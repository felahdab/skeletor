@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h2>Historique de la transformation</h2>

        <div class="mt-3">
            <livewire:transformation-history-table>
        </div>

    </div>
@endsection