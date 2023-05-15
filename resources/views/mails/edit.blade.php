@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Editer un mail</h2>
    </div>
    <div>
        @livewire('mail-edit-component', ["mail" => $mail ])
    </div>
@endsection