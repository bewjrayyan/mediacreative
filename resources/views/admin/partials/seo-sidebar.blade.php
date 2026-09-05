{{--
  Included by: pages/posts/projects/services create+edit sidebars; settings SEO can reuse JS.
  Fields: meta_title, meta_description, meta_keywords → DB columns on content models.
  User: "pastikan masing masing ada panel meta keyword auto generated dan meta tile serta google search preview for seo di sidebar"
--}}
@php
    $metaTitle = old('meta_title', $metaTitle ?? '');
    $metaDescription = old('meta_description', $metaDescription ?? '');
    $metaKeywords = old('meta_keywords', $metaKeywords ?? '');
    $siteName = $siteName ?? site_name();
    $urlPrefix = $urlPrefix ?? '/';
    $titleSource = $titleSource ?? '#title';
    $descSources = $descSources ?? ['#excerpt', '#description', '#meta_description', '#content'];
    $slugSource = $slugSource ?? '#slug';
    $keywordSources = $keywordSources ?? ['#title', '#category', '#excerpt', '#description', '#content', '#technologies_input'];
    $host = parse_url(config('app.url'), PHP_URL_HOST) ?: request()->getHost();
@endphp

<section class="saas-panel saas-panel--side saas-seo-panel"
    data-seo-panel
    data-site-name="{{ $siteName }}"
    data-url-prefix="{{ $urlPrefix }}"
    data-host="{{ $host }}"
    data-title-source="{{ $titleSource }}"
    data-slug-source="{{ $slugSource }}"
    data-desc-sources="{{ implode(',', $descSources) }}"
    data-keyword-sources="{{ implode(',', $keywordSources) }}">
    <div class="saas-panel__head">
        <h2 class="saas-panel__title">SEO</h2>
    </div>
    <div class="saas-panel__body saas-panel__body--tight">
        <div class="saas-serp" aria-label="Google search preview">
            <div class="saas-serp__label">Google preview</div>
            <div class="saas-serp__card">
                <div class="saas-serp__url">
                    <span class="saas-serp__favicon" aria-hidden="true">{{ strtoupper(mb_substr($siteName, 0, 1)) }}</span>
                    <div class="saas-serp__crumbs">
                        <span class="saas-serp__host" data-seo-host>{{ $host }}</span>
                        <span class="saas-serp__path" data-seo-path>{{ rtrim($urlPrefix, '/') }}/…</span>
                    </div>
                </div>
                <a class="saas-serp__title" data-seo-preview-title href="javascript:void(0)" tabindex="-1">
                    {{ $metaTitle !== '' ? $metaTitle : ($siteName.' · …') }}
                </a>
                <p class="saas-serp__desc" data-seo-preview-desc>
                    {{ $metaDescription !== '' ? $metaDescription : 'Add a meta description to control how this page appears in Google search results.' }}
                </p>
            </div>
        </div>

        <div class="saas-field">
            <label class="saas-label" for="meta_title">
                Meta title
                <span class="saas-seo-count" data-seo-count="title">0/60</span>
            </label>
            <input class="saas-input{{ isset($errors) && $errors->has('meta_title') ? ' is-invalid' : '' }}"
                id="meta_title"
                type="text"
                name="meta_title"
                value="{{ $metaTitle }}"
                maxlength="70"
                data-seo-title
                placeholder="Auto from page title"
                autocomplete="off">
            @error('meta_title')<p class="saas-error">{{ $message }}</p>@enderror
            <p class="saas-help">Aim for ~50–60 characters.</p>
        </div>

        <div class="saas-field">
            <label class="saas-label" for="meta_description">
                Meta description
                <span class="saas-seo-count" data-seo-count="description">0/160</span>
            </label>
            <textarea class="saas-textarea{{ isset($errors) && $errors->has('meta_description') ? ' is-invalid' : '' }}"
                id="meta_description"
                name="meta_description"
                rows="3"
                maxlength="180"
                data-seo-description
                placeholder="Auto from excerpt / content">{{ $metaDescription }}</textarea>
            @error('meta_description')<p class="saas-error">{{ $message }}</p>@enderror
            <p class="saas-help">Aim for ~120–160 characters.</p>
        </div>

        <div class="saas-field">
            <div class="saas-label-row">
                <label class="saas-label" for="meta_keywords">Meta keywords</label>
                <button type="button" class="saas-seo-regen" data-seo-regen-keywords title="Regenerate from title &amp; content">
                    Auto
                </button>
            </div>
            <input class="saas-input{{ isset($errors) && $errors->has('meta_keywords') ? ' is-invalid' : '' }}"
                id="meta_keywords"
                type="text"
                name="meta_keywords"
                value="{{ $metaKeywords }}"
                maxlength="500"
                data-seo-keywords
                data-seo-keywords-auto="{{ $metaKeywords === '' ? '1' : '0' }}"
                placeholder="design, agency, branding"
                autocomplete="off">
            @error('meta_keywords')<p class="saas-error">{{ $message }}</p>@enderror
            <p class="saas-help">Comma-separated. Auto-fills from title &amp; content until you edit.</p>
        </div>
    </div>
</section>
