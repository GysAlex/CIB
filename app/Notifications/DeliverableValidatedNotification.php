<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeliverableValidatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('filament.client.pages.project-bilan', ['record' => $this->task->project_id]);

        return (new MailMessage)->markdown('email.deliverable.delivered', [
                'task' => $this->task,
                'url' => $url,
                'notifiable' => $notifiable,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title("Livrable validé : {$this->task->title}")
            ->body("Un nouveau livrable est disponible pour votre projet {$this->task->project->name}.")
            ->icon('heroicon-o-cloud-arrow-down')
            ->iconColor('success')
            ->getDatabaseMessage();
    }
}
