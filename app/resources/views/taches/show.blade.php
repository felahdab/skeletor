@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
    <div id='divmodifobj' class='card bg-light ml-3 w-100' >
        <div class='card-header' >Consultation tache </div>
            <div style='padding-left: 15px;'>
                <div class='form-group row' >
                    <label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control'  name='tache[tache_libcourt]' id='tache[tache_libcourt]' placeholder='Libell&eacute; court' value="{{ $tache->tache_libcourt }}" >
                    </div>
                </div>
                <div class='form-group row' >
                    <label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
                    <div class='col-sm-5'>
                        <input type='text' class='form-control' name='tache[tache_liblong]' id='tache[tache_liblong]' placeholder='Libell&eacute; long' value="{{ $tache->tache_liblong }}" >
                    </div>
                </div>
                <div style='text-align:right;'>
                    <ul  class='navbar-nav mr-auto' >
                        <li class='dropdown'>
                            <a href='#' class='dropdown-toogle' data-bs-toggle='dropdown'>Compagnonage(s) associé(s)</a>
                            <div class='dropdown-menu'>
                                @foreach ($tache->compagnonages()->get() as $comp)
                                    <a class="dropdown-item" href="{{ route('compagnonages.show', $comp->id) }}">{{ $comp->comp_libcourt }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>

            </div>

        <div style='padding-left: 15px;'>
            <div class='card-header ml-n3 mr-n4 mb-3' >Objectifs associ&eacute;s</div>
            <input type='hidden' name='tache_id' id='tache_id'  value='{{ $tache->id }}'>
            
            @php $count = 1 @endphp
            @foreach ($tache->objectifs()->get() as $objectif)
            <div class='cadressobj'>
            <div class='form-group row' >
                <label class='col-sm-5 col-form-label '>Objectif </label>
                <input type='hidden' name='sous_objectifs[{{$count}}][id]' id='sous_objectifs[{{$count}}][id]'  value='{{ $objectif->id }}'>
                <div class='col-sm-5'>
                    <textarea cols='40' rows='6' name='objectifs[{{$count}}][objectif_libcourt]' id='objectifs[{{$count}}][objectif_libcourt]' placeholder='Libell&eacute;' >{{ $objectif->objectif_libcourt }}</textarea>
                </div>
            </div>
            </div>
            @php $count = $count +1 @endphp
            @endforeach
            
        
        </div>
    </div>
@endsection