@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')
    <div class="p-4">
        <h2>Transformation - Stages</h2>
        <div class="lead">
            Liste des stages pour validation collective
        </div>
        <div class="mt-3">
            <livewire:stages-table mode="transformation">
        </div>
    </div>
@endsection