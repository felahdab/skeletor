<?php

namespace App\Filament\PanelRegistry;

use Closure;

class DirectMenuItem
{
    private string $name ='';
    private bool | Closure $visible = true;
    private string | Closure $url ='';
    private array | Closure $children = [];

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

    public function url(string | Closure $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function visible(bool | Closure $visible): static
    {
        $this->visible = $visible;
        return $this;
    }

    public function children(array | Closure $children): static
    {
        $this->children = $children;
        return $this;
    }

    public function getChildren(): array
    {
        return value($this->children);
    }

    public function hasChildren(): bool
    {
        return ! empty($this->children);
    }

    public function getUrl(): string
    {
        if (! empty($this->children))
        {
            return '';
        }
        return value($this->url);
    }

    public function isVisible(): bool
    {
        return value($this->visible);
    }

    
}
