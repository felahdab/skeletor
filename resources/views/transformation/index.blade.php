@extends('layouts.app-master')

@section('helplink')
< x-help-link page="transformation"/>
@endsection


@section('content')
    
    <div class="p-4">
        <h2>Transformation - Marins</h2>
        <div class="lead">
            Liste des marins en transformation
        </div>

        <div class="mt-3">
            <livewire:users-table mode="transformation">
        </div>

    </div>
@endsection