@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Compagnonnages</h2>
        <div class="lead">
            Gérer les compagnonnages
            <a href="{{ route('compagnonages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un compagnonnage</a>
        </div>
        @livewire('transformation::compagnonage-list')
    </div>
@endsection