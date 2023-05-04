@extends('layouts.app-master')

@section('helplink')
<x-documentation-link page="administration"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Update role</h2>
        <div class="lead">
            Edit role and manage permissions.
        </div>

<div x-data='{allChecked : false }'>
        <div class="container mt-4">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

			{!! Form::open(['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
				
                <div class="mb-3">
					<label for="name" class="form-label">Name</label>
					{!!Form::text('name', $role->name , ['class' => 'form-control', 'placeholder'=> "Name"]) !!}
                    
                </div>
                
                <label for="permissions" class="form-label">Assign Permissions</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = !allChecked; $dispatch('toggleallperms');"></th>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th> 
                    </thead>

                    @foreach($permissions as $permission)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="permission[{{ $permission->name }}]"
                                value="{{ $permission->name }}"
				class='permission'
                                x-on:toggleallperms.window="$el.checked = allChecked;"
                                {{ in_array($permission->name, $rolePermissions) 
                                    ? 'checked'
                                    : '' }}>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->guard_name }}</td>
                        </tr>
                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('roles.index') }}" class="btn btn-default">Retour</a>
			{!! Form::close() !!}
        </div>
</div>
    </div>
@endsection

