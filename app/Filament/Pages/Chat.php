<?php

namespace App\Filament\Pages;

use App\Events\MessageDeleted;
use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\UserRole;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class Chat extends Page
{
    #[Validate('required|max:100')]
    public string $message = '';

    public array $messages = [];

    public ?int $otherUserId = null;

    public ?int $conversationId = null;

    public bool $otherUserOnline = false;

    public bool $hasMoreMessages = false;

    protected string $view = 'filament.pages.chat';

    public static function getNavigationLabel(): string
    {
        return 'Chat';
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedChatBubbleLeft;
    }

    public function getHeading(): string
    {
        return '';
    }

    public function mount(): void
    {
        $this->loadMessages();
        $this->loadOtherUser();
        $this->markConversationRead();
    }

    public function send()
    {
        $this->validate();

        $admin = $this->admin();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        $message = Message::create(
            [
                'conversation_id' => $conversation->id,
                'user_id' => auth()->id(),
                'content' => $this->message,
            ]
        );

        broadcast(new MessageSent($message))->toOthers();

        $this->loadMessages();
        $this->loadOtherUser();
        $this->reset('message');

        Notification::make()
            ->title('message has been sent')
            ->success()
            ->send();
    }

    #[On('message-sent')]
    public function onMessageSent(array $message): void
    {
        $admin = $this->admin();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        if ((int) ($message['conversation_id'] ?? 0) !== $conversation->id) {
            return;
        }

        if ((int) ($message['user_id'] ?? 0) === auth()->id()) {
            return;
        }

        $this->loadOtherUser();

        $this->appendIncomingMessage($message);

        $this->markConversationRead();
    }

    #[On('message-read')]
    public function onMessageRead(array $messageIds, ?int $conversationId = null): void
    {
        $this->refreshReadStatus($messageIds);
    }

    #[On('message-updated')]
    public function onMessageUpdated(int $messageId, ?int $conversationId = null): void
    {
        if ($conversationId !== null && (int) $conversationId !== $this->conversationId) {
            return;
        }

        foreach ($this->messages as $index => $message) {
            if ($message['id'] === $messageId) {
                $this->messages[$index]['content'] = Message::query()->where('id', $messageId)->value('content');
            }
        }
    }

    #[On('message-deleted')]
    public function onMessageDeleted(int $messageId, ?int $conversationId = null): void
    {
        if ($conversationId !== null && (int) $conversationId !== $this->conversationId) {
            return;
        }

        $this->messages = array_values(array_filter(
            $this->messages,
            fn (array $message): bool => $message['id'] !== $messageId,
        ));
    }

    #[On('presence-updated')]
    public function onPresenceUpdated(array $onlineUserIds): void
    {
        if ($this->otherUserId === null) {
            return;
        }

        $this->otherUserOnline = in_array($this->otherUserId, array_map('intval', $onlineUserIds), true);
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->iconButton()
            ->icon('heroicon-m-pencil-square')
            ->color('gray')
            ->fillForm(fn (Action $action): array => [
                'content' => Message::query()
                    ->where('id', $action->getArguments()['id'])
                    ->where('user_id', auth()->id())
                    ->value('content'),
            ])
            ->form([
                Textarea::make('content')
                    ->label('Message')
                    ->required()
                    ->maxLength(100)
                    ->rows(4),
            ])
            ->action(function (array $arguments, array $data): void {
                $message = Message::query()
                    ->where('id', $arguments['id'])
                    ->where('user_id', auth()->id())
                    ->first();

                $message?->update(['content' => $data['content']]);

                if ($message !== null) {
                    broadcast(new MessageUpdated(
                        messageId: $message->id,
                        conversationId: $message->conversation_id,
                        content: $message->content,
                    ));
                }

                $this->loadMessages();

                Notification::make()
                    ->title('message has been updated')
                    ->success()
                    ->send();
            });
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->iconButton()
            ->icon('heroicon-m-trash')
            ->color('danger')
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                $message = Message::query()
                    ->where('id', $arguments['id'])
                    ->where('user_id', auth()->id())
                    ->first();

                $message?->delete();

                if ($message !== null) {
                    broadcast(new MessageDeleted(
                        messageId: $message->id,
                        conversationId: $message->conversation_id,
                    ));
                }

                $this->loadMessages();

                Notification::make()
                    ->title('message has been deleted')
                    ->danger()
                    ->send();
            });
    }

    public function loadMessages(): void
    {
        $admin = $this->admin();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        $this->conversationId = $conversation->id;

        $this->messages = Message::query()
            ->where('conversation_id', $conversation->id)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (Message $message) => $this->messagePayload($message))
            ->all();

        $this->hasMoreMessages = ! empty($this->messages) && Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('id', '<', $this->messages[0]['id'])
            ->exists();
    }

    public function loadOlderMessages(): void
    {
        if (empty($this->messages) || ! $this->hasMoreMessages) {
            return;
        }

        $admin = $this->admin();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        $oldestId = $this->messages[0]['id'];

        $older = Message::query()
            ->where('conversation_id', $conversation->id)
            ->where('id', '<', $oldestId)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->reverse()
            ->values()
            ->map(fn (Message $message) => $this->messagePayload($message))
            ->all();

        $this->messages = array_merge($older, $this->messages);
        $this->hasMoreMessages = count($older) === 10;
    }

    protected function appendIncomingMessage(array $message): void
    {
        $id = (int) ($message['id'] ?? 0);

        if ($id === 0 || in_array($id, array_column($this->messages, 'id'), true)) {
            return;
        }

        $model = Message::query()
            ->with('user')
            ->where('id', $id)
            ->first();

        if ($model === null) {
            return;
        }

        $this->messages[] = $this->messagePayload($model);
    }

    protected function refreshReadStatus(array $messageIds): void
    {
        $ids = array_map('intval', $messageIds);

        foreach ($this->messages as $index => $message) {
            if (in_array($message['id'], $ids, true)) {
                $this->messages[$index]['read'] = true;
            }
        }
    }

    public function markConversationRead(): void
    {
        $affectedIds = $this->markIncomingAsRead();

        if ($affectedIds->isNotEmpty()) {
            $this->refreshReadStatus($affectedIds->all());
        }
    }

    protected function markIncomingAsRead(): Collection
    {
        $admin = $this->admin();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        $affectedIds = $conversation->messages()
            ->notFromUser(auth()->id())
            ->unread()
            ->pluck('id');

        if ($affectedIds->isEmpty()) {
            return $affectedIds;
        }

        $conversation->markAsReadFor(auth()->id());

        MessageRead::dispatch(
            conversationId: $conversation->id,
            userId: auth()->id(),
            messageIds: $affectedIds->map(fn (int $id): int => (int) $id)->all(),
        );

        return $affectedIds;
    }

    protected function loadOtherUser(): void
    {
        $admin = $this->admin();
        $this->otherUserId = $admin->id;
    }

    protected function admin(): User
    {
        return User::where('role', UserRole::Admin->value)->firstOrFail();
    }

    protected function messagePayload(Message $message): array
    {
        return [
            'id' => $message->id,
            'user_id' => $message->user_id,
            'is_own' => $message->user_id === auth()->id(),
            'content' => $message->content,
            'time' => $message->created_at->format('h:i A'),
            'read' => $message->read_at !== null,
        ];
    }
}
