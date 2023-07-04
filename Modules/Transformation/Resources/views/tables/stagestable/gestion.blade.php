<a href="{{ route('transformation::stages.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
@can('transformation::stage.destroy')

    {!! Form::open(['method' => 'DELETE','route' => ['transformation::stages.destroy', $row->id],'style'=>'display:inline']) !!}
    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
    {!! Form::close() !!}

@endcan