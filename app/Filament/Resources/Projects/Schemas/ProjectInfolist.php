<?php
namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ── Bloc supérieur : image + infos principales ──────────────
                Grid::make([])
                    ->schema([
                        Section::make()
                            ->schema([
                                ImageEntry::make('image_path')
                                    ->label('Image')
                                    ->height(280)
                                    ->width('100%')
                                    ->extraImgAttributes([
                                        'class' => 'object-cover rounded-lg w-full',
                                    ])
                                    ->placeholder('Aucune image disponible'),
                            ])
                            ->grow(false)
                            ->columnSpan(1),

                        // Infos principales
                        Section::make('Informations générales')
                            ->icon('heroicon-o-building-office-2')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nom du projet')
                                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                                    ->columnSpanFull(),

                                TextEntry::make('status')
                                    ->label('Statut')
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'en_cours' => 'warning',
                                        'termine' => 'success',
                                        'suspendu' => 'danger',
                                        'planifie' => 'info',
                                        default => 'gray',
                                    }),

                                TextEntry::make('location')
                                    ->label('Localisation')
                                    ->icon('heroicon-o-map-pin')
                                    ->placeholder('Non renseignée'),

                                TextEntry::make('description')
                                    ->label('Description')
                                    ->placeholder('Aucune description disponible')
                                    ->columnSpanFull()
                                    ->prose(),
                            ])
                            ->columns(2)
                            ->grow(),

                    ]),

                // ── Dates ────────────────────────────────────────────────────
                Section::make('Calendrier')
                    ->icon('heroicon-o-calendar-days')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Début')
                            ->date('d/m/Y')
                            ->icon('heroicon-o-play')
                            ->placeholder('Non définie')
                            ->color('success'),

                        TextEntry::make('end_date')
                            ->label('Fin prévue')
                            ->date('d/m/Y')
                            ->icon('heroicon-o-flag')
                            ->placeholder('Non définie')
                            ->color('danger'),

                        TextEntry::make('created_at')
                            ->label('Créé le')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-plus-circle')
                            ->color('gray'),

                        TextEntry::make('updated_at')
                            ->label('Dernière modification')
                            ->dateTime('d/m/Y à H:i')
                            ->icon('heroicon-o-pencil-square')
                            ->since()  // affiche "il y a 3 jours"
                            ->color('gray'),
                    ]),
            ]);

        // Image du projet


    }
}