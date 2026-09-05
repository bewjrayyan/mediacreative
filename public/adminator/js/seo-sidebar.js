/**
 * Loaded by resources/views/admin/layouts/app.blade.php.
 * Drives [data-seo-panel] from admin/partials/seo-sidebar.blade.php.
 * API: live SERP preview, auto meta title/description/keywords.
 * User: "pastikan masing masing ada panel meta keyword auto generated dan meta tile serta google search preview for seo di sidebar"
 */
(function () {
  'use strict';

  var STOP = {
    a:1, an:1, the:1, and:1, or:1, but:1, in:1, on:1, at:1, to:1, for:1, of:1, with:1,
    by:1, from:1, as:1, is:1, are:1, was:1, were:1, be:1, been:1, being:1, have:1,
    has:1, had:1, do:1, does:1, did:1, will:1, would:1, could:1, should:1, may:1,
    might:1, must:1, shall:1, can:1, this:1, that:1, these:1, those:1, it:1, its:1,
    we:1, you:1, your:1, our:1, their:1, they:1, them:1, he:1, she:1, his:1, her:1,
    not:1, no:1, yes:1, if:1, then:1, than:1, so:1, too:1, very:1, just:1, about:1,
    into:1, over:1, after:1, before:1, between:1, through:1, during:1, without:1,
    via:1, per:1, each:1, all:1, any:1, some:1, such:1, only:1, own:1, same:1,
    other:1, more:1, most:1, also:1, how:1, what:1, when:1, where:1, who:1, why:1,
    which:1, while:1, here:1, there:1, out:1, up:1, down:1, off:1, again:1, further:1,
    once:1, yang:1, dan:1, atau:1, untuk:1, dengan:1, dari:1, pada:1, ini:1, itu:1,
    kami:1, kita:1, anda:1, mereka:1, adalah:1, dalam:1, ke:1, di:1, akan:1, sudah:1,
    belum:1, lebih:1, sangat:1, juga:1, serta:1, oleh:1, sebagai:1, seperti:1
  };

  function q(sel, root) {
    try { return (root || document).querySelector(sel); } catch (e) { return null; }
  }

  function qa(sel, root) {
    try { return Array.prototype.slice.call((root || document).querySelectorAll(sel)); } catch (e) { return []; }
  }

  function plain(el) {
    if (!el) return '';
    var v = ('value' in el) ? el.value : (el.textContent || '');
    return String(v).replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();
  }

  function truncate(str, max) {
    str = String(str || '').trim();
    if (str.length <= max) return str;
    var cut = str.slice(0, max - 1);
    var sp = cut.lastIndexOf(' ');
    if (sp > max * 0.6) cut = cut.slice(0, sp);
    return cut.replace(/[,\s.;:!-]+$/, '') + '…';
  }

  function generateKeywords(texts, limit) {
    limit = limit || 10;
    var bag = {};
    texts.forEach(function (text) {
      String(text || '').toLowerCase()
        .replace(/[^a-z0-9\u00c0-\u024f\s-]/gi, ' ')
        .split(/[\s/-]+/)
        .forEach(function (w) {
          if (w.length < 3 || STOP[w]) return;
          bag[w] = (bag[w] || 0) + 1;
        });
    });
    return Object.keys(bag)
      .sort(function (a, b) { return bag[b] - bag[a] || a.localeCompare(b); })
      .slice(0, limit)
      .join(', ');
  }

  function bindPanel(panel) {
    var siteName = panel.getAttribute('data-site-name') || 'Site';
    var urlPrefix = panel.getAttribute('data-url-prefix') || '/';
    var titleSel = panel.getAttribute('data-title-source') || '#title';
    var slugSel = panel.getAttribute('data-slug-source') || '#slug';
    var descSels = (panel.getAttribute('data-desc-sources') || '').split(',').filter(Boolean);
    var keySels = (panel.getAttribute('data-keyword-sources') || '').split(',').filter(Boolean);

    var titleInput = q('[data-seo-title]', panel);
    var descInput = q('[data-seo-description]', panel);
    var keywordsInput = q('[data-seo-keywords]', panel);
    var previewTitle = q('[data-seo-preview-title]', panel);
    var previewDesc = q('[data-seo-preview-desc]', panel);
    var previewPath = q('[data-seo-path]', panel);
    var countTitle = q('[data-seo-count="title"]', panel);
    var countDesc = q('[data-seo-count="description"]', panel);
    var regenBtn = q('[data-seo-regen-keywords]', panel);

    var titleAuto = titleInput && !String(titleInput.value || '').trim();
    var descAuto = descInput && !String(descInput.value || '').trim();
    var keywordsAuto = keywordsInput && keywordsInput.getAttribute('data-seo-keywords-auto') === '1';

    function sourceTitle() {
      return plain(q(titleSel)) || 'Untitled';
    }

    function sourceDesc() {
      for (var i = 0; i < descSels.length; i++) {
        var t = plain(q(descSels[i]));
        if (t) return t;
      }
      return '';
    }

    function sourceSlug() {
      var slug = plain(q(slugSel));
      if (!slug) {
        slug = sourceTitle().toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')
          .trim()
          .replace(/\s+/g, '-');
      }
      return slug;
    }

    function keywordCorpus() {
      return keySels.map(function (sel) { return plain(q(sel)); }).filter(Boolean);
    }

    function updateCounts() {
      if (countTitle && titleInput) {
        var n = titleInput.value.length;
        countTitle.textContent = n + '/60';
        countTitle.classList.toggle('is-warn', n > 60);
        countTitle.classList.toggle('is-ok', n >= 30 && n <= 60);
      }
      if (countDesc && descInput) {
        var d = descInput.value.length;
        countDesc.textContent = d + '/160';
        countDesc.classList.toggle('is-warn', d > 160);
        countDesc.classList.toggle('is-ok', d >= 70 && d <= 160);
      }
    }

    function updatePreview() {
      var metaTitle = plain(titleInput);
      var pageTitle = sourceTitle();
      var shownTitle = metaTitle || (pageTitle + (siteName ? ' · ' + siteName : ''));
      var metaDesc = plain(descInput) || truncate(sourceDesc(), 155) ||
        'Add a meta description to control how this page appears in Google search results.';
      var slug = sourceSlug();
      var prefix = urlPrefix.replace(/\/?$/, '/');
      if (prefix === '//') prefix = '/';

      if (previewTitle) previewTitle.textContent = truncate(shownTitle, 60);
      if (previewDesc) previewDesc.textContent = truncate(metaDesc, 160);
      if (previewPath) {
        previewPath.textContent = prefix === '/'
          ? ('/' + (slug || '…'))
          : (prefix + (slug || '…'));
      }
      updateCounts();
    }

    function maybeAutofill() {
      if (titleAuto && titleInput) {
        var t = sourceTitle();
        if (t && t !== 'Untitled') {
          titleInput.value = truncate(t + (siteName ? ' · ' + siteName : ''), 60).replace(/…$/, '');
        }
      }
      if (descAuto && descInput) {
        var d = sourceDesc();
        if (d) descInput.value = truncate(d, 155).replace(/…$/, '');
      }
      if (keywordsAuto && keywordsInput) {
        var keys = generateKeywords(keywordCorpus(), 10);
        if (keys) keywordsInput.value = keys;
      }
      updatePreview();
    }

    if (titleInput) {
      titleInput.addEventListener('input', function () {
        titleAuto = false;
        updatePreview();
      });
    }
    if (descInput) {
      descInput.addEventListener('input', function () {
        descAuto = false;
        updatePreview();
      });
    }
    if (keywordsInput) {
      keywordsInput.addEventListener('input', function () {
        keywordsAuto = false;
        keywordsInput.setAttribute('data-seo-keywords-auto', '0');
      });
    }
    if (regenBtn && keywordsInput) {
      regenBtn.addEventListener('click', function () {
        keywordsAuto = true;
        keywordsInput.setAttribute('data-seo-keywords-auto', '1');
        keywordsInput.value = generateKeywords(keywordCorpus(), 10);
      });
    }

    var watch = {};
    [titleSel, slugSel].concat(descSels).concat(keySels).forEach(function (sel) {
      if (!sel || watch[sel]) return;
      watch[sel] = true;
      var el = q(sel);
      if (!el) return;
      el.addEventListener('input', maybeAutofill);
      el.addEventListener('change', maybeAutofill);
    });

    maybeAutofill();
  }

  function boot() {
    qa('[data-seo-panel]').forEach(bindPanel);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
  } else {
    boot();
  }
})();
