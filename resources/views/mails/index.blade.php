@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
<x-content-div heading="Mails">
        <div class="lead">
            Mails envoyés précédemment
            <a dusk="create-mail-btn" href="{{ route('mails.create') }}" class="btn btn-primary btn-sm float-right">Envoyer un nouveau mail</a>
        </div>
        
        @livewire('mail-table')
</x-content-div>
@endsection