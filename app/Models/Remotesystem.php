<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Remotesystem extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;

    protected $fillable = ['uuid', 'nom'];

    public function IsSuperAdmin()
    {
        return false;
    }

    protected function getDefaultGuardName(): string
    {
        return 'api';
    }
}
