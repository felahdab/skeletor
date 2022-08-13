@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Compagnonages</h2>
        <div class="lead">
            Gérer les compagnonages
            <a href="{{ route('compagnonages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un compagnonage</a>
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
            {!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
            {!! Form::text('filter', $filter) !!}
            {!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
            {!! Form::close() !!}
    
            {{ $compagnonages->count() }} taches
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
                @foreach($compagnonages as $compagnonage)
                    <tr>
                        <th scope="row">{{ $compagnonage->id }}</th>
                        <td>{{ $compagnonage->comp_libcourt }}</td>
                        <td>{{ $compagnonage->comp_liblong }}</td>
                        <td><a href="{{ route('compagnonages.show', $compagnonage->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('compagnonages.edit', $compagnonage->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        @can('compagnonages.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['compagnonages.destroy', $compagnonage->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $compagnonages->withQueryString()->links() !!}
        </div>

@endsection