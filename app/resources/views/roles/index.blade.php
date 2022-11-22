@extends('layouts.app-master')

@section('content')
    
    <div class="bg-light p-4 rounded">
        <h2>Roles</h2>
        <div class="lead">
            Gérer les roles.
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right">Ajouter un role</a>
        </div>

        <table class="table table-bordered">
          <tr>
             <th width="1%">No</th>
             <th>Name</th>
             <th width="3%" colspan="3">Action</th>
          </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="{{ route('roles.show', $role->id) }}">Consulter</a>
                </td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ route('roles.edit', $role->id) }}">Modifier</a>
                </td>
                <td>
                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        </table>

        <div class="d-flex">
            {!! $roles->links() !!}
        </div>

    </div>
@endsection