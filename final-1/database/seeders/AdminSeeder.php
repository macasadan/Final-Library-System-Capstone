<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Use firstOrCreate to avoid duplicate entry errors
        User::firstOrCreate(
            ['email' => 'myadmin@user.com'], // Unique email constraint
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'), // Set the password you prefer
                'is_admin' => true,
            ]
        );
    }
}
