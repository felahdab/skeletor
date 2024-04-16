@extends('layouts.app-master')


@section('content')
<div class="d-flex flex-column mb-3 text-center">
    <div class="p-2 mt-3">
        <x-bootstrap-icon iconname='alarm-fill.svg' />
        {{-- <img src='{!! asset("assets/images/logo_FFAST_bleu.png") !!}' alt="Logo de l'escouade" style="height:250px; display: block; margin-left:auto; margin-right: auto; "> --}}
    </div>
    @if($MCuserexist->msg)
        <div class="p-2 mt-3">
            <h5>Votre demande est en cours de traitement. Vous recevrez un mail lorsque votre pourrez vous connecter.</h5>
        </div>
        <div class="p-2">
            <a href="{{ route('home.index') }}" class="btn btn-outline-dark">Retour</a>
        </div>
    @else
        <form method="post" action="{{ route('login.newMdcLogin', ['MCuserexist' => $MCuserexist]) }}">
            <div class="p-2 mt-3">
                Votre compte doit être validé par un administrateur.<br> 
                <b>Merci de décrire la raison de votre connexion et de valider l'envoi.</b><br>
                Vous recevrez un mail lorsque votre pourrez vous connecter.<br>
            </div>
            @csrf
            <div class="p-2 mt-3">
                    <textarea class="form-control" name="comment_mdconnect"></textarea>
            </div>
            <div class="p-2">
                <button class="btn btn-primary" type="submit">Envoyer</button>
                <a href="{{ route('login.show') }}" class="btn btn-outline-dark">Annuler</a>
            </div>
        </form>
    @endif
</div>

@endsection