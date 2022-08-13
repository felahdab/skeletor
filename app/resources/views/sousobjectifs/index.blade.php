@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Sous-Objectifs</h2>
        <div class="lead">
            Gérer les sous objectifs.
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>
    
            {!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
            {!! Form::text('filter', $filter) !!}
            {!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
            {!! Form::close() !!}
    
            {{ $sousobjectifs->count() }} Sous-objectifs
            <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="60%">Libelle</th>
                <th scope="col" width="5%">Coefficient</th>
				<th scope="col" width="5%">Duree</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($sousobjectifs as $sousobjectif)
                    <tr>
                        <th scope="row">{{ $sousobjectif->id }}</th>
                        <td>{{ $sousobjectif->ssobj_lib }}</td>
                        <td>{{ $sousobjectif->ssobj_coeff }}</td>
						<td>{{ $sousobjectif->ssobj_duree }}</td>
                        <td><a href="{{ route('sous-objectifs.show', $sousobjectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('sous-objectifs.edit', $sousobjectif->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        @can('sousobjectifs.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['sous-objectifs.destroy', $sousobjectif->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $sousobjectifs->withQueryString()->links() !!}
        </div>
@endsection