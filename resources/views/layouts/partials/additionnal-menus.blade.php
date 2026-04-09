
<x-filament::dropdown>
    <x-slot name="trigger">
        <x-filament::button>
            Accès rapide
        </x-filament::button>
    </x-slot>

<x-filament::dropdown.list>
    @foreach($menus as $menu)
        @if($menu->hasChildren())
            {{-- Parent : visible seulement si au moins un enfant est accessible --}}
            @if($menu->hasVisibleChildren())
                <x-filament::dropdown.list.item
                    tag="div"
                    x-data='{ subMenuOpen: false }'
                    x-on:click='subMenuOpen = ! subMenuOpen'
                    x-on:click.away='subMenuOpen = false'
                    x-on:keydown.escape.window='subMenuOpen = false'
                    class='flex relative'
                >
                    {{ $menu->getName() }}
                    <x-icon name="heroicon-o-chevron-right" class="w-4 h-4 ml-auto flex" />

                    <div class="ml-auto ml-4 w-full shadow-lg px-2 py-2" x-show="subMenuOpen">
                        @foreach($menu->getChildren() as $child)
                            @if($child->isVisible())
                                <div x-on:click="window.location.href = '{{ $child->getUrl() }}'"
                                    class="px-4 py-2 text-sm hover:text-gray-700 hover:bg-gray-100">
                                    {{ $child->getName() }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </x-filament::dropdown.list.item>
            @endif
        @else
            {{-- Lien simple --}}
            @if($menu->isVisible() && $menu->getUrl() !== '')
                <x-filament::dropdown.list.item tag="a" href="{{ $menu->getUrl() }}">
                    {{ $menu->getName() }}
                </x-filament::dropdown.list.item>
            @endif
        @endif
    @endforeach
</x-filament::dropdown.list>
</x-filament::dropdown>
