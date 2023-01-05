<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DocumentationLink extends Component
{
	public $page;    
    public $version;
	/**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($page='', $version=null)
    {
        $this->page = $page;
        if ($version == null)
            $version= env('DOC_VERSION');
        $this->version = $version;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.documentation-link');
    }
}
