<?php

namespace App\Models;

use App\Observers\ProjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


// #[ObservedBy([ProjectObserver::class])]
class Project extends Model
{
    //

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    protected $fillable = [
        'name',
        'description',
        'image_path',
        'location',
        'status',
        'start_date',
        'end_date',
        'client_id',
        'creator_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }


    public function getCompletionPercentageAttribute(): int
    {
        $total = $this->tasks()->count();
        if ($total === 0)
            return 0;

        $completed = $this->tasks()->where('status', 'valide')->count();
        return (int) (($completed / $total) * 100);
    }

    public function getOfficialDocumentsAttribute()
    {
        return Media::whereHasMorph(
            'model',
            Submission::class,
            fn($q) => $q->whereHas('task', fn($t) => $t->where('project_id', $this->id))
                        ->where('status', 'done')
        )->get();
    }
}
