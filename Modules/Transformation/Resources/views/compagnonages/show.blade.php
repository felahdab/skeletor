@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Compagnonnages</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Consultation compagnonnage </div>
        <div style='text-align:right;'>&nbsp;</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='comp[comp_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control'  name='comp[comp_libcourt]' id='comp[comp_libcourt]' placeholder='Libell&eacute; court' value="{{ $compagnonage->comp_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='comp[comp_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' name='comp[comp_liblong]' id='comp[comp_liblong]' placeholder='Libell&eacute; long' value="{{ $compagnonage->comp_liblong }}" >
                </div>
            </div>
            <div>
                @can('transformation::compagnonages.edit')
                <a href="{{ route('transformation::compagnonages.edit', $compagnonage) }}" class="btn btn-primary mt-4">Modifier</a>
                @endcan
                <a href="{{ route('transformation::compagnonages.index') }}" class="btn btn-outline-dark mt-4">Retour</a>
                <br>&nbsp;
            </div>
            <div style='text-align:right;'>
                <ul  class='navbar-nav mr-auto' >
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Fonction(s) associée(s)</a>
                        <div class='dropdown-menu'>
                            @foreach ($compagnonage->fonctions()->get() as $fonction)
                                <a class="dropdown-item" href="{{ route('transformation::fonctions.show', $fonction->id) }}">{{ $fonction->fonction_libcourt }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class='card ml-3 w-100' >
        <div class='card-header ml-n3 mr-n4 mb-3' ><b>Tâche(s) associ&eacute;e(s)</b></div>
        <input type='hidden' name='compagnonage_id' id='compagnonage_id'  value='{{ $compagnonage->id }}'>
        
        @foreach ($compagnonage->taches()->get() as $tache)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row mb-1 justify-content-between">
                        <div class="p-2 h4 w-50" >{{ $tache->tache_liblong }}</div>
                        <div class="p-2 w-50"> => {{ $tache->tache_libcourt }} </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    </div>
@endsection