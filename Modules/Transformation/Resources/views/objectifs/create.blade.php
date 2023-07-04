@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Objectifs</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Création objectif </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'POST','route' => 'transformation::objectifs.store' ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='100'
                        class='form-control'  
                        name='objectif[objectif_libcourt]' 
                        id='objectif[objectif_libcourt]' 
                        placeholder='Libell&eacute; court' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='256'
                        class='form-control' 
                        name='objectif[objectif_liblong]' 
                        id='objectif[objectif_liblong]' 
                        placeholder='Libell&eacute; long' 
                        value="" >
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
                    <a href="{{ route('transformation::objectifs.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection