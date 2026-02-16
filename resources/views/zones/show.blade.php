@extends('layouts.app')

@section('title', 'Zone Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('zones.index') }}" class="text-decoration-none">Zone</a></li>
            <li class="breadcrumb-item active">Zone Details</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Zone Details</h1>
        <p class="text-muted mb-0">{{ $zone->name }}</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-0"><strong>Name:</strong> {{ $zone->name }}</p>
            @can('manage-zones')
                <hr>
                <a href="{{ route('zones.edit', $zone) }}" class="btn btn-primary btn-sm">Edit Zone</a>
            @endcan
        </div>
    </div>
@endsection
