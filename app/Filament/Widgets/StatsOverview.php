<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Blog;
use App\Models\Project;


class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('number of blogs', Blog::all()->count()),
            Stat::make('number of projects',Project::all()->count()),
        ];
    }
}
