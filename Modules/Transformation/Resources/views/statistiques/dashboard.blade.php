@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="statistiques"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Tableaux de bord</h2>
        <div class="lead">
            Affinez la liste des marins en effectuant une recherche ou en filtrant les données.
        </div>
        <div style ="border-left: 5px solid deepskyblue !important"><small> &nbsp;Le marin a une date de débarquement.</small></div>
        <div><small> &nbsp;Les marins n'ayant pas encore embarqué n'apparaissent pas dans cette liste.</small></div>
        
        <livewire:transformation::dashboard>
    </div>
@endsection
