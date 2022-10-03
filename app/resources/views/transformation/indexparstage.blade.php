@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Transformation - Stages</h2>
        <div class="lead">
            Gérer la transformation par les stages
        </div>

        @livewire('stages-table', ['mode' => "transformation"])

    </div>
@endsection