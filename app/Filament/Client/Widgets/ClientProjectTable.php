<?php

namespace App\Filament\Client\Widgets;

use App\Filament\Client\Pages\ProjectBilan;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;


use Filament\Tables\Table;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ClientProjectTable extends Widget implements HasTable, HasSchemas, HasActions
{
    use InteractsWithTable;
    use InteractsWithSchemas;
    use InteractsWithActions;

    protected static ?int $sort = 2;

    protected string $view = 'filament.client.widgets.client-project-table';
    protected static ?string $heading = 'Mes Projets & Chantiers';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn() => Project::where('client_id', Auth::id()))
            ->columns([
                TextColumn::make('name')
                    ->label('Projet')
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('location')
                    ->label('Site / Localisation'),
                TextColumn::make('completion_percentage')
                    ->label('Avancement')
                    ->badge()
                    ->suffix('%')
                    ->color(fn ($state) => $state >= 100 ? 'success' : 'primary'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge(),
            ])
            ->actions([
                Action::make('view_bilan')
                    ->label('Consulter le Bilan (GED)')
                    ->icon('heroicon-m-folder-open')
                    ->color('info')
                    ->url(fn (Project $record): string => 
                        ProjectBilan::getUrl(['activeProjectId' => $record->id])
                    ),
            ]);
    }
}
