@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded" x-data="{ opendivvalid : false,
                                                commentaire : '',
                                                date_validation : '{{ date('Y-m-d') }}', 
                                                valideur : '{{auth()->user()->display_name}}',
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
        
        
        @livewire('livret-transformation', ['mode'      => "multiple",
                                            'fonction'  => $fonction,
                                            'readwrite' => true])
    </div>
@endsection