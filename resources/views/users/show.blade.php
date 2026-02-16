@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}" class="text-decoration-none">User Management</a></li>
            <li class="breadcrumb-item active">User Details</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">User Details</h1>
        <p class="text-muted mb-0">{{ $user->name }}</p>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-2"><strong>Zone:</strong> {{ $user->zone?->name ?? '—' }}</p>
            <p class="mb-2"><strong>Circle:</strong> {{ $user->circle?->name ?? '—' }}</p>
            <p class="mb-2"><strong>Division:</strong> {{ $user->division?->name ?? '—' }}</p>
            <p class="mb-2"><strong>Sub Station:</strong> {{ $user->substation?->name ?? '—' }}</p>
            <p class="mb-0"><strong>Role:</strong> {{ $user->roles->pluck('name')->join(', ') ?: '—' }}</p>
            @can('manage-users')
                <hr>
                <a href="{{ route('users.edit', $user) }}" class="btn btn-primary btn-sm">Edit user</a>
            @endcan
        </div>
    </div>
@endsection
