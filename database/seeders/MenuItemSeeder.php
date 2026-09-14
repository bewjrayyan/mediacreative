<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['label' => 'Home', 'url' => '/', 'location' => 'header', 'sort_order' => 10],
            ['label' => 'Services', 'url' => '/services', 'location' => 'header', 'sort_order' => 20],
            ['label' => 'Portfolio', 'url' => '/portfolio', 'location' => 'header', 'sort_order' => 30],
            ['label' => 'About', 'url' => '/about', 'location' => 'header', 'sort_order' => 40],
            ['label' => 'Blog', 'url' => '/blog', 'location' => 'header', 'sort_order' => 50],
            ['label' => 'Contact', 'url' => '/contact', 'location' => 'header', 'sort_order' => 60],
            ['label' => 'About Us', 'url' => '/about', 'location' => 'footer', 'sort_order' => 10],
            ['label' => 'Portfolio', 'url' => '/portfolio', 'location' => 'footer', 'sort_order' => 20],
            ['label' => 'Blog', 'url' => '/blog', 'location' => 'footer', 'sort_order' => 30],
            ['label' => 'Contact', 'url' => '/contact', 'location' => 'footer', 'sort_order' => 40],
        ];

        foreach ($items as $item) {
            MenuItem::updateOrCreate(
                ['location' => $item['location'], 'url' => $item['url']],
                $item + ['is_active' => true]
            );
        }
    }
}
