<?php

namespace App\Models;

use App\Observers\TaskObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([TaskObserver::class])]
class Task extends Model implements HasMedia
{

    use InteractsWithMedia;
    protected $fillable = [
        'project_id',
        'creator_id',
        'category_id',
        'task_template_id',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'checklist',
        'launch_at',
        'is_launched'
    ];

    protected $casts = [
        'objectives' => 'array',
        'deadline' => 'date',
        'attachment' => 'array',
        'is_launched' => 'boolean',
        'launch_at' => 'date',
    ];
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachements');

        $this->addMediaCollection('documents');
    }
}
