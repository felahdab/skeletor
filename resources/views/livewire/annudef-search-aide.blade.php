<div>
    <div class="input-group mt-4">
        <input class="form-control" dusk="input-nom" wire:model.debounce.200ms="nom" placeholder="Nom..."></input>
        <input class="form-control" wire:model.debounce.200ms="prenom" placeholder="Prénom..."></input>
        <input class="form-control" wire:model.debounce.200ms="email" placeholder="Email..."></input>
        <input class="form-control" wire:model.debounce.200ms="nid" placeholder="nid..."></input>
    </div>
    
    @if ($error)
        <div  wire:loading.remove class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
    @endif
    
    <div wire:loading> Recherche en cours... </div>
    @if (count($users))
    
    <table class="table table-sm table-hover  table-striped mt-4">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Grade</th>
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($users as $user)
            <tr>
                <td>
                    @include('livewire.annudef-search-aide.actions', ['user' => $user])
                </td>
                <td>{{ $user['gradecourt'] }}</td>
                <td>{{ $user['nom'] }}</td>
                <td>{{ $user['prenomusuel'] }}</td>
                <td>{{ $user['email'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
