<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{

    protected $fillable = [
        'project_id',
        'creator_id',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'checklist',
    ];

    protected $casts = [
        'checklist' => 'array',
        'deadline' => 'date',
    ];
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }


    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
