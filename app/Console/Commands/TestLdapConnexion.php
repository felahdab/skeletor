<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RicorocksDigitalAgency\Soap\Facades\Soap;

use App\Http\Controllers\AnnudefController;

use App\Models\User;

class TestLdapConnexion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:test-ldap-connexion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test LDAP connexion';
    

    
    public function handle()
    {
        
        $results = collect(AnnudefController::searchUsers($tel ='', $nom='' , $prenom='' ,
                                                        $mail='' , $bdd='' , $zone='' ,
                                                        $localite ='' ,
                $entite='MARINE/ALFAN/GTR FREMM TOULON' ,$fonction='' , $nid=''));
                
        // $this->info(count($results));
        $this->info(json_encode($results, JSON_PRETTY_PRINT));
        return 0;
    }
}
