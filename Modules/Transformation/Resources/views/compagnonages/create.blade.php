@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Compagnonnages</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Création compagnonnage </div>
        <div style='text-align:right;'>* champs obligatoires </div>
            <x-form::form method="POST" :action="route('transformation::compagnonages.store')">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='comp[comp_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text'  maxlength='100'
                        class='form-control'  
                        name='comp[comp_libcourt]' 
                        id='comp[comp_libcourt]' 
                        placeholder='Libell&eacute; court' 
                        value="" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='comp[comp_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text'  maxlength='256'
                        class='form-control' 
                        name='comp[comp_liblong]' 
                        id='comp[comp_liblong]' 
                        placeholder='Libell&eacute; long' 
                        value="" >
                    </div>
                </div>
            </div>
            <div>
                <button class='btn btn-primary ms-4 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Créer</button>
                <a href="{{ route('transformation::compagnonages.index') }}" class="btn btn-default mt-4">Annuler</a>
                <br>&nbsp;
            </div>
        </x-form::form>
    </div>
@endsection