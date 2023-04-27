<div x-data="{
    selected_users : []
    }">
    
    <div class='flex'>
        <div style='width: 50%'>
            <div>
                <label>Sujet: </label>
                <input dusk="input-sujet" class="form-control" wire:model='sujet'></input>
            </div>
            <textarea class="form-control mt-4" wire:model='corps' cols='40' rows='20'></textarea>
        </div>
        <div style='width: 50%'>
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
        <livewire:users-table mode="dashboard">
    </div>
</div>

