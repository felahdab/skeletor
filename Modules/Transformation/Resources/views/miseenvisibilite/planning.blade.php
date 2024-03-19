@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Planning des mises pour emploi</h2>
        <p>Affinez l'affichage grâce aux filtres</p>
        
        
        <livewire:transformation::planning>

    </div>
@endsection