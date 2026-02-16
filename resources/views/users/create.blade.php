@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">User Management</a></li>
            <li class="breadcrumb-item active">Create User</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Create User</h1>
        <p class="text-muted mb-0">Add a new user. Assign zone → circle → division → substation (user chain).</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}" id="userForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" required class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control">
                </div>
                <div class="mb-3">
                    <label for="zone_id" class="form-label">Zone</label>
                    <select name="zone_id" id="zone_id" class="form-select @error('zone_id') is-invalid @enderror">
                        <option value="">— Select zone (optional) —</option>
                        @foreach($zones as $z)
                            <option value="{{ $z->id }}" {{ old('zone_id') == $z->id ? 'selected' : '' }}>{{ $z->name }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="circle_id" class="form-label">Circle</label>
                    <select name="circle_id" id="circle_id" class="form-select @error('circle_id') is-invalid @enderror">
                        <option value="">— Select zone first —</option>
                    </select>
                    @error('circle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="division_id" class="form-label">Division</label>
                    <select name="division_id" id="division_id" class="form-select @error('division_id') is-invalid @enderror">
                        <option value="">— Select circle first —</option>
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="substation_id" class="form-label">Sub Station</label>
                    <select name="substation_id" id="substation_id" class="form-select @error('substation_id') is-invalid @enderror">
                        <option value="">— Select division first —</option>
                    </select>
                    @error('substation_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" required class="form-select @error('role') is-invalid @enderror">
                        @foreach($roles as $r)
                            <option value="{{ $r->name }}" {{ old('role') === $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                        @endforeach
                    </select>
                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            var zoneSelect = $('#zone_id');
            var circleSelect = $('#circle_id');
            var divisionSelect = $('#division_id');
            var substationSelect = $('#substation_id');
            var circlesByZoneUrl = '{{ route("circles.by-zone") }}';
            var divisionsByCircleUrl = '{{ route("divisions.by-circle") }}';
            var substationsByDivisionUrl = '{{ route("substations.by-division") }}';
            var oldCircleId = '{{ old("circle_id") }}';
            var oldDivisionId = '{{ old("division_id") }}';
            var oldSubstationId = '{{ old("substation_id") }}';

            function loadCircles(zoneId, selectCircleId, thenDivision, thenSubstation) {
                circleSelect.html('<option value="">— Select zone first —</option>').prop('disabled', !zoneId);
                divisionSelect.html('<option value="">— Select circle first —</option>').prop('disabled', true);
                substationSelect.html('<option value="">— Select division first —</option>').prop('disabled', true);
                if (!zoneId) return;
                circleSelect.html('<option value="">Loading...</option>');
                $.get(circlesByZoneUrl, { zone_id: zoneId }).done(function(circles) {
                    circleSelect.empty().append('<option value="">— Select circle (optional) —</option>');
                    circles.forEach(function(c) { circleSelect.append($('<option></option>').val(c.id).text(c.name)); });
                    if (selectCircleId) circleSelect.val(selectCircleId);
                    circleSelect.prop('disabled', false);
                    if (thenDivision && circleSelect.val()) loadDivisions(circleSelect.val(), oldDivisionId, thenSubstation);
                }).fail(function() { circleSelect.html('<option value="">Error</option>').prop('disabled', false); });
            }
            function loadDivisions(circleId, selectDivisionId, thenSubstation) {
                divisionSelect.html('<option value="">Loading...</option>').prop('disabled', true);
                substationSelect.html('<option value="">— Select division first —</option>').prop('disabled', true);
                if (!circleId) { divisionSelect.html('<option value="">— Select circle first —</option>').prop('disabled', false); return; }
                $.get(divisionsByCircleUrl, { circle_id: circleId }).done(function(divisions) {
                    divisionSelect.empty().append('<option value="">— Select division (optional) —</option>');
                    divisions.forEach(function(d) { divisionSelect.append($('<option></option>').val(d.id).text(d.name)); });
                    if (selectDivisionId) divisionSelect.val(selectDivisionId);
                    divisionSelect.prop('disabled', false);
                    if (thenSubstation && divisionSelect.val()) loadSubstations(divisionSelect.val(), oldSubstationId);
                }).fail(function() { divisionSelect.html('<option value="">Error</option>').prop('disabled', false); });
            }
            function loadSubstations(divisionId, selectSubstationId) {
                substationSelect.html('<option value="">Loading...</option>').prop('disabled', true);
                if (!divisionId) { substationSelect.html('<option value="">— Select division first —</option>').prop('disabled', false); return; }
                $.get(substationsByDivisionUrl, { division_id: divisionId }).done(function(substations) {
                    substationSelect.empty().append('<option value="">— Select sub station (optional) —</option>');
                    substations.forEach(function(s) { substationSelect.append($('<option></option>').val(s.id).text(s.name)); });
                    if (selectSubstationId) substationSelect.val(selectSubstationId);
                    substationSelect.prop('disabled', false);
                }).fail(function() { substationSelect.html('<option value="">Error</option>').prop('disabled', false); });
            }

            zoneSelect.on('change', function() { loadCircles($(this).val(), null, false, false); });
            circleSelect.on('change', function() { loadDivisions($(this).val(), null, false); });
            divisionSelect.on('change', function() { loadSubstations($(this).val(), null); });

            if (zoneSelect.val()) loadCircles(zoneSelect.val(), oldCircleId, true, true);
        });
    </script>
    @endpush
@endsection
