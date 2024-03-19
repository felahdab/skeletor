@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Tâches</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Consultation tâche </div>
        <div style='text-align:right;'>&nbsp;</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control'  name='tache[tache_libcourt]' id='tache[tache_libcourt]' placeholder='Libell&eacute; court' value="{{ $tache->tache_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' name='tache[tache_liblong]' id='tache[tache_liblong]' placeholder='Libell&eacute; long' value="{{ $tache->tache_liblong }}" >
                </div>
            </div>
            <div>
                @can('transformation::taches.edit')
                <a href="{{ route('transformation::taches.edit', $tache) }}" class="btn btn-primary mt-4">Modifier</a>
                @endcan
                <a href="{{ route('transformation::taches.index') }}" class="btn btn-outline-dark mt-4">Retour</a>
                <br>&nbsp;
            </div>
            <div style='text-align:right;'>
                <ul  class='navbar-nav mr-auto' >
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Compagnonnage(s) associé(s)</a>
                        <div class='dropdown-menu'>
                            @foreach ($tache->compagnonages()->get() as $comp)
                                <a class="dropdown-item" href="{{ route('transformation::compagnonages.show', $comp->id) }}">{{ $comp->comp_libcourt }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class='card ml-3 w-100'>
        <div class='card-header ml-n3 mr-n4 mb-3' ><b>Objectif(s) associ&eacute;(s)</b></div>
        <input type='hidden' name='tache_id' id='tache_id'  value='{{ $tache->id }}'>
        @foreach ($tache->objectifs()->get() as $objectif)
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row mb-1 justify-content-between">
                        <div class="p-2 h4 w-50" >{{ $objectif->objectif_libcourt }}</div>
                        <div class="p-2 w-50"> => {{ $objectif->objectif_liblong }} </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection