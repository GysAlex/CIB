<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Filament\Infolists\Components\SpatieMediaDownloadEntry;
use App\Filament\Infolists\Components\TaskProgressBar;
use Filament\Actions\Action;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        Section::make('Détails de la mission')
                            ->columnSpan(2)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Intitulé')
                                    ->weight('bold')
                                    ->size('lg'),
                                TextEntry::make('description')
                                    ->markdown()
                                    ->placeholder('Aucune description fournie.'),

                                Grid::make(2)->schema([
                                    TextEntry::make('project.name')
                                        ->label('Projet')
                                        ->color('primary')
                                        ->icon('heroicon-m-building-office'),
                                    TextEntry::make('deadline')
                                        ->label('Échéance')
                                        ->date('d/m/Y')
                                        ->color(fn($record) => $record->deadline?->isPast() ? 'danger' : 'gray'),
                                ]),
                                TaskProgressBar::make('Progression'),
                                RepeatableEntry::make('objectives')
                                    ->label('Checklist technique')
                                    ->schema([
                                        TextEntry::make('item')->label('Objectif'),
                                    ])->columns(1),
                            ]),

                        Section::make('Statut & Lancement')
                            ->columnSpan(1)
                            ->schema([
                                IconEntry::make('is_launched')
                                    ->label('Ordre de mission envoyé')
                                    ->boolean(),
                                TextEntry::make('status')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'a_faire' => 'gray',
                                        'en_cours' => 'warning',
                                        'valide' => 'success',
                                        default => 'info',
                                    }),
                                TextEntry::make('priority')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'low' => 'gray',
                                        'high' => 'danger',
                                        default => 'info',
                                    }),
                                TextEntry::make('expected_deliverable')
                                    ->label('Livrable attendu')
                                    ->icon('heroicon-m-archive-box'),
                            ]),

                        // Section Basse : Documents et Médias
                        Section::make('Documentation technique')
                            ->columnSpanFull()
                            ->schema([
                                Grid::make(2)->schema([
                                    SpatieMediaLibraryImageEntry::make('attachements')
                                        ->label('Photos de terrain')
                                        ->collection('attachements')
                                        ->circular(),

                                    SpatieMediaDownloadEntry::make('documents')
                                        ->label('Plans techniques et documents')
                                        ->collection('documents') // On précise la collection Spatie

                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
