<?php

namespace App\Filament\Client\Resources\TaskRequests\Pages;

use App\Filament\Client\Resources\TaskRequests\TaskRequestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTaskRequest extends ViewRecord
{
    protected static string $resource = TaskRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
