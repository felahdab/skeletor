@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="parcours"/>
@endsection


@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Modification objectif </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['objectifs.update', $objectif->id] ]) !!}
            <input type='hidden' id='objectif[id]' name='objectif[id]' value='{{ $objectif->id }}'>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                    <div class='col-sm-5'>
                        <input type='text'  maxlength='100' class='form-control'  name='objectif[objectif_libcourt]' id='objectif[objectif_libcourt]' placeholder='Libell&eacute; court' value="{{ $objectif->objectif_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                    <div class='col-sm-5'>
                        <input type='text' maxlength='256' class='form-control' name='objectif[objectif_liblong]' id='objectif[objectif_liblong]' placeholder='Libell&eacute; long' value="{{ $objectif->objectif_liblong }}" >
                    </div>
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
            {!! Form::open(['method' => 'POST','route' => 'sous-objectifs.multipleupdate' ]) !!}
            <input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
            

            @php $count = 1 @endphp
            @foreach ($objectif->sous_objectifs()->get() as $ssobj)
            <div class='cadressobj'>
                <div class='form-group row' >
                    <label class='col-sm-5 col-form-label '>Sous-objectif </label>
                    <input type='hidden' name='sous_objectifs[{{$count}}][id]' id='sous_objectifs[{{$count}}][id]'  value='{{ $ssobj->id }}'>
                    <div class='col-sm-5'>
                        <textarea maxlength='1500' cols='40' rows='6' name='sous_objectifs[{{$count}}][ssobj_lib]' id='sous_objectifs[{{$count}}][ssobj_lib]' placeholder='Libell&eacute;' >{{ $ssobj->ssobj_lib }}</textarea>
                    </div>
                </div>
                <div class='form-group row' >
                    <label class='col-sm-5 col-form-label '>Coefficient</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='sous_objectifs[{{$count}}][ssobj_coeff]' id='sous_objectifs[{{$count}}][ssobj_coeff]' placeholder='Coefficient' value='{{ $ssobj->ssobj_coeff }}'>
                    </div>
                </div>
                <div class='form-group row' >
                    <label class='col-sm-5 col-form-label '>Dur&eacute;e (heure)</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='sous_objectifs[{{$count}}][ssobj_duree]' id='sous_objectifs[{{$count}}][ssobj_duree]' placeholder='Durée' value='{{ $ssobj->ssobj_duree }}'>
                    </div>
                </div>
                <div class='form-group row' >
                    <label class='col-sm-5 col-form-label '>Lieu </label>
                    <div class='col-sm-5'>
                        <select name='sous_objectifs[{{$count}}][lieu_id]' id='sous_objectifs[{{$count}}][lieu_id]' class='custom-select  w-50'>
                            @foreach ($lieux as $lieu)
                                <option value='{{ $lieu->id }}' {{ $lieu->id == $ssobj->lieu_id
                                ? ' selected'
                                : '' }}> {{ $lieu->lieu_libcourt }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @can("sousobjectifs.destroy")
                
                <input class="btn btn-danger btn-sm" value="Supprimer ce sous objectif" onclick="document.getElementById('deleteform[{{ $count }}]').submit();">
                @endcan
            </div>
            @php $count = $count +1 @endphp
            @endforeach
            <div>
                <button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobjssobj' name='btnmodifobjssobj'>Enregistrer les sous objectifs associ&eacute;s</button>
            </div>
            {!! Form::close() !!}
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