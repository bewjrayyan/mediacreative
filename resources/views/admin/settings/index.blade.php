@extends('admin.layouts.app')

@section('title', 'Settings')
@section('crumb', 'Settings')
@section('active', 'settings')

@section('content')
@php
    $allSettings = \App\Models\PageSetting::all()->pluck('value', 'key')->toArray();
    $groups = [
        'general' => ['site_name', 'tagline', 'site_description', 'logo', 'favicon'],
        'contact' => ['email', 'phone', 'address', 'map_embed'],
        'social' => ['facebook', 'instagram', 'linkedin', 'twitter', 'github'],
        'seo' => ['meta_title', 'meta_description', 'keywords', 'og_image'],
        'home' => ['hero_heading', 'hero_subheading', 'hero_image', 'cta_text', 'cta_link'],
        'footer' => ['copyright', 'quick_links'],
    ];
    $activeTab = request('tab', 'general');
@endphp

<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">System</div>
            <h1 class="saas-list-head__title">Site settings</h1>
            <p class="saas-list-head__sub">Configure general info, contact details, social links, SEO, homepage, footer, and system updates.</p>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-tabs">
            @foreach($groups as $group => $keys)
            <button type="button" class="saas-tab {{ $activeTab === $group ? 'is-active' : '' }}" data-tab="{{ $group }}">
                {{ ucfirst($group) }}
            </button>
            @endforeach
            <button type="button" class="saas-tab {{ $activeTab === 'updates' ? 'is-active' : '' }}" data-tab="updates">
                Updates
            </button>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">
            @csrf

            {{-- General --}}
            <div class="tab-panel saas-panel__body" data-panel="general" @if($activeTab !== 'general') style="display:none" @endif>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">Site Name</label>
                        <input class="saas-input" type="text" name="site_name" value="{{ $allSettings['site_name'] ?? 'DesignPro' }}">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">Tagline</label>
                        <input class="saas-input" type="text" name="tagline" value="{{ $allSettings['tagline'] ?? '' }}">
                    </div>
                </div>
                <div class="saas-field">
                    <label class="saas-label">Site Description</label>
                    <textarea class="saas-textarea" name="site_description" rows="3">{{ $allSettings['site_description'] ?? '' }}</textarea>
                </div>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">Logo</label>
                        <input class="saas-input" type="file" name="logo" accept="image/*">
                        @if(!empty($allSettings['logo']))
                            <img src="{{ asset('storage/' . $allSettings['logo']) }}" alt="" style="width:120px;margin-top:8px;background:#fff;border-radius:8px;padding:4px">
                        @endif
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">Favicon</label>
                        <input class="saas-input" type="file" name="favicon" accept="image/*">
                        @if(!empty($allSettings['favicon']))
                            <img src="{{ asset('storage/' . $allSettings['favicon']) }}" alt="" style="width:32px;margin-top:8px">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="tab-panel saas-panel__body" data-panel="contact" @if($activeTab !== 'contact') style="display:none" @endif>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">Contact Email</label>
                        <input class="saas-input" type="email" name="email" value="{{ $allSettings['email'] ?? '' }}">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">Phone</label>
                        <input class="saas-input" type="text" name="phone" value="{{ $allSettings['phone'] ?? '' }}">
                    </div>
                </div>
                <div class="saas-field">
                    <label class="saas-label">Address</label>
                    <textarea class="saas-textarea" name="address" rows="2">{{ $allSettings['address'] ?? '' }}</textarea>
                </div>
                <div class="saas-field">
                    <label class="saas-label">Google Maps Embed URL</label>
                    <textarea class="saas-textarea saas-textarea--mono" name="map_embed" rows="3" style="min-height:auto">{{ $allSettings['map_embed'] ?? '' }}</textarea>
                    <p class="saas-help">Paste the embed src URL from Google Maps (share → embed → copy the src value).</p>
                </div>
            </div>

            {{-- Social --}}
            <div class="tab-panel saas-panel__body" data-panel="social" @if($activeTab !== 'social') style="display:none" @endif>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">Facebook</label>
                        <input class="saas-input" type="url" name="facebook" value="{{ $allSettings['facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">Instagram</label>
                        <input class="saas-input" type="url" name="instagram" value="{{ $allSettings['instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">LinkedIn</label>
                        <input class="saas-input" type="url" name="linkedin" value="{{ $allSettings['linkedin'] ?? '' }}" placeholder="https://linkedin.com/...">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">X / Twitter</label>
                        <input class="saas-input" type="url" name="twitter" value="{{ $allSettings['twitter'] ?? '' }}" placeholder="https://twitter.com/...">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">GitHub</label>
                        <input class="saas-input" type="url" name="github" value="{{ $allSettings['github'] ?? '' }}" placeholder="https://github.com/...">
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="tab-panel saas-panel__body" data-panel="seo" @if($activeTab !== 'seo') style="display:none" @endif>
                <div class="saas-field">
                    <label class="saas-label">Default Meta Title</label>
                    <input class="saas-input" type="text" name="meta_title" value="{{ $allSettings['meta_title'] ?? '' }}">
                </div>
                <div class="saas-field">
                    <label class="saas-label">Meta Description</label>
                    <textarea class="saas-textarea" name="meta_description" rows="3">{{ $allSettings['meta_description'] ?? '' }}</textarea>
                </div>
                <div class="saas-field">
                    <label class="saas-label">Keywords (comma separated)</label>
                    <input class="saas-input" type="text" name="keywords" value="{{ $allSettings['keywords'] ?? '' }}">
                </div>
                <div class="saas-field">
                    <label class="saas-label">OG Image</label>
                    <input class="saas-input" type="file" name="og_image" accept="image/*">
                    @if(!empty($allSettings['og_image']))
                        <img src="{{ asset('storage/' . $allSettings['og_image']) }}" alt="" style="width:160px;margin-top:8px;border-radius:8px">
                    @endif
                </div>
            </div>

            {{-- Homepage --}}
            <div class="tab-panel saas-panel__body" data-panel="home" @if($activeTab !== 'home') style="display:none" @endif>
                <div class="saas-field">
                    <label class="saas-label">Hero Heading</label>
                    <input class="saas-input" type="text" name="hero_heading" value="{{ $allSettings['hero_heading'] ?? '' }}">
                </div>
                <div class="saas-field">
                    <label class="saas-label">Hero Subheading</label>
                    <textarea class="saas-textarea" name="hero_subheading" rows="3">{{ $allSettings['hero_subheading'] ?? '' }}</textarea>
                </div>
                <div class="saas-field">
                    <label class="saas-label">Hero Image</label>
                    <input class="saas-input" type="file" name="hero_image" accept="image/*">
                    @if(!empty($allSettings['hero_image']))
                        <img src="{{ asset('storage/' . $allSettings['hero_image']) }}" alt="" style="width:200px;margin-top:8px;border-radius:8px">
                    @endif
                </div>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">CTA Text</label>
                        <input class="saas-input" type="text" name="cta_text" value="{{ $allSettings['cta_text'] ?? '' }}">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">CTA Link</label>
                        <input class="saas-input" type="text" name="cta_link" value="{{ $allSettings['cta_link'] ?? '' }}" placeholder="/contact or https://...">
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="tab-panel saas-panel__body" data-panel="footer" @if($activeTab !== 'footer') style="display:none" @endif>
                <div class="saas-row saas-row--2">
                    <div class="saas-field">
                        <label class="saas-label">Copyright Text</label>
                        <input class="saas-input" type="text" name="copyright" value="{{ $allSettings['copyright'] ?? '' }}">
                    </div>
                    <div class="saas-field">
                        <label class="saas-label">Quick Links (JSON: label:url)</label>
                        <textarea class="saas-textarea saas-textarea--mono" name="quick_links" rows="4" style="min-height:auto">{{ $allSettings['quick_links'] ?? '{"Services":"/services","Portfolio":"/portfolio","About":"/about","Blog":"/blog","Contact":"/contact"}' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="saas-panel__body" id="settingsSaveBar" style="padding-top:0;border-top:1px solid var(--border-soft){{ $activeTab === 'updates' ? ';display:none' : '' }}">
                <button type="submit" class="btn btn--primary saas-btn saas-btn--save">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
                    Save all settings
                </button>
            </div>
        </form>

        {{-- Updates (outside settings form) --}}
        <div class="tab-panel saas-panel__body" data-panel="updates" @if($activeTab !== 'updates') style="display:none" @endif>
            <div class="saas-row saas-row--2">
                <div class="saas-field">
                    <div class="saas-eyebrow">Installed</div>
                    <div class="saas-update-card" id="updateLocalCard">
                        <div class="saas-update-card__title" id="updateLocalBranch">Loading…</div>
                        <div class="saas-update-card__meta" id="updateLocalMeta">—</div>
                        <div class="saas-update-card__msg" id="updateLocalMsg"></div>
                    </div>
                </div>
                <div class="saas-field">
                    <div class="saas-eyebrow">GitHub release</div>
                    <div class="saas-update-card" id="updateReleaseCard">
                        <div class="saas-update-card__title" id="updateReleaseTitle">Loading…</div>
                        <div class="saas-update-card__meta" id="updateReleaseMeta">—</div>
                        <div class="saas-update-card__msg" id="updateReleaseBody"></div>
                    </div>
                </div>
            </div>

            <div class="saas-update-status" id="updateSyncStatus">Checking sync status…</div>

            <div class="saas-update-actions">
                <button type="button" class="btn btn--ghost saas-btn" id="btnUpdateCheck">Check for updates</button>
                <button type="button" class="btn btn--primary saas-btn" id="btnUpdatePull">Pull latest + Artisan</button>
                <button type="button" class="btn btn--ghost saas-btn" id="btnUpdateMaintain">Run Artisan only</button>
            </div>

            <p class="saas-help">
                Pull uses <code>git pull --ff-only</code> from the configured remote/branch, then runs migrate (optional),
                config/cache/route/view clear, and <code>storage:link</code>. Admin only. Disable with <code>UPDATER_ENABLED=false</code>.
            </p>

            <div class="saas-field">
                <label class="saas-label">Command output</label>
                <pre class="saas-update-console" id="updateConsole">Ready.</pre>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var saveBar = document.getElementById('settingsSaveBar');
    var csrf = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('#settingsForm input[name="_token"]')?.value
        || '';

    function showTab(tab) {
        document.querySelectorAll('.saas-tab').forEach(function(b) {
            b.classList.toggle('is-active', b.dataset.tab === tab);
        });
        document.querySelectorAll('.tab-panel').forEach(function(p) {
            p.style.display = p.dataset.panel === tab ? '' : 'none';
        });
        if (saveBar) {
            saveBar.style.display = tab === 'updates' ? 'none' : '';
        }
        if (tab === 'updates') {
            loadStatus();
        }
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    }

    document.querySelectorAll('.saas-tab').forEach(function(btn) {
        btn.addEventListener('click', function() {
            showTab(btn.dataset.tab);
        });
    });

    function setBusy(busy) {
        ['btnUpdateCheck', 'btnUpdatePull', 'btnUpdateMaintain'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.disabled = busy;
        });
    }

    function appendConsole(lines) {
        var cons = document.getElementById('updateConsole');
        if (!cons) return;
        cons.textContent = (typeof lines === 'string' ? lines : (lines || []).join('\n')) || 'Done.';
        cons.scrollTop = cons.scrollHeight;
    }

    function formatSteps(steps) {
        if (!steps || !steps.length) return '';
        return steps.map(function(s) {
            return (s.ok ? '[OK] ' : '[FAIL] ') + s.command + '\n' + (s.output || '');
        }).join('\n\n');
    }

    function renderStatus(data) {
        if (!data) return;
        var local = data.local || {};
        var remote = data.remote_info || {};
        var release = data.release || {};

        document.getElementById('updateLocalBranch').textContent =
            (local.branch || '?') + ' @ ' + (local.short || 'unknown');
        document.getElementById('updateLocalMeta').textContent =
            [local.date || '', data.runtime ? ('v' + (data.runtime.app_version || '') + ' · PHP ' + data.runtime.php + ' · Laravel ' + data.runtime.laravel) : '']
                .filter(Boolean).join(' · ');
        document.getElementById('updateLocalMsg').textContent = local.message || '';
        if (local.dirty) {
            document.getElementById('updateLocalMsg').textContent +=
                (local.message ? ' · ' : '') + 'Working tree has local changes';
        }

        document.getElementById('updateReleaseTitle').textContent =
            release.tag || release.name || 'No release info';
        document.getElementById('updateReleaseMeta').textContent =
            [release.published_at || '', data.github_repo || ''].filter(Boolean).join(' · ');
        document.getElementById('updateReleaseBody').textContent = release.body || '';
        if (release.url) {
            document.getElementById('updateReleaseTitle').innerHTML =
                '<a href="' + release.url + '" target="_blank" rel="noopener">' +
                (release.tag || release.name || 'GitHub') + '</a>';
        }

        var sync = document.getElementById('updateSyncStatus');
        if (remote.behind == null) {
            sync.textContent = 'Remote status unknown. Click “Check for updates”.';
            sync.className = 'saas-update-status is-warn';
        } else if (remote.behind === 0 && remote.ahead === 0) {
            sync.textContent = 'Up to date with ' + (remote.ref || 'remote') + ' (' + (remote.short || '') + ').';
            sync.className = 'saas-update-status is-ok';
        } else if (remote.behind > 0) {
            sync.textContent = 'Behind by ' + remote.behind + ' commit(s). Remote: ' + (remote.short || '') + '.';
            sync.className = 'saas-update-status is-behind';
        } else {
            sync.textContent = 'Local is ahead by ' + remote.ahead + ' commit(s).';
            sync.className = 'saas-update-status is-warn';
        }
    }

    async function api(url, method) {
        setBusy(true);
        appendConsole('Running…');
        try {
            var res = await fetch(url, {
                method: method || 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            var json = await res.json().catch(function() { return {}; });
            if (json.data) renderStatus(json.data);
            var out = [];
            if (json.message) out.push(json.message);
            if (json.steps) out.push(formatSteps(json.steps));
            if (json.data && json.data.steps && json.data.steps.length) {
                out.push(formatSteps(json.data.steps));
            }
            if (!out.length) out.push(res.ok ? 'OK' : ('HTTP ' + res.status));
            appendConsole(out.join('\n\n'));
            return json;
        } catch (e) {
            appendConsole('Error: ' + e.message);
            return null;
        } finally {
            setBusy(false);
        }
    }

    function loadStatus() {
        api(@json(route('admin.settings.updates.status')), 'GET');
    }

    document.getElementById('btnUpdateCheck')?.addEventListener('click', function() {
        api(@json(route('admin.settings.updates.check')), 'POST');
    });
    document.getElementById('btnUpdatePull')?.addEventListener('click', function() {
        if (!confirm('Pull latest from GitHub and run Artisan maintenance? This cannot be undone easily.')) return;
        api(@json(route('admin.settings.updates.pull')), 'POST');
    });
    document.getElementById('btnUpdateMaintain')?.addEventListener('click', function() {
        api(@json(route('admin.settings.updates.maintenance')), 'POST');
    });

    if (@json($activeTab === 'updates')) {
        loadStatus();
    }
});
</script>
@endpush
