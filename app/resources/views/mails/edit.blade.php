@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Editer un mail</h2>
    </div>
    <div>
        @livewire('mail-edit-component', ["mail" => $mail ])
    </div>
@endsection