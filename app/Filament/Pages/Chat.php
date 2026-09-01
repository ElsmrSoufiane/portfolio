<?php

namespace App\Filament\Pages;

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
use Livewire\Attributes\Validate;

class Chat extends Page
{
    #[Validate('required|max:100')]
    public string $message = '';

    public array $messages = [];

    protected string $view = 'filament.pages.chat';

    public static function getNavigationLabel(): string
    {
        return 'Chat';
    }

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedChatBubbleLeft;
    }

    public static function getNavigationBadge(): ?string
    {
        return '5';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    public function mount(): void
    {
        $this->loadMessages();
    }

    public function send()
    {
        $this->validate();

        $admin = User::where('role', UserRole::Admin->value)->first();
        $conversation = Conversation::between(auth()->id(), $admin->id);

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
                $this->loadMessages();

                Notification::make()
                    ->title('message has been deleted')
                    ->danger()
                    ->send();
            });
    }

    public function loadMessages(): void
    {
        $admin = User::where('role', UserRole::Admin->value)->first();
        $conversation = Conversation::between(auth()->id(), $admin->id);

        $this->messages = Message::query()
            ->where('conversation_id', $conversation->id)
            ->orderBy('created_at')
            ->get()
            ->map(fn (Message $message) => [
                'id' => $message->id,
                'user_id' => $message->user_id,
                'is_own' => $message->user_id === auth()->id(),
                'content' => $message->content,
                'time' => $message->created_at->format('h:i A'),
            ])
            ->all();
    }
}
