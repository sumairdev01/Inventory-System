<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        $staff = User::create([
            'name' => 'Staff User',
                        'email' => 'staff1@gmail.com',
            'password' => Hash::make('staff123'),
        ]);

        $staff->assignRole('staff');
    }
}
