<?php

namespace Modules\Transformation\Entities;

use Modules\Transformation\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSousObjectif extends Model
{
    use HasFactory;
    use HasTablePrefix;
    
    protected $table = 'user_sous_objectif';

}
