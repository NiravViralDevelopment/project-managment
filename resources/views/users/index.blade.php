@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">User Management</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">User Management</h1>
            <p class="text-muted mb-0">User chain: filter by Zone → Circle → Division → Sub Station.</p>
        </div>
        @can('manage-users')
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-header py-2">
            <span class="fw-semibold">User chain filter</span>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('users.index') }}" id="userChainFilter" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filter_zone_id" class="form-label small">Zone</label>
                    <select name="zone_id" id="filter_zone_id" class="form-select form-select-sm">
                        <option value="">— All zones —</option>
                        @foreach($zones as $z)
                            <option value="{{ $z->id }}" {{ request('zone_id') == $z->id ? 'selected' : '' }}>{{ $z->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_circle_id" class="form-label small">Circle</label>
                    <select name="circle_id" id="filter_circle_id" class="form-select form-select-sm">
                        <option value="">— All circles —</option>
                        @foreach($circles as $c)
                            <option value="{{ $c->id }}" {{ request('circle_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filter_division_id" class="form-label small">Division</label>
                    <select name="division_id" id="filter_division_id" class="form-select form-select-sm">
                        <option value="">— All divisions —</option>
                        @foreach($divisions as $d)
                            <option value="{{ $d->id }}" {{ request('division_id') == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filter_substation_id" class="form-label small">Sub Station</label>
                    <select name="substation_id" id="filter_substation_id" class="form-select form-select-sm">
                        <option value="">— All —</option>
                        @foreach($substations as $s)
                            <option value="{{ $s->id }}" {{ request('substation_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-sm">Apply</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="usersTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Zone</th>
                            <th>Circle</th>
                            <th>Division</th>
                            <th>Sub Station</th>
                            <th>Role</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td class="fw-semibold">{{ $u->name }}</td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->zone?->name ?? '—' }}</td>
                                <td>{{ $u->circle?->name ?? '—' }}</td>
                                <td>{{ $u->division?->name ?? '—' }}</td>
                                <td>{{ $u->substation?->name ?? '—' }}</td>
                                <td>
                                    @if($u->roles->isEmpty())
                                        <span class="text-muted">—</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($u->roles as $r)
                                                <span class="badge bg-info">{{ $r->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end flex-wrap">
                                        <a href="{{ route('users.show', $u) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                        @can('manage-users')
                                            <a href="{{ route('users.edit', $u) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-muted py-4">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            var circlesByZoneUrl = '{{ route("circles.by-zone") }}';
            var divisionsByCircleUrl = '{{ route("divisions.by-circle") }}';
            var substationsByDivisionUrl = '{{ route("substations.by-division") }}';
            var zoneId = '{{ request("zone_id") }}';
            var circleId = '{{ request("circle_id") }}';
            var divisionId = '{{ request("division_id") }}';

            function loadFilterCircles(zoneId, selectId) {
                if (!zoneId) {
                    $('#filter_circle_id').html('<option value="">— All circles —</option>');
                    $('#filter_division_id').html('<option value="">— All divisions —</option>');
                    $('#filter_substation_id').html('<option value="">— All —</option>');
                    return;
                }
                $.get(circlesByZoneUrl, { zone_id: zoneId }).done(function(circles) {
                    var $sel = $('#filter_circle_id');
                    $sel.empty().append('<option value="">— All circles —</option>');
                    circles.forEach(function(c) { $sel.append($('<option></option>').val(c.id).text(c.name)); });
                    if (selectId) $sel.val(selectId);
                });
            }
            function loadFilterDivisions(circleId, selectId) {
                if (!circleId) {
                    $('#filter_division_id').html('<option value="">— All divisions —</option>');
                    $('#filter_substation_id').html('<option value="">— All —</option>');
                    return;
                }
                $.get(divisionsByCircleUrl, { circle_id: circleId }).done(function(divisions) {
                    var $sel = $('#filter_division_id');
                    $sel.empty().append('<option value="">— All divisions —</option>');
                    divisions.forEach(function(d) { $sel.append($('<option></option>').val(d.id).text(d.name)); });
                    if (selectId) $sel.val(selectId);
                });
            }
            function loadFilterSubstations(divisionId, selectId) {
                if (!divisionId) {
                    $('#filter_substation_id').html('<option value="">— All —</option>');
                    return;
                }
                $.get(substationsByDivisionUrl, { division_id: divisionId }).done(function(substations) {
                    var $sel = $('#filter_substation_id');
                    $sel.empty().append('<option value="">— All —</option>');
                    substations.forEach(function(s) { $sel.append($('<option></option>').val(s.id).text(s.name)); });
                    if (selectId) $sel.val(selectId);
                });
            }

            $('#filter_zone_id').on('change', function() {
                loadFilterCircles($(this).val(), null);
                $('#filter_division_id').html('<option value="">— All divisions —</option>');
                $('#filter_substation_id').html('<option value="">— All —</option>');
            });
            $('#filter_circle_id').on('change', function() {
                loadFilterDivisions($(this).val(), null);
                $('#filter_substation_id').html('<option value="">— All —</option>');
            });
            $('#filter_division_id').on('change', function() {
                loadFilterSubstations($(this).val(), null);
            });

            if (zoneId) loadFilterCircles(zoneId, circleId);
            if (circleId) loadFilterDivisions(circleId, divisionId);
            if (divisionId) loadFilterSubstations(divisionId, '{{ request("substation_id") }}');

            @if($users->count() > 0)
            $('#usersTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search users...' }
            });
            @endif
        });
    </script>
    @endpush
@endsection
