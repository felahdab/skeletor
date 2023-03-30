@extends('layouts.app-master')


@section('content')
    <div>
        <img src='{!! asset("assets/images/logo_FFAST_bleu.png") !!}' alt="Logo de l'escouade" style="height:250px; display: block; margin-left:auto; margin-right: auto; ">
    </div>
    <div class="bg-light p-4 rounded" style="max-width: 400px; margin-left:auto; margin-right: auto;">
    Demande enregistrée. Votre compte doit être validé par un administrateur. Vous recevrez un mail lorque votre pourrez vous connecter.
    </div>
@endsection