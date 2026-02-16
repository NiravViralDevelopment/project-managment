<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name')) - Project Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --crm-blue: #3c50e0;
            --crm-blue-light: #eef2ff;
            --crm-blue-dark: #2d3a9f;
        }
        body { background: #f1f5f9; }
        .sidebar { width: 260px; min-height: 100vh; background: #fff; border-right: 1px solid #e2e8f0; }
        .sidebar-brand { background: var(--crm-blue); color: #fff; padding: 1rem 1.25rem; font-weight: 700; font-size: 1.15rem; display: flex; align-items: center; gap: 0.5rem; }
        .sidebar-brand i { font-size: 1.5rem; }
        .sidebar .nav-link { color: #64748b; padding: 0.7rem 1.25rem; border-left: 3px solid transparent; display: flex; align-items: center; }
        .sidebar .nav-link:hover { background: var(--crm-blue-light); color: var(--crm-blue); }
        .sidebar .nav-link.active { background: var(--crm-blue-light); color: var(--crm-blue); border-left-color: var(--crm-blue); font-weight: 500; }
        .sidebar .nav-link i { font-size: 1.1rem; opacity: 0.9; }
        .sidebar .menu-label { padding: 0.5rem 1.25rem; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; }
        .topbar { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 0.75rem 1.5rem; }
        .topbar .search-wrap { max-width: 320px; }
        .topbar .search-wrap .form-control { border-radius: 8px; padding-left: 2.5rem; background: #f8fafc; border-color: #e2e8f0; }
        .topbar .search-wrap .search-icon { left: 0.75rem; color: #94a3b8; }
        .main-content { background: #f1f5f9; min-height: 100vh; padding: 1.5rem; }
        .crm-card { background: #fff; border: none; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); }
        .crm-card .card-body { padding: 1.25rem; }
        .crm-kpi { border-radius: 10px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.25rem; }
        .crm-kpi .crm-kpi-value { font-size: 1.75rem; font-weight: 700; color: #1e293b; }
        .crm-kpi .crm-kpi-label { font-size: 0.8rem; color: #64748b; font-weight: 500; }
        .crm-kpi .crm-kpi-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--crm-blue); background: var(--crm-blue-light); }
        .crm-progress-ring { width: 120px; height: 120px; }
        .toast-container { z-index: 1090; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <aside class="sidebar flex-shrink-0 d-flex flex-column">
            <div class="sidebar-brand">
                <i class="bi bi-bar-chart-fill"></i>
                <span>{{ config('app.name') }}</span>
            </div>
            <div class="py-2 flex-grow-1">
                <div class="menu-label">Menu</div>
                <nav class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2 me-2"></i>Dashboard
                    </a>
                    @if(auth()->user()->can('manage-users') || auth()->user()->hasRole('Admin'))
                        <div class="menu-label">User Management</div>
                        @can('manage-users')
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                <i class="bi bi-people me-2"></i>User list
                            </a>
                        @endcan
                        @role('Admin')
                            <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                                <i class="bi bi-shield-lock me-2"></i>Role & Permissions
                            </a>
                        @endrole
                    @endif
                    @can('manage-zones')
                        <div class="menu-label">Zone</div>
                        <a href="{{ route('zones.index') }}" class="nav-link {{ request()->routeIs('zones.*') ? 'active' : '' }}">
                            <i class="bi bi-geo-alt me-2"></i>Zone list
                        </a>
                    @endcan
                    @can('manage-circles')
                        <div class="menu-label">Circle</div>
                        <a href="{{ route('circles.index') }}" class="nav-link {{ request()->routeIs('circles.*') ? 'active' : '' }}">
                            <i class="bi bi-circle me-2"></i>Circle list
                        </a>
                    @endcan
                    @can('manage-divisions')
                        <div class="menu-label">Division</div>
                        <a href="{{ route('divisions.index') }}" class="nav-link {{ request()->routeIs('divisions.*') ? 'active' : '' }}">
                            <i class="bi bi-diagram-3 me-2"></i>Division list
                        </a>
                    @endcan
                    @can('manage-substations')
                        <div class="menu-label">Sub Station</div>
                        <a href="{{ route('substations.index') }}" class="nav-link {{ request()->routeIs('substations.*') ? 'active' : '' }}">
                            <i class="bi bi-lightning-charge me-2"></i>Sub Station list
                        </a>
                    @endcan
                    @can('view-projects')
                        <div class="menu-label">Project</div>
                        <a href="{{ route('projects.index') }}" class="nav-link {{ request()->routeIs('projects.index') || request()->routeIs('projects.show') || request()->routeIs('projects.progress.*') ? 'active' : '' }}">
                            <i class="bi bi-folder2-open me-2"></i>Project list
                        </a>
                        @can('create-projects')
                            <a href="{{ route('projects.create') }}" class="nav-link {{ request()->routeIs('projects.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-circle me-2"></i>Create Project
                            </a>
                        @endcan
                    @endcan
                </nav>
            </div>
            <div class="p-3 border-top border-light">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </aside>
        <div class="flex-grow-1 d-flex flex-column min-vh-100">
            <header class="topbar d-flex align-items-center gap-3">
                <button class="btn btn-link text-body d-lg-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="search-wrap position-relative flex-grow-1">
                    <i class="bi bi-search position-absolute search-icon top-50 translate-middle-y"></i>
                    <input type="text" class="form-control form-control-sm" placeholder="Search or type command..." readonly>
                </div>
                <button class="btn btn-light btn-sm position-relative p-2" type="button" title="Notifications">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.5rem;">1</span>
                </button>
                <div class="dropdown ms-auto">
                    <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:0.85rem;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><span class="dropdown-item-text small text-muted">{{ auth()->user()->email }}</span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </header>
            <main class="main-content flex-grow-1">
                @yield('content')
            </main>
        </div>
    </div>

    @if(session('success') || session('status') || session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="flashToast" class="toast align-items-center text-bg-{{ session('error') ? 'danger' : 'success' }} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-{{ session('error') ? 'exclamation-circle' : 'check-circle' }} me-2"></i>
                    {{ session('success') ?? session('status') ?? session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('flashToast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl, { delay: 4000, autohide: true });
                toast.show();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
