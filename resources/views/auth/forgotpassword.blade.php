@extends('layouts.app-master')

@section('helplink')
  <x-help-link page="connexion"/>
@endsection
@section('content')
<div class="p-4 rounded">
    <h1>Réinitialiser le mot de passe</h1>
    <div class="lead">
       Un lien va être envoyé sur votre email pour changer votre mot de passe.
    </div>
    <div class="container mt-4">
	<form method="post" action="{{ route('login.forgotpwd') }}">
		@csrf
		<div class="form-group form-floating mb-3">
            <input  dusk='email-input' id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            <label for="floatingPassword">Email</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

		<button dusk='valid-btn' type="submit" class="btn btn-primary">Envoyer</button>
	</form>
</div>
</div>
@endsection