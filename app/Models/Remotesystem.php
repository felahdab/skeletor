<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;

class Remotesystem  extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $fillable = ['uuid', 'nom'];

    protected function getDefaultGuardName(): string { return 'api'; }

    public function IsSuperAdmin()
    {
        return false;
    }
}
