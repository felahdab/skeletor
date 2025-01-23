<a href="{{ route('groupement.show', $row) }}" class="btn btn-secondary btn-sm float-right">Consulter</a>
<a href="{{ route('groupement.edit', $row) }}" class="btn btn-info btn-sm float-right">Modifier</a>
@can('groupement.destroy')
<x-form::form method="DELETE" :action="route('groupement.destroy', $row->id)">
    <button type='submit' class='btn btn-danger btn-sm' dusk='delete-btn'>Supprimer</button>
</x-form::form>
@endcan