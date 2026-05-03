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

        $adminRole = Role::findOrCreate('admin');

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

        $adminRole->givePermissionTo(Permission::all());

        User::all()->each(function ($user) use ($adminRole) {
            $user->assignRole($adminRole);
        });
    }
}
