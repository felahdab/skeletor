@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="lead">
            Gérer les stages
            <a href="{{ route('stages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un stage</a>
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        
        @livewire('stage-list', ['mode' => "gestion"])
    </div>
@endsection