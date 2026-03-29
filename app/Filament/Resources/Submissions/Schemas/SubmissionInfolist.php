<?php

namespace App\Filament\Resources\Submissions\Schemas;

use App\Filament\Infolists\Components\SpatieMediaDownloadEntry;
use App\Filament\Infolists\Components\TaskProgressBar;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubmissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([

                        // COLONNE Gauche : Le rendu de l'employé (Submission)
                        Section::make('Le Rendu de l\'Employé')
                            ->icon('heroicon-m-arrow-up-tray')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('user.name')
                                            ->label('Auteur du rendu')
                                            ->icon('heroicon-m-user'),

                                        // Indicateur de ponctualité
                                        TextEntry::make('delay_status')
                                            ->label('Respect des délais')
                                            ->getStateUsing(function ($record) {
                                                if (!$record->task->deadline)
                                                    return 'Échéance non définie';

                                                $isLate = $record->submitted_at->gt($record->task->deadline);
                                                $diff = $record->submitted_at->diffForHumans($record->task->deadline, true);

                                                return $isLate ? "Retard de {$diff}" : "Remis à temps";
                                            })
                                            ->badge()
                                            ->color(fn($record) => $record->submitted_at->gt($record->task->deadline) ? 'danger' : 'success')
                                            ->icon(fn($record) => $record->submitted_at->gt($record->task->deadline) ? 'heroicon-m-clock' : 'heroicon-m-check-circle'),

                                        TextEntry::make('submitted_at')
                                            ->label('Date de remise')
                                            ->dateTime('d/m/Y H:i')
                                            ->columnSpanFull(),
                                    ]),

                                TextEntry::make('comment')
                                    ->label('Note d\'accompagnement')
                                    ->markdown()
                                    ->placeholder('L\'employé n\'a pas laissé de commentaire.'),

                                SpatieMediaLibraryImageEntry::make('preview')
                                    ->label('Aperçu du travail')
                                    ->collection('preview'),

                                SpatieMediaDownloadEntry::make('documents')
                                    ->label('Livrables techniques')
                                    ->collection('documents'),

                                SpatieMediaLibraryImageEntry::make('attachements')
                                    ->label('Galerie visuelle du rendu')
                                    ->collection('attachements')
                                    ->placeholder('Aucun aperçu visuel')
                            ])->columnSpan(1),


                        // COLONNE Droite : Rappel de la demande (Task)
                        Section::make('La Demande Initiale')
                            ->icon('heroicon-m-clipboard-document-list')
                            ->schema([
                                TextEntry::make('task.title')
                                    ->label('Intitulé de la mission')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('task.description')
                                    ->label('Instructions fournies')
                                    ->markdown()
                                    ->prose(),

                                // Documents sources que l'admin avait joint à la tâche
                                SpatieMediaDownloadEntry::make('task_documents')
                                    ->label('Documents sources (Instructions/Plans)')
                                    ->collection('documents')
                                    ->relation('task'),
                                TaskProgressBar::make('Timing de la tâche')
                            ])->columnSpan(1),

                    ])->columnSpanFull(),

                // SECTION INFÉRIEURE : Affichage du Feedback (si déjà évalué)
                Section::make('Résultat de l\'Évaluation')
                    ->icon('heroicon-m-star')
                    ->visible(fn($record) => $record->feedback()->exists())
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('feedback.decision')
                                    ->label('Décision finale')
                                    ->badge()
                                    ->color(fn($state) => $state === 'approved' ? 'success' : 'danger')
                                    ->formatStateUsing(fn($state) => $state === 'approved' ? 'Validé' : 'Rejeté'),

                                TextEntry::make('feedback.score')
                                    ->label('Note de qualité')
                                    ->suffix('/5')
                                    ->weight('bold')
                                    ->color('warning'),

                                TextEntry::make('feedback.reviewed_at')
                                    ->label('Évalué le')
                                    ->dateTime('d/m/Y H:i'),
                            ]),

                        TextEntry::make('feedback.comment')
                            ->label('Commentaires de l\'examinateur')
                            ->prose(),
                    ])->columnSpanFull()
            ]);
    }
}
