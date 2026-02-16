<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\AuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request): ProjectCollection
    {
        $query = Project::query()
            ->with(['projectManager', 'members'])
            ->visibleBy($request->user());

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $projects = $query->latest()->paginate($request->integer('per_page', 15));

        return new ProjectCollection($projects);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        if (! $request->user()->hasRole(['Admin', 'Project Manager'])) {
            abort(403, 'Only Admin or Project Manager can create projects.');
        }
        $data = $request->safe()->except('member_ids');
        $project = Project::create($data);
        if ($request->filled('member_ids')) {
            $project->members()->sync($request->validated('member_ids'));
        }
        $project->load(['projectManager', 'members']);
        $this->auditService->log('project.created', $project, null, $project->toArray());

        return response()->json([
            'message' => 'Project created successfully.',
            'data' => new ProjectResource($project),
        ], 201);
    }

    public function show(Request $request, Project $project): JsonResponse
    {
        $this->authorizeProjectAccess($request->user(), $project);
        $project->load(['projectManager', 'members', 'tasks.assignee']);

        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $this->authorizeProjectAccess($request->user(), $project);
        $old = $project->toArray();
        $data = $request->safe()->except('member_ids');
        $project->update($data);
        if ($request->has('member_ids')) {
            $project->members()->sync($request->validated('member_ids') ?? []);
        }
        $project->load(['projectManager', 'members']);
        $this->auditService->log('project.updated', $project, $old, $project->toArray());

        return response()->json([
            'message' => 'Project updated successfully.',
            'data' => new ProjectResource($project),
        ]);
    }

    public function destroy(Request $request, Project $project): JsonResponse
    {
        if (! $request->user()->hasRole('Admin')) {
            abort(403, 'Only Admin can delete projects.');
        }
        $project->delete();
        $this->auditService->log('project.deleted', $project, $project->toArray(), null);

        return response()->json(['message' => 'Project deleted successfully.']);
    }

    private function authorizeProjectAccess($user, Project $project): void
    {
        if ($user->hasRole('Admin')) {
            return;
        }
        $isManager = $project->project_manager_id === $user->id;
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        if (! $isManager && ! $isMember) {
            abort(403, 'You do not have access to this project.');
        }
    }
}
