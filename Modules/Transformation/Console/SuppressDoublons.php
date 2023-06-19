<?php

namespace Modules\Transformation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;
use Modules\Transformation\Entities\UserSousObjectif;

use App\Jobs\CalculateUserTransformationRatios;

class SuppressDoublons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:suppressdoublons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprimer les doubles dans la table user_sous_objectif. Recalcule le taux de transformation.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $found=false;
        foreach (User::withTrashed()->get() as $user) {
            $userid=$user->id;
            $this->info($userid);
            if ($user->sous_objectifs->count() != 0){
                $liste_totale = $user->sous_objectifs->pluck('id');
                $liste_unique = $user->sous_objectifs->pluck('id')->unique();
                if ($liste_unique->count() != $liste_totale->count()){
                    $this->warn("Non unique");
                    $found=true;
                    foreach($liste_unique as $ssobjid){
                        $keep=UserSousObjectif::where('user_id', $userid)->where('sous_objectif_id', $ssobjid)->first();
                        $nb = UserSousObjectif::where('user_id', $userid)->where('sous_objectif_id', $ssobjid)->where('id', '!=', $keep->id)->delete();
                        $this->output->write(".", false);
                    }
                    $this->output->write("\n", false);
                }
            }
        }
        if($found)
            $this->warn("Des doubles ont ete trouves et supprimes. Vous devriez recalculer les indicateurs avec la commande ffast:recalculertransformation.");
        return Command::SUCCESS;
    }
}
