<?php

namespace App\Providers;

use App\View\Components\Asantibanez\LaravelBladeSortable\Scripts;
use App\View\Components\Asantibanez\LaravelBladeSortable\Sortable;
use App\View\Components\Asantibanez\LaravelBladeSortable\SortableItem;
use Blade;
use Illuminate\Support\ServiceProvider;

class LaravelBladeSortableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('sortable', Sortable::class);
        Blade::component('sortable-item', SortableItem::class);
        Blade::component('sortable-scripts', Scripts::class);
    }

    public function register()
    {
        //
    }
}
