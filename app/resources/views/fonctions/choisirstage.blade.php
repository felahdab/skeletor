@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="parcours"/>
@endsection


@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class='lead'>Ajout d'un stage pour la fonction : {!!$fonction->fonction_libcourt !!} </div>
    </div>
   
   @livewire('stage-list', ['mode' => 'selection', 'fonction'=>$fonction])
   
@endsection