<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GuestSubscriber;
use Illuminate\Support\Str;

class GuestSubscriberSeeder extends Seeder
{
    public function run()
    {
        $subscribers = [
            [
                'email' => 'john.doe@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(30),
                'is_active' => true,
            ],
            [
                'email' => 'maria.santos@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(25),
                'is_active' => true,
            ],
            [
                'email' => 'pedro.garcia@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(20),
                'is_active' => true,
            ],
            [
                'email' => 'ana.reyes@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(15),
                'is_active' => true,
            ],
            [
                'email' => 'carlos.dela.cruz@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(10),
                'is_active' => true,
            ],
            [
                'email' => 'elena.flores@example.com',
                'verification_token' => null,
                'verified_at' => now()->subDays(5),
                'is_active' => true,
            ],
            [
                'email' => 'pending.user@example.com',
                'verification_token' => Str::random(64),
                'verified_at' => null,
                'is_active' => true,
            ],
            [
                'email' => 'another.pending@example.com',
                'verification_token' => Str::random(64),
                'verified_at' => null,
                'is_active' => true,
            ],
        ];

        foreach ($subscribers as $subscriber) {
            GuestSubscriber::create($subscriber);
        }

        $this->command->info('Guest subscribers seeded successfully!');
    }
}