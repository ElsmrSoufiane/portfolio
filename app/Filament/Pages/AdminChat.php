<?php

namespace App\Filament\Pages;

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
use Livewire\Attributes\Validate;

class AdminChat extends Page
{
    #[Validate('required|max:100')]
    public string $message = '';

    public array $conversations = [];

    public array $messages = [];

    public ?int $activeConversationId = null;

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
    }

    public function switchConversation(int $id)
    {
        abort_unless($this->isAdminConversation($id), 404);

        $this->activeConversationId = $id;
        $this->reset('message');

        $this->loadMessages();
    }

    public function send()
    {
        $this->validate();

        $conversation = $this->getActiveConversationModel();

        Message::create(
            [
                'conversation_id' => $conversation->id,
                'user_id' => auth()->id(),
                'content' => $this->message,
            ]
        );

        $this->loadMessages();
        $this->reset('message');

        Notification::make()
            ->title('message has been sent')
            ->success()
            ->send();
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
                $userId = $conversation->user_one_id === auth()->id()
                    ? $conversation->user_two_id
                    : $conversation->user_one_id;

                $user = User::query()->find($userId);
                $lastMessage = $conversation->messages->first();

                return [
                    'id' => $conversation->id,
                    'name' => $user?->name ?? 'Unknown',
                    'initials' => $this->initials($user?->name),
                    'status' => $lastMessage
                        ? $lastMessage->created_at->format('g:i A')
                        : 'No messages yet',
                    'is_recent' => $lastMessage?->created_at->gt(now()->subMinutes(5)) ?? false,
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
            ])
            ->all();
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
