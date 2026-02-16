@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-decoration-none">Projects</a></li>
            <li class="breadcrumb-item active">Project Details</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Project Details</h1>
            <p class="text-muted mb-0">{{ $project->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('projects.progress.show', $project) }}" class="btn btn-outline-primary">Progress Review</a>
            @can('edit-projects')
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Edit Project</a>
            @endcan
            @can('delete-projects')
                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endcan
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p class="mb-2"><strong>Name:</strong> {{ $project->name }}</p>
            <p class="mb-2"><strong>Status:</strong>
                @if($project->status->value === 'Active')
                    <span class="badge bg-success">{{ $project->status->value }}</span>
                @elseif($project->status->value === 'Completed')
                    <span class="badge bg-secondary">{{ $project->status->value }}</span>
                @else
                    <span class="badge bg-warning text-dark">{{ $project->status->value }}</span>
                @endif
            </p>
            <p class="mb-2"><strong>Deadline:</strong> {{ $project->deadline?->format('M d, Y') ?? '—' }}</p>
            <p class="mb-2"><strong>Project Manager:</strong> {{ $project->projectManager?->name ?? '—' }}</p>
            <p class="mb-2"><strong>Team Members:</strong>
                @if($project->members->isEmpty())
                    —
                @else
                    {{ $project->members->pluck('name')->join(', ') }}
                @endif
            </p>
            @if($project->description)
                <p class="mb-0"><strong>Description:</strong><br>{{ $project->description }}</p>
            @endif
        </div>
    </div>

    @if($project->tasks->isNotEmpty())
        <h5 class="mb-2">Tasks ({{ $project->tasks->count() }})</h5>
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @foreach($project->tasks as $task)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $task->title }}</span>
                            <span class="badge bg-secondary">{{ $task->status->value ?? 'N/A' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection
