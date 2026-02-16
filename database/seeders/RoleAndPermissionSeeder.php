<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        Permission::query()->delete();
        Role::query()->delete();

        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-zones',
            'manage-circles',
            'manage-divisions',
            'manage-substations',
            'create-projects',
            'edit-projects',
            'delete-projects',
            'assign-team-members',
            'manage-tasks',
            'view-projects',
            'update-tasks',
        ];

        foreach ($permissions as $name) {
            Permission::create(['name' => $name, 'guard_name' => $guard]);
        }

        $admin = Role::create(['name' => 'Admin', 'guard_name' => $guard]);
        $admin->givePermissionTo(Permission::all());

        $projectManager = Role::create(['name' => 'Project Manager', 'guard_name' => $guard]);
        $projectManager->givePermissionTo([
            'create-projects', 'edit-projects', 'assign-team-members', 'manage-tasks', 'view-projects', 'update-tasks',
        ]);

        $teamMember = Role::create(['name' => 'Team Member', 'guard_name' => $guard]);
        $teamMember->givePermissionTo(['view-projects', 'update-tasks']);
    }
}
