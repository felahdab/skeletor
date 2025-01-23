<div>
    <h1>{{ $count }}</h1>
 
    <button wire:click="increment">+</button>
 
    <button wire:click="decrement">-</button>

    <form wire:submit="save">
        <input type="file" wire:model.live="photo">
     
        @error('photo') <span class="error">{{ $message }}</span> @enderror
     
        <button type="submit">Save photo</button>
    </form>
    
    <div x-data="{ count: 0 }">
        <!-- Render the current "count" value inside an element... -->
        <h2 x-text="count"></h2>
     
        <!-- Increment the "count" value by "1" when a click event is dispatched... -->
        <button x-on:click="count++">+</button>
    </div>

    @livewire('full-calendar')
</div>
