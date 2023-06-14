@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Tâches</h2>
        <div class='lead'>Ajout d'une tâche pour le compagnonnage : {!!$compagnonage->comp_libcourt !!} </div>
    </div>
    
    @livewire('transformation::tache-list', ['compagnonage' => $compagnonage, 'mode' => 'selection'])
@endsection