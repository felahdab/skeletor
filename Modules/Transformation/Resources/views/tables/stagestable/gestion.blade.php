<a href="{{ route('transformation::stages.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
@can('transformation::stages.destroy')

    <x-form::form method="DELETE" :action="route('transformation::stages.destroy', $row->id)">
        <button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>
    </x-form::form>

@endcan