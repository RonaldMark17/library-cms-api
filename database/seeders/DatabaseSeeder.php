<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ContentSectionSeeder::class,
            StaffMemberSeeder::class,
            AnnouncementSeeder::class,
            MenuItemSeeder::class,
            PageSeeder::class,
            ExternalLinkSeeder::class,
            GuestSubscriberSeeder::class,
            SettingSeeder::class,
        ]);
    }
}