@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
		<div class='lead'>Ajout d'une tache pour le compagnonage {!!$compagnonage->comp_libcourt !!} </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    </div>
	{!! Form::open(['method' => 'GET','route' => ['compagnonages.choisirtache', $compagnonage->id]]) !!}
	{!! Form::text('filter', $filter) !!}
	{!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
	{!! Form::close() !!}
	<div id='divmodifobj' class='card bg-light ml-3 w-100' >
		<div class='card-header' > Ajout d'une tache </div>
		{!! Form::open(['method' => 'POST','route' => ['compagnonages.ajoutertache', $compagnonage->id] ]) !!}
			<div style='padding-left: 15px;'>
				<div class='form-group row' >
				<label class='col-sm-5 col-form-label '>Tache</label>
				<div>
					<select name='tache_id' id='tache_id' class='custom-select  w-50'>
						@foreach ($taches as $tache)
							<option value='{{ $tache->id }}' > {{ $tache->tache_libcourt }}</option>
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