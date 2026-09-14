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
                <div class="pf-gallery-wrap" data-pf-gallery>
                    <div class="pf-gallery-head">
                        <h2>{{ __('Gallery') }}</h2>
                        @if(count($project->gallery_images) > 1)
                        <div class="pf-gallery-nav">
                            <button type="button" class="pf-gallery-btn" data-pf-prev aria-label="{{ __('Previous image') }}" disabled>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                            </button>
                            <span class="pf-gallery-counter" data-pf-counter>1 / {{ count($project->gallery_images) }}</span>
                            <button type="button" class="pf-gallery-btn" data-pf-next aria-label="{{ __('Next image') }}">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="gallery-grid" data-pf-track>
                        @foreach($project->gallery_images as $img)
                        <button type="button" class="img-zoom" data-zoom-src="{{ asset('storage/' . $img) }}" data-zoom-alt="{{ $project->title }} — {{ __('Gallery') }}" aria-label="{{ __('View full image') }}">
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ __('Gallery') }}">
                        </button>
                        @endforeach
                    </div>
                    @if(count($project->gallery_images) > 1)
                    <div class="pf-gallery-dots" data-pf-dots role="tablist" aria-label="{{ __('Gallery pagination') }}">
                        @foreach($project->gallery_images as $idx => $img)
                        <button type="button" class="pf-gallery-dot {{ $loop->first ? 'is-active' : '' }}" data-pf-dot="{{ $idx }}" aria-label="{{ __('Go to image') }} {{ $idx + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif
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
  /* Mobile Gallery Carousel Controller */
  var wrap = document.querySelector('[data-pf-gallery]');
  if (wrap) {
    var track = wrap.querySelector('[data-pf-track]');
    var slides = track ? Array.prototype.slice.call(track.querySelectorAll('.img-zoom')) : [];
    if (track && slides.length > 1) {
      var dots = Array.prototype.slice.call(wrap.querySelectorAll('[data-pf-dot]'));
      var counter = wrap.querySelector('[data-pf-counter]');
      var btnPrev = wrap.querySelector('[data-pf-prev]');
      var btnNext = wrap.querySelector('[data-pf-next]');
      var total = slides.length;
      var currentIndex = 0;

      function updateState(idx) {
        currentIndex = Math.max(0, Math.min(idx, total - 1));
        if (counter) counter.textContent = (currentIndex + 1) + ' / ' + total;
        if (btnPrev) btnPrev.disabled = (currentIndex === 0);
        if (btnNext) btnNext.disabled = (currentIndex === total - 1);
        dots.forEach(function (dot, i) {
          dot.classList.toggle('is-active', i === currentIndex);
        });
      }

      function scrollToIndex(idx) {
        if (idx < 0 || idx >= total) return;
        var target = slides[idx];
        if (target && track) {
          var trackRect = track.getBoundingClientRect();
          var targetRect = target.getBoundingClientRect();
          var offset = targetRect.left - trackRect.left + track.scrollLeft;
          var centerOffset = offset - (track.clientWidth - target.clientWidth) / 2;
          track.scrollTo({ left: centerOffset, behavior: 'smooth' });
        }
        updateState(idx);
      }

      var scrollTimer = null;
      track.addEventListener('scroll', function () {
        if (scrollTimer) clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function () {
          var trackCenter = track.scrollLeft + track.clientWidth / 2;
          var closestIndex = 0;
          var minDiff = Infinity;
          slides.forEach(function (slide, i) {
            var slideCenter = slide.offsetLeft + slide.clientWidth / 2;
            var diff = Math.abs(slideCenter - trackCenter);
            if (diff < minDiff) {
              minDiff = diff;
              closestIndex = i;
            }
          });
          updateState(closestIndex);
        }, 40);
      }, { passive: true });

      dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
          var idx = parseInt(this.getAttribute('data-pf-dot'), 10);
          scrollToIndex(idx);
        });
      });

      if (btnPrev) {
        btnPrev.addEventListener('click', function () {
          scrollToIndex(currentIndex - 1);
        });
      }

      if (btnNext) {
        btnNext.addEventListener('click', function () {
          scrollToIndex(currentIndex + 1);
        });
      }
    }
  }

  /* Lightbox zoom viewer */
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
  var btnPrevLB = overlay.querySelector('.img-lightbox__nav--prev');
  var btnNextLB = overlay.querySelector('.img-lightbox__nav--next');
  var index = 0;
  var lastFocus = null;

  function show(i) {
    index = (i + triggers.length) % triggers.length;
    var t = triggers[index];
    imgEl.src = t.getAttribute('data-zoom-src');
    imgEl.alt = t.getAttribute('data-zoom-alt') || '';
    capEl.textContent = imgEl.alt;
    var multi = triggers.length > 1;
    btnPrevLB.hidden = !multi;
    btnNextLB.hidden = !multi;
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
  btnPrevLB.addEventListener('click', function (e) { e.stopPropagation(); show(index - 1); });
  btnNextLB.addEventListener('click', function (e) { e.stopPropagation(); show(index + 1); });

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
