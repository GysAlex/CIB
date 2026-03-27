<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Filament\Infolists\Components\TaskProgressBar;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Colonne gauche
                Section::make('Détails de la tâche')
                    ->schema([
                        TextEntry::make('title')
                            ->label('Intitulé')
                            ->weight(FontWeight::Bold),
                        TaskProgressBar::make('progression'),
                        RepeatableEntry::make('checklist')
                            ->label('Livrables attendus')
                            ->placeholder('Aucun point de contrôle défini')
                            ->schema([
                                TextEntry::make('item')
                                ->label('Objectifs')
                                ->bulleted()
                            ]),
                    ]),

                // Colonne droite
                Section::make('Statut & Priorité')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Statut actuel')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'a_faire' => 'gray',
                                'en_cours' => 'warning',
                                'en_attente_validation' => 'info',
                                'valide' => 'success',
                            }),
                        TextEntry::make('priority')
                            ->label('Urgence')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'basse' => 'gray',
                                'normale' => 'info',
                                'haute' => 'warning',
                                'critique' => 'danger',
                            }),
                        TextEntry::make('employees.name')
                            ->label('Employés assignés')
                            ->badge() // Crée une bulle individuelle pour chaque employé
                            ->color('gray')
                            ->placeholder('Aucun intervenant'),
                    ])

            ]);
    }
}
