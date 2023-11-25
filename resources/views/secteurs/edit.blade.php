@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Secteurs</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification d'un secteur </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        <x-form::form method="PATCH" :action="route('secteurs.update' , $secteur->id)">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='secteur_libcourt' class='col-sm-5 col-form-label'>Libell&eacute; court*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='secteur_libcourt' id='secteur_libcourt' placeholder='Libell&eacute; court' value="{{ $secteur->secteur_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='secteur_liblong' class='col-sm-5 col-form-label'>Libell&eacute; long*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='secteur_liblong' id='secteur_liblong' placeholder='Libell&eacute; long' value="{{ $secteur->secteur_liblong }}" >
                    </div>
                </div>
                <div class='form-group row'>
                    <label for='service_libcourt' class='col-sm-5 col-form-label'>Libellé court du service*</label>
                    <div class='col-sm-5'>
                        <select class='form-control' name='service_libcourt' id='service_libcourt'>
                            @foreach ($service as $services)
                            <option value='{{$services->service_libcourt}}' @if ($services->id == $secteur->service_id) selected @endif>{{$services->service_libcourt}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btncreatlien' name='btncreatlien'>Modifier</button>
                    <a href="{{ route('secteurs.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        </x-form::form>
    </div>
@endsection