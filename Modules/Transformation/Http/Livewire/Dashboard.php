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

class Dashboard extends Component
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
        //
        // livewire-column-chart
        // livewire-area-chart
        // livewire-line-chart
        // livewire-multi-column-chart
        // livewire-multi-line-chart
        // livewire-pie-chart
        // livewire-radar-chart
        // livewire-tree-map-chart
        //
        $charts=[];
        $users=[];

        if (!is_null($this->userids) && sizeof($this->userids))
        {
            $users=User::with('fonctions')->whereIn('id', $this->userids)->get();

            $columnChartModel = 
            (new ColumnChartModel())
                ->setTitle('Nombre de fonctions');

            foreach ($users as $user)
            {
                $color = RandomColorService::randomColor(); // '#f6ad55'
                $columnChartModel->addColumn($user->name, $user->fonctions->count(), $color);
            }

            $charts[]= [
                'type'  =>'livewire-column-chart',
                'data'  => $columnChartModel,
                'title' => 'Nombre de fonctions attribuées',
                'id'    => 'nbre_fonctions'
            ];
                        
            $columnChartModel2 = 
            (new ColumnChartModel())
                ->setTitle('Taux de transformation');

            foreach ($users->sortBy('taux_de_transformation') as $user)
            {
                $color = $user->taux_de_transformation >= 70 ? '#00ff00' : '#ff0000';
                $columnChartModel2->addColumn($user->name, $user->taux_de_transformation, $color);
            }
            $charts[] = ['type' =>'livewire-column-chart',
                         'data' => $columnChartModel2,
                         'title' => 'Taux de transformation',
                         'id'    => 'tx_de_transformation' ];

        }

        return view('transformation::livewire.dashboard', ['charts' => $charts]);
    }
    

}
