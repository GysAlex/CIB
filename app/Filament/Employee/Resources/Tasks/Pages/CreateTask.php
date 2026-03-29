<?php

namespace App\Filament\Employee\Resources\Tasks\Pages;

use App\Filament\Employee\Resources\Tasks\TaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTask extends CreateRecord
{
    protected static string $resource = TaskResource::class;
}
