@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Sous-Objectifs</h2>
        <div class="lead">
            Gérer les sous objectifs.
        </div>

        @livewire('sousobjectif-list')
    </div>
    
@endsection