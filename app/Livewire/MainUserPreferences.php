<?php

namespace App\Livewire;

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
        $composants_des_modules = [];
        foreach (Module::allEnabled() as $module) {
            $listpagesaccueil=[];
            if($listpagesdumodule = config($module->getLowerName() . ".pageaccueilpossible")){
                foreach ($listpagesdumodule as $key => $route) {
                    $listpagesaccueil[$module->getName() . " - " . $key] = $route;
                }    
            }
            $candidat_composant = $module->getLowerName() . "::user-preferences-component";

            if (array_key_exists($candidat_composant, app('livewire')->getComponentAliases())) {
                $composants_des_modules[]  = $candidat_composant;
            }
        }

        return view('livewire.main-user-preferences', [
            'listpagesaccueil' => $listpagesaccueil,
            'composants_des_modules' => $composants_des_modules
        ]);
    }
}
