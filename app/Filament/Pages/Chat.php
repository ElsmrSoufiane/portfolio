<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Chat extends Page
{
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
}
