@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projects</a></li>
            <li class="breadcrumb-item active">Edit Project</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Edit Project</h1>
        <p class="text-muted mb-0">Update project: {{ $project->name }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('projects.update', $project) }}" id="projectForm">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $project->name) }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Project name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Optional description">{{ old('description', $project->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="substation_id" class="form-label">Sub Station</label>
                    <select name="substation_id" id="substation_id" class="form-select @error('substation_id') is-invalid @enderror">
                        <option value="">— Select Sub Station (optional) —</option>
                        @foreach($substations as $s)
                            <option value="{{ $s->id }}" data-zone="{{ $s->zone?->name }}" data-circle="{{ $s->circle?->name }}" data-division="{{ $s->division?->name }}" {{ old('substation_id', $project->substation_id) == $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->zone?->name ?? '' }} / {{ $s->circle?->name ?? '' }} / {{ $s->division?->name ?? '' }})</option>
                        @endforeach
                    </select>
                    <div id="substationHierarchy" class="small text-muted mt-1" style="display: none;"></div>
                    @error('substation_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="timeline" class="form-label">Timeline</label>
                        <input type="text" name="timeline" id="timeline" value="{{ old('timeline', $project->timeline) }}" class="form-control @error('timeline') is-invalid @enderror" placeholder="e.g. Q1 2026 - Q4 2026">
                        @error('timeline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="scheme" class="form-label">Scheme</label>
                        <input type="text" name="scheme" id="scheme" value="{{ old('scheme', $project->scheme) }}" class="form-control @error('scheme') is-invalid @enderror" placeholder="Scheme name/number">
                        @error('scheme')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date_of_commissioning" class="form-label">Date of Commissioning</label>
                        <input type="date" name="date_of_commissioning" id="date_of_commissioning" value="{{ old('date_of_commissioning', $project->date_of_commissioning?->format('Y-m-d')) }}" class="form-control @error('date_of_commissioning') is-invalid @enderror">
                        @error('date_of_commissioning')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="scheduled_date_of_completion" class="form-label">Scheduled Date of Completion</label>
                        <input type="date" name="scheduled_date_of_completion" id="scheduled_date_of_completion" value="{{ old('scheduled_date_of_completion', $project->scheduled_date_of_completion?->format('Y-m-d')) }}" class="form-control @error('scheduled_date_of_completion') is-invalid @enderror">
                        @error('scheduled_date_of_completion')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="project_cost" class="form-label">Project Cost (₹)</label>
                    <input type="number" name="project_cost" id="project_cost" value="{{ old('project_cost', $project->project_cost) }}" step="0.01" min="0" class="form-control @error('project_cost') is-invalid @enderror" placeholder="0.00">
                    @error('project_cost')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" required class="form-select @error('status') is-invalid @enderror">
                            @foreach(\App\Enums\ProjectStatus::cases() as $s)
                                <option value="{{ $s->value }}" {{ old('status', $project->status->value) === $s->value ? 'selected' : '' }}>{{ $s->value }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" name="deadline" id="deadline" value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" class="form-control @error('deadline') is-invalid @enderror">
                        @error('deadline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="project_manager_id" class="form-label">Project Manager</label>
                    <select name="project_manager_id" id="project_manager_id" class="form-select @error('project_manager_id') is-invalid @enderror">
                        <option value="">— Select (optional) —</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('project_manager_id', $project->project_manager_id) == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Select Sub Station to show only users from that hierarchy.</small>
                    @error('project_manager_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Project</button>
                    <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            var allUsers = @json($users->map(function ($u) { return ['id' => $u->id, 'name' => $u->name, 'email' => $u->email]; })->values());
            var usersBySubstationUrl = '{{ route("users.by-substation") }}';
            var $substation = $('#substation_id');
            var $hierarchy = $('#substationHierarchy');
            var $pm = $('#project_manager_id');

            function setHierarchyText() {
                var opt = $substation.find('option:selected');
                if (opt.val()) {
                    var z = opt.data('zone') || '', c = opt.data('circle') || '', d = opt.data('division') || '';
                    $hierarchy.html('Zone: ' + z + ' → Circle: ' + c + ' → Division: ' + d).show();
                } else {
                    $hierarchy.hide();
                }
            }

            function fillUserDropdowns(users) {
                var list = users && users.length ? users : allUsers;
                var pmVal = $pm.val();
                $pm.find('option:not(:first)').remove();
                list.forEach(function(u) {
                    $pm.append($('<option></option>').val(u.id).text(u.name + ' (' + u.email + ')'));
                });
                if (pmVal && list.some(function(u) { return u.id == pmVal; })) $pm.val(pmVal);
            }

            $substation.on('change', function() {
                setHierarchyText();
                var sid = $(this).val();
                if (!sid) {
                    fillUserDropdowns(allUsers);
                    return;
                }
                $.get(usersBySubstationUrl, { substation_id: sid })
                    .done(function(users) { fillUserDropdowns(users); })
                    .fail(function() { fillUserDropdowns(allUsers); });
            });

            setHierarchyText();
            if ($substation.val()) {
                $.get(usersBySubstationUrl, { substation_id: $substation.val() })
                    .done(function(users) { fillUserDropdowns(users); })
                    .fail(function() { fillUserDropdowns(allUsers); });
            }
        });
    </script>
    @endpush
@endsection
