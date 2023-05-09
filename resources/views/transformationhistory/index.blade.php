@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    

    <div class="  p-4 rounded">
        <h2>Historique des modifications de la transformation</h2>

        <div class="mt-3">
            <livewire:transformation-history-table>
        </div>

    </div>
@endsection