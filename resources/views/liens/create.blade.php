@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Liens</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Création d'un lien </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        <x-form::form method="POST" :action="route('liens.store')">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='lib_lien' class='col-sm-5 col-form-label'> Libell&eacute; *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='lien_lib' id='lien_lib' placeholder='Libell&eacute;' value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='url_lien' class='col-sm-5 col-form-label'>URL *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='lien_url' id='lien_url' placeholder='URL' value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='image_lien' class='col-sm-5 col-form-label'>Logo (100 Ko max) *</label>
                    <div class='col-sm-5'>
                        <input type='file' class='form-control' name='lien_image' id='lien_image' accept='.jpg, .jpeg, .png'>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btncreatlien' name='btncreatlien'>Créer</button>
                    <a href="{{ route('liens.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        </x-form::form>
    </div>
@endsection