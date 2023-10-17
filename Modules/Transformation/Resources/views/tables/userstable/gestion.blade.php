<a href="{{ route('users.edit', $row->id) }}" class="btn btn-info btn-sm">Modifier</a>
@can('users.destroy')
    <x-form::form method="DELETE" :action="route('users.destroy', $row->id)">
        <button type='submit' class='btn btn-danger btn-sm' dusk='delete-btn'>Supprimer</button>
    </x-form::form>
@endcan
@can('changepasswd.allusers')
    <a href="{{ route('changepasswd.show', $row->id) }}" class="btn btn-secondary btn-sm">Changer le mot de passe</a>
@endcan
@can('impersonate')
    <a href="{{ route('impersonate', $row->id) }}" class="btn btn-danger btn-sm">Se faire passer pour</a>
@endcan
