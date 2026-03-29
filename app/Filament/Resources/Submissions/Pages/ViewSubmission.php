<?php

namespace App\Filament\Resources\Submissions\Pages;

use App\Filament\Resources\Submissions\SubmissionResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Grid;

class ViewSubmission extends ViewRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('evaluate')
                ->label('Évaluer ce rendu')
                ->icon('heroicon-m-check-badge')
                ->color('primary')
                ->modalWidth('lg')
                // Visible seulement si le dossier est en attente ou a déjà été rejeté (pour une nouvelle chance)
                ->visible(fn($record) => in_array($record->status, ['pending', 'rejected']))
                ->form([
                    Grid::make(1)
                        ->schema([
                            ToggleButtons::make('decision')
                                ->label('Décision')
                                ->options([
                                    'approved' => 'Approuver le travail',
                                    'rejected' => 'Demander des corrections',
                                ])
                                ->icons([
                                    'approved' => 'heroicon-o-check',
                                    'rejected' => 'heroicon-o-x-circle',
                                ])
                                ->colors([
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                ])
                                ->required()
                                ->inline()
                                ->live()
                                ->columnSpanFull(),
                            ToggleButtons::make('score')
                                ->label('Qualité du rendu')
                                ->options([
                                    1 => '1/5',
                                    2 => '2/2',
                                    3 => '3/5',
                                    4 => '4/5',
                                    5 => '5/5',
                                ])
                                ->icons([
                                    1 => 'heroicon-o-face-frown',
                                    2 => 'heroicon-o-hand-thumb-down',
                                    3 => 'heroicon-o-hand-raised',
                                    4 => 'heroicon-o-hand-thumb-up',
                                    5 => 'heroicon-o-star',
                                ])
                                ->colors([
                                    1 => 'danger',
                                    2 => 'warning',
                                    3 => 'info',
                                    4 => 'primary',
                                    5 => 'success',
                                ])
                                ->inline() // Pour les aligner horizontalement
                                ->required()
                                ->visible(fn($get) => $get('decision') === 'approved'),

                            Textarea::make('comment')
                                ->label('Observations techniques')
                                ->placeholder('Détaillez les points à améliorer ou validez la conformité...')
                                ->required()
                                ,
                        ]),
                ])
                ->action(function ($record, array $data) {
                    $record->feedback()->updateOrCreate(
                        ['submission_id' => $record->id],
                        [
                            'admin_id' => auth()->id(),
                            'decision' => $data['decision'],
                            'score' => $data['score'] ?? null,
                            'comment' => $data['comment'],
                            'reviewed_at' => now(),
                        ]
                    );

                    $newStatus = ($data['decision'] === 'approved') ? 'done' : 'rejected';
                    $record->update(['status' => $newStatus]);

                    // 3. Notification de succès pour l'admin
                    Notification::make()
                        ->title($newStatus === 'done' ? 'Rendu validé' : 'Correction demandée')
                        ->success()
                        ->send();
                })
        ];
    }
}
