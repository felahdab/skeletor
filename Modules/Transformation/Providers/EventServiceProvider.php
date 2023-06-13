<?php

namespace Modules\Transformation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected function discoverEventsWithin(): array
{
    return [
        module_path('Transformation')
    ];
}
}