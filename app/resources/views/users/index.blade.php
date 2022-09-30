@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Utilisateurs</h2>
        <div class="lead">
            Gestion des utilisateurs
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un utilisateur</a>
        </div>

        @livewire('users-table')

    </div>
@endsection