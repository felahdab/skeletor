@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>SUIVI TRANSFORMATION </h2>
        
        @if (auth()->user()->secteur_id != 0)
            <div class="lead">
        @if (auth()->user()->hasRole("em"))
                Liste des marins en transformation par entité
        @else
                Liste des marins en transformation dans le service {{ $currentuser->displayService() }}
        @endif
            </div>
            <div style="text-align: right;">
                Cliquez sur un marin pour afficher son livret de transformation
            </div>
            <div class="mt-3">
                <livewire:stattuteur-table>
            </div>        
        @else
            <div class="lead">
                Vous n'êtes pas rattaché à un service !!!
            </div>
        @endif
    </div>
@endsection