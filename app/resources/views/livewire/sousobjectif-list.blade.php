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
                <th scope="col" width="60%">Libellé</th>
                <th scope="col" width="5%">Coefficient</th>
                <th scope="col" width="5%">Durée</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($sousobjectifs as $sousobjectif)
                    <tr>
                        <th scope="row">{{ $sousobjectif->id }}</th>
                        <td>{{ $sousobjectif->ssobj_lib }}</td>
                        <td>{{ $sousobjectif->ssobj_coeff }}</td>
                        <td>{{ $sousobjectif->ssobj_duree }}</td>
                        <td><a href="{{ route('sous-objectifs.show', $sousobjectif->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('sous-objectifs.edit', $sousobjectif->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                        @can('sousobjectifs.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['sous-objectifs.destroy', $sousobjectif->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $sousobjectifs->links() !!}
        </div>
    </div>
</div>
