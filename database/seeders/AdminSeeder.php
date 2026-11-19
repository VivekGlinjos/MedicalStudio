<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'      => 'Admin',
                'email'     => 'admin@gmail.com',
                'password'  => 'Admin@123',
                'is_admin'  => true,
                'is_paid'   => true,
                'is_active' => true,
            ]
        );

        echo "Admin user created: admin@gmail.com / Admin@123\n";
    }
}
