@extends('layouts.app-master')

@section('helplink')
<x-help-link module="Transformation" page="parcours"/>
@endsection

@section('after_styles')
    @include('layouts.partials.sortable')
@endsection

@section('content')

    <div class="p-4 rounded">
        <h2>Savoir-faire</h2>
    </div>
    <div id='divmodifobj' class='card w-100'>
        <div class='card-header' >Modification savoir-faire </div>
        <div class='text-end '>* champs obligatoires </div>
        <x-form::form method="PATCH" :action="route('transformation::objectifs.update', $objectif->id)">
            <input type='hidden' id='objectif[id]' name='objectif[id]' value='{{ $objectif->id }}'>
            <div style='padding-left: 15px;'>
                <div class="p-2">
                    <div class="d-flex flex-row ">
                        <div class="p-2 w-25">Libellé court *</div>
                        <div class="p-2 w-75"><x-form::input name="objectif[objectif_libcourt]" type="text" :value="$objectif->objectif_libcourt"/></div>
                    </div>
                    <div class="d-flex flex-row ">
                        <div class="p-2 w-25">Libellé long *</div>
                        <div class="p-2 w-75"><x-form::input name="objectif[objectif_liblong]" type="text" :value="$objectif->objectif_liblong" /></div>                                  
                    </div>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Enregistrer</button>
                    <a href="{{ route('transformation::objectifs.index') }}" class="btn btn-outline-dark mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
                <div style='text-align:right;'>
                    <ul class='navbar-nav mr-auto' >
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

            <div class='card w-100'>
                <div class='card-header ml-n3 mr-n4 mb-3' >Activité(s) associ&eacute;e(s) <span style="font-size:x-small;">(Glissez/déplacez les activités puis enregistrez pour modifier leur ordre d'affichage dans l'application)</span></div>
                <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
                <x-sortable name="sort_order">
                    @foreach ($objectif->sous_objectifs->sortBy('ordre') as $ssobj)
                    <x-sortable-item sort-key="{{$ssobj->id}}">    
                        <div class="card m-1">
                            <div class="card-body">
                                <div class="myhandle btn btn-default"><x-bootstrap-icon iconname='arrows-move.svg' /></div>
                                <div class="d-flex flex-row mb-1 justify-content-between">
                                    <div class="p-2 w-50 " >
                                        <div>
                                            <input type='hidden' name='sous_objectifs[{{$ssobj->id}}][id]' id='sous_objectifs[{{$ssobj->id}}][id]'  value='{{ $ssobj->id }}'>
                                            <textarea class="form-control" maxlength='1500' cols='40' rows='6' name='sous_objectifs[{{$ssobj->id}}][ssobj_lib]' placeholder='Libell&eacute;' >{{ $ssobj->ssobj_lib }}</textarea>
                                        </div>
                                        <div class="mt-3 text-center">
                                            @can("transformation::sous-objectifs.destroy")
                                                <input class="btn btn-danger" value="Supprimer cette activité" onclick="document.getElementById('deleteform[{{ $ssobj->id }}]').submit();">
                                            @endcan        
                                        </div>
                                    </div>
                                    <div class="p-2 w-50 ml-bs-5">
                                        <div class="d-flex flex-row ">
                                            <div class="p-2 w-25">Lien externe</div>
                                            <div class="p-2 w-75"><x-form::input name="sous_objectifs[{{$ssobj->id}}][ssobj_lienurl]" type="text" value="{{ $ssobj->ssobj_lienurl }}"/></div>
                                        </div>
                                        <div class="d-flex flex-row ">
                                            <div class="p-2 w-25">Coefficient</div>
                                            <div class="p-2 w-75"><x-form::input name="sous_objectifs[{{$ssobj->id}}][ssobj_coeff]" type="text" value="{{ $ssobj->ssobj_coeff }}"/></div>                                  
                                        </div>
                                        <div class="d-flex flex-row ">
                                            <div class="p-2 w-25">Durée (h)</div>
                                            <div class="p-2 w-75"><x-form::input name="sous_objectifs[{{$ssobj->id}}][ssobj_duree]" type="text" value="{{ $ssobj->ssobj_duree }}"/></div>                                   
                                        </div>
                                        <div class="d-flex flex-row ">
                                            <div class="p-2 w-25">Lieu</div>
                                            <div class="p-2 w-75">
                                                <x-form::model-select name="sous_objectifs[{{$ssobj->id}}][lieu_id]" 
                                                :models="$lieux"
                                                key-attribute="id" 
                                                value-attribute="lieu_libcourt"
                                                value="{{ $ssobj->lieu_id }}">
                                                </x-form::model-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-sortable-item>            
                    @endforeach
                </x-sortable>
        </x-form:::form>
                <div class='text-center mb-1'>
                    <x-form::form method="POST" :action="route('transformation::sous-objectifs.store')">
                        <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
                        <button class='btn btn-primary btn-sm' type='submit' >Ajouter une nouvelle activité</button>
                    </x-form:::form>
                </div>
                <!-- Cette partie contient les formulaires actives par javascript pour provoquer la suppression
                d'un sous-objectif-->
                @foreach ($objectif->sous_objectifs()->get() as $ssobj)
                    <x-form::form method="POST" :action="route('transformation::sous-objectifs.destroy', $ssobj)" id="deleteform[{{ $ssobj->id }}]">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <input type='hidden' name='objectif_id' id='objectif_id' value='{{ $objectif->id }}'>
                    </x-form:::form>
                @endforeach
                <!-- Fin de partie -->
            </div>
    </div>
@endsection