@extends('layouts.app-master')

@section('helplink')
  <x-help-link page="connexion"/>
@endsection

@section('content')
<div class="p-4 rounded">
    
    <h1>Réinitialiser le mot de passe</h1>
    <div class="lead">
       Tapez votre nouveau mot de passe :  
    </div><div class="container mt-4">
	<form method="post" action="{{ route('login.updatepwd') }}">
		@csrf
        <input type="hidden" name="token" value="{{ $token }}">
		<div class="form-group form-floating mb-3">
            <input  type="hidden" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email }}">
            <label for="floatingPassword">Email</label>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group form-floating mb-3">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            <label for="floatingPassword">mot de passe</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group form-floating mb-3">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            <label for="floatingPassword">Confirmer mot de passe</label>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

		<button type="submit" class="btn btn-primary">Réinitialiser</button>
	</form>
</div>
</div>
@endsection
