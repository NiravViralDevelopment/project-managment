<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SyncAdminPermissions extends Command
{
    protected $signature = 'admin:sync-permissions';

    protected $description = 'Give Admin role all permissions and ensure admin user has Admin role (fixes 403 on zones, users, roles)';

    public function handle(): int
    {
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();

        $adminRole = Role::where('name', 'Admin')->where('guard_name', 'web')->first();
        if (! $adminRole) {
            $this->error('Admin role not found. Run: php artisan db:seed --class=RoleAndPermissionSeeder');

            return self::FAILURE;
        }

        $permissions = Permission::where('guard_name', 'web')->pluck('name');
        $adminRole->syncPermissions($permissions);
        $this->info('Admin role now has '.$permissions->count().' permissions.');

        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            if (! $adminUser->hasRole('Admin')) {
                $adminUser->assignRole('Admin');
                $this->info('Assigned Admin role to admin@example.com');
            } else {
                $this->info('admin@example.com already has Admin role.');
            }
        }

        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        $this->info('Permission cache cleared. Log out and log in again, then try /zones.');

        return self::SUCCESS;
    }
}
