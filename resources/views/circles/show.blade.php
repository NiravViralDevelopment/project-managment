@extends('layouts.app')

@section('title', 'Circle Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('circles.index') }}" class="text-decoration-none">Circle</a></li>
            <li class="breadcrumb-item active">Circle Details</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Circle Details</h1>
        <p class="text-muted mb-0">{{ $circle->name }}</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-1"><strong>Name:</strong> {{ $circle->name }}</p>
            <p class="mb-0"><strong>Zone:</strong> {{ $circle->zone?->name ?? '—' }}</p>
            @can('manage-circles')
                <hr>
                <a href="{{ route('circles.edit', $circle) }}" class="btn btn-primary btn-sm">Edit Circle</a>
            @endcan
        </div>
    </div>
@endsection
