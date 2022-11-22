@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Transformation - Fonctions</h2>
        <div class="lead">
            Liste des fonctions pour validation collective
        </div>
        <div class="mt-3">
            @livewire('fonction-list', ["mode" => "transformation"])
        </div>
    </div>
@endsection