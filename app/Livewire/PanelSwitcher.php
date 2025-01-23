<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class PanelSwitcher extends Widget
{
    protected static string $view = 'livewire.panel-switcher';

    protected int | string | array $columnSpan = 2;

}
