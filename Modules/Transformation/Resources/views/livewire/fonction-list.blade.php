<div class="mt-4">
    <input wire:model='filter' type="text" placeholder="Filtrer...">

    <div wire:loading>
        Chargement...
    </div>

    <div wire:loading.remove>

         <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="15%">Libellé court</th>
                <th scope="col">Libellé long</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>    
            </tr>
            </thead>
            <tbody>
                @foreach($fonctions as $fonction)
                    <tr>
                        <th scope="row">{{ $fonction->id }}</th>
                        <td>{{ $fonction->fonction_libcourt }}</td>
                        <td>{{ $fonction->fonction_liblong }}</td>
                        <td>{{ $fonction->type_fonction->typfonction_libcourt }}</td>
                        <td>
                        @if ($mode == 'gestion')
                            <a href="{{ route('transformation::fonctions.show', $fonction->id) }}" class="btn btn-primary btn-sm">Consulter</a>
                            <a href="{{ route('transformation::fonctions.edit', $fonction->id) }}" class="btn btn-info btn-sm">Modifier</a>
                            @can('transformation::fonctions.destroy')
                                <x-form::form method="DELETE" :action="route('transformation::fonctions.destroy', $fonction->id)">
                                <button class="btn btn-danger btn-sm" type="submit" dusk="delete-btn">Supprimer</button>
                                </x-form::form>
                            @endcan
                        @elseif($mode == 'transformation')
                            @can('transformation::fonctions.validermarins')
                                <a href="{{ route('transformation::fonctions.choixmarins', $fonction->id) }}" class="btn btn-info btn-sm">Validation collective</a>
                            @endcan
                            <a href="{{ route('transformation::fonctions.listemarinsfonction', $fonction->id) }}" class="btn btn-primary btn-sm">Liste marins</a>
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $fonctions->links() !!}
        </div>
    </div>
</div>
