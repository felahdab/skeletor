<?php

namespace App\Filament\PanelRegistry;

use Closure;

class PreferedPageItem
{
    private string $name ='';
    private bool | Closure $visible = true;
    private string | Closure $routename ='';

    public function __construct()
    {
        //
    }

    public static function make()
    {
        return new static(...func_get_args());
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function routeName(string | Closure $routename): static
    {
        $this->routename = $routename;
        return $this;
    }

    public function visible(bool | Closure $visible): static
    {
        $this->visible = $visible;
        return $this;
    }

    public function getRouteName(): ?string
    {
        return value($this->routename);
    }

    public function isVisible(): bool
    {
        return value($this->visible);
    }

    
}
