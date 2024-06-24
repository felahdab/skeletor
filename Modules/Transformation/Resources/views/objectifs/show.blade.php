@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Savoir-faire</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Consultation savoir-faire </div>
        <div style='text-align:right;'>&nbsp;</div>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control'  name='objectif[objectif_libcourt]' id='objectif[objectif_libcourt]' placeholder='Libell&eacute; court' value="{{ $objectif->objectif_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                <div class='col-sm-5'>
                    <input disabled type='text' class='form-control' name='objectif[objectif_liblong]' id='objectif[objectif_liblong]' placeholder='Libell&eacute; long' value="{{ $objectif->objectif_liblong }}" >
                </div>
            </div>
            <div>
                @can('transformation::objectifs.edit')
                <a href="{{ route('transformation::objectifs.edit', $objectif) }}" class="btn btn-primary mt-4">Modifier</a>
                @endcan
                <a href="{{ route('transformation::objectifs.index') }}" class="btn btn-outline-dark mt-4">Retour</a>
                <br>&nbsp;
            </div>
            <div style='text-align:right;'>
                <ul  class='navbar-nav mr-auto' >
                    <li class='dropdown'>
                        <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Compétence(s) associée(s)</a>
                        <div class='dropdown-menu'>
                            @foreach ($objectif->taches()->get() as $tache)
                                <a class="dropdown-item" href="{{ route('transformation::taches.show', $tache->id) }}">{{ $tache->tache_libcourt }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class='card ml-3 w-100'>
        <div class='card-header ml-n3 mr-n4 mb-3' ><b>Actvité(s) associ&eacute;e(s)</b></div>
        @foreach ($objectif->sous_objectifs()->orderBy("ordre")->get() as $ssobj)
            @php 
                $lieu= $lieux->where('id', $ssobj->lieu_id)->first();
                $lib_lieu = $lieu->lieu_libcourt;
            @endphp
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-row mb-1 justify-content-between">
                        <div class="p-2 w-50 card" >{{ $ssobj->ssobj_lib }}</div>
                        <div class="p-2 w-50 ml-bs-5">
                            <div class="d-flex flex-row ">
                                <div class="p-2 w-25">Lien externe :</div>
                                <div class="p-2 w-75">{{ $ssobj->ssobj_lienurl }}</div>
                            </div>
                            <div class="d-flex flex-row "">
                                <div class="p-2 w-25">Coefficient : </div>
                                <div class="p-2 w-75">{{ $ssobj->ssobj_coeff }}</div>
                            </div>
                            <div class="d-flex flex-row "">
                                <div class="p-2 w-25">Durée(h) : </div>
                                <div class="p-2 w-75">{{ $ssobj->ssobj_duree }}</div>
                            </div>
                            <div class="d-flex flex-row "">
                                <div class="p-2 w-25">Lieu : </div>
                                <div class="p-2 w-75">{{ $lib_lieu }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection