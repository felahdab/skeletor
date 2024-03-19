@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Fonctions</h2>
        <div class='lead'>Ajout d'un stage pour la fonction : {!!$fonction->fonction_libcourt !!} </div>
    </div>
   
   @livewire('transformation::stage-list', ['mode' => 'selection', 'fonction'=>$fonction])
   
@endsection