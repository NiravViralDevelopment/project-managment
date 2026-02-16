<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Substation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $query = Project::query()
            ->with(['projectManager', 'substation.users', 'substation.zone', 'substation.circle', 'substation.division'])
            ->visibleBy($user);
        $projects = $query->latest()->get();
        $projects = $projects->sortByDesc('created_at')->values();

        return view('projects.index', compact('projects'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        $substations = Substation::with(['zone', 'circle', 'division'])->orderBy('name')->get();

        return view('projects.create', compact('users', 'substations'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('members');
        $project = Project::create($data);
        if ($request->filled('members')) {
            $project->members()->sync($request->validated('members'));
        }

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project): View
    {
        $this->authorizeView($project);
        $project->load('projectManager', 'members', 'tasks');

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $this->authorizeView($project);
        $project->load('members', 'substation');
        $users = User::orderBy('name')->get();
        $substations = Substation::with(['zone', 'circle', 'division'])->orderBy('name')->get();

        return view('projects.edit', compact('project', 'users', 'substations'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorizeView($project);
        $data = $request->safe()->except('members');
        $project->update($data);
        $project->members()->sync($request->validated('members', []));

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorizeView($project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    private function authorizeView(Project $project): void
    {
        $user = auth()->user();
        if ($user->hasRole('Admin')) {
            return;
        }
        $visible = Project::query()->visibleBy($user)->where('id', $project->id)->exists();
        if (! $visible) {
            abort(403, 'You do not have access to this project.');
        }
    }
}
