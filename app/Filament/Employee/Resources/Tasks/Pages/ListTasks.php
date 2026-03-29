<?php

namespace App\Filament\Employee\Resources\Tasks\Pages;

use App\Filament\Employee\Resources\Tasks\TaskResource;
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



    #[Url]
    public ?string $project = null;

    #[On('project-filter-updated')]
    public function refreshFilteredTable($projectId): void
    {
        $this->project = $projectId;
    }
}
