<?php

namespace App\Filament\Employee\Resources\Tasks\Pages;

use App\Filament\Employee\Resources\Tasks\TaskResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTask extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('create_submission')
                ->label('Déposer mon rendu')
                ->icon('heroicon-m-arrow-up-tray')
                ->url(fn($record) => route('filament.employee.resources.submissions.create', ['task_id' => $record->id]))
        ];
    }
}
