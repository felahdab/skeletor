@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Transformation - Marins</h2>
        <div class="lead">
            Liste des marins
        </div>

        @livewire('user-list', ["mode" => "transformation"])

    </div>
@endsection