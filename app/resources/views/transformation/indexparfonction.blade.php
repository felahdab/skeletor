@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Transformation - Fonctions</h2>
        <div class="lead">
            Gérer la transformation par fonction
        </div>
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

    </div>
            {!! Form::open(['method' => 'GET','route' => request()->route()->getName()]) !!}
            {!! Form::text('filter', $filter) !!}
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
                        <td><a href="{{ route('fonctions.choixmarins', $fonction->id) }}" class="btn btn-primary btn-sm">Validation collective</a></td>
                        <td>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $fonctions->withQueryString()->links() !!}
        </div>

@endsection