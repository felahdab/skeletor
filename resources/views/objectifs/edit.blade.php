@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')

    <div class="p-4 rounded">
        <h2>Objectifs</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification objectif </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['objectifs.update', $objectif->id] ]) !!}
            <input type='hidden' id='objectif[id]' name='objectif[id]' value='{{ $objectif->id }}'>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <x-form::input name="objectif[objectif_libcourt]" label="Libellé court *" type="text" :value="$objectif->objectif_libcourt"/>
                </div>
                <div class='form-group row'>
                    <x-form::input name="objectif[objectif_liblong]" label="Libellé long *" type="text" :value="$objectif->objectif_liblong" />
                </div>
                <div style='text-align:right;'>
                    <ul  class='navbar-nav mr-auto' >
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Tâche(s) associée(s)</a>
                            <div class='dropdown-menu'>
                                @foreach ($objectif->taches()->get() as $tache)
                                    <a class="dropdown-item" href="{{ route('taches.show', $tache->id) }}">{{ $tache->tache_libcourt }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
                    <a href="{{ route('objectifs.index') }}" class="btn btn-default mt-4">Annuler</a>
                    <br>&nbsp;
                </div>
            </div>
        {!! Form::close() !!}

        <div style='padding-left: 15px;'>
            <div class='card-header ml-n3 mr-n4 mb-3' >Sous-objectif(s) associ&eacute;(s)</div>
            

            <div style='text-align: center;'>
                {!! Form::open(['method' => 'POST','route' => 'sous-objectifs.store','style'=>'display:inline']) !!}
                <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
                {!! Form::submit('Ajouter un nouveau sous objectif', ['class' => 'btn btn-primary btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            <x-form::form method="POST" :action="route('sous-objectifs.multipleupdate')">
            <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
            
        <x-sortable name="sort_order">
            @php $count = 1 @endphp
            @foreach ($objectif->sous_objectifs->sortBy('ordre') as $ssobj)
            <x-sortable-item sort-key="{{$ssobj->id}}">
                <div class='cadressobj mt-4'>
                    <div class='form-group row' >
                        <div class="col-sm-8">
                            <label class='col-form-label '>Sous-objectif </label>
                            <input type='hidden' name='sous_objectifs[{{$count}}][id]' id='sous_objectifs[{{$count}}][id]'  value='{{ $ssobj->id }}'>
                            <div class='col'>
                                <textarea class="form-control" maxlength='1500' cols='40' rows='6' name='sous_objectifs[{{$count}}][ssobj_lib]' id='sous_objectifs[{{$count}}][ssobj_lib]' placeholder='Libell&eacute;' >{{ $ssobj->ssobj_lib }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class='form-group row' >
                                <x-form::input name="sous_objectifs[{{$count}}][ssobj_lienurl]" label="Lien externe" type="text" value="{{ $ssobj->ssobj_lienurl }}"/>
                            </div>
                            <div class='form-group row' >
                                <x-form::input name="sous_objectifs[{{$count}}][ssobj_coeff]" label="Coefficient" type="text" value="{{ $ssobj->ssobj_coeff }}"/>
                            </div>
                            <div class='form-group row' >
                                <x-form::input name="sous_objectifs[{{$count}}][ssobj_duree]" label="Durée (heure)" type="text" value="{{ $ssobj->ssobj_duree }}"/>
                            </div>
                            <div class='form-group row' >
                                <x-form::model-select name="sous_objectifs[{{$count}}][lieu_id]" 
                                    :models="$lieux" 
                                    label="Lieu" 
                                    key-attribute="id" 
                                    value-attribute="lieu_libcourt"
                                    value="{{ $ssobj->lieu_id }}">
                                </x-form::model-select>
                            </div>
                        </div>
                    </div>
                    
                    @can("sousobjectifs.destroy")
                        <input class="btn btn-danger btn-sm mb-2" value="Supprimer ce sous objectif" onclick="document.getElementById('deleteform[{{ $count }}]').submit();">
                    @endcan
                </div>
            </x-sortable-item>
            @php $count = $count +1 @endphp
        
            @endforeach
            <div>
                <button class='btn btn-primary w-100 mt-4 mb-4' type='submit' id='btnmodifobjssobj' name='btnmodifobjssobj'>Enregistrer les sous objectifs associ&eacute;s</button>
            </div>
        </x-sortable>
    </x-form:::form>
            <!-- Cette partie contient les formulaires actives par javascript pour provoquer la suppression
            d'un sous-objectif-->
            @php $count = 1 @endphp
            @foreach ($objectif->sous_objectifs()->get() as $ssobj)
                <form method="POST" action="{{ route('sous-objectifs.destroy', $ssobj) }}" accept-charset="UTF-8" style="display:inline" id="deleteform[{{ $count }}]">
                @csrf
                <input name="_method" type="hidden" value="DELETE">
                <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
                {!! Form::close() !!}
                @php $count = $count +1 @endphp
            @endforeach
            <!-- Fin de partie -->
        </div>
    </div>
@endsection