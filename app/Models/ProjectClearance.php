<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectClearance extends Model
{
    protected $fillable = ['clearance_type', 'total', 'obtained', 'pending', 'remarks'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
