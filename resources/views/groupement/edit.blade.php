@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Groupement</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification d'un groupement </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['groupement.update' , $groupement->id], 'enctype'=>'multipart/form-data' ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='groupement_libcourt' class='col-sm-5 col-form-label'>Libell&eacute; court*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='groupement_libcourt' id='groupement_libcourt' placeholder='Libell&eacute; court' value="{{ $groupement->groupement_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='groupement_liblong' class='col-sm-5 col-form-label'>Libell&eacute; long*</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='groupement_liblong' id='groupement_liblong' placeholder='Libell&eacute; long' value="{{ $groupement->groupement_liblong }}" >
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btncreatgroupement' name='btncreatgroupement'>Modifier</button>
                    <a href="{{ route('groupement.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection