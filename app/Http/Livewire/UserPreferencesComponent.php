<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Fonction;
use App\Models\Service;

class UserPreferencesComponent extends Component
{
    public array $settings=[];

    public $fonctions_collapse=true;
    public $services_collapse=true;

    public function mount()
    {
        $this->settings = auth()->user()->settings()->all();
    }

    public function render()
    {
        auth()->user()->settings()->apply($this->settings);
        $fonctions = Fonction::all();
        $services= Service::all();

        return view('livewire.user-preferences-component')
            ->layout('layouts.app-master')
            ->with(compact('fonctions', 'services'));
    }
}
