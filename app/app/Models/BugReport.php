<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "url",
        "message",
        "user_id",
        "username"
        ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
