<div class="w-100">
    <input dusk="input-nom" wire:model.debounce.200ms="nom" placeholder="Nom..."></input>
    <input wire:model.debounce.200ms="prenom" placeholder="Prénom..."></input>
    <input wire:model.debounce.200ms="email" placeholder="Email..."></input>
    <input wire:model.debounce.200ms="nid" placeholder="nid..."></input>
    
    @if ($error)
        <div  wire:loading.remove class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
    @endif
    
    <div wire:loading> Recherche en cours... </div>
    @if (count($users))
    
       <table class="table-primary w-100">
            <thead>
            <tr class="table-primary">
                <th scope="col">Nom</th>
                <th scope="col">Prénom</th>
                <th scope="col">Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['nom'] }}</td>
                <td>{{ $user['prenomusuel'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>
                    @include('livewire.annudef-search-aide.actions', ['user' => $user])
                </td>
            </tr>
            @endforeach
        </table>
    @endif
</div>
