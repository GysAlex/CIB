<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                // Relation avec le Projet (avec son image en miniature)
                TextColumn::make('project.name')
                    ->label('Projet')
                    ->description(fn($record) => $record->project->location) // Affiche le lieu sous le nom
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold)
                    ->color('primary'),

                TextColumn::make('title')
                    ->label('Intitulé de la tâche')
                    ->searchable()
                    ->limit(30), // Coupe le texte s'il est trop long

                TextColumn::make('employees.name')
                    ->label('Assigné à')
                    ->badge()
                    ->separator(',') // Si plusieurs employés
                    ->color('gray')
                    ->listWithLineBreaks(true),
                TextColumn::make('priority')
                    ->label('Priorité')
                    ->badge()
                    ->sortable()
                    ->color(fn(string $state): string => match ($state) {
                        'basse' => 'gray',
                        'normale' => 'info',
                        'haute' => 'warning',
                        'critique' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),

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

                TextColumn::make('deadline')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable()
                    ->icon('heroicon-o-calendar')
                    ->color(fn($record) => $record->deadline->isPast() ? 'danger' : 'gray'), // Rouge si en retard

                TextColumn::make('creator.name')
                    ->label('Créé par')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('project')
                    ->relationship('project', 'name')
                    ->label('Filtrer par projet'),

                SelectFilter::make('priority')
                    ->options([
                        'basse' => 'Basse',
                        'normale' => 'Normale',
                        'haute' => 'Haute',
                        'critique' => 'Critique',
                    ])
                    ->label('Priorité'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ])

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(
                function (Builder $query, $livewire) {
                    $projectId = $livewire->project ?? request()->query('project');

                    if ($projectId) {
                        $query->where('project_id', $projectId);
                    }
                }

            )
        ;
    }
}
