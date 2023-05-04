<div>
    <div class="lead mt-1 mb-3">Compagnonnage : <b>{{ $comp -> comp_liblong}}</b></div>
    <!-- div avec formulaire de validation -->
    @include('livewire.livret-transformation.divvalid', ['mode' => "parcomp"])
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
        <table class="table table-bordered table-striped table-hover table-sm">
            <thead class="sticky-top" style="top:7.5rem;">
            <tr class="table-primary">
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
            <tr class="table-info">
                <th>Marin</th>
                <th>Tx transfo (%)</th>
                @foreach($entete_ssobjectifs as $entete_ssobjectif)
                    <td style="font-size:x-small;" title="{{$entete_ssobjectif['ssobj']->ssobj_lib}}">{{substr($entete_ssobjectif['ssobj']->ssobj_lib, 0, 40)}}...</td>
                @endforeach
            </tr>   
            </thead>
            <tbody>
                @foreach($usersssobjs as $ligne)
                <tr>
                    @foreach($ligne as $key => $cell)
                        @if ($key != 'id')
                            @if($cell=='true')
                                <td class="text-center">&#10004;
                            @elseif ($cell=='false')
                                <td class="text-center">&#10060;
                                <input type="checkbox" 
                                        x-data='{ active: false }'
                                        x-model="selected_parcomp"
                                        value="'ssobjid'-{{$key}}-'userid'-{{$ligne['id']}}">                                   
                            @elseif (is_numeric($cell))
                                <td class="text-center">{{$cell}}
                            @else
                                <td class="text-center" style="position: sticky; left: 0;z-index: 1;background: white;">{{$cell}}
                            @endif
                            </td>
                    @endif
                    @endforeach
                </tr>   
                @endforeach
            </tbody>
        </table>
    </div>
</div>
