@extends('layouts.app')

@section('title', 'Zone Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Zone</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Zone</h1>
            <p class="text-muted mb-0">Create and manage zones.</p>
        </div>
        @can('manage-zones')
            <a href="{{ route('zones.create') }}" class="btn btn-primary">Add Zone</a>
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
                <table id="zonesTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            @can('manage-zones')
                                <th class="text-end">Actions</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($zones as $zone)
                            <tr>
                                <td class="fw-semibold">{{ $zone->name }}</td>
                                @can('manage-zones')
                                    <td class="text-end">
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="{{ route('zones.edit', $zone) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('zones.destroy', $zone) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this zone?');">
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
                                <td colspan="{{ auth()->user()->can('manage-zones') ? 2 : 1 }}" class="text-center text-muted py-4">No zones found.</td>
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
            @if($zones->count() > 0)
            $('#zonesTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search zones...' }
            });
            @endif
        });
    </script>
    @endpush
@endsection
