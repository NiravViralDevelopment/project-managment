<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectBottleneck;
use App\Models\ProjectClearance;
use App\Models\ProjectDecision;
use App\Models\ProjectManpower;
use App\Models\ProjectMilestone;
use App\Models\ProjectPhysicalProgress;
use App\Models\ProjectRisk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectProgressController extends Controller
{
    public function show(Project $project): View|RedirectResponse
    {
        $this->authorizeProject($project);
        $project->load([
            'projectManager', 'physicalProgress', 'clearances', 'bottlenecks',
            'milestones', 'risks', 'manpower', 'decisions',
        ]);

        return view('projects.progress', compact('project'));
    }

    public function edit(Project $project): View|RedirectResponse
    {
        $this->authorizeProject($project);
        $project->load([
            'physicalProgress', 'clearances', 'bottlenecks',
            'milestones', 'risks', 'manpower', 'decisions',
        ]);

        return view('projects.progress-edit', compact('project'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorizeProject($project);

        $project->update($request->only([
            'voltage_level', 'line_length_km', 'approved_cost_cr', 'scheduled_cod', 'target_cod',
            'executing_agency', 'review_period', 'overall_status', 'expenditure_till_date',
            'billing_pending', 'cost_overrun', 'financial_health', 'summary_text',
            'expected_foundation_nos', 'expected_erection_nos', 'expected_stringing_km', 'clearance_expected',
        ]));

        $this->syncPhysicalProgress($project, $request->input('physical', []));
        $this->syncClearances($project, $request->input('clearances', []));
        $this->syncBottlenecks($project, $request->input('bottlenecks', []));
        $this->syncMilestones($project, $request->input('milestones', []));
        $this->syncRisks($project, $request->input('risks', []));
        $this->syncManpower($project, $request->input('manpower', []));
        $this->syncDecisions($project, $request->input('decisions', []));

        return redirect()
            ->route('projects.progress.show', $project)
            ->with('success', 'Progress review updated successfully.');
    }

    private function authorizeProject(Project $project): void
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return;
        }
        $visible = Project::query()->visibleBy($user)->where('id', $project->id)->exists();
        if (! $visible) {
            abort(403, 'You do not have access to this project.');
        }
    }

    private function syncPhysicalProgress(Project $project, array $rows): void
    {
        $project->physicalProgress()->delete();
        foreach ($rows as $row) {
            if (empty($row['activity'])) {
                continue;
            }
            $project->physicalProgress()->create([
                'activity' => $row['activity'],
                'total_scope' => $row['total_scope'] ?? 0,
                'achieved' => $row['achieved'] ?? 0,
                'balance' => $row['balance'] ?? 0,
                'progress_pct' => $row['progress_pct'] ?? 0,
                'unit' => $row['unit'] ?? null,
            ]);
        }
    }

    private function syncClearances(Project $project, array $rows): void
    {
        $project->clearances()->delete();
        foreach ($rows as $row) {
            if (empty($row['clearance_type'])) {
                continue;
            }
            $project->clearances()->create([
                'clearance_type' => $row['clearance_type'],
                'total' => (int) ($row['total'] ?? 0),
                'obtained' => (int) ($row['obtained'] ?? 0),
                'pending' => (int) ($row['pending'] ?? 0),
                'remarks' => $row['remarks'] ?? null,
            ]);
        }
    }

    private function syncBottlenecks(Project $project, array $rows): void
    {
        $project->bottlenecks()->delete();
        foreach ($rows as $row) {
            if (empty($row['location'])) {
                continue;
            }
            $project->bottlenecks()->create([
                'location' => $row['location'],
                'issue_summary' => $row['issue_summary'] ?? null,
            ]);
        }
    }

    private function syncMilestones(Project $project, array $rows): void
    {
        $project->milestones()->delete();
        foreach ($rows as $row) {
            if (empty($row['milestone_name'])) {
                continue;
            }
            $project->milestones()->create([
                'milestone_name' => $row['milestone_name'],
                'planned_date' => $row['planned_date'] ?? null,
                'actual_date' => $row['actual_date'] ?? null,
                'status' => $row['status'] ?? null,
                'schedule_variance_days' => isset($row['schedule_variance_days']) ? (int) $row['schedule_variance_days'] : null,
            ]);
        }
    }

    private function syncRisks(Project $project, array $rows): void
    {
        $project->risks()->delete();
        $sort = 0;
        foreach ($rows as $row) {
            if (empty($row['issue'])) {
                continue;
            }
            $project->risks()->create([
                'issue' => $row['issue'],
                'impact' => $row['impact'] ?? null,
                'responsibility' => $row['responsibility'] ?? null,
                'action_plan' => $row['action_plan'] ?? null,
                'target_date' => $row['target_date'] ?? null,
                'sort_order' => $sort++,
            ]);
        }
    }

    private function syncManpower(Project $project, array $rows): void
    {
        $project->manpower()->delete();
        foreach ($rows as $row) {
            if (empty($row['parameter'])) {
                continue;
            }
            $project->manpower()->create([
                'parameter' => $row['parameter'],
                'status' => $row['status'] ?? null,
            ]);
        }
    }

    private function syncDecisions(Project $project, array $rows): void
    {
        $project->decisions()->delete();
        $sort = 0;
        foreach (array_filter($rows, fn ($r) => ! empty($r['decision_text'] ?? '')) as $row) {
            $project->decisions()->create([
                'decision_text' => $row['decision_text'],
                'sort_order' => $sort++,
            ]);
        }
    }
}
