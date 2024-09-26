@can('archives.restore')
    @if ($row->deleted_at)
        <a href="{{ route('archives.restore', $row) }}" class="btn btn-success btn-sm" dusk="restaur-user">Restaurer</a>
    @endif
@endcan
@can('archives.destroy')
    <a href="{{ route('archives.destroy', $row->id) }}" class="btn btn-danger btn-sm" dusk="delete-user">Supprimer</a>
@endcan
