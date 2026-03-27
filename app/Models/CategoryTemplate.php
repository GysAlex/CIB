<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTemplate extends Model
{
    public function taskTemplates(): HasMany
    {
        return $this->hasMany(TaskTemplate::class);
    }

}
