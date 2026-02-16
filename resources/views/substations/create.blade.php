@extends('layouts.app')

@section('title', 'Create Sub Station')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('substations.index') }}" class="text-decoration-none">Sub Station</a></li>
            <li class="breadcrumb-item active">Create Sub Station</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Create Sub Station</h1>
        <p class="text-muted mb-0">Select zone → circle loads; select circle → division loads.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('substations.store') }}" id="substationForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Sub station name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="zone_id" class="form-label">Zone</label>
                    <select name="zone_id" id="zone_id" required class="form-select @error('zone_id') is-invalid @enderror">
                        <option value="">Select zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="circle_id" class="form-label">Circle</label>
                    <select name="circle_id" id="circle_id" required class="form-select @error('circle_id') is-invalid @enderror">
                        <option value="">Select zone first</option>
                    </select>
                    @error('circle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="division_id" class="form-label">Division</label>
                    <select name="division_id" id="division_id" required class="form-select @error('division_id') is-invalid @enderror">
                        <option value="">Select circle first</option>
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Sub Station</button>
                    <a href="{{ route('substations.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
            var circlesByZoneUrl = '{{ route("circles.by-zone") }}';
            var divisionsByCircleUrl = '{{ route("divisions.by-circle") }}';
            var oldCircleId = '{{ old("circle_id") }}';
            var oldDivisionId = '{{ old("division_id") }}';

            function loadCircles(zoneId, selectCircleId, thenLoadDivisions) {
                circleSelect.html('<option value="">Loading...</option>').prop('disabled', true);
                divisionSelect.html('<option value="">Select circle first</option>').prop('disabled', true);
                if (!zoneId) {
                    circleSelect.html('<option value="">Select zone first</option>').prop('disabled', false);
                    return;
                }
                $.get(circlesByZoneUrl, { zone_id: zoneId })
                    .done(function(circles) {
                        circleSelect.empty().append('<option value="">Select circle</option>');
                        circles.forEach(function(c) {
                            circleSelect.append($('<option></option>').val(c.id).text(c.name));
                        });
                        if (selectCircleId) circleSelect.val(selectCircleId);
                        circleSelect.prop('disabled', false);
                        if (thenLoadDivisions && circleSelect.val()) {
                            loadDivisions(circleSelect.val(), oldDivisionId);
                        }
                    })
                    .fail(function() {
                        circleSelect.html('<option value="">Error loading circles</option>').prop('disabled', false);
                    });
            }

            function loadDivisions(circleId, selectDivisionId) {
                divisionSelect.html('<option value="">Loading...</option>').prop('disabled', true);
                if (!circleId) {
                    divisionSelect.html('<option value="">Select circle first</option>').prop('disabled', false);
                    return;
                }
                $.get(divisionsByCircleUrl, { circle_id: circleId })
                    .done(function(divisions) {
                        divisionSelect.empty().append('<option value="">Select division</option>');
                        divisions.forEach(function(d) {
                            divisionSelect.append($('<option></option>').val(d.id).text(d.name));
                        });
                        if (selectDivisionId) divisionSelect.val(selectDivisionId);
                        divisionSelect.prop('disabled', false);
                    })
                    .fail(function() {
                        divisionSelect.html('<option value="">Error loading divisions</option>').prop('disabled', false);
                    });
            }

            zoneSelect.on('change', function() {
                loadCircles($(this).val(), null, false);
            });
            circleSelect.on('change', function() {
                loadDivisions($(this).val(), null);
            });

            if (zoneSelect.val()) {
                loadCircles(zoneSelect.val(), oldCircleId || null, true);
            }
        });
    </script>
    @endpush
@endsection
