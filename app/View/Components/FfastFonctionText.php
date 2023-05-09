<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FfastFonctionText extends Component
{
    
    public $text="";
    public $pourcentage=0;
    public $lache = false;
    public $caption="";
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text="", $pourcentage=0, $lache = false)
    {
        $this->text = $text;
        $this->pourcentage = $pourcentage;
        $this->lache = $lache;

        if ($this->text == "")
        {
            $this->caption = $this->pourcentage . "%";
        }
        else
        {
            $this->caption = $this->text . " (" . $this->pourcentage . "%)";
        }
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
        
        return view('components.ffast-fonction-text', ['color' => $color,
                                                     'caption' => $this->caption]);
    }
}
