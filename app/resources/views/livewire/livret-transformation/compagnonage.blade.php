<div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComp_{{$compagnonage->id}}">
            <h5>{{$compagnonage->comp_libcourt}}</h5>
            </button>
        </div>
        <div id="collapseComp_{{$compagnonage->id}}" class="accordion-collapse collapse">
            <div class="accordion-body">
            <table class='table' x-data='{ active : false }'>
                <tr class='table-active text-center'>
                    <th style='width:20%;'>Tâche</td>
                    <th style='width:25%;'>Objectif</td>
                    <th style='width:25%;'>Détail du compagnonnage</td>
                    <th style='width:5%;'>Durée (h)</td>
                    <th style='width:10%;'>Date de Visa</td>
                    <th style='width:10%;'>Viseur</td>
                    <th style='width:5%;'>Lieu de formation</td>
                </tr>
                @foreach($compagnonage->taches()->get() as $tache)
                <tr class='ligneTache'>
                    <td rowspan='{{$tache->nb_ssobj()}}'>
                    @if($readwrite)
                        <input type='checkbox' 
                            x-data='{ active: false }'
                            x-model="selected_taches"
                            value="{{$tache->id}}">@endif 
                        {{$tache->tache_liblong }} 
                        @if ($mode=='unique' && $user->aValideLaTache($tache))
                            <button class='btn btn-success' type='button' disabled>VALIDEE</button>
                        @endif
                    </td>
                    @foreach($tache->objectifs()->get() as $objectif)
                    <td rowspan='{{$objectif->sous_objectifs()->get()->count()}}'> 
                        <input type='checkbox' 
                            x-data='{ active: false }'
                            x-model="selected_objectifs"
                            value="{{$objectif->id}}">
                        {{$objectif->objectif_liblong }}
                        @if ($mode=='unique' && $user->aValideLObjectif($objectif))
                            <button class='btn btn-success' type='button' disabled>
                            VALIDE
                            </button>
                        @endif
                        </td>
                        @foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                            <td>{{$sous_objectif->ssobj_lib}}</td>
                            <td>{{$sous_objectif->ssobj_duree}}</td>
                            <td title=''>
                                @if($readwrite)
                                    <input type='checkbox' 
                                    x-data='{ active: false }'
                                    x-model="selected_sous_objectifs"
                                    value="{{$sous_objectif->id}}">@endif
                                @if ($mode=='unique' && $user->aValideLeSousObjectif($sous_objectif))
                                    <button class='btn btn-success' type='button' disabled>
                                    VALIDE {{ $user->sous_objectifs()->find($sous_objectif)->pivot->date_validation }}
                                    </button>
                                @endif
                            </td>
                            @if ($mode=='unique' && $user->aValideLeSousObjectif($sous_objectif))
                                <td title="{{ $user->sous_objectifs()->find($sous_objectif)->pivot->commentaire }}">
                                        {{ $user->sous_objectifs()->find($sous_objectif)->pivot->valideur }}
                                </td>
                            @else
                                <td>&nbsp;</td>
                            @endif
                            <td>{{$sous_objectif->lieu()->get()->first()->lieu_libcourt}}</td>
                           </tr>
                        @endforeach <!-- foreach sous objectif -->
                    @endforeach <!-- foreach objectif -->
                @endforeach <!-- foreach tache -->
            </table>
            </div>
        </div>
    </div>
</div>

