<div>
    <div wire:loading class="w-100">
        <div class="text-center">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </div>
    </div>
    <div wire:loading.remove x-data="{ opendivvalid : false ,
                    commentaire : '' ,
                    valideur : '{{auth()->user()->display_name}}',
                    button : null,
                    buttonid : '',
                    date_validation : '{{ date('Y-m-d')}}',
                    selected_compagnonnages : {},
                    selected_taches : {},
                    selected_objectifs : {},
                    selected_sous_objectifs : {}
                       }">
    
        @if($readwrite)
            <!-- div avec boutons generaux -->
            <div class='text-center mt-1 sticky-top' style="top:3.5rem" x-data='{ active : false }'>
                <button type="submit" 
                form="ssobjs"
                class="btn btn-primary" 
                name="validation"
                x-on:click.prevent="active = true ;
                                    opendivvalid = true ;
                                    buttonid = 'validation' ;">Valider les éléments cochés</button>
                <button x-show="false" 
                        x-on:uservalidated.window="if (active)
                        { 
                            active = false;  
$wire.ValideElementsDuParcours( {{$user->id}} , date_validation , commentaire, valideur, selected_compagnonnages , selected_taches , selected_objectifs ,selected_sous_objectifs );
                        }"></button>
                <button class="btn btn-danger" 
                name="annulation_validation"
                x-on:click="
$wire.UnValideElementsDuParcours( {{$user->id}} , selected_compagnonnages , selected_taches , selected_objectifs ,selected_sous_objectifs );">Annuler la validation des éléments cochés</button>
                <a href="{{ route('transformation.livretpdf', $user->id) }}" class="btn btn-info">Imprimer</a>
            </div><!-- fin de la div avec boutons speciaux -->

            <!-- div avec formulaire de validation -->
            <div x-cloak x-show="opendivvalid" id='divvalid' class='popupvalidcontrat'>
                <div class='titrenavbarvert'>
                    <h5>Validation</h5>
                </div>
                <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
                <div class='form-group row pl-3 mt-2' >
                    <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                    <div class='col-sm-5'>
                    <input type='date' class='form-control'name='date_validation' id='date_validation' required x-model="date_validation">
                    </div>
                </div>
                <div class='form-group row  pl-3' >
                    <label for='valideur' class='col-sm-5 col-form-label '>Valideur</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='valideur' id='valideur' placeholder=' Valideur' x-model="valideur">
                    </div>
                </div>
                <div class='form-group row  pl-3' >
                    <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
                    <div class='col-sm-5'>
                        <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                    </div>
                </div>
                <div class='text-center'>
                    <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                    id='btnvalidobj' 
                    name='btnvalidobj'
                    x-on:click="opendivvalid = false;
                                $dispatch('uservalidated');">Valider</button>
                    <button class='btn btn-primary w-25 mt-4 mb-2' x-on:click='opendivvalid=false;'>Annuler</button>
                </div>
            </div> <!-- fin de la divvalid -->
        @endif
        
        <div id='livret' class='div-table-contrat-compagnonnage table'>
            
            @foreach ($user->fonctions()->orderBy('typefonction_id')->get() as $fonction)
             <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFonction_{{$fonction->id}}">
                            <h3>Fonction {{$fonction->fonction_liblong }} </h3>
                        </button>
                    </div>
                    <div id="collapseFonction_{{$fonction->id}}" class="accordion-collapse collapse">
                        <div  class="accordion-body">
                            <table class='table'>
                                <tr class='lignecomp div-table-contrat-compagnonnage'>
                                    <th colspan='5'>{{$fonction->fonction_liblong }}</th>
                                </tr>
                                <tr class='lignecomp'>
                                        <td style='width:5%;'>&nbsp;</td>
                                        <td style='width:70%;'>Commentaire</td>
                                        <td style='width:10%;'>Date de Visa</td>
                                        <td style='width:10%;'>Viseur</td>
                                        <td style='width:5%;'>Lieu de formation</td>
                                </tr>
                                @if ($fonction->fonction_double)
                                <tr  class='lignecomp' x-data='{ active : false }'>
                                    <td>DOUBLE</td>
                                    <td class="text-start">
                                    @if ($fonction->pivot->date_double != null)
                                        {{ $fonction->pivot->commentaire_double }}
                                    @endif
                                    </td>
                                    <td>
                                    @if ($fonction->pivot->date_double != null)
                                        <button class='btn btn-success' type='button' disabled>
                                            VALIDE {{ $fonction->pivot->date_double }}
                                        </button>
                                    @endif
                                    </td>
                                    <td>
                                    @if ($fonction->pivot->valideur_double != null and $readwrite)
                                        {{ $fonction->pivot->valideur_double }}
                                        <button class="btn btn-danger" 
                                        x-on:click.prevent="$wire.UnValideDoubleFonction( {{ $user->id }}, {{ $fonction->id }} );">
                                        Annuler</button>
                                    @elseif ($readwrite)
                                    <button type="submit" 
                                        class="btn btn-primary" 
                                        name="validation_double"
                                        x-on:click.prevent="active  = true; 
                                                           buttonid ='validation_double'; 
                                                       opendivvalid =true;">Valider</button>
                                    <button x-show="false" 
                                            x-on:uservalidated.window="if (active)
                                            {   
                                                active = false;  
                                                $wire.ValideDoubleFonction( {{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                                             };"></button>
                                    @endif
                                    </td>
                                    <td>Bord</td>
                                </tr>
                                @endif
                                @if ($fonction->fonction_lache)
                                <tr  class='lignecomp' x-data='{ active : false }'>
                                    <td>LACHER</td>
                                    <td class="text-start">
                                    @if ($fonction->pivot->date_double != null)
                                        {{ $fonction->pivot->commentaire_lache }}
                                    @endif
                                    </td>
                                    <td>
                                    @if ($fonction->pivot->date_lache != null)
                                        <button class='btn btn-success' type='button' disabled>
                                            VALIDE {{ $fonction->pivot->date_lache }}
                                        </button>
                                    @endif
                                    </td>
                                    <td>
                                    @if ($fonction->pivot->valideur_lache != null and $readwrite)
                                        {{ $fonction->pivot->valideur_lache }}
                                        <button class="btn btn-danger" 
                                        x-on:click.prevent="$wire.UnValideLacheFonction( {{ $user->id }}, {{ $fonction->id }} );">
                                        Annuler</button>
                                    @elseif($readwrite)
                                    <button type="submit" 
                                        class="btn btn-primary" 
                                        name="validation_lache"
                                        x-on:click.prevent="active  = true; 
                                                           buttonid ='validation_lache'; 
                                                       opendivvalid =true;">Valider</button>
                                        <button x-show="false"  
                                                x-on:uservalidated.window="if (active)
                                                { 
                                                    active = false;  
                                                    $wire.ValideLacheFonction({{$user->id}}, {{$fonction->id}}, date_validation , commentaire, valideur);
                                                }"></button>
                                    @endif
                                    </td>
                                    <td>Bord</td>
                                </tr>
                                @endif
                            </table>
                            
                            @if ($fonction->compagnonages()->get()->count() > 0)
                                @foreach($fonction->compagnonages()->get() as $compagnonage)
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
                                                    <tr class='lignecomp'>
                                                        <td style='width:20%;'>Tâche</td>
                                                        <td style='width:25%;'>Objectif</td>
                                                        <td style='width:25%;'>Détail du compagnonnage</td>
                                                        <td style='width:5%;'>Durée (h)</td>
                                                        <td style='width:10%;'>Date de Visa</td>
                                                        <td style='width:10%;'>Viseur</td>
                                                        <td style='width:5%;'>Lieu de formation</td>
                                                    </tr>
                                                    @foreach($compagnonage->taches()->get() as $tache)
                                                    <tr class='ligneTache'>
                                                        <td rowspan='{{$tache->nb_ssobj()}}'>
                                                        @if($readwrite)
                                                            <input type='checkbox' 
                                                                x-data='{ active: false }'
                                                                x-on:click="active = !active;
                                                                            if (active){
                                                                                selected_taches[{{$tache->id}}] = true; 
                                                                            }
                                                                            else {
                                                                                selected_taches[{{$tache->id}}] = false; 
                                                                            }";>@endif {{$tache->tache_liblong }} 
                                                            @if ($user->aValideLaTache($tache))
                                                                <button class='btn btn-success' type='button' disabled>VALIDEE</button>
                                                        @endif
                                                        </td>
                                                        @foreach($tache->objectifs()->get() as $objectif)
                                                        <td rowspan='{{$objectif->sous_objectifs()->get()->count()}}'> {{$objectif->objectif_liblong }} </td>
                                                            @foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                                                                <td>{{$sous_objectif->ssobj_lib}}</td>
                                                                <td>{{$sous_objectif->ssobj_duree}}</td>
                                                                <td title=''>
                                                                    @if($readwrite)
                                                                        <input type='checkbox' 
                                                                        x-data='{ active: false }'
                                                                        x-on:click="active = !active;
                                                                                    if (active){
                                                                                        selected_sous_objectifs[{{$sous_objectif->id}}] = true; 
                                                                                    }
                                                                                    else {
                                                                                        selected_sous_objectifs[{{$sous_objectif->id}}] = false; 
                                                                                    };"
                                                                                    >@endif
                                                                    @if ($user->aValideLeSousObjectif($sous_objectif))
                                                                        <button class='btn btn-success' type='button' disabled>
                                                                        VALIDE {{ $user->sous_objectifs()->find($sous_objectif)->pivot->date_validation }}
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                @if ($user->aValideLeSousObjectif($sous_objectif))
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
                                   @endforeach <!-- foreach compagnonage -->
                            @endif
                            
                            @if ($fonction->stages()->get()->count() > 0)
                            <div class="accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStages">
                                            <h5>Stages</h5>
                                        </button>
                                    </div>
                                    <div id="collapseStages" class="accordion-collapse collapse">
                                        <div  class="accordion-body">
                                            <table class='table'>
                                                @foreach($fonction->stages()->get() as $stage)

                                                <tr class='lignecomp div-table-contrat-compagnonnage'>
                                                    <th colspan='2'>{{$stage->stage_libcourt }}</th>
                                                </tr>
                                                <tr class='ligneTache'>
                                                    <td>
                                                        @if ($user->aValideLeStage($stage))
                                                            <button class='btn btn-success' type='button' disabled>
                                                            VALIDE {{ $user->stages()->find($stage)->pivot->date_validation }}
                                                            </button>
                                                        @else
                                                            <button class='btn btn-warning' type='button' disabled>
                                                            NON VALIDE A CE JOUR
                                                            </button>
                                                            @if (false)
                                                                <input type='checkbox' 
                                                                id='stageid[{{$stage->id}}]' 
                                                                name='stageid[{{$stage->id}}]' 
                                                                value='stageid[{{$stage->id}}]'>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach <!-- foreach stage -->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
            @endforeach   <!-- foreach fonction -->
            
            @if ($user->stagesOrphelins()->count() > 0)
             <div class="accordion">
                <div class="accordion-item">
                    <div class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStages">
                            <h3>Stages attribués mais non liés à une fonction</h3>
                        </button>
                    </div>
                    <div id="collapseStages" class="accordion-collapse collapse">
                        <div  class="accordion-body">
                            <table class='table'>
                                @foreach($user->stagesOrphelins() as $stage)
                                    <tr class='lignecomp div-table-contrat-compagnonnage'>
                                        <th colspan='2'>{{$stage->stage_libcourt }}</th>
                                    </tr>
                                    <tr class='ligneTache'>
                                        <td>
                                            @if ($user->aValideLeStage($stage))
                                                <button class='btn btn-success' type='button' disabled>
                                                VALIDE {{ $user->stages()->find($stage)->pivot->date_validation }}
                                                </button>
                                            @else
                                                <button class='btn btn-warning' type='button' disabled>
                                                NON VALIDE A CE JOUR
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach <!-- foreach stage -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>  <!-- fin de la div livret -->
    </div>
</div>
