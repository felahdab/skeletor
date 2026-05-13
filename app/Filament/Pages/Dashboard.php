<?php

namespace App\Filament\Pages;

use App\Livewire\PanelSwitcher;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Accueil Poseidon';
   

    public function getWidgets(): array
    {
        return [PanelSwitcher::class];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
