<div class="mt-4">
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
                <th scope="col">Licence</th>
                <th scope="col" width="25%" colspan="4"></th>    
            </tr>
        </thead>
        <tbody>
            @foreach($stages as $stage)
                <tr>
                    <th scope="row">{{ $stage->id }}</th>
                    <td>{{ $stage->stage_libcourt }}</td>
                    <td>{{ $stage->stage_liblong }}</td>
                    <td>{{ $stage->type_licence->typlicense_libcourt}}</td>
                    @if ($mode=="gestion")
                        <td><a href="{{ route('transformation::stages.choixmarins', ['stage' => $stage->id] ) }}" class="btn btn-primary btn-sm">Validation ou annulation collective</a></td>
                        <td><a href="{{ route('transformation::stages.edit', $stage->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                        @can('transformation::stage.destroy')
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['transformation::stages.destroy', $stage->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                        @endcan
                    @elseif ($mode=="transformation")
                        <td><a href="{{ route('transformation::stages.show', $stage->id ) }}" class="btn btn-info btn-sm">Consulter</a></td>
                        <td><a href="{{ route('transformation::stages.choixmarins', ['stage' => $stage->id] ) }}" class="btn btn-primary btn-sm">Validation ou annulation collective</a></td>
                        <td></td>
                    @elseif ($mode=='selection')
                        <td colspan="3"> 
                            {!! Form::open(['method' => 'POST','route' => ['transformation::fonctions.ajouterstage', $fonction->id] ]) !!}
                            <input type='hidden' id='stage_id' name='stage_id' value='{{ $stage->id }}'>
                            <button type="submit" class="btn btn-primary btn-sm">Ajouter</a></td>
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        </table>
        <div class="d-flex">
            {!! $stages->links() !!}
        </div>
    </div>
</div>