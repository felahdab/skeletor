@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="transformation"/>
@endsection


@section('content')
    <div class="  p-4 rounded" x-data="{ opendivvalid : false,
                                                commentaire : '',
                                                date_validation : '{{ date('Y-m-d') }}', 
                                                valideur : '{{auth()->user()->display_name}}',
                                                }">
        <h1>Transformation</h1>
        <div class="lead">
           Validation collective de sous objectifs ou de taches pour la fonction {{$fonction->fonction_libcourt}}
        </div>
        
        <div>
        Sélectionnez les sous objectifs ou les tâches pour lesquelles vous souhaitez enregistrer
        une validation, puis cliquez sur "Enregistrer les validations". Vous pourrez ensuite
        sélectionner les marins pour lesquels ces éléments du parcours de transformation sont
        validés.
        </div>
        
        
        @livewire('transformation::livret-transformation', ['mode'      => "modificationmultiple",
                                            'fonction'  => $fonction])
    </div>
@endsection