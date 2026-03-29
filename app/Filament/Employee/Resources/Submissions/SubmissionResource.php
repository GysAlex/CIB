<?php

namespace App\Filament\Employee\Resources\Submissions;

use App\Filament\Employee\Resources\Submissions\Pages\CreateSubmission;
use App\Filament\Employee\Resources\Submissions\Pages\EditSubmission;
use App\Filament\Employee\Resources\Submissions\Pages\ListSubmissions;
use App\Filament\Employee\Resources\Submissions\Pages\ViewSubmission;
use App\Filament\Employee\Resources\Submissions\Schemas\SubmissionForm;
use App\Filament\Employee\Resources\Submissions\Tables\SubmissionsTable;
use App\Filament\Infolists\Components\SpatieMediaDownloadEntry;
use App\Models\Submission;
use BackedEnum;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Livrables';

    public static function form(Schema $schema): Schema
    {
        return SubmissionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubmissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Dossier de soumission')
                    ->tabs([
                        // ONGLET 1 : DÉTAILS DE LA VERSION ACTUELLE
                        Tabs\Tab::make(fn($record) => 'Version Actuelle (V' . $record->version. ')')
                            ->icon('heroicon-m-document-text')
                            ->schema([
                                Grid::make(3) // Utilisation d'une grille pour équilibrer l'espace
                                    ->schema([
                                        // COLONNE GAUCHE : Contenu technique
                                        Section::make('Détails du rendu')
                                            ->schema([
                                                TextEntry::make('task.title')
                                                    ->label('Mission de référence')
                                                    ->weight('bold')
                                                    ->color('primary'),

                                                TextEntry::make('comment')
                                                    ->label('Note de l\'intervenant')
                                                    ->markdown()
                                                    ->prose(),
                                            ])->columnSpan(1),

                                        // COLONNE DROITE : Statut et Métadonnées
                                        Section::make('Statut & Délais')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('status')
                                                            ->label('État actuel')
                                                            ->badge()
                                                            ->color(fn(string $state): string => match ($state) {
                                                                'draft' => 'gray',
                                                                'pending' => 'warning',
                                                                'done' => 'success',
                                                                'rejected' => 'danger',
                                                                default => 'gray',
                                                            }),

                                                        // Indicateur de retard (Ajouté pour la cohérence avec l'admin)
                                                        TextEntry::make('delay_status')
                                                            ->label('Ponctualité')
                                                            ->getStateUsing(function ($record) {
                                                                if (!$record->task->due_at)
                                                                    return 'Pas d\'échéance';
                                                                return $record->submitted_at?->gt($record->task->due_at) ? 'En retard' : 'À temps';
                                                            })
                                                            ->badge()
                                                            ->color(fn($record) => $record->submitted_at?->gt($record->task->deadline) ? 'danger' : 'success'),

                                                        TextEntry::make('submitted_at')
                                                            ->label('Envoyé le')
                                                            ->dateTime('d/m/Y à H:i')
                                                            ->placeholder('Non encore soumis'),

                                                        TextEntry::make('user.name') // Correction: user au lieu de submitter
                                                            ->label('Auteur')
                                                            ->icon('heroicon-m-user'),
                                                    ])

                                            ])->columnSpan(2),
                                    ]),

                                // SECTION LIVRABLES (Documents & Images)
                                Grid::make(1)
                                    ->schema([
                                        Section::make('Aperçu rapide du rendu')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('rendu principal')
                                                    ->label(false)
                                                    ->placeholder('Aucun document')
                                                    ->collection('preview')
                                                    ->extraImgAttributes(['class' => 'rounded-lg shadow-sm mx-auto h-[300px]']),
                                            ])
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        Section::make('Livrables numériques')
                                            ->icon('heroicon-m-folder-arrow-down')
                                            ->schema([
                                                SpatieMediaDownloadEntry::make('documents')
                                                    ->label(false)
                                                    ->collection('documents')
                                                    // Message si pruné (après 30 jours)
                                                    ->hint(fn($record) => $record->status === 'rejected' && $record->updated_at->lt(now()->subDays(30)) ? 'Fichier archivé' : ''),
                                            ]),

                                        Section::make('Galerie visuelle')
                                            ->icon('heroicon-m-photo')
                                            ->schema([
                                                SpatieMediaLibraryImageEntry::make('attachements')
                                                    ->label(false)
                                                    ->placeholder('Aucun document')
                                                    ->collection('attachements')
                                                    ->extraImgAttributes(['class' => 'rounded-lg shadow-sm']),
                                            ]),
                                    ]),
                            ]),

                        // ONGLET 2 : HISTORIQUE DES VERSIONS (TRAÇABILITÉ)
                        Tabs\Tab::make('Historique (Itérations)')
                            ->icon('heroicon-m-clock')
                            ->schema([
                                RepeatableEntry::make('task.submissions')
                                    ->label(false)
                                    ->schema([
                                        Grid::make(4)
                                            ->schema([
                                                TextEntry::make('version')
                                                    ->label('Version')
                                                    ->prefix('V-')
                                                    ->weight('bold'),

                                                TextEntry::make('status')
                                                    ->badge()
                                                    ->label('État'),

                                                TextEntry::make('submitted_at')
                                                    ->label('Date d\'envoi')
                                                    ->dateTime('d/m/Y H:i'),

                                                TextEntry::make('feedback.score')
                                                    ->label('Note')
                                                    ->suffix('/5')
                                                    ->placeholder('—'),
                                            ]),

                                        TextEntry::make('feedback.comment')
                                            ->label('Feedback de l\'administration')
                                            ->prose()
                                            ->visible(fn($record) => $record->feedback()->exists()),
                                    ])
                                    ->getStateUsing(fn($record) => $record->task->submissions()->orderBy('version', 'desc')->get())
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubmissions::route('/'),
            'create' => CreateSubmission::route('/create'),
            'edit' => EditSubmission::route('/{record}/edit'),
            'view' => ViewSubmission::route('/{record}')
        ];
    }
}
