<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\CategoryTemplate;
use App\Models\TaskTemplate;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $project = $this->record;

        // On récupère tous les IDs de templates déjà transformés en tâches pour ce projet
        $existingTemplateIds = $project->tasks()
            ->whereNotNull('task_template_id')
            ->pluck('task_template_id')
            ->toArray();

        // On parcourt les catégories pour dispatcher les IDs dans les bons champs "temp_tasks_..."
        $categories = CategoryTemplate::all();

        foreach ($categories as $category) {
            $data["temp_tasks_{$category->id}"] = TaskTemplate::where('category_template_id', $category->id)
                ->whereIn('id', $existingTemplateIds)
                ->pluck('id')
                ->toArray();
        }

        return $data;
    }


    protected function afterSave(): void
    {
        $project = $this->record;

        // 1. Récupérer tous les IDs cochés dans le formulaire
        $selectedTemplateIds = collect($this->data)
            ->filter(fn($value, $key) => str_starts_with($key, 'temp_tasks_'))
            ->flatten()
            ->toArray();

        // 2. Récupérer les IDs déjà présents en base de données
        $currentTemplateIds = $project->tasks()->whereNotNull('task_template_id')->pluck('task_template_id')->toArray();

        // 3. Identifier ce qu'il faut AJOUTER et ce qu'il faut SUPPRIMER
        $toCreate = array_diff($selectedTemplateIds, $currentTemplateIds); //Retourne un array contenant les valeurs présentes dans selectedTemplateId, 
        // et qui ne sont pas présente dans currentTemplatIds
        
        $toDelete = array_diff($currentTemplateIds, $selectedTemplateIds);

        // --- SUPPRESSION ---
        if (!empty($toDelete)) {
            $project->tasks()->whereIn('task_template_id', $toDelete)->delete();
            // Optionnel : Nettoyer les catégories vides après suppression
            $project->categories()->doesntHave('tasks')->delete();
        }

        // --- AJOUT (Ta logique existante adaptée) ---
        if (!empty($toCreate)) {
            $taskTemplates = TaskTemplate::with('categoryTemplate')
                ->whereIn('id', $toCreate)
                ->get();

            foreach ($taskTemplates->groupBy('category_template_id') as $catTemplateId => $tasks) {
                // On vérifie si la catégorie existe déjà pour ce projet, sinon on la crée
                $category = $project->categories()->firstOrCreate(
                    ['category_template_id' => $catTemplateId],
                    [
                        'title' => $tasks->first()->categoryTemplate->title,
                        'order' => $tasks->first()->categoryTemplate->order,
                    ]
                );

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

    protected function getRedirectUrl(): string|null
    {
        return $this->getResource()::getUrl('index');
    }


}
