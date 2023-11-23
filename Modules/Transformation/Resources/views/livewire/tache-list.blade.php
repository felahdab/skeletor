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
                @foreach($taches as $tache)
                    <tr>
                        <th scope="row">{{ $tache->id }}</th>
                        <td>{{ $tache->tache_libcourt }}</td>
                        <td>{{ $tache->tache_liblong }}</td>
                        @if ($mode == "gestion")
                            <td><a href="{{ route('transformation::taches.show', $tache->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                            <td><a href="{{ route('transformation::taches.edit', $tache->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                            @can('transformation::taches.destroy')
                            <td>
                                <x-form::form method="DELETE" :action="route('transformation::taches.destroy', $tache->id)">
                                <button class="btn btn-danger btn-sm" type="submit" dusk="delete-btn">Supprimer</button>
                                </x-form::form>
                            </td>
                            @endcan
                        @elseif ($mode == "selection")
                            <td>
                                <x-form::form method="POST" :action="route('transformation::compagnonages.ajoutertache', $compagnonage->id)">
                                <input type='hidden' id='tache_id' name='tache_id' value='{{ $tache->id }}'>
                                <button dusk="select-tache" type="submit" class="btn btn-primary btn-sm">Ajouter</a></td>
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
            {!! $taches->withQueryString()->links() !!}
        </div>
    </div>

</div>
