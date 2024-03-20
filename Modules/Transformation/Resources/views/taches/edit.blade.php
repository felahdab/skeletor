@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Tâches</h2>
    </div>
    <div id='divmodifobj' class='card   ml-3 w-100' >
        <div class='card-header' >Modification tâche </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        
        <x-form::form method="PATCH" :action="route('transformation::taches.update', $tache->id)">
        <input type='hidden' id='tache[id]' name='tache[id]' value='{{ $tache->id }}'>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                <div class='col-sm-5'>
                    <input type='text' maxlength='100' class='form-control'  name='tache[tache_libcourt]' id='tache[tache_libcourt]' placeholder='Libell&eacute; court' value="{{ $tache->tache_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                <div class='col-sm-5'>
                    <input type='text' maxlength='256' class='form-control' name='tache[tache_liblong]' id='tache[tache_liblong]' placeholder='Libell&eacute; long' value="{{ $tache->tache_liblong }}" >
                </div>
            </div>
            <div>
                <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Enregistrer</button>
                <a href="{{ route('transformation::taches.index') }}" class="btn btn-outline-dark mt-4">Annuler</a>
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
        <div class='card ml-3 w-100'>
            <div class='card-header ml-n3 mr-n4 mb-3' ><b>Objectif(s) associ&eacute;(s)</b> <span style="font-size:x-small;">(Glissez/déplacez les objectifs puis enregistrez pour modifier leur ordre d'affichage dans l'application)</span></div>
            <input type='hidden' name='tache_id' id='tache_id'  value='{{ $tache->id }}'>
            
            <x-sortable name="sort_order">
                @foreach ($tache->objectifs->sortBy('pivot.ordre') as $objectif)
                    <x-sortable-item sort-key="{{$objectif->id}}">
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="myhandle btn btn-default"><x-bootstrap-icon iconname='arrows-move.svg' /></div>
                                <div class="d-flex flex-row mb-1 justify-content-between">
                                    <div class="p-2 h4 w-50" >{{ $objectif->objectif_libcourt }}</div>
                                    <div class="p-2 w-25"> => {{ $objectif->objectif_liblong }} </div>
                                    <div class="p-2 w-25 text-end">
                                        @can("transformation::objectifs.destroy")
                                            <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('removeobj[{{ $objectif->id }}]').submit()">Retirer cet objectif</button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-sortable-item>
                @endforeach
            </x-sortable>
        
            <div  class='text-center mt-1 mb-1'>
                <a class='btn btn-primary btn-sm' href="{{ route('transformation::taches.choisirobjectif', $tache->id) }}">Ajouter un nouvel objectif</a>
            </div>
        </div>
        </x-form::form>
        <!-- Cette partie contient les formulaires actives par javascript pour provoquer la suppression
            d'un objectif-->
            @can("transformation::objectifs.destroy")
                @foreach ($tache->objectifs as $objectif)
                <form method="POST" action="{{ route('transformation::taches.removeobjectif', [$tache, $objectif]) }}" id="removeobj[{{ $objectif->id }}]">
                    @csrf
                </form>
                @endforeach
            @endcan
            <!-- Fin de partie -->
    </div>
@endsection