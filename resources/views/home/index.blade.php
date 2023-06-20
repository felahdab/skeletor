@extends('layouts.app-master')

@section('content')
    @if (auth()->user())
 
        <div>
            <h1 class="mt-5 text-center">Bienvenue sur Skeletor !</h1><br><hr>
        </div>    
    @endif
@endsection

            
