<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversationId}', function (User $user, int $conversationId) {
    return Conversation::query()
        ->where('id', $conversationId)
        ->where(
            fn ($query) => $query
                ->where('user_one_id', $user->id)
                ->orWhere('user_two_id', $user->id)
        )
        ->exists();
});

Broadcast::channel('presence.online', function (User $user) {
    return $user->only(['id', 'name']);
});
