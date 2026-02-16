@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .dash-wrap { --dash-primary: #2563eb; --dash-indigo: #4f46e5; --dash-amber: #d97706; --dash-emerald: #059669; --dash-slate: #334155; --dash-muted: #64748b; }
    .dash-hero { background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%); color: #fff; border-radius: 14px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem; }
    .dash-hero h1 { font-size: 1.35rem; font-weight: 700; margin: 0; color: #fff; }
    .dash-hero p { margin: 0.25rem 0 0; opacity: 0.9; font-size: 0.9rem; }
    .dash-hero .btn-light { border-radius: 8px; font-weight: 500; }
    .dash-kpi { border-radius: 14px; padding: 1.25rem; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.07); transition: transform 0.2s, box-shadow 0.2s; overflow: hidden; position: relative; }
    .dash-kpi:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .dash-kpi .dash-kpi-value { font-size: 1.85rem; font-weight: 800; letter-spacing: -0.02em; }
    .dash-kpi .dash-kpi-label { font-size: 0.8rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; opacity: 0.85; }
    .dash-kpi .dash-kpi-sub { font-size: 0.75rem; margin-top: 0.2rem; }
    .dash-kpi-icon { width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #fff; }
    .dash-kpi.dash-kpi-users { background: linear-gradient(145deg, #eff6ff 0%, #dbeafe 100%); }
    .dash-kpi.dash-kpi-users .dash-kpi-value { color: #1d4ed8; }
    .dash-kpi.dash-kpi-users .dash-kpi-icon { background: linear-gradient(135deg, #2563eb, #3b82f6); }
    .dash-kpi.dash-kpi-projects { background: linear-gradient(145deg, #eef2ff 0%, #e0e7ff 100%); }
    .dash-kpi.dash-kpi-projects .dash-kpi-value { color: #4338ca; }
    .dash-kpi.dash-kpi-projects .dash-kpi-icon { background: linear-gradient(135deg, #4f46e5, #6366f1); }
    .dash-kpi.dash-kpi-tasks { background: linear-gradient(145deg, #fffbeb 0%, #fef3c7 100%); }
    .dash-kpi.dash-kpi-tasks .dash-kpi-value { color: #b45309; }
    .dash-kpi.dash-kpi-tasks .dash-kpi-icon { background: linear-gradient(135deg, #d97706, #f59e0b); }
    .dash-kpi.dash-kpi-active { background: linear-gradient(145deg, #ecfdf5 0%, #d1fae5 100%); }
    .dash-kpi.dash-kpi-active .dash-kpi-value { color: #047857; }
    .dash-kpi.dash-kpi-active .dash-kpi-icon { background: linear-gradient(135deg, #059669, #10b981); }
    .dash-card { background: #fff; border: none; border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
    .dash-card .card-body { padding: 1.35rem; }
    .dash-card .card-title { font-weight: 700; color: #1e293b; font-size: 1rem; }
</style>
@endpush

@section('content')
    <div class="dash-wrap">
    <div class="mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="dash-hero d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h1 class="h4 mb-0 fw-bold">Project Management Dashboard</h1>
            <p class="mb-0">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <a href="{{ route('projects.index') }}" class="btn btn-light btn-sm">View all projects <i class="bi bi-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="dash-kpi dash-kpi-users h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="dash-kpi-label mb-1">Users</div>
                    <div class="dash-kpi-value">{{ $totalUsers }}</div>
                    <small class="dash-kpi-sub text-muted">Team users</small>
                </div>
                <div class="dash-kpi-icon"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dash-kpi dash-kpi-projects h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="dash-kpi-label mb-1">Projects</div>
                    <div class="dash-kpi-value">{{ $totalProjects }}</div>
                    <small class="dash-kpi-sub text-muted">Total</small>
                </div>
                <div class="dash-kpi-icon"><i class="bi bi-folder2-open-fill"></i></div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dash-kpi dash-kpi-tasks h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="dash-kpi-label mb-1">Tasks</div>
                    <div class="dash-kpi-value">{{ $totalTasks }}</div>
                    <small class="dash-kpi-sub text-muted">All tasks</small>
                </div>
                <div class="dash-kpi-icon"><i class="bi bi-check2-square-fill"></i></div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="dash-kpi dash-kpi-active h-100 d-flex justify-content-between align-items-start">
                <div>
                    <div class="dash-kpi-label mb-1">Active</div>
                    <div class="dash-kpi-value">{{ $activeProjects }}</div>
                    <small class="dash-kpi-sub text-muted">Active projects</small>
                </div>
                <div class="dash-kpi-icon"><i class="bi bi-activity"></i></div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="dash-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-1">Monthly Target</h5>
                    <p class="text-muted small mb-3">Project completion</p>
                    @php
                        $completed = $projectsByStatus['Completed'] ?? 0;
                        $total = $totalProjects ?: 1;
                        $pct = min(100, round(($completed / $total) * 100, 1));
                    @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="crm-progress-ring position-relative">
                            <canvas id="targetRing" width="120" height="120"></canvas>
                            <span id="targetRingText" class="position-absolute top-50 start-50 translate-middle fw-bold" style="font-size:1.25rem; color: #2563eb;">{{ $pct }}%</span>
                        </div>
                        <div>
                            <p class="text-muted small mb-0">Completed projects</p>
                            <p class="fw-semibold mb-0" style="color: #2563eb;">Keep it up!</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Target {{ $total }}</span>
                        <span>Done {{ $completed }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="dash-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Monthly Projects</h5>
                    <div style="height: 260px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-4">
            <div class="dash-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Projects by Status</h5>
                    <div class="d-flex justify-content-center" style="max-height: 220px;">
                        <canvas id="projectChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dash-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Tasks by Status</h5>
                    <div class="d-flex justify-content-center" style="max-height: 220px;">
                        <canvas id="tasksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dash-card h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Users by Role</h5>
                    @if($rolesWithUserCount->isEmpty())
                        <p class="text-muted small mb-0">No roles defined.</p>
                    @else
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    @foreach($rolesWithUserCount as $role)
                                        <tr>
                                            <td class="text-dark fw-medium">{{ $role->name }}</td>
                                            <td class="text-end">
                                                <span class="badge rounded-pill" style="background: #2563eb;">{{ $role->users_count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center" style="max-height: 140px;">
                            <canvas id="usersChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12">
            <div class="dash-card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Recent Projects</h5>
                    @if($recentProjects->isEmpty())
                        <p class="text-muted mb-0">No projects yet. <a href="{{ route('projects.create') }}" style="color: #2563eb;">Create one</a>.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Manager</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProjects as $p)
                                        <tr>
                                            <td class="fw-medium">{{ $p->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $p->status->value === 'Active' ? 'primary' : ($p->status->value === 'Completed' ? 'secondary' : 'warning') }}">{{ $p->status->value }}</span>
                                            </td>
                                            <td class="text-muted">{{ $p->projectManager?->name ?? '—' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('projects.show', $p) }}" class="btn btn-sm" style="background: #2563eb; color: #fff;">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm mt-2" style="background: #2563eb; color: #fff;">All projects</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    @php
        $targetPct = $totalProjects ? (int) min(100, round((($projectsByStatus['Completed'] ?? 0) / $totalProjects) * 100)) : 0;
    @endphp
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var primary = '#2563eb';
            var indigo = '#4f46e5';
            var amber = '#d97706';
            var emerald = '#059669';
            var palette = [primary, indigo, amber, emerald, '#6366f1', '#10b981'];

            // Target ring (semi-circle style as doughnut 180deg)
            var pct = {{ $targetPct }};
            var targetCtx = document.getElementById('targetRing').getContext('2d');
            new Chart(targetCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Done', 'Remaining'],
                    datasets: [{
                        data: [pct, 100 - pct],
                        backgroundColor: [primary, '#e2e8f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    circumference: 180,
                    rotation: 270,
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: { legend: { display: false } }
                }
            });

            // Monthly projects bar chart
            var monthlyData = @json($projectsPerMonth);
            var monthNames = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            var last12 = [];
            for (var i = 11; i >= 0; i--) {
                var d = new Date();
                d.setMonth(d.getMonth() - i);
                var key = d.getFullYear() + '-' + (d.getMonth() + 1);
                var found = monthlyData.find(function(x) { return x.year == d.getFullYear() && x.month == (d.getMonth() + 1); });
                last12.push({ label: monthNames[d.getMonth()] + ' ' + d.getFullYear(), count: found ? found.count : 0 });
            }
            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: last12.map(function(x) { return x.label; }),
                    datasets: [{
                        label: 'Projects',
                        data: last12.map(function(x) { return x.count; }),
                        backgroundColor: primary,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            var statusCounts = @json($projectsByStatus);
            var plabels = ['Active', 'Completed', 'On Hold'];
            var pvalues = plabels.map(function(l) { return statusCounts[l] || 0; });
            new Chart(document.getElementById('projectChart'), {
                type: 'doughnut',
                data: {
                    labels: plabels,
                    datasets: [{ data: pvalues, backgroundColor: [primary, '#64748b', amber], borderWidth: 0 }]
                },
                options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } }
            });

            var taskStatusCounts = @json($tasksByStatus);
            var tlabels = ['Todo', 'In Progress', 'Done'];
            var tvalues = tlabels.map(function(l) { return taskStatusCounts[l] || 0; });
            new Chart(document.getElementById('tasksChart'), {
                type: 'doughnut',
                data: {
                    labels: tlabels,
                    datasets: [{ data: tvalues, backgroundColor: [primary, amber, emerald], borderWidth: 0 }]
                },
                options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } }
            });

            var usersChartEl = document.getElementById('usersChart');
            if (usersChartEl) {
                var usersByRole = @json($usersByRole);
                var roleLabels = Object.keys(usersByRole);
                var roleValues = Object.values(usersByRole);
                new Chart(usersChartEl, {
                    type: 'doughnut',
                    data: {
                        labels: roleLabels,
                        datasets: [{ data: roleValues, backgroundColor: palette.slice(0, Math.max(roleLabels.length, 1)), borderWidth: 0 }]
                    },
                    options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } } }
                });
            }
        });
    </script>
    @endpush
@endsection
