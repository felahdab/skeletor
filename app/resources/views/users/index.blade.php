@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Utilisateurs</h2>
        <div class="lead">
            Gestion des utilisateurs
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un utilisateur</a>
        </div>
        <div class="mt-3">
            <livewire:users-table mode="gestion">
        </div>

    </div>
@endsection