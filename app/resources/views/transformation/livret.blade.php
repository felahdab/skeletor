@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="transformation"/>
@endsection


@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Livret de transformation de {{$user->display_name}}
        </div>
        
        @if($readwrite)
            <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            @can('users.stages')
                <a href="{{ route('users.stages', $user->id) }}" class="btn btn-danger btn-sm">Stages</a>
            @endcan
            <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">Annuler</a>
        @else
            <a href="{{ route('transformation.monlivret') }}" class="btn btn-warning btn-sm">Mon livret de transformation</a>
            <a href="{{ route('transformation.maprogression') }}" class="btn btn-primary btn-sm">Ma progression</a>
            <a href="{{ route('transformation.mafichebilan') }}" class="btn btn-secondary btn-sm">Ma fiche bilan</a>
        @endif
        

        @livewire('livret-transformation', ['mode' => "unique", 
                                            'user' => $user, 
                                            'readwrite' => $readwrite])
        
        
    </div>
@endsection