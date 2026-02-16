@extends('layouts.app')

@section('title', 'Sub Station Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Sub Station</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Sub Station</h1>
            <p class="text-muted mb-0">Create and manage sub stations by zone, circle and division.</p>
        </div>
        @can('manage-substations')
            <a href="{{ route('substations.create') }}" class="btn btn-primary">Add Sub Station</a>
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
                <table id="substationsTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Zone</th>
                            <th>Circle</th>
                            <th>Division</th>
                            @can('manage-substations')
                                <th class="text-end">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($substations as $substation)
                            <tr>
                                <td class="fw-semibold">{{ $substation->name }}</td>
                                <td>{{ $substation->zone?->name ?? '—' }}</td>
                                <td>{{ $substation->circle?->name ?? '—' }}</td>
                                <td>{{ $substation->division?->name ?? '—' }}</td>
                                @can('manage-substations')
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('substations.edit', $substation) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('substations.destroy', $substation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this sub station?');">
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
                                <td colspan="{{ auth()->user()->can('manage-substations') ? 5 : 4 }}" class="text-center text-muted py-4">No sub stations found.</td>
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
            @if($substations->count() > 0)
            $('#substationsTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search sub stations...' }
            });
            @endif
        });
    </script>
    @endpush
@endsection
