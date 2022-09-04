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
                <th scope="col" width="1%" colspan="4"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($stages as $stage)
                    <tr>
                        <th scope="row">{{ $stage->id }}</th>
                        <td>{{ $stage->stage_libcourt }}</td>
                        <td>{{ $stage->stage_liblong }}</td>
                        <td><a href="{{ route('stages.consulter', ['stage' => $stage->id] ) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                        <td><a href="{{ route('stages.edit', $stage->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                        @can('stage.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['stages.destroy', $stage->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $stages->links() !!}
        </div>
    </div>
</div>
