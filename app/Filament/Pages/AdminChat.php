<?php

namespace App\Filament\Pages;

use App\Events\MessageDeleted;
use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class AdminChat extends Page
{
    #[Validate('required|max:100')]
    public string $message = '';

    public array $conversations = [];

    public array $messages = [];

    public ?int $activeConversationId = null;

    public array $onlineUserIds = [];

    protected string $view = 'filament.pages.admin-chat';

    public static function getNavigationLabel(): string
    {
        return 'Admin Chat';
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedChatBubbleBottomCenterText;
    }

    public function mount(): void
    {
        $this->loadConversations();

        $this->activeConversationId ??= $this->conversations[0]['id'] ?? null;

        $this->loadMessages();

        if ($this->activeConversationId !== null) {
            $this->markConversationRead($this->activeConversationId);
        }
    }

    public function switchConversation(int $id)
    {
        abort_unless($this->isAdminConversation($id), 404);

        $this->activeConversationId = $id;
        $this->reset('message');

        $this->loadMessages();
        $this->markConversationRead($id);
    }

    public function send()
    {
        $this->validate();

        $conversation = $this->getActiveConversationModel();

        $message = Message::create(
            [
                'conversation_id' => $conversation->id,
                'user_id' => auth()->id(),
                'content' => $this->message,
            ]
        );

        broadcast(new MessageSent($message))->toOthers();

        $this->loadConversations();
        $this->loadMessages();
        $this->reset('message');

        Notification::make()
            ->title('message has been sent')
            ->success()
            ->send();
    }

    #[On('message-sent')]
    public function onMessageSent(array $message): void
    {
        $conversationId = (int) ($message['conversation_id'] ?? 0);

        if ($conversationId !== $this->activeConversationId) {
            $this->loadConversations();

            return;
        }

        if ((int) ($message['user_id'] ?? 0) === auth()->id()) {
            return;
        }

        $this->loadConversations();
        $this->loadMessages();
        $this->markConversationRead($conversationId);
    }

    #[On('message-read')]
    public function onMessageRead(array $messageIds, ?int $conversationId = null): void
    {
        $this->loadConversations();
        $this->loadMessages();
    }

    #[On('message-updated')]
    public function onMessageUpdated(int $messageId, ?int $conversationId = null): void
    {
        $this->loadConversations();
        $this->loadMessages();
    }

    #[On('message-deleted')]
    public function onMessageDeleted(int $messageId, ?int $conversationId = null): void
    {
        $this->loadConversations();
        $this->loadMessages();
    }

    #[On('presence-updated')]
    public function onPresenceUpdated(array $onlineUserIds): void
    {
        $this->onlineUserIds = array_map('intval', $onlineUserIds);
        $this->loadConversations();
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->iconButton()
            ->icon('heroicon-m-pencil-square')
            ->color('gray')
            ->fillForm(fn (Action $action): array => [
                'content' => Message::query()
                    ->where('conversation_id', $this->activeConversationId)
                    ->where('id', $action->getArguments()['id'])
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
                    ->where('conversation_id', $this->activeConversationId)
                    ->where('id', $arguments['id'])
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
                    ->where('conversation_id', $this->activeConversationId)
                    ->where('id', $arguments['id'])
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

    public function getActiveConversation(): array
    {
        $active = collect($this->conversations)
            ->first(fn (array $conversation): bool => $conversation['id'] === $this->activeConversationId);

        return $active ?? ($this->conversations[0] ?? []);
    }

    protected function loadConversations(): void
    {
        $this->conversations = Conversation::query()
            ->where('user_one_id', auth()->id())
            ->orWhere('user_two_id', auth()->id())
            ->with([
                'messages' => fn ($query) => $query->latest()->limit(1),
            ])
            ->get()
            ->map(function (Conversation $conversation): array {
                $userId = $conversation->otherUserId(auth()->id());
                $user = $userId !== null ? User::query()->find($userId) : null;
                $lastMessage = $conversation->messages->first();

                return [
                    'id' => $conversation->id,
                    'name' => $user?->name ?? 'Unknown',
                    'initials' => $this->initials($user?->name),
                    'status' => $lastMessage
                        ? $lastMessage->created_at->format('g:i A')
                        : 'No messages yet',
                    'is_recent' => ($lastMessage?->created_at->gt(now()->subMinutes(5)) ?? false),
                    'unread' => $conversation->unreadCountFor(auth()->id()),
                    'online' => $userId !== null
                        && in_array($userId, $this->onlineUserIds, true),
                ];
            })
            ->sortByDesc('id')
            ->values()
            ->all();
    }

    protected function loadMessages(): void
    {
        if ($this->activeConversationId === null) {
            $this->messages = [];

            return;
        }

        $this->messages = Message::query()
            ->where('conversation_id', $this->activeConversationId)
            ->orderBy('created_at')
            ->get()
            ->map(fn (Message $message) => [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'is_own' => $message->user_id === auth()->id(),
                'content' => $message->content,
                'time' => $message->created_at->format('g:i A'),
                'read' => $message->read_at !== null,
            ])
            ->all();
    }

    protected function markConversationRead(int $conversationId): void
    {
        $conversation = Conversation::query()->find($conversationId);

        if ($conversation === null || ! $conversation->isParticipant(auth()->id())) {
            return;
        }

        $affectedIds = $conversation->messages()
            ->notFromUser(auth()->id())
            ->unread()
            ->pluck('id');

        if ($affectedIds->isEmpty()) {
            return;
        }

        $conversation->markAsReadFor(auth()->id());

        broadcast(new MessageRead(
            conversationId: $conversation->id,
            userId: auth()->id(),
            messageIds: $affectedIds->map(fn (int $id): int => (int) $id)->all(),
        ));

        $this->loadConversations();
        $this->loadMessages();
    }

    protected function getActiveConversationModel(): Conversation
    {
        return Conversation::query()
            ->where('id', $this->activeConversationId)
            ->where(
                fn ($query) => $query
                    ->where('user_one_id', auth()->id())
                    ->orWhere('user_two_id', auth()->id())
            )
            ->firstOrFail();
    }

    protected function isAdminConversation(int $id): bool
    {
        return Conversation::query()
            ->where('id', $id)
            ->where(
                fn ($query) => $query
                    ->where('user_one_id', auth()->id())
                    ->orWhere('user_two_id', auth()->id())
            )
            ->exists();
    }

    protected function initials(?string $name): string
    {
        if ($name === null) {
            return '?';
        }

        return Str::of($name)
            ->explode(' ')
            ->filter()
            ->map(fn (string $part): string => Str::upper(Str::substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    }
}
