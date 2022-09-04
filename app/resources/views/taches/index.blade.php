@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="lead">
            Gérer les taches
            <a href="{{ route('taches.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une tache</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @livewire('tache-list')
    </div>
@endsection