@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Modifier un stage</h2>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Modification d'un stage </div>
		<div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['stages.update', $stage->id] ]) !!}
            <input type='hidden' id='stage[id]' name='stage[id]' value='{{ $stage->id }}'>
            <div style='padding-left: 15px;'>
                                <div class='form-group row' >
                    <label for='stage[stage_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='stage[stage_libcourt]' id='stage[stage_libcourt]' placeholder='Libell&eacute; court' value="{{ $stage->stage_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='stage[stage_liblong]' id='stage[stage_liblong]' placeholder='Libell&eacute; long' value="{{ $stage->stage_liblong }}" >
                    </div>
                </div>
                @if(false)
                <div class='form-group row' >
                    <label for='stage[transverse]' class='col-sm-5 col-form-label'>Transverse</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='stage[transverse]' id='stage[transverse]' {{ $stage->transverse
                                            ? ' checked'
                                            : '' }}> 
                    </div>
                </div>
                @endif
                <div class="form-group row">
                    <label for="stage[typelicence_id]" class="col-sm-5 col-form-label">Type de licence</label>
                    <div class='col-sm-5'>
                        <select class="form-control" 
                            name="stage[typelicence_id]" required>
                            <option value="0">Type de licence</option>
                            @foreach($typelicences as $typelicence)
                                <option value="{{ $typelicence->id }}" {{ $stage->typelicence_id == $typelicence->id
                                        ? ' selected'
                                        : '' }}>
                                    {{ $typelicence->typlicense_libcourt }}
                                    {{ $stage->typelicence_id == $typelicence->id
                                        ? ' (type actuel)'
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
                            placeholder="Date fin licence" 
                            value="{{ $stage->stage_date_fin_licence }}" >
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
                        value="{{ $stage->stage_capamax }}" >
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
                        value="{{ $stage->stage_duree }}" >
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
                        value="{{ $stage->stage_lieu }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='stage[stage_commentaire]' class='col-sm-5 col-form-label'>Commentaire</label>
                    <div class='col-sm-5'>
                        <textarea class="form-control" 
                                rows='5' 
                                name='stage[stage_commentaire]' 
                                id='stage[stage_commentaire]' 
                                placeholder='Commentaire'>{{ $stage->stage_commentaire }}</textarea>
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
                    <a href="{{ route('stages.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection