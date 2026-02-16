<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Services\AuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request): TaskCollection
    {
        $query = Task::query()
            ->with(['project', 'assignee'])
            ->visibleBy($request->user());

        if ($request->filled('project_id')) {
            $query->where('project_id', $request->integer('project_id'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->string('priority'));
        }
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $tasks = $query->latest()->paginate($request->integer('per_page', 15));

        return new TaskCollection($tasks);
    }

    public function store(StoreTaskRequest $request, Project $project): JsonResponse
    {
        $this->authorizeProjectAccess($request->user(), $project);
        $data = $request->safe()->all();
        $data['project_id'] = $project->id;
        $task = Task::create($data);
        $task->load('assignee');
        $this->auditService->log('task.created', $task, null, $task->toArray());

        return response()->json([
            'message' => 'Task created successfully.',
            'data' => new TaskResource($task),
        ], 201);
    }

    public function show(Request $request, Task $task): JsonResponse
    {
        $this->authorizeTaskAccess($request->user(), $task);
        $task->load(['project', 'assignee', 'comments.user']);

        return response()->json(['data' => new TaskResource($task)]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $this->authorizeTaskAccess($request->user(), $task);
        $old = $task->toArray();
        $task->update($request->safe()->all());
        $task->load('assignee');
        $this->auditService->log('task.updated', $task, $old, $task->toArray());

        return response()->json([
            'message' => 'Task updated successfully.',
            'data' => new TaskResource($task),
        ]);
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        $this->authorizeTaskAccess($request->user(), $task);
        $task->delete();
        $this->auditService->log('task.deleted', $task, $task->toArray(), null);

        return response()->json(['message' => 'Task deleted successfully.']);
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

    private function authorizeTaskAccess($user, Task $task): void
    {
        $project = $task->project;
        if ($user->hasRole('Admin')) {
            return;
        }
        $isManager = $project->project_manager_id === $user->id;
        $isMember = $project->members()->where('users.id', $user->id)->exists();
        $isAssignee = $task->assigned_to === $user->id;
        if (! $isManager && ! $isMember && ! $isAssignee) {
            abort(403, 'You do not have access to this task.');
        }
    }
}
