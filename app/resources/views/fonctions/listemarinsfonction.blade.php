@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Transformation pour la fonction <b>{{$fonction->fonction_liblong}}</b></h2>
            <a href="{{ url()->previous() }}" class="btn btn-primary">Retour</a>
        <div class="lead">
            Liste des marins étant {{$fonction->fonction_liblong}}
        </div>
        <div class="mt-3">
             @livewire('users-table', ['mode' => 'listmarin', 'fonction'=> $fonction ])
        </div>

    </div>
@endsection