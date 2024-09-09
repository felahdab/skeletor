<?php

namespace Modules\RH\Entities;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\User;

class Personne extends User
{
    use HasUuids; 

    protected $primaryKey = 'uuid';

    protected $table='users';
}
