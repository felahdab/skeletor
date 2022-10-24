<div>
    <input wire:model.debounce.200ms="nom" placeholder="Nom..."></input>
    <input wire:model.debounce.200ms="prenom" placeholder="Prénom..."></input>
    <input wire:model.debounce.200ms="email" placeholder="Email..."></input>
    <input wire:model.debounce.200ms="entite" placeholder="Entite..."></input>
    <input wire:model.debounce.200ms="nid" placeholder="nid..."></input>
    
    @if ($error)
        <div  wire:loading.remove class="alert alert-danger text-center" role="alert">
            <i class="fa fa-check"></i>
            {{ $error }}
        </div>
    @endif
    
    <div wire:loading> Recherche en cours... </div>
    @if (count($users))
       <table>
            <thead>
            <tr>
                <th scope="col">titre</th>
                <th scope="col">nom</th>
                <th scope="col">prenom</th>
                <th scope="col">gradelong</th>
                <th scope="col">gradecourt</th>
                <th scope="col">nid</th>
                <th scope="col">nomaffiche</th>
                <th scope="col">email</th>
                <th scope="col">unites</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user['titre'] }}</td>
                <td>{{ $user['nom'] }}</td>
                <td>{{ $user['prenomusuel'] }}</td>
                <td>{{ $user['gradelong'] }}</td>
                <td>{{ $user['gradecourt'] }}</td>
                <td>{{ $user['nid'] }}</td>
                <td>{{ $user['nomaffiche'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['unites'] }}</td>
            </tr>
            @endforeach
        </table>
    @endif
</div>
