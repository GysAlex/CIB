<?php

namespace App\Filament\Employee\Resources\Submissions\Pages;

use App\Filament\Employee\Resources\Submissions\SubmissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubmission extends CreateRecord
{
    protected static string $resource = SubmissionResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if ($data['status'] === 'pending') {
            $data['submitted_at'] = now();
        }

        return $data;
    }

    protected function afterFill()
    {
        
    }
}
