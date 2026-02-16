@extends('layouts.app')

@section('title', 'Role & Permission Management')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active">Role & Permissions</li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h2">Role & Permission Management</h1>
            <p class="text-muted mb-0">Manage roles and their permissions.</p>
        </div>
        @can('manage-roles')
            <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
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
                <table id="rolesTable" class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Role</th>
                            <th>Users</th>
                            <th>Permissions</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="fw-semibold">{{ $role->name }}</td>
                                <td><span class="badge bg-secondary rounded-pill">{{ $role->users_count }}</span></td>
                                <td>
                                    @if($role->permissions->isEmpty())
                                        <span class="text-muted">—</span>
                                    @else
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($role->permissions as $perm)
                                                <span class="badge bg-primary text-wrap">{{ $perm->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @can('manage-roles')
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary btn-sm">Edit permissions</a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function() {
            $('#rolesTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 10,
                language: { search: '', searchPlaceholder: 'Search roles...' }
            });
        });
    </script>
    @endpush
@endsection
