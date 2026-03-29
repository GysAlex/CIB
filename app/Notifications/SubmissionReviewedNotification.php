<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubmissionReviewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private Submission $submission)
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
        $status = $this->submission->status;
        $taskTitle = $this->submission->task->title;

        $subject = ($status === 'done')
            ? "Travail validé : $taskTitle"
            : "Corrections demandées : $taskTitle";
        return (new MailMessage)->markdown('mail.submission.reviewed', [
            'submission' => $this->submission,
            'feedback' => $this->submission->feedback,
            'url' => route('filament.employee.resources.submissions.view', ['record' => $this->submission->id]),
            'isApproved' => $status === 'done',
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
            'submission_id' => $this->submission->id,
            'status' => $this->submission->status,
            'task_title' => $this->submission->task->title,
            'score' => $this->submission->feedback?->score,
        ];
    }
}
