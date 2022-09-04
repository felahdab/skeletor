@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Transformation - Fonctions</h2>
        <div class="lead">
            Gérer la transformation par fonction
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @livewire('fonction-list', ["mode" => "transformation"])
    </div>
@endsection