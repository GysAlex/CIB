<?php

namespace App\Observers;

use App\Models\Submission;
use App\Models\User;
use App\Notifications\SubmissionNotification;
use App\Notifications\SubmissionReviewedNotification;
use Filament\Notifications\Notification;

class SubmissionObserver
{
    /**
     * Handle the Submission "created" event.
     */
    public function created(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "updated" event.
     */
    public function updated(Submission $submission): void
    {
        if ($submission->wasChanged('status') && $submission->status === 'pending') {
            $this->notifyAdminOfNewSubmission($submission);
        }

        if ($submission->wasChanged('status') && in_array($submission->status, ['done', 'rejected'])) {
            $this->notifyEmployeeOfReview($submission);
        }
    }


    protected function notifyAdminOfNewSubmission(Submission $submission)
    {

        $admin = $submission->task->creator;

        $admin->notify(new SubmissionNotification($submission));

        Notification::make()
            ->title('Nouveau rendu soumis')
            ->body("{$submission->user->name} a déposé son travail pour : {$submission->task->title}")
            ->icon('heroicon-o-document-check')
            ->color('info')
            ->sendToDatabase($admin);
    }


    protected function notifyEmployeeOfReview(Submission $submission): void
    {
        $isApproved = $submission->status === 'done';
        $employee = $submission->user;

        $employee->notify(new SubmissionReviewedNotification($submission));

        Notification::make()
            ->title($isApproved ? 'Travail validé !' : 'Correction demandée')
            ->body($isApproved
                ? "Votre rendu pour \"{$submission->task->title}\" a été accepté."
                : "Des modifications sont attendues sur votre dernier rendu.")
            ->icon($isApproved ? 'heroicon-o-check-badge' : 'heroicon-o-exclamation-triangle')
            ->color($isApproved ? 'success' : 'danger')
            ->sendToDatabase($employee);
    }


    /**
     * Handle the Submission "deleted" event.
     */
    public function deleted(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "restored" event.
     */
    public function restored(Submission $submission): void
    {
        //
    }

    /**
     * Handle the Submission "force deleted" event.
     */
    public function forceDeleted(Submission $submission): void
    {
        //
    }
}
