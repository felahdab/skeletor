<div>
    <input wire:model='filter' type="text" placeholder="Filtrer...">

    <div wire:loading>
        Chargement...
    </div>

    <div wire:loading.remove>
        <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" width="1%">#</th>
                    <th scope="col" width="8%">Nom</th>
                    <th scope="col" width="8%">Prénom</th>
                    <th scope="col">Email</th>
                    @if($mode == "gestion")
                        <th scope="col" width="15%">Roles</th>
                        <th scope="col" width="40%" colspan="3"></th>
                    @elseif ($mode == "transformation")
                        <th scope="col" width="40%">Actions</th>
                        <th scope="col" width="1%" colspan="3"></th>
                    @endif
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->prenom }}</td>
                            <td>{{ $user->email }}</td>
                            @if($mode == "gestion")
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm">Editer</a>
                                
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </td>
                                <td>
                                @can('changepasswd.allusers')
                                    <a href="{{ route('changepasswd.show', $user->id) }}" class="btn btn-secondary btn-sm">Changer le mot de passe</a>
                                @endcan
                                </td>
                                <td>
                                @can('impersonate')
                                    <a href="{{ route('impersonate', $user->id) }}" class="btn btn-danger btn-sm">Se faire passer pour</a>
                                @endcan
                                </td>

                            @elseif ($mode == "transformation")
                                <td>
                                    <a href="{{ route('users.choisirfonction', $user->id) }}" class="btn btn-info btn-sm">Attribuer des fonctions</a>
                                    <a href="{{ route('transformation.livret', $user->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
                                    <a href="{{ route('transformation.progression', $user->id) }}" class="btn btn-primary btn-sm">Progression</a>
                                    <a href="{{ route('transformation.fichebilan', $user->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
                                    <a href="{{ route('stages.consulter', [ 'marin' => $user->id]) }}" class="btn btn-danger btn-sm">Stages</a>
                                </td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $users->links() }}
        </div>
</div>
