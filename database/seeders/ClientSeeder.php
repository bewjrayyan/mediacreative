<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'TechNova', 'website' => 'https://technova.io'],
            ['name' => 'GreenLeaf', 'website' => 'https://greenleaf.com'],
            ['name' => 'Acme Corp', 'website' => 'https://acmecorp.com'],
            ['name' => 'Northwind', 'website' => 'https://northwind.com'],
            ['name' => 'Cloud9', 'website' => 'https://cloud9.tech'],
            ['name' => 'Visionary', 'website' => 'https://visionary.co'],
            ['name' => 'DataFlow', 'website' => 'https://dataflow.dev'],
            ['name' => 'BrightPath', 'website' => 'https://brightpath.org'],
        ];

        foreach ($clients as $index => $client) {
            Client::updateOrCreate(
                ['name' => $client['name']],
                [
                    'website' => $client['website'],
                    'logo' => null, // Use placeholder / initials in views
                    'is_active' => true,
                ]
            );
        }
    }
}
