@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages - Visualisation des stages et des marins concernés</h2>
    </div>
    
    <div id='divconsultstage' class='card bg-light ml-3 w-100'>
        <div class='card-header'>Consultation des stages pour {{$marin->displayString()}}
        </div>
        
        
        @if ( $marin != null)
        <div class='mt-2 mb-2'> 
            <a href="{{ route('transformation.livret', $marin->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
            <a href="{{ route('transformation.progression', $marin->id) }}" class="btn btn-primary btn-sm">Progression</a>
            <a href="{{ route('transformation.fichebilan', $marin->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
            <a href="{{ route('users.stages', $marin->id) }}" class="btn btn-danger btn-sm">Stages</a>
            <a href="{{ route('transformation.index') }}" class="btn btn-default btn-sm">Annuler</a>
       </div>
        <div class='mt-2 mb-2' style='margin-left:50%; text-align: center;'> </div>
        <div class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des stages en attente pour le {{$marin->displayString()}}</div>
            <div class='card-body'>
                @foreach ($marin->stages()->get() as $stageenattente)
                    @if (! $marin->aValideLeStage($stageenattente))
                    <div class='mt-3'><a href='{{route("stages.show", $stageenattente->id)}}'>{{ $stageenattente->stage_libcourt }}</a></div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class='card border-primary mb-3'>
            <div class='card-header text-primary'>Liste des stages valid&eacute;s pour {{$marin->displayString()}}</div>
            <div class='card-body'>
                @foreach ($marin->stages()->get() as $stageenattente)
                    @if ( $marin->aValideLeStage($stageenattente))
                    <div class='mt-3'><a href='{{route("stages.show", $stageenattente->id)}}'>{{ $stageenattente->stage_libcourt }}</a></div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
    {!! link_to_route('transformation.index', 'Annuler', [], ['class' => 'btn btn-primary']) !!}
@endsection