@extends('layouts.app')

@section('title', 'Sub Station Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('substations.index') }}" class="text-decoration-none">Sub Station</a></li>
            <li class="breadcrumb-item active">Sub Station Details</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Sub Station Details</h1>
        <p class="text-muted mb-0">{{ $substation->name }}</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-1"><strong>Name:</strong> {{ $substation->name }}</p>
            <p class="mb-1"><strong>Zone:</strong> {{ $substation->zone?->name ?? '—' }}</p>
            <p class="mb-1"><strong>Circle:</strong> {{ $substation->circle?->name ?? '—' }}</p>
            <p class="mb-0"><strong>Division:</strong> {{ $substation->division?->name ?? '—' }}</p>
            @can('manage-substations')
                <hr>
                <a href="{{ route('substations.edit', $substation) }}" class="btn btn-primary btn-sm">Edit Sub Station</a>
            @endcan
        </div>
    </div>
@endsection
