<a href="{{ route('services.show', $row) }}" class="btn btn-secondary btn-sm float-right">Consulter</a>
<a href="{{ route('services.edit', $row) }}" class="btn btn-info btn-sm float-right">Modifier</a>
@can('services.destroy')
<x-form::form method="POST" :action="route('bugreports.store')">
    <button type='submit' class='btn btn-danger btn-sm' dusk='delete-btn'>Supprimer</button>
</x-form::form>
@endcan