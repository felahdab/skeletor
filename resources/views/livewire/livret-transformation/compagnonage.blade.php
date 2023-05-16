<div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComp_{{$compagnonage->id}}">
            <h5>
            @if ($mode== "unique")
                @if ($user->getTransformationManager()->sous_objectifs_du_parcours_proposes($fonction, $compagnonage)->count() > 0)
                &#128232;
                @endif
            @endif
                {{$compagnonage->comp_libcourt}}
            </h5>
            </button>
        </div>
        <div id="collapseComp_{{$compagnonage->id}}" class="accordion-collapse collapse">
            <div class="accordion-body">
            <table class='table table-bordered' x-data='{ active : false }'>
                <tr class='table-active text-center'>
                    <th style='width:20%;'>Tâche</td>
                    <th style='width:25%;'>Objectif</td>
                    <th style='width:25%;'>Détail du compagnonnage</td>
                    <th style='width:5%;'>Durée (h)</td>
                    <th style='width:10%;'>Date de Visa</td>
                    <th style='width:10%;'>Viseur</td>
                    <th style='width:5%;'>Lieu de formation</td>
                </tr>
                @foreach($compagnonage->taches as $tache)
                <tr class='ligneTache'>
                    @if ($mode=='unique')
                        <td rowspan='{{ $user->getTransformationManager()->sous_objectifs_du_parcours(null, null, $tache, null)->count() }}'>
                    @else
                        <td rowspan='{{ $tache->coll_sous_objectifs()->count() }}'>
                    @endif
                            @if ($readwrite || ! $user->getTransformationManager()->aValideLaTache($tache) )
                            <input type='checkbox' 
                                x-data='{ active: false }'
                                x-model="selected_taches"
                                value="{{$tache->id}}">
                            @endif
                        {{$tache->tache_liblong }} 
                        @if ($mode=='unique' && $user->getTransformationManager()->aValideLaTache($tache))
                            <button class='btn btn-success' type='button' disabled>VALIDEE</button>
                        @endif
                    </td>
                    @foreach($tache->objectifs as $objectif)
                    <td rowspan='{{$objectif->sous_objectifs->count()}}'> 
                            @if ($readwrite || ! $user->getTransformationManager()->aValideLObjectif($objectif) )
                            <input type='checkbox' 
                                x-data='{ active: false }'
                                x-model="selected_objectifs"
                                value="{{$objectif->id}}">
                            @endif
                        {{$objectif->objectif_liblong }}
                        @if ($mode=='unique' && $user->getTransformationManager()->aValideLObjectif($objectif))
                            <button class='btn btn-success' type='button' disabled>
                            VALIDE
                            </button>
                        @endif
                        </td>
                        @foreach($objectif->sous_objectifs as $sous_objectif)
                            <td>{{$sous_objectif->ssobj_lib}}</td>
                            <td>{{$sous_objectif->ssobj_duree}}</td>
                            <td title=''>
                                @if ($readwrite || ! $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif) )
                                    <input type='checkbox' 
                                    x-data='{ active: false }'
                                    x-model="selected_sous_objectifs"
                                    value="{{$sous_objectif->id}}">
                                @endif
                                @if ($mode=='unique' && $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif))
                                    <button class='btn btn-success' type='button' disabled>
                                    VALIDE {{ $user->getTransformationManager()->dateDeValidationDuSousObjectif($sous_objectif) }}
                                    </button>
                                @endif
                                @if ($mode=='unique' && $user->getTransformationManager()->aProposeLeSousObjectif($sous_objectif))
                                    <button class='btn btn-primary' type='button' disabled>
                                    PROPOSE {{ $user->getTransformationManager()->dateDePropositionDeValidationDuSousObjectif($sous_objectif) }}
                                    </button>
                                @endif
                            </td>
                            @if ($mode=='unique' && ( $user->getTransformationManager()->aValideLeSousObjectif($sous_objectif) || $user->getTransformationManager()->aProposeLeSousObjectif($sous_objectif) ) )
                                <td title="{{$user->getTransformationManager()->commentaireDeValidationDuSousObjectif($sous_objectif)  }}">
                                        {{ $user->getTransformationManager()->valideurDeValidationDuSousObjectif($sous_objectif) }}
                                </td>
                            @else
                                <td>&nbsp;</td>
                            @endif
                            <td>{{$sous_objectif->lieu->lieu_libcourt}}</td>
                           </tr>
                        @endforeach <!-- foreach sous objectif -->
                    @endforeach <!-- foreach objectif -->
                @endforeach <!-- foreach tache -->
            </table>
            </div>
        </div>
    </div>
</div>

