@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded" x-data="{ opendivvalid : false,
                                                commentaire : '',
                                                date_validation : '{{ date('Y-m-d') }}', 
                                                valideur : '{{auth()->user()->displayString()}}',
                                                }">
        <h1>Transformation</h1>
        <div class="lead">
           Validation collective de sous objectifs ou de taches pour la fonction {{$fonction->fonction_libcourt}}
        </div>
        
        <div>
        Selectionnez les sous objectifs ou les taches pour lesquelles vous souhaitez enregistrer
        une validation, puis cliquer sur "Enregistrer les validation". Vous pourrez ensuite
        selectionner les marins pour lesquels ces elements du parcours de transformation sont
        validés.
        </div>
        {!! Form::open(['method' => 'POST','id'=> 'formlivretfonc' , 'route' => ['fonctions.validermarins', $fonction->id]]) !!}
        <div x-show="opendivvalid" id='divvalid' class='popupvalidcontrat' >
            <div class='titrenavbarvert'>
                <h5>Validation</h5>
            </div>
            <div class='form-group row mt-2'>
                <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                <div class='col'>
                    <input type='date' class='form-control' name='date_validation' id='date_validation' x-model="date_validation" required>
                </div>
            </div>
            <div class='form-group row'>
                <label for='valideur' class='col-sm-5 col-form-label '>Valideur</label>
                <div class='col'>
                    <input type='text' class='form-control' name='valideur' id='valideur' placeholder=' Valideur' x-model="valideur">
                </div>
            </div>
            <div class='form-group row'>
                <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
                <div class='col-sm-5'>
                    <textarea cols='40' rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                </div>
            </div>
            <div class='form-group row'>
                <label for='marinsfonc' class='col-sm-5 col-form-label '>S&eacute;lectionnez les marins à valider</label>
                <div class='col w-100'>
                    <select multiple name='marinsfonc[]' id='marinsfonc[]'>
                    @foreach($usersfonction as $user)
                        <option value ='{{$user->id}}'>{{$user->displayString()}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
            <div class='text-center'>
                <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                        type='submit' 
                        form='formlivretfonc' 
                        id='btnvalidobjusers' 
                        name='btnvalidobjusers'
                        x-on:click.prevent="$dispatch('uservalidated');
                                            opendivvalid=false;">Valider</button>
                <button class='btn btn-primary w-25 mt-4 mb-2' 
                        type='reset' 
                        form='formlivretfonc' 
                        x-on:click.prevent='opendivvalid=false;'>Annuler</button>
            </div>
        </div>
        
        <div id='livret' class='div-table-contrat-compagnonnage table'>
            <table class='table'>
                <tr class='lignecomp'>
                <td colspan='7'>
                <button type="submit" 
                class="btn btn-primary" 
                name="validation"
                x-on:click.prevent='opendivvalid=true'>Enregistrer les validations</button>
                <button x-show="false" type="submit" 
                x-on:uservalidated.window='$el.click();'></button></td>
                </tr>
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
                    <input type='checkbox' 
                        id='tacheid[{{$tache->id}}]' 
                        name='tacheid[{{$tache->id}}]' 
                        value='tacheid[{{$tache->id}}]'> {{$tache->tache_liblong }} 
                    </td>
                        @foreach($tache->objectifs()->get() as $objectif)
                        <td rowspan='{{$objectif->sous_objectifs()->get()->count()}}'> {{$objectif->objectif_liblong }} </td>
                            @foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                                <td>{{$sous_objectif->ssobj_lib}}</td>
                                <td>{{$sous_objectif->ssobj_duree}}</td>
                                <td title=''>
                                    <input type='checkbox' 
                                    id='ssobjid[{{$sous_objectif->id}}]' 
                                    name='ssobjid[{{$sous_objectif->id}}]' 
                                    value='ssobjid[{{$sous_objectif->id}}]'>
                                </td>
                                <td>
                                </td>
                                <td>{{$sous_objectif->lieu()->get()->first()->lieu_libcourt}}</td>
                                </tr>
                            @endforeach <!-- foreach sous objectif -->
                        @endforeach <!-- foreach objectif -->
                    
                    @endforeach <!-- foreach tache -->
                    </tr>
                @endforeach <!-- foreach compagnonage -->
                <tr  class='lignecomp'>
                        <td colspan='7'>
                            <button type="submit" 
                            class="btn btn-primary" 
                            name="validation"
                            x-on:click.prevent='opendivvalid=true'>Enregistrer les validations</button>
                        </td>
                    </tr>
            </table>
            {!! Form::close() !!}
        </div> 
    </div>
@endsection