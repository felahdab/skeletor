@extends('layouts.app-master')

@section('helplink')
< x-help-link page="transformation"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Suivi de la progression de {{$user->prenom}} {{$user->name}}
        </div>
        @if($mode !="proposition")
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
        @if ($user->en_transformation)
        <div id='progression' style='width:100%;'>
            @include('transformation::transformation.progression.global')
            @foreach($user->getTransformationManager()->parcours as $fonction)
                @include('transformation::transformation.progression.fonction')
            @endforeach
        </div>
        @endif
    
@endsection