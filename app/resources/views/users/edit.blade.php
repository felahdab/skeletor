@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Update user</h1>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input value="{{ $user->name }}" 
                        type="text" 
                        class="form-control" 
                        name="name" 
                        placeholder="Name" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prenom</label>
                    <input value="{{ $user->prenom }}" 
                        type="text" 
                        class="form-control" 
                        name="prenom" 
                        placeholder="Prenom" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{ $user->email }}"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        placeholder="Email address" required>
                    @if ($errors->has('email'))
                        <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input value="{{ $user->matricule }}" 
                        type="text" 
                        class="form-control" 
                        name="matricule" 
                        placeholder="Matricule" required>
                </div>
                <div class="mb-3">
                    <label for="date_embarq" class="form-label">Date d'embarquement</label>
                    <input value="{{ $user->date_embarq }}" 
                        type="date" 
                        class="form-control" 
                        name="date_embarq" 
                        placeholder="Date d'embarquement" required>
                </div>
                
                <label for="roles" class="form-label">Attribuer des roles</label>

                <table class="table table-striped">
                    <thead>
                        <th scope="col" width="1%"><input type="checkbox" name="all_roles"></th>
                        <th scope="col" width="20%">Nom</th>
                    </thead>

                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <input type="checkbox" 
                                name="role[{{ $role->name }}]"
                                value="{{ $role->name }}"
                                class='role'
                                {{ in_array($role->name, $userRole) 
                                    ? 'checked'
                                    : '' }}>
                            </td>
                            <td>{{ $role->name }}</td>
                        </tr>
                    @endforeach
                </table>

                <button type="submit" class="btn btn-primary">Update user</button>
                <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</button>
            </form>
        </div>

    </div>
@endsection