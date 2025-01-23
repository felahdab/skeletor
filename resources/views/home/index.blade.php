@extends('layouts.app-master')

@section('content')
    {{-- @if (auth()->user())
 
        <div>
            <h1 class="mt-5 text-center">Bienvenue !</h1><br><hr>
        </div>    
    @endif --}}
    <div class="w-100">
        <div class="w-100 mt-5 text-center">
            <h1>{{config('app.name')}}</h1>
        </div>
        <div class="w-100 mt-5 text-center">
           <img src='{!! asset("public/images/".$logo) !!}' alt="Logo" style="height:400px; display: block; margin-left:auto; margin-right: auto; ">
        </div>
        <div class="w-100 mt-5 mb-5 text-center h5">
            {{$texte}}
        </div>
        <div class="w-100 mt-5 d-flex justify-content-between">
            <div style="font-size: smaller;">&#9786;Skeletor&#xAE;</div>
            <div style="font-size: smaller;">Version : {{env('APP_VERSION')}}</div>
        </div>
    </div>
@endsection

            
