<?php

namespace App\Filament\Resources\Projects;

use App\Filament\Resources\Projects\Pages\CreateProject;
use App\Filament\Resources\Projects\Pages\EditProject;
use App\Filament\Resources\Projects\Pages\ListProjects;
use App\Filament\Resources\Projects\Pages\ViewProject;
use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Filament\Resources\Projects\Schemas\ProjectInfolist;
use App\Filament\Resources\Projects\Tables\ProjectsTable;
use App\Models\Project;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use App\Filament\Resources\Projects\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\Projects\RelationManagers\SectionsRelationManager;
use App\Filament\Resources\Projects\RelationManagers\VideosRelationManager;
use App\Filament\Resources\Projects\RelationManagers\ThemesRelationManager;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPaintBrush;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ProjectInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
            SectionsRelationManager::class,
            VideosRelationManager::class,
            ThemesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'view' => ViewProject::route('/{record}'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
