<?php

namespace App\Filament\Employee\Widgets;

use App\Models\Submission;
use App\Models\SubmissionFeedback;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EmployeePerformanceOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id();

        return [
            Stat::make('Tâches à faire', Task::whereHas('members', fn($q) => $q->where('users.id', $userId))
                ->where('status', '!=', 'valide')->count())
                ->description('Travail en attente')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('info'),

            Stat::make('Soumissions Rejetées', Submission::where('user_id', $userId)
                ->where('status', 'rejected')->count())
                ->description('Nécessite des corrections')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Score Moyen', round(
                SubmissionFeedback::whereHas('submission', fn($q) => $q->where('user_id', $userId))
                    ->avg('score') ?? 0,
                1
            ) . ' / 5')
                ->description('Qualité de vos livrables')
                ->descriptionIcon('heroicon-m-star')
                ->color('success'),
        ];
    }
}
