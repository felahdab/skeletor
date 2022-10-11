@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Livret de transformation de {{$user->displayString()}}
        </div>
        
        @if($readwrite)
            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            @can('users.stages')
                <a href="{{ route('users.stages', $user->id) }}" class="btn btn-danger btn-sm">Stages</a>
            @endcan
            <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
        @else
            <a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-sm">Mon livret de transformation</a>
            <a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-sm">Ma progression</a>
            <a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-sm">Ma fiche bilan</a>
        @endif
        
        <div x-data="{ opendivvalid : false ,
                       commentaire : '' ,
                       valideur : '{{auth()->user()->displayString()}}',
                       button : null,
                       buttonid : '',
                       date_validation : '{{ date('Y-m-d')}}' }">
                       
        @if($readwrite)
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
        </div>
        @endif
        
        <div id='livret' class='div-table-contrat-compagnonnage table'>
            <div class='text-center'>
                <a href="{{ route('transformation.livretpdf', $user->id) }}" class="btn btn-primary w-25 ml-5 mb-2">Imprimer</a>
            </div>
            
            @foreach ($user->fonctions()->orderBy('typefonction_id')->get() as $fonction)
            <h3>Situation de la transformation pour la fonction {{$fonction->fonction_liblong }} </h3>
            
            @if($readwrite){!! Form::open(['method' => 'POST','id'=> 'fonction[' . $fonction->id .']' , 'route' => ['transformation.validerlacheoudouble', $user->id, $fonction->id]]) !!}
            <input type='hidden' id='fonction[id]' name='fonction[id]' value='{{ $fonction->id }}'>
            <input type='hidden' id='date_validation' name='date_validation' x-model="date_validation">
            <input type='hidden' id='commentaire' name='commentaire' x-model="commentaire">
            <input type='hidden' id='valideur' name='valideur' x-model="valideur">
            <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">@endif
            
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
                    <td>
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
                        <button type="submit" 
                        class="btn btn-danger" 
                        name="annulation_double">
                        Annuler</button>
                    @elseif ($readwrite)
                    <button type="submit" 
                        class="btn btn-primary" 
                        name="validation_double"
                        x-on:click.prevent="active  = true; 
                                           buttonid ='validation_double'; 
                                       opendivvalid =true;">Valider</button>
                    <button x-show="false" type="submit"  x-on:uservalidated.window="if (active){ active = false;  $el.click();}"></button>
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
                        <button type="submit" 
                        class="btn btn-danger" 
                        name="annulation_lache">Annuler</button>
                    @elseif($readwrite)
                    <button type="submit" 
                        class="btn btn-primary" 
                        name="validation_lache"
                        x-on:click.prevent="active  = true; 
                                           buttonid ='validation_lache'; 
                                       opendivvalid =true;">Valider</button>
                        <button x-show="false" type="submit"  x-on:uservalidated.window="if (active){ active = false;  $el.click();}"></button>
                    @endif
                    </td>
                    <td>Bord</td>
                </tr>
                @endif
            </table>
            @if($readwrite){!! Form::close() !!} @endif
            
            @if ($fonction->compagnonages()->get()->count() > 0)
            <h4>Compagnonages liés à la fonction {{ $fonction->fonction_liblong }} </h4>
            
            @if($readwrite){!! Form::open(['method' => 'POST','id'=> 'ssobjs[' . $fonction->id .']' ,'route' => ['transformation.livret', $user->id]]) !!}@endif
            <input type='hidden' id='fonction[id]' name='fonction[id]' value='{{ $fonction->id }}'>
            <input type='hidden' id='date_validation' name='date_validation' x-model="date_validation">
            <input type='hidden' id='commentaire' name='commentaire' x-model="commentaire">
            <input type='hidden' id='valideur' name='valideur' x-model="valideur">
            <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">
            
            <table class='table' x-data='{ active : false }'>
                @foreach($fonction->compagnonages()->get() as $compagnonage)

                    <tr class='lignecomp div-table-contrat-compagnonnage'>
                        <th colspan='7'>{{$compagnonage->comp_liblong }}</th>
                    </tr>
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
                        id='tacheid[{{$tache->id}}]' 
                        name='tacheid[{{$tache->id}}]' 
                        value='tacheid[{{$tache->id}}]'>@endif {{$tache->tache_liblong }} 
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
                                    @if($readwrite)<input type='checkbox' 
                                    id='ssobjid[{{$sous_objectif->id}}]' 
                                    name='ssobjid[{{$sous_objectif->id}}]' 
                                    value='ssobjid[{{$sous_objectif->id}}]'>@endif
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
                    </tr>
                    @if($readwrite)<tr  class='lignecomp'>
                        <td colspan='7'>
                            <button type="submit" 
                            class="btn btn-primary" 
                            name="validation"
                            x-on:click.prevent="active = true ;
                                                opendivvalid = true ;
                                                buttonid = 'validation' ;">Valider les éléments cochés</button>
                            <button x-show="false" type="submit"  x-on:uservalidated.window="if (active){ active = false;  $el.click();}"></button>
                            <button type="submit" 
                            class="btn btn-danger" 
                            name="annulation_validation">Annuler la validation des éléments cochés</button>
                        </td>
                    </tr>@endif

                @endforeach <!-- foreach compagnonage -->
            </table>
            @if($readwrite){!! Form::close() !!}@endif
            @endif
            
            @if ($fonction->stages()->get()->count() > 0)
            <h4>Stages liés à la fonction {{ $fonction->fonction_liblong }} </h4>
            
            {!! Form::open(['method' => 'POST','id'=> 'stages[' . $fonction->id .']' ,'route' => ['transformation.livret', $user->id]]) !!}
            <input type='hidden' id='fonction[id]' name='fonction[id]' value='{{ $fonction->id }}'>
            <input type='hidden' id='date_validation' name='date_validation' x-model="date_validation">
            <input type='hidden' id='commentaire' name='commentaire' x-model="commentaire">
            <input type='hidden' id='valideur' name='valideur' x-model="valideur">
            <input type='hidden' id='buttonid' name='buttonid' x-model="buttonid">
            
            <table class='table' x-data='{ active : false }'>
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
                
                @if (false)
                    <tr  class='lignecomp'>
                        <td colspan='3'>
                            <button type="submit" 
                            class="btn btn-primary" 
                            name="validation"
                            x-on:click.prevent='active = true;
                                                opendivvalid = true;
                                                buttonid = "validation";'>Valider les éléments cochés</button>
                            <button x-show="false" type="submit"  x-on:uservalidated.window="if (active){ active = false;  $el.click();}"></button>
                            <button type="submit" 
                            class="btn btn-danger" 
                            name="annulation_validation">Annuler la validation des éléments cochés</button>
                        </td>
                    </tr>
                @endif
            </table>
            {!! Form::close() !!}
            
            @endif
            @endforeach   <!-- foreach fonction -->
            
            @if ($user->stagesOrphelins()->count() > 0)
                <h3>Stages attribues mais non liés à une fonction</h3>
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
            @endif
        </div> 
        </div>
    </div>
@endsection