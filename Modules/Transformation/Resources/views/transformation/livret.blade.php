@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="transformation"/>
@endsection


@section('content')
    <div class="p-4">
        <h1>Transformation</h1>
        <div class="lead">
            PPA de {{$user->display_name}}
        </div>


        @if($mode !="proposition")
            <a href="{{ route('transformation::transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">PPA du marin</a>
            <a href="{{ route('transformation::transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation::transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            @can('transformation::users.stages')
                <a href="{{ route('transformation::users.stages', $user->id) }}" class="btn btn-danger btn-sm">Stages</a>
            @endcan
            <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">Annuler</a>
        @else
            <a href="{{ route('transformation::transformation.monlivret') }}" class="btn btn-warning btn-sm">Mon PPA</a>
            <a href="{{ route('transformation::transformation.maprogression') }}" class="btn btn-primary btn-sm">Ma progression</a>
            <a href="{{ route('transformation::transformation.mafichebilan') }}" class="btn btn-secondary btn-sm">Ma fiche bilan</a>
        @endif
    
        @livewire('transformation::livret-transformation', ['mode' => $mode, 
                                            'user' => $user
                                        ])

    </div>
@endsection