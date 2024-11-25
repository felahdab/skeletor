<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

use Spatie\Permission\Traits\HasRoles;

use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;

use Filament\Panel;

use Lab404\Impersonate\Models\Impersonate;

use App\Filament\AvatarProviders\AnnudefAvatarProvider;


#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use SoftDeletes;
    use Impersonate;

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
        // if ($panel->getID() === 'admin')
        //     return $this->IsSuperAdmin();
        return true;
    }

    public function getFilamentName(): string
    {
        return $this->display_name;
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
        'uuid',
        'nom',
        'prenom',
        'email',
        'password',
        'display_name',
        'admin',
        'data'
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

    /**
     * Renvoie l'url de l'image de profil
     *
     * @deprecated A retirer des que possible. Remplacé par le gestionnaire d'avatar de Filament.
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
        if ($this->admin)
            return 1;
        
        return 0;
    }

    public function canImpersonate()
    {
        return $this->admin;
    }
}
