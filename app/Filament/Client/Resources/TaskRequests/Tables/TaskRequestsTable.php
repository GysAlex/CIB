<?php

namespace App\Filament\Client\Resources\TaskRequests\Tables;

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
                TextColumn::make('project.name')
                    ->label('Projet')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('title')
                    ->label('Objet de la demande')
                    ->description(fn($record) => str($record->description)->limit(50)),

                TextColumn::make('priority')
                    ->label('Urgence')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'low' => 'gray',
                        'medium' => 'info',
                        'high' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'low' => 'Basse',
                        'medium' => 'Normale',
                        'high' => 'Haute',
                    }),

                TextColumn::make('status')
                    ->label('État')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'en_attente' => 'warning',
                        'approuve' => 'success',
                        'rejete' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'en_attente' => 'En attente',
                        'approuve' => 'Validée',
                        'rejete' => 'Refusée',
                    }),

                TextColumn::make('created_at')
                    ->label('Envoyée le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'en_attente' => 'En attente',
                        'approuve' => 'Validée',
                        'rejete' => 'Refusée',
                    ]),
            ])
            ->actions([
                ViewAction::make()->label('Détails'),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
