@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages - {{$marin->display_name}}</h2>
    </div>
    
    <div x-data="{stageid : null , 
                commentaire : null , 
                libstage : null ,
                nommarin : null ,
                date_validation : null ,
                opendivvalid : false,
                opendivvalidcomment : false }">

        <div id='divconsultstage' class='card bg-light ml-3 w-100'>
            <div class='card-header'>Consultation des stages pour {{$marin->display_name}}</div>
            @if ( $marin != null)
            <div class='mt-2 mb-2'> 
                <a href="{{ route('transformation.livret', $marin->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
                <a href="{{ route('transformation.progression', $marin->id) }}" class="btn btn-primary btn-sm">Progression</a>
                <a href="{{ route('transformation.fichebilan', $marin->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
                <a href="{{ route('users.stages', $marin->id) }}" class="btn btn-danger btn-sm">Stages</a>
                <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
            </div>
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

                <div x-cloak x-show="opendivvalid" class='popupvalidcontrat' >
                <!-- div qui permet de valider un stage pour un user-->
                    <div class='titrenavbarvert'>
                        <h5>Validation</h5>
                    </div>
                    <div class='form-group row pl-3 mt-2' >
                        <label class='col-sm-5 col-form-label '>Date validation</label>
                        <div class='col-sm-5'>
                        <input type='date' class='form-control' x-model="date_validation">
                        </div>
                    </div>
                    <div class='form-group row  pl-3' >
                        <label class='col-sm-5 col-form-label '>Commentaire</label>
                        <div class='col-sm-5'>
                            <textarea cols='40' rows='4' placeholder='Commentaire' x-model="commentaire"></textarea>
                        </div>
                    </div>
                    <div class='text-center'>
                        <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                             x-on:click.prevent="$dispatch('uservalidated');
                                                     opendivvalid=false;"> Valider </button>
                        <button class='btn btn-primary w-25 mt-4 mb-2' 
                            x-on:click.prevent='opendivvalid = false ;'>Annuler</button>
                    </div>
                </div>
                <div x-cloak x-show="opendivvalidcomment" class='popupvalidcontrat' >
                <!-- div qui permet maj commentaire d'un stage pour un user-->
                    <div class='titrenavbarvert'>
                        <h5>Validation</h5>
                        <input class='text-center' x-model="libstage" disabled>
                        <input class='text-center' x-model="nommarin" disabled>
                    </div>
                    <div class='form-group row  pl-3' >
                        <label class='col-sm-5 col-form-label '>Commentaire</label>
                        <div class='col-sm-5'>
                            <textarea cols='40' rows='4' placeholder='Commentaire' x-model="commentaire"></textarea>
                        </div>
                    </div>
                    <div class='text-center'>
                        <button class='btn btn-primary w-25 mt-4 mr-2 mb-2' 
                             x-on:click.prevent="$dispatch('usercommentvalidated');
                                                     opendivvalidcomment=false;"> Valider </button>
                        <button class='btn btn-primary w-25 mt-4 mb-2' 
                            x-on:click.prevent='opendivvalidcomment = false ;'>Annuler</button>
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
        {!! link_to_route('transformation.index', 'Annuler', [], ['class' => 'btn btn-primary']) !!}
    </div>
@endsection
