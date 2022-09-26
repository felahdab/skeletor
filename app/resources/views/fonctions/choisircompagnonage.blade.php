@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class='lead'>Ajout d'un compagnonnage pour la fonction : {!!$fonction->fonction_libcourt !!} </div>
    </div>
    
    @livewire('compagnonage-list', ['fonction' => $fonction, 'mode' => 'selection']);
    
@endsection