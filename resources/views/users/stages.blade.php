@extends('layouts.app-master')

@section('helplink')
< x-help-link page="transformation"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Stages de {{$marin->display_name}}
        </div>
        <div class='mt-2'> 
            <a href="{{ route('transformation.livret', $marin->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $marin->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $marin->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            <a href="{{ route('users.stages', $marin->id) }}" class="btn btn-danger btn-sm">Stages</a>
            <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
        </div>
   
    <div x-data="{stageid : null , 
                commentaire : null , 
                libstage : null ,
                nommarin : null ,
                date_validation : null ,
                opendivvalid : false,
                opendivvalidcomment : false }">

        <div id='divconsultstage' class='card   ml-3 w-100'>
            @if ( $marin != null)
            <div class='mt-2 mb-2' style='margin-left:50%; text-align: center;'> </div>

            <div x-data='{ selectstage : false }'>
                @can('stages.attribuerstage')
                    <button class="btn btn-primary mb-1" 
                        x-on:click.prevent="selectstage= ! selectstage;
                                            if (selectstage)
                                                $el.innerHTML='Retour à la liste des stages du marin';
                                            else
                                                $el.innerHTML='Rajouter un stage supplémentaire';">Rajouter un stage supplémentaire</button>
                @endcan
                <div class="modal fade" id="divvalid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Validation</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
                            <div class='form-group row mt-4' >
                                <label for='datvalid' class='col-sm-5 col-form-label '>Date validation</label>
                                <div class='col-sm-5'>
                                    <input type='date' class='form-control'name='date_validation' id='date_validation' x-model="date_validation">
                                </div>
                            </div>
                            <div class='form-group row  mt-4' >
                                    <textarea class="form-control"  rows='4' name='commentaire' id='commentaire' placeholder='Commentaire' x-model="commentaire"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" 
                                    class="btn btn-primary"
                                    data-bs-dismiss="modal"
                                    x-on:click="opendivvalid=false;
                                    $dispatch('uservalidated');">Valider</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="divvalidcomment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <p class="modal-title fs-5" id="exampleModalLabel">
                                Commentaire du stage : <input x-model="libstage" disabled class="mb-1 text-dark w-100" > 
                                <br>Pour le marin : <input x-model="nommarin" disabled class="mt-1 text-dark w-100" >
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type='hidden' id='formtosubmit' name='formtosubmit' value=''>
                            <div class='form-group row  mt-2' >
                                <textarea class="form-control" rows='4' name='commentaire' id='commentaire' placeholder="Commentaire" x-model="commentaire"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="button" 
                                    class="btn btn-primary"
                                    data-bs-dismiss="modal"
                                    x-on:click="opendivvalid=false;
                                    $dispatch('usercommentvalidated');">Valider</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div x-cloak x-show="selectstage">
                    @livewire('stages-table', ['mode' => 'selectnewstage', 'user' => $marin])
                </div>
                <div x-cloak x-show=" ! selectstage">
                    @livewire('stages-table', ['mode' => 'uservalidation', 'user' => $marin])
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
