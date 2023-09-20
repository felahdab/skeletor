<?php

namespace Modules\Transformation\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Transformation\Traits\HasTablePrefix;

use Modules\Transformation\Entities\User;
use App\Models\Unite;

class MiseEnVisibilite extends Model
{
    use HasTablePrefix;
    use HasFactory;

    protected $fillable = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

}
