@extends('layouts.app')

@section('title', 'Edit Division')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}" class="text-decoration-none">Division</a></li>
            <li class="breadcrumb-item active">Edit Division</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Edit Division</h1>
        <p class="text-muted mb-0">Update division: {{ $division->name }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('divisions.update', $division) }}" id="divisionForm">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $division->name) }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Division name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="zone_id" class="form-label">Zone</label>
                    <select name="zone_id" id="zone_id" required class="form-select @error('zone_id') is-invalid @enderror">
                        <option value="">Select zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', $division->zone_id) == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="circle_id" class="form-label">Circle</label>
                    <select name="circle_id" id="circle_id" required class="form-select @error('circle_id') is-invalid @enderror">
                        <option value="">Select zone first</option>
                        @foreach($circles as $circle)
                            <option value="{{ $circle->id }}" {{ old('circle_id', $division->circle_id) == $circle->id ? 'selected' : '' }}>{{ $circle->name }}</option>
                        @endforeach
                    </select>
                    @error('circle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Division</button>
                    <a href="{{ route('divisions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            var zoneSelect = $('#zone_id');
            var circleSelect = $('#circle_id');
            var circlesByZoneUrl = '{{ route("circles.by-zone") }}';
            var currentCircleId = '{{ old("circle_id", $division->circle_id) }}';

            function loadCircles(zoneId, selectCircleId) {
                if (!zoneId) {
                    circleSelect.html('<option value="">Select zone first</option>');
                    return;
                }
                circleSelect.html('<option value="">Loading...</option>').prop('disabled', true);
                $.get(circlesByZoneUrl, { zone_id: zoneId })
                    .done(function(circles) {
                        circleSelect.empty().append('<option value="">Select circle</option>');
                        circles.forEach(function(c) {
                            circleSelect.append($('<option></option>').val(c.id).text(c.name));
                        });
                        if (selectCircleId) {
                            circleSelect.val(selectCircleId);
                        }
                        circleSelect.prop('disabled', false);
                    })
                    .fail(function() {
                        circleSelect.html('<option value="">Error loading circles</option>').prop('disabled', false);
                    });
            }

            zoneSelect.on('change', function() {
                loadCircles($(this).val(), null);
            });

            if (zoneSelect.val()) {
                loadCircles(zoneSelect.val(), currentCircleId);
            }
        });
    </script>
    @endpush
@endsection
