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
                <th scope="col" width="8%">Libelle court</th>
                <th scope="col">Libelle long</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($objectifs as $objectif)
                    <tr>
                        <th scope="row">{{ $objectif->id }}</th>
                        <td>{{ $objectif->objectif_libcourt }}</td>
                        <td>{{ $objectif->objectif_liblong }}</td>
                        <td><a href="{{ route('objectifs.show', $objectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('objectifs.edit', $objectif->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        @can('objectifs.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['objectifs.destroy', $objectif->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $objectifs->links() !!}
        </div>
</div>
