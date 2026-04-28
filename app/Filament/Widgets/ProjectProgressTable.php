<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ProjectProgressTable extends TableWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Project::query()->where('status', '!=', 'termine')->latest())
            ->heading('Avancement des projets')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom du Projet')
                    ->searchable(),
                TextColumn::make('client.name')
                    ->label('Client'),

                // Utilisation de ton attribut de pourcentage
                TextColumn::make('completion_percentage')
                    ->label('Progression')
                    ->suffix('%')
                    ->badge()
                    ->color(fn($state) => match (true) {
                        $state >= 80 => 'success',
                        $state >= 40 => 'warning',
                        default => 'danger',
                    }),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),

                TextColumn::make('end_date')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

}
