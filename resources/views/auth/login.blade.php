@extends('layouts.app-master')

@section('helplink')
  < x-help-link page="connexion"/>
@endsection

@section('content')
    <div class="d-flex justify-content-center mt-5 ">
        <div class="card w-50 justify-content-center" >
            <div class="w-100 text-center mt-3">
                <div class="mb-1"><h4><b>LOGIN Automatique/DR-CPT</b></h4></div>
                <a href="{{ route('keycloak.login.redirect') }}" class="btn btn-light w-50" >
                    <div class="card">
                        <div class="row g-0">
                          <div class="col-md-4 p-2" >
                            <img src='{!! asset("assets/images/MDC_intradef.png") !!}' alt="Logo MDconnect" style="width:70px">
                          </div>
                          <div class="col-md-8 border-start d-flex align-items-center">
                                <div class="card-body ">
                                    Se connecter
                                </div>
                          </div>
                        </div>
                      </div>
                </a>
            </div>
            <div class="w-100 text-center mt-5 mb-5">
              <div class="w-100" style="display: flex; justify-content: center; align-items: center;">
                    <div style="width: 40%; height: 1px; background-color:lightgrey"></div>
                    <span class="mx-3"><b>OU</b></span>
                    <div style="width: 40%; height: 1px; background-color:lightgrey"></div>
                </div>
            </div>
            <div class="w-100 text-center mb-3">
                <h4><b>LOGIN LOCAL</b></h4>
                <span style="font-size: small;">Saisissez votre adresse mail <b>complète</b> et le mot de passe défini dans l'application.</span>
                <form method="post" action="{{ route('login.perform') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="m-3 d-flex justify-content-center">
                        <input dusk="login-email" type="text" class="form-control w-75" name="email" value="{{ old('email') }}" placeholder="Email" required="required" autofocus>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="m-3 d-flex justify-content-center">
                        <input dusk="login-password" type="password" class="form-control w-75" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>        
                    <button dusk="login-button" class=" w-25 btn btn-primary m-3" type="submit">Se connecter</button>
                </form>
            </div>
        </div>
    </div>


@endsection