<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\Zone;
use App\Services\AuditService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct(
        private AuditService $auditService
    ) {}

    public function index(Request $request): View
    {
        $query = User::query()->with('roles', 'zone', 'circle', 'division', 'substation');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
        }
        if ($request->filled('role')) {
            $query->whereHas('roles', fn ($q) => $q->where('name', $request->string('role')));
        }
        if ($request->filled('zone_id')) {
            $query->where('zone_id', $request->integer('zone_id'));
        }
        if ($request->filled('circle_id')) {
            $query->where('circle_id', $request->integer('circle_id'));
        }
        if ($request->filled('division_id')) {
            $query->where('division_id', $request->integer('division_id'));
        }
        if ($request->filled('substation_id')) {
            $query->where('substation_id', $request->integer('substation_id'));
        }

        $users = $query->latest()->limit(500)->get();
        $roles = Role::orderBy('name')->get();
        $zones = Zone::orderBy('name')->get();
        $circles = $request->filled('zone_id')
            ? \App\Models\Circle::where('zone_id', $request->integer('zone_id'))->orderBy('name')->get()
            : collect();
        $divisions = $request->filled('circle_id')
            ? \App\Models\Division::where('circle_id', $request->integer('circle_id'))->orderBy('name')->get()
            : collect();
        $substations = $request->filled('division_id')
            ? \App\Models\Substation::where('division_id', $request->integer('division_id'))->orderBy('name')->get()
            : collect();

        return view('users.index', compact('users', 'roles', 'zones', 'circles', 'divisions', 'substations'));
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        $zones = Zone::orderBy('name')->get();

        return view('users.create', compact('roles', 'zones'));
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('role');
        $data['password'] = Hash::make($data['password']);
        $data['zone_id'] = $request->validated('zone_id');
        $data['circle_id'] = $request->validated('circle_id');
        $data['division_id'] = $request->validated('division_id');
        $data['substation_id'] = $request->validated('substation_id');
        $user = User::create($data);
        $user->assignRole($request->validated('role'));
        $this->auditService->log('user.created', $user, null, $user->toArray());
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        $user->load('roles', 'zone', 'circle', 'division', 'substation');

        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load('roles');
        $roles = Role::orderBy('name')->get();
        $zones = Zone::orderBy('name')->get();
        $circles = $user->zone_id
            ? \App\Models\Circle::where('zone_id', $user->zone_id)->orderBy('name')->get()
            : collect();
        $divisions = $user->circle_id
            ? \App\Models\Division::where('circle_id', $user->circle_id)->orderBy('name')->get()
            : collect();
        $substations = $user->division_id
            ? \App\Models\Substation::where('division_id', $user->division_id)->orderBy('name')->get()
            : collect();

        return view('users.edit', compact('user', 'roles', 'zones', 'circles', 'divisions', 'substations'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $old = $user->toArray();
        $data = $request->safe()->except('role', 'password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->validated('password'));
        }
        $data['zone_id'] = $request->validated('zone_id');
        $data['circle_id'] = $request->validated('circle_id');
        $data['division_id'] = $request->validated('division_id');
        $data['substation_id'] = $request->validated('substation_id');
        $user->update($data);
        if ($request->has('role')) {
            $user->syncRoles([$request->validated('role')]);
        }
        $this->auditService->log('user.updated', $user, $old, $user->toArray());
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        $this->auditService->log('user.deleted', $user, $user->toArray(), null);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function usersBySubstation(Request $request): JsonResponse
    {
        $substationId = $request->integer('substation_id');
        $users = User::query()
            ->where('substation_id', $substationId)
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
