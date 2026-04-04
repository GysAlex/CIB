<?php

namespace App\Notifications;

use App\Models\TaskRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskRequestResponseDecisionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public TaskRequest $taskRequest,
    ) {
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
        $isApprouve = $this->taskRequest->status === 'approuve';

        return (new MailMessage)
            ->subject(env('APP_NAME')." | Mise à jour de votre demande : " . $this->taskRequest->title)
            ->markdown('email.request.task-decision', [
                'taskRequest' => $this->taskRequest,
                'statusTitle' => $isApprouve ? "✅ Demande Approuvée" : "❌ Demande Refusée",
                'statusLabel' => $isApprouve ? "Approuvée" : "Refusée",
                'url' => route('filament.client.resources.task-requests.index'),
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
            ->title($this->taskRequest->status === 'approuve' ? "Demande validée" : "Demande refusée")
            ->body("La tâche '{$this->taskRequest->title}' a été traitée.")
            ->icon($this->taskRequest->status === 'approuve' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->iconColor($this->taskRequest->status === 'approuve' ? 'success' : 'danger')
            ->getDatabaseMessage();
    }


}
