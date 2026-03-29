<?php

namespace App\Filament\Employee\Resources\Submissions\Tables;

use App\Models\Submission;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Aperçu visuel (Plan, Rendu ou Photo)
                SpatieMediaLibraryImageColumn::make('preview')
                    ->label('Aperçu')
                    ->collection('preview')
                    ->square()
                    ->conversion('thumb'),

                TextColumn::make('task.title')
                    ->label('Mission / Tâche')
                    ->description(fn($record) => $record->task->project->name)
                    ->searchable()
                    ->sortable(),

                // Statut de la soumission
                TextColumn::make('status')
                    ->label('État du dossier')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'pending' => 'warning',
                        'done' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'pending' => 'En attente de revue',
                        'done' => 'Approuvé',
                        'rejected' => 'À corriger',
                        default => $state,
                    }),

                // Indicateur de contenu (Documents ou Images)
                IconColumn::make('has_files')
                    ->label('Livrables')
                    ->getStateUsing(fn($record) => $record->hasMedia('documents') || $record->hasMedia('attachements'))
                    ->boolean()
                    ->trueIcon('heroicon-o-document-check')
                    ->falseIcon('heroicon-o-document-minus')
                    ->tooltip('Contient des fichiers ou des rendus'),

                TextColumn::make('submitted_at')
                    ->label('Date d\'envoi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Non envoyé'),

                // Résultat de l'examen (si rejeté)
                TextColumn::make('feedback.decision')
                    ->label('Note de révision')
                    ->placeholder('En attente...')
                    ->formatStateUsing(fn($state, $record) => $state === 'rejected' ? '❌ ' . Str::limit($record->feedback->comment, 20) : '—')
                    ->color('danger'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filtrer par état')
                    ->options([
                        'draft' => 'Brouillons',
                        'pending' => 'En attente',
                        'done' => 'Validés',
                        'rejected' => 'À corriger',
                    ]),
            ])
            ->recordAction(
                fn(Submission $record): string =>
                match ($record->status) {
                    'draft', 'rejected' => 'edit', // On édite pour corriger ou soumettre
                    default => 'view',             // On consulte uniquement si c'est validé ou en attente
                }
            )
            ->actions([
                Action::make('submit_now')
                    ->label('Soumettre')
                    ->icon('heroicon-m-paper-airplane')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn(Submission $record): bool => in_array($record->status, ['draft']))
                    ->action(function (Submission $record) {
                        $record->update([
                            'status' => 'pending',
                            'submitted_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Dossier soumis avec succès')
                            ->success()
                            ->send();
                    }),

                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn($record) => $record->status === 'draft' || $record->status === 'rejected'),
                    DeleteAction::make()
                        ->visible(fn($record) => $record->status === 'draft'),
                ]),

            ])
            ->defaultSort('created_at', 'desc');
    }
}
