<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MindefConnectUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'email',
        'name',
        'prenom',
        'main_department_number',
        'personal_title',
        'rank',
        'short_rank',
        'display_name',
        ];
}
