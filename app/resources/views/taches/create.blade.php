@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Création tache </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'POST','route' => 'taches.store' ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='tache[tache_libcourt]' id='tache[tache_libcourt]' placeholder='Libell&eacute; court' value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='tache[tache_liblong]' id='tache[tache_liblong]' placeholder='Libell&eacute; long' value="" >
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection