@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')

    <div class="  p-4 rounded">
        <h2>Permissions</h2>
        <div class="lead">
            Gérer les permissions.
            <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm float-right">Ajouter une permission</a>
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="15%">Name</th>
                <th scope="col">Guard</th> 
                <th scope="col" colspan="3" width="1%"></th> 
            </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td><a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                        <td>
                            <x-form::form method="DELETE" :action="route('permissions.destroy', $permission->id)">
                            <button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>
                            </x-form::form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection