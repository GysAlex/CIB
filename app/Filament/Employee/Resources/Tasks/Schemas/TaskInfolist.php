<?php

namespace App\Filament\Employee\Resources\Tasks\Schemas;

use App\Filament\Infolists\Components\SpatieMediaDownloadEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
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
                        Section::make('Informations Générales')
                            ->columnSpan(2)
                            ->schema([
                                Grid::make(3) // On crée une grille interne
                                    ->schema([
                                        // Colonne pour l'image de preview (si elle existe)
                                        SpatieMediaLibraryImageEntry::make('attachements')
                                            ->label('Documents associés')
                                            ->collection('attachements')
                                            ->hidden(fn($record) => !$record->hasMedia('attachements'))
                                            ->extraImgAttributes([
                                                'class' => 'rounded-xl shadow-sm w-full object-cover',
                                                'style' => 'height: 180px;',
                                            ]),

                                        // Colonne pour les textes (on ajuste le span selon la présence de l'image)
                                        Group::make([
                                            TextEntry::make('project.name')
                                                ->label('Projet')
                                                ->weight('bold')
                                                ->color('primary'),
                                            TextEntry::make('title')
                                                ->label('Intitulé de la mission')
                                                ->weight('medium'),
                                        ])->columnSpan(fn($record) => $record->hasMedia('attachements') ? 2 : 3),

                                        // La description prend toute la largeur sous l'entête
                                        TextEntry::make('description')
                                            ->label('Instructions détaillées')
                                            ->markdown()
                                            ->prose()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Section::make('Délais & Équipe')
                            ->columnSpan(1)
                            ->schema([
                                // Groupe Statut et Date
                                Group::make([
                                    TextEntry::make('status')
                                        ->badge()
                                        ->color(fn(string $state): string => match ($state) {
                                            'en_cours' => 'warning',
                                            'valide' => 'success',
                                            'annule' => 'danger',
                                            default => 'gray',
                                        }),

                                    TextEntry::make('deadline')
                                        ->label('Échéance')
                                        ->dateTime('d/m/Y')
                                        ->color('danger')
                                        ->weight('bold')
                                        ->icon('heroicon-o-calendar'),
                                ])->columns(2),

                                // Liste des collaborateurs affectés
                                RepeatableEntry::make('members')
                                    ->label('Équipe assignée')
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                TextEntry::make('name')
                                                    ->label('Nom')
                                                    ->icon('heroicon-m-user-circle')
                                                    ->weight('medium')
                                                    ->color('gray'),
                                            ]),
                                    ])
                                    ->grid(1)
                                    ->extraAttributes(['class' => 'mt-1']),
                            ]),

                        Section::make('Documents de travail')
                            ->description('Téléchargez ici les plans, devis ou documents sources.')
                            ->columnSpanFull()
                            ->schema([
                                SpatieMediaDownloadEntry::make('documents')
                                    ->label(false)
                                    ->collection('documents'), // La collection de la Task
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
