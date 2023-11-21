@extends('layouts.app-master')
@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')

<h1>Gestion des services</h1>
<a href="{{ route('services.create') }}" class="btn btn-primary btn-sm float-right">Ajouter</a>
<livewire:services-table>

@endsection