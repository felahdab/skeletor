<?php

namespace App\Providers\Filament\Traits;

trait UsesSkeletorPrefixAndMultitenancyTrait
{
    public string $prefix="";

    public function register(): void
    {
        $this->prefix = config('skeletor.prefixe_instance');
        
        if (config('skeletor.multi_tenancy'))
        {
            $this->prefix = $this->prefix . '/{tenant}';
        }

        parent::register();
    }
}