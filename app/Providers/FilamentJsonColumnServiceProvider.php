<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;

use ValentinMorice\FilamentJsonColumn\FilamentJsonColumnServiceProvider as BaseProvider;

class FilamentJsonColumnServiceProvider extends BaseProvider
{
    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make('jsoneditor-js-cdn', app_path('Providers/resources/valentin-morice/jsoneditor.min.js')),
            Js::make('filament-json-column-js', base_path('vendor/valentin-morice/filament-json-column/resources/js/filament-json-column.js')),
            Css::make('filament-json-column', base_path('vendor/valentin-morice/filament-json-column/resources/css/filament-json-column.css')),
            Css::make('jsoneditor-css-cdn', app_path('Providers/resources/valentin-morice/jsoneditor.min.css')),
        ], 'filament-json-column');
    }
}
