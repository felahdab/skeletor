@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Liens</h2>
        <div class="lead">
            Gérer les liens de la page d'accueil des marins en transformation
            <a href="{{ route('liens.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un lien</a>
        </div>
            
        @livewire('lien-list')
    </div>
@endsection