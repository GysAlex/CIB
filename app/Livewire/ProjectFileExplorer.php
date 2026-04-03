<?php

namespace App\Livewire;

use App\Models\Submission;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Actions\Contracts\HasActions;
use Spatie\MediaLibrary\Support\MediaStream;

class ProjectFileExplorer extends Component implements HasSchemas, HasActions
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    public $projectId;
    public $taskId = null;


    public function viewDetailsAction(): Action
    {
        return Action::make('viewDetails')
            ->label('Détails')
            ->icon('heroicon-m-information-circle')
            ->color('info')
            ->record(fn(array $arguments) => Media::find($arguments['record']))
            ->modalHeading('Informations sur le fichier')
            ->modalSubmitAction(false) // On ne veut pas de bouton de soumission
            ->infolist(
                [
                    Section::make('Fichier')
                        ->schema([
                            TextEntry::make('name')
                                ->label('Nom du fichier'),
                            TextEntry::make('mime_type')->label('Type MIME'),
                            TextEntry::make('size')
                                ->label('Taille')
                                ->formatStateUsing(fn($state) => number_format($state / 1024 / 1024, 2) . ' MB'),
                            TextEntry::make('created_at')->label('Ajouté le')->dateTime(),
                        ])->columns(2),
                    Section::make('Contexte technique')
                        ->schema([
                            TextEntry::make('model.task.title')->label('Mission associée'),
                            TextEntry::make('model.user.name')->label('Auteur du rendu'),
                            TextEntry::make('model.task.creator.name')->label('Valider par')
                        ])->columns(3)
                ]
            );


    }



    public function getFiles()
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

        return $files;
    }

    public function render()
    {
        $files = $this->getFiles();

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

        $files = $this->getFiles();

        return MediaStream::create('tous_les_fichiers.zip')
            ->addMedia($files);

    }
}
