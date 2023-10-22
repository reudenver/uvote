<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\PartyList;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count()),
            Stat::make('Departments', Department::count()),
            Stat::make('Partylists', PartyList::count()),
        ];
    }
}
