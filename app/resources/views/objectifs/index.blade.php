@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Objectifs</h2>
        <div class="lead">
            Gérer les objectifs.
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
	
			{!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
			{!! Form::text('filter', $filter) !!}
			{!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
			{!! Form::close() !!}
	
			{{ $objectifs->count() }} objectifs
	
	        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="8%">Libelle court</th>
				<th scope="col">Libelle long</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($objectifs as $objectif)
                    <tr>
                        <th scope="row">{{ $objectif->id }}</th>
                        <td>{{ $objectif->objectif_libcourt }}</td>
                        <td>{{ $objectif->objectif_liblong }}</td>
						<td><a href="{{ route('objectifs.show', $objectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('objectifs.edit', $objectif->id) }}" class="btn btn-info btn-sm">Editer</a></td>
						@can('objectifs.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['objectifs.destroy', $objectif->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
						@endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $objectifs->withQueryString()->links() !!}
        </div>

@endsection