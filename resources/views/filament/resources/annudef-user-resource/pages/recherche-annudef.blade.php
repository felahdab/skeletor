<x-filament-panels::page>
    <div>
        <form wire:submit="submit">
            {{ $this->form }}
            
            <div class="p-4">
                {{ $this->submitAction() }}
            </div>
        </form>
        
        <x-filament-actions::modals />
    </div>

    <div>
        {{ $this->table }}
    </div>
    
</x-filament-panels::page>
