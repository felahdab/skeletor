<div>
    <input wire:model='filter' type="text" placeholder="Filtrer...">

    <div wire:loading>
        Chargement...
    </div>

    <div wire:loading.remove>
        <table class="table table-striped">
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
                            <td><a href="{{ route('objectifs.show', $objectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                            <td><a href="{{ route('objectifs.edit', $objectif->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                            @can('objectifs.destroy')
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['objectifs.destroy', $objectif->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                            @endcan
                         @elseif ($mode == "selection")
                            <td>
                                {!! Form::open(['method' => 'POST','route' => ['taches.ajouterobjectif', $tache->id] ]) !!}
                                <input type='hidden' id='objectif_id' name='objectif_id' value='{{ $objectif->id }}'>
                                <button type="submit" class="btn btn-primary btn-sm">Ajouter</a></td>
                                {!! Form::close() !!}
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
