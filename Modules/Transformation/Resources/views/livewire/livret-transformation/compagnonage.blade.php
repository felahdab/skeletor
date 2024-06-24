<div class="accordion">
    <div class="accordion-item">
        <div class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComp_{{$compagnonage->id}}">
            <h5>
            @if ($mode== "proposition" || $mode== "modification")
                @if ($user->getTransformationManager()->sous_objectifs_du_parcours_proposes($fonction, $compagnonage)->count() > 0)
                    <span class="text-info"><x-bootstrap-icon iconname='envelope-open.svg' /></span>
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
                    <th style='width:20%;'>Compétence</td>
                    <th style='width:25%;'>Savoir-faire</td>
                    <th style='width:25%;'>Activité</td>
                    <th style='width:5%;'>Durée (h)</td>
                    <th style='width:10%;'>Date de Visa</td>
                    <th style='width:10%;'>Viseur</td>
                    <th style='width:5%;'>Lieu de formation</td>
                </tr>
                @foreach($compagnonage->taches->sortBy('pivot.ordre') as $tache)
                <tr class='ligneTache'>
                    @if ($mode!='modificationmultiple')
                        <td rowspan='{{ $user->getTransformationManager()->sous_objectifs_du_parcours(null, null, $tache, null)->count() }}'>
                    @else
                        <td rowspan='{{ $tache->coll_sous_objectifs()->count() }}'>
                    @endif
                            @if ($mode == "validelacherdouble" || $mode == "consultation" || ($mode== 'proposition' && $user->getTransformationManager()->aValideLaTache($tache) )  )
                            @else
                                <input type='checkbox' 
                                    x-data='{ active: false }'
                                    x-model="selected_taches"
                                    value="{{$tache->id}}">
                            @endif
                            {{$tache->tache_liblong }} 
                            @if ($mode!='modificationmultiple' && $user->getTransformationManager()->aValideLaTache($tache))
                                <button class='btn btn-success' type='button' disabled>VALIDEE</button>
                            @endif
                        </td>
                    @foreach($tache->objectifs->sortBy("pivot.ordre") as $objectif)
                        <td rowspan='{{$objectif->sous_objectifs->count()}}'> 
                            @if ($mode == "validelacherdouble" || $mode == "consultation" || ($mode== 'proposition' && $user->getTransformationManager()->aValideLObjectif($objectif) )  )
                            @else
                            <input type='checkbox' 
                                x-data='{ active: false }'
                                x-model="selected_objectifs"
                                value="{{$objectif->id}}">
                            @endif
                        {{$objectif->objectif_liblong }}
                        @if ($mode!='modificationmultiple' && $user->getTransformationManager()->aValideLObjectif($objectif))
                            <button class='btn btn-success' type='button' disabled>
                            VALIDE
                            </button>
                        @endif
                        </td>
                        @foreach($objectif->sous_objectifs->sortBy("ordre") as $sous_objectif)
                            @include('transformation::livewire.livret-transformation.sous-objectif')
                        @endforeach <!-- foreach sous objectif -->
                    @endforeach <!-- foreach objectif -->
                @endforeach <!-- foreach tache -->
            </table>
            </div>
        </div>
    </div>
</div>

