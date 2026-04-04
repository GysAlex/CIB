<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Project;
use App\Notifications\DeliverableValidatedNotification;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading("Aucune tâche pour le moment")
            ->emptyStateIcon('heroicon-o-clipboard-document-list')
            ->emptyStateDescription(fn() => Project::count() > 0
                ? 'Commencez par assigner une mission à vos équipes.'
                : 'Vous devez créer un projet avant de pouvoir y ajouter des tâches.')
            ->emptyStateActions([
                Action::make('create')
                    ->label(fn() => Project::count() > 0 ? 'Créer une tâche' : "Créer un projet")
                    ->url(fn(): string => Project::count() > 0
                        ? TaskResource::getUrl('create')
                        : ProjectResource::getUrl('create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                // 1. Indicateur de Lancement (Nouveau)
                IconColumn::make('is_launched')
                    ->label('Lancée')
                    ->boolean()
                    ->trueIcon('heroicon-s-rocket-launch')
                    ->falseIcon('heroicon-o-pause-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn($state) => $state ? 'Tâche active sur le terrain' : 'En attente de lancement'),

                // 2. Projet avec description de localisation
                TextColumn::make('project.name')
                    ->label('Projet')
                    ->description(fn($record) => $record->project->location)
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary'),

                // 3. Titre + Indicateur de pièces jointes (Trombone)
                TextColumn::make('title')
                    ->label('Intitulé')
                    ->searchable()
                    ->limit(30)
                    ->icon(
                        fn($record) => $record->hasMedia('documents') || $record->hasMedia('attachements')
                        ? 'heroicon-o-paper-clip'
                        : null
                    )
                    ->iconColor('info'),

                // 4. Assignés (Membres)
                TextColumn::make('members.name')
                    ->label('Assigné à')
                    ->badge()
                    ->placeholder('Aucun intervenant')
                    ->color(fn($state) => $state ? 'gray' : 'danger'),

                TextColumn::make('priority')
                    ->label('Priorité')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'low' => 'Basse',
                        'medium' => 'Normale',
                        'high' => 'Haute',
                        default => $state,
                    }),

                // 6. Statut
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'a_faire' => 'gray',
                        'en_cours' => 'warning',
                        'en_attente_validation' => 'info',
                        'valide' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'a_faire' => 'À faire',
                        'en_cours' => 'En cours',
                        'en_attente_validation' => 'En attente',
                        'valide' => 'Validé',
                        default => $state,
                    }),

                // 7. Échéance
                TextColumn::make('deadline')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->placeholder('Non spécifié')
                    ->color(fn($record) => ($record->deadline && $record->deadline->isPast() && $record->status !== 'valide') ? 'danger' : 'gray'),
            ])
            ->filters([
                SelectFilter::make('project')
                    ->relationship('project', 'name')
                    ->label('Filtrer par projet'),

                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Basse',
                        'medium' => 'Normale',
                        'high' => 'Haute',
                    ])
                    ->label('Priorité'),

                TernaryFilter::make('is_launched')
                    ->label('Statut de lancement')
                    ->placeholder('Toutes les tâches')
                    ->trueLabel('Tâches lancées')
                    ->falseLabel('En attente de lancement'),
            ])
            ->actions([
                Action::make('launch')
                    ->label('Lancer')
                    ->icon('heroicon-m-rocket-launch')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Lancer la mission')
                    ->modalDescription(fn($record) => $record->members()->count() === 0
                        ? "Attention : Aucun intervenant n'est assigné. Vous ne pouvez pas lancer cette tâche."
                        : "Voulez-vous notifier les intervenants assignés ?")
                    ->hidden(fn($record) => $record->is_launched || $record->status === 'valide')

                    ->action(function ($record) {
                        if ($record->members()->count() === 0) {
                            Notification::make()
                                ->title('Action impossible')
                                ->body('Vous devez assigner au moins un intervenant avant de lancer la tâche.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->update([
                            'is_launched' => true,
                            'status' => 'en_cours',
                        ]);

                        Notification::make()
                            ->title('Tâche lancée avec succès')
                            ->success()
                            ->send();
                    }),
                Action::make('cancel_launch')
                    ->label('Annuler le lancement')
                    ->icon('heroicon-m-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Annuler l\'ordre de mission')
                    ->modalDescription('Cette action va retirer la tâche du planning des intervenants et leur envoyer une notification d\'annulation.')
                    ->modalSubmitActionLabel('Oui, annuler')

                    // Condition d'affichage : Seulement si lancée ET pas encore validée
                    // ->visible(fn($record) => $record->is_launched && $record->status !== 'valide')
                    ->visible(
                        fn($record) =>
                        $record->is_launched &&
                        $record->status !== 'valide'
                        // $record->getMedia('attachements')->count() === 0
                    )
                    ->action(function ($record) {
                        $record->update([
                            'is_launched' => false,
                            'status' => 'a_faire',
                            'launched_at' => null, // On réinitialise la date si tu l'utilises
                        ]);



                        // Notification d'annulation aux membres
                        $members = $record->members;

                        Notification::make()
                            ->title('Annulation de tâche')
                            ->body("L'ordre de mission pour la tâche \"{$record->title}\" a été annulé par l'administration.")
                            ->warning()
                            ->sendToDatabase($members);

                        Notification::make()
                            ->title('Lancement annulé')
                            ->success()
                            ->send();
                    }),
                Action::make('complete')
                    ->label('Terminer la mission')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Clôturer la tâche')
                    ->modalDescription('Confirmez-vous que tous les livrables ont été reçus et validés pour cette mission ? Cela marquera la tâche comme terminée pour tous les intervenants.')
                    ->modalSubmitActionLabel('Oui, marquer comme terminé')
                    ->visible(fn($record) => $record->is_launched && $record->status !== 'valide')
                    ->action(function ($record) {

                        $hasValidatedSubmission = $record->submissions()->where('status', 'done')->exists();

                        if (!$hasValidatedSubmission) {
                            Notification::make()
                                ->title('Clôture impossible')
                                ->body('Vous devez d\'abord approuver au moins une soumission d\'employé avant de terminer la tâche.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => 'valide',
                        ]);

                        // Notification de succès pour l'admin
                        Notification::make()
                            ->title('Mission clôturée')
                            ->body("La tâche \"{$record->title}\" est désormais marquée comme validée.")
                            ->success()
                            ->send();

                        // Notification aux membres assignés pour les informer de la fin de mission
                        $members = $record->members;
                        Notification::make()
                            ->title('Mission validée')
                            ->body("L'administration a validé définitivement la tâche : \"{$record->title}\".")
                            ->success()
                            ->sendToDatabase($members);

                        $client = $record->project->client;
                        if ($client) {
                            $client->notify(new DeliverableValidatedNotification($record));
                        }
                    }),
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // Possibilité de lancer plusieurs tâches d'un coup
                    BulkAction::make('launch_selected')
                        ->label('Lancer la sélection')
                        ->icon('heroicon-o-rocket-launch')
                        ->color('success')
                        ->action(function ($records) {
                            $launchedCount = 0;
                            $skippedCount = 0;

                            foreach ($records as $record) {
                                if ($record->members()->count() > 0 && !$record->is_launched) {
                                    $record->update(['is_launched' => true, 'status' => 'en_cours']);
                                    $launchedCount++;
                                } else {
                                    $skippedCount++;
                                }
                            }

                            Notification::make()
                                ->title('Traitement terminé')
                                ->body("$launchedCount tâches lancées. $skippedCount ignorées (pas d'assignés ou déjà lancées).")
                                ->info()
                                ->send();
                        })
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query, $livewire) {
                $projectId = $livewire->project ?? request()->query('project');
                if ($projectId) {
                    $query->where('project_id', $projectId);
                }
            });
    }
}
