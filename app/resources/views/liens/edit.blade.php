@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Liens</h2>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Modification d'un lien </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['liens.update' , $lien->id] ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='lib_lien' class='col-sm-5 col-form-label'> Libell&eacute; *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='lien[lien_lib]' id='tache[lien_lib]' placeholder='Libell&eacute;' value="{{ $lien->lien_lib }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='url_lien' class='col-sm-5 col-form-label'>URL *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='lien[lien_url]' id='lien[lien_url]' placeholder='URL' value="{{ $lien->lien_url }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='image_lien' class='col-sm-5 col-form-label'>Logo (100 Ko max) </label>
                    <div class='col-sm-5'>
                        <input type='file' class='form-control' name='lien[lien_image]' id='lien[lien_image]' accept='.jpg, .jpeg, .png' for="{{ $lien->lien_image }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='image_lien' class='col-sm-5 col-form-label'>Logo actuel</label>
                    <div class='col-sm-5 mt-2'>
                        <img src="{!! asset($lien->lien_image) !!}" alt="logo" style="height: 30px;">
                    </div>
                </div>
                <div class='form-group row' >
                    
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btncreatlien' name='btncreatlien'>Modifier</button>
                    <a href="{{ route('liens.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection