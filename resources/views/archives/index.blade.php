@extends('layouts.app-master')

{{-- @section('helplink')
<x-help-link module="Transformation" page="administration"/>
@endsection --}}

@section('content')
    

    <div class="p-4 rounded">
        <h2>Marins archivés</h2>
        <div class="lead">
            Suppression définitive des marins.        
        </div>
        <div class="mt-3">
            <livewire:users-table mode="archiv">
        </div>

    </div>
@endsection