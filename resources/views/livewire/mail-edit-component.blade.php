<div x-data="{
    selected_users : []
    }">
    
    <div class='row'>
        <div class='col'>
            <div>
                <label>Sujet: </label>
                <input dusk="input-sujet" class="form-control" wire:model.live='sujet'></input>
            </div>
            <textarea class="form-control mt-4" wire:model.live='corps' cols='40' rows='20'></textarea>
        </div>
        <div class='col'>
            <label>Aperçu: </label>
            <x-markdown>
                {!! $corps !!}
            </x-markdown>
        </div>
    </div>
    <div>
        {{ count($recipients) }} destinataires sélectionnés.
    </div>

     <div class="btn-group" role="groupe">
        <button class="btn btn-primary" x-on:click="$wire.sendToUsers()">Envoyer aux utilisateurs sélectionnés</button>
        
        <button dusk='input-enregistrer-btn' class="btn btn-secondary" x-on:click="$wire.save()">Enregistrer</button>
        <a dusk='input-retour-btn' href="{{route('mails.index')}}" class="btn btn-warning" >Retour</a>
    </div>
    <div class="mt-4">
        <livewire:users-table mode="listmarins">
    </div>
</div>

