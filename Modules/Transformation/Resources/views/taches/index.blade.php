@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Compétences</h2>
        <div class="lead">
            Gérer les compétences
            <a href="{{ route('transformation::taches.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une compétence</a>
        </div>
        @livewire('transformation::tache-list')
    </div>
@endsection