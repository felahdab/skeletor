@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    

    <div class="  p-4 rounded">
        <h2>Marins</h2>
        <div class="lead">
            Gestion des marins
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un marin</a>
        </div>
        <div class="mt-3">
            <livewire:users-table mode="gestion">
        </div>

    </div>
@endsection
