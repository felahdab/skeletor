<?php

namespace Modules\Transformation\Views\Components;

use Illuminate\View\Component;

class FfastProgressionDiv extends Component
{
    public $pourcentage;
    public $height;
    public $style;
    public $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($pourcentage, $height, $style="div", $text="")
    {
        $this->pourcentage = $pourcentage;
        $this->height = $height;
        $this->style=$style;
        $this->text=$text;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->pourcentage == 100)
            $color = 'green';
        elseif ($this->pourcentage >= 70 )
            $color = 'Goldenrod';
        elseif ($this->pourcentage >= 35)
            $color = 'orangered';
        else
            $color = 'red';
        $pourcentagestr = round($this->pourcentage, 2);
        if ($this->text == "")
            $finaltext = $pourcentagestr . "%";
        else
            $finaltext = $this->text . ": " . $pourcentagestr . "%";
        switch ($this->style){
            case "div":
            $result = view('transformation::components.ffast-progression-div', ['color' => $color,
                                                    'pourcentagestr' => $pourcentagestr,
                                                    'finaltext' => $finaltext]);
            break;
            case "span":
            $result = view('transformation::components.ffast-progression-span', ['color' => $color,
                                                    'pourcentagestr' => $pourcentagestr,
                                                    'finaltext' => $finaltext]);
            break;
            case "td":
            $result = view('transformation::components.ffast-progression-td', ['color' => $color,
                                                    'pourcentagestr' => $pourcentagestr,
                                                    'finaltext' => $finaltext]);
            break;
        }
        return $result;
    }
}
