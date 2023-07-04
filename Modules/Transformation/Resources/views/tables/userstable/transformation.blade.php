 @can('transformation::users.attribuerfonction')
    <a href="{{ route('transformation::users.choisirfonction', $row->id) }}" class="btn btn-info btn-sm">Attribuer des fonctions</a>
@endcan
<a href="{{ route('transformation::transformation.livret', $row->id) }}" class="btn btn-warning btn-sm">Livret de transformation</a>
<a href="{{ route('transformation::transformation.progression', $row->id) }}" class="btn btn-primary btn-sm">Progression</a>
<a href="{{ route('transformation::transformation.fichebilan', $row->id) }}" class="btn btn-secondary btn-sm">Fiche bilan</a>
@can('transformation::users.stages')
    <a href="{{ route('transformation::users.stages', $row->id) }}" class="btn btn-danger btn-sm">Stages</a>
@endcan