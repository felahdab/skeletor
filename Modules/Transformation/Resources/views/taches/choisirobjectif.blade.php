@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="administration"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Objectifs</h2>
        <div class='lead'>Ajout d'un objectif pour la tâche {!!$tache->tache_libcourt !!} </div>
    </div>
    
    @livewire('transformation::objectif-list', ['tache' => $tache, 'mode' => 'selection'])
    
@endsection