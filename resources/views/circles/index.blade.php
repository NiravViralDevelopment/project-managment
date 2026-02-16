@extends('layouts.app')

@section('title', 'Circle Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Circle</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Circle</h1>
            <p class="text-muted mb-0">Create and manage circles by zone.</p>
        </div>
        @can('manage-circles')
            <a href="{{ route('circles.create') }}" class="btn btn-primary">Add Circle</a>
        @endcan
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="circlesTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Zone</th>
                            @can('manage-circles')
                                <th class="text-end">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($circles as $circle)
                            <tr>
                                <td class="fw-semibold">{{ $circle->name }}</td>
                                <td>{{ $circle->zone?->name ?? '—' }}</td>
                                @can('manage-circles')
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('circles.edit', $circle) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('circles.destroy', $circle) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this circle?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->can('manage-circles') ? 3 : 2 }}" class="text-center text-muted py-4">No circles found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            @if($circles->count() > 0)
            $('#circlesTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search circles...' }
            });
            @endif
        });
    </script>
    @endpush
@endsection
