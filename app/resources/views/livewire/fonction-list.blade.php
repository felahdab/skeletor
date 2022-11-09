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
                            <a href="{{ route('fonctions.show', $fonction->id) }}" class="btn btn-primary btn-sm">Consulter</a>
                            <a href="{{ route('fonctions.edit', $fonction->id) }}" class="btn btn-info btn-sm">Modifier</a>
                            @can('fonctions.destroy')
                                {!! Form::open(['method' => 'DELETE','route' => ['fonctions.destroy', $fonction->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            
                            @endcan
                        @elseif($mode == 'transformation')
                            <a href="{{ route('fonctions.choixmarins', $fonction->id) }}" class="btn btn-info btn-sm">Validation collective</a>
                            <a href="{{ route('fonctions.listemarinsfonction', $fonction->id) }}" class="btn btn-primary btn-sm">Liste des marins ayant cette fonction</a>
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
