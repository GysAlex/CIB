<?php

namespace App\Filament\Client\Resources\TaskRequests\Schemas;

use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Récapitulatif de la demande')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('project.name')->label('Projet'),
                                TextEntry::make('title')->label('Tâche demandée'),
                                TextEntry::make('status')
                                    ->label('Statut actuel')
                                    ->badge()
                                    ->color(fn($state) => match ($state) {
                                        'en_attente' => 'warning',
                                        'approuve' => 'success',
                                        'rejete' => 'danger',
                                    }),
                            ]),
                        TextEntry::make('description')
                            ->label('Vos précisions')
                            ->markdown(),
                    ]),

                // SECTION COMMENTAIRE ADMIN : Visible uniquement si remplie
                Section::make('Réponse de l\'administration')
                    ->icon('heroicon-m-chat-bubble-bottom-center-text')
                    ->visible(fn($record) => filled($record->admin_comment))
                    ->schema([
                        TextEntry::make('admin_comment')
                            ->label(false)
                            ->prose()
                            ->color('info')
                            ->weight('medium')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->persistCollapsed(false)
                    ->headerActions([
                        // Petit indicateur visuel si c'est un refus
                        fn($record) => $record->status === 'rejete'
                        ? Action::make('status_info')
                            ->label('Action requise')
                            ->color('danger')
                            ->icon('heroicon-m-exclamation-triangle')
                        : null,
                    ]),
            ]);
    }
}
