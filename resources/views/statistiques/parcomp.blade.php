@extends('layouts.app-master')

@section('helplink')
<x-help-link page="statistiques"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Transformation par compagnonnage</h2>
        <div class="lead mb-3">
            Sélectionnez le compagnonnage à afficher. L'onglet "Résultat" doit s'ouvrir automatiquement.
        </div>
        
        <livewire:stat-par-comp>

    </div>
@endsection
