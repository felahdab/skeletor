@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection

@section('after_styles')
    @include('layouts.partials.sortable')
@endsection

@section('content')
    <div class="p-4 rounded">
        <h2>Fonctions</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification fonction </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        <x-form::form method="PATCH" :action="route('transformation::fonctions.update',   $fonction )">
        <input type='hidden' id='fonction[id]' name='fonction[id]' value='{{ $fonction->id }}'>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                <div class='col-sm-5'>
                    <input dusk="input-libcourt" type='text' maxlength='100' class='form-control'  name='fonction[fonction_libcourt]' id='fonction[fonction_libcourt]' placeholder='Libell&eacute; court' value="{{ $fonction->fonction_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction[fonction_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                <div class='col-sm-5'>
                    <input type='text' maxlength='256' class='form-control' name='fonction[fonction_liblong]' id='fonction[fonction_liblong]' placeholder='Libell&eacute; long' value="{{ $fonction->fonction_liblong }}" >
                </div>
            </div>
            <div class="form-group row">
                <label for="typefonction_id" class="col-sm-5 col-form-label">Type de fonction *</label>
                <div class='col-sm-5'>
                    <select class="form-control" 
                        name="fonction[typefonction_id]" required>
                        <option value="0">Type de fonction</option>
                        @foreach($typefonctions as $typefonction)
                            <option value="{{ $typefonction->id }}" {{ $fonction->typefonction_id == $typefonction->id
                                    ? ' selected'
                                    : '' }}>
                                {{ $typefonction->typfonction_libcourt }}
                                {{ $fonction->typefonction_id == $typefonction->id
                                    ? ' (type actuel)'
                                    : '' }}  </option>
                        @endforeach
                    </select>
                    @if ($errors->has('grade'))
                        <span class="text-danger text-left">{{ $errors->first('grade') }}</span>
                    @endif
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction_lache' class='col-sm-5 col-form-label'>Lâcher</label>
                <div class='col-sm-5'>
                    <input type='checkbox'name='fonction[fonction_lache]' id='fonction[fonction_lache]' {{ $fonction->fonction_lache
                                        ? ' checked'
                                        : '' }}> 
                </div>
            </div>
            <div class='form-group row' >
                <label for='fonction_double' class='col-sm-5 col-form-label'>Double</label>
                <div class='col-sm-5'>
                    <input type='checkbox'name='fonction[fonction_double]' id='fonction[fonction_double]' {{ $fonction->fonction_double
                                        ? ' checked'
                                        : '' }}> 
                </div>
            </div>
            <div>
                <button class='btn btn-primary mt-4' dusk="enregistrer_fonction" type='submit'>Enregistrer</button>
                <a href="{{ route('transformation::fonctions.index') }}" class="btn btn-outline-dark mt-4">Annuler</a>
                <br>&nbsp;
            </div>
        </div>

        <div class='card ml-3 w-100' >
            <div class='card-header ml-n3 mr-n4 mb-3' ><b>Compagnonnage(s) associ&eacute;(s) </b><span style="font-size:x-small;">(Glissez/déplacez les compagnonnages puis enregistrez pour modifier leur ordre d'affichage dans l'application)</span></div>
            <input type='hidden' name='fonction_id' id='fonction_id'  value='{{ $fonction->id }}'>
            <x-sortable name="sort_order">
                @foreach ($fonction->compagnonages->sortBy('pivot.ordre') as $compagnonage)
                    <x-sortable-item sort_key="{{ $compagnonage->id }}">
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="myhandle btn btn-default"><x-bootstrap-icon iconname='arrows-move.svg' /></div>
                                <div class="d-flex flex-row mb-1 justify-content-between">
                                    <div class="p-2 h4 w-50" >{{ $compagnonage->comp_liblong }}</div>
                                    <div class="p-2 w-25"> => {{ $compagnonage->comp_libcourt }} </div>
                                    <div class="p-2 w-25 text-end">
                                    @can("transformation::fonctions.removecompagnonage")
                                        <button dusk="retirer-comp" type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('removecompagnonage[{{ $compagnonage->id }}]').submit()">Retirer ce compagnonnage</button>
                                    @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-sortable-item>
                @endforeach
            </x-sortable>
            @can("transformation::fonctions.choisircompagnonage")
                <div class='text-center mt-1 mb-1'>
                    <a dusk="ajouter_compagnonnage" class='btn btn-primary btn-sm' href="{{route('transformation::fonctions.choisircompagnonage', $fonction->id)}}">Ajouter un nouveau compagnonnage</a>
                </div>
            @endcan
        </div>
        </x-form::form>

        @can("transformation::fonctions.removecompagnonage")
            @foreach ($fonction->compagnonages->sortBy('pivot.ordre') as $compagnonage)
                <form method="POST" action="{{ route('transformation::fonctions.removecompagnonage', [$fonction , $compagnonage]) }}" id="removecompagnonage[{{ $compagnonage->id }}]">
                    @csrf
                </form>
            @endforeach
        @endcan

        <div class='card ml-3 w-100' >
            <div class='card-header ml-n3 mr-n4 mb-3' ><b>Stage(s) associ&eacute;(s)</b></div>
            <input type='hidden' name='fonction_id' id='fonction_id'  value='{{ $fonction->id }}'>
            @foreach ($fonction->stages()->get() as $stage)
                <div class="card m-1">
                    <div class="card-body">
                        <div class="d-flex flex-row mb-1 justify-content-between">
                            <div class="p-2 h4 w-50">{{ $stage->stage_libcourt}}</div>
                            <div class="p-2 w-25">=> {{ $stage->stage_liblong}}</div>
                            <div class="p-2 w-25 text-end">
                                @can("transformation::fonctions.removestage")
                                <x-form::form method="POST" :action="route('transformation::fonctions.removestage',  [ $fonction , $stage ])">
                                    <button dusk="retirer_stage" class="btn btn-danger btn-sm" type="submit">Retirer ce stage</button>
                                </x-form::form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @can("transformation::fonctions.choisirstage")
            <div class='text-center mb-1 mt-1'>
                <a dusk="ajouter_stage" class="btn btn-primary btn-sm" href="{{ route('transformation::fonctions.choisirstage', $fonction)}}">Ajouter un nouveau stage</a>
            </div>
            @endcan
        </div>
    </div>
@endsection