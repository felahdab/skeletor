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
                @foreach($compagnonages as $compagnonage)
                    <tr>
                        <th scope="row">{{ $compagnonage->id }}</th>
                        <td>{{ $compagnonage->comp_libcourt }}</td>
                        <td>{{ $compagnonage->comp_liblong }}</td>
                        <td><a href="{{ route('compagnonages.show', $compagnonage->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('compagnonages.edit', $compagnonage->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        @can('compagnonages.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['compagnonages.destroy', $compagnonage->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $compagnonages->links() !!}
        </div>
    </div>
</div>
