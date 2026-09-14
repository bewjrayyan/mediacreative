@if($errors->any())<div class="saas-alert" role="alert"><div><strong>Fix the following issues</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
<section class="saas-panel saas-menu-form"><div class="saas-panel__body">
    <div class="saas-field"><label class="saas-label" for="label">Label <span class="req">*</span></label><input class="saas-input" id="label" name="label" value="{{ old('label', $menuItem->label ?? '') }}" required>@error('label')<p class="saas-error">{{ $message }}</p>@enderror</div>
    @php($selectedPageSlug = old('page_slug', $selectedPageSlug ?? ''))
    <div class="saas-field">
        <label class="saas-label" for="page_slug">Link to CMS page</label>
        <select class="saas-input" id="page_slug" name="page_slug">
            <option value="">Custom URL or external link</option>
            @foreach($pages as $page)
                <option value="{{ $page->slug }}" @selected($selectedPageSlug === $page->slug)>{{ $page->title }} ({{ $page->slug === 'about' ? '/about' : '/page/' . $page->slug }})</option>
            @endforeach
        </select>
        @error('page_slug')<p class="saas-error">{{ $message }}</p>@enderror
    </div>
    <div class="saas-field">
        <label class="saas-label" for="url">Custom URL</label>
        <input class="saas-input" id="url" name="url" value="{{ old('url', $menuItem->url ?? '') }}" placeholder="/services or https://example.com">
        <p class="saas-help">Choose a CMS page above, or leave it empty and enter an internal path or external URL here.</p>
        @error('url')<p class="saas-error">{{ $message }}</p>@enderror
    </div>
    <div class="saas-field"><label class="saas-label" for="location">Location</label><select class="saas-input" id="location" name="location"><option value="header" @selected(old('location', $menuItem->location ?? 'header') === 'header')>Header</option><option value="footer" @selected(old('location', $menuItem->location ?? 'header') === 'footer')>Footer</option></select></div>
    <div class="saas-field"><label class="saas-label" for="sort_order">Order</label><input class="saas-input" id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $menuItem->sort_order ?? 0) }}"></div>
    <label class="saas-switch-row"><span><span class="saas-switch-label">Show on website</span></span><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $menuItem->is_active ?? true))></label>
</div></section>
