@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Transformation - Stages</h2>
        <div class="lead">
            Gérer la transformation par les stages
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        @livewire('stage-list', ['mode' => "transformation"])

    </div>
@endsection