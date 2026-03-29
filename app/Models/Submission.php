<?php

namespace App\Models;

use App\Observers\SubmissionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy([SubmissionObserver::class])]
class Submission extends Model implements HasMedia
{
    use Prunable;

    use InteractsWithMedia;
    protected $fillable = [
        'task_id',
        'parent_id',
        'user_id',
        'comment',
        'status',
        'submitted_at',
        'version'
    ];

    protected $casts = [
        'submitted_at' => 'datetime'
    ];

    protected static function booted()
    {
        static::creating(function ($submission) {
            // On récupère la version la plus haute pour cette tâche précise
            $maxVersion = static::where('task_id', $submission->task_id)
                ->max('version');

            $submission->version = ($maxVersion ?? 0) + 1;
        });
    }



    /**
     * Définition des enregistrements à "élaguer" (Pruning)
     * On cible les soumissions rejetées de plus de 30 jours
     */
    public function prunable(): Builder
    {
        return static::where('status', 'rejected')
            ->where('updated_at', '<=', now()->subDays(30));
    }



    protected function pruning(): void
    {

        $this->clearMediaCollection('documents');
        $this->clearMediaCollection('attachements');
        
        // Optionnel : on peut laisser une trace dans le log
        Log::info("Nettoyage des fichiers de la soumission ID: {$this->id} (Version {$this->version})");
    }


    public function feedback(): HasOne
    {
        return $this->hasOne(SubmissionFeedback::class);
    }


    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        // Pour les pièces jointes supplémentaires
        $this->addMediaCollection('attachements');
        
        //Pour l'image de preview de chaque soumission
        $this->addMediaCollection('preview')->singleFile();

        //Pour les fichiers words, pdf, autre
        $this->addMediaCollection('documents');
    }
}
