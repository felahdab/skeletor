<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;

use Modules\Transformation\Services\RecalculerTransformationService;
use Illuminate\Support\Facades\Bus;

class GereRecalcul extends Component
{
    public $nb_jours_batch_id=null;
    public $tx_transfo_batch_id = null;
    public $inProgress = false;

    public function render()
    {
        if ($this->inProgress)
        {
            $nb_jours_batch   = Bus::findBatch($this->nb_jours_batch_id);
            $tx_transfo_batch = Bus::findBatch($this->tx_transfo_batch_id);
            
            if ($nb_jours_batch != null && $tx_transfo_batch != null)
            {
                if (! $nb_jours_batch->finished() ||  ! $tx_transfo_batch->finished())
                {
                    return view('transformation::livewire.gere-recalcul', ['nb_jours_batch' => $nb_jours_batch,
                                                   'tx_transfo_batch' => $tx_transfo_batch]);
                }
            }
        }
        $this->inProgress=false;
        return view('transformation::livewire.gere-recalcul');
    }

    public function startRecalcul()
    {
        $this->inProgress=true;
        $ids = RecalculerTransformationService::handle();
        $this->nb_jours_batch_id   = $ids['nb_jours_batch_id'];
        $this->tx_transfo_batch_id = $ids['tx_transfo_batch_id'];
    }

    public function cancelCalcul()
    {
        if ($this->inProgress)
        {
            $nb_jours_batch   = Bus::findBatch($this->nb_jours_batch_id);
            $tx_transfo_batch = Bus::findBatch($this->tx_transfo_batch_id);
            
            if ($nb_jours_batch != null && $tx_transfo_batch != null)
            { 
                if (! $nb_jours_batch->finished() )
                {
                    $nb_jours_batch->cancel();
                }
                if ( ! $tx_transfo_batch->finished())
                {
                    $tx_transfo_batch->cancel();
                }
            }
            $this->inProgress=false;
        }
    }
}
