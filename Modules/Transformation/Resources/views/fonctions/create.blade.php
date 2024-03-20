@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Fonctions</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Création fonction </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        <x-form::form method="POST" :action="route('transformation::fonctions.store')">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='fonction[fonction_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='100' class='form-control'  name='fonction[fonction_libcourt]' id='fonction[fonction_libcourt]' placeholder='Libell&eacute; court' value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction[fonction_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='256' class='form-control' name='fonction[fonction_liblong]' id='fonction[fonction_liblong]' placeholder='Libell&eacute; long' value="" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="fonction[typefonction_id]" class="col-sm-5 col-form-label">Type de fonction *</label>
                    <div class='col-sm-5'>
                        <select class="form-control" 
                            name="fonction[typefonction_id]" required>                        
                            @foreach($typefonctions as $typefonction)
                                <option value="{{ $typefonction->id }}" >
                                    {{ $typefonction->typfonction_libcourt }}
                                    {{ $typefonction->id == 1
                                        ? ' (par défaut)'
                                        : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction_lache' class='col-sm-5 col-form-label'>Lâcher</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='fonction[fonction_lache]' id='fonction[fonction_lache]'> 
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='fonction_double' class='col-sm-5 col-form-label'>Double</label>
                    <div class='col-sm-5'>
                        <input type='checkbox'name='fonction[fonction_double]' id='fonction[fonction_double]'> 
                    </div>
                </div>                
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
                    <a href="{{ route('transformation::fonctions.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        </x-form::form> 

        </div>
@endsection