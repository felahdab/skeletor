@extends('layouts.app-master')

@section('helplink')
< x-help-link page="transformation"/>
@endsection


@section('content')
    

    <div class="  p-4 rounded">
        <h2>Transformation - Recalcul</h2>
        <div class="lead">
            Calcul de tous les taux de transformation pour tous les marins.
        </div>
        <p class="mt-5 mb-5"><b><u>Attention</u></b> : Ce traitement peut durer quelques minutes.</p>

        <livewire:gere-recalcul>

    </div>
@endsection