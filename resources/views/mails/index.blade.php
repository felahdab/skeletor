@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Mails</h2>
        <div class="lead">
            Mails envoyés précédemment
            <a dusk="create-mail-btn" href="{{ route('mails.create') }}" class="btn btn-primary btn-sm float-right">Envoyer un nouveau mail</a>
        </div>
        
        @livewire('mail-table')
    </div>
@endsection