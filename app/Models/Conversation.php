<?php

namespace App\Models;

use App\UserRole;
use Database\Factories\ConversationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_one_id', 'user_two_id'])]
class Conversation extends Model
{
    /** @use HasFactory<ConversationFactory> */
    use HasFactory;

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

    public function otherUser(int $userId): ?User
    {
        $otherId = $this->otherUserId($userId);

        return $otherId === null ? null : User::query()->find($otherId);
    }

    public function otherUserId(int $userId): ?int
    {
        if ($this->user_one_id === $userId) {
            return $this->user_two_id;
        }

        if ($this->user_two_id === $userId) {
            return $this->user_one_id;
        }

        return null;
    }

    public function isParticipant(int $userId): bool
    {
        return $this->user_one_id === $userId || $this->user_two_id === $userId;
    }

    public function unreadCountFor(int $userId): int
    {
        return $this
            ->messages()
            ->notFromUser($userId)
            ->unread()
            ->count();
    }

    public function markAsReadFor(int $userId): int
    {
        return $this
            ->messages()
            ->notFromUser($userId)
            ->unread()
            ->update(['read_at' => now()]);
    }

    public function isAdminConversation(int $userId): bool
    {
        $otherId = $this->otherUserId($userId);

        if ($otherId === null) {
            return false;
        }

        return User::query()->whereKey($otherId)->where('role', UserRole::Admin)->exists();
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
