@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class="lead">
            Gérer les fonctions
            <a href="{{ route('fonctions.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une fonction</a>
        </div>
        @livewire('fonction-list', ['mode' => 'gestion'])
    </div>
@endsection