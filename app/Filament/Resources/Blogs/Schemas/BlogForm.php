<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                FileUpload::make('video')
                  ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                   ->maxSize(100000)
                    ->required(),
            ]);
    }
}
