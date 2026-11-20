<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primary test student account: vivek@medicalstudio.in
        $student1 = User::updateOrCreate(
            ['email' => 'vivek@medicalstudio.in'],
            [
                'name'              => 'Vivek',
                'email'             => 'vivek@medicalstudio.in',
                'password'          => Hash::make('vivek2026'),
                'phone'             => '9876543210',
                'address'           => 'Kerala, India',
                'is_paid'           => true,
                'is_admin'          => false,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        // Secondary fallback email: vivek@gmail.com (in case the user enters gmail)
        $student2 = User::updateOrCreate(
            ['email' => 'vivek@gmail.com'],
            [
                'name'              => 'Vivek',
                'email'             => 'vivek@gmail.com',
                'password'          => Hash::make('vivek2026'),
                'phone'             => '9876543210',
                'address'           => 'Kerala, India',
                'is_paid'           => true,
                'is_admin'          => false,
                'is_active'         => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('====================================================');
        $this->command->info('       TEST STUDENT ACCOUNTS READY FOR LOGIN        ');
        $this->command->info('====================================================');
        $this->command->info('Account 1:');
        $this->command->info(' - Email:    vivek@medicalstudio.in');
        $this->command->info(' - Password: vivek2026');
        $this->command->info('Account 2:');
        $this->command->info(' - Email:    vivek@gmail.com');
        $this->command->info(' - Password: vivek2026');
        $this->command->info('Status:');
        $this->command->info(' - Paid Access:  YES (is_paid = 1)');
        $this->command->info(' - Active State: YES (is_active = 1)');
        $this->command->info(' - Role:         Student (is_admin = 0)');
        $this->command->info('====================================================');
    }
}
