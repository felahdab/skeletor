<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Modules\Transformation\Entities\Fonction;
use App\Models\Service;

class UserPreferencesComponent extends Component
{
    public array $settings = [];

    public $fonctions_collapse = true;
    public $services_collapse = true;

    public function mount()
    {
        $this->settings = auth()->user()->settings()->all();
    }

    public function render()
    {
        auth()->user()->settings()->apply($this->settings);
        $fonctions = Fonction::all();
        $services = Service::all();

        $prefered_routes = [
            "Ma page d'accueil" => 'transformation::transformation.homeindex',
            'Bilan pour mon service' => "transformation::statistiques.statpourunservice",
            'Bilan global' => 'transformation::statistiques.statglobal',
            'Bilan par stage' => 'transformation::statistiques.statstage',
            'Suivi par marins' => 'transformation::transformation.index',
            'Suivi par stages' => 'transformation::transformation.indexparstage'];

        return view('livewire.user-preferences-component')
            ->with(compact('fonctions', 'services', 'prefered_routes'));
    }
}
