<div>
    <input wire:model='filter' type="text" placeholder="Filtrer...">

    <div wire:loading>
        Chargement...
    </div>

    <div wire:loading.remove>
        <div class="d-flex">
            {!! $stages->links() !!}
        </div>
    </div>
</div>
