@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
	<div id='divmodifobj' class='card bg-light ml-3 w-100' >
		<div class='card-header' >Modification objectif </div>
		<div style='text-align:right;'>* champs obligatoires </div>
		{!! Form::open(['method' => 'PATCH','route' => ['objectifs.update', $objectif->id] ]) !!}
			<div style='padding-left: 15px;'>
				<div class='form-group row' >
					<label for='libelle_court_objectif' class='col-sm-5 col-form-label'> Libell&eacute; court *</label>
					<div class='col-sm-5'>
						<input type='text' class='form-control'  name='libelle_court_objectif' id='libelle_court_objectif' placeholder='Libell&eacute; court' value="{{ $objectif->objectif_libcourt }}" >
					</div>
				</div>
				<div class='form-group row' >
					<label for='libelle_long_objectif' class='col-sm-5 col-form-label'>Libell&eacute; long</label>
					<div class='col-sm-5'>
						<input type='text' class='form-control' name='libelle_long_objectif' id='libelle_long_objectif' placeholder='Libell&eacute; long' value="{{ $objectif->objectif_liblong }}" >
					</div>
				</div>
				<div style='text-align:right;'>
					<ul  class='navbar-nav mr-auto' >
						<li class='nav-item dropdown'>
							<a href='#' class='nav-link dropdown-toogle' data-toggle='dropdown'>T&acirc;che(s) associée(s)</a>
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
			<div class='card-header ml-n3 mr-n4 mb-3' >Sous-objectifs associ&eacute;s</div>
			{!! Form::open(['method' => 'POST','route' => 'sousobjectifs.multipleupdate' ]) !!}
			<input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
			
			@php $count = 1 @endphp
			@foreach ($objectif->sous_objectifs()->get() as $ssobj)
			<div class='cadressobj'>
			<div class='form-group row' >
				<label class='col-sm-5 col-form-label '>Sous-objectif </label>
				<input type='hidden' name='sous_objectifs[{{$count}}][id]' id='sous_objectifs[{{$count}}][id]'  value='{{ $ssobj->id }}'>
				<div class='col-sm-5'>
					<textarea cols='40' rows='6' name='sous_objectifs[{{$count}}][ssobj_lib]' id='sous_objectifs[{{$count}}][ssobj_lib]' placeholder='Libell&eacute;' >{{ $ssobj->ssobj_lib }}</textarea>
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
			{!! Form::open(['method' => 'DELETE','route' => ['sous-objectifs.destroy', $ssobj ],'style'=>'display:inline']) !!}
			<input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
			{!! Form::submit('Supprimer ce sous objectif', ['class' => 'btn btn-danger btn-sm']) !!}
			{!! Form::close() !!}
			@endcan
			</div>
			@php $count = $count +1 @endphp
			@endforeach
			
			<div>
				<button class='btn btn-primary w-100 mt-4' type='submit' id='btnmodifobjssobj' name='btnmodifobjssobj'>Enregistrer les sous objectifs associ&eacute;s</button>
			</div>
			{!! Form::close() !!}
			<div style='text-align: center;'>
				{!! Form::open(['method' => 'POST','route' => 'sous-objectifs.store','style'=>'display:inline']) !!}
				<input type='hidden' name='objectif_id' id='objectif_id'  value='{{ $objectif->id }}'>
				{!! Form::submit('Ajouter un nouveau sous objectif', ['class' => 'btn btn-primary btn-sm']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@endsection