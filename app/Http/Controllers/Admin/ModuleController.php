<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use ZipArchive;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('status', 'asc')->orderBy('name', 'asc')->get();

        $stats = [
            'total' => $modules->count(),
            'active' => $modules->where('status', 'active')->count(),
            'installed' => $modules->whereIn('status', ['active', 'installed'])->count(),
            'uninstalled' => $modules->where('status', 'uninstalled')->count(),
        ];

        return view('admin.modules.index', compact('modules', 'stats'));
    }

    /**
     * Upload and install module ZIP package (WordPress plugin concept).
     */
    public function uploadZip(Request $request)
    {
        $request->validate([
            'module_file' => 'required|file|mimes:zip|max:20480',
        ]);

        $file = $request->file('module_file');
        $zipPath = $file->getRealPath();

        $zip = new ZipArchive();
        if ($zip->open($zipPath) !== true) {
            return redirect()->back()->with('error', 'Gagal membuka fail ZIP modul. Sila pastikan fail ZIP sah.');
        }

        // Read module.json or info.json if present
        $metadata = null;
        $metaContent = $zip->getFromName('module.json') ?: $zip->getFromName('info.json');

        if ($metaContent) {
            $metadata = json_decode($metaContent, true);
        }

        $zip->close();

        // Extract metadata or fallback from filename
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slug = isset($metadata['slug']) ? Str::slug($metadata['slug']) : Str::slug($originalName);
        $name = $metadata['name'] ?? Str::title(str_replace(['-', '_'], ' ', $originalName));
        $version = $metadata['version'] ?? '1.0.0';
        $category = $metadata['category'] ?? 'Plugins & Addons';
        $description = $metadata['description'] ?? 'Modul aplikasi yang di-upload melalui fail .zip.';
        $icon = $metadata['icon'] ?? '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>';

        // Save or update module entry
        $module = Module::updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'description' => $description,
                'version' => $version,
                'category' => $category,
                'icon' => $icon,
                'status' => 'installed',
                'is_system' => false,
            ]
        );

        return redirect()->route('admin.modules.index')->with('success', "Modul {$module->name} v{$module->version} berjaya dimuat naik dan dipasang!");
    }

    /**
     * Download sample module ZIP package for testing uploads.
     */
    public function downloadSampleZip()
    {
        $tempPath = tempnam(sys_get_temp_dir(), 'mod_zip_') . '.zip';

        $zip = new ZipArchive();
        if ($zip->open($tempPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $meta = [
                'name' => 'E-Commerce Storefront',
                'slug' => 'ecommerce-storefront',
                'version' => '1.2.0',
                'category' => 'E-Commerce',
                'description' => 'Modul kedai dalam talian untuk paparan produk, troli jualan, dan pembayaran terus.',
                'icon' => '<circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>',
            ];
            $zip->addFromString('module.json', json_encode($meta, JSON_PRETTY_PRINT));
            $zip->addFromString('README.md', "# E-Commerce Storefront Module\nInstalled via Adminator Zip Plugin Installer.");
            $zip->close();
        }

        return response()->download($tempPath, 'ecommerce-storefront-v1.2.0.zip')->deleteFileAfterSend(true);
    }

    public function install(Module $module)
    {
        $module->update(['status' => 'active']);
        return redirect()->back()->with('success', "Modul {$module->name} berjaya dipasang dan diaktifkan.");
    }

    public function uninstall(Module $module)
    {
        if ($module->is_system) {
            return redirect()->back()->with('error', 'Modul sistem tidak boleh dinyahpasang.');
        }

        $module->update(['status' => 'uninstalled']);
        return redirect()->back()->with('success', "Modul {$module->name} telah dinyahpasang.");
    }

    public function toggle(Module $module)
    {
        $newStatus = ($module->status === 'active') ? 'installed' : 'active';
        $module->update(['status' => $newStatus]);

        $msg = $newStatus === 'active' ? "Modul {$module->name} diaktifkan." : "Modul {$module->name} dinyahaktifkan.";
        return redirect()->back()->with('success', $msg);
    }

    public function destroy(Module $module)
    {
        if ($module->is_system) {
            return redirect()->back()->with('error', 'Modul sistem tidak boleh dipadam.');
        }

        $name = $module->name;
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', "Modul {$name} telah dipadam.");
    }
}
