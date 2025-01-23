@extends('layouts.app-master')

@section('helplink')
<x-help-link page="generalites"/>
@endsection

@section('content')
<div class="p-4 rounded">
    <h1>Changement de mot de passe pour {{ $user->name }}</h1>
    <div class="lead">
        Le mot de passe que vous enregistrez ici vous permettra d'accéder à FFAST si la connexion automatique ne fonctionne pas.
        Saisissez, dans la partie "Login local", votre identifiant (adresse mail intradef complete : prenom.nom@intradef.gouv.fr) et le mot de passe défini.
    </div><div class="container mt-4">
	<form method="post" action="{{ route('changepasswd.store', $user->id) }}">
		@csrf
		<input id="userid" name="userid" type="hidden" value="{{$user->id}}">
		<div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            <label for="floatingPassword">Password</label>
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="form-group form-floating mb-3">
            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required="required">
            <label for="floatingConfirmPassword">Confirm Password</label>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
		
		<button type="submit" class="btn btn-primary">Modifier</button>
		<a href="{{ route('home.index') }}" class="btn btn-default">Annuler</button>
	</form>
</div>
</div>
@endsection