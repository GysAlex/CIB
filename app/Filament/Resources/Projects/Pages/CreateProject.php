<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\TaskTemplate;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


    protected function afterCreate(): void
    {
        $project = $this->record;

        $selectedTaskIds = collect($this->data)
            ->filter(fn($value, $key) => str_starts_with($key, 'temp_tasks_'))
            ->flatten()
            ->toArray();

        Log::info('les id sélectionnés', [
            'tableau origine' => collect($this->data)->flatten()
            
        ]);

        if (!empty($selectedTaskIds)) {
            $taskTemplates = TaskTemplate::with('categoryTemplate')
                ->whereIn('id', $selectedTaskIds)
                ->get();

            $groupedTasks = $taskTemplates->groupBy('category_template_id');

            Log::info('les id sélectionnés', [
                'Les tâches groupés' => $groupedTasks,
            ]);

            foreach ($groupedTasks as $catTemplateId => $tasks) {
                $catTemplate = $tasks->first()->categoryTemplate;

                $category = $project->categories()->create([
                    'title' => $catTemplate->title,
                    'category_template_id' => $catTemplateId,
                    'order' => $catTemplate->order,
                ]);

                foreach ($tasks as $taskTemp) {
                    $project->tasks()->create([
                        'category_id' => $category->id,
                        'task_template_id' => $taskTemp->id,
                        'creator_id' => auth()->id(),
                        'title' => $taskTemp->title,
                        'description' => $taskTemp->description,
                        'expected_deliverable' => $taskTemp->expected_deliverable,
                        'priority' => $taskTemp->default_priority,
                        'status' => 'a_faire',
                        'deadline' => $project->end_date,
                    ]);
                }
            }
        }
    }

}
