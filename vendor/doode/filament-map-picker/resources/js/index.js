import * as L from "leaflet";
import "leaflet/dist/leaflet.css";
import 'leaflet-fullscreen';
import "@geoman-io/leaflet-geoman-free";
import "@geoman-io/leaflet-geoman-free/dist/leaflet-geoman.css";

document.addEventListener('DOMContentLoaded', () => {
    const mapPicker = ($wire, config, state) => {
        return {
            map: null,
            tile: null,

            createMap: function (el) {
                const that = this;

                this.map = L.map(el, config.controls);
                
                this.map.on('load', () => {
                    setTimeout(() => that.map.invalidateSize(true), 0);
                });

                if (!config.draggable) { this.map.dragging.disable(); }

                function setTileBasedOnTheme()
                {
                    tileUrl='';
                    if (localStorage.getItem('theme') == 'light')
                    {
                        tileUrl = config.tilesUrl;
                    }
                    else if (localStorage.getItem('theme') == 'dark')
                    {
                        tileUrl = config.tilesUrlDark;
                    }
    
                    that.tile = L.tileLayer(tileUrl, {
                        attribution: config.attribution,
                        minZoom: config.minZoom,
                        maxZoom: config.maxZoom,
                        tileSize: config.tileSize,
                        zoomOffset: config.zoomOffset,
                        detectRetina: config.detectRetina,
                    }).addTo(that.map);
                }

                setTileBasedOnTheme();
                

                window.addEventListener('theme-changed', (event) => {
                    that.tile.remove();

                    setTileBasedOnTheme();

                })
                
                // this.wmslayer = L.tileLayer.wms('http://c2n.adalfantln.marine.defensecdd.gouv.fr:8081/geoserver/wms?', {
                //     layers: 'fond_de_carte'
                // }).addTo(this.map)

                // Geoman Toolbar Controls
                this.map.pm.addControls({
                    position: 'topright',
                    drawPolygon: true,
                    drawRectangle: true,
                    editMode: true,
                    drawMarker: true,
                    drawCircle: true,
                    drawText: false,
                    drawPolyline: true,
                    deleteMode: false,
                    drawCircleMarker: false,
                    rotateMode: true,
                });

                let drawItems = new L.FeatureGroup().addTo(this.map);

                // Define custom control class
                var ColorPickerControl = L.Control.extend({
                    onAdd: function(map) {
                        // Create container element for color picker
                        var container = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                        
                        // Create color picker input element
                        var colorPicker = document.createElement('input');
                        colorPicker.type = 'color';
                        colorPicker.id = 'color-picker'; // Set an ID for styling or event handling
                        colorPicker.title = 'Choisir une couleur';
                        
                        // Append color picker to container
                        container.appendChild(colorPicker);

                        return container;
                    },

                    onRemove: function(map) {
                        // Nothing to do here
                    }
                });
                var colorPickerControl = new ColorPickerControl({ position: 'topleft' }); // Adjust position as needed
                colorPickerControl.addTo(this.map);

                let location = state ?? this.getCoordinates();
                if (!location.lat && !location.lng) {
                    this.map.locate({
                        setView: true,
                        maxZoom: config.controls.maxZoom,
                        enableHighAccuracy: true,
                        watch: false
                    });
                } else {
                    this.map.setView(new L.LatLng(location.lat, location.lng));
                }

                // To Drawing shapes in the map
                this.map.on('pm:create', function(e) {
                    if (e.layer && e.layer.pm){
                        var layer = e.layer;
                        const shape = e;
                        var newColor = document.getElementById('color-picker').value;

                        shape.layer.pm.enable();
                        drawItems.addLayer(shape.layer);
                        
                        if (layer instanceof L.Polygon || layer instanceof L.Circle) {
                            // Set the selected polygon
                            selectedPolygon = layer;
                            selectedPolygon.setStyle({ fillColor: newColor });
                            selectedPolygon.setStyle({ color: newColor });
                     
                        }
                        
                        shape.layer.on('pm:edit', (e) => {
                            $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                            $wire.$refresh();
                        })

                        shape.layer.on('click', function() {
                            var newColor = document.getElementById('color-picker').value;
                    
                            // Check if the clicked layer is a polygon
                            if (layer instanceof L.Polygon || layer instanceof L.Circle) {
                                // Set the selected polygon
                                selectedPolygon = layer;
                                selectedPolygon.setStyle({ fillColor: newColor });
                                selectedPolygon.setStyle({ color: newColor });
                            }

                            $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                            $wire.$refresh();
                        });

                        shape.layer.feature = e.layer.toGeoJSON();
                        shape.layer.feature.properties = {
                            id : crypto.randomUUID(),
                            fillColor : newColor,
                            color: newColor,
                        };

                        $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                        $wire.$refresh();
                    } else {
                        console.log('Not a shape');
                    }
                });

                drawItems.on('pm:edit', (e) => {
                    $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                    $wire.$refresh();
                });

                this.map.on('pm:rotateend', (e) => {
                    $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                    $wire.$refresh();
                })

                this.map.on('pm:remove', (e) => {
                   drawItems.removeLayer(e.layer);
                   $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                   $wire.$refresh();
                });

                $wire.getGeoJson().then(function(result) {
                    geomData = JSON.parse(result);
                    //console.log(geomData);
    
                    drawItems = new L.geoJSON(geomData, {
                        style: function (feature) { 
                            return {
                                color: feature.properties.color || "#FFFFFF",
                                fillColor:  feature.properties.fillColor || 'blue',
                                fillOpacity: 0.5,
                            }
                        },
                        onEachFeature: function(feature, layer) {
                            layer.on('click', function() {

                                var newColor = document.getElementById('color-picker').value;

                                layer.feature.properties = {
                                    fillColor : newColor,
                                    color : newColor
                                };
                                                        
                                // Check if the clicked layer is a polygon
                                if (layer instanceof L.Polygon || layer instanceof L.Circle) {
                                    // Set the selected polygon
                                    selectedPolygon = layer;
                                    selectedPolygon.setStyle({ fillColor: newColor });
                                    selectedPolygon.setStyle({ color: newColor });
                                }

                                $wire.setGeoJson(JSON.stringify(drawItems.toGeoJSON()));
                                $wire.$refresh();
                            }); 
                        },
                    });
                    that.map.addLayer(drawItems);
                    that.map.fitBounds(drawItems.getBounds());
                    that.map.setZoom(4);
                });

            },

            removeMap: function (el) {
                //this.tile.remove();
                //this.tile = null;
                this.map.off();
                this.map.remove();
                this.map = null;
            },

            getCoordinates: function () {
                let location = $wire.get(config.statePath) ?? {};

                const hasValidCoordinates = location.hasOwnProperty('lat') && location.hasOwnProperty('lng') &&
                    location.lat !== null && location.lng !== null;

                if (!hasValidCoordinates) {
                    location = {
                        lat: config.default.lat,
                        lng: config.default.lng
                    };
                }

                return location;
            },

            attach: function (el) {
                this.createMap(el);
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.intersectionRatio > 0) {
                            if (!this.map)
                                this.createMap(el);
                        } else {
                            this.removeMap(el);
                        }
                    });
                }, {
                    root: null,
                    rootMargin: '0px',
                    threshold: 1.0
                });
                observer.observe(el);
            },

            init: function() {
                this.$wire = $wire;
                this.config = config;
                this.state = state;
                this.refreshMap.bind(this);
                //$wire.on('refreshMap', this.refreshMap.bind(this));
            },

            refreshMap: function() {
                this.map.flyTo(this.getCoordinates());
            }
        };
    };

    window.mapPicker = mapPicker;
    window.dispatchEvent(new CustomEvent('map-script-loaded'));
});
