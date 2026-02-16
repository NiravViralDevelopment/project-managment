@extends('layouts.app')

@section('title', 'Division Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Division</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Division</h1>
            <p class="text-muted mb-0">Create and manage divisions by zone and circle.</p>
        </div>
        @can('manage-divisions')
            <a href="{{ route('divisions.create') }}" class="btn btn-primary">Add Division</a>
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
                <table id="divisionsTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Zone</th>
                            <th>Circle</th>
                            @can('manage-divisions')
                                <th class="text-end">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($divisions as $division)
                            <tr>
                                <td class="fw-semibold">{{ $division->name }}</td>
                                <td>{{ $division->zone?->name ?? '—' }}</td>
                                <td>{{ $division->circle?->name ?? '—' }}</td>
                                @can('manage-divisions')
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('divisions.edit', $division) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('divisions.destroy', $division) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this division?');">
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
                                <td colspan="{{ auth()->user()->can('manage-divisions') ? 4 : 3 }}" class="text-center text-muted py-4">No divisions found.</td>
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
            @if($divisions->count() > 0)
            $('#divisionsTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search divisions...' }
            });
            @endif
        });
    </script>
    @endpush
@endsection
