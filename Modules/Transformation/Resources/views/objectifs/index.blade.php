@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Objectifs</h2>
        <div class="lead">
            Gérer les objectifs.
        <a href="{{ route('objectifs.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un objectif</a>
        </div>
        
        @livewire('transformation::objectif-list')
    </div>
@endsection