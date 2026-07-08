<?php

namespace App\Filament\PanelRegistry;

class PreferedPageItem
{
    private string $name = '';
    private bool|\Closure $visible = true;
    private \Closure|string $routename = '';

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

    public function routeName(\Closure|string $routename): static
    {
        $this->routename = $routename;

        return $this;
    }

    public function visible(bool|\Closure $visible): static
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
