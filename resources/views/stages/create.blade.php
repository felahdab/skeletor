@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Ajouter un stage</h2>
    </div>
    <div id='divmodifobj' class='card   ml-3 w-100' >
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
                        value="" required>
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
                        value="" required>
                    </div>
                </div>
                @if (false)
                <div class='form-group row' >
                    <label for='stage[transverse]' class='col-sm-5 col-form-label'>Transverse</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='stage[transverse]' id='stage[transverse]'> 
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label for="stage[typelicence_id]" class="col-sm-5 col-form-label">Type de licence *</label>
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
                <div class="form-group row">
                    <label for="stage[stage_date_fin_licence]" class="col-sm-5 col-form-label">Date de fin de licence</label>
                    <div class='col-sm-5'>
                        <input type="date" 
                            class="form-control" 
                            name="stage[stage_date_fin_licence]" 
                            placeholder="Date fin licence" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_capamax]' class='col-sm-5 col-form-label'>Capacité maximum</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='stage[stage_capamax]' 
                        id='stage[stage_capamax]' 
                        placeholder='Capacité maximum' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_duree]' class='col-sm-5 col-form-label'>Durée (j)</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='stage[stage_duree]' 
                        id='stage[stage_duree]' 
                        placeholder='Durée' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[duree_validite]' class='col-sm-5 col-form-label'>Durée de validité (mois)</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='stage[duree_validite]' 
                        id='stage[duree_validite]' 
                        placeholder='Durée de validité' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_lieu]' class='col-sm-5 col-form-label'>Lieu</label>
                    <div class='col-sm-5'>
                        <input type='text' 
                        class='form-control' 
                        name='stage[stage_lieu]' 
                        id='stage[stage_lieu]' 
                        placeholder='Lieu' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_commentaire]' class='col-sm-5 col-form-label'>Commentaire</label>
                    <div class='col-sm-5'>
                        <textarea class="form-control" 
                                rows='5' 
                                name='stage[stage_commentaire]' 
                                id='stage[stage_commentaire]' 
                                placeholder='Commentaire'></textarea>
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