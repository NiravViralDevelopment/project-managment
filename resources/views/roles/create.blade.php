@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" class="text-decoration-none">Role & Permissions</a></li>
            <li class="breadcrumb-item active">Create Role</li>
        </ol>
    </nav>
    <div class="mb-4">
        <h1 class="h2">Create Role</h1>
        <p class="text-muted mb-0">Add a new role and assign permissions.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="form-label">Role name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Editor">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="form-label">Permissions</label>
                    <div class="row g-2">
                        @foreach($permissions as $permission)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                           id="perm-{{ $permission->id }}"
                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}
                                           class="form-check-input">
                                    <label for="perm-{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($permissions->isEmpty())
                        <p class="text-muted small mb-0">No permissions defined.</p>
                    @endif
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Role</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
