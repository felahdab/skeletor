@extends('layouts.app-master')

@section('helplink')
< x-help-link page="statistiques"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>SUIVI TRANSFORMATION </h2>
        
        @if (auth()->user()->secteur_id != 0)
            <div class="lead">
                @if (auth()->user()->hasRole("em"))
                        Liste des marins en transformation par entité
                @else
                        Liste des marins en transformation dans le service {{ $currentuser->displayService() }}
                @endif
            </div>
            <div style ="border-left: 5px solid purple !important"><small> &nbsp;Le marin n'a pas encore embarqué.</small></div>
            <div class="mt-3">
            @if (isset($service))
                @livewire('transformation::stattuteur-table', ['service' => $service ])
            @else
                @livewire('transformation::stattuteur-table')
            @endif
            </div>        
        @else
            <div class="lead">
                Vous n'êtes pas rattaché à un service !!!
            </div>
        @endif
    </div>
@endsection