<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::where('guard_name', 'web')->pluck('name'));
        }

        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser && $adminRole && ! $adminUser->hasRole('Admin')) {
            $adminUser->assignRole('Admin');
        }
    }

    public function down(): void
    {
        //
    }
};
