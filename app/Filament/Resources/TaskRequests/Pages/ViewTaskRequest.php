<?php

namespace App\Filament\Resources\TaskRequests\Pages;

use App\Filament\Resources\TaskRequests\TaskRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskRequest extends ViewRecord
{
    protected static string $resource = TaskRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
            ->label('Valider / Rejeter'),
        ];
    }
    
    protected static ?string $title = "Détails de la demande";
}
