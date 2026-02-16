<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $projectsQuery = Project::query()->visibleBy($user);
        $totalProjects = (clone $projectsQuery)->count();
        $activeProjects = (clone $projectsQuery)->where('status', ProjectStatus::Active)->count();
        $projectsByStatus = (clone $projectsQuery)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $tasksQuery = Task::query()->visibleBy($user);
        $totalTasks = (clone $tasksQuery)->count();
        $tasksByStatus = (clone $tasksQuery)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        $tasksByPriority = (clone $tasksQuery)
            ->selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        $recentProjects = (clone $projectsQuery)
            ->with('projectManager')
            ->latest()
            ->limit(5)
            ->get();

        $projectsPerMonth = (clone $projectsQuery)
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, count(*) as count')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $totalUsers = User::count();
        $rolesWithUserCount = Role::withCount('users')->orderBy('name')->get();
        $usersByRole = $rolesWithUserCount->mapWithKeys(fn ($role) => [$role->name => $role->users_count]);

        return view('dashboard', [
            'totalProjects' => $totalProjects,
            'activeProjects' => $activeProjects,
            'projectsByStatus' => $projectsByStatus,
            'totalTasks' => $totalTasks,
            'tasksByStatus' => $tasksByStatus,
            'tasksByPriority' => $tasksByPriority,
            'recentProjects' => $recentProjects,
            'projectsPerMonth' => $projectsPerMonth,
            'totalUsers' => $totalUsers,
            'usersByRole' => $usersByRole,
            'rolesWithUserCount' => $rolesWithUserCount,
        ]);
    }
}
