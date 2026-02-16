@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Projects</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Projects</h1>
            <p class="text-muted mb-0">View and manage your projects.</p>
        </div>
        @can('create-projects')
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Project
            </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($projects->isEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="bi bi-folder2 text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mb-0 mt-2">No projects yet.</p>
                @can('create-projects')
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm mt-3">Create your first project</a>
                @endcan
            </div>
        </div>
    @else
        <div class="row g-4">
            @foreach($projects as $p)
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 project-card">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 text-dark fw-semibold text-truncate pe-2" title="{{ $p->name }}">{{ $p->name }}</h5>
                                @if($p->status->value === 'Active')
                                    <span class="badge bg-success rounded-pill">Active</span>
                                @elseif($p->status->value === 'Completed')
                                    <span class="badge bg-secondary rounded-pill">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark rounded-pill">On Hold</span>
                                @endif
                            </div>
                            @if($p->description)
                                <p class="card-text small text-muted mb-2 line-clamp-2">{{ Str::limit($p->description, 60) }}</p>
                            @endif
                            <ul class="list-unstyled small mb-3 flex-grow-1">
                                <li class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-person text-primary"></i>
                                    <span class="text-muted">PM:</span>
                                    <span class="text-dark">{{ $p->projectManager?->name ?? '—' }}</span>
                                </li>
                                @if($p->substation)
                                    <li class="mb-1">
                                        <span class="text-muted d-block small">Zone → Circle → Division → Sub Station</span>
                                        <span class="text-dark small fw-medium">{{ $p->substation->zone?->name ?? '—' }} → {{ $p->substation->circle?->name ?? '—' }} → {{ $p->substation->division?->name ?? '—' }} → {{ $p->substation->name }}</span>
                                    </li>
                                    @if($p->substation->users->isNotEmpty())
                                        <li class="d-flex align-items-start gap-2 mb-1">
                                            <i class="bi bi-people text-primary"></i>
                                            <span>
                                                <span class="text-muted small">Assigned users:</span>
                                                <span class="text-dark small">{{ $p->substation->users->pluck('name')->join(', ') }}</span>
                                            </span>
                                        </li>
                                    @endif
                                @else
                                    <li class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-lightning-charge text-primary"></i>
                                        <span class="text-muted">Sub Station:</span>
                                        <span class="text-dark">—</span>
                                    </li>
                                @endif
                                <li class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi bi-calendar-event text-primary"></i>
                                    <span class="text-muted">Deadline:</span>
                                    <span class="text-dark">{{ $p->deadline?->format('M d, Y') ?? '—' }}</span>
                                </li>
                                @if($p->scheduled_date_of_completion)
                                    <li class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-flag text-primary"></i>
                                        <span class="text-muted">Completion:</span>
                                        <span class="text-dark">{{ $p->scheduled_date_of_completion?->format('M d, Y') }}</span>
                                    </li>
                                @endif
                            </ul>
                            <div class="d-flex flex-wrap gap-1 pt-2 border-top">
                                <a href="{{ route('projects.show', $p) }}" class="btn btn-outline-secondary btn-sm">View</a>
                                <a href="{{ route('projects.progress.show', $p) }}" class="btn btn-outline-info btn-sm">Progress</a>
                                @can('edit-projects')
                                    <a href="{{ route('projects.edit', $p) }}" class="btn btn-primary btn-sm">Edit</a>
                                @endcan
                                @can('delete-projects')
                                    <form action="{{ route('projects.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .project-card { border-radius: 12px; transition: box-shadow 0.2s ease, transform 0.2s ease; }
        .project-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.08) !important; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
@endsection
