@extends('layouts.app-master')
@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')

<h1>Groupement</h1>
<div class="lead">
    Gestion des groupement
    <a href="{{ route('groupement.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un groupement</a>
</div>
<livewire:groupement-table>


@endsection