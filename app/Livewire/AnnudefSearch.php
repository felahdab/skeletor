<?php

namespace App\Livewire;

use App\Events\UnUtilisateurDoitEtreRestaureEvent;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Service\AnnudefLDAPRequestService;
use App\Service\RandomPasswordGeneratorService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class AnnudefSearch extends Component
{
    public $tel = '';
    public $nom = '';
    public $prenom = '';
    public $email = '';
    public $entite = '';
    public $fonction = '';
    public $nid = '';

    public $error = '';

    public $users;

    public $mode = 'recherche';

    public function render()
    {
        try {
            $this->users = AnnudefLDAPRequestService::searchUsers(
                $this->tel,
                $this->nom,
                $this->prenom,
                $this->email,
                '',
                '',
                '',
                $this->entite,
                $this->fonction,
                $this->nid
            );
            // [ "titre" => "M."
            // "nom" => "NOM"
            // "prenom" => "Prénom1,Prénom2"
            // "gradelong" => "Grade long"
            // "gradecourt" => "GL"
            // "nid" => "123456789"
            // "nomcomplet" => "NOM Prénom1"
            // "nomaffiche" => "NOM Prénom1 (GL)"
            // "uid" => "prenom.nom"
            // "email" => "prenom.nom@domaine.fr"
            // "unites" => "RACINE/BRANCHE/BRANCHE/UNITE"
            // "status" => "NOM"
            // "prenomusuel" => "Prénom1"
            // "categorystatus" => "Corps"
            // "categoryrank" => "Catégorie"
            // "familyname" => "NOM" ]
            foreach ($this->users as $key => $ldapuser) {
                $localuser = User::withTrashed()->where('email', $ldapuser['email'])->first();
                if (null != $localuser) {
                    if (null != $localuser->deleted_at) {
                        $this->users[$key]['archive'] = true;
                    } else {
                        if ($localuser->nom != $ldapuser['nom']) {
                            $this->users[$key]['nompasidentique'] = true;
                        }
                        if ($localuser->prenom != $ldapuser['prenomusuel']) {
                            $this->users[$key]['prenompasidentique'] = true;
                        }
                    }
                } else {
                    $this->users[$key]['nexistepas'] = true;
                }
            }
            $this->users = collect($this->users);
            $this->error = '';
        } catch (ConnectionException $e) {
            $this->users = collect([]);
            $this->error = 'La requête a pris trop de temps et a été abandonnée.';
        }

        switch ($this->mode) {
            case 'recherche':
                return view('livewire.annudef-search-recherche')->withError($this->error);

            case 'aide':
                return view('livewire.annudef-search-aide')->withError($this->error);
        }
    }

    public function createLocalUser($index)
    {
        $usertocreate = $this->users[$index];

        $newUser = User::create(['email' => $usertocreate['email'],
            'nom' => $usertocreate['nom'],
            'prenom' => $usertocreate['prenomusuel'],
            'password' => RandomPasswordGeneratorService::generateRandomString(),
        ]);
        $newUser->syncRoles(['user']);

        Mail::to($newUser->email)
            ->queue(new WelcomeMail($newUser))
        ;
    }

    public function conservcpte($index)
    {
        $userconserv = $this->users[$index];
        UnUtilisateurDoitEtreRestaureEvent::dispatch($userconserv['email'], true);

        return redirect()->route('annudef.index')
            ->with(['success' => __('Utilisateur restauré avec succès.')])
        ;
    }

    public function effacecpte($index)
    {
        $userconserv = $this->users[$index];
        UnUtilisateurDoitEtreRestaureEvent::dispatch($userconserv['email'], false);

        return redirect()->route('annudef.index')
            ->with(['success' => __('Utilisateur restauré avec succès.')])
        ;
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
        foreach ($this->users as $key => $ldapuser) {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if (null == $localuser) {
                $this->createLocalUser($key);
            }
        }
    }

    public function aligneAllNom()
    {
        foreach ($this->users as $key => $ldapuser) {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if (null != $localuser) {
                if ($localuser->nom != $ldapuser['nom']) {
                    $this->aligneNom($key);
                }
            }
        }
    }

    public function aligneAllPrenom()
    {
        foreach ($this->users as $key => $ldapuser) {
            $localuser = User::where('email', $ldapuser['email'])->first();
            if (null != $localuser) {
                if ($localuser->prenom != $ldapuser['prenomusuel']) {
                    $this->alignePrenom($key);
                }
            }
        }
    }
}
