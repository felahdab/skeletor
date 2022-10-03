<td><a href="{{ route('stages.choixmarins', ['stage' => $row->id] ) }}" class="btn btn-primary btn-sm">Validation ou annulation collective</a></td>
<td><a href="{{ route('stages.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
@can('stage.destroy')
<td>
    {!! Form::open(['method' => 'DELETE','route' => ['stages.destroy', $row->id],'style'=>'display:inline']) !!}
    {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
    {!! Form::close() !!}
</td>
@endcan