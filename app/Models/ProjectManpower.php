<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectManpower extends Model
{
    protected $table = 'project_manpower';

    protected $fillable = ['parameter', 'status'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
