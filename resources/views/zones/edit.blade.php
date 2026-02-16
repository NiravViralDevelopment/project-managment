@extends('layouts.app')

@section('title', 'Edit Zone')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('zones.index') }}" class="text-decoration-none">Zone</a></li>
            <li class="breadcrumb-item active">Edit Zone</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Edit Zone</h1>
        <p class="text-muted mb-0">Update zone: {{ $zone->name }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('zones.update', $zone) }}">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $zone->name) }}" required class="form-control @error('name') is-invalid @enderror" placeholder="Zone name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Zone</button>
                    <a href="{{ route('zones.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
