<?php

namespace Modules\Transformation\Http\Livewire;

use App\Models\FiltreTransformationCompagnonnage;
use Livewire\Component;
use Modules\Transformation\Services\GererTransformationService;

use Modules\Transformation\Entities\User;
// use App\Models\Fonction;
use Modules\Transformation\Entities\Compagnonage;
use Modules\Transformation\Entities\Tache;
use Modules\Transformation\Entities\Objectif;
use Modules\Transformation\Entities\SousObjectif;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;

use function Termwind\render;

class EtatCompUsers extends Component
{

    public $comp=null;
    public $listusers =null;
    public $user_id=null;
    public function mount(Compagnonage $comp, $listusers, $user)
    {
        $this->comp=$comp;
        $this->listusers=$listusers;
        $this->user_id=$user;
    }

    public function render()
    {
        //liste des fonctions pour ce comp
        $listfoncs= $this->comp->fonctions()->get();

        // liste des users ayant ces fonc donc ce comp
        if($this->listusers === null){
            $this->listusers=collect();
            foreach($listfoncs as $fonc){
                $users=$fonc->users;
                if ($users->isNotEmpty()){
                    foreach($users as $user){
                        $this->listusers->push($user);
                    }
                }
            }
        }
        $listusers=$this->listusers->sortBy('name');
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
        $filtres = FiltreTransformationCompagnonnage::where('user_id', $this->user_id)->get();
        return view('transformation::livewire.etat-comp-users',['entete_taches' => $entete_taches,
                                                'entete_objectifs' => $entete_objectifs,
                                                'entete_ssobjectifs' => $entete_ssobjectifs,
                                                'usersssobjs' => $usersssobjs,
                                                'filtres' => $filtres,
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

    public function showMarinFiltrer($marinSelectionnes){
        $listUsers = [];
        $listUsers = User::whereIn('id', $marinSelectionnes)->get();
        $this->listusers = $listUsers;
        $this->render();
    }

    public function reinitialiser(){
        $this->listusers = null;
        $this->render();
    }

    public function creerUnFiltre($marinSelectionnes){
        if(count($marinSelectionnes) != 0){
            $listUsers = [];
            $listUsers = User::whereIn('id', $marinSelectionnes)->get();
            $this->listusers = $listUsers;
            $filtre = new FiltreTransformationCompagnonnage();
            $filtre->user_id = $this->user_id;
            $filtre->nomDuFiltre = "test";
            $filtre->listeId = json_encode($marinSelectionnes);
            $filtre->save();
            $this->render();
        }
        $this->listusers = null;
        $this->render();
    }

    public function appliquerFiltre($idFiltre){
        //Ajouter une fenetre quand on appuie sur enregistrer pour vérifier les personnes selectionnées et mettre un nom au filtre
        $filtre = FiltreTransformationCompagnonnage::where('id', $idFiltre)->first();
        if($filtre){
            $listeId = json_decode($filtre->listeId, true);
            $listUsers = User::whereIn('id', $listeId)->get();
            $this->listusers = $listUsers;
            $this->render();
        }
    }
}
