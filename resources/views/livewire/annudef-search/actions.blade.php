<div class="btn-group" role="groupe">
@if (array_key_exists('nexistepas', $user))
    <button x-on:click="$wire.createLocalUser('{{ $loop->index }}')" class='btn btn-primary'>Créer la fiche</button>
@endif
@if (array_key_exists('nompasidentique', $user))
    <button x-on:click="$wire.aligneNom('{{ $loop->index }}')" class='btn btn-warning'>Ajuster le nom</button>
@endif
@if (array_key_exists('prenompasidentique', $user))
    <button x-on:click="$wire.alignePrenom('{{ $loop->index }}')" class='btn btn-secondary'>Ajuster le prénom</button>
@endif
@if (array_key_exists('nidpasidentique', $user))
    <button x-on:click="$wire.aligneNid('{{ $loop->index }}')" class='btn btn-danger'>Ajuster le NID</button>
@endif
@if (array_key_exists('gradepasidentique', $user))
    <button x-on:click="$wire.aligneGrade('{{ $loop->index }}')" class='btn btn-info'>Ajuster le grade</button>
@endif
</div>