@can('users.update')
    <a href="{{ route('archivage.restaurer', $row->id) }}" class="btn btn-info btn-sm">Restaurer</a>
@endcan
<a href="{{ route('archivage.imprimer', $row->id) }}" class="btn btn-primary btn-sm">Télécharger livret</a>
@can('users.destroy')
    <a href="{{ route('archivage.archiver', $row->id) }}" class="btn btn-danger btn-sm">Archivage</a>
@endcan
