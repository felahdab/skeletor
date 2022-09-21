@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Tâches</h2>
        <div class="lead">
            Gérer les tâches
            <a href="{{ route('taches.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une tâche</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @livewire('tache-list')
    </div>
@endsection