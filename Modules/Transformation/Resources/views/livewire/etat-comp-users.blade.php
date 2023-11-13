<div>
    <div class="lead mt-1 mb-3">Compagnonnage : <b>{{ $comp -> comp_liblong}}</b></div>
    <!-- div avec formulaire de validation -->
    @include('transformation::livewire.livret-transformation.divvalid', ['mode' => "parcomp"])
    
    <div style="width: min-content;" x-data="{
        selectedMarins: [],
        filter(){
            $wire.showMarinFiltrer(this.selectedMarins);
        },
        reinitialiser(){
            $wire.reinitialiser();
        },
        creerUnFiltre(){
            $wire.creerUnFiltre(this.selectedMarins);
        },
        appliquerFiltre(idFiltre){
            $wire.appliquerFiltre(idFiltre);
        }
    }">
        <div class="sticky-top" style="top:5rem;  background: white; width:100%; ">
            <button type="submit" 
            form="ssobjsusers"
            class="btn btn-primary sticky-top" 
            style="left:0;"
            name="validation"
            x-on:click.prevent="active = true ;
                                validModal = new bootstrap.Modal(document.getElementById('divvalid'), []);
                                validModal.show();
                                buttonid = 'validation' ;"
            x-on:uservalidated.window="if (active)
                { 
                    active = false; 
                    $wire.ValideElementsDuParcoursParcomp( date_validation, commentaire, valideur, selected_parcomp );
                }"
                >Valider les éléments cochés
            </button>
        </div>
        <div>Cliquez sur un sous objectif pour mettre la colonne en surbrillance</div>
        <table class="table table-bordered table-striped table-hover table-sm" id="matable">
            <thead class="sticky-top" style="top:7.5rem;">
            <tr class="table-primary" >
                <td colspan="3" style="position: sticky; left: 0px;z-index: 1;">
                    <nav class="navbar bg-body-tertiary sticky-top">
                        <div class="sticky-top" style="left:0px">
                            <form style="left:0px;" role="search">
                                <input type="search" class="form-control me-2" placeholder="Recherche" aria-label="Recherche" id="searchInput">
                            </form>
                        </div>
                    </nav> 
                </td>
                @foreach($entete_taches as $entete_tache)
                    <td style="font-size:x-small;" colspan="{{$entete_tache['colspantach']}}" title="{{$entete_tache['libtach']}}">{{substr($entete_tache['libtach'], 0, 40)}}...</td>
                @endforeach
            </tr>   
            <tr class="table-success">
                <td colspan="3">
                    <button  class="btn btn-primary sticky-top" title="enregistrer le filtre"  x-on:click="creerUnFiltre">
                        <img src="{!! asset("assets/images/floppy.svg") !!}" alt="">
                    </button>
                    <div class="dropdown" class="sticky-top">
                        <button class="btn btn-primary dropdown-toggle" type="buttun" data-bs-toggle="dropdown" aria-expanded="false">
                            Filtre(s) enregistré(s)
                        </button>
                        <ul class="dropdown-menu">
                            @forEach($filtres as $filtre)
                                <li><button class="btn btn-primary" x-on:click="appliquerFiltre({{$filtre->id}})">{{$filtre->nomDuFiltre}}</button></li>
                            @endforeach
                        </ul>
                    </div>    
                </td>            
                @foreach($entete_objectifs as $entete_objectif)
                    <td style="font-size:x-small;" colspan="{{$entete_objectif['colspanobj']}}" title="{{$entete_objectif['libobj']}}">{{substr($entete_objectif['libobj'], 0, 40)}}...</td>
                @endforeach
            </tr>   
            <tr class="table-info">
                <th style="position: sticky; left: 0px;z-index: 1;">
                <button
                    class="btn btn-primary sticky-top"
                    style="left:220px;"
                    x-on:click="filter"
                    title="filtre"
                    >
                    <img src="{!! asset("assets/images/funnel.svg") !!}" alt="">
                </button>
                <button
                class="btn btn-primary sticky-top"
                    style="left:220px;"
                    x-on:click="reinitialiser"
                    title="réinitialiser le filtre des marins">
                    <img src="{!! asset("assets/images/x.svg") !!}" alt="">
                </button>
                </th>
                <th>Marin</th>
                <th>Taux</th>
                @foreach($entete_ssobjectifs as $entete_ssobjectif)
                    <th style="font-size:x-small;" 
                        title="{{$entete_ssobjectif['ssobj']->ssobj_lib}}" >
                        {{substr($entete_ssobjectif['ssobj']->ssobj_lib, 0, 40)}}...
                    </th>
                @endforeach
            </tr>   
            </thead>
            <tbody>
                    @foreach($usersssobjs as $ligne)
                    <tr>
                        <td style="position: sticky; left: 0;z-index: 1;background: white;">
                            <input type="checkbox" class="form-check-input" x-model="selectedMarins" :value="{{$ligne['id']}}">
                        </td>
                        <td class="text-center" style="position: sticky; left: 50px;z-index: 1;background: white;">
                            <a href="{{ route('transformation::transformation.livret', $ligne['id'] )}}">
                                {{$ligne['name']}}
                            </a>
                            <br>
                        </td>
                        <td>{{$ligne['txtransfo']}}</td>
    
                        @foreach($ligne as $key => $cell)
                            @if ($cell == 'true')
                                <td class="text-center text-success"><x-bootstrap-icon iconname='check-circle.svg'/></td>
                            @endif
                            @if ($cell == 'false')
                                <td class="text-center text-danger"><x-bootstrap-icon iconname='x-circle.svg'/>
                                <input type="checkbox" 
                                        x-data='{ active: false }'
                                        x-model="selected_parcomp"
                                        value="'ssobjid'-{{$key}}-'userid'-{{$ligne['id']}}">
                                </td>                                   
                            @endif
                            @if ($cell == 'propose')
                                <td class="text-center text-info"><x-bootstrap-icon iconname='envelope-open.svg' />
                                <input type="checkbox" 
                                        x-data='{ active: false }'
                                        x-model="selected_parcomp"
                                        value="'ssobjid'-{{$key}}-'userid'-{{$ligne['id']}}">
                                </td>                                   
                            @endif
                        @endforeach
                    </tr>   
                    @endforeach
            </tbody>
        </table>
    </div>
</div>


<style>
    .highlight{
        background-color: #feffa7;
    }
</style>

<script>
    var input = document.getElementById("searchInput");
    input.addEventListener("input", function() {
        var table = document.getElementById("matable");
        var rows = table.querySelectorAll("tbody tr");
        var searchText = input.value.toLowerCase();
        for (var i = 0; i < rows.length; i++) {
            var marinCell = rows[i].querySelector("td:nth-child(2)");
            if (marinCell.textContent.toLowerCase().includes(searchText)) {
                rows[i].classList.add("highlight");
                rows[i].scrollIntoView({ behavior: "smooth", block: "center" });
            } else {
                rows[i].classList.remove("highlight");
            }
        }
        if (searchText === "") {
            for (var i = 0; i < rows.length; i++) {
                rows[i].classList.remove("highlight");
            }
        }
    });
</script>

<script>
      // Get the table element
      var table = document.getElementById("matable");

      // Get all the th elements in the table
      var ths = table.querySelectorAll("th");

      // Loop over the th elements
      ths.forEach(function (th, columnIndex) {
        // Add a click event listener to each th
        th.addEventListener("click", function () {
          // Get all the tr elements in the table body
          var trs = table.querySelectorAll("tbody tr");

          // Remove the 'bg-info' class from all td elements
          table.querySelectorAll("td").forEach(function (td) {
            td.classList.remove("bg-secondary");
          });

          // Loop over the tr elements
          trs.forEach(function (tr) {
            // Get the td element at the clicked column index
            var td = tr.children[columnIndex];

            // Add the 'highlight' class to the td element
            td.classList.add("bg-secondary");
          });
        });
      });
</script>
