<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\MultiLineChartModel;

use Modules\Transformation\Entities\Fonction;
use App\Models\User;

use App\Service\RandomColorService;

use Modules\Transformation\Scopes\MemeUnite;

class ParcoursFichesBilan extends Component
{
    public $userids=null;
    public $user = null;

    protected $listeners = ['userListUpdated', '$refresh'];

    public function userListUpdated($userids)
    {
        $this->userids = $userids;
        $this->emitSelf('$refresh');
    }

    public function render()
    {
        $fiches=[];
        $users=[];

        if (!is_null($this->userids) && sizeof($this->userids))
        {
            // $users=User::with('fonctions')->whereIn('id', $this->userids)->get();
            foreach($this->userids as $id)
            {
                $user=User::scoped(MemeUnite::class)->find($id);
                if ($user != null)
                {
                    $fiches[] = [
                        'id' => $user->id,
                        'user' => $user,
                        'title' => $user->display_name,
                    ];
                }
            }

        }
        return view('transformation::livewire.parcoursfichebilan', ['fiches' => $fiches]);
    }
    

}
