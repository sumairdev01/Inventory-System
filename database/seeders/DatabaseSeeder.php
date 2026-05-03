<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = User::updateOrCreate(
            ['email' => 'admin@medistock.com'],
            [
                'name' => 'MediStock Admin',
                'password' => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            RolePermissionSeeder::class,
        ]);

        $admin->assignRole('admin');
    }
}
