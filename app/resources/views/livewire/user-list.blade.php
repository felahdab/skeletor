<div>
    <input wire:model='filter' type="text" placeholder="Filtrer...">
    <div wire:loading>
        Chargement...
    </div>
    <div wire:loading.remove>
        {{ $users->links() }}
    </div>
</div>
