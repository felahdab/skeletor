<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Builder;

class ChatThread extends Model
{
    use HasFactory;

    public function aboutmodel(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'chattable_type', 'chattable_id');
    }

    public function messages(): BelongsToMany
    {
        return $this->belongsToMany(ChatMessage::class, 'message_thread');
    }

    public static function forModel(Model $model)
    {
        return static::whereHasMorph(
            'aboutmodel',
            [$model->getMorphClass()],
            function (Builder $query) use ($model){
                $query->where('id', $model->id);
            }
        )->get();
    }
}
