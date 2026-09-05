@extends('layouts.app')

@section('title', $project->title . ' - ' . __('Portfolio'))

@section('content')
<section class="page-hero">
    <div class="container">
        <span class="project-cat" style="color:var(--primary);font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em">{{ $project->category }}</span>
        <h1 style="margin-top:10px">{{ $project->title }}</h1>
        @if($project->client)<p style="color:var(--text-light)">{{ __('Client') }}: {{ $project->client }}</p>@endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="blog-single">
            @if($project->thumbnail)
            <div class="cover">
                <button type="button" class="img-zoom" data-zoom-src="{{ asset('storage/' . $project->thumbnail) }}" data-zoom-alt="{{ $project->title }}" aria-label="{{ __('View full image') }}">
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
                </button>
            </div>
            @endif

            <div class="blog-content">
                <div class="project-prose">{!! strip_tags($project->description, '<p><br><br/><strong><b><em><i><u><ul><ol><li><a><h2><h3><blockquote>') !!}</div>

                @if(!empty($project->gallery_images))
                <h2>{{ __('Gallery') }}</h2>
                <div class="gallery-grid">
                    @foreach($project->gallery_images as $img)
                    <button type="button" class="img-zoom" data-zoom-src="{{ asset('storage/' . $img) }}" data-zoom-alt="{{ $project->title }} — {{ __('Gallery') }}" aria-label="{{ __('View full image') }}">
                        <img src="{{ asset('storage/' . $img) }}" alt="{{ __('Gallery') }}">
                    </button>
                    @endforeach
                </div>
                @endif

                @if(!empty($project->technologies))
                <h2>{{ __('Technologies Used') }}</h2>
                <div class="tech-tags">
                    @foreach($project->technologies as $tech)
                    <span class="tech-tag">{{ $tech }}</span>
                    @endforeach
                </div>
                @endif

                @if($project->url)
                <div style="margin-top:32px">
                    <a href="{{ $project->url }}" target="_blank" class="btn btn-primary btn-lg">
                        {{ __('Visit Live Project') }}
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <h2>{{ __('Related Projects') }}</h2>
        </div>
        <div class="portfolio-grid">
            @foreach($related as $rel)
            <a href="{{ route('portfolio.show', $rel->slug) }}" class="project-card">
                <div class="project-thumb">
                    @if($rel->thumbnail)
                        <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->title }}">
                    @else
                        <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">{{ __('No Image') }}</div>
                    @endif
                </div>
                <div class="project-body">
                    <span class="project-cat">{{ $rel->category }}</span>
                    <h3>{{ $rel->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
(function () {
  var triggers = Array.prototype.slice.call(document.querySelectorAll('.img-zoom[data-zoom-src]'));
  if (!triggers.length) return;

  var overlay = document.createElement('div');
  overlay.className = 'img-lightbox';
  overlay.setAttribute('role', 'dialog');
  overlay.setAttribute('aria-modal', 'true');
  overlay.setAttribute('aria-label', @json(__('Image viewer')));
  overlay.hidden = true;
  overlay.innerHTML =
    '<button type="button" class="img-lightbox__close" aria-label="' + @json(__('Close')) + '">&times;</button>' +
    '<button type="button" class="img-lightbox__nav img-lightbox__nav--prev" aria-label="' + @json(__('Previous image')) + '">&#8249;</button>' +
    '<button type="button" class="img-lightbox__nav img-lightbox__nav--next" aria-label="' + @json(__('Next image')) + '">&#8250;</button>' +
    '<figure class="img-lightbox__figure"><img class="img-lightbox__img" alt=""><figcaption class="img-lightbox__cap"></figcaption></figure>';
  document.body.appendChild(overlay);

  var imgEl = overlay.querySelector('.img-lightbox__img');
  var capEl = overlay.querySelector('.img-lightbox__cap');
  var btnClose = overlay.querySelector('.img-lightbox__close');
  var btnPrev = overlay.querySelector('.img-lightbox__nav--prev');
  var btnNext = overlay.querySelector('.img-lightbox__nav--next');
  var index = 0;
  var lastFocus = null;

  function show(i) {
    index = (i + triggers.length) % triggers.length;
    var t = triggers[index];
    imgEl.src = t.getAttribute('data-zoom-src');
    imgEl.alt = t.getAttribute('data-zoom-alt') || '';
    capEl.textContent = imgEl.alt;
    var multi = triggers.length > 1;
    btnPrev.hidden = !multi;
    btnNext.hidden = !multi;
  }

  function open(i) {
    lastFocus = document.activeElement;
    show(i);
    overlay.hidden = false;
    document.documentElement.classList.add('img-lightbox-open');
    btnClose.focus();
  }

  function close() {
    overlay.hidden = true;
    document.documentElement.classList.remove('img-lightbox-open');
    imgEl.removeAttribute('src');
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }

  triggers.forEach(function (btn, i) {
    btn.addEventListener('click', function () { open(i); });
  });

  btnClose.addEventListener('click', close);
  btnPrev.addEventListener('click', function (e) { e.stopPropagation(); show(index - 1); });
  btnNext.addEventListener('click', function (e) { e.stopPropagation(); show(index + 1); });

  overlay.addEventListener('click', function (e) {
    if (e.target === overlay || e.target.classList.contains('img-lightbox__figure')) close();
  });

  document.addEventListener('keydown', function (e) {
    if (overlay.hidden) return;
    if (e.key === 'Escape') close();
    else if (e.key === 'ArrowLeft') show(index - 1);
    else if (e.key === 'ArrowRight') show(index + 1);
  });
})();
</script>
@endpush
