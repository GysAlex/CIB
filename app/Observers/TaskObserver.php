<?php

namespace App\Observers;

use App\Models\Task;
use App\Notifications\TaskAssignedNotification;
use Filament\Notifications\Notification;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->wasChanged('is_launched') && $task->is_launched) {

            $members = $task->members;

            foreach ($members as $user) {
                $user->notify(new TaskAssignedNotification($task));

                Notification::make()
                    ->title('Nouvelle mission assignée')
                    ->body("Vous avez été assigné à la tâche : {$task->title}")
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color('success')
                    ->sendToDatabase($user);
            }
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
