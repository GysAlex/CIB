<?php
namespace App\Filament\Client\Resources\Projects\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('État d\'avancement du Projet')
                    ->description('Suivi en temps réel de vos investissements')
                    ->schema([
                        // Barre de progression visuelle (Custom Entry ou Text avec Badge)
                        TextEntry::make('completion_percentage')
                            ->label('Progression Globale')
                            ->suffix('%')
                            ->weight('bold')
                            ->color(fn($state) => $state >= 100 ? 'success' : 'primary'),

                        TextEntry::make('status')
                            ->label('Statut Contractuel')
                            ->badge(),
                    ])->columns(2),

                Tabs::make('Détails')
                    ->tabs([
                        Tabs\Tab::make('Informations Générales')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextEntry::make('name')->label('Nom du projet'),
                                TextEntry::make('location')->label('Site / Localisation'),
                                TextEntry::make('description')->markdown(),
                            ]),

                        Tabs\Tab::make('Missions & Tâches')
                            ->icon('heroicon-m-clipboard-document-check')
                            ->schema([
                                // On affiche la liste des tâches liées
                                RepeatableEntry::make('tasks')
                                    ->label(false)
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('title')->label('Mission'),
                                                TextEntry::make('status')
                                                    ->badge()
                                                    ->color(fn($state) => $state === 'valide' ? 'success' : 'gray'),
                                                TextEntry::make('deadline')
                                                    ->label('Échéance prévue')
                                                    ->date(),
                                            ])
                                    ])
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

}