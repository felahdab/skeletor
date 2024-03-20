@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Tâches</h2>
        <div class="lead">
            Gérer les tâches
            <a href="{{ route('transformation::taches.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une tâche</a>
        </div>
        @livewire('transformation::tache-list')
    </div>
@endsection