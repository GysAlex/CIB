<?php

namespace App\Filament\Resources\TaskRequests\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détails de la demande')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('client.name')
                            ->label('Client')
                            ->placeholder('nom du client'),

                        TextEntry::make('project.name')
                            ->label('Projet')
                            ->placeholder('Nom du projet'),

                        TextInput::make('title')
                            ->label('Objet')
                            ->disabled(), // On ne change pas ce que le client a écrit

                        Select::make('priority')
                            ->options(['low' => 'Basse', 'medium' => 'Normale', 'high' => 'Haute'])
                            ->disabled(),
                    ]),

                Section::make('Réponse à apporter')
                    ->schema([
                        Textarea::make('admin_comment')
                            ->label('Commentaire / Justification')
                            ->placeholder('Expliquez ici pourquoi vous acceptez ou refusez la demande...')
                            ->rows(3),

                        Select::make('status')
                            ->label('Décision')
                            ->options([
                                'en_attente' => 'En attente',
                                'approuve' => 'Approuver',
                                'rejete' => 'Rejeter',
                            ])
                            ->required()
                            ->native(false),
                    ]),
            ]);
    }
}
