<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request): UserCollection
    {
        $query = User::query()->with('roles');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', fn ($q) => $q->where('name', $request->string('role')));
        }

        $users = $query->latest()->paginate($request->integer('per_page', 15));

        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->safe()->except('role');
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user->assignRole($request->validated('role'));

        $this->auditService->log('user.created', $user, null, $user->toArray());

        return response()->json([
            'message' => 'User created successfully.',
            'data' => new UserResource($user->load('roles')),
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        $user->load('roles');

        return response()->json(['data' => new UserResource($user)]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $old = $user->toArray();
        $data = $request->safe()->except('role', 'password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }
        $user->update($data);
        if ($request->has('role')) {
            $user->syncRoles([$request->validated('role')]);
        }

        $this->auditService->log('user.updated', $user, $old, $user->toArray());

        return response()->json([
            'message' => 'User updated successfully.',
            'data' => new UserResource($user->load('roles')),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        $this->auditService->log('user.deleted', $user, $user->toArray(), null);

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
