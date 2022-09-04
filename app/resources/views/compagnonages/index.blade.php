@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Compagnonages</h2>
        <div class="lead">
            Gérer les compagnonages
            <a href="{{ route('compagnonages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un compagnonage</a>
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
        @livewire('compagnonage-list')
    </div>
@endsection