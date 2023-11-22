<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkeletorUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'uri',
        'route',
        'session',
        'source',
        'user-agent',
        'user-email',
        'status',
        'ip',
        'method',
        'response_time',
        'counter'
    ];
}
