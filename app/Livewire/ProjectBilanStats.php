<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Livewire\Attributes\On;

class ProjectBilanStats extends StatsOverviewWidget
{
    // On passe l'ID du projet depuis la page parente
    public ?int $projectId = null;

    protected function getStats(): array
    {
        if (!$this->projectId) {
            return [
                Stat::make('Sélectionnez un projet', '--')
                    ->description('Veuillez choisir un projet pour voir les statistiques')
                    ->icon('heroicon-m-magnifying-glass'),
            ];
        }

        $project = Project::with('tasks')->find($this->projectId);

        if (!$project)
            return [];

        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'valide')->count();
        $remainingTasks = $project->tasks->where('status', '!=', 'valide');

        // Calcul du pourcentage de progression
        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Récupération du nombre de fichiers uniques validés (GED)
        $filesCount = \DB::table('media')
            ->whereIn('model_id', $project->tasks->pluck('id'))
            ->where('model_type', Task::class) // Ou Submission selon ton stockage
            ->count();

        return [
            // 1. Barre de progression visuelle
            Stat::make('Avancement Global', "{$progress}%")
                ->description("{$completedTasks} sur {$totalTasks} missions terminées")
                ->descriptionIcon($progress === 100 ? 'heroicon-m-check-badge' : 'heroicon-m-chart-bar')
                ->color($progress === 100 ? 'success' : 'primary')
                ->chart([$progress, 100]), // Petit graphique linéaire

            // 2. Compteur de tâches restantes avec détail
            Stat::make('Missions Restantes', $remainingTasks->count())
                ->description(function () use ($remainingTasks) {
                    if ($remainingTasks->isEmpty())
                        return "Projet terminé !";
                    // On affiche les 2 premières tâches restantes pour ne pas encombrer
                    return "Ex: " . $remainingTasks->take(2)->pluck('title')->implode(', ');
                })
                ->color($remainingTasks->isEmpty() ? 'success' : 'warning')
                ->icon('heroicon-m-clipboard-document-list'),

            // 3. Volume de la GED
            Stat::make('Documents Validés', $filesCount)
                ->description('Fichiers prêts pour archivage')
                ->icon('heroicon-m-folder-open')
                ->color('info'),
        ];
    }


    #[On('project-filter-updated')]
    public function refreshFilteredTable($projectId): void
    {
        $this->projectId = $projectId;
    }

    
}
