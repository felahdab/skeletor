@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Consulter stage </div>
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
                <div class='form-group row' >
                    <label for='stage[typelicence]' class='col-sm-5 col-form-label'>Type de licence</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='stage[typelicence]' id='stage[typelicence]' placeholder='Type de licence' value="{{ $stage->type_licence()->get()->first()->typlicense_libcourt }}" >
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection