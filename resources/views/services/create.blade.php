@extends('layouts.app-master')
@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')

    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Création d'un service </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        <x-form::form method="POST" :action="route('services.store')">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='service_libcourt' class='col-sm-5 col-form-label'>Libell&eacute; court*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='service_libcourt' id='service_libcourt' placeholder='Libell&eacute; court' value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='service_liblong' class='col-sm-5 col-form-label'>Libell&eacute; long*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='service_liblong' id='service_liblong' placeholder='Libell&eacute; long' value="" >
                    </div>
                </div>
                <div class='form-group row'>
                    <label for='groupement_libcourt' class='col-sm-5 col-form-label'>Libellé court du groupement*</label>
                    <div class='col-sm-5'>
                        <select class='form-control' name='groupement_libcourt' id='groupement_libcourt'>
                            @foreach ($groupement as $groupements)
                            <option value='{{$groupements->groupement_libcourt}}'>{{$groupements->groupement_libcourt}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btncreatlien' name='btncreatlien'>Créer</button>
                    <a href="{{ route('services.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        </x-form::form>
    </div>
 


@endsection