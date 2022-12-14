<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FfastFonctionText extends Component
{
    
    public $text;
    public $pourcentage;
    public $lache = false;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $pourcentage, $lache = false)
    {
        $this->text = $text;
        $this->pourcentage = $pourcentage;
        $this->lache = $lache;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->lache)
            $color = 'green';
        elseif ($this->pourcentage >= 70 )
            $color = 'Goldenrod';
        elseif ($this->pourcentage >= 35)
            $color = 'orangered';
        else
            $color = 'red';
        
        return view('components.ffast-fonction-text', ['color' => $color]);
    }
}
