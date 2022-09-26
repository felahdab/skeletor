@extends('layouts.app-master')

@section('content')
 <div class="bg-light p-4 rounded">
    <h2>Utilisateurs</h2>
    <div class="lead">
        Gestion des demandes d'activation de compte Mindef Connect
    </div>
    
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="8%">Nom</th>
                <th scope="col" width="8%">Prénom</th>
                <th scope="col" width="8%">Email</th>
                <th scope="col">Unité</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($mcusers as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->main_department_number }}</td>
                        <td>
                            <a href="{{ route('mindefconnect.edit', $user->id) }}" class="btn btn-info btn-sm">Examiner cette demande</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['mindefconnect.destroy', $user->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Refuser cette demande', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $mcusers->links() }}
    </div>
</div>
@endsection