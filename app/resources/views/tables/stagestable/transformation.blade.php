<td><a href="{{ route('stages.show', $row->id ) }}" class="btn btn-info btn-sm">Consulter</a></td>
<td><a href="{{ route('stages.choixmarins', ['stage' => $row->id] ) }}" class="btn btn-primary btn-sm">Validation ou annulation collective</a></td>
<td></td>