<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $allPermission = Permission::firstOrCreate([
            'name' => 'all',
            'guard_name' => 'web',
        ]);
        $readPermission = Permission::firstOrCreate([
            'name' => 'read',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
            'status' => 'active',
        ]);
        $admin->syncPermissions(Permission::all());


        $user = Role::firstOrCreate([
            'name' => 'User',
            'guard_name' => 'web',
            'status' => 'active',
        ]);
        $user->syncPermissions([$readPermission]);
    }
}
