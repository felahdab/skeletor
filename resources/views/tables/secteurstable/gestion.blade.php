<a href="{{ route('secteurs.show', $row) }}" class="btn btn-secondary btn-sm float-right">Consulter</a>
<a href="{{ route('secteurs.edit', $row) }}" class="btn btn-info btn-sm float-right">Modifier</a>
@can('secteurs.destroy')
<x-form::form method="DELETE" :action="route('secteurs.destroy', $row->id)">
    <button type='submit' class='btn btn-danger btn-sm' dusk='delete-btn'>Supprimer</button>    
</x-form::form>
@endcan