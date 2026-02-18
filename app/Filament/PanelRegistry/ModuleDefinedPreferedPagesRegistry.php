<?php

namespace App\Filament\PanelRegistry;

use InvalidArgumentException;
use Illuminate\Support\Arr;

class ModuleDefinedPreferedPagesRegistry
{
    private array $preferedpages=[];

    public function __construct()
    {
        $this->preferedpages[] = PreferedPageItem::make()
            ->name("Page par défaut de l'application")
            ->routeName(fn() => null);
    }

    public function registerPreferedPagesItems(array | PreferedPageItem $preferedPageItem): void
    {
        $preferedPageItem = Arr::wrap($preferedPageItem);
        foreach($preferedPageItem as $item) {
            //dump($item);
            if (!($item instanceof PreferedPageItem)) {
                throw new InvalidArgumentException('Prefered page item must be an instance of PreferedPageItem');
            }
            $this->preferedpages[] = $item;
        }
    }

    public function getPreferedPagesItems(): array
    {
        return $this->preferedpages;
    }

    public function getPreferedPagesItemsForSelect()
    {
        return collect($this->preferedpages)
            ->filter(function ($item)
            {
                return $item->isVisible();
            })
            ->map(function ($item)
            {
                return (object) [
                    "name" => $item->getName(),
                    "routename" => $item->getRouteName()
                ];
            })
            ->pluck("name", "routename");
    }
}
