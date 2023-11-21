@extends('layouts.app-master')
@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')

<h1>Gestion des secteurs</h1>
<a href="{{ route('secteurs.create') }}" class="btn btn-primary btn-sm float-right">Ajouter</a>
<livewire:secteurs-table>

@endsection