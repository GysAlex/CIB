<?php

namespace App\Filament\Client\Resources\TaskRequests\Pages;

use App\Filament\Client\Resources\TaskRequests\TaskRequestResource;
use App\Models\TaskRequest;
use App\Models\TaskTemplate;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends CreateRecord
{
    protected static string $resource = TaskRequestResource::class;



    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        $data = $this->data;
        $projectId = $data['project_id'];

        $selectedTemplateIds = collect($data)
            ->filter(fn($v, $k) => str_starts_with($k, 'temp_tasks_'))
            ->flatten()
            ->toArray();

        foreach ($selectedTemplateIds as $templateId) {
            $template = TaskTemplate::find($templateId);
            TaskRequest::create([
                'project_id' => $projectId,
                'client_id' => auth()->id(),
                'task_template_id' => $template->id,
                'title' => $template->title,
                'description' => $template->description,
                'priority' => $template->default_priority,
                'status' => 'en_attente',
            ]);
        }

        if (!empty($data['custom_tasks'])) {
            foreach ($data['custom_tasks'] as $customTask) {
                TaskRequest::create([
                    'project_id' => $projectId,
                    'client_id' => auth()->id(),
                    'task_template_id' => null,
                    'title' => $customTask['title'],
                    'description' => $customTask['description'],
                    'priority' => $customTask['priority'],
                    'status' => 'en_attente',
                ]);
            }
        }

        // Nettoyage de la "coquille"
        $this->record->delete();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
