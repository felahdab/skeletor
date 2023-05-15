@extends('layouts.app-master')

@section('content')
    <div class="  p-4 rounded">
        <h1>Données de l'utilisateur</h1>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Utilisateur: {{ $user->grade->grade_libcourt}} {{$user->name}} {{$user->prenom}}
            </div>
            <div>
                Email: {{ $user->email }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Mettre à jour</a>
        <a href="{{ route('users.index') }}" class="btn btn-default">Annuler</a>
    </div>
@endsection