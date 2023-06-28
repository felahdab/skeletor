@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded h2">
        Fonctions
    </div>
    <div class='card ml-3 w-100' >
        <div class='card-header' >Consulter fonction </div>
        <div style='text-align:right;'>&nbsp;</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' value="{{ $fonction->fonction_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' value="{{ $fonction->fonction_liblong }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction[typefonction_id]' class='col-sm-5 col-form-label'>Type de fonction</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' value="{{ $fonction->type_fonction()->get()->first()->typfonction_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction_lache' class='col-sm-5 col-form-label'>Lâcher</label>
                <div class='col-sm-5'>
                    <input disabled type='checkbox' {{ $fonction->fonction_lache
                                        ? ' checked'
                                        : '' }}> 
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction_double' class='col-sm-5 col-form-label'>Double</label>
                <div class='col-sm-5'>
                    <input disabled type='checkbox' {{ $fonction->fonction_double
                                        ? ' checked'
                                        : '' }}> 
                </div>
            </div>
            <input type='hidden' name='fonction_id' id='fonction_id'  value='{{ $fonction->id }}'>
        </div>
        <div>
            @can('transformation::fonctions.edit')
                <a href="{{ route('transformation::fonctions.edit', $fonction) }}" class="btn btn-primary mt-4 mx-1">Modifier</a>
            @endcan
            <a href="{{ route('transformation::fonctions.index') }}" class="btn btn-outline-dark mt-4  mx-1">Retour</a>
            <br>&nbsp;
        </div>
    </div>
    <div class='card ml-3 w-100' >
        <div class='card-header mb-3'><b>Compagnonnage(s) associ&eacute;(s)</b></div>
        @foreach ($fonction->compagnonages()->get() as $compagnonage)
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row mb-1">
                    <div class="p-2 h4 w-50">{{ $compagnonage->comp_liblong }}</div>
                    <div class="p-2 w-50"> => {{ $compagnonage->comp_libcourt }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class='card ml-3 w-100' >
        <div class='card-header mb-3'><b>Stage(s) associ&eacute;(s)</b></div>
        @foreach ($fonction->stages()->get() as $stage)
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row mb-1">
                    <div class="p-2 h4 w-50">{{ $stage->stage_libcourt  }}</div>
                    <div class="p-2 w-50"> => {{ $stage->stage_liblong }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection