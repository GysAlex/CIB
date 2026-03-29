<?php

namespace App\Filament\Resources\Submissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Aperçu du rendu (si c'est une image/plan)
                SpatieMediaLibraryImageColumn::make('preview')
                    ->label('Aperçu')
                    ->collection('preview')
                    ->circular(),

                // Qui a soumis ?
                TextColumn::make('user.name')
                    ->label('Employé')
                    ->sortable()
                    ->searchable(),

                // Pour quelle mission ?
                TextColumn::make('task.title')
                    ->label('Mission / Projet')
                    ->description(fn($record) => $record->task->project->name)
                    ->searchable(),

                // Statut avec badges
                TextColumn::make('status')
                    ->label('État')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'done' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'pending' => 'À réviser',
                        'done' => 'Validé',
                        'rejected' => 'Rejeté',
                        default => $state,
                    }),

                // Date de soumission
                TextColumn::make('submitted_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                // Score (issu de la relation feedback)
                TextColumn::make('feedback.score')
                    ->label('Note')
                    ->state(fn($record) => $record->feedback?->score ? $record->feedback->score . '/5' : '—')
                    ->badge()
                    ->color('info'),
            ])
            ->defaultSort('submitted_at', 'desc')

            ->filters([
                SelectFilter::make('task_id')
                    ->relationship('task', 'title')
                    ->label('Filtrer par tâche'),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Examiner le dossier')
                    ->icon('heroicon-m-eye')
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function(Builder $query){
                return $query->where('status', '!=',  'draft' );
            });
    }
}
