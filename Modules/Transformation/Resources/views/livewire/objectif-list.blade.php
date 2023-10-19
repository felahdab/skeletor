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
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($objectifs as $objectif)
                    <tr>
                        <th scope="row">{{ $objectif->id }}</th>
                        <td>{{ $objectif->objectif_libcourt }}</td>
                        <td>{{ $objectif->objectif_liblong }}</td>
                        @if ($mode == "gestion")
                            <td><a href="{{ route('transformation::objectifs.show', $objectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                            <td><a href="{{ route('transformation::objectifs.edit', $objectif->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                            @can('transformation::objectifs.destroy')
                            <td>
                                <x-form::form method="DELETE" :action="route('transformation::objectifs.destroy', $objectif->id)">
                                    <button type='submit' class='btn btn-danger btn-sm'>Supprimer</button>
                                </x-form::form>
                            </td>
                            @endcan
                         @elseif ($mode == "selection")
                            <td>
                                <x-form::form method="POST" :action="route('transformation::taches.ajouterobjectif', [$tache, $objectif])">
                                    <button type="submit" class="btn btn-primary btn-sm">Ajouter</a></td>
                                </x-form::form>
                            </td>
                            <td></td>
                            <td></td>
                         @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $objectifs->links() !!}
        </div>
</div>
