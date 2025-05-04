<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use RicorocksDigitalAgency\Soap\Facades\Soap;

use App\Service\AnnudefLDAPRequestService;

use App\Models\User;

class FixUsersFromLdap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skeletor:fix-users-from-ldap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adjust user acounts from LDAP';
    

    
    public function handle()
    {
        $users = User::all();
        foreach($users as $localuser)
        {
            $ldapusers = collect(AnnudefLDAPRequestService::searchUsers($tel ='', $nom='' , $prenom='' ,
                                                        $mail=$localuser->email , $bdd='' , $zone='' ,
                                                        $localite ='' , $entite='' ,$fonction='' , $nid=''));
            if (count($ldapusers) == 1){
                $ldapuser = $ldapusers[0];
                if ($localuser->nom != $ldapuser['nom']){
                    $this->warn('Adjusting name from ' . $localuser->nom . " to " . $ldapuser['nom']);
                    $localuser->nom = $ldapuser['nom'];
                }
                if ($localuser->prenom != $ldapuser['prenomusuel']){
                    $this->warn('Adjusting prenom from ' . $localuser->prenom . " to " . $ldapuser['prenomusuel']);
                    $localuser->prenom = $ldapuser['prenomusuel'];
                }
                $localuser->save();

            }
            else {
                $this->error("User with email: " . $localuser->email . " is unknown on Annudef");
            }
        }
        
        return 0;
    }
}
