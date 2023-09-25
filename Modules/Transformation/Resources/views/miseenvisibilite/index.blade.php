@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Mises pour emploi</h2>
        <div class="lead">
            Gérer les mises pour emploi.
        <a href="{{ route('transformation::miseenvisibilite.create') }}" class="btn btn-primary btn-sm float-right">Ajouter MPE</a>
        </div>
        
        @livewire('transformation::miseenvisibilite-table')
    </div>
@endsection