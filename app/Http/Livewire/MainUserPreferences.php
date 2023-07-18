<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Nwidart\Modules\Facades\Module;

class MainUserPreferences extends Component
{
    public array $settings = [];


    public function mount()
    {
        $this->settings = auth()->user()->settings()->all();
    }

    public function render()
    {

        $user = auth()->user();
        $user->settings()->apply($this->settings);
        // liste de toutes les pages d'accueil possibles par modules
        $listpagesaccueil = [];
        foreach (Module::allEnabled() as $module) {
            $listpagesdumodule = config($module->getLowerName() . ".pageaccueilpossible");

            foreach ($listpagesdumodule as $key => $route) {
                $listpagesaccueil[$module->getName() . " - " . $key] = $route;
            }
        }

        return view('livewire.main-user-preferences', ['listpagesaccueil' => $listpagesaccueil]);
    }
}
