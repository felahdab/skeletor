<?php

namespace Doode\MapPicker\Traits;

use Illuminate\Support\Arr;


trait HasMap {
    public $geoJson;

    public function mount(int | string $record): void
    {
        parent::mount($record);
        $this->geoJson = Arr::get($this->record->data, "mapdata", []);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Arr::forget($data, 'geomanbox');
        Arr::forget($data, 'unusedmapdata');
        Arr::set($data, "data.mapdata", $this->geoJson);
        
        return $data;
    }

    public function getGeoJson()
    {
        return json_encode($this->geoJson);
    }

    public function setGeoJson($geojson)
    {
        $this->geoJson = json_decode($geojson, true);
    }

}