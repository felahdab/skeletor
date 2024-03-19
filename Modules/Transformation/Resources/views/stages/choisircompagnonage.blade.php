@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Fonctions</h2>
        {{-- <div class='lead'>Ajout d'un compagnonage pour la fonction {!!$fonction->fonction_libcourt !!} </div>
    </div>
    <x-form::form method="GET" :action="route(request()->route()->getName(), $fonction->id)">
        <x-form::input name='filter' type='text' placeholder={{ $filter }}>
        <button type='submit' class='btn btn-primary btn-sm'>Filtrer</button>
    </x-form::form>
    <div id='divmodifobj' class='card   ml-3 w-100' >
        <div class='card-header' > Ajout d'un compagnonage </div>
        <x-form::form method="POST" :action="route('transformation::fonctions.ajoutercompagnonage', $fonction->id)">
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Tache</label>
                <div>
                    <select name='compagnonage_id' id='compagnonage_id' class='custom-select  w-50'>
                        @foreach ($compagnonages as $compagnonage)
                            <option value='{{ $compagnonage->id }}' > {{ $compagnonage->comp_libcourt }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
                <div>
                    <button class='btn btn-primary w-100 mt-4' type='submit'>Ajouter</button>
                    <br>&nbsp;
                </div>
            </div>
        </x-form::form>

    </div>
@endsection