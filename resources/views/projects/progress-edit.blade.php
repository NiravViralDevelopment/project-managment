@extends('layouts.app')

@section('title', 'Edit Progress - ' . $project->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projects</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.progress.show', $project) }}" class="text-decoration-none">Progress Review</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
    <h1 class="h2 mb-4">Edit Progress Review</h1>

    <form method="POST" action="{{ route('projects.progress.update', $project) }}">
        @csrf
        @method('PUT')

        {{-- A. Project Snapshot --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>A. Project Snapshot</strong></div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-3"><label class="form-label small">Voltage Level (kV)</label><input type="text" name="voltage_level" class="form-control form-control-sm" value="{{ old('voltage_level', $project->voltage_level) }}" placeholder="220/400/765"></div>
                    <div class="col-md-2"><label class="form-label small">Line Length (km)</label><input type="number" step="0.01" name="line_length_km" class="form-control form-control-sm" value="{{ old('line_length_km', $project->line_length_km) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Approved Cost (₹ Cr)</label><input type="number" step="0.01" name="approved_cost_cr" class="form-control form-control-sm" value="{{ old('approved_cost_cr', $project->approved_cost_cr) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Scheduled COD</label><input type="date" name="scheduled_cod" class="form-control form-control-sm" value="{{ old('scheduled_cod', $project->scheduled_cod?->format('Y-m-d')) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Target COD</label><input type="date" name="target_cod" class="form-control form-control-sm" value="{{ old('target_cod', $project->target_cod?->format('Y-m-d')) }}"></div>
                    <div class="col-md-3"><label class="form-label small">Executing Agency</label><input type="text" name="executing_agency" class="form-control form-control-sm" value="{{ old('executing_agency', $project->executing_agency) }}" placeholder="GETCO/EPC"></div>
                    <div class="col-md-2"><label class="form-label small">Review Period</label><input type="text" name="review_period" class="form-control form-control-sm" value="{{ old('review_period', $project->review_period) }}" placeholder="Month/Fortnight"></div>
                    <div class="col-md-2"><label class="form-label small">Overall Status</label>
                        <select name="overall_status" class="form-select form-select-sm">
                            <option value="">—</option>
                            <option value="On Track" {{ old('overall_status', $project->overall_status) === 'On Track' ? 'selected' : '' }}>On Track</option>
                            <option value="At Risk" {{ old('overall_status', $project->overall_status) === 'At Risk' ? 'selected' : '' }}>At Risk</option>
                            <option value="Delayed" {{ old('overall_status', $project->overall_status) === 'Delayed' ? 'selected' : '' }}>Delayed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- B. Physical Progress --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>B. Physical Progress Summary</strong></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light"><tr><th>Activity</th><th>Total</th><th>Achieved</th><th>Balance</th><th>%</th><th>Unit</th></tr></thead>
                        <tbody id="physicalBody">
                            @php $defaultActivities = ['Route Survey','Forest Clearance','Tower Foundation','Tower Erection','Stringing','Charging Readiness','Critical Path Activity']; $physByActivity = $project->physicalProgress->keyBy('activity'); @endphp
                            @foreach($defaultActivities as $i => $act)
                                @php $row = $physByActivity->get($act) ?? new \App\Models\ProjectPhysicalProgress(['activity'=>$act,'total_scope'=>0,'achieved'=>0,'balance'=>0,'progress_pct'=>0]); @endphp
                                <tr>
                                    <td><input type="text" name="physical[{{ $i }}][activity]" class="form-control form-control-sm" value="{{ old("physical.$i.activity", $row->activity) }}"></td>
                                    <td><input type="number" step="0.01" name="physical[{{ $i }}][total_scope]" class="form-control form-control-sm" value="{{ old("physical.$i.total_scope", $row->total_scope) }}" style="width:80px"></td>
                                    <td><input type="number" step="0.01" name="physical[{{ $i }}][achieved]" class="form-control form-control-sm" value="{{ old("physical.$i.achieved", $row->achieved) }}" style="width:80px"></td>
                                    <td><input type="number" step="0.01" name="physical[{{ $i }}][balance]" class="form-control form-control-sm" value="{{ old("physical.$i.balance", $row->balance) }}" style="width:80px"></td>
                                    <td><input type="number" step="0.01" name="physical[{{ $i }}][progress_pct]" class="form-control form-control-sm" value="{{ old("physical.$i.progress_pct", $row->progress_pct) }}" style="width:70px"></td>
                                    <td><input type="text" name="physical[{{ $i }}][unit]" class="form-control form-control-sm" value="{{ old("physical.$i.unit", $row->unit) }}" placeholder="km/Nos" style="width:60px"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- C. Financial --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>C. Financial Progress</strong></div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-2"><label class="form-label small">Expenditure till Date (₹ Cr)</label><input type="number" step="0.01" name="expenditure_till_date" class="form-control form-control-sm" value="{{ old('expenditure_till_date', $project->expenditure_till_date) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Billing Pending</label><input type="number" step="0.01" name="billing_pending" class="form-control form-control-sm" value="{{ old('billing_pending', $project->billing_pending) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Cost Overrun</label><input type="number" step="0.01" name="cost_overrun" class="form-control form-control-sm" value="{{ old('cost_overrun', $project->cost_overrun) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Financial Health</label><input type="text" name="financial_health" class="form-control form-control-sm" value="{{ old('financial_health', $project->financial_health) }}" placeholder="Normal/Watch/Concern"></div>
                </div>
            </div>
        </div>

        {{-- D. Clearances --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>D. RoW & Clearance Status</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Clearance Type</th><th>Total</th><th>Obtained</th><th>Pending</th><th>Remarks</th></tr></thead>
                    <tbody>
                        @php $clearTypes = ['RoW Cases','Forest Clearance','Railway Crossing','Highway/River Crossing']; $clears = $project->clearances->keyBy('clearance_type'); @endphp
                        @foreach($clearTypes as $j => $ct)
                            @php $c = $clears->get($ct) ?? new \App\Models\ProjectClearance(['clearance_type'=>$ct,'total'=>0,'obtained'=>0,'pending'=>0]); @endphp
                            <tr>
                                <td><input type="text" name="clearances[{{ $j }}][clearance_type]" class="form-control form-control-sm" value="{{ old("clearances.$j.clearance_type", $c->clearance_type) }}"></td>
                                <td><input type="number" name="clearances[{{ $j }}][total]" class="form-control form-control-sm" value="{{ old("clearances.$j.total", $c->total) }}" style="width:70px"></td>
                                <td><input type="number" name="clearances[{{ $j }}][obtained]" class="form-control form-control-sm" value="{{ old("clearances.$j.obtained", $c->obtained) }}" style="width:70px"></td>
                                <td><input type="number" name="clearances[{{ $j }}][pending]" class="form-control form-control-sm" value="{{ old("clearances.$j.pending", $c->pending) }}" style="width:70px"></td>
                                <td><input type="text" name="clearances[{{ $j }}][remarks]" class="form-control form-control-sm" value="{{ old("clearances.$j.remarks", $c->remarks) }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-2"><strong>Key Bottleneck Locations</strong></div>
                @for($b = 0; $b < 3; $b++)
                    @php $bot = $project->bottlenecks->get($b) ?? new \App\Models\ProjectBottleneck(['location'=>'','issue_summary'=>'']); @endphp
                    <div class="row g-2 p-2">
                        <div class="col-md-4"><input type="text" name="bottlenecks[{{ $b }}][location]" class="form-control form-control-sm" value="{{ old("bottlenecks.$b.location", $bot->location) }}" placeholder="Village/Taluka/District"></div>
                        <div class="col-md-8"><input type="text" name="bottlenecks[{{ $b }}][issue_summary]" class="form-control form-control-sm" value="{{ old("bottlenecks.$b.issue_summary", $bot->issue_summary) }}" placeholder="Issue summary"></div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- E. Milestones --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>E. Schedule Monitoring</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Milestone</th><th>Planned Date</th><th>Actual Date</th><th>Status</th><th>Variance (Days)</th></tr></thead>
                    <tbody>
                        @php $mileNames = ['Foundation Completion','Erection Completion','Stringing Completion','Line Charging']; $miles = $project->milestones->values(); @endphp
                        @foreach($mileNames as $k => $mn)
                            @php $m = $miles->get($k) ?? new \App\Models\ProjectMilestone(['milestone_name'=>$mn]); @endphp
                            <tr>
                                <td><input type="text" name="milestones[{{ $k }}][milestone_name]" class="form-control form-control-sm" value="{{ old("milestones.$k.milestone_name", $m->milestone_name) }}"></td>
                                <td><input type="date" name="milestones[{{ $k }}][planned_date]" class="form-control form-control-sm" value="{{ old("milestones.$k.planned_date", $m->planned_date?->format('Y-m-d')) }}"></td>
                                <td><input type="date" name="milestones[{{ $k }}][actual_date]" class="form-control form-control-sm" value="{{ old("milestones.$k.actual_date", $m->actual_date?->format('Y-m-d')) }}"></td>
                                <td><select name="milestones[{{ $k }}][status]" class="form-select form-select-sm"><option value="">—</option><option value="On Track" {{ old("milestones.$k.status", $m->status) === 'On Track' ? 'selected' : '' }}>On Track</option><option value="Delayed" {{ old("milestones.$k.status", $m->status) === 'Delayed' ? 'selected' : '' }}>Delayed</option></select></td>
                                <td><input type="number" name="milestones[{{ $k }}][schedule_variance_days]" class="form-control form-control-sm" value="{{ old("milestones.$k.schedule_variance_days", $m->schedule_variance_days) }}" placeholder="+/-" style="width:80px"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- F. Risks (Top 5) --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>F. Risk & Issues Tracker (Top 5)</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Issue</th><th>Impact</th><th>Responsibility</th><th>Action Plan</th><th>Target Date</th></tr></thead>
                    <tbody>
                        @for($r = 0; $r < 5; $r++)
                            @php $risk = $project->risks->get($r) ?? new \App\Models\ProjectRisk(['issue'=>'','impact'=>'','responsibility'=>'','action_plan'=>'','target_date'=>null]); @endphp
                            <tr>
                                <td><input type="text" name="risks[{{ $r }}][issue]" class="form-control form-control-sm" value="{{ old("risks.$r.issue", $risk->issue) }}"></td>
                                <td><input type="text" name="risks[{{ $r }}][impact]" class="form-control form-control-sm" value="{{ old("risks.$r.impact", $risk->impact) }}" placeholder="High/Medium"></td>
                                <td><input type="text" name="risks[{{ $r }}][responsibility]" class="form-control form-control-sm" value="{{ old("risks.$r.responsibility", $risk->responsibility) }}"></td>
                                <td><input type="text" name="risks[{{ $r }}][action_plan]" class="form-control form-control-sm" value="{{ old("risks.$r.action_plan", $risk->action_plan) }}"></td>
                                <td><input type="date" name="risks[{{ $r }}][target_date]" class="form-control form-control-sm" value="{{ old("risks.$r.target_date", $risk->target_date?->format('Y-m-d')) }}"></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        {{-- G. Manpower --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>G. Manpower & Contractor Performance</strong></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light"><tr><th>Parameter</th><th>Status</th></tr></thead>
                    <tbody>
                        @php $manParams = ['Manpower Deployment','Equipment Availability','Contractor Performance','Safety Compliance']; $manP = $project->manpower->keyBy('parameter'); @endphp
                        @foreach($manParams as $mpi => $param)
                            @php $mp = $manP->get($param) ?? new \App\Models\ProjectManpower(['parameter'=>$param,'status'=>'']); @endphp
                            <tr>
                                <td><input type="text" name="manpower[{{ $mpi }}][parameter]" class="form-control form-control-sm" value="{{ old("manpower.$mpi.parameter", $mp->parameter) }}"></td>
                                <td><input type="text" name="manpower[{{ $mpi }}][status]" class="form-control form-control-sm" value="{{ old("manpower.$mpi.status", $mp->status) }}" placeholder="Adequate/Satisfactory etc."></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- H. Decisions --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>H. Key Decisions Required</strong></div>
            <div class="card-body">
                @for($d = 0; $d < 5; $d++)
                    @php $dec = $project->decisions->get($d) ?? new \App\Models\ProjectDecision(['decision_text'=>'']); @endphp
                    <div class="mb-2"><input type="text" name="decisions[{{ $d }}][decision_text]" class="form-control form-control-sm" value="{{ old("decisions.$d.decision_text", $dec->decision_text) }}" placeholder="Decision {{ $d+1 }}"></div>
                @endfor
            </div>
        </div>

        {{-- I. Expected Progress --}}
        <div class="card crm-card mb-3">
            <div class="card-header bg-white"><strong>I. Expected Progress Next Review</strong></div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-md-2"><label class="form-label small">Foundation (Nos)</label><input type="number" name="expected_foundation_nos" class="form-control form-control-sm" value="{{ old('expected_foundation_nos', $project->expected_foundation_nos) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Erection (Nos)</label><input type="number" name="expected_erection_nos" class="form-control form-control-sm" value="{{ old('expected_erection_nos', $project->expected_erection_nos) }}"></div>
                    <div class="col-md-2"><label class="form-label small">Stringing (km)</label><input type="number" step="0.01" name="expected_stringing_km" class="form-control form-control-sm" value="{{ old('expected_stringing_km', $project->expected_stringing_km) }}"></div>
                    <div class="col-md-3"><label class="form-label small">Clearance Expected</label><input type="text" name="clearance_expected" class="form-control form-control-sm" value="{{ old('clearance_expected', $project->clearance_expected) }}"></div>
                </div>
            </div>
        </div>

        {{-- J. Summary --}}
        <div class="card crm-card mb-4">
            <div class="card-header bg-white"><strong>J. Summary for Management</strong></div>
            <div class="card-body">
                <textarea name="summary_text" class="form-control" rows="3" placeholder="Project is ___% complete with critical dependency on ___. With timely intervention...">{{ old('summary_text', $project->summary_text) }}</textarea>
            </div>
        </div>

        <div class="d-flex gap-2 mb-4">
            <button type="submit" class="btn btn-primary">Save Progress Review</button>
            <a href="{{ route('projects.progress.show', $project) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
@endsection
