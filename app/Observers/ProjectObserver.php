<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\TaskTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        // On ne prend que les templates actifs
        $templates = TaskTemplate::whereNull('parent_id')
            ->where('is_active', true)
            ->with('children')
            ->orderBy('order')
            ->get();

            Log::info('id', [
                'id' => Auth::id()
            ]);

        foreach ($templates as $template) {
            $parentTask = $project->tasks()->create([
                'title'                => $template->title,
                'description'          => $template->description,
                'priority'             => $template->priority,
                'expected_deliverable' => $template->expected_deliverable,
                'status'               => 'pending',
                'created_by'           =>  Auth::id(),
            ]);


            Log::info('child', [
                    'child' => $template->children
                ]);
                

            foreach ($template->children as $child) {

                $parentTask->subtasks()->create([
                    'project_id'  => $project->id,
                    'title'       => $child->title,
                    'description' => $child->description,
                    'priority'    => $child->priority,
                    'status'      => 'pending',
                    'created_by'  => Auth::id(),
                ]);
            }
        }
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     */
    public function restored(Project $project): void
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     */
    public function forceDeleted(Project $project): void
    {
        //
    }
}
