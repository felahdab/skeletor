<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Lab404\Impersonate\Models\Impersonate;

use App\Jobs\CalculateUserTransformationRatios;
use App\Service\GererTransformationService;
use App\Service\TransformationManagerService;
use App\Service\AnnudefAjaxRequestService;

use Illuminate\Database\Eloquent\Model;
use App\Models\TransformationHistory;
use App\Models\Stage;
use App\Models\Fonction;
use App\Models\UserSousObjectif;

use Glorand\Model\Settings\Traits\HasSettingsTable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    use Impersonate;

    use HasSettingsTable; # provides the ->settings() methods

    public array $defaultSettings = [
        'ffast' => [
            'notifications' => [
                'pour_fonctions' => [
                    'daily'           => false,
                    'weekly'          => false,
                    'liste_fonctions' => []
                ],
                'pour_services' => [
                    'daily'           => false,
                    'weekly'          => false,
                    'liste_services' => []
                ],
            ]
        ]
    ]; # for Glorand\Model\Settings\Traits\HasSettingsTable

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /** 
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'matricule',
        'date_embarq',
        'date_debarq',
        'grade_id',
        'specialite_id',
        'diplome_id',
        'secteur_id',
        'unite_id',
        'unite_destination_id',
        'user_comment',
        'display_name',
        'nid',
        'comete',
        'socle',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    // protected $appends = ['en_transformation'];

    private $fonctionscount = null;

    private $colls_sous_objs = [];
    private $colls_sous_objs_non_orphelins = null;


    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function displayString()
    {
        $gradecoll = $this->grade()->get();
        if ($gradecoll->count() == 1)
            $grade = $gradecoll->first()->grade_libcourt;
        else
            $grade = "";
        return $grade . " " . $this->name . " " . $this->prenom;
    }

    public function displayServiceSecteur()
    {
        $secteur = $this->secteur;
        if ($secteur == null)
            return "NON RENSEIGNE";
        $service = $secteur->service;

        return $service->service_libcourt . "/" . $secteur->secteur_libcourt;
    }

    public function displayGrade()
    {
        return $this->grade ? $this->grade->grade_libcourt : "";
    }

    public function displayDiplome()
    {
        return $this->diplome ? $this->diplome->diplome_libcourt : "";
    }

    public function displaySpecialite()
    {
        return $this->specialite ? $this->specialite->specialite_libcourt : "";
    }

    public function displaySecteur()
    {
        return $this->secteur ? $this->secteur->secteur_libcourt : "";
    }

    public function displayService()
    {
        if ($this->secteur) {
            return $this->secteur->service?->service_libcourt;
        }
        return "NON RENSEIGNE";
    }

    public function displayDestination()
    {
        return $this->unite_destination ? $this->unite_destination->unitelib_court : "";
    }
    public function displayDateDebarquement()
    {
        return $this->date_debarq ? $this->date_debarq : "N.C.";
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function diplome()
    {
        return $this->belongsTo(Diplome::class);
    }

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function service()
    {
        return $this->secteur()->first()->service()->take(1);
    }

    public function groupement()
    {
        return $this->secteur()->first()->service()->first()->groupement()->first();
    }

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function unite_destination()
    {
        return $this->belongsTo(Unite::class, 'unite_destination_id');
    }

    public function getAnnudefPictureUrl()
    {
        $url = AnnudefAjaxRequestService::searchPictureForEmail($this->email);
        return $url;
    }

    // Cette partie concerne le suivi de la transformation.
    public $transformation_service = null;
    public function getTransformationManager()
    {
        if ($this->transformation_service == null)
            $this->transformation_service = new TransformationManagerService($this);
        return $this->transformation_service;
    }

    public function fonctions()
    {
        return $this->belongsToMany(Fonction::class, 'user_fonction')
            ->withTimeStamps()
            ->withPivot(
                'date_lache',
                'valideur_lache',
                'commentaire_lache',
                'date_double',
                'valideur_double',
                'commentaire_double',
                'validation',
                'taux_de_transformation',
                'nb_jours_pour_validation',
                'date_proposition_double',
                'date_proposition_lache'
            );
    }

    public function stages()
    {
        return $this->belongsToMany(Stage::class, 'user_stage')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'date_validite');
    }

    // Doit renvoyer la liste des sous objectifs que l'utilisateur a valide
    // associes à une fonction actuelle de l'utilisateur.
    public function sous_objectifs_non_orphelins()
    {
        if ($this->colls_sous_objs_non_orphelins != null)
            return $this->colls_sous_objs_non_orphelins;

        $ssobj_du_parcours_de_transformation = $this->coll_sous_objectifs();

        $liste_sous_obj_valides = $this->belongsToMany(SousObjectif::class, 'user_sous_objectif')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur', 'date_proposition_validation')
            ->get()
            ->whereNotNull('pivot.date_validation');

        $resultat = $liste_sous_obj_valides->intersect($ssobj_du_parcours_de_transformation);

        $this->colls_sous_objs_non_orphelins = $resultat;
        return $resultat;
    }

    public function sous_objectifs()
    {
        return $this->belongsToMany(SousObjectif::class, 'user_sous_objectif')
            ->withTimeStamps()
            ->withPivot('commentaire', 'date_validation', 'valideur', 'nb_jours_pour_validation', 'date_proposition_validation');
    }

    // Cette partie contient des fonctions d'aide pour le suivi de la transformation
    public function logTransformationHistory($event, $event_details = "")
    {
        $currentuser = auth()->user();

        TransformationHistory::create([
            "modifying_user" => $currentuser->display_name,
            "modified_user" => $this->display_name,
            "event" => $event,
            "event_details" => $event_details
        ]);
    }

    public function aValideLaTache(Tache $tache)
    {
        foreach ($tache->objectifs()->get() as $objectif) {
            if ($this->aValideLObjectif($objectif) == false)
                return false;
        }
        return true;
    }

    public function aValideLObjectif(Objectif $objectif)
    {
        foreach ($objectif->sous_objectifs()->get() as $sous_objectif) {
            if ($this->aValideLeSousObjectif($sous_objectif) == false)
                return false;
        }
        return true;
    }

    public function getEtatDeValidationDesSsojbsAttribute($liste_id_ssobs)
    {
        return $this->sous_objectifs()
            ->whereIn('sous_objectif_id', $liste_id_ssobs)
            ->get()
            ->pluck('pivot.date_validation', 'id')
            ->all();
    }

    public function aValideLeSousObjectif(SousObjectif $sous_objectif)
    {
        $workitem = $this->sous_objectifs()->find($sous_objectif);

        if ($workitem == null)
            return false;
        if ($workitem->pivot->date_validation == null)
            return false;
        return true;
    }

    public function aProposeLeSousObjectif(SousObjectif $sous_objectif)
    {
        $workitem = $this->sous_objectifs()->find($sous_objectif);

        if ($workitem == null)
            return false;
        if ($workitem->pivot->date_validation != null)
            return false;
        if ($workitem->pivot->date_proposition_validation != null)
            return true;
        return false;
    }

    public function aProposeDoubleFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_proposition_double != null)
            return true;
        return false;
    }

    public function aValideDoubleFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_double != null)
            return true;
        return false;
    }

    public function aProposeLacheFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_proposition_lache != null)
            return true;
        return false;
    }

    public function aValideLacheFonction(Fonction $fonction)
    {
        $userfonction = $this->fonctions->find($fonction);
        if ($userfonction == null)
            return false;

        if ($userfonction->pivot->date_lache != null)
            return true;
        return false;
    }

    public function aValideLeStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return false;
        $workitem = $workitem->pivot;
        if ($workitem->date_validation == null)
            return false;
        return true;
    }

    public function dateValidationDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return "";
        $workitem = $workitem->pivot;
        if ($workitem->date_validation == null)
            return "";
        return $workitem->date_validation;
    }

    public function dateValiditeDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        if ($workitem == null)
            return "";
        $workitem = $workitem->pivot;
        if ($workitem->date_validite == null)
            return "";
        return $workitem->date_validite;
    }

    public function CommentaireDuStage(Stage $stage)
    {
        $workitem = $this->stages()->find($stage);
        return $workitem?->pivot->commentaire;
    }

    /** Renvoie la liste de stages lies a une fonction.
     * Attention: ne verifie pas les doublons !
     */
    public function stagesLiesAUneFonction()
    {
        $collect = collect([]);
        foreach ($this->fonctions()->get() as $fonction)
            foreach ($fonction->stages()->get() as $stage)
                $collect = $collect->concat([$stage]);
        return $collect;
    }

    public function stagesOrphelins()
    {
        // Pour les stages qui ont été attribués à l'utilisateur en dehors du parcours de transformation.
        $orphans = $this->stages()->get()->diff($this->stagesLiesAUneFonction());

        return $orphans;
    }

    public function nbSousObjectifsAValider(Fonction $fonction = null)
    {
        if ($fonction != null) {
            return $fonction->coll_sous_objectifs()->unique()->count();
        } else {
            return $this->coll_sous_objectifs()->unique()->count();
        }
    }

    public function fonctionAQuai()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 2)->get();
        return $fonction;
    }

    public function fonctionAMer()
    {
        $fonction = $this->fonctions()->where('typefonction_id', 1);
        return $fonction;
    }

    public function fonctionsMetier()
    {
        $fonctions = $this->fonctions()->where('typefonction_id', 3);
        return $fonctions;
    }

    public function coll_sous_objectifs(Fonction $fonction = null)
    {
        $key = $fonction == null ? "null" : $fonction->id;
        if (array_key_exists($key, $this->colls_sous_objs)) {
            return $this->colls_sous_objs[$key];
        }

        if ($fonction != null) {
            $this->colls_sous_objs[$fonction->id] = $fonction->coll_sous_objectifs();
            return $this->colls_sous_objs[$fonction->id];
        }

        $coll = collect([]);
        foreach ($this->fonctions()->with('compagnonages.taches.objectifs.sous_objectifs')->get() as $fonction) {
            foreach ($fonction->compagnonages as $compagnonage) {
                foreach ($compagnonage->taches as $tache) {
                    foreach ($tache->objectifs as $objectif) {
                        $coll = $coll->concat($objectif->sous_objectifs);
                    }
                }
            }
        }
        $this->colls_sous_objs["null"] = $coll;
        return $this->colls_sous_objs["null"];
    }

    public function historique_validation_sous_objectifs(Fonction $fonction = null)
    {
        if ($fonction == null) {
            $sous_objectifs_valides = $this->sous_objectifs_non_orphelins()->sortBy('pivot_date_validation');
        } else {
            $sous_objectifs_valides = $this->sous_objectifs_non_orphelins()->sortBy('pivot_date_validation');
            $sous_objectifs_a_garder = $fonction->coll_sous_objectifs();

            $sous_objectifs_valides = $sous_objectifs_valides->intersect($sous_objectifs_a_garder);
        }
        $liste_des_dates_de_validation = $sous_objectifs_valides->pluck('pivot.date_validation');
        $nb_validation_par_date = array_count_values($liste_des_dates_de_validation->all());

        return $nb_validation_par_date;
    }

    public function historique_validation_sous_objectifs_cumulatif(Fonction $fonction = null)
    {
        $nb_validation_par_date = $this->historique_validation_sous_objectifs($fonction);
        $total = 0;
        foreach ($nb_validation_par_date as $key => $value) {
            $total = $total + $value;
            $nb_validation_par_date[$key] = $total;
        }
        return $nb_validation_par_date;
    }

    public function pourcentage_valides_pour_fonction(Fonction $fonction, bool $fullcalc = false)
    {
        if (!$fullcalc) {
            $workitem = $this->fonctions()->find($fonction);
            return $workitem->pivot->taux_de_transformation;
        } else {
            $fcoll = $fonction->coll_sous_objectifs();
            $workcoll = $this->sous_objectifs_non_orphelins()->intersect($fcoll);
            if ($fcoll->sum('ssobj_coeff') == 0) return 0;
            return round(100.0 * $workcoll->sum('ssobj_coeff') / $fcoll->sum('ssobj_coeff'), 2);
        }
    }

    public function taux_de_transformation(bool $fullcalc = false)
    {
        if (!$fullcalc)
            return user->taux_de_transformation;

        $nb_stage_total = 0;
        $nb_stage_total = $this->stages()->get()->count();

        $nb_stage_valides = 0;
        $nb_stage_valides = $this->stages()->wherePivotNotNull('date_validation')->get()->count();

        $coll_sous_objs_valides = $this->sous_objectifs_non_orphelins();
        $coeff_valides = $coll_sous_objs_valides->sum('ssobj_coeff');
        $coll_sous_objs = $this->coll_sous_objectifs();
        $total_des_coeff = $coll_sous_objs->sum('ssobj_coeff');

        $taux_transfo = 0;
        if ($nb_stage_total > 0 or $total_des_coeff > 0) {
            $taux_transfo = 100 * ($nb_stage_valides + $coeff_valides) / ($nb_stage_total + $total_des_coeff);
        }
        return $taux_transfo;
    }

    public function pourcentage_valides_pour_comp(Compagnonage $comp)
    {
        $compcoll = $comp->coll_sous_objectifs();
        $workcoll = $this->sous_objectifs_non_orphelins()->intersect($compcoll);

        return round(100.0 * $workcoll->sum('ssobj_coeff') / $compcoll->sum('ssobj_coeff'), 2);
    }

    public function getEnTransformationAttribute()
    {
        // return $this->getTransformationManager()->parcours->count();
        if ($this->fonctionscount == null) {
            $fonctions = $this->fonctions;
            $this->fonctionscount = $fonctions->count();
        }

        return $this->fonctionscount > 0;
    }
    public function NbJoursPresence()
    {
        // renvoie le nb de jours de presence diff date embarquement et aujourd'hui
        $deb = date_create($this->date_embarq);
        $fin = date_create(date('Y-m-d'));
        $nbjours = $deb->diff($fin)->format('%a');

        return $nbjours;
    }
}
