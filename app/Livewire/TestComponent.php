<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class TestComponent extends Component
{
    use WithFileUploads;
    public $count=0;

    public $photo;
    public function increment()
    {
        $this->count++;
    }
 
    public function decrement()
    {
        $this->count--;
    }

    public function save()
    {
        $this->photo->store('photos');
    }
    public function render()
    {
        return view('livewire.test-component');
    }
}
