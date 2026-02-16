<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectBottleneck extends Model
{
    protected $fillable = ['location', 'issue_summary'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
