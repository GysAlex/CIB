<?php

namespace App\Filament\Resources\TaskRequests\Pages;

use App\Filament\Resources\TaskRequests\TaskRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskRequests extends ListRecords
{
    protected static string $resource = TaskRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
