<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Http\Client\ConnectionException;

use App\Http\Controllers\AnnudefController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use App\Models\Grade;

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
                $localuser = User::where('email', $ldapuser['email'])->first();
                if ($localuser != null)
                {
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
        
        $newUser = User::create(["email"    => $usertocreate["email"],
                      "name"     => $usertocreate["nom"],
                      "prenom"   => $usertocreate["prenomusuel"],
                      "nid"      => $usertocreate["nid"],
                      "password" => UsersController::generateRandomString(),
                      "grade_id" => $grade_id]);
        $newUser->syncRoles(["user"]);
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
