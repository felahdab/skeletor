@extends('layouts.app-master')

@section('helplink')
< x-help-link page="parcours"/>
@endsection


@section('content')
    <div class="p-4 rounded">
        <h2>Compagnonnages</h2>
    </div>
    <div id='divmodifobj' class='card ml-3 w-100' >
        <div class='card-header' >Modification compagnonnage </div>
        <div style='text-align:right;'>* champs obligatoires </div>
        {!! Form::open(['method' => 'PATCH','route' => ['transformation::compagnonages.update', $compagnonage->id] ]) !!}
        <input type='hidden' id='comp[id]' name='comp[id]' value='{{ $compagnonage->id }}'>
        <div style='padding-left: 15px;'>
            <div class='form-group row' >
                <label for='comp[comp_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
                <div class='col-sm-5'>
                    <input type='text' maxlength='100' class='form-control'  name='comp[comp_libcourt]' id='comp[comp_libcourt]' placeholder='Libell&eacute; court' value="{{ $compagnonage->comp_libcourt }}" >
                </div>
            </div>
            <div class='form-group row' >
                <label for='comp[comp_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long *</label>
                <div class='col-sm-5'>
                    <input type='text' maxlength='256' class='form-control' name='comp[comp_liblong]' id='comp[comp_liblong]' placeholder='Libell&eacute; long' value="{{ $compagnonage->comp_liblong }}" >
                </div>
            </div>
            <div>
                <button class='btn btn-primary mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Enregistrer</button>
                <a href="{{ route('transformation::compagnonages.index') }}" class="btn btn-outline-dark mt-4">Annuler</a>
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

        <div class='card ml-3 w-100'>
            <div class='card-header ml-n3 mr-n4 mb-3' ><b>Tâche(s) associ&eacute;e(s)</b> <span style="font-size:x-small;">(Glissez/déplacez les taches puis enregistrez pour modifier leur ordre d'affichage dans l'application)</span></div>
            <input type='hidden' name='compagnonage_id' id='compagnonage_id'  value='{{ $compagnonage->id }}'>
            
            <x-sortable name="sort_order">
            @foreach ($compagnonage->taches->sortBy('pivot.ordre') as $tache)
                <x-sortable-item sort_key="{{$tache->id}}">
                    <div class="card m-1">
                        <div class="card-body">
                            <div class="myhandle btn btn-default"><x-bootstrap-icon iconname='arrows-move.svg' /></div>
                            <div class="d-flex flex-row mb-1 justify-content-between">
                                <div class="p-2 h4 w-50" >{{ $tache->tache_liblong }}</div>
                                <div class="p-2 w-25"> => {{ $tache->tache_libcourt }} </div>
                                <div class="p-2 w-25 text-end">
                                    @can("transformation::compagnonages.removetache")
                                        <button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('removetache[{{ $tache->id }}]').submit()">Retirer cette tâche</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </x-sortable-item>
            @endforeach
            </x-sortable>
            {!! Form::close() !!}
            
            @can("transformation::compagnonages.removetache")
                @foreach ($compagnonage->taches->sortBy('pivot.ordre') as $tache)
                    <form method="POST" action="{{ route('transformation::compagnonages.removetache', [$compagnonage, $tache]) }}" id="removetache[{{ $tache->id }}]">
                        @csrf
                    </form>
                @endforeach
            @endcan

            @can("transformation::compagnonages.choisirtache")
            <div class='text-center mt-1 mb-1'>
                {!! Form::open(['method' => 'GET','route' => ['transformation::compagnonages.choisirtache', $compagnonage->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Ajouter une nouvelle tâche', ['class' => 'btn btn-primary btn-sm']) !!}
                {!! Form::close() !!}
            </div>
            @endcan
        </div>
    </div>
@endsection