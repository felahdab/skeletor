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
        <div class="p-3 me-2 card w-25" style="border: 2px solid grey; padding: 5px; box-shadow: 0px 0px 10px;">
            <!-- partie mindefconnect -->
            <div class="mt-2 mb-3 text-center h5">Authentification <br>MindefConnect</div>
            <div class="text-center">
                <a href="{{ route('keycloak.login.redirect') }}">
                    <img src='{!! asset("assets/images/MDC_intradef.png") !!}' alt="Logo MDconnect" style="height:100px; width:90px">
                </a>
            </div>
        </div>
        <div class="p-3 ms-2 card w-25" style="border: 2px solid grey; padding: 5px; box-shadow: 0px 0px 10px;">
            <!-- partie login local -->
            <form method="post" action="{{ route('login.perform') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="mb-3">
                    <input dusk="login-email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required="required" autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="mb-4">
                    <input dusk="login-password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                    @if ($errors->has('password'))
                        <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                    @endif
                </div>        
                <button dusk="login-button" class="w-100 btn btn-primary" type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection