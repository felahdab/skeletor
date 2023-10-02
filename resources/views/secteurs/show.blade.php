@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Secteurs : {{ $secteur->secteur_liblong }}</h2>
    </div>
    
    <div id='divafficheobj' class='card ml-3 w-100'>
        <div class='card-header'>Information du secteur</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row'>
                <label for='secteur_libcourt' class='col-sm-5 col-form-label'>Libell&eacute; court</label>
                <div class='col-sm-7'>
                    <p class='form-control-static'>{{ $secteur->secteur_libcourt }}</p>
                </div>
            </div>
            <div class='form-group row'>
                <label for='secteur_liblong' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-7'>
                    <p class='form-control-static'>{{ $secteur->secteur_liblong }}</p>
                </div>
            </div>
            <div class='form-group row'>
                <label for='service_libcourt' class='col-sm-5 col-form-label'>Libellé court du service</label>
                <div class='col-sm-7'>
                    <p class='form-control-static'>{{ $service->service_libcourt }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('secteurs.edit', $secteur->id) }}" class='btn btn-primary mt-4'>Modifier</a>
                <a href="{{ route('secteurs.index') }}" class='btn btn-default mt-4'>Annuler</a>
            </div>
        </div>
    </div>
@endsection