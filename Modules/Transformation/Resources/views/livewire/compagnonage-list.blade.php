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
                @foreach($compagnonages as $compagnonage)
                    <tr>
                        <th scope="row">{{ $compagnonage->id }}</th>
                        <td>{{ $compagnonage->comp_libcourt }}</td>
                        <td>{{ $compagnonage->comp_liblong }}</td>
                        @if ($mode == "gestion")
                            <td><a href="{{ route('transformation::compagnonages.show', $compagnonage->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                            <td><a href="{{ route('transformation::compagnonages.edit', $compagnonage->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                            @can('transformation::compagnonages.destroy')
                            <td>
                                
                                <x-form::form method="DELETE" :action="route('transformation::compagnonages.destroy', $compagnonage->id)">
                                <button class='btn btn-danger btn-sm' type='submit'>Supprimer</button>
                                </x-form::form> 
                            </td>
                            @endcan
                        @elseif ($mode == "selection")
                            <td>
                                <x-form::form method="POST" :action="route('transformation::fonctions.ajoutercompagnonage', $fonction->id)">
                                <input type='hidden' id='compagnonage_id' name='compagnonage_id' value='{{ $compagnonage->id }}'>
                                <button dusk="select-comp" type="submit" class="btn btn-primary btn-sm">Ajouter</a></td>
                                </x-form::form>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $compagnonages->links() !!}
        </div>
    </div>
</div>
