<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_one_id', 'user_two_id'])]
class Conversation extends Model
{
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
