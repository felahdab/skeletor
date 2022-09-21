@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
        <div class='lead'>Ajout d'un objectif pour la tâche {!!$tache->tache_libcourt !!} </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    
    @livewire('objectif-list', ['tache' => $tache, 'mode' => 'selection'])
    
@endsection