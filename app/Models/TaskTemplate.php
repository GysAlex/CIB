<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskTemplate extends Model
{
    // TaskTemplate.php
    public function categoryTemplate(): BelongsTo
    {
        return $this->belongsTo(CategoryTemplate::class);
    }
}
