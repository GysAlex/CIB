<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Submission extends Model implements HasMedia
{

    use InteractsWithMedia;
    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'status',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'date'
    ];


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
