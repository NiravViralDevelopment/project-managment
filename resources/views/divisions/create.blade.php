@extends('layouts.app')

@section('title', 'Create Division')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}" class="text-decoration-none">Division</a></li>
            <li class="breadcrumb-item active">Create Division</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Create Division</h1>
        <p class="text-muted mb-0">Add a new division. Select zone first, then circle will load.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('divisions.store') }}" id="divisionForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Division name">
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
                <div class="mb-4">
                    <label for="circle_id" class="form-label">Circle</label>
                    <select name="circle_id" id="circle_id" required class="form-select @error('circle_id') is-invalid @enderror">
                        <option value="">Select zone first</option>
                    </select>
                    @error('circle_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Division</button>
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
            var oldCircleId = '{{ old("circle_id") }}';

            function loadCircles(zoneId, selectCircleId) {
                circleSelect.html('<option value="">Loading...</option>').prop('disabled', true);
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
                loadCircles(zoneSelect.val(), oldCircleId || null);
            }
        });
    </script>
    @endpush
@endsection
