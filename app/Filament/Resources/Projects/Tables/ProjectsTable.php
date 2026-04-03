<?php

namespace App\Filament\Resources\Projects\Tables;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProjectsTable
{

    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading("Aucun projet pour le moment")
            ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateDescription('Veillez créer un nouveau projet pour commencer')
            ->emptyStateActions([
                Action::make('create')
                    ->label('Créer un projet')
                    ->url(route('filament.admin.resources.projects.create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Aperçu')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nom du Projet')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client.name')
                    ->label('Nom du client')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'etude' => 'gray',
                        'en_cours' => 'warning',
                        'termine' => 'success',
                        'suspendu' => 'danger',
                    }),

                TextColumn::make('location')
                    ->label('Lieu')
                    ->icon('heroicon-m-map-pin'),

                TextColumn::make('tasks_count')
                    ->label('Tâches')
                    ->counts('tasks') // Utilise la relation hasMany
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'etude' => 'Étude',
                        'en_cours' => 'En cours',
                        'termine' => 'Terminé',
                    ]),
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
