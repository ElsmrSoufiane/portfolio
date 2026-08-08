<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Blogs\BlogResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';


    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
