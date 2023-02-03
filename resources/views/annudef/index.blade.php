@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Recherche Annudef</h2>
        <div class="mt-3">
            <livewire:annudef-search>
        </div>

    </div>
@endsection