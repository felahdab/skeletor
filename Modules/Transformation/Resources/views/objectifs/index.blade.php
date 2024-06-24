@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Savoir-faire</h2>
        <div class="lead">
            Gérer les savoir-faire.
        <a href="{{ route('transformation::objectifs.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un savoir-faire</a>
        </div>
        
        @livewire('transformation::objectif-list')
    </div>
@endsection