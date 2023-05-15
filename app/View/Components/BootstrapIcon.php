<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BootstrapIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $icon_name='0-circle-fill.svg')
    {
        
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $filepath = base_path("vendor/twbs/bootstrap-icons/icons/" . $this->icon_name);
        return file_get_contents($filepath);
    }
}
