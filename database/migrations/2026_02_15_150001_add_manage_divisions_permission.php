<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permission = Permission::firstOrCreate(
            ['name' => 'manage-divisions', 'guard_name' => 'web']
        );
        $admin = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        if ($admin && ! $admin->hasPermissionTo($permission)) {
            $admin->givePermissionTo($permission);
        }
    }

    public function down(): void
    {
        Permission::where('name', 'manage-divisions')->where('guard_name', 'web')->delete();
    }
};
