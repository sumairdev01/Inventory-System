<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Permissions
        $permissions = [
            'manage inventory',
            'view sales',
            'add sale',
            'delete sale',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Create Roles & Assign Permissions
        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::findOrCreate('staff');
        $staffRole->givePermissionTo(['view sales', 'add sale', 'manage inventory']);

        // 3. Assign Admin role to the first user (aapka main account)
        $admin = User::first();
        if ($admin) {
            $admin->assignRole($adminRole);
        }
    }
}
