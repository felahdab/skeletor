@extends('layouts.app-master')

@section('content')
    

    <div class="bg-light p-4 rounded">
        <h1>Transformation</h1>
        <div class="lead">
            Liste des utilisateurs
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="8%">Nom</th>
                <th scope="col" width="8%">Prénom</th>
                <th scope="col">Email</th>
                <th scope="col" width="30%">Actions</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->email }}</td>
                        <td><a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
                        <a href="{{ route('users.choisirfonction', $user->id) }}" class="btn btn-info btn-sm">Attribuer des fonctions</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $users->links() !!}
        </div>

    </div>
@endsection