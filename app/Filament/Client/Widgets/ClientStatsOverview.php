<?php

namespace App\Filament\Client\Widgets;

use App\Models\Project;
use App\Models\Submission;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ClientStatsOverview extends StatsOverviewWidget
{

    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $userId = Auth::id();

        $avgProgress = (int) Project::where('client_id', $userId)->get()->avg('completion_percentage');

        $totalDocs = Media::whereHasMorph('model', [Submission::class], function ($query) use ($userId) {
            $query->where('status', 'done')
                ->whereHas('task.project', fn($q) => $q->where('client_id', $userId));
        })->count();

        $totalPending = Task::whereHas('project', fn($q) => $q->where('client_id', $userId))
            ->where('status', '!=', 'valide')
            ->count();

        return [
            Stat::make('Progression Portefeuille', $avgProgress . '%')
                ->description('Moyenne de vos projets actifs')
                ->chart([5, 10, 20, $avgProgress])
                ->color('primary'),

            Stat::make('Total Livrables', $totalDocs)
                ->description('Documents officiels archivés')
                ->icon('heroicon-m-document-duplicate')
                ->color('success'),

            Stat::make('Missions en attente', $totalPending)
                ->description('Tâches restant à finaliser')
                ->icon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
