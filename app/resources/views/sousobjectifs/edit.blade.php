@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Sous-Objectifs</h2>
        <div class="lead">
            Gérer les sous objectifs.
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
		{!! Form::open(['method' => 'PATCH','route' => ['sousobjectifs.update', $sousobjectif->id] ]) !!}
		
		{!! Form::close() !!}

    </div>
@endsection