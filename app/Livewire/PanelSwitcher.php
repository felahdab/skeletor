<?php

namespace App\Livewire;

use Filament\Facades\Filament;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PanelSwitcher extends Widget
{
    protected string $view = 'livewire.panel-switcher';
    protected array|int|string $columnSpan = 'full';

    protected function getViewData(): array
    {
        $moduleMeta = $this->loadModuleMeta();
        $currentId  = filament()->getCurrentPanel()->getId();

        $panels = collect(Filament::getPanels())
            ->filter(fn ($panel) => $panel->getId() !== $currentId)
            ->filter(function ($panel) {
                // masquer si guest et panel protégé
                if (!auth()->check()) {
                    return $panel->getAuthMiddleware() === [];
                }
                return true;
            })
            ->map(function ($panel) use ($moduleMeta) {
                $alias = $panel->getId();
                $meta  = $moduleMeta[$alias] ?? [];
                $url   = tenant()
                    ? Str::of(url($panel->getPath()))->replace('{tenant}', tenant()->id)
                    : url($panel->getPath());

                return [
                    'id'          => $alias,
                    'label'       => $meta['name']        ?? Str::ucfirst($alias),
                    'description' => $meta['description'] ?? '',
                    'icon'        => $meta['icon']        ?? 'heroicon-o-squares-2x2',
                    'doc'         => $meta['doc']         ?? null,
                    'url'         => $url,
                ];
            })
            ->values();

        return ['panels' => $panels];
    }

    private function loadModuleMeta(): array
    {
        $meta = [];
        foreach (File::directories(base_path('Modules')) as $moduleDir) {
            $jsonPath = $moduleDir . '/module.json';
            if (!File::exists($jsonPath)) continue;
            $data  = json_decode(File::get($jsonPath), true) ?? [];
            $alias = $data['alias'] ?? strtolower(basename($moduleDir));
            $meta[$alias] = $data;
        }
        return $meta;
    }
}
