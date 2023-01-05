@can('users.update')
    <a href="{{ route('archivage.restaurer', $row->id) }}" class="btn btn-info btn-sm">Restaurer</a>
@endcan
@can('users.destroy')
    <a href="{{ route('archivage.archiver', $row->id) }}" class="btn btn-danger btn-sm">Archivage</a>
@endcan
