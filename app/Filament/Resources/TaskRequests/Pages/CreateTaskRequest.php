<?php

namespace App\Filament\Resources\TaskRequests\Pages;

use App\Filament\Resources\TaskRequests\TaskRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskRequest extends CreateRecord
{
    protected static string $resource = TaskRequestResource::class;
}
