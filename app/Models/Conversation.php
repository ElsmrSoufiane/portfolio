<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_one_id', 'user_two_id'])]
class Conversation extends Model
{
    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public static function between(int $firstUserId, int $secondUserId): self
    {
        $conversation = static::query()
            ->where(function ($query) use ($firstUserId, $secondUserId) {
                $query->where('user_one_id', $firstUserId)->where('user_two_id', $secondUserId);
            })
            ->orWhere(function ($query) use ($firstUserId, $secondUserId) {
                $query->where('user_one_id', $secondUserId)->where('user_two_id', $firstUserId);
            })
            ->first();

        return $conversation ?? static::create([
            'user_one_id' => $firstUserId,
            'user_two_id' => $secondUserId,
        ]);
    }
}
