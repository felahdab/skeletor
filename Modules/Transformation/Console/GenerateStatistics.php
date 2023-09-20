<?php

namespace Modules\Transformation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use App\Service\StatService;

use App\Models\Unite;
use Modules\Transformation\Entities\User;
use Modules\Transformation\Entities\Statistique;

use DateTime;

class GenerateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:makestatistics 
                              {unite=2 : Unite pour laquelle calculer les statistiques. Utiliser ffast:listunits pour obtenir la liste.},
                              {period? : Mois de calcul sous le format YYYY/M. Par defaut, le mois en cours.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (! is_numeric($this->argument('unite')))
        {
            $this->error('L unite doit etre precisee sous forme numerique. Voir ffast:listunits pour trouver l identifiant de l unite.');
            return 1;
        }
        
        $period = $this->argument('period');
        if (is_null($period))
        {
            $date_stat = Carbon::now();
            $periode = $date_stat->year . "/" . $date_stat->month;
        }
        else
        {
            $pieces = explode("/", $period);
            $date_stat = Carbon::create($pieces[0], $pieces[1], 1,0,0,0);
            $periode = $date_stat->year . "/" . $date_stat->month;
        }
        $unite = Unite::find($this->argument('unite'));
        $this->info("Calcul des statistiques pour l'unite: " . $unite->unite_libcourt);
        
        $date_max = $date_stat->copy()->lastOfMonth();
        $date_min = $date_stat->copy()->firstOfMonth();
        $this->info("Pour les marins debarques entre le " . $date_min . " et le " . $date_max);


        $existing_stats_for_period = Statistique::all()->where('periode', $periode);
        foreach ($existing_stats_for_period as $stat)
        {
            $dbrecord = Statistique::find($stat->id);
            $dbrecord->delete();
        }
        
        $users = User::withTrashed
            ->where('date_debarq', '>', $date_min)
            ->where('date_debarq', '<=', $date_max)
            ->get();
        foreach ($users as $user)
        {
            StatService::statuser($user);
        }
        return 0;
    }
}
