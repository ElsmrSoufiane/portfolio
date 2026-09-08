<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('number of blogs'), Blog::all()->count()),
            Stat::make(__('number of projects'), Project::all()->count()),
        ];
    }
}
