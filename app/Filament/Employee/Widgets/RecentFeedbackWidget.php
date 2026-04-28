<?php

namespace App\Filament\Employee\Widgets;

use App\Models\SubmissionFeedback;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentFeedbackWidget extends TableWidget
{

    protected static ?string $heading = 'Derniers retours de la direction';
    protected int | string | array $columnSpan = 'full';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                SubmissionFeedback::query()
                    ->whereHas('submission', fn($q) => $q->where('user_id', auth()->id()))
                    ->latest('reviewed_at')
            )
            ->columns([
                TextColumn::make('submission.task.title')
                    ->label('Tâche concernée')
                    ->limit(30),
                
                TextColumn::make('decision')
                    ->label('Décision')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'needs_changes' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('score')
                    ->label('Note')
                    ->suffix('/5')
                    ->weight('bold'),

                TextColumn::make('comment')
                    ->label('Commentaire Admin')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->comment),

                TextColumn::make('reviewed_at')
                    ->label('Date de revue')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
