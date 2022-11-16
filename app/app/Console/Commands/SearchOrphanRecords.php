<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Database\Eloquent\Model;

class SearchOrphanRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:searchorphanrecords 
                             {delete=0 : Faut-il supprimer les enregistrements orphelins.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Searches for orphan records.';

    /**
     * Execute the console command.
     *
     * @return int
     */
     
    public function findOrphanRecordsForForeignRelation($sourceModel, 
                                    $destinationModel, 
                                    $foreignKeyField , 
                                    $destinationfield='id',
                                    $removeRecord = false)
    {
        foreach ($sourceModel::all() as $source)
        {
            $attributes = $source->getAttributes();
            $ref = $attributes[$foreignKeyField];
            if ($ref != null)
            {
                $dest = $destinationModel::where($destinationfield, $ref)->first();
                if ($dest == null)
                {
                    $this->error("Identified an orphan record: ");
                    $this->info(json_encode($source, JSON_PRETTY_PRINT) . " is referencing a non existant record thru key " . $foreignKeyField);
                    
                    if ($removeRecord)
                    {
                        $this->warn("Removing orphan record");
                        $source->forceDelete();
                    }
                }
            }
        }
    }
    
    public function pivotClass($tablename)
    {
        $class = new class extends Model {
            public static $tablename='';
            protected $table='';
            
            public function __construct()
            {
                $this->table = self::$tablename;
            }
            
            public static function setTableName($tablename)
            {
                self::$tablename = $tablename;
            }
        };
        
        $class::setTableName($tablename);
        return $class;
    }
    
    
    
    public function handle()
    {
        
        
        $delete = false;
        if ($this->argument('delete') != "0"){
            $delete = true;
            if (! $this->confirm("Du you really want to delete orphan records if any is found?") )
            {
                return Command::SUCCESS;
            };
        }
        
        $checkList = [ 
            [ 'App\Models\Secteur', 'App\Models\Service', 'service_id' ],
            [ 'App\Models\Service', 'App\Models\Groupement', 'groupement_id' ],
            [ 'App\Models\User', 'App\Models\Grade', 'grade_id' ],
            [ 'App\Models\User', 'App\Models\Specialite', 'specialite_id' ],
            [ 'App\Models\User', 'App\Models\Diplome', 'diplome_id' ],
            [ 'App\Models\User', 'App\Models\Secteur', 'secteur_id' ],
            [ 'App\Models\User', 'App\Models\Unite', 'unite_id' ],
            [ 'App\Models\User', 'App\Models\Unite', 'unite_destination_id' ],
            [ 'App\Models\SousObjectif', 'App\Models\Objectif', 'objectif_id' ],
            [ 'App\Models\SousObjectif', 'App\Models\Lieu', 'lieu_id' ],
            [ 'App\Models\Fonction', 'App\Models\TypeFonction', 'typefonction_id' ],
            [ 'App\Models\Stage', 'App\Models\TypeLicence', 'typelicence_id' ],
            [ 'App\Models\Statistique', 'App\Models\Unite', 'unite_id' ],
            [ 'App\Models\BugReport', 'App\Models\User', 'user_id' ],
            [ 'App\Models\TransformationHistory', 'App\Models\User', 'modifying_user_id' ],
            [ 'App\Models\TransformationHistory', 'App\Models\User', 'modified_user_id' ],
        ];
        
        foreach($checkList as $check)
        {
            $this->info("Checking: " . $check[0] . " against " . $check[1] . " thru key: " . $check[2]);
            $sourceModel = $check[0];
            $destinationModel = $check[1];
            $foreignKeyField = $check[2];
            
            $this->findOrphanRecordsForForeignRelation($sourceModel, 
                                        $destinationModel, 
                                        $foreignKeyField, 
                                        removeRecord : $delete);
        }
        
        $checkList = [ 
            [ 'tache_objectif', 'App\Models\Tache', 'tache_id' ],
            [ 'tache_objectif', 'App\Models\Objectif', 'objectif_id' ],
            [ 'compagnonage_tache', 'App\Models\Compagnonage', 'compagnonage_id' ],
            [ 'compagnonage_tache', 'App\Models\Tache', 'tache_id' ],
            [ 'compagnonage_fonction', 'App\Models\Compagnonage', 'compagnonage_id' ],
            [ 'compagnonage_fonction', 'App\Models\Fonction', 'fonction_id' ],
            [ 'fonction_stage', 'App\Models\Fonction', 'fonction_id' ],
            [ 'fonction_stage', 'App\Models\Stage', 'stage_id' ],
            [ 'user_fonction', 'App\Models\User', 'user_id' ],
            [ 'user_fonction', 'App\Models\Fonction', 'fonction_id' ],
            [ 'user_stage', 'App\Models\User', 'user_id' ],
            [ 'user_stage', 'App\Models\Stage', 'stage_id' ],
            [ 'user_sous_objectif', 'App\Models\User', 'user_id' ],
            [ 'user_sous_objectif', 'App\Models\SousObjectif', 'sous_objectif_id' ],
        ];
        
        foreach($checkList as $check)
        {
            $this->info("Checking: " . $check[0] . " against " . $check[1] . " thru key: " . $check[2]);
            $sourceModel =  $this->pivotClass($check[0]);
            $destinationModel = $check[1];
            $foreignKeyField = $check[2];
            
            $this->findOrphanRecordsForForeignRelation($sourceModel, 
                                    $destinationModel, 
                                    $foreignKeyField, 
                                    removeRecord : $delete);
        }
        
        
        return Command::SUCCESS;
    }
}
