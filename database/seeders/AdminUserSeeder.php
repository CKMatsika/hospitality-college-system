<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@hospitality.edu'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'is_active' => true,
            ]
        );

        // Assign super-admin role
        if (!$admin->hasRole('super-admin')) {
            $admin->assignRole('super-admin');
        }

        $this->command->info('Admin user created/updated: admin@hospitality.edu / admin123');
    }
}
