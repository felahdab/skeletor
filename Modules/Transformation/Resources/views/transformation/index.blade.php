@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="transformation"/>
@endsection


@section('content')
    
    <div class="p-4">
        <h2>Suivi par marin</h2>
        <div class="lead">
            Liste des marins
        </div>

        <div class="mt-3">
            <livewire:transformation::users-table mode="transformation">
        </div>

    </div>
@endsection