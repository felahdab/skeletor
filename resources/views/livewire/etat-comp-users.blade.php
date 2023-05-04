<div>
    <div class="lead mb-5">Compagnonnage : <b>{{ $comp -> comp_liblong}}</b></div>
    <!-- div avec formulaire de validation -->
    @include('livewire.livret-transformation.divvalid', ['mode' => "parcomp"])
    <button type="submit" 
    form="ssobjs"
    class="btn btn-primary" 
    name="validation"
    x-on:click.prevent="active = true ;
                        opendivvalid = true ;
                        buttonid = 'validation' ;">Valider les éléments cochés
                        </button>
    <button x-show="false" 
            x-on:uservalidated.window="if (active)
            { 
                active = false; 
$wire.ValideElementsDuParcoursParcomp( date_validation , commentaire, valideur, selected_parcomp );
            }"></button>
    <!-- 1ere présentation -->
    <!-- ----------------- -->
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead style="position: sticky;top: 0; z-index: 2;">
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

    <!-- 2eme présentation -->
    <!-- ----------------- -->
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead style="position: sticky;top: 0; z-index: 2;">
            <tr class="table-info" style="background:white;">
                <td colspan="3" style="width: 40%">&nbsp;</td>
            @foreach ($entete_users as $key => $user)
                <td style ="writing-mode: sideways-lr;" style="width: 75px;">{{$user['name']}}</td>
            @endforeach
            </tr>
            <tr style="background:white;">
            <td colspan="3">&nbsp;</td>
            @foreach ($entete_users as $key => $user)
                <td>{{$user['txtransfo']}}</td>
            @endforeach
            </tr>
        </thead>
        <tbody>
        @foreach($ssobjsusers as $ligne)
            <tr>
                @foreach($ligne as $key => $cell)
                        @if($cell=='true')
                            <td class="text-center">&#10004;
                        @elseif ($cell=='false')
                            <td class="text-center">&#10060;
                            <input type="checkbox" id="['ssobjid' => {{$ligne['ssobj']->id}}, 'userid' => {{$key}}]" >
                        @else
                            @if ($key == "ssobj")
                                <td style="font-size:x-small;" title="{{$cell->ssobj_lib}}">{{substr($cell->ssobj_lib, 0, 40)}}
                            @else
                                <td style="font-size:x-small;" title="{{$cell}}">{{substr($cell, 0, 40)}}
                            @endif
                        @endif  
                        </td>                      
                @endforeach
            </tr>   
            @endforeach
        </tbody>
    </table>


</div>
