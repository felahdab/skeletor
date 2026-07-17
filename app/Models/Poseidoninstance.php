<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poseidoninstance extends Model
{
    protected $fillable = ['uuid', 'nom', 'data', 'last_seen'];

    protected function casts(): array
    {
        return [
            'last_seen' => 'timestamp'
        ];
    }

}
