<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Http\Client\ConnectionException;

use App\Service\AnnudefLDAPRequestService;;
use App\Service\RandomPasswordGeneratorService;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

use App\Events\UnUtilisateurDoitEtreRestaureEvent;

class AnnudefSearch extends Component
{
    
    public $tel='';
    public $nom='';
    public $prenom='';
    public $email='';
    public $entite='';
    public $fonction='';
    public $nid='';
    
    public $error='';
    
    public $users;

    public $mode="recherche";
    
    public function render()
    {
        try
        {
            $this->users = AnnudefLDAPRequestService::searchUsers($this->tel ,
                                                        $this->nom,
                                                        $this->prenom,
                                                        $this->email,
                                                        '',
                                                        '',
                                                        '' ,
                                                        $this->entite,
                                                        $this->fonction,
                                                        $this->nid
                                                        );
            // [ "titre" => "M."
            // "nom" => "EL-AHDAB"
            // "prenom" => "Florian,Rémy"
            // "gradelong" => "Capitaine de vaisseau"
            // "gradecourt" => "CV"
            // "nid" => "0012030028"
            // "nomcomplet" => "EL-AHDAB Florian"
            // "nomaffiche" => "EL-AHDAB Florian CV"
            // "uid" => "florian.el-ahdab"
            // "email" => "florian.el-ahdab@intradef.gouv.fr"
            // "unites" => "MARINE/ALFAN/GTR FREMM TOULON/COMMANDEMENT"
            // "status" => "EL-AHDAB"
            // "prenomusuel" => "Florian"
            // "categorystatus" => "Officiers de marine"
            // "categoryrank" => "Officier"
            // "familyname" => "EL-AHDAB" ]
            foreach($this->users as $key=>$ldapuser)
            {
                $localuser = User::withTrashed()->where('email', $ldapuser['email'])->first();
                if ($localuser != null)
                {
                    if ($localuser->deleted_at != null){
                        $this->users[$key]['archive'] = true;
                    }
                    else{
                        if ($localuser->nom != $ldapuser['nom']){
                            $this->users[$key]['nompasidentique'] = true;
                        }
                        if ($localuser->prenom != $ldapuser['prenomusuel']){
                            $this->users[$key]['prenompasidentique'] = true;
                        } 
                    }
                }
                else 
                {
                    $this->users[$key]['nexistepas'] = true;
                }
            }
            $this->users=collect($this->users);
            $this->error='';
        }
        catch (ConnectionException $e)
        {
            $this->users =collect([]);
            $this->error='La requête a pris trop de temps et a été abandonnée.';
        }
        switch ($this->mode){
            case "recherche":
                return view('livewire.annudef-search-recherche')->withError($this->error);
            case "aide":
                return view('livewire.annudef-search-aide')->withError($this->error);
        }
        
    }
    
    public function createLocalUser($index)
    {
        $usertocreate = $this->users[$index];
        
        $newUser = User::create(["email"    => $usertocreate["email"],
                      "nom"     => $usertocreate["nom"],
                      "prenom"   => $usertocreate["prenomusuel"],
                      "password" => RandomPasswordGeneratorService::generateRandomString(),
                      ]);
        $newUser->syncRoles(["user"]);

        Mail::to($newUser->email)
            ->queue(new WelcomeMail($newUser));
    }

    public function conservcpte($index)
    {
        $userconserv = $this->users[$index];
        UnUtilisateurDoitEtreRestaureEvent::dispatch($userconserv["email"], true);
        return redirect()->route('annudef.index')
                ->with(['success' => __('Utilisateur restauré avec succès.') ] );
    }

    public function effacecpte($index)
    {
        $userconserv = $this->users[$index];
        UnUtilisateurDoitEtreRestaureEvent::dispatch($userconserv["email"], false);
        return redirect()->route('annudef.index')
                ->with(['success' => __('Utilisateur restauré avec succès.') ] );
    }
    
    public function aligneNom($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $localuser->nom = $usertocreate['nom'];
        $localuser->save();
    }
    
    public function alignePrenom($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $localuser->prenom = $usertocreate['prenomusuel'];
        $localuser->save();
    }
    
    public function createAllLocalUser()
    {
        foreach($this->users as $key=>$ldapuser)
        {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if ($localuser == null)
            {
                $this->createLocalUser($key);
            }
        }
    }
    
    public function aligneAllNom()
    {
        foreach($this->users as $key=>$ldapuser)
        {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if ($localuser != null)
            {
                if ($localuser->nom != $ldapuser['nom']){
                    $this->aligneNom($key);
                }
            }
        }
    }
    
    public function aligneAllPrenom()
    {
        foreach($this->users as $key=>$ldapuser)
        {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if ($localuser != null)
            {
                if ($localuser->prenom != $ldapuser['prenomusuel']){
                    $this->alignePrenom($key);
                }
                
            }
        }
    }
    
}
