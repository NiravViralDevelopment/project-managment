@extends('layouts.app')

@section('title', 'Division Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('divisions.index') }}" class="text-decoration-none">Division</a></li>
            <li class="breadcrumb-item active">Division Details</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Division Details</h1>
        <p class="text-muted mb-0">{{ $division->name }}</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-1"><strong>Name:</strong> {{ $division->name }}</p>
            <p class="mb-1"><strong>Zone:</strong> {{ $division->zone?->name ?? '—' }}</p>
            <p class="mb-0"><strong>Circle:</strong> {{ $division->circle?->name ?? '—' }}</p>
            @can('manage-divisions')
                <hr>
                <a href="{{ route('divisions.edit', $division) }}" class="btn btn-primary btn-sm">Edit Division</a>
            @endcan
        </div>
    </div>
@endsection
