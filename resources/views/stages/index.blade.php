@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Stages</h2>
        <div class="lead">
            Gérer les stages
            <a href="{{ route('stages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un stage</a>
        </div>
        <div class="mt-4">
            @livewire('stages-table', ['mode' => "gestion"])
        </div>
    </div>
@endsection