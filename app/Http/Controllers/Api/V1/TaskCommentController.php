<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskCommentRequest;
use App\Http\Resources\TaskCommentResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    public function store(TaskCommentRequest $request, Task $task): JsonResponse
    {
        $user = $request->user();
        $project = $task->project;
        if (! $user->hasRole('Admin')) {
            $isManager = $project->project_manager_id === $user->id;
            $isMember = $project->members()->where('users.id', $user->id)->exists();
            $isAssignee = $task->assigned_to === $user->id;
            if (! $isManager && ! $isMember && ! $isAssignee) {
                abort(403, 'You do not have access to this task.');
            }
        }
        $comment = $task->comments()->create([
            'user_id' => $user->id,
            'comment' => $request->validated('comment'),
        ]);
        $comment->load('user');

        return response()->json([
            'message' => 'Comment added successfully.',
            'data' => new TaskCommentResource($comment),
        ], 201);
    }
}
