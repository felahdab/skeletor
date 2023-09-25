<a href="{{ route('transformation::miseenvisibilite.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
@can('transformation::miseenvisibilite.destroy')
    {!! Form::open(['method' => 'DELETE','route' => ['transformation::miseenvisibilite.destroy', $row->id], 'style'=>'display:inline' ]) !!}
    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm', 'dusk' => 'delete-btn']) !!}
    {!! Form::close() !!}
@endcan

