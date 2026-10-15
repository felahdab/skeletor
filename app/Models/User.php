<?php

namespace App\Models;

use App\Filament\AvatarProviders\AnnudefAvatarProvider;
use App\Observers\UserObserver;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Lab404\Impersonate\Models\Impersonate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use Impersonate;

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
        'sub',
        'uuid',
        'nom',
        'prenom',
        'email',
        'password',
        'display_name',
        'admin',
        'data',
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

    public function canAccessPanel(Panel $panel): bool
    {
        // Par défaut, le panel admin n'est accessible qu'au super admins.
        // Les autres panels sont accessibles à tout le monde (la sécurité se fera au niveau des ressources et autres elements filament)
        // if ($panel->getID() === 'admin')
        //     return $this->IsSuperAdmin();
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->display_name;
    }

    public function cacheKey()
    {
        return sprintf(
            '%s/%s-%s',
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }

    public function storeMindefConnectInformations($informations)
    {
        Cache::put($this->cacheKey().':mindefConnectInformations', $informations, 60 * 60 * 24);
    }

    public function getMindefConnectInformations()
    {
        return Cache::get($this->cacheKey().':mindefConnectInformations');
    }

    /**
     * Always encrypt password when it is updated.
     */
    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Renvoie l'url de l'image de profil.
     *
     * @deprecated A retirer des que possible. Remplacé par le gestionnaire d'avatar de Filament.
     *
     * @return string
     */
    public function getAnnudefPictureUrl()
    {
        $avatarProvider = new AnnudefAvatarProvider();

        return $avatarProvider->get($this);
    }

    public function IsSuperAdmin()
    {
        // renvoie si le user est superadmin
        if ($this->admin) {
            return 1;
        }

        return 0;
    }

    public function canImpersonate()
    {
        return $this->admin || $this->can('skeletor.se_faire_passer_pour');
    }

    public function canBeImpersonated()
    {
        return !$this->admin;
    }

    /**
     * Renvoie les préférences personnelles enregistrées pour une section déclarée
     * par un module dans le ModuleDefinedUserPreferencesRegistry.
     *
     * @return array<string, mixed>
     */
    public function getPreferences(string $section): array
    {
        $preferences = Arr::get($this->data ?? [], "settings.{$section}", []);

        if (!is_array($preferences)) {
            throw new \UnexpectedValueException("The user preferences for section [{$section}] must be an array.");
        }

        return $preferences;
    }

    /**
     * Renvoie une préférence personnelle d'une section. La clé accepte la notation pointée.
     */
    public function getPreference(string $section, string $key, mixed $default = null): mixed
    {
        return Arr::get($this->getPreferences($section), $key, $default);
    }

    /**
     * Fusionne les préférences fournies avec celles déjà enregistrées pour la section.
     * Les préférences de la section qui ne sont pas fournies sont conservées.
     *
     * Cette méthode ne persiste pas le modèle: appeler save() pour enregistrer.
     *
     * @param array<string, mixed> $preferences
     */
    public function setPreferences(string $section, array $preferences): static
    {
        $data = $this->data ?? [];

        Arr::set($data, "settings.{$section}", array_replace($this->getPreferences($section), $preferences));

        $this->data = $data;

        return $this;
    }

    /**
     * Définit une préférence personnelle d'une section. La clé accepte la notation pointée.
     *
     * Cette méthode ne persiste pas le modèle: appeler save() pour enregistrer.
     */
    public function setPreference(string $section, string $key, mixed $value): static
    {
        $preferences = $this->getPreferences($section);

        Arr::set($preferences, $key, $value);

        return $this->setPreferences($section, $preferences);
    }

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'email_verified_at' => 'datetime',
        ];
    }
}
