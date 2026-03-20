<?php

namespace App\Filament\PanelRegistry;

use Illuminate\Support\Arr;

class ModuleDefinedMenusRegistry
{
    private array $directmenuitems = [];

    public function __construct() {}

    public function registerDirectMenuItems(array|DirectMenuItem $menuItem): void
    {
        $menuItem = Arr::wrap($menuItem);
        foreach ($menuItem as $item) {
            if (!$item instanceof DirectMenuItem) {
                throw new \InvalidArgumentException('Direct menu item must be an instance of DirectMenuItem');
            }
            $this->directmenuitems[] = $item;
        }
    }

    public function getDirectMenuItems(): array
    {
        return $this->directmenuitems;
    }
}
