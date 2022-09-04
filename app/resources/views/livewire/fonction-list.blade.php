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
                @foreach($fonctions as $fonction)
                    <tr>
                        <th scope="row">{{ $fonction->id }}</th>
                        <td>{{ $fonction->fonction_libcourt }}</td>
                        <td>{{ $fonction->fonction_liblong }}</td>
                        @if ($mode == 'gestion')
                            <td><a href="{{ route('fonctions.show', $fonction->id) }}" class="btn btn-primary btn-sm">Consulter</a></td>
                            <td><a href="{{ route('fonctions.edit', $fonction->id) }}" class="btn btn-info btn-sm">Editer</a></td>
                            @can('fonctions.destroy')
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['fonctions.destroy', $fonction->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                            @endcan
                        @elseif($mode == 'transformation')
                            <td><a href="{{ route('fonctions.choixmarins', $fonction->id) }}" class="btn btn-primary btn-sm">Validation collective</a></td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $fonctions->links() !!}
        </div>
    </div>
</div>
