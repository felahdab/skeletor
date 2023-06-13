<a href="{{ route('users.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
@can('users.destroy')
    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $row->id], 'style'=>'display:inline' ]) !!}
    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm', 'dusk' => 'delete-btn']) !!}
    {!! Form::close() !!}
@endcan
@can('changepasswd.allusers')
    <a href="{{ route('changepasswd.show', $row->id) }}" class="btn btn-secondary btn-sm">Changer le mot de passe</a>
@endcan
@can('impersonate')
    <a href="{{ route('impersonate', $row->id) }}" class="btn btn-danger btn-sm">Se faire passer pour</a>
@endcan
