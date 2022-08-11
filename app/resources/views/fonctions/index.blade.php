@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Fonctions</h2>
        <div class="lead">
            Gérer les fonctions   
		</div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
			{!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
			{!! Form::text('filter') !!}
			{!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
			{!! Form::close() !!}
	
			{{ $fonctions->count() }} taches
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
                @foreach($fonctions as $fonction)
                    <tr>
                        <th scope="row">{{ $fonction->id }}</th>
                        <td>{{ $fonction->fonction_libcourt }}</td>
                        <td>{{ $fonction->fonction_liblong }}</td>
                        <td><a href="{{ route('fonctions.edit', $fonction->id) }}" class="btn btn-info btn-sm">Editer</a></td>
						@can('fonctions.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['fonctions.destroy', $fonction->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
						@endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $fonctions->withQueryString()->links() !!}
        </div>

@endsection