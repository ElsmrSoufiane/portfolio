<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\Validate;

class AdminChat extends Page
{
    #[Validate('required|max:100')]
    public string $message = '';

    public array $conversations = [];

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
        $this->conversations = [
            [
                'id' => 1,
                'name' => 'lasmar soufiane',
                'initials' => 'LS',
                'status' => 'Online now',
                'messages' => [
                    ['is_own' => false, 'content' => 'Hello admin, I have a question about my order.', 'time' => '09:12 AM'],
                    ['is_own' => true, 'content' => 'Sure, what can I help you with?', 'time' => '09:14 AM'],
                    ['is_own' => false, 'content' => 'When will my package arrive?', 'time' => '09:15 AM'],
                ],
            ],
            [
                'id' => 2,
                'name' => 'yassine benali',
                'initials' => 'YB',
                'status' => 'Last seen 5m ago',
                'messages' => [
                    ['is_own' => false, 'content' => 'Hi, is the new collection available?', 'time' => '08:40 AM'],
                    ['is_own' => true, 'content' => 'Yes, it was just released today.', 'time' => '08:42 AM'],
                ],
            ],
            [
                'id' => 3,
                'name' => 'amina el idrissi',
                'initials' => 'AE',
                'status' => 'Offline',
                'messages' => [
                    ['is_own' => false, 'content' => 'I would like to return an item.', 'time' => 'Yesterday'],
                    ['is_own' => true, 'content' => 'No problem, please send your order number.', 'time' => 'Yesterday'],
                    ['is_own' => false, 'content' => 'Order #4821, thank you!', 'time' => 'Yesterday'],
                ],
            ],
            [
                'id' => 4,
                'name' => 'mehdi alaoui',
                'initials' => 'MA',
                'status' => 'Online now',
                'messages' => [
                    ['is_own' => true, 'content' => 'Welcome to our store!', 'time' => '07:55 AM'],
                ],
            ],
        ];

        $this->activeConversationId ??= $this->conversations[0]['id'];
    }

    public function selectConversation(int $id): void
    {
        $this->activeConversationId = $id;
        $this->reset('message');
    }

    public function getActiveConversation(): array
    {
        foreach ($this->conversations as $conversation) {
            if ($conversation['id'] === $this->activeConversationId) {
                return $conversation;
            }
        }

        return $this->conversations[0];
    }

    public function send(): void
    {
        $this->validate();
        $this->reset('message');
    }
}
