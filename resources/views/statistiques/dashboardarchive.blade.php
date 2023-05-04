@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="statistiques"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Tableaux de bord des marins archivés</h2>
        <div class="lead">
            Affinez la liste des marins en effectuant une recherche ou en filtrant les données.
        </div>
        <div class="mt-3 mb-4"><b style="font-size: x-large;">&#9432;</b> Les filtres dates permettent de filtrer uniquement sur la date de débarquement.</div>
        
        <livewire:dashboardarchive>
    </div>
@endsection
