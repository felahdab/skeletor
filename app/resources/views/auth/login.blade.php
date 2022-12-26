@extends('layouts.app-master')


@section('content')
    <div>
        <img src='{!! asset("assets/images/InsigneEscouade.jpg") !!}' alt="Logo de l'escouade" style="height:450px; display: block; margin-left:auto; margin-right: auto; ">
    </div>
    <div class="bg-light p-4 rounded" style="max-width: 400px; margin-left:auto; margin-right: auto;">
    <form method="post" action="{{ route('login.perform') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="mb-3">
            <input dusk="login-email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required="required" autofocus>
            @if ($errors->has('username'))
                <span class="text-danger text-left">{{ $errors->first('username') }}</span>
            @endif
        </div>
        
        <div class="mb-3">
            <input  dusk="login-password" type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
            @if ($errors->has('password'))
                <span class="text-danger text-left">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <button  dusk="login-button" class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
        
    </form>
    </div>
@endsection