@extends('layouts.app-master')

@section('helplink')
<x-help-link page="administration"/>
@endsection

@section('content')
<div id='divmodifobj' class='card ml-3 w-100' >
    <div class='card-header' >Création d'un groupement </div>
    <div style='text-align:right;'>* champs obligatoires </div>
    {!! Form::open(['method' => 'POST','route' => 'groupement.store', 'enctype'=>'multipart/form-data' ]) !!}
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='groupement_libcourt' class='col-sm-5 col-form-label'>Libell&eacute court *</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='groupement_libcourt' id='groupement_libcourt' placeholder='Libell&eacute court' value="" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='groupement_liblong' class='col-sm-5 col-form-label'>Libell&eacute long *</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='groupement_liblong' id='groupement_liblong' placeholder='Libell&eacute long' value="" >
                </div>
            </div>
            <div>
                <button class='btn btn-primary mt-4' type='submit' id='btncreatgroupement' name='btncreatgroupement'>Créer</button>
                <a href="{{ route('groupement.index') }}" class="btn btn-default mt-4">Annuler</a>
                <br>&nbsp;
            </div>
        </div>
    {!! Form::close() !!}
</div>
@endsection

