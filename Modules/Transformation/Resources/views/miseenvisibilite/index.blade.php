@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Partage de dossier</h2>
        <div class="lead">
            Gérer la visibilité d'un dossier par les autres unités.
        <a href="{{ route('transformation::miseenvisibilite.create') }}" class="btn btn-primary btn-sm float-right">Ajouter partage</a>
        <!--a href="{{ route('transformation::miseenvisibilite.planning') }}" class="btn btn-secondary btn-sm float-right">Planning</a-->
        </div>
        
        @livewire('transformation::miseenvisibilite-table')
    </div>
@endsection