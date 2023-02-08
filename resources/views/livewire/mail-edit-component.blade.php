<div x-data="{
    selected_users : []
    }">
    <div>
        <label>Sujet: </label>
        <input dusk="input-sujet" wire:model='sujet'></input>
    </div>
    <div class='flex'>
        <div style='width: 50%'>
            <textarea wire:model='corps' cols='40' rows='20'></textarea>
        </div>
        <div style='width: 50%'>
            <label>Aperçu: </label>
            <x-markdown>
                {!! $corps !!}
            </x-markdown>
        </div>
    </div>
    <div class="mt-2 mb-2">
        <label>Rechercher un/des utilisateurs</label>
        <input wire:model='query'></input>
        @foreach ($recipients as $recipient)
            <li> {{ $recipient->display_name }} </li>
        @endforeach
    </div>
     <div class="btn-group" role="groupe">
        <button class="btn btn-primary" x-on:click="$wire.sendToUsers()">Envoyer aux utilisateurs sélectionnés</button>
        <button class="btn btn-warning" x-on:click="$wire.sendToAllPriviledgedUsers()">Envoyer aux groupes em/tuteurs/admin/2ps</button>
        <button dusk='input-enregistrer-btn' class="btn btn-primary" x-on:click="$wire.save()">Enregistrer</button>
        <a dusk='input-retour-btn' href="{{route('mails.index')}}" class="btn btn-default" >Retour</button>
    </div>
</div>

