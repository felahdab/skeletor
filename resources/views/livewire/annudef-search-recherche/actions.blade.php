<div class="btn-group btn-group-sm" role="groupe">
@if (array_key_exists('nexistepas', $user))
    <button x-on:click="$wire.createLocalUser('{{ $loop->index }}')" class='btn btn-primary btn-sm'>Créer la fiche</button>
@endif
@if (array_key_exists('archive', $user))
    <button x-on:click="$wire.conservcpte('{{ $loop->index }}')"  class="btn btn-success  btn-sm">Restaurer <u><strong>AVEC</strong></u> données</button>
    <button x-on:click="$wire.effacecpte('{{ $loop->index }}')" class="btn btn-info  btn-sm">Restaurer <u><strong>SANS</strong></u> données</button>
@endif
@if (array_key_exists('nompasidentique', $user))
    <button x-on:click="$wire.aligneNom('{{ $loop->index }}')" class='btn btn-warning  btn-sm'>Ajuster le nom</button>
@endif
@if (array_key_exists('prenompasidentique', $user))
    <button x-on:click="$wire.alignePrenom('{{ $loop->index }}')" class='btn btn-secondary  btn-sm'>Ajuster le prénom</button>
@endif
@if (array_key_exists('nidpasidentique', $user))
    <button x-on:click="$wire.aligneNid('{{ $loop->index }}')" class='btn btn-danger  btn-sm'>Ajuster le NID</button>
@endif
@if (array_key_exists('gradepasidentique', $user))
    <button x-on:click="$wire.aligneGrade('{{ $loop->index }}')" class='btn btn-info  btn-sm'>Ajuster le grade</button>
@endif
</div>