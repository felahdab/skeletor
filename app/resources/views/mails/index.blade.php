@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Mails</h2>
        <div class="lead">
            Mails envoyés précédemment
            <a href="{{ route('mails.create') }}" class="btn btn-primary btn-sm float-right">Envoyer un nouveau mail</a>
        </div>
        
        @livewire('mail-table')
    </div>
@endsection