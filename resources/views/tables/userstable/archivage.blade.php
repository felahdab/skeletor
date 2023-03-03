@can('users.update')
    @if ($row->deleted_at)
        <a href="{{ route('archivage.conservcpte', $row) }}" class="btn btn-success btn-sm">Restaurer <u><strong>AVEC</strong></u> données</a>
        <a href="{{ route('archivage.effacecpte', $row) }}" class="btn btn-info btn-sm">Restaurer <u><strong>SANS</strong></u> données</a>
    @endif
@endcan
<a href="{{ route('archivage.imprimer', $row->id) }}" class="btn btn-primary btn-sm">Télécharger livret</a>
@can('users.destroy')
    @if($row->date_archivage)
        <a href="{{ route('archivage.supprimer', $row->id) }}" class="btn btn-danger btn-sm">Supprimer totalement</a>
    @else
        <a href="{{ route('archivage.archiver', $row->id) }}" class="btn btn-secondary btn-sm">Archiver</a>
    @endif
@endcan
