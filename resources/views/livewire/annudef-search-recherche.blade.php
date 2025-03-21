<div>
    <div class="input-group">
        <input class="mx-2 form-control" type="text" dusk="input-nom" wire:model.live.debounce.200ms="nom" placeholder="Nom..."></input>
        <input class="mx-2 form-control" type="text" wire:model.live.debounce.200ms="prenom" placeholder="Prénom..."></input>
        <input class="mx-2 form-control" type="text" wire:model.live.debounce.200ms="email" placeholder="Email..."></input>
        <input class="mx-2 form-control" type="text" wire:model.live.debounce.200ms="entite" placeholder="Entite..."></input>
        <input class="mx-2 form-control" type="text" wire:model.live.debounce.200ms="nid" placeholder="nid..."></input>
    </div>
    
    @if ($error)
        <div  wire:loading.remove class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
    @endif
    
    <div wire:loading> Recherche en cours... </div>
    @if (count($users))
    <div class="btn-group mt-4 w-100" role="groupe">
        <button x-on:click="$wire.createAllLocalUser()" class='btn btn-primary'>Créer toutes les fiches manquantes</button>
        <button x-on:click="$wire.aligneAllNom()" class='btn btn-warning'>Ajuster tous les noms</button>
        <button x-on:click="$wire.aligneAllPrenom()" class='btn btn-secondary'>Ajuster tous les prénoms</button>
        <button x-on:click="$wire.aligneAllNid()" class='btn btn-danger'>Ajuster tous les NID</button>
        <button x-on:click="$wire.aligneAllGrade()" class='btn btn-info'>Ajuster tous les grades</button>
    </div>

    <table class="table table-sm table-hover table-bordered mt-4">
        <thead class="text-center align-middle table-light ">
            <tr>
                <th scope="col">Titre</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Grade long</th>
                <th scope="col">Grade court</th>
                <th scope="col">NID</th>
                <th scope="col">Email</th>
                <th scope="col">Unité</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['titre'] }}</td>
                <td>{{ $user['nom'] }}</td>
                <td>{{ $user['prenomusuel'] }}</td>
                <td>{{ $user['gradelong'] }}</td>
                <td>{{ $user['gradecourt'] }}</td>
                <td>{{ $user['nid'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['unites'] }}</td>
                <td>
                    @include('livewire.annudef-search-recherche.actions', ['user' => $user])
                </td>
            </tr>
            @endforeach
    </table>
    @endif
</div>
