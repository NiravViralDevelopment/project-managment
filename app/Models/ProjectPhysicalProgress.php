<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPhysicalProgress extends Model
{
    protected $table = 'project_physical_progress';

    protected $fillable = ['activity', 'total_scope', 'achieved', 'balance', 'progress_pct', 'unit'];

    protected function casts(): array
    {
        return [
            'total_scope' => 'decimal:2',
            'achieved' => 'decimal:2',
            'balance' => 'decimal:2',
            'progress_pct' => 'decimal:2',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
