@auth
<x-filament::modal id="report-bug-or-suggestion" width="5xl">
    <x-slot name="heading">
    {{__('Signaler un bug ou faire une suggestion') }}
    </x-slot>
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button class='mt-6' color="danger" x-on:click="$dispatch('close-modal', { id: 'report-bug-or-suggestion' }); ">
            Annuler
        </x-filament::button>

        <x-filament::button class='mt-6' type="submit">
            Envoyer
        </x-filament::button>
    </form>
</x-filament::modal>
@endauth