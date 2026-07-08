<?php

namespace App\Console\Commands;

use App\Service\AnnudefLDAPRequestService;
use Illuminate\Console\Command;

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
        $results =collect(AnnudefLDAPRequestService::searchUsers(
            tel : '',
            nom : '',
            prenom : '',
            mail : '',
            bdd : '',
            zone : '',
            localite : '',
            entite :  'MARINE/ALFAN/FPS TOULON',
            fonction : '',
            nid : ''
        ));

        $this->info(json_encode($results, JSON_PRETTY_PRINT));

        return 0;
    }
}
