<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Filament\Resources\Tasks\TaskResource;
use App\Filament\Resources\Tasks\Widgets\ProjectSwitcher;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProjectSwitcher::class,
        ];
    }


    #[Url]
    public ?string $project = null;

    #[On('project-filter-updated')]
    public function refreshFilteredTable($projectId): void
    {
        // On met à jour la propriété de la page. 
        // Cela force le rafraîchissement du composant Table.
        $this->project = $projectId;
    }
}
