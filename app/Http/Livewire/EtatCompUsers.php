<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Service\GererTransformationService;

use App\Models\User;
// use App\Models\Fonction;
use App\Models\Compagnonage;
use App\Models\Tache;
use App\Models\Objectif;
use App\Models\SousObjectif;
use App\Models\UserSousObjectif;

class EtatCompUsers extends Component
{

    public $comp=null;
    
    public function mount(Compagnonage $comp)
    {
        $this->comp=$comp;
    }

    public function render()
    {
        //liste des fonctions pour ce comp
        $listfoncs= $this->comp->fonctions()->get();

        // liste des users ayant ces fonc donc ce comp
        $listusers=collect();
        foreach($listfoncs as $fonc){
            $users=$fonc->users;
            if ($users->isNotEmpty()){
                foreach($users as $user){
                    $listusers->push($user);
                }
            }
        }
        $listusers=$listusers->unique('id');

        ///////////////////////
        //1ere présentation
        ///////////////////////

        //entete du tableau
        $entete_taches=[];
        $entete_objectifs=[];
        $entete_ssobjectifs=[];
        foreach($this->comp->taches as $tache){
            //nb de colspan
            $nbcoltach = $tache->coll_sous_objectifs()->count();
            $tabtach=['colspantach' => $nbcoltach, 'libtach' =>  $tache->tache_liblong ];
            array_push($entete_taches, $tabtach);
            foreach($tache->objectifs as $objectif){
                //nb de colspan
                $nbcolobj =$objectif->coll_sous_objectifs()->count();
                $tabobj=['colspanobj' => $nbcolobj, 'libobj' => $objectif->objectif_liblong ];
                array_push($entete_objectifs, $tabobj);
                foreach($objectif->sous_objectifs as $sous_objectif){
                    $tabssobj=['ssobj' => $sous_objectif ];
                    array_push($entete_ssobjectifs, $tabssobj);
                }
            }
        }
        
        //body du tableau
        $usersssobjs=[];
        foreach ($listusers as $user){
            $txcompuser=$user->pourcentage_valides_pour_comp($this->comp);
            $ligne=['id' => $user->id, 'name' => $user->display_name, 'txtransfo' => $txcompuser];
            foreach($entete_ssobjectifs as $ssobj){
                $idssobj=$ssobj['ssobj']->id;
                if ($user->aValideLeSousObjectif($ssobj['ssobj']) ){
                    $ligne[$idssobj] = 'true';
                }
                else{
                    $ligne[$idssobj] = 'false';
                }
            }
            array_push($usersssobjs, $ligne);
        }
        
        ///////////////////////
        //2eme présentation
        ///////////////////////
        //entete du tableau
        $entete_users=[];
        foreach ($listusers as $user){
            $txcompuser=$user->pourcentage_valides_pour_comp($this->comp);
            $col=['id' => $user->id, 'name' => $user->display_name, 'txtransfo' => $txcompuser];
            array_push($entete_users, $col);
        }

        //body du tableau
        $ssobjsusers=[];
        foreach($this->comp->taches as $tache){
            $libtach=$tache->tache_liblong;
            foreach($tache->objectifs as $objectif){
                $libobj=$objectif->objectif_liblong;
                foreach($objectif->sous_objectifs as $sous_objectif){
                    $ligne=['tache' => $libtach, 
                            'obj' => $libobj, 
                            'ssobj' => $sous_objectif];

                    $libtach='';
                    $libobj='';
                    $idssobj = $sous_objectif->id;                    
                    foreach ($listusers as $user){
                        if ($user->aValideLeSousObjectif($sous_objectif) ){
                            $ligne[$user->id] = 'true';
                        }
                        else{
                            $ligne[$user->id] = 'false';
                        }     
                    }
                    array_push($ssobjsusers, $ligne);
                }
            }
        }
        return view('livewire.etat-comp-users',['entete_taches' => $entete_taches,
                                                'entete_objectifs' => $entete_objectifs,
                                                'entete_ssobjectifs' => $entete_ssobjectifs,
                                                'usersssobjs' => $usersssobjs,
                                                'entete_users' => $entete_users,
                                                'ssobjsusers' => $ssobjsusers,
                                            ]);
    }
    public function ValideElementsDuParcoursParcomp( 
        $date_validation , $commentaire, $valideur,
        $selected_parcomp = null)
    {
        foreach ($selected_parcomp as $ssobjuseravalider){
            $tabavalider=explode('-',$ssobjuseravalider);
            $ssobjid=$tabavalider[1];
            $userid=$tabavalider[3];
            $sous_objectif = SousObjectif::find($ssobjid);
            $user = User::find($userid);
            $transformationService = new GererTransformationService;
            $transformationService->ValidateSousObjectif($user, $sous_objectif, $date_validation , $commentaire, $valideur);
        }
        $this->emit('$refresh');
        $this->dispatchBrowserEvent("resetselection");
    }
}
