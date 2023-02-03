@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Transformation - Marins</h2>
        <div class="lead">
            Liste des marins en transformation
        </div>

        <div class="mt-3">
            <livewire:users-table mode="transformation">
        </div>

    </div>
@endsection