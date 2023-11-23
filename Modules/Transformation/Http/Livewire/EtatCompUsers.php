<?php

namespace Modules\Transformation\Http\Livewire;

use Livewire\Component;
use Modules\Transformation\Services\GererTransformationService;

use Modules\Transformation\Entities\User;
// use App\Models\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;

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
        $listusers=$listusers->sortBy('name');
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
            $etat_de_validation = $user->getEtatDeValidationDesSsojbsAttribute($liste_id_ssobs);
            $nbssobjvalid=0;
            foreach($entete_ssobjectifs as $ssobj){
                $idssobj=$ssobj['ssobj']->id;
                if (array_key_exists($idssobj, $etat_de_validation) )
                {
                    if ($etat_de_validation[$idssobj] != null){
                        $ligne[$idssobj] = 'true';
                        $nbssobjvalid ++;    
                    }
                    else{
                        $ligne[$idssobj] = 'propose';
                    }
                }
                else{
                    $ligne[$idssobj] = 'false';
                }
            }
            $txcompuser=$nbssobjvalid.' / '.count($entete_ssobjectifs);
            $ligne['id'] = $user->id;
            $ligne['name'] = $user->display_name;
            $ligne['txtransfo'] = $txcompuser;
            array_push($usersssobjs, $ligne);
        }
        return view('transformation::livewire.etat-comp-users',['entete_taches' => $entete_taches,
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
        $this->dispatch("resetselection");
    }
}
