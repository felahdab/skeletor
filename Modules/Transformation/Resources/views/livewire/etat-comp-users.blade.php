<div>
    <div class="lead mt-1 mb-3">Compagnonnage : <b>{{ $comp -> comp_liblong}}</b></div>
    <!-- div avec formulaire de validation -->
    @include('transformation::livewire.livret-transformation.divvalid', ['mode' => "parcomp"])
    <div style="width: min-content;">
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
                }">Valider les éléments cochés
            </button>
        </div>
        <div>Cliquez sur un sous objectif pour mettre la colonne en surbrillance</div>
        <table class="table table-bordered table-striped table-hover table-sm" id="matable">
            <thead class="sticky-top" style="top:7.5rem;">
            <tr class="table-primary" >
                <td colspan="2">&nbsp</td>
                @foreach($entete_taches as $entete_tache)
                    <td style="font-size:x-small;" colspan="{{$entete_tache['colspantach']}}" title="{{$entete_tache['libtach']}}">{{substr($entete_tache['libtach'], 0, 40)}}...</td>
                @endforeach
            </tr>   
            <tr class="table-success">
                <td colspan="2">&nbsp</td>            
                @foreach($entete_objectifs as $entete_objectif)
                    <td style="font-size:x-small;" colspan="{{$entete_objectif['colspanobj']}}" title="{{$entete_objectif['libobj']}}">{{substr($entete_objectif['libobj'], 0, 40)}}...</td>
                @endforeach
            </tr>   
            </thead>
            <tbody>
                <tr class="table-info">
                    <th>Marin</th>
                    <th>Taux</th>
                    @foreach($entete_ssobjectifs as $entete_ssobjectif)
                        <th style="font-size:x-small;" 
                            title="{{$entete_ssobjectif['ssobj']->ssobj_lib}}" >
                            {{substr($entete_ssobjectif['ssobj']->ssobj_lib, 0, 40)}}...
                </th>
                    @endforeach
                </tr>   
                    @foreach($usersssobjs as $ligne)
                <tr>
                    <td class="text-center" style="position: sticky; left: 0;z-index: 1;background: white;"><a href="{{ route('transformation::transformation.livret', $ligne['id'] )}}">{{$ligne['name']}}</a>
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
