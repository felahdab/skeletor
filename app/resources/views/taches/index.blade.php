@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Taches</h2>
        <div class="lead">
            Gérer les taches   </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
	
			{!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
			{!! Form::text('filter') !!}
			{!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
			{!! Form::close() !!}
	
			{{ $taches->count() }} taches
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
                @foreach($taches as $tache)
                    <tr>
                        <th scope="row">{{ $tache->id }}</th>
                        <td>{{ $tache->tache_libcourt }}</td>
                        <td>{{ $tache->tache_liblong }}</td>
                        <td><a href="{{ route('taches.show', $tache->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
						<td><a href="{{ route('taches.edit', $tache->id) }}" class="btn btn-info btn-sm">Editer</a></td>
						@can('taches.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['taches.destroy', $tache->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
						@endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $taches->withQueryString()->links() !!}
        </div>

@endsection