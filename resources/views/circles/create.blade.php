@extends('layouts.app')

@section('title', 'Create Circle')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('circles.index') }}" class="text-decoration-none">Circle</a></li>
            <li class="breadcrumb-item active">Create Circle</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Create Circle</h1>
        <p class="text-muted mb-0">Add a new circle and select its zone.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('circles.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Circle name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="zone_id" class="form-label">Zone</label>
                    <select name="zone_id" id="zone_id" required class="form-select @error('zone_id') is-invalid @enderror">
                        <option value="">Select zone</option>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    @error('zone_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Circle</button>
                    <a href="{{ route('circles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
