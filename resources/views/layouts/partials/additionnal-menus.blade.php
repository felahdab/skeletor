<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            Accès direct aux autres modules
        </x-filament::button>
    </x-slot>
    
    <x-filament::dropdown.list>
        @foreach($menus as $menu)
            @if($menu->isVisible())
            <x-filament::dropdown.list.item 
                tag="a"
                href="{{ $menu->getUrl() }}"
                x-data='{ subMenuOpen: false }'
                x-on:click='subMenuOpen = ! subMenuOpen'
                x-on:click.away='subMenuOpen = false'
                x-on:keydown.escape.window='subMenuOpen = false'
                class='flex relative'
            >
                {{ $menu->getName() }} @if($menu->hasChildren()) <x-icon name="heroicon-o-chevron-right" class="w-4 h-4 ml-auto flex" /> @endif

                @if($menu->hasChildren())
                <div
                    class="ml-auto ml-4 w-full shadow-lg px-2 py-2"
                    x-show="subMenuOpen"
                >
                    @foreach($menu->getChildren() as $child)
                        @if($child->isVisible())
                            <div x-on:click="window.location.href = '{{ $child->getUrl() }}'"
                                class="px-4 py-2 text-sm hover:text-gray-700 hover:bg-gray-100">
                                {{ $child->getName() }}
                            </div>
                        @endif
                    @endforeach
                </div
                @endif

            </x-filament::dropdown.list.item>
            @endif

        @endforeach
    </x-filament::dropdown.list>
</x-filament::dropdown>