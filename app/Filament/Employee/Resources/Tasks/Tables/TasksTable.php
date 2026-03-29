<?php

namespace App\Filament\Employee\Resources\Tasks\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('attachements')
                    ->label('Aperçu')
                    ->collection('attachements')
                    ->circular(),

                TextColumn::make('title')
                    ->label('Mission')
                    ->searchable()
                    ->description(fn($record) => Str::limit($record->description, 40)),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'en_cours' => 'warning',
                        'valide' => 'success',
                        'annule' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('deadline')
                    ->label('Échéance')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->color(fn($record) => $record->deadline?->isPast() ? 'danger' : 'gray')
                    ->weight(fn($record) => $record->deadline?->isPast() ? 'bold' : 'normal'),

                TextColumn::make('members_count')
                    ->label('Équipe')
                    ->counts('members')
                    ->suffix(' pers.'),
            ])
            ->filters([
                // Filtre par projet (optionnel en plus du paramètre URL)
                SelectFilter::make('project_id')
                    ->relationship('project', 'name')
                    ->label('Projet'),
            ])
            ->actions([
                // On ne laisse que l'action "Voir"
                ViewAction::make()
                    ->label('Consulter'),
            ])            ->modifyQueryUsing(function (Builder $query, $livewire) {
                $projectId = $livewire->project ?? request()->query('project');
                if ($projectId) {
                    $query->where('project_id', $projectId);
                }
            });
    }
}
