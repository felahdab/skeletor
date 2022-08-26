@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Transformation - Stages</h2>
        <div class="lead">
            Gérer la transformation par les stages
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
                        <td colspan="2"><a href="{{ route('stages.choixmarins', ['stage' => $stage->id] ) }}" class="btn btn-primary btn-sm">Validation ou annulation collective</a></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $stages->withQueryString()->links() !!}
        </div>

@endsection