<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\MultiLineChartModel;

use Modules\Transformation\Entities\Archive;

use App\Service\RandomColorService;

class Dashboardarchive extends Component
{
    public $archiveids=null;
    public $archive = null;

    protected $listeners = ['archiveListUpdated', '$refresh'];

    public function archiveListUpdated($archiveids)
    {
        $this->archiveids = $archiveids;
        $this->emitSelf('$refresh');
    }

    public function render()
    {
        $charts=[];

        if (!is_null($this->archiveids) && sizeof($this->archiveids)){
            $archive=Archive::whereIn('id', $this->archiveids)->get();
            $columnChartModel = (new ColumnChartModel())
                                ->setTitle('Indicateurs moyens');

            $nbemb = 0;
            $nbdeb = 0;  
            $ddebut = $this->archiveids['datedebut'];
            $dfin = $this->archiveids['datefin'];            
            foreach ($archive as $marin){
                $userdata=json_decode($marin->userdata);
                $datemb=$userdata->date_emb;
                $datedeb=$userdata->date_deb;
                if ($ddebut <= $datemb &&  $datemb<= $dfin){
                    $nbemb ++;
                }
                if ($ddebut <= $datedeb &&  $datedeb<= $dfin){
                    $nbdeb ++;
                }
            }

            $charts[]= [
                'id'    => 'moyenne_globale',
                'title' => 'Moyenne globale',
                'txtransfo'    => round($archive->avg("tauxdetransformation"), 2),
                'duree'    => round($archive->avg("duree")),
                'nbmarins'    => count($archive),
                'nbmarins_debarq'    => $nbdeb,
                'nbmarins_embarq'    => $nbemb,
            ];
        }
        return view('transformation::livewire.dashboardarchive', ['charts' => $charts]);    

    }
    

}
