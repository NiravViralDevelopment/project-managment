@extends('layouts.app')

@section('title', 'Edit Role Permissions')

@section('content')
    <div class="mb-4">
        <a href="{{ route('roles.index') }}" class="btn btn-link btn-sm text-decoration-none p-0">← Back to roles</a>
        <h1 class="h2 mt-2">Edit Role: {{ $role->name }}</h1>
        <p class="text-muted mb-0">Select permissions for this role.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @csrf
                @method('PUT')
                <div class="row g-2">
                    @foreach($permissions as $permission)
                        <div class="col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="perm-{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} class="form-check-input">
                                <label for="perm-{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($permissions->isEmpty())
                    <p class="text-muted mb-0">No permissions defined.</p>
                @endif
                <hr>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update permissions</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
