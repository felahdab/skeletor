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
            $users=$fonc->users->sortBy('name');
            if ($users->isNotEmpty()){
                foreach($users as $user){
                    $listusers->push($user);
                }
            }
        }
        $listusers=$listusers->unique('id');

        //entete du tableau
        $entete_taches=[];
        $entete_objectifs=[];
        $entete_ssobjectifs=[];

        $liste_id_ssobs = $this->comp->coll_sous_objectifs()->pluck('id');

        foreach($this->comp->cached_taches as $tache){
            //nb de colspan
            $nbcoltach = $tache->nb_ssobj();
            $tabtach=['colspantach' => $nbcoltach, 'libtach' =>  $tache->tache_liblong ];
            array_push($entete_taches, $tabtach);
            foreach($tache->objectifs as $objectif){
                $listssobj=$objectif->sous_objectifs;
                //nb de colspan
                $nbcolobj =count($listssobj);
                $tabobj=['colspanobj' => $nbcolobj, 'libobj' => $objectif->objectif_liblong ];
                array_push($entete_objectifs, $tabobj);
                foreach($listssobj as $sous_objectif){
                    $tabssobj=['ssobj' => $sous_objectif ];
                    array_push($entete_ssobjectifs, $tabssobj);
                }
            }
        }
        
        //body du tableau
        $usersssobjs=[];
        foreach ($listusers as $user){
            $txcompuser=$user->pourcentage_valides_pour_comp($this->comp);
            $ligne=['id' => $user->id, 
                    'name' => $user->display_name, 
                    'txtransfo' => $txcompuser
                ];
            $etat_de_validation = $user->getEtatDeValidationDesSsojbsAttribute($liste_id_ssobs);

            foreach($entete_ssobjectifs as $ssobj){
                $idssobj=$ssobj['ssobj']->id;
                // if ($user->aValideLeSousObjectif($ssobj['ssobj']) ){ // N requetes...
                if (array_key_exists($idssobj, $etat_de_validation) && $etat_de_validation[$idssobj] != null)
                {
                    $ligne[$idssobj] = 'true';
                }
                else{
                    $ligne[$idssobj] = 'false';
                }
            }
            array_push($usersssobjs, $ligne);
        }
        return view('livewire.etat-comp-users',['entete_taches' => $entete_taches,
                                                'entete_objectifs' => $entete_objectifs,
                                                'entete_ssobjectifs' => $entete_ssobjectifs,
                                                'usersssobjs' => $usersssobjs,
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
        // $this->emit('$refresh');
        $this->dispatchBrowserEvent("resetselection");
    }
}
