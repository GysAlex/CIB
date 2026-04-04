<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BulkTaskRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Collection $taskRequests)
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
    public function toMail($notifiable): MailMessage
    {
        $firstRequest = $this->taskRequests->first();
        $url = route('filament.admin.resources.task-requests.index');

        return (new MailMessage)
            ->subject("BluePay | " . $this->taskRequests->count() . " Nouvelles demandes - " . $firstRequest->project->name)
            ->markdown('email.request.bulk-task-request', [
                'tasks' => $this->taskRequests,
                'project' => $firstRequest->project,
                'client' => $firstRequest->client,
                'url' => $url,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => "{$this->taskRequests->count()} nouvelles demandes",
            'body' => "Projet : " . $this->taskRequests->first()->project->name,
            'icon' => 'heroicon-o-rectangle-stack',
            'color' => 'info',
        ];
    }
}
