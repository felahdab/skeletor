@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
	<div id='divmodifobj' class='card bg-light ml-3 w-100' >
		<div class='card-header' >Modification tache </div>
		<div style='text-align:right;'>* champs obligatoires </div>
		{!! Form::open(['method' => 'PATCH','route' => ['taches.update', $tache->id] ]) !!}
			<input type='hidden' id='tache[id]' name='tache[id]' value='{{ $tache->id }}'>
			<div style='padding-left: 15px;'>
				<div class='form-group row' >
					<label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
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
						<li class='nav-item dropdown'>
							<a href='#' class='nav-link dropdown-toogle' data-toggle='dropdown'>Compagnonnage(s) associée(s)</a>
							<ul class='dropdown-menu dropdown-menu-right'></ul>
						</li>
					</ul>
				</div>
				<div>
					<button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobj' name='btnmodifobj'>Modifier</button>
					<br>&nbsp;
				</div>
			</div>
		{!! Form::close() !!}

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
			@can("objectifs.destroy")
			{!! Form::open(['method' => 'POST','route' => ['taches.removeobjectif', $tache ],'style'=>'display:inline']) !!}
			<input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
			{!! Form::submit('Retirer cet objectif', ['class' => 'btn btn-danger btn-sm']) !!}
			{!! Form::close() !!}
			@endcan
			</div>
			@php $count = $count +1 @endphp
			@endforeach
			
		
			<div style='text-align: center;'>
				{!! Form::open(['method' => 'GET','route' => ['taches.choisirobjectif', $tache->id],'style'=>'display:inline']) !!}
				{!! Form::submit('Ajouter un nouvel objectif', ['class' => 'btn btn-primary btn-sm']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection