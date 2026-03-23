<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    //


    protected $fillable = [
        'name',
        'description',
        'image_path',
        'location',
        'status',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }


}
