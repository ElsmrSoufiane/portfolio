<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Chat extends Page
{
    protected static ?string $navigationLabel = 'Chat';

    protected static string|Heroicon|null $navigationIcon = Heroicon::OutlinedChatBubbleLeft;

    protected static ?string $navigationGroup = 'Chat';

    public static function getNavigationBadge(): ?string
    {
        return '5';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'info';
    }

    protected string $view = 'filament.pages.chat';
}
