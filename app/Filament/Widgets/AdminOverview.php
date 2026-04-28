<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminOverview extends StatsOverviewWidget
{

    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? null;
        $endDate = $this->pageFilters['endDate'] ?? null;

        return [
            Stat::make('Chantiers Actifs', Project::whereIn('status', ['en_cours', 'etude'])->count())
                ->description('Projets en cours d\'exécution')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Tâches en Attente', Task::where('status', 'a_faire')->count())
                ->description('Besoin d\'assignation ou lancement')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Clients Total', User::whereHas('roles', fn($q) => $q->where('name', 'client'))->count())
                ->description('Portefeuille client actif')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];


    }

    protected static ?int $sort = 0;

}
