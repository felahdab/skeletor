<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poseidoninstance extends Model
{
    use HasFactory;

    protected $fillable = ['uuid', 'nom', 'data', 'last_seen', 'node_description', 'versions'];

    protected function casts(): array
    {
        return [
            'last_seen' => 'timestamp',
            'data' => 'array',
            'node_description' => 'array',
            'versions' => 'array',
        ];
    }

}
