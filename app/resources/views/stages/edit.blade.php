@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Modification d'un stage </div>
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
                    <label for='stage[stage_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='stage[stage_liblong]' id='stage[stage_liblong]' placeholder='Libell&eacute; long' value="{{ $stage->stage_liblong }}" >
                    </div>
                </div>
				<div class='form-group row' >
                    <label for='stage[transverse]' class='col-sm-5 col-form-label'>Transverse</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='stage[transverse]' id='stage[transverse]' {{ $stage->transverse
                                            ? ' checked'
                                            : '' }}> 
                    </div>
                </div>
                <div class="mb-3">
                    <label for="stage[typelicence_id]" class="form-label">Type de licence</label>
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
                <div>
                    <button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection