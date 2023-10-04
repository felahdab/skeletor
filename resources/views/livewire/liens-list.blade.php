<div>
     <input wire:model='filter' type="text" placeholder="Filtrer...">

    <div wire:loading>
        Chargement...
    </div>

    <div wire:loading.remove>
        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col" width="1%">#</th>
                <th scope="col" width="5%">Image</th>
                <th scope="col">Libellé</th>
                <th scope="col">URL</th>
                <th scope="col" width="1%"></th>    
            </tr>
            </thead>
            <tbody>
                @foreach($liens as $lien)
                    <tr>
                        <th scope="row">{{ $lien->id }}</th>
                        <td><img src="{{asset('public/images/' . $lien->lien_image)}}" alt="logo" style="height: 20px;"></td>
                        <td>{{ $lien->lien_lib }}</td>
                        <td>{{ $lien->lien_url }}</td>
                        <td><a href="{{ route('liens.edit', $lien->id) }}" class="btn btn-info btn-sm">Modifier</a></td>
                        <td>            
                            <x-form::form method="DELETE" :action="route('liens.destroy', $lien->id)">
                            <button class="btn btn-danger btn-sm" type="submit" dusk="delete-btn">Supprimer</button>
                            </x-form::form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            {!! $liens->withQueryString()->links() !!}
        </div>
    </div>

</div>
