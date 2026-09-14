@extends('admin.layouts.app')

@section('title', 'Modules')
@section('crumb', 'System | Modules')
@section('active', 'modules')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">System · Extensions</div>
            <h1 class="saas-list-head__title">Module Management <span class="saas-count">{{ $stats['total'] }}</span></h1>
            <p class="saas-list-head__sub">Create, install, activate, and manage application modules and extensions.</p>
        </div>
        <div class="saas-toolbar__actions">
            <button type="button" class="btn btn--primary saas-btn" onclick="openSaasModal('uploadModuleModal')">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Upload Module (.zip)
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:16px;margin-bottom:24px">
        <div class="saas-panel" style="padding:20px;margin:0">
            <div style="font-size:12px;font-weight:600;color:var(--t-muted);text-transform:uppercase;letter-spacing:0.05em">Total Modules</div>
            <div style="font-size:28px;font-weight:700;margin-top:6px;color:var(--t-base)">{{ $stats['total'] }}</div>
        </div>
        <div class="saas-panel" style="padding:20px;margin:0">
            <div style="font-size:12px;font-weight:600;color:var(--success);text-transform:uppercase;letter-spacing:0.05em">Active</div>
            <div style="font-size:28px;font-weight:700;margin-top:6px;color:var(--success)">{{ $stats['active'] }}</div>
        </div>
        <div class="saas-panel" style="padding:20px;margin:0">
            <div style="font-size:12px;font-weight:600;color:var(--primary);text-transform:uppercase;letter-spacing:0.05em">Installed</div>
            <div style="font-size:28px;font-weight:700;margin-top:6px;color:var(--primary)">{{ $stats['installed'] }}</div>
        </div>
        <div class="saas-panel" style="padding:20px;margin:0">
            <div style="font-size:12px;font-weight:600;color:var(--t-light);text-transform:uppercase;letter-spacing:0.05em">Uninstalled</div>
            <div style="font-size:28px;font-weight:700;margin-top:6px;color:var(--t-light)">{{ $stats['uninstalled'] }}</div>
        </div>
    </div>

    {{-- Modules Grid --}}
    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">Available Modules</h2>
                <p class="saas-panel__sub">Install or uninstall features to expand application capabilities.</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));gap:20px;padding:20px">
            @forelse($modules as $module)
            <div style="border:1px solid var(--border);border-radius:14px;padding:20px;background:var(--bg-card);display:flex;flex-direction:column;justify-content:space-between;gap:16px;box-shadow:var(--shadow-sm);transition:all .2s ease">
                <div>
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:12px">
                        <div style="display:flex;align-items:center;gap:12px">
                            <div style="width:44px;height:44px;border-radius:12px;background:var(--primary-soft);color:var(--primary);display:grid;place-items:center;flex-shrink:0">
                                @if($module->icon)
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">{!! $module->icon !!}</svg>
                                @else
                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                @endif
                            </div>
                            <div>
                                <h3 style="font-size:16px;font-weight:700;margin:0 0 2px">{{ $module->name }}</h3>
                                <div style="font-size:12px;color:var(--t-muted)">v{{ $module->version }} · <span class="saas-badge" style="font-size:10px;padding:2px 8px">{{ $module->category }}</span></div>
                            </div>
                        </div>
                        <div>
                            @if($module->status === 'active')
                                <span style="background:#ECFDF5;color:#059669;border:1px solid #10B981;font-size:11px;font-weight:600;padding:4px 10px;border-radius:999px;display:inline-flex;align-items:center;gap:4px">
                                    <span style="width:6px;height:6px;border-radius:50%;background:#10B981"></span> Active
                                </span>
                            @elseif($module->status === 'installed')
                                <span style="background:#EFF6FF;color:#2563EB;border:1px solid #3B82F6;font-size:11px;font-weight:600;padding:4px 10px;border-radius:999px;display:inline-flex;align-items:center;gap:4px">
                                    Installed
                                </span>
                            @else
                                <span style="background:var(--bg-body);color:var(--t-light);border:1px solid var(--border);font-size:11px;font-weight:600;padding:4px 10px;border-radius:999px">
                                    Uninstalled
                                </span>
                            @endif
                        </div>
                    </div>

                    <p style="font-size:13.5px;color:var(--t-muted);line-height:1.5;margin:0 0 14px">{{ $module->description ?: 'No description provided.' }}</p>
                </div>

                <div style="border-top:1px solid var(--border-soft);padding-top:14px;display:flex;align-items:center;justify-content:space-between;gap:8px">
                    <div style="display:flex;gap:8px">
                        @if($module->status === 'uninstalled')
                            <form method="POST" action="{{ route('admin.modules.install', $module) }}">
                                @csrf
                                <button type="submit" class="btn btn--primary saas-btn" style="padding:6px 14px;font-size:13px">Install Module</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.modules.toggle', $module) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn {{ $module->status === 'active' ? 'btn--ghost' : 'btn--primary' }} saas-btn" style="padding:6px 14px;font-size:13px">
                                    {{ $module->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.modules.uninstall', $module) }}" onsubmit="return confirm('Uninstall this module?');">
                                @csrf
                                <button type="submit" class="btn btn--ghost saas-btn" style="padding:6px 12px;font-size:13px;color:var(--danger)">Uninstall</button>
                            </form>
                        @endif
                    </div>

                    @if($module->slug === 'lead-form' && $module->status === 'active')
                        <a href="{{ route('admin.leads.index') }}" class="btn btn--ghost saas-btn" style="font-size:13px;color:var(--primary)">Open Leads →</a>
                    @endif
                </div>
            </div>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:40px 20px;color:var(--t-muted)">No modules registered yet.</div>
            @endforelse
        </div>
    </section>
</div>

{{-- Upload Module ZIP Modal (WordPress Plugin Installer Concept) --}}
<div id="uploadModuleModal" class="saas-modal" hidden>
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:18px;width:100%;max-width:540px;padding:28px;box-shadow:var(--shadow-lg);position:relative">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <h3 style="font-size:18px;font-weight:700;margin:0">Upload & Install Plugin Module</h3>
            <button type="button" style="border:0;background:transparent;font-size:24px;cursor:pointer;color:var(--t-muted);line-height:1" onclick="closeSaasModal('uploadModuleModal')">&times;</button>
        </div>

        <p style="font-size:13.5px;color:var(--t-muted);line-height:1.5;margin-bottom:20px">
            Pilih fail <code>.zip</code> modul dari komputer anda untuk dipasang ke dalam aplikasi (konsep muat naik plugin WordPress).
        </p>

        <form method="POST" action="{{ route('admin.modules.upload') }}" enctype="multipart/form-data">
            @csrf
            <div style="border:2px dashed var(--border);border-radius:12px;padding:32px 20px;text-align:center;background:var(--bg-body);margin-bottom:20px">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="var(--primary)" stroke-width="2" style="margin:0 auto 12px;display:block"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="12 12 12 18"/><polyline points="9 15 12 12 15 15"/></svg>
                <input type="file" name="module_file" accept=".zip" required style="display:block;margin:0 auto;font-size:13px">
                <div style="font-size:12px;color:var(--t-muted);margin-top:8px">Fail format disokong: .zip (Maksimum 20MB)</div>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                <a href="{{ route('admin.modules.sample-zip') }}" style="font-size:13px;color:var(--primary);text-decoration:underline">Muat Turun Sample Plugin (.zip)</a>
                <div style="display:flex;gap:10px">
                    <button type="button" class="btn btn--ghost saas-btn" onclick="closeSaasModal('uploadModuleModal')">Batal</button>
                    <button type="submit" class="btn btn--primary saas-btn">Muat Naik & Pasang</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
