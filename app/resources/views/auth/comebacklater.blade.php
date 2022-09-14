@extends('layouts.app-master')


@section('content')
    <div>
        <img src='{!! url("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
    </div>
    <div class="bg-light p-4 rounded" style="max-width: 400px; margin-left:auto; margin-right: auto;">
    Demande enregistrée. Votre compte doit être validé par un administrateur. Veuillez reessayer ultérieurement.
    </div>
@endsection