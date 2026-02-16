<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'project_id',
        'assigned_to',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'due_date' => 'date',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class);
    }

    public function scopeVisibleBy(Builder $query, User $user): void
    {
        if ($user->hasRole('Admin')) {
            return;
        }
        if ($user->hasRole('Project Manager')) {
            $query->whereHas('project', function (Builder $q) use ($user) {
                $q->where('project_manager_id', $user->id)
                    ->orWhereHas('members', fn ($m) => $m->where('users.id', $user->id));
            });

            return;
        }
        $query->where(function (Builder $q) use ($user) {
            $q->where('assigned_to', $user->id)
                ->orWhereHas('project', fn ($p) => $p->whereHas('members', fn ($m) => $m->where('users.id', $user->id)));
        });
    }
}
