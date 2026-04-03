<?php

namespace App\Filament\Resources\TaskRequests\Schemas;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // SECTION 1 : CONTEXTE DU PROJET
                Section::make('Contexte de la demande')
                    ->icon('heroicon-m-information-circle')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('client.name')
                            ->label('Client émetteur')
                            ->weight('bold')
                            ->color('primary'),

                        TextEntry::make('project.name')
                            ->label('Projet concerné')
                            ->url(fn($record) => ProjectResource::getUrl('view', ['record' => $record->project_id])),

                        TextEntry::make('created_at')
                            ->label('Date de réception')
                            ->dateTime('d/m/Y H:i'),
                    ]),

                // SECTION 2 : CONTENU TECHNIQUE
                Grid::make(2)
                    ->schema([
                        Group::make([
                            Section::make('Détails de la tâche')
                                ->schema([
                                    TextEntry::make('title')
                                        ->label('Intitulé de la tâche'),

                                    TextEntry::make('taskTemplate.title')
                                        ->label('Template associé')
                                        ->placeholder('Aucun (Tâche personnalisée)')
                                        ->color('info'),

                                    TextEntry::make('priority')
                                        ->label('Niveau d\'urgence')
                                        ->badge()
                                        ->color(fn($state) => match ($state) {
                                            'low' => 'gray',
                                            'medium' => 'info',
                                            'high' => 'danger',
                                        }),
                                ]),
                        ]),

                        Group::make([
                            Section::make('Description / Justification')
                                ->schema([
                                    TextEntry::make('description')
                                        ->label(false)
                                        ->markdown()
                                        ->placeholder('Aucune description fournie par le client.'),
                                ]),
                        ]),
                    ]),

                // SECTION 3 : ÉTAT ET COMMENTAIRES
                Section::make('Traitement Administratif')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('status')
                            ->label('Statut actuel')
                            ->badge()
                            ->color(fn($state) => match ($state) {
                                'en_attente' => 'warning',
                                'approuve' => 'success',
                                'rejete' => 'danger',
                            }),

                        TextEntry::make('admin_comment')
                            ->label('Note ou motif de décision')
                            ->prose()
                            ->placeholder('En attente de traitement par un administrateur...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
