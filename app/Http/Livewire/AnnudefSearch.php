<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Client\ConnectionException;

use App\Http\Controllers\AnnudefController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use App\Models\Grade;
use App\Models\Unite;

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
    
    public function render()
    {
        try
        {
            $this->users = AnnudefController::searchUsers($this->tel ,
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
                                                        
            foreach($this->users as $key=>$ldapuser)
            {
                $localuser = User::withTrashed()->where('email', $ldapuser['email'])->first();
                if ($localuser != null)
                {
                    if ($localuser->date_archivage != null){
                        $this->users[$key]['archive'] = true;
                    }
                    else{
                        if ($localuser->name != $ldapuser['nom']){
                            $this->users[$key]['nompasidentique'] = true;
                        }
                        if ($localuser->prenom != $ldapuser['prenomusuel']){
                            $this->users[$key]['prenompasidentique'] = true;
                        }
                        if ($localuser->nid != $ldapuser['nid']){
                            $this->users[$key]['nidpasidentique'] = true;
                        }
                        if ($localuser->grade()->first()?->grade_libcourt != $ldapuser['gradecourt']){
                            $this->users[$key]['gradepasidentique'] = true;
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
        return view('livewire.annudef-search')->withError($this->error);
    }
    
    public function createLocalUser($index)
    {
        $usertocreate = $this->users[$index];
        
        $annudefGrade = $usertocreate["gradecourt"];
        // ddd($annudefGrade);
        $possibleGrade = Grade::where('grade_libcourt', $annudefGrade)->get()->first();
        // ddd($possibleGrade);
        if ($possibleGrade != null)
        {
            $grade_id = $possibleGrade->id;
        }
        else
            $grade_id = null;
        ////////////////////////////////////////////////
        $possibleUnite=null;
        $affectation = $usertocreate["unites"];
        if (str_contains($affectation, "GTR FREMM TOULON"))
            $possibleUnite = Unite::where("unite_libcourt", "GTR/T")->get()->first();
        elseif (str_contains($affectation, "GTR BREST"))
            $possibleUnite = Unite::where("unite_libcourt", "GTR/B")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/ALSACE"))
            $possibleUnite = Unite::where("unite_libcourt", "ALS")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/AUVERGNE"))
            $possibleUnite = Unite::where("unite_libcourt", "AVG")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/LANGUEDOC/LANGUEDOC A"))
            $possibleUnite = Unite::where("unite_libcourt", "LGC_A")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/LANGUEDOC/LANGUEDOC B"))
            $possibleUnite = Unite::where("unite_libcourt", "LGC_B")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/PROVENCE/PROVENCE A"))
            $possibleUnite = Unite::where("unite_libcourt", "PCE_A")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS TOULON/PROVENCE/PROVENCE B"))
            $possibleUnite = Unite::where("unite_libcourt", "PCE_B")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/AQUITAINE/AQUITAINE A"))
            $possibleUnite = Unite::where("unite_libcourt", "AQN_A")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/AQUITAINE/AQUITAINE B"))
            $possibleUnite = Unite::where("unite_libcourt", "AQN_B")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/BRETAGNE/BRETAGNE A"))
            $possibleUnite = Unite::where("unite_libcourt", "BTE_A")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/BRETAGNE/BRETAGNE B"))
            $possibleUnite = Unite::where("unite_libcourt", "BTE_B")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/LORRAINE"))
            $possibleUnite = Unite::where("unite_libcourt", "LRN")->get()->first();
        elseif (str_contains($affectation, "BATIMENTS BREST/NORMANDIE"))
            $possibleUnite = Unite::where("unite_libcourt", "NMD")->get()->first();
        else
            $possibleUnite = Unite::where("unite_libcourt", "HE")->get()->first();
        



        /////////////////////////////////////////////////
        $newUser = User::create(["email"    => $usertocreate["email"],
                      "name"     => $usertocreate["nom"],
                      "prenom"   => $usertocreate["prenomusuel"],
                      "nid"      => $usertocreate["nid"],
                      "password" => UsersController::generateRandomString(),
                      "grade_id" => $grade_id,
                      "unite_id" => $possibleUnite->id]);
        $newUser->syncRoles(["user"]);
    }

    public function conservcpte($index)
    {
        $userconserv = $this->users[$index];
        $user=User::withTrashed()->where ('email', $userconserv["email"])->get()->first();
        $user->date_archivage = null;
        $user->deleted_at = null;
        $user->save();
        // Que fait-on avec les stats ? Comment ?
        return view('livewire.annudef-search');
    }

    public function effacecpte($index)
    {
        $userconserv = $this->users[$index];
        $user=User::withTrashed()->where ('email', $userconserv["email"])->get()->first();
        $user->forceDelete();
        AnnudefSearch::createLocalUser($index);
        return view('livewire.annudef-search');
        // Que fait-on avec les stats ? Comment ?
    }
    
    public function aligneNom($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $localuser->name = $usertocreate['nom'];
        $localuser->save();
    }
    
    public function alignePrenom($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $localuser->prenom = $usertocreate['prenomusuel'];
        $localuser->save();
    }
    
    public function aligneNid($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $localuser->nid = $usertocreate['nid'];
        $localuser->save();
    }
    public function aligneGrade($index)
    {
        $usertocreate = $this->users[$index];
        $localuser = User::where('email', $usertocreate['email'])->first();
        $possibleGrade = Grade::where('grade_libcourt', $usertocreate['gradecourt'])->get()->first();
        // ddd($possibleGrade);
        if ($possibleGrade != null)
        {
            $localuser->grade_id = $possibleGrade->id;
            $localuser->save();
        }
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
                if ($localuser->name != $ldapuser['nom']){
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
    
    public function aligneAllNid()
    {
        foreach($this->users as $key=>$ldapuser)
        {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if ($localuser != null)
            {
                if ($localuser->nid != $ldapuser['nid']){
                    $this->aligneNid($key);
                }
            }
        }
    }
    public function aligneAllGrade()
    {
        foreach($this->users as $key=>$ldapuser)
        {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if ($localuser != null)
            {
                if ($localuser->grade()->first()?->grade_libcourt != $ldapuser['gradecourt']){
                    $this->aligneGrade($key);
                }
            }
        }
    }
}
