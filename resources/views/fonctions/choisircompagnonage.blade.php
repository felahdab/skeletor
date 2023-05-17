@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Compagnonnages</h2>
        <div class='lead'>Ajout d'un compagnonnage pour la fonction : {!!$fonction->fonction_libcourt !!} </div>
    </div>
    
    @livewire('compagnonage-list', ['fonction' => $fonction, 'mode' => 'selection'])
    
@endsection