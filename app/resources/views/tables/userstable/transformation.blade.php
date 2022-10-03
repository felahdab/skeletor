 @can('users.attribuerfonction')
    <a href="{{ route('users.choisirfonction', $row->id) }}" class="btn btn-info btn-sm">Attribuer des fonctions</a>
@endcan
<a href="{{ route('transformation.livret', $row->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
<a href="{{ route('transformation.progression', $row->id) }}" class="btn btn-primary btn-sm">Progression</a>
<a href="{{ route('transformation.fichebilan', $row->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
@can('stages.consulter')
    <a href="{{ route('users.stages', $row->id) }}" class="btn btn-danger btn-sm">Stages</a>
@endcan