@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
        <div class="lead">
            Gérer les objectifs.
        <a href="{{ route('objectifs.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un objectif</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @livewire('objectif-list')
    </div>
@endsection