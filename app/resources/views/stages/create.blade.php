@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Création d'un stage </div>
		<div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'POST','route' => 'stages.store' ]) !!}
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='stage[stage_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control'  
                        name='stage[stage_libcourt]' 
                        id='stage[stage_libcourt]' 
                        placeholder='Libell&eacute; court' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='stage[stage_liblong]' 
                        id='stage[stage_liblong]' 
                        placeholder='Libell&eacute; long' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[transverse]' class='col-sm-5 col-form-label'>Transverse</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='stage[transverse]' id='stage[transverse]'> 
                    </div>
                </div>
                <div class="form-group row">
                    <label for="stage[typelicence_id]" class="col-sm-5 col-form-label">Type de licence</label>
                    <div class='col-sm-5'>
                        <select class="form-control" 
                            name="stage[typelicence_id]" required>
                            @foreach($typelicences as $typelicence)
                                <option value="{{ $typelicence->id }}" {{ $typelicence->id == 4
                                        ? ' selected'
                                        : '' }}>
                                    {{ $typelicence->typlicense_libcourt }}
                                    {{ $typelicence->id == 4
                                        ? ' (par défaut)'
                                        : '' }}  </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
                    <a href="{{ route('stages.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection