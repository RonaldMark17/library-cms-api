<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Masantol Public Library',
                'type' => 'string',
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Knowledge for All, Learning for Life',
                'type' => 'string',
            ],
            [
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
            ],
            [
                'key' => 'languages',
                'value' => json_encode(['en', 'tl']),
                'type' => 'json',
            ],
            [
                'key' => 'default_theme',
                'value' => 'light',
                'type' => 'string',
            ],
            [
                'key' => 'items_per_page',
                'value' => '10',
                'type' => 'integer',
            ],
            [
                'key' => 'max_borrow_books',
                'value' => '5',
                'type' => 'integer',
            ],
            [
                'key' => 'borrow_period_days',
                'value' => '14',
                'type' => 'integer',
            ],
            [
                'key' => 'overdue_fine_per_day',
                'value' => '5',
                'type' => 'integer',
            ],
            [
                'key' => 'library_address',
                'value' => '123 Bonifacio Street, Masantol, Pampanga, Philippines',
                'type' => 'string',
            ],
            [
                'key' => 'library_phone',
                'value' => '+63 917 123 4567',
                'type' => 'string',
            ],
            [
                'key' => 'library_email',
                'value' => 'info@library.com',
                'type' => 'string',
            ],
            [
                'key' => 'operating_hours_weekday',
                'value' => 'Monday - Friday: 8:00 AM - 8:00 PM',
                'type' => 'string',
            ],
            [
                'key' => 'operating_hours_saturday',
                'value' => 'Saturday: 9:00 AM - 5:00 PM',
                'type' => 'string',
            ],
            [
                'key' => 'operating_hours_sunday',
                'value' => 'Sunday: 10:00 AM - 4:00 PM',
                'type' => 'string',
            ],
            [
                'key' => 'enable_2fa',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'enable_email_notifications',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
            ],
            [
                'key' => 'total_collection_count',
                'value' => '50000',
                'type' => 'integer',
            ],
            [
                'key' => 'digital_resources_count',
                'value' => '15000',
                'type' => 'integer',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Settings seeded successfully!');
    }
}