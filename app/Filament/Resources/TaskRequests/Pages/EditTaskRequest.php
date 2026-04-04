<?php

namespace App\Filament\Resources\TaskRequests\Pages;

use App\Filament\Resources\TaskRequests\TaskRequestResource;
use App\Notifications\TaskRequestResponseDecisionNotification;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTaskRequest extends EditRecord
{
    protected static string $resource = TaskRequestResource::class;


    protected static ?string $title = "Détails de la demande";
    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approuver')
                ->icon('heroicon-m-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->action(function ($record) {
                    // 1. Déterminer la catégorie
                    $category = $record->task_template_id
                        ? $record->project->categories()->firstOrCreate(
                            ['category_template_id' => $record->taskTemplate->category_template_id],
                            ['title' => $record->taskTemplate->categoryTemplate->title]
                        )
                        : $record->project->categories()->firstOrCreate(
                            ['title' => 'Demandes Client Spécifiques'],
                            ['order' => 99]
                        );

                    // 2. Créer la tâche
                    $record->project->tasks()->create([
                        'category_id' => $category->id,
                        'task_template_id' => $record->task_template_id,
                        'creator_id' => auth()->id(),
                        'title' => $record->title,
                        'description' => $record->description,
                        'priority' => $record->priority,
                        'status' => 'a_faire',
                        'deadline' => $record->project->end_date,
                    ]);

                    $record->update(['status' => 'approuve', 'admin_comment' => 'Validé par l\'administration.']);
                })
                ->visible(fn($record) => $record->status === 'en_attente')
                ->successRedirectUrl($this->getResource()::getUrl('index')),

            Action::make('reject')
                ->label('Rejeter')
                ->icon('heroicon-m-x-circle')
                ->color('danger')
                ->modalHeading('Rejeter la demande de tâche')
                ->modalDescription('Veuillez indiquer au client la raison du refus de cette prestation.')
                ->modalSubmitActionLabel('Confirmer le rejet')
                ->form([
                    Textarea::make('admin_comment')
                        ->label('Motif du rejet')
                        ->placeholder('Ex: Cette prestation n\'est pas incluse dans votre forfait actuel...')
                        ->required()
                        ->rows(3),
                ])

                ->action(function (\App\Models\TaskRequest $record, array $data) {

                    $record->update([
                        'status' => 'rejete',
                        'admin_comment' => $data['admin_comment'],
                    ]);

                    // 2. Notification interne pour l'Admin (Succès visuel)
                    Notification::make()
                        ->title('Demande rejetée')
                        ->body('Le client a été informé de votre décision.')
                        ->danger()
                        ->send();

                    $record->client->notify(new TaskRequestResponseDecisionNotification($record));

                    
                })
                ->successRedirectUrl($this->getResource()::getUrl('index'))
                ->visible(fn($record) => $record->status === 'en_attente'), // L'action disparaît si déjà traitée
        ];
    }

    protected function afterSave()
    {
        if ($this->record->status == "approuve") {
            Notification::make()
                ->success()
                ->title('Demande approuvée et injectée')
                ->sendToDatabase($this->record->client);
            $this->record->client->notify(new TaskRequestResponseDecisionNotification($this->record));

        } else if ($this->record->status == "rejete") {
            $this->record->client->notify(new TaskRequestResponseDecisionNotification($this->record));
        }
    }
}
