<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskRequest extends Model
{
    protected $fillable = [
        'project_id',
        'client_id',
        'task_template_id',
        'title',
        'description',
        'priority',
        'status',
        'admin_comment'
    ];
}
