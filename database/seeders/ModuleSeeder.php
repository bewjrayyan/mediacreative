<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Lead;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            [
                'slug' => 'lead-form',
                'name' => 'Lead Form & Prospect Management',
                'description' => 'Borang tangkapan prospek lead dengan sokongan import fail Excel (.xlsx / .csv) dan pengurusan status CRUD lengkap.',
                'version' => '1.0.0',
                'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/>',
                'category' => 'Marketing & Sales',
                'status' => 'active',
                'is_system' => false,
            ],
            [
                'slug' => 'appointment-booking',
                'name' => 'Appointment Booking',
                'description' => 'Modul perjanjiantemu & penjadualan slot bagi memudahkan pelanggan membuat tempahan sesi perkhidmatan.',
                'version' => '1.1.0',
                'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
                'category' => 'Services',
                'status' => 'installed',
                'is_system' => false,
            ],
            [
                'slug' => 'custom-analytics',
                'name' => 'Advanced Analytics & Reports',
                'description' => 'Laporan analitik terperinci dan paparan prestasi penukaran prospek serta trafik laman web.',
                'version' => '2.0.0',
                'icon' => '<path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/>',
                'category' => 'Analytics',
                'status' => 'uninstalled',
                'is_system' => false,
            ],
        ];

        foreach ($modules as $data) {
            Module::updateOrCreate(['slug' => $data['slug']], $data);
        }

        // Seed initial sample leads for demonstration
        if (Lead::count() === 0) {
            Lead::create([
                'name' => 'Ahmad Farhan',
                'email' => 'ahmad.farhan@example.com',
                'phone' => '012-3456789',
                'company' => 'Farhan Tech Solutions',
                'source' => 'Website Form',
                'status' => 'New',
                'notes' => 'Memerlukan quotation untuk pembinaan aplikasi web dan sistem tempahan.',
            ]);
            Lead::create([
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nur@example.com',
                'phone' => '019-8765432',
                'company' => 'Hijabista Couture',
                'source' => 'Excel Import',
                'status' => 'Contacted',
                'notes' => 'Telah dihubungi melalui WhatsApp pada 5 Sep. Menunggu maklum balas pakej.',
            ]);
            Lead::create([
                'name' => 'Robert Tan',
                'email' => 'robert.tan@example.com',
                'phone' => '016-1122334',
                'company' => 'Apex Logistics Sdn Bhd',
                'source' => 'Referral',
                'status' => 'Qualified',
                'notes' => 'Prospek berpotensi tinggi untuk integrasi sistem inventori.',
            ]);
        }
    }
}
