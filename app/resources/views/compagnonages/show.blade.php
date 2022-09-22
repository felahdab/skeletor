@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Compagnonnages</h2>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Consultation compagnonnage </div>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='comp[comp_libcourt]' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='comp[comp_libcourt]' id='comp[comp_libcourt]' placeholder='Libell&eacute; court' value="{{ $compagnonage->comp_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='comp[comp_liblong]' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='comp[comp_liblong]' id='comp[comp_liblong]' placeholder='Libell&eacute; long' value="{{ $compagnonage->comp_liblong }}" >
                    </div>
                </div>
                <div>
                    <a href="{{ route('compagnonages.index') }}" class="btn btn-primary mt-4">Retour</a>
                    <br>&nbsp;
                </div>
                <div style='text-align:right;'>
                    <ul  class='navbar-nav mr-auto' >
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Fonction(s) associée(s)</a>
                            <div class='dropdown-menu'>
                                @foreach ($compagnonage->fonctions()->get() as $fonction)
                                    <a class="dropdown-item" href="{{ route('fonctions.show', $fonction->id) }}">{{ $fonction->fonction_libcourt }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        <div style='padding-left: 15px;'>
            <div class='card-header ml-n3 mr-n4 mb-3' >Tâche(s) associ&eacute;e(s)</div>
            <input type='hidden' name='compagnonage_id' id='compagnonage_id'  value='{{ $compagnonage->id }}'>
            
            @php $count = 1 @endphp
            @foreach ($compagnonage->taches()->get() as $tache)
            <div class='cadressobj'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Tâche </label>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé court</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='taches[{{$count}}][tache_libcourt]' id='taches[{{$count}}][tache_libcourt]' placeholder='Libelle court' value='{{ $tache->tache_libcourt }}'>
                </div>
            </div>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Libellé long</label>
                <div class='col-sm-5'>
                    <input type='text' class='form-control' name='taches[{{$count}}][tache_liblong]' id='taches[{{$count}}][tache_liblong]' placeholder='Libelle long' value='{{ $tache->tache_liblong }}'>
                </div>
            </div>
            </div>
            @php $count = $count +1 @endphp
            @endforeach
            
        </div>
    </div>
@endsection