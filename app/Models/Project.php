<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status',
        'deadline',
        'project_manager_id',
        'substation_id',
        'timeline',
        'date_of_commissioning',
        'scheduled_date_of_completion',
        'project_cost',
        'scheme',
        'voltage_level',
        'line_length_km',
        'approved_cost_cr',
        'scheduled_cod',
        'target_cod',
        'executing_agency',
        'review_period',
        'overall_status',
        'expenditure_till_date',
        'billing_pending',
        'cost_overrun',
        'financial_health',
        'summary_text',
        'expected_foundation_nos',
        'expected_erection_nos',
        'expected_stringing_km',
        'clearance_expected',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ProjectStatus::class,
            'deadline' => 'date',
            'date_of_commissioning' => 'date',
            'scheduled_date_of_completion' => 'date',
            'scheduled_cod' => 'date',
            'target_cod' => 'date',
            'line_length_km' => 'decimal:2',
            'approved_cost_cr' => 'decimal:2',
            'expenditure_till_date' => 'decimal:2',
            'billing_pending' => 'decimal:2',
            'cost_overrun' => 'decimal:2',
            'expected_stringing_km' => 'decimal:2',
            'project_cost' => 'decimal:2',
        ];
    }

    public function substation(): BelongsTo
    {
        return $this->belongsTo(Substation::class);
    }

    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')->withTimestamps();
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function physicalProgress(): HasMany
    {
        return $this->hasMany(ProjectPhysicalProgress::class)->orderBy('id');
    }

    public function clearances(): HasMany
    {
        return $this->hasMany(ProjectClearance::class)->orderBy('id');
    }

    public function bottlenecks(): HasMany
    {
        return $this->hasMany(ProjectBottleneck::class)->orderBy('id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class)->orderBy('id');
    }

    public function risks(): HasMany
    {
        return $this->hasMany(ProjectRisk::class)->orderBy('sort_order');
    }

    public function manpower(): HasMany
    {
        return $this->hasMany(ProjectManpower::class)->orderBy('id');
    }

    public function decisions(): HasMany
    {
        return $this->hasMany(ProjectDecision::class)->orderBy('sort_order');
    }

    public function scopeVisibleBy(Builder $query, User $user): void
    {
        if ($user->hasRole('Admin')) {
            return;
        }
        $query->where(function (Builder $q) use ($user) {
            $q->where('project_manager_id', $user->id)
                ->orWhereHas('members', fn ($m) => $m->where('users.id', $user->id));

            if ($user->substation_id) {
                $q->orWhere('substation_id', $user->substation_id);
            }
            if ($user->division_id) {
                $q->orWhereHas('substation', fn ($s) => $s->where('division_id', $user->division_id));
            }
            if ($user->circle_id) {
                $q->orWhereHas('substation', fn ($s) => $s->where('circle_id', $user->circle_id));
            }
            if ($user->zone_id) {
                $q->orWhereHas('substation', fn ($s) => $s->where('zone_id', $user->zone_id));
            }
        });
    }
}
