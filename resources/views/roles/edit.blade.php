@extends('layouts.app-master')

@section('helplink')
< x-help-link page="administration"/>
@endsection


@section('content')
    <div class="  p-4 rounded">
        <h2>Mettre à jour le role</h2>
        <div class="lead">
            Moditifer le role et attribuer les permissions associées.
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
					<label for="name" class="form-label">Nom du rôle</label>
					{!!Form::text('name', $role->name , ['class' => 'form-control', 'placeholder'=> "Name"]) !!}
                    
                </div>
                
                <label for="permissions" class="form-label">Attribuer les permissions</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" x-on:click="allChecked = !allChecked; $dispatch('toggleallperms');"></th>
                        <th scope="col" width="20%">Name</th>
                        <th scope="col" width="1%">Guard</th> 
                    </thead>
                    <tbody>
                    <tr><td colspan="3" class="text-center display-5">Permissions générales: </td></tr>
                    @foreach($permissions as $permission)
                    @if (! str_contains($permission->name, '::'))
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
                        @endif
                    @endforeach

                    @foreach(Module::allEnabled() as $module)
                    <tr><td colspan="3" class="text-center display-5">Permissions du module: {{ $module->getName() }} </td></tr>
                        @foreach($permissions as $permission)
                        @if (str_contains($permission->name, $module->getLowerName() . '::'))
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
                            @endif
                        @endforeach
                    @endforeach
                            </tbody>
                </table>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('roles.index') }}" class="btn btn-default">Retour</a>
			{!! Form::close() !!}
        </div>
</div>
    </div>
@endsection

