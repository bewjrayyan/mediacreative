@extends('admin.layouts.app')

@section('title', 'Settings')
@section('crumb', 'Settings')
@section('active', 'settings')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">System</span>
        <h1 class="hero-title">Site <span class="accent">settings</span></h1>
        <p class="hero-sub">Configure your website's general info, contact details, social links, SEO, homepage, and footer.</p>
    </div>
</section>

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

<section class="card">
    <div class="card-head" style="border-bottom:1px solid var(--border);padding-bottom:0;margin-bottom:0">
        <div style="display:flex;gap:4px;flex-wrap:wrap">
            @foreach($groups as $group => $keys)
            <button class="tab-btn {{ $activeTab === $group ? 'active' : '' }}" data-tab="{{ $group }}" style="padding:10px 18px;border:none;background:none;cursor:pointer;font-size:13.5px;font-weight:600;color:var(--{{ $activeTab === $group ? 'primary' : 'muted' }});border-bottom:2px solid {{ $activeTab === $group ? 'var(--primary)' : 'transparent' }}">
                {{ ucfirst($group) }}
            </button>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">
        @csrf

        {{-- General --}}
        <div class="tab-panel" data-panel="general" style="{{ $activeTab === 'general' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-6">
                    <div class="field"><label class="field-label">Site Name</label>
                        <input class="input" type="text" name="site_name" value="{{ $allSettings['site_name'] ?? 'DesignPro' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Tagline</label>
                        <input class="input" type="text" name="tagline" value="{{ $allSettings['tagline'] ?? '' }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Site Description</label>
                        <textarea class="input" name="site_description" rows="3">{{ $allSettings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Logo</label>
                        <input class="input" type="file" name="logo" accept="image/*">
                        @if(!empty($allSettings['logo']))<img src="{{ asset('storage/' . $allSettings['logo']) }}" style="width:120px;margin-top:8px;background:#fff;border-radius:8px;padding:4px" alt="">@endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Favicon</label>
                        <input class="input" type="file" name="favicon" accept="image/*">
                        @if(!empty($allSettings['favicon']))<img src="{{ asset('storage/' . $allSettings['favicon']) }}" style="width:32px;margin-top:8px" alt="">@endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="tab-panel" data-panel="contact" style="{{ $activeTab === 'contact' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-6">
                    <div class="field"><label class="field-label">Contact Email</label>
                        <input class="input" type="email" name="email" value="{{ $allSettings['email'] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Phone</label>
                        <input class="input" type="text" name="phone" value="{{ $allSettings['phone'] ?? '' }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Address</label>
                        <textarea class="input" name="address" rows="2">{{ $allSettings['address'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Google Maps Embed URL</label>
                        <textarea class="input monospace" name="map_embed" rows="3" style="font-family:'JetBrains Mono',monospace;font-size:12px">{{ $allSettings['map_embed'] ?? '' }}</textarea>
                        <div style="font-size:12px;color:var(--t-light)">Paste the embed src URL from Google Maps (share → embed → copy the src value).</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Social --}}
        <div class="tab-panel" data-panel="social" style="{{ $activeTab === 'social' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-6">
                    <div class="field"><label class="field-label">Facebook</label>
                        <input class="input" type="url" name="facebook" value="{{ $allSettings['facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Instagram</label>
                        <input class="input" type="url" name="instagram" value="{{ $allSettings['instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">LinkedIn</label>
                        <input class="input" type="url" name="linkedin" value="{{ $allSettings['linkedin'] ?? '' }}" placeholder="https://linkedin.com/...">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">X / Twitter</label>
                        <input class="input" type="url" name="twitter" value="{{ $allSettings['twitter'] ?? '' }}" placeholder="https://twitter.com/...">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">GitHub</label>
                        <input class="input" type="url" name="github" value="{{ $allSettings['github'] ?? '' }}" placeholder="https://github.com/...">
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO --}}
        <div class="tab-panel" data-panel="seo" style="{{ $activeTab === 'seo' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-12">
                    <div class="field"><label class="field-label">Default Meta Title</label>
                        <input class="input" type="text" name="meta_title" value="{{ $allSettings['meta_title'] ?? '' }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Meta Description</label>
                        <textarea class="input" name="meta_description" rows="3">{{ $allSettings['meta_description'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Keywords (comma separated)</label>
                        <input class="input" type="text" name="keywords" value="{{ $allSettings['keywords'] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">OG Image</label>
                        <input class="input" type="file" name="og_image" accept="image/*">
                        @if(!empty($allSettings['og_image']))<img src="{{ asset('storage/' . $allSettings['og_image']) }}" style="width:160px;margin-top:8px;border-radius:8px" alt="">@endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Homepage --}}
        <div class="tab-panel" data-panel="home" style="{{ $activeTab === 'home' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-12">
                    <div class="field"><label class="field-label">Hero Heading</label>
                        <input class="input" type="text" name="hero_heading" value="{{ $allSettings['hero_heading'] ?? '' }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="field"><label class="field-label">Hero Subheading</label>
                        <textarea class="input" name="hero_subheading" rows="3">{{ $allSettings['hero_subheading'] ?? '' }}</textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Hero Image</label>
                        <input class="input" type="file" name="hero_image" accept="image/*">
                        @if(!empty($allSettings['hero_image']))<img src="{{ asset('storage/' . $allSettings['hero_image']) }}" style="width:200px;margin-top:8px;border-radius:8px" alt="">@endif
                    </div>
                </div>
                <div class="col-3">
                    <div class="field"><label class="field-label">CTA Text</label>
                        <input class="input" type="text" name="cta_text" value="{{ $allSettings['cta_text'] ?? '' }}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="field"><label class="field-label">CTA Link</label>
                        <input class="input" type="url" name="cta_link" value="{{ $allSettings['cta_link'] ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="tab-panel" data-panel="footer" style="{{ $activeTab === 'footer' ? '' : 'display:none' }}">
            <div class="grid">
                <div class="col-6">
                    <div class="field"><label class="field-label">Copyright Text</label>
                        <input class="input" type="text" name="copyright" value="{{ $allSettings['copyright'] ?? '' }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="field"><label class="field-label">Quick Links (JSON: label:url)</label>
                        <textarea class="input monospace" name="quick_links" rows="4" style="font-family:'JetBrains Mono',monospace;font-size:12px">{{ $allSettings['quick_links'] ?? '{"Services":"/services","Portfolio":"/portfolio","About":"/about","Blog":"/blog","Contact":"/contact"}' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div style="margin-top:24px;display:flex;gap:12px">
            <button type="submit" class="btn btn--primary">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
                Save All Settings
            </button>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var tab = btn.dataset.tab;
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active');
                b.style.color = 'var(--t-muted)';
                b.style.borderBottomColor = 'transparent';
            });
            btn.classList.add('active');
            btn.style.color = 'var(--primary)';
            btn.style.borderBottomColor = 'var(--primary)';
            document.querySelectorAll('.tab-panel').forEach(p => p.style.display = 'none');
            document.querySelector('[data-panel="' + tab + '"]').style.display = '';
        });
    });
});
</script>
@endpush
