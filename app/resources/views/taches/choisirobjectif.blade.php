@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
	{!! Form::open(['method' => 'GET','route' => [request()->route()->getName(), $tache->id]]) !!}
	{!! Form::text('filter', $filter) !!}
	{!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
	{!! Form::close() !!}
	<div id='divmodifobj' class='card bg-light ml-3 w-100' >
		<div class='card-header' > Ajout d'un objectif </div>
		<div style='text-align:right;'>* champs obligatoires </div>
		{!! Form::open(['method' => 'POST','route' => ['taches.ajouterobjectif', $tache->id] ]) !!}
			<div style='padding-left: 15px;'>
				<div class='form-group row' >
				<label class='col-sm-5 col-form-label '>Objectif</label>
				<div>
					<select name='objectif_id' id='objectif_id' class='custom-select  w-50'>
						@foreach ($objectifs as $objectif)
							<option value='{{ $objectif->id }}' > {{ $objectif->objectif_libcourt }}</option>
						@endforeach
					</select>
				</div>
			</div>
				<div>
					<button class='btn btn-primary w-100 mt-4' type='submit'>Ajouter</button>
					<br>&nbsp;
				</div>
			</div>
		{!! Form::close() !!}

	</div>
@endsection