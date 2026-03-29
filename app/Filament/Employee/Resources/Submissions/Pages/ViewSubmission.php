<?php

namespace App\Filament\Employee\Resources\Submissions\Pages;

use App\Filament\Employee\Resources\Submissions\SubmissionResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSubmission extends ViewRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('re_submit')
                ->label('Soumettre une nouvelle version (Correction)')
                ->icon('heroicon-m-arrow-path')
                ->color('warning')
                // Le bouton n'apparaît que si la version actuelle est rejetée
                ->visible(fn($record) => $record->status === 'rejected')
                ->action(function ($record) {
                    // On crée la V2 en base
                    $newSubmission = $record->replicate(['submitted_at', 'status', 'version']);
                    $newSubmission->parent_id = $record->id;
                    $newSubmission->status = 'draft'; // On repart en brouillon
                    $newSubmission->save();

                    // On redirige l'employé vers l'édition de cette nouvelle version
                    return redirect(SubmissionResource::getUrl('edit', ['record' => $newSubmission->id]));
                })
                ->requiresConfirmation()
                ->modalHeading('Préparer une correction')
                ->modalDescription(fn($record) => 'Ceci va créer une nouvelle version (V' . ($record->version + 1) . '). Vous devrez uploader vos fichiers corrigés.'),

        ];
    }
}
