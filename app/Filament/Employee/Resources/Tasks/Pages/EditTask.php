<?php

namespace App\Filament\Employee\Resources\Tasks\Pages;

use App\Filament\Employee\Resources\Tasks\TaskResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ViewAction::make(),
            DeleteAction::make()
        ];
    }


}
