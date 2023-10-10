<a href="{{ route('groupement.show', $row) }}" class="btn btn-secondary btn-sm float-right">Consulter</a>
<a href="{{ route('groupement.edit', $row) }}" class="btn btn-info btn-sm float-right">Modifier</a>
@can('groupement.destroy')
    {!! Form::open(['method' => 'DELETE','route' => ['groupement.destroy', $row->id], 'style'=>'display:inline' ]) !!}
    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm', 'dusk' => 'delete-btn']) !!}
    {!! Form::close() !!}
@endcan