@extends('layouts.app-master')

@section('helplink')
  < x-help-link page="connexion"/>
@endsection

@section('content')
    <div class="mt-5 mb-3">
        <img src='{!! asset("assets/images/logo_FFAST_bleu.png") !!}' alt="Logo FFAST" style="height:250px; display: block; margin-left:auto; margin-right: auto; ">
    </div>
    <div>&nbsp;</div>
    <div class="d-flex flex-row justify-content-center ">
        <div class="p-3 me-4 card w-25" style="border: 2px solid grey; padding: 5px; box-shadow: 0px 0px 10px;">
            <!-- partie mindefconnect -->
            <div class="mt-2 mb-4 text-center h5">Login Automatique/DR-CPT</div>
            <div class="text-center">
                <a href="{{ route('keycloak.login.redirect') }}" class="btn btn-light">
                    <img src='{!! asset("assets/images/MDC_intradef.png") !!}' alt="Logo MDconnect" style="height:100px; width:90px">
                </a>
            </div>
            <div class="mt-4 mb-1 text-center" style="font-size: x-small;">Cliquez sur l'image pour vous connecter automatiquement ou avec vos identifiants DR-CPT</div>
        </div>
        <div class="p-3 ms-4 card w-25" style="border: 2px solid grey; padding: 5px; box-shadow: 0px 0px 10px;">
            <div class="mt-2 mb-3 text-center h5">Login local</div>
            <!-- partie login local -->
            <form method="post" action="{{ route('login.perform') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="mb-3">
                    <input dusk="login-email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required="required" autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <input dusk="login-password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>        
                <button dusk="login-button" class="w-100 btn btn-primary" type="submit">Login</button>
            </form>
            <div class="mt-2 mb-1 text-center" style="font-size: x-small;">Saisissez votre adresse mail <b>complète</b> et le mot de passe défini dans l'application.</div>
        </div>
    </div>
@endsection