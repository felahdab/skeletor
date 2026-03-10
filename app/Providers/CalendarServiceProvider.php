<?php

namespace App\Providers;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Guava\Calendar\Widgets\CalendarWidget;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

use Guava\Calendar\CalendarServiceProvider as BaseProvider;

class CalendarServiceProvider extends BaseProvider
{

    protected function getPackageBaseDir(): string
    {
        return base_path("vendor/guava/calendar/src");
    }


    public function packageBooted(): void
    {
        //Livewire::component('calendar-widget', CalendarWidget::class);

        FilamentAsset::register(
            assets: [
                AlpineComponent::make(
                    'calendar',
                     base_path('vendor/guava/calendar/dist/js/calendar.js'),
                ),
                AlpineComponent::make(
                    'calendar-context-menu',
                    base_path('vendor/guava/calendar/dist/js/calendar-context-menu.js'),
                ),
                AlpineComponent::make(
                    'calendar-event',
                    base_path('vendor/guava/calendar/dist/js/calendar-event.js'),
                ),
                Css::make('calendar-styles', app_path('Providers/resources/guava/event-calendar.min.css')),
                Js::make('calendar-script', app_path('Providers/resources/guava/event-calendar.min.js')),
            ],
            package: 'guava/calendar'
        );
    }
}
