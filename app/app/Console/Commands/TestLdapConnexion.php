<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RicorocksDigitalAgency\Soap\Facades\Soap;

use App\Http\Controllers\AnnudefController;

class TestLdapConnexion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ffast:testldapconnexion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test LDAP connexion';
    

    
    public function handle()
    {
        
        $results = AnnudefController::searchUsers($tel ='', $nom='el-ahdab' , $prenom='' ,$mail='' , $bdd='' , $zone='' ,$localite ='' ,
                $entite='' ,$fonction='' , $nid='');
        
        $this->info(count($results));
        $this->info(json_encode($results));
        return 0;
    }
}
