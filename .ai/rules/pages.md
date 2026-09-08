---
paths:
  - app/Filament/Pages/AdminChat.php
  - 'app/Filament/Pages/**'
---

# Pages

## Chat read receipts + Reverb usage
Chat pages (Chat.php, AdminChat.php) track seen/unseen per-message via `messages.read_at`. "Unseen" = message not sent by current user with read_at null. Opening/switching a conversation auto-marks the other party's unread messages as read (Conversation::markAsReadFor) and broadcasts MessageRead. Sending broadcasts MessageSent to the `conversation.{id}` private channel with ->toOthers(). Both are ShouldBroadcastNow (no queue worker needed). Realtime JS lives in resources/js/chat.js (registered as a Filament Js asset in AppServiceProvider) — it subscribes to the active conversation's private channel plus the `presence.online` Echo presence channel, and dispatches `message-sent`/`message-read`/`presence-updated` Livewire events handled by the page's #[On()] methods. Broadcast::routes() is already registered via the `channels` key in bootstrap/app.php.

## Livewire 4 On() handler params must match dispatch keys
In Livewire 4, `window.Livewire.dispatch('event', { key: value })` spreads the payload as NAMED arguments into the `#[On('event')]` handler (`ImplicitlyBoundMethod`). The method parameter name(s) must match the dispatched keys, e.g. `dispatch('message-sent', { message: ... })` requires `onMessageSent(array $message)` — NOT `array $payload`. A mismatched name throws `Unable to resolve dependency [Parameter #0 [array $payload]]`. Name params after the payload keys; for `{ messageIds, conversationId }` use `onMessageRead(array $messageIds, ?int $conversationId = null)`.

## Chat message pagination: last-10 + loadOlderMessages
Both Chat and AdminChat load messages newest-first: `loadMessages()` fetches the last 10 (orderByDesc created_at AND id), reverses to oldest-first for rendering, and sets `hasMoreMessages` by checking for any id < the oldest loaded id. `loadOlderMessages()` cursor-fetches the previous 10 (id < oldestId) and prepends. Realtime On() handlers must NOT call full loadMessages() (it would collapse loaded history) — instead they append/update/filter in place via appendIncomingMessage/refreshReadStatus. markConversationRead no longer reloads; it marks DB read via markIncomingAsRead and refreshes local read flags with refreshReadStatus.
