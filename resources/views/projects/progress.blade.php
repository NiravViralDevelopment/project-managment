@extends('layouts.app')

@section('title', 'Progress Review - ' . $project->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projects</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.show', $project) }}" class="text-decoration-none">{{ $project->name }}</a></li>
            <li class="breadcrumb-item active">Progress Review</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <h1 class="h2 mb-0">Project Progress Review</h1>
        @can('edit-projects')
            <a href="{{ route('projects.progress.edit', $project) }}" class="btn btn-primary">Edit Progress</a>
        @endcan
    </div>

    {{-- A. Project Snapshot --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>A. Project Snapshot (At a Glance)</strong></div>
        <div class="card-body">
            <div class="row g-2 small">
                <div class="col-md-4"><strong>Project Name:</strong> {{ $project->name }}</div>
                <div class="col-md-2"><strong>Voltage:</strong> {{ $project->voltage_level ?? '—' }}</div>
                <div class="col-md-2"><strong>Line Length (km):</strong> {{ $project->line_length_km ?? '—' }}</div>
                <div class="col-md-2"><strong>Approved Cost (₹ Cr):</strong> {{ $project->approved_cost_cr ?? '—' }}</div>
                <div class="col-md-2"><strong>Scheduled COD:</strong> {{ $project->scheduled_cod?->format('d/m/Y') ?? '—' }}</div>
                <div class="col-md-2"><strong>Target COD:</strong> {{ $project->target_cod?->format('d/m/Y') ?? '—' }}</div>
                <div class="col-md-2"><strong>Executing Agency:</strong> {{ $project->executing_agency ?? '—' }}</div>
                <div class="col-md-2"><strong>Review Period:</strong> {{ $project->review_period ?? '—' }}</div>
                <div class="col-md-2"><strong>Overall Status:</strong>
                    @if($project->overall_status)
                        <span class="badge bg-{{ $project->overall_status === 'On Track' ? 'success' : ($project->overall_status === 'Delayed' ? 'danger' : 'warning') }}">{{ $project->overall_status }}</span>
                    @else — @endif
                </div>
            </div>
        </div>
    </div>

    {{-- B. Physical Progress --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>B. Physical Progress Summary</strong></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Activity</th><th>Total Scope</th><th>Achieved</th><th>Balance</th><th>% Progress</th></tr></thead>
                    <tbody>
                        @forelse($project->physicalProgress as $p)
                            <tr><td>{{ $p->activity }}</td><td>{{ $p->total_scope }} {{ $p->unit ?? '' }}</td><td>{{ $p->achieved }}</td><td>{{ $p->balance }}</td><td>{{ $p->progress_pct }}%</td></tr>
                        @empty
                            <tr><td colspan="5" class="text-muted text-center">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- C. Financial Progress --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>C. Financial Progress</strong></div>
        <div class="card-body">
            <div class="row g-2 small">
                <div class="col-md-2"><strong>Approved Cost (₹ Cr):</strong> {{ $project->approved_cost_cr ?? '—' }}</div>
                <div class="col-md-2"><strong>Expenditure till Date:</strong> {{ $project->expenditure_till_date ?? '—' }}</div>
                <div class="col-md-2"><strong>Billing Pending:</strong> {{ $project->billing_pending ?? '—' }}</div>
                <div class="col-md-2"><strong>Cost Overrun:</strong> {{ $project->cost_overrun ?? '—' }}</div>
                <div class="col-md-2"><strong>Financial Health:</strong> {{ $project->financial_health ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- D. RoW & Clearance --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>D. Right of Way (RoW) & Clearance Status</strong></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Clearance Type</th><th>Total</th><th>Obtained</th><th>Pending</th><th>Remarks</th></tr></thead>
                    <tbody>
                        @forelse($project->clearances as $c)
                            <tr><td>{{ $c->clearance_type }}</td><td>{{ $c->total }}</td><td>{{ $c->obtained }}</td><td>{{ $c->pending }}</td><td>{{ $c->remarks ?? '—' }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="text-muted text-center">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($project->bottlenecks->isNotEmpty())
                <div class="p-3"><strong>Key Bottleneck Locations:</strong>
                    @foreach($project->bottlenecks as $b)
                        <div class="small">{{ $b->location }} — {{ $b->issue_summary ?? '—' }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- E. Schedule Monitoring --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>E. Schedule Monitoring</strong></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Milestone</th><th>Planned Date</th><th>Actual/Expected Date</th><th>Status</th><th>Variance (Days)</th></tr></thead>
                    <tbody>
                        @forelse($project->milestones as $m)
                            <tr><td>{{ $m->milestone_name }}</td><td>{{ $m->planned_date?->format('d/m/Y') ?? '—' }}</td><td>{{ $m->actual_date?->format('d/m/Y') ?? '—' }}</td><td>{{ $m->status ?? '—' }}</td><td>{{ $m->schedule_variance_days !== null ? $m->schedule_variance_days : '—' }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="text-muted text-center">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- F. Risk & Issues --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>F. Risk & Issues Tracker (Top 5)</strong></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Issue</th><th>Impact</th><th>Responsibility</th><th>Action Plan</th><th>Target Date</th></tr></thead>
                    <tbody>
                        @forelse($project->risks as $r)
                            <tr><td>{{ $r->issue }}</td><td>{{ $r->impact ?? '—' }}</td><td>{{ $r->responsibility ?? '—' }}</td><td>{{ $r->action_plan ?? '—' }}</td><td>{{ $r->target_date?->format('d/m/Y') ?? '—' }}</td></tr>
                        @empty
                            <tr><td colspan="5" class="text-muted text-center">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- G. Manpower & Contractor --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>G. Manpower & Contractor Performance</strong></div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Parameter</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($project->manpower as $mp)
                            <tr><td>{{ $mp->parameter }}</td><td>{{ $mp->status ?? '—' }}</td></tr>
                        @empty
                            <tr><td colspan="2" class="text-muted text-center">No data</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- H. Key Decisions --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>H. Key Decisions Required from Management</strong></div>
        <div class="card-body">
            @if($project->decisions->isNotEmpty())
                <ol class="mb-0">
                    @foreach($project->decisions as $d)
                        <li>{{ $d->decision_text }}</li>
                    @endforeach
                </ol>
            @else
                <p class="text-muted mb-0">None listed.</p>
            @endif
        </div>
    </div>

    {{-- I. Expected Progress --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>I. Expected Progress Next Review Period</strong></div>
        <div class="card-body">
            <div class="row g-2 small">
                <div class="col-md-3"><strong>Foundation (Nos):</strong> {{ $project->expected_foundation_nos ?? '—' }}</div>
                <div class="col-md-3"><strong>Erection (Nos):</strong> {{ $project->expected_erection_nos ?? '—' }}</div>
                <div class="col-md-3"><strong>Stringing (km):</strong> {{ $project->expected_stringing_km ?? '—' }}</div>
                <div class="col-md-3"><strong>Clearance Expected:</strong> {{ $project->clearance_expected ?? '—' }}</div>
            </div>
        </div>
    </div>

    {{-- J. Summary --}}
    <div class="card crm-card mb-4">
        <div class="card-header bg-white"><strong>J. Summary for Management</strong></div>
        <div class="card-body">
            <p class="mb-0">{{ $project->summary_text ?? '—' }}</p>
        </div>
    </div>
@endsection
