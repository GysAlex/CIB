<?php

namespace App\Filament\Employee\Resources\Submissions\Pages;

use App\Filament\Employee\Resources\Submissions\SubmissionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSubmission extends EditRecord
{
    protected static string $resource = SubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }


    public function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['status'] === 'pending' && is_null($this->record->submitted_at)) {
            $data['submitted_at'] = now();
        }

        return $data;
    }
}
