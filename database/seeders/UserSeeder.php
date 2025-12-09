<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@library.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'two_factor_enabled' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'librarian@library.com',
                'password' => Hash::make('password'),
                'role' => 'librarian',
                'two_factor_enabled' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan.delacruz@library.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'two_factor_enabled' => false,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Ana Reyes',
                'email' => 'ana.reyes@library.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'two_factor_enabled' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Carlos Garcia',
                'email' => 'carlos.garcia@library.com',
                'password' => Hash::make('password'),
                'role' => 'librarian',
                'two_factor_enabled' => false,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Users seeded successfully!');
    }
}