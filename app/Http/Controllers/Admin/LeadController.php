<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Module;
use App\Services\ExcelImporter;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    private function checkModuleActive()
    {
        $mod = Module::where('slug', 'lead-form')->first();
        if (!$mod || !$mod->isActive()) {
            return redirect()->route('admin.modules.index')->with('error', 'Modul Lead Form belum diaktifkan. Sila aktifkan modul ini di pengurusan modul.');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        $query = Lead::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $leads = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Lead::count(),
            'new' => Lead::where('status', 'New')->count(),
            'contacted' => Lead::where('status', 'Contacted')->count(),
            'qualified' => Lead::where('status', 'Qualified')->count(),
            'converted' => Lead::where('status', 'Converted')->count(),
            'lost' => Lead::where('status', 'Lost')->count(),
        ];

        return view('admin.leads.index', compact('leads', 'stats'));
    }

    public function create()
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        return view('admin.leads.create');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:100',
            'status' => 'required|string|in:New,Contacted,Qualified,Converted,Lost',
            'notes' => 'nullable|string',
        ]);

        Lead::create($validated);

        return redirect()->route('admin.leads.index')->with('success', 'Rekod lead baru berjaya ditambah.');
    }

    public function edit(Lead $lead)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        return view('admin.leads.edit', compact('lead'));
    }

    public function update(Request $request, Lead $lead)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:100',
            'status' => 'required|string|in:New,Contacted,Qualified,Converted,Lost',
            'notes' => 'nullable|string',
        ]);

        $lead->update($validated);

        return redirect()->route('admin.leads.index')->with('success', 'Rekod lead berjaya dikemas kini.');
    }

    public function destroy(Lead $lead)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        $name = $lead->name;
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', "Rekod lead {$name} berjaya dipadam.");
    }

    public function import(Request $request, ExcelImporter $importer)
    {
        if ($redirect = $this->checkModuleActive()) {
            return $redirect;
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv,txt,xls|max:10240',
        ]);

        $result = $importer->import($request->file('file'));

        if ($result['success']) {
            return redirect()->route('admin.leads.index')->with('success', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['error']);
        }
    }

    public function downloadSample()
    {
        $csvContent = "Name,Email,Phone,Company,Source,Status,Notes\n";
        $csvContent .= "Ahmad Rozaini,ahmad@example.com,012-9988776,Rozaini Enterprise,Website,New,Minat pakej web app\n";
        $csvContent .= "Nurul Ain,nurul@example.com,019-3344556,Ain Beauty,Facebook Ads,Contacted,Minta sebut harga\n";
        $csvContent .= "Chong Wei,chong@example.com,016-5544332,Mega Trading,Referral,Qualified,Perlu demo sistem\n";

        return response($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample_leads_import.csv"',
        ]);
    }
}
