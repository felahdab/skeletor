@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>SUIVI TRANSFORMATION </h2>
        <div class="lead">
            Liste des marins en transformation dans le service {{ $currentuser->displayService() }}
        </div>
        <div class="mt-3">
            <livewire:stattuteur-table>
        </div>
    </div>
@endsection