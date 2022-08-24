@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Stages</h2>
        <div class="lead">
            Gérer les stages
            <a href="{{ route('stages.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un stage</a>
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
            {!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
            {!! Form::text('filter', $filter) !!}
            {!! Form::submit('Filtrer', ['class' => 'btn btn-primary btn-sm']) !!}
            {!! Form::close() !!}
    
            {{ $stages->count() }} stages
            <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="8%">Libelle court</th>
                <th scope="col">Libelle long</th>
                <th scope="col" width="1%" colspan="4"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($stages as $stage)
                    <tr>
                        <th scope="row">{{ $stage->id }}</th>
                        <td>{{ $stage->stage_libcourt }}</td>
                        <td>{{ $stage->stage_liblong }}</td>
                        <td><a href="{{ route('stages.show', $stage->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('stages.edit', $stage->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        <td><a href="{{ route('stages.validermarins', $stage->id) }}" class="btn btn-info btn-sm">Validation de stage</a></td>
                        @can('stage.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['stages.destroy', $stage->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $stages->withQueryString()->links() !!}
        </div>

@endsection