<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'superadmin@user.com'], // Unique email constraint
            [
                'name' => 'Super Admin User',
                'password' => Hash::make('superadminpassword'), 
                'is_super_admin' => true,
                'is_admin' => true, // Optionally, super admin can also be an admin
            ]
        );
    }
}
