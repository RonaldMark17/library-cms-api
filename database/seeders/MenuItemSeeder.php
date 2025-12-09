<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $menuItems = [
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'Home',
                    'tl' => 'Tahanan'
                ],
                'url' => '/',
                'type' => 'internal',
                'icon' => '🏠',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'About Us',
                    'tl' => 'Tungkol sa Amin'
                ],
                'url' => '/about',
                'type' => 'internal',
                'icon' => 'ℹ️',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'Staff Directory',
                    'tl' => 'Direktoryo ng Kawani'
                ],
                'url' => '/staff',
                'type' => 'internal',
                'icon' => '👥',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'Announcements',
                    'tl' => 'Mga Pahayag'
                ],
                'url' => '/announcements',
                'type' => 'internal',
                'icon' => '📢',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'Resources',
                    'tl' => 'Mga Mapagkukunan'
                ],
                'url' => '/resources',
                'type' => 'internal',
                'icon' => '📚',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'parent_id' => null,
                'label' => [
                    'en' => 'Contact',
                    'tl' => 'Makipag-ugnayan'
                ],
                'url' => '/pages/contact',
                'type' => 'page',
                'icon' => '📧',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create($item);
        }

        $this->command->info('Menu items seeded successfully!');
    }
}
