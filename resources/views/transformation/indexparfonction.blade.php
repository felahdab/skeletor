@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')

    <div  class="p-4">
        <h2>Transformation - Fonctions</h2>
        <div class="lead">
            Liste des fonctions pour validation collective
        </div>
        <div class="mt-3">
            @livewire('fonction-list', ["mode" => "transformation"])
        </div>
    </div>
@endsection