<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = Role::with('permissions')->get();

        return response()->json(['data' => RoleResource::collection($roles)]);
    }

    public function permissions(): JsonResponse
    {
        $permissions = Permission::all();

        return response()->json(['data' => PermissionResource::collection($permissions)]);
    }
}
