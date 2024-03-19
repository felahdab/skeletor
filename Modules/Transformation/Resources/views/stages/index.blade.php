@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Stages</h2>
        <div class="lead">
            Gérer les stages
            <a href="{{ route('transformation::stages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un stage</a>
        </div>
        <div class="mt-4">
            @livewire('transformation::stages-table', ['mode' => "gestion"])
        </div>
    </div>
@endsection