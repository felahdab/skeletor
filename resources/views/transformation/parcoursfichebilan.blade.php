@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="statistiques"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Parcours des fiches bilans</h2>
        <div class="lead">
            Affinez la liste des marins en effectuant une recherche ou en filtrant les données.
        </div>
        
        <livewire:parcours-fiches-bilan>
    </div>
@endsection
