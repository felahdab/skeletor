@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Livret de transformation de {{$user->prenom}} {{$user->name}}
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <div id='livret' class='div-table-contrat-compagnonnage table'>
            <div class='text-center'>
                <button type='button' class='btn btn-primary w-25 mr-5 mb-2' onclick='affichage("divvalid");'>Enregistrer les validations</button>
                <button type='submit' class='btn btn-primary w-25 ml-5 mb-2' id='btnimp' name='btnimp' form='formlivret'>Imprimer</button>
            </div>
            
            <div id='divvalid' class='popupvalidcontrat' style='display:none;'>
                <div class='titrenavbarvert'>
                    <h5>Validation</h5>
                </div>
                <div class='form-group row pl-3 mt-2' >
                    <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                    <div class='col-sm-5'>
                    <input type='date' class='form-control'name='dat_valid' id='dat_valid' value='2022-08-14'>
                    </div>
                </div>
                <div class='form-group row  pl-3' >
                    <label for='valideur' class='col-sm-5 col-form-label '>Valideur</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='valideur' id='valideur' placeholder=' Valideur' value='{{auth()->user()->displayString()}}'>
                    </div>
                </div>
                <div class='form-group row  pl-3' >
                    <label for='comment' class='col-sm-5 col-form-label '>Commentaire</label>
                    <div class='col-sm-5'>
                        <textarea cols='40' rows='4' name='comment' id='comment' placeholder='Commentaire'></textarea>
                    </div>
                </div>
                <div class='text-center'>
                    <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' type='submit' form='formlivret' id='btnvalidobj' name='btnvalidobj'>Valider</button>
                    <button class='btn btn-primary w-25 mt-4 mb-2' type='reset' form='formlivret' id='btnresetobj' name='btnresetobj' onclick='annuler("divvalid");'>Annuler</button>
                </div>
            </div>
            
            @foreach ($user->fonctions()->get() as $fonction)
            <table class='table'>
            <tr class='lignecomp div-table-contrat-compagnonnage'>
                <th colspan='7'>{{$fonction->fonction_liblong }}</th>
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
                    <input type='checkbox' id='tacheid={{$tache->id}}' name='tacheid={{$tache->id}}' value='tacheid={{$tache->id}}'> {{$tache->tache_liblong }}
                    </td>
                        @foreach($tache->objectifs()->get() as $objectif)
                        <td rowspan='{{$objectif->sous_objectifs()->get()->count()}}'> {{$objectif->objectif_liblong }} </td>
                            @foreach($objectif->sous_objectifs()->get() as $sous_objectif)
                                <td>{{$sous_objectif->ssobj_lib}}</td>
                                <td>{{$sous_objectif->ssobj_duree}}</td>
                                <td title=''>
                                    <input type='checkbox' id='ssobjid={{$sous_objectif->id}}' name='ssobjid={{$sous_objectif->id}}' value='ssobjid={{$sous_objectif->id}}'>
                                </td>
                                <td></td>
                                <td>{{$sous_objectif->lieu()->get()->first()->lieu_libcourt}}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                    </tr>
                @endforeach
                <tr  class='double'>
                    <td>DOUBLE</td>
                    <td colspan='3'></td>
                    <td><input type='button' class='btn btn-primary' id='double=82' name='double=82' value='Valider' onclick=''>
                    <input type='hidden' id='cache' name='cache' value=''></td>
                    <td></td>
                    <td>Bord</td>
                </tr>
                <tr  class='double'>
                    <td>L&Acirc;CHER</td>
                    <td colspan='3'></td>
                    <td></td>
                    <td></td>
                    <td>Bord</td>
                </tr>
            </table>
            @endforeach
        </div>

    </div>
@endsection