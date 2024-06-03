<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

use Spatie\Permission\Traits\HasRoles;

use App\Service\AnnudefAjaxRequestService;

use Glorand\Model\Settings\Traits\HasSettingsTable;
use Lab404\Impersonate\Models\Impersonate;
use Nwidart\Modules\Facades\Module;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    use Impersonate;

    use HasSettingsTable; # provides the ->settings() methods

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'email_verified_at' => 'datetime'
        ];
    }
    
    public function canAccessPanel(Panel $panel): bool
    {
        // Par défaut, le panel admin n'est accessible qu'au super admins.
        // Les autres panels sont accessibles à tout le monde (la sécurité se fera au niveau des ressources et autres elements filament)
        if ($panel->getID() === 'admin')
            return $this->IsSuperAdmin();
        return true;
    }
    /* La surcharge ci-dessous semble inutile, mais elle est là pour outrepasser la surcharge de __call définie
        dans le trait HasSettingsTable qui utilise call_user_func(get_parent_class($this) . '::__call', $name, $args);
        là ou parent::__call($name, $args) aurait suffit. La méthode utilisée déclenche un appel récursif sans find
        dans le cas où on extends le modèle sans rien surcharger...
    */
    public function __call($name, $args)
    {
        return parent::__call($name, $args);
    }

    # La propriete statique modelDefaultSettings est enrichie par les preferences des utilisateurs declarees dans les modules
    # actives, puis utilisee a l'initialisation d'un User pour configurer la propriete defaultSettings.
    protected static $modelDefaultSettings=[
        "prefered_page" => null
    ];

    public array $defaultSettings = [
        
    ]; # for Glorand\Model\Settings\Traits\HasSettingsTable

    protected static function booted(): void
    {
        foreach(Module::allEnabled() as $module)
        {
            static::$modelDefaultSettings[$module->getLowerName()] = config($module->getLowerName() . ".user_settings");
        }
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->defaultSettings = static::$modelDefaultSettings;
    }



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
        'admin',
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

    public function cacheKey()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }

    public function storeMindefConnectInformations($informations)
    {
        Cache::put($this->cacheKey() . ':mindefConnectInformations', $informations, 60*60*24);
    }

    public function getMindefConnectInformations()
    {
        return Cache::get($this->cacheKey() . ':mindefConnectInformations');
    }

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

    public function IsSuperAdmin()
    {
        // renvoie si le user est superadmin
        if ($this->admin)
            return 1;
        
        return 0;
    }
}
