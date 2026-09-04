@extends('admin.layouts.app')

@section('title', 'Settings')
@section('crumb', 'Settings')
@section('active', 'settings')

@section('content')
@php
    $allSettings = \App\Models\PageSetting::all()->pluck('value', 'key')->toArray();
    $siteName = old('site_name', $allSettings['site_name'] ?? 'DesignPro');
    $tabs = [
        'general' => ['label' => 'General', 'hint' => 'Brand & identity'],
        'contact' => ['label' => 'Contact', 'hint' => 'Reach details'],
        'social' => ['label' => 'Social', 'hint' => 'Profile links'],
        'seo' => ['label' => 'SEO', 'hint' => 'Search & share'],
        'home' => ['label' => 'Homepage', 'hint' => 'Hero & CTA'],
        'services_page' => ['label' => 'Services page', 'hint' => 'Flow & tech'],
        'footer' => ['label' => 'Footer', 'hint' => 'Copyright & links'],
        'cache' => ['label' => 'Clear cache', 'hint' => 'Refresh admin UI'],
        'updates' => ['label' => 'Updates', 'hint' => 'GitHub deploy'],
    ];
    $activeTab = request('tab', 'general');
    if (! array_key_exists($activeTab, $tabs)) {
        $activeTab = 'general';
    }
    $hideSaveTabs = ['updates', 'cache'];
@endphp

<div class="saas-editor saas-settings">
    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">System</div>
                <h1 class="saas-title" id="liveSettingsTitle">{{ $siteName }}</h1>
            </div>
            <span class="saas-status is-live" id="settingsTabPill">
                <span class="saas-status__dot"></span>
                <span id="settingsTabPillText">{{ $tabs[$activeTab]['label'] }}</span>
            </span>
        </div>
        <div class="saas-toolbar__actions" id="settingsSaveBar" @if(in_array($activeTab, $hideSaveTabs, true)) style="display:none" @endif>
            <button type="submit" form="settingsForm" class="btn btn--primary saas-btn saas-btn--save">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
                Save settings
            </button>
        </div>
    </header>

    @if ($errors->any())
        <div class="saas-alert" role="alert">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <div>
                <strong>Fix {{ $errors->count() }} {{ $errors->count() === 1 ? 'issue' : 'issues' }} before saving</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="saas-layout">
        <aside class="saas-side">
            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Sections</h2>
                </div>
                <nav class="saas-settings-nav" aria-label="Settings sections">
                    @foreach($tabs as $key => $meta)
                        <button type="button"
                            class="saas-settings-nav__item {{ $activeTab === $key ? 'is-active' : '' }}"
                            data-tab="{{ $key }}">
                            <span class="saas-settings-nav__label">{{ $meta['label'] }}</span>
                            <span class="saas-settings-nav__hint">{{ $meta['hint'] }}</span>
                        </button>
                    @endforeach
                </nav>
            </section>

            <section class="saas-panel saas-panel--side" data-settings-preview @if($activeTab !== 'general') style="display:none" @endif>
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Preview</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <div class="saas-settings-preview">
                        <div class="saas-settings-preview__logo" id="previewLogo">
                            @if(!empty($allSettings['logo']))
                                <img src="{{ asset('storage/' . $allSettings['logo']) }}" alt="Logo">
                            @else
                                <span class="saas-settings-preview__mark">{{ strtoupper(mb_substr($siteName, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="saas-settings-preview__name" id="previewName">{{ $siteName }}</div>
                        <div class="saas-settings-preview__tag" id="previewTagline">{{ old('tagline', $allSettings['tagline'] ?? 'Site tagline') }}</div>
                    </div>
                    <p class="saas-help">Live preview of brand identity on the public site.</p>
                </div>
            </section>
        </aside>

        <div class="saas-main">
            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm" novalidate>
                @csrf

                {{-- General --}}
                <div class="saas-settings-panel" data-panel="general" @if($activeTab !== 'general') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Brand identity</h2>
                                <p class="saas-panel__sub">Site name, tagline, and short description shown across the website.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-field">
                                <label class="saas-label" for="site_name">Site name <span class="req">*</span></label>
                                <input class="saas-input saas-input--lg" id="site_name" type="text" name="site_name" value="{{ $siteName }}" required autocomplete="organization" placeholder="e.g. Media Creative">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="tagline">Tagline</label>
                                <input class="saas-input" id="tagline" type="text" name="tagline" value="{{ old('tagline', $allSettings['tagline'] ?? '') }}" placeholder="One-line brand promise">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="site_description">Site description</label>
                                <textarea class="saas-textarea" id="site_description" name="site_description" rows="4" placeholder="Short overview for footers and about snippets">{{ old('site_description', $allSettings['site_description'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </section>

                    <section class="saas-panel" style="margin-top:20px">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Logo &amp; favicon</h2>
                                <p class="saas-panel__sub">Upload brand marks used in the header, emails, and browser tab.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-row saas-row--2">
                                <div class="saas-field">
                                    <label class="saas-label" for="logo">Logo</label>
                                    <div class="saas-dropzone saas-dropzone--logo" data-dropzone="logo">
                                        <input type="file" name="logo" id="logo" accept="image/*" class="saas-dropzone__input" data-preview="logoPreview">
                                        <div class="saas-dropzone__preview saas-dropzone__preview--logo" id="logoPreview">
                                            @if(!empty($allSettings['logo']))
                                                <div class="saas-logo-frame"><img src="{{ asset('storage/' . $allSettings['logo']) }}" alt="Current logo"></div>
                                                <div class="saas-dropzone__overlay"><span>Replace logo</span></div>
                                            @else
                                                <div class="saas-dropzone__empty">
                                                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                                    <strong>Drop logo here</strong>
                                                    <span>PNG, SVG, WEBP · up to 5MB</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="saas-help">Transparent PNG or SVG works best on light and dark headers.</p>
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="favicon">Favicon</label>
                                    <div class="saas-dropzone" data-dropzone="favicon">
                                        <input type="file" name="favicon" id="favicon" accept="image/*" class="saas-dropzone__input">
                                        <div class="saas-dropzone__preview" id="faviconPreview" style="min-height:160px;display:grid;place-items:center;padding:24px">
                                            @if(!empty($allSettings['favicon']))
                                                <img src="{{ asset('storage/' . $allSettings['favicon']) }}" alt="Favicon" style="width:48px;height:48px;object-fit:contain;border-radius:8px">
                                                <div class="saas-dropzone__overlay"><span>Replace</span></div>
                                            @else
                                                <div class="saas-dropzone__empty">
                                                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h7v7H4zM13 4h7v7h-7zM4 13h7v7H4zM13 13h7v7h-7z"/></svg>
                                                    <strong>Drop favicon</strong>
                                                    <span>ICO / PNG · 32×32 or 64×64</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Contact --}}
                <div class="saas-settings-panel" data-panel="contact" @if($activeTab !== 'contact') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Contact details</h2>
                                <p class="saas-panel__sub">Shown on the contact page, footer, and inquiry forms.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-row saas-row--2">
                                <div class="saas-field">
                                    <label class="saas-label" for="email">Contact email</label>
                                    <input class="saas-input" id="email" type="email" name="email" value="{{ old('email', $allSettings['email'] ?? '') }}" placeholder="hello@example.com">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="phone">Phone</label>
                                    <input class="saas-input" id="phone" type="text" name="phone" value="{{ old('phone', $allSettings['phone'] ?? '') }}" placeholder="+60 …">
                                </div>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="address">Address</label>
                                <textarea class="saas-textarea" id="address" name="address" rows="3">{{ old('address', $allSettings['address'] ?? '') }}</textarea>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="map_embed">Google Maps embed URL</label>
                                <textarea class="saas-textarea saas-textarea--mono" id="map_embed" name="map_embed" rows="3" style="min-height:auto">{{ old('map_embed', $allSettings['map_embed'] ?? '') }}</textarea>
                                <p class="saas-help">Paste the embed <code>src</code> from Google Maps (Share → Embed a map).</p>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Social --}}
                <div class="saas-settings-panel" data-panel="social" @if($activeTab !== 'social') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Social profiles</h2>
                                <p class="saas-panel__sub">Full profile URLs for footer and contact modules.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-row saas-row--2">
                                <div class="saas-field">
                                    <label class="saas-label" for="facebook">Facebook</label>
                                    <input class="saas-input" id="facebook" type="url" name="facebook" value="{{ old('facebook', $allSettings['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="instagram">Instagram</label>
                                    <input class="saas-input" id="instagram" type="url" name="instagram" value="{{ old('instagram', $allSettings['instagram'] ?? '') }}" placeholder="https://instagram.com/...">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="linkedin">LinkedIn</label>
                                    <input class="saas-input" id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $allSettings['linkedin'] ?? '') }}" placeholder="https://linkedin.com/...">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="twitter">X / Twitter</label>
                                    <input class="saas-input" id="twitter" type="url" name="twitter" value="{{ old('twitter', $allSettings['twitter'] ?? '') }}" placeholder="https://twitter.com/...">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="github">GitHub</label>
                                    <input class="saas-input" id="github" type="url" name="github" value="{{ old('github', $allSettings['github'] ?? '') }}" placeholder="https://github.com/...">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- SEO --}}
                <div class="saas-settings-panel" data-panel="seo" @if($activeTab !== 'seo') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Default SEO</h2>
                                <p class="saas-panel__sub">Fallbacks for pages without custom meta tags.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-field">
                                <label class="saas-label" for="meta_title">Meta title</label>
                                <input class="saas-input" id="meta_title" type="text" name="meta_title" value="{{ old('meta_title', $allSettings['meta_title'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="meta_description">Meta description</label>
                                <textarea class="saas-textarea" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $allSettings['meta_description'] ?? '') }}</textarea>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="keywords">Keywords</label>
                                <input class="saas-input" id="keywords" type="text" name="keywords" value="{{ old('keywords', $allSettings['keywords'] ?? '') }}" placeholder="design, agency, branding">
                                <p class="saas-help">Comma-separated keywords.</p>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="og_image">OG image</label>
                                <div class="saas-dropzone" data-dropzone="og_image">
                                    <input type="file" name="og_image" id="og_image" accept="image/*" class="saas-dropzone__input">
                                    <div class="saas-dropzone__preview" id="ogPreview" style="min-height:180px;display:grid;place-items:center">
                                        @if(!empty($allSettings['og_image']))
                                            <img src="{{ asset('storage/' . $allSettings['og_image']) }}" alt="OG" style="max-width:100%;max-height:200px;object-fit:cover;border-radius:8px">
                                            <div class="saas-dropzone__overlay"><span>Replace image</span></div>
                                        @else
                                            <div class="saas-dropzone__empty">
                                                <strong>Drop Open Graph image</strong>
                                                <span>Recommended 1200×630</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Homepage --}}
                <div class="saas-settings-panel" data-panel="home" @if($activeTab !== 'home') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Hero section</h2>
                                <p class="saas-panel__sub">Primary message and call-to-action on the homepage.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-field">
                                <label class="saas-label" for="hero_heading">Hero heading</label>
                                <input class="saas-input saas-input--lg" id="hero_heading" type="text" name="hero_heading" value="{{ old('hero_heading', $allSettings['hero_heading'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="hero_subheading">Hero subheading</label>
                                <textarea class="saas-textarea" id="hero_subheading" name="hero_subheading" rows="3">{{ old('hero_subheading', $allSettings['hero_subheading'] ?? '') }}</textarea>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="hero_image">Hero image</label>
                                <div class="saas-dropzone" data-dropzone="hero_image">
                                    <input type="file" name="hero_image" id="hero_image" accept="image/*" class="saas-dropzone__input">
                                    <div class="saas-dropzone__preview" id="heroPreview" style="min-height:200px;display:grid;place-items:center">
                                        @if(!empty($allSettings['hero_image']))
                                            <img src="{{ asset('storage/' . $allSettings['hero_image']) }}" alt="Hero" style="max-width:100%;max-height:240px;object-fit:cover;border-radius:8px">
                                            <div class="saas-dropzone__overlay"><span>Replace image</span></div>
                                        @else
                                            <div class="saas-dropzone__empty">
                                                <strong>Drop hero image</strong>
                                                <span>Wide landscape works best</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="saas-row saas-row--2">
                                <div class="saas-field">
                                    <label class="saas-label" for="cta_text">CTA text</label>
                                    <input class="saas-input" id="cta_text" type="text" name="cta_text" value="{{ old('cta_text', $allSettings['cta_text'] ?? '') }}">
                                </div>
                                <div class="saas-field">
                                    <label class="saas-label" for="cta_link">CTA link</label>
                                    <input class="saas-input" id="cta_link" type="text" name="cta_link" value="{{ old('cta_link', $allSettings['cta_link'] ?? '') }}" placeholder="/contact or https://…">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>


                {{-- Services page --}}
                <div class="saas-settings-panel" data-panel="services_page" @if($activeTab !== 'services_page') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Services page</h2>
                                <p class="saas-panel__sub">Extra sections shown below your service cards (intro, flow, technologies, quote, CTA). Inspired by modern studio layouts; your CMS services list stays above.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-field">
                                <label class="saas-label" for="services_intro_title">Intro title</label>
                                <input class="saas-input" id="services_intro_title" type="text" name="services_intro_title" value="{{ old('services_intro_title', $allSettings['services_intro_title'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_intro_body">Intro body</label>
                                <textarea class="saas-textarea" id="services_intro_body" name="services_intro_body" rows="6">{{ old('services_intro_body', $allSettings['services_intro_body'] ?? '') }}</textarea>
                                <p class="saas-help">Separate paragraphs with a blank line.</p>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_intro_stack">Stack / approach paragraph</label>
                                <textarea class="saas-textarea" id="services_intro_stack" name="services_intro_stack" rows="3">{{ old('services_intro_stack', $allSettings['services_intro_stack'] ?? '') }}</textarea>
                            </div>

                            <hr class="saas-divider" style="margin:28px 0;border:0;border-top:1px solid var(--border,#E4E8EF)">

                            <div class="saas-field">
                                <label class="saas-label" for="services_flow_heading">Flow heading</label>
                                <input class="saas-input" id="services_flow_heading" type="text" name="services_flow_heading" value="{{ old('services_flow_heading', $allSettings['services_flow_heading'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_flow_subheading">Flow subheading</label>
                                <input class="saas-input" id="services_flow_subheading" type="text" name="services_flow_subheading" value="{{ old('services_flow_subheading', $allSettings['services_flow_subheading'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_flow_steps">Flow steps (JSON)</label>
                                <textarea class="saas-textarea saas-textarea--mono" id="services_flow_steps" name="services_flow_steps" rows="14" style="min-height:auto;font-family:ui-monospace,SFMono-Regular,Menlo,monospace;font-size:12.5px">{{ old('services_flow_steps', $allSettings['services_flow_steps'] ?? '[]') }}</textarea>
                                <p class="saas-help">Array of objects: <code>[{"title":"…","description":"…"}]</code></p>
                            </div>

                            <hr class="saas-divider" style="margin:28px 0;border:0;border-top:1px solid var(--border,#E4E8EF)">

                            <div class="saas-field">
                                <label class="saas-label" for="services_tech_heading">Technologies heading</label>
                                <input class="saas-input" id="services_tech_heading" type="text" name="services_tech_heading" value="{{ old('services_tech_heading', $allSettings['services_tech_heading'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_tech_subheading">Technologies subheading</label>
                                <input class="saas-input" id="services_tech_subheading" type="text" name="services_tech_subheading" value="{{ old('services_tech_subheading', $allSettings['services_tech_subheading'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_technologies">Technologies list</label>
                                <input class="saas-input" id="services_technologies" type="text" name="services_technologies" value="{{ old('services_technologies', $allSettings['services_technologies'] ?? '') }}" placeholder="Laravel, React, …">
                                <p class="saas-help">Comma-separated labels.</p>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_quote">Quote</label>
                                <textarea class="saas-textarea" id="services_quote" name="services_quote" rows="2">{{ old('services_quote', $allSettings['services_quote'] ?? '') }}</textarea>
                            </div>

                            <hr class="saas-divider" style="margin:28px 0;border:0;border-top:1px solid var(--border,#E4E8EF)">

                            <div class="saas-field">
                                <label class="saas-label" for="services_bottom_cta_title">Bottom CTA title</label>
                                <input class="saas-input" id="services_bottom_cta_title" type="text" name="services_bottom_cta_title" value="{{ old('services_bottom_cta_title', $allSettings['services_bottom_cta_title'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_bottom_cta_body">Bottom CTA body</label>
                                <textarea class="saas-textarea" id="services_bottom_cta_body" name="services_bottom_cta_body" rows="3">{{ old('services_bottom_cta_body', $allSettings['services_bottom_cta_body'] ?? '') }}</textarea>
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="services_bottom_cta_button">Bottom CTA button</label>
                                <input class="saas-input" id="services_bottom_cta_button" type="text" name="services_bottom_cta_button" value="{{ old('services_bottom_cta_button', $allSettings['services_bottom_cta_button'] ?? '') }}">
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Footer --}}
                <div class="saas-settings-panel" data-panel="footer" @if($activeTab !== 'footer') hidden @endif>
                    <section class="saas-panel">
                        <div class="saas-panel__head">
                            <div>
                                <h2 class="saas-panel__title">Footer</h2>
                                <p class="saas-panel__sub">Copyright line and quick navigation links.</p>
                            </div>
                        </div>
                        <div class="saas-panel__body">
                            <div class="saas-field">
                                <label class="saas-label" for="copyright">Copyright text</label>
                                <input class="saas-input" id="copyright" type="text" name="copyright" value="{{ old('copyright', $allSettings['copyright'] ?? '') }}">
                            </div>
                            <div class="saas-field">
                                <label class="saas-label" for="quick_links">Quick links (JSON)</label>
                                <textarea class="saas-textarea saas-textarea--mono" id="quick_links" name="quick_links" rows="6" style="min-height:auto">{{ old('quick_links', $allSettings['quick_links'] ?? '{"Services":"/services","Portfolio":"/portfolio","About":"/about","Blog":"/blog","Contact":"/contact"}') }}</textarea>
                                <p class="saas-help">Object map of <code>label → url</code>, e.g. <code>{"Services":"/services"}</code>.</p>
                            </div>
                        </div>
                    </section>
                </div>
            </form>

            {{-- Clear cache --}}
            <div class="saas-settings-panel" data-panel="cache" @if($activeTab !== 'cache') hidden @endif>
                <section class="saas-panel">
                    <div class="saas-panel__head">
                        <div>
                            <h2 class="saas-panel__title">Clear cache</h2>
                            <p class="saas-panel__sub">Refresh Laravel caches so admin UI and pages pick up the latest changes — no hard refresh required.</p>
                        </div>
                    </div>
                    <div class="saas-panel__body">
                        <div class="saas-update-card">
                            <div class="saas-update-card__title">What this does</div>
                            <div class="saas-update-card__msg">Clears config, application, route, and view caches (<code>optimize:clear</code> + related Artisan commands), then reloads this page automatically.</div>
                        </div>

                        <div class="saas-update-actions">
                            <button type="button" class="btn btn--primary saas-btn" id="btnClearCache">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                                Clear cache &amp; reload
                            </button>
                        </div>

                        <p class="saas-help">Use this after an update if styles or menus look outdated. Admin only.</p>

                        <div class="saas-field">
                            <label class="saas-label">Command output</label>
                            <pre class="saas-update-console" id="cacheConsole">Ready.</pre>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Updates --}}
            <div class="saas-settings-panel" data-panel="updates" @if($activeTab !== 'updates') hidden @endif>
                <section class="saas-panel">
                    <div class="saas-panel__head">
                        <div>
                            <h2 class="saas-panel__title">System updates</h2>
                            <p class="saas-panel__sub">Check GitHub releases, pull the latest code, and run standard Artisan maintenance.</p>
                        </div>
                    </div>
                    <div class="saas-panel__body">
                        <div class="saas-row saas-row--2">
                            <div class="saas-field">
                                <div class="saas-eyebrow">Installed</div>
                                <div class="saas-update-card">
                                    <div class="saas-update-card__title" id="updateLocalBranch">Loading…</div>
                                    <div class="saas-update-card__meta" id="updateLocalMeta">—</div>
                                    <div class="saas-update-card__msg" id="updateLocalMsg"></div>
                                </div>
                            </div>
                            <div class="saas-field">
                                <div class="saas-eyebrow">GitHub release</div>
                                <div class="saas-update-card">
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
                            Pull uses <code>git pull --ff-only</code>, then migrate (optional), cache clears, and <code>storage:link</code>. Admin only.
                        </p>

                        <div class="saas-field">
                            <label class="saas-label">Command output</label>
                            <pre class="saas-update-console" id="updateConsole">Ready.</pre>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabLabels = @json(collect($tabs)->mapWithKeys(fn ($t, $k) => [$k => $t['label']]));
    var saveBar = document.getElementById('settingsSaveBar');
    var previewBox = document.querySelector('[data-settings-preview]');
    var csrf = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('#settingsForm input[name="_token"]')?.value
        || '';

    function showTab(tab) {
        document.querySelectorAll('.saas-settings-nav__item').forEach(function (b) {
            b.classList.toggle('is-active', b.dataset.tab === tab);
        });
        document.querySelectorAll('.saas-settings-panel').forEach(function (p) {
            p.hidden = p.dataset.panel !== tab;
        });
        if (saveBar) saveBar.style.display = (tab === 'updates' || tab === 'cache') ? 'none' : '';
        if (previewBox) previewBox.style.display = tab === 'general' ? '' : 'none';
        var pill = document.getElementById('settingsTabPillText');
        if (pill) pill.textContent = tabLabels[tab] || tab;
        if (tab === 'updates') loadStatus();
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tab);
        window.history.replaceState({}, '', url);
    }

    document.querySelectorAll('.saas-settings-nav__item').forEach(function (btn) {
        btn.addEventListener('click', function () { showTab(btn.dataset.tab); });
    });

    var siteName = document.getElementById('site_name');
    var tagline = document.getElementById('tagline');
    function syncPreview() {
        var name = (siteName?.value || '').trim() || 'Site name';
        document.getElementById('liveSettingsTitle').textContent = name;
        document.getElementById('previewName').textContent = name;
        if (tagline) {
            document.getElementById('previewTagline').textContent = tagline.value.trim() || 'Site tagline';
        }
        var mark = document.querySelector('#previewLogo .saas-settings-preview__mark');
        if (mark) mark.textContent = name.charAt(0).toUpperCase();
    }
    siteName?.addEventListener('input', syncPreview);
    tagline?.addEventListener('input', syncPreview);

    document.querySelectorAll('[data-dropzone]').forEach(function (zone) {
        var input = zone.querySelector('.saas-dropzone__input');
        var preview = zone.querySelector('.saas-dropzone__preview');
        if (!input || !preview) return;
        input.addEventListener('change', function () {
            var file = (input.files || [])[0];
            if (!file) return;
            var url = URL.createObjectURL(file);
            if (zone.dataset.dropzone === 'logo') {
                preview.innerHTML =
                    '<div class="saas-logo-frame"><img src="' + url + '" alt="New logo"></div>' +
                    '<div class="saas-dropzone__overlay"><span>Replace logo</span></div>';
                document.getElementById('previewLogo').innerHTML = '<img src="' + url + '" alt="Logo">';
            } else if (zone.dataset.dropzone === 'favicon') {
                preview.innerHTML =
                    '<img src="' + url + '" alt="Favicon" style="width:48px;height:48px;object-fit:contain;border-radius:8px">' +
                    '<div class="saas-dropzone__overlay"><span>Replace</span></div>';
            } else {
                preview.innerHTML =
                    '<img src="' + url + '" alt="" style="max-width:100%;max-height:220px;object-fit:cover;border-radius:8px">' +
                    '<div class="saas-dropzone__overlay"><span>Replace image</span></div>';
            }
        });
        ['dragenter', 'dragover'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.add('is-drag'); });
        });
        ['dragleave', 'drop'].forEach(function (evt) {
            zone.addEventListener(evt, function (e) { e.preventDefault(); zone.classList.remove('is-drag'); });
        });
    });

    function setBusy(busy) {
        ['btnUpdateCheck', 'btnUpdatePull', 'btnUpdateMaintain', 'btnClearCache'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.disabled = busy;
        });
    }

    function appendConsole(lines, consoleId) {
        var cons = document.getElementById(consoleId || 'updateConsole');
        if (!cons) return;
        cons.textContent = (typeof lines === 'string' ? lines : (lines || []).join('\n')) || 'Done.';
        cons.scrollTop = cons.scrollHeight;
    }

    function formatSteps(steps) {
        if (!steps || !steps.length) return '';
        return steps.map(function (s) {
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
            var dirtyList = (local.dirty_files || []).join(', ');
            document.getElementById('updateLocalMsg').textContent +=
                (local.message ? ' · ' : '') + 'Local changes' + (dirtyList ? ': ' + dirtyList : '');
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

    async function api(url, method, options) {
        options = options || {};
        var consoleId = options.consoleId || 'updateConsole';
        setBusy(true);
        appendConsole('Running…', consoleId);
        try {
            var res = await fetch(url, {
                method: method || 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            var json = await res.json().catch(function () { return {}; });
            if (json.data) renderStatus(json.data);
            var out = [];
            if (json.message) out.push(json.message);
            if (json.steps) out.push(formatSteps(json.steps));
            if (json.data && json.data.steps && json.data.steps.length) {
                out.push(formatSteps(json.data.steps));
            }
            if (!out.length) out.push(res.ok ? 'OK' : ('HTTP ' + res.status));
            appendConsole(out.join('\n\n'), consoleId);
            if (json.reload && json.ok) {
                setTimeout(function () {
                    var next = new URL(window.location.href);
                    next.searchParams.set('tab', options.reloadTab || 'cache');
                    next.searchParams.set('_', String(Date.now()));
                    window.location.href = next.toString();
                }, 700);
            }
            return json;
        } catch (e) {
            appendConsole('Error: ' + e.message, consoleId);
            return null;
        } finally {
            setBusy(false);
        }
    }

    function loadStatus() {
        api(@json(route('admin.settings.updates.status')), 'GET');
    }

    document.getElementById('btnUpdateCheck')?.addEventListener('click', function () {
        api(@json(route('admin.settings.updates.check')), 'POST');
    });
    document.getElementById('btnUpdatePull')?.addEventListener('click', function () {
        if (!confirm('Pull latest from GitHub and run Artisan maintenance? This cannot be undone easily.')) return;
        api(@json(route('admin.settings.updates.pull')), 'POST');
    });
    document.getElementById('btnUpdateMaintain')?.addEventListener('click', function () {
        api(@json(route('admin.settings.updates.maintenance')), 'POST');
    });
    document.getElementById('btnClearCache')?.addEventListener('click', function () {
        api(@json(route('admin.settings.cache.clear')), 'POST', {
            consoleId: 'cacheConsole',
            reloadTab: 'cache'
        });
    });

    if (@json($activeTab === 'updates')) loadStatus();
});
</script>
@endpush
