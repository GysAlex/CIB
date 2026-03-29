<?php

namespace App\Filament\Employee\Resources\Submissions\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        // Colonne principale (Gauche)
                        Section::make('Rapport d\'avancement')
                            ->description('Détaillez le travail effectué sur cette tâche.')
                            ->columnSpan(2)
                            ->schema([
                                Select::make('task_id')
                                    ->label('Sélectionner la tâche')
                                    ->relationship('task', 'title', fn($query) => $query->where('is_launched', true)) // Uniquement les tâches lancées
                                    ->searchable()
                                    ->default(fn () => request()->query('task_id'))
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->disabledOn('edit'),

                                Textarea::make('comment')
                                    ->label('Commentaire technique')
                                    ->placeholder('Décrivez les travaux réalisés, les matériaux utilisés ou les difficultés rencontrées...')
                                    ->rows(6)
                                    ->required(),
                            ]),

                        // Colonne latérale (Droite)
                        Section::make('Statut de l\'envoi')
                            ->columnSpan(1)
                            ->schema([
                                Placeholder::make('info')
                                    ->label('Note')
                                    ->content('Passez en "Prêt pour validation" pour que l\'admin puisse réviser votre travail.'),

                                ToggleButtons::make('status')
                                    ->label('Action')
                                    ->options([
                                        'draft' => 'Brouillon',
                                        'pending' => 'Envoyer pour validation',
                                    ])
                                    ->colors([
                                        'draft' => 'gray',
                                        'pending' => 'success',
                                    ])
                                    ->icons([
                                        'draft' => 'heroicon-o-pencil-square',
                                        'pending' => 'heroicon-o-paper-airplane',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->inline(),
                            ]),

                        // Section Médias (Bas)
                        Section::make('Preuves du chantier')
                            ->description('Joignez les photos et documents justificatifs.')
                            ->columnSpanFull()
                            ->schema([
                                Grid::make(3)->schema([
                                    // Image de Preview (Couverture)
                                    SpatieMediaLibraryFileUpload::make('preview')
                                        ->label('Photo principale (Preview)')
                                        ->collection('preview')
                                        ->image()
                                        ->imageEditor()
                                        ->directory('submissions/previews')
                                        ->required()
                                        ->columnSpan(1),

                                    // Photos de détails
                                    SpatieMediaLibraryFileUpload::make('attachements')
                                        ->label('Photos de détails / Galerie')
                                        ->collection('attachements')
                                        ->multiple()
                                        ->image()
                                        ->reorderable()
                                        ->directory('submissions/attachments')
                                        ->columnSpan(1),

                                    // Documents Techniques
                                    SpatieMediaLibraryFileUpload::make('documents')
                                        ->label('Documents (PDF, PV, Rapports)')
                                        ->collection('documents')
                                        ->multiple()
                                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                        ->directory('submissions/documents')
                                        ->columnSpan(1),
                                ]),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
