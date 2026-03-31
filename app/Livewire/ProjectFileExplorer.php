<?php

namespace App\Livewire;

use App\Models\Submission;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Actions\Contracts\HasActions;

class ProjectFileExplorer extends Component implements HasSchemas
{

    use InteractsWithSchemas;
    public $projectId;
    public $taskId = null;


    public function deleteAction(): Action
    {
        return Action::make('viewDetails')
            ->label('Détails')
            ->icon('heroicon-m-information-circle')
            ->color('info')
            ->modalHeading('Informations sur le fichier')
            ->modalSubmitAction(false) // On ne veut pas de bouton de soumission
            ->action(function($arguments){
                dd($arguments);
            });
    }


    public function render()
    {
        // On récupère les IDs des tâches validées du projet
        $taskIds = Task::where('project_id', $this->projectId)
            ->where('status', 'valide')
            ->when($this->taskId, fn($q) => $q->where('id', $this->taskId))
            ->pluck('id');

        // On récupère les médias des soumissions approuvées de ces tâches
        $files = Media::whereHasMorph('model', [Submission::class], function ($query) use ($taskIds) {
            $query->whereIn('task_id', $taskIds)
                ->where('status', 'done');
        })->get();

        return view('livewire.project.project-file-explorer', [
            'files' => $files
        ]);
    }

    public function download($mediaId)
    {
        return Media::findOrFail($mediaId);
    }

    public function downloadAll()
    {

        if ($this->getFiles()->isEmpty())
            return;

    }
}
