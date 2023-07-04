<?php

namespace Modules\Transformation\Console;

use Illuminate\Console\Command;

use Illuminate\Database\Eloquent\Model;

class SearchOrphanRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transformation:searchorphanrecords 
                             {delete=0 : Faut-il supprimer les enregistrements orphelins.},
                             {replacezeros=0 : Remplacer les references 0 par null.}';

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
                                    $removeRecord = false,
                                    $replaceZeros = false)
    {
        $sourcetraits = class_uses($sourceModel);
        $source_use_soft_delete = in_array("Illuminate\Database\Eloquent\SoftDeletes", $sourcetraits);
        if ($source_use_soft_delete)
            $sourcerecords = $sourceModel::withTrashed()->get();
        else
            $sourcerecords = $sourceModel::all();
        
        foreach ($sourcerecords as $source)
        {
            $attributes = $source->getAttributes();
            $ref = $attributes[$foreignKeyField];
            
            
            if (! is_null($ref ) )
            {
                $traits = class_uses($destinationModel);
                $use_soft_delete = in_array("Illuminate\Database\Eloquent\SoftDeletes", $traits);
                if ($use_soft_delete)
                    $dest = $destinationModel::withTrashed()->where($destinationfield, intval($ref))->first();
                else
                    $dest = $destinationModel::where($destinationfield, intval($ref))->first();
                
                if ($dest == null)
                {
                    if ($ref == 0)
                    {
                        $this->error("Identified an orphan record with a 0 reference: ");
                        $this->info(json_encode($source, JSON_PRETTY_PRINT) . " is referencing a non existant record thru key " . $foreignKeyField);
                        
                        if ($replaceZeros)
                        {
                            $this->warn("Removing orphan record");
                            $source->{$foreignKeyField}=null;
                            $source->save();
                        }
                    }
                    else {
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
        $replacezeros = false;
        if ($this->argument('replacezeros') != "0"){
            $replacezeros = true;
            if (! $this->confirm("Du you really want to replace 0 references by null if any is found?") )
            {
                return Command::SUCCESS;
            };
        }
        
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
            [ 'Modules\Transformation\Entities\SousObjectif', 'Modules\Transformation\Entities\Objectif', 'objectif_id' ],
            [ 'Modules\Transformation\Entities\SousObjectif', 'App\Models\Lieu', 'lieu_id' ],
            [ 'Modules\Transformation\Entities\Fonction', 'Modules\Transformation\Entities\TypeFonction', 'typefonction_id' ],
            [ 'Modules\Transformation\Entities\Stage', 'Modules\Transformation\Entities\TypeLicence', 'typelicence_id' ],
            [ 'Modules\Transformation\Entities\Statistique', 'App\Models\Unite', 'unite_id' ],
            [ 'App\Models\BugReport', 'App\Models\User', 'user_id' ],
            [ 'Modules\Transformation\Entities\TransformationHistory', 'App\Models\User', 'modifying_user_id' ],
            [ 'Modules\Transformation\Entities\TransformationHistory', 'App\Models\User', 'modified_user_id' ],
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
                                        removeRecord : $delete,
                                        replaceZeros : $replacezeros);
        }
        
        $checkList = [ 
            [ 'transformation_tache_objectif', 'Modules\Transformation\Entities\Tache', 'tache_id' ],
            [ 'transformation_tache_objectif', 'Modules\Transformation\Entities\Objectif', 'objectif_id' ],
            [ 'transformation_compagnonage_tache', 'Modules\Transformation\Entities\Compagnonage', 'compagnonage_id' ],
            [ 'transformation_compagnonage_tache', 'Modules\Transformation\Entities\Tache', 'tache_id' ],
            [ 'transformation_compagnonage_fonction', 'Modules\Transformation\Entities\Compagnonage', 'compagnonage_id' ],
            [ 'transformation_compagnonage_fonction', 'Modules\Transformation\Entities\Fonction', 'fonction_id' ],
            [ 'transformation_fonction_stage', 'Modules\Transformation\Entities\Fonction', 'fonction_id' ],
            [ 'transformation_fonction_stage', 'Modules\Transformation\Entities\Stage', 'stage_id' ],
            [ 'transformation_user_fonction', 'App\Models\User', 'user_id' ],
            [ 'transformation_user_fonction', 'Modules\Transformation\Entities\Fonction', 'fonction_id' ],
            [ 'transformation_user_stage', 'App\Models\User', 'user_id' ],
            [ 'transformation_user_stage', 'Modules\Transformation\Entities\Stage', 'stage_id' ],
            [ 'transformation_user_sous_objectifs', 'App\Models\User', 'user_id' ],
            [ 'transformation_user_sous_objectifs', 'Modules\Transformation\Entities\SousObjectif', 'sous_objectif_id' ],
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
                                    removeRecord : $delete,
                                    replaceZeros : $replacezeros);
        }
        
        
        return Command::SUCCESS;
    }
}
