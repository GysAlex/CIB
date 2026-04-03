<?php

namespace App\Filament\Resources\TaskRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TaskRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('project.name')
                    ->label('Projet')
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('title')
                    ->label('Tâche demandée')
                    ->limit(40),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'en_attente' => 'warning',
                        'approuve' => 'success',
                        'rejete' => 'danger',
                    }),

                TextColumn::make('created_at')
                    ->label('Reçue le')
                    ->dateTime('d/m/Y H:i')
                    ->since(), // Affiche "il y a 2 heures"
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'en_attente' => 'À traiter',
                        'approuve' => 'Approuvées',
                        'rejete' => 'Rejetées',
                    ])
                    ->default('en_attente'), // L'admin voit d'abord ce qu'il doit faire

                SelectFilter::make('project_id')
                    ->relationship('project', 'name')
                    ->label('Filtrer par projet'),
            ])
            ->actions([
                // Action d'approbation (Logique Option B que nous avons validée)
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
                    ->visible(fn($record) => $record->status === 'en_attente'),

                EditAction::make()->label('Répondre / Modifier'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
