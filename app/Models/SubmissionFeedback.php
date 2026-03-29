<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionFeedback extends Model
{
    protected $table = 'submission_feedbacks';
    protected $fillable = [
        'submission_id',
        'admin_id',
        'score',
        'comment',
        'decision',
        'objectives_evaluation',
        'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'objectives_evaluation' => 'array'
    ];


    public function submission(): BelongsTo
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

}
