<?php

namespace Modules\Transformation\Http\Livewire;

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

        return view('transformation::livewire.user-preferences-component')
            ->with(compact('fonctions', 'services'));
    }
}
