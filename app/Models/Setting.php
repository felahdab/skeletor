<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'data'
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }

    public static function forKey($key)
    {
        return static::where('key', $key)->first();
    }

    public function updateSetting($data)
    {
        $this->data = $data;
        $this->save();
    }

    public function set($key, $value)
    {
        $data = $this->data;
        Arr::set($data, $key, $value);
        $this->data = $data;
        $this->save();
    }

    public function get($key)
    {
        $data = $this->data;
        return Arr::get($data, $key);
    }

}
