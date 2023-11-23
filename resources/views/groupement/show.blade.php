@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Groupement : {{ $groupement->groupement_liblong }}</h2>
    </div>
    
    <div id='divafficheobj' class='card ml-3 w-100'>
        <div class='card-header'>Information du groupement</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row'>
                <label for='groupement_libcourt' class='col-sm-5 col-form-label'>Libell&eacute; court</label>
                <div class='col-sm-7'>
                    <p class='form-control-static'>{{ $groupement->groupement_libcourt }}</p>
                </div>
            </div>
            <div class='form-group row'>
                <label for='groupement_liblong' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-7'>
                    <p class='form-control-static'>{{ $groupement->groupement_liblong }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('groupement.edit', $groupement->id) }}" class='btn btn-primary mt-4'>Mettre à jour</a>
                <a href="{{ route('groupement.index') }}" class='btn btn-default mt-4'>Annuler</a>
            </div>
        </div>
    </div>
@endsection