@can('users.update')
    @if ($row->deleted_at)
        <a href="{{ route('archivage.restaurer', $row->id) }}" class="btn btn-info btn-sm">Restaurer</a>
    @endif
@endcan
<a href="{{ route('archivage.imprimer', $row->id) }}" class="btn btn-primary btn-sm">Télécharger livret</a>
@can('users.destroy')
    @if ($row->date_debarq)
        <a href="{{ route('archivage.archiver', $row->id) }}" class="btn btn-danger btn-sm">Archivage</a>
    @endif
@endcan
