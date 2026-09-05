{{--
  TinyMCE rich editor bootstrap.
  Include once per page that has textarea[data-rich-editor].
  Auto-inits all matching textareas; call initSaasRichEditor() for custom options.
--}}
@once
@push('styles')
<style>
    .saas-rich-editor .tox-tinymce {
        border-radius: 12px !important;
        border: 1.5px solid var(--border) !important;
        box-shadow: none !important;
    }
    .saas-rich-editor .tox-tinymce:focus-within {
        border-color: color-mix(in srgb, var(--primary) 55%, var(--border)) !important;
    }
    .saas-rich-editor .tox-editor-header {
        box-shadow: none !important;
        border-bottom: 1px solid var(--border-soft, var(--border)) !important;
        padding: 4px 6px !important;
    }
    .saas-rich-editor .tox .tox-toolbar__primary {
        background: var(--bg-muted, #F8FAFC) !important;
    }
    .saas-rich-editor textarea.saas-textarea[data-rich-editor] {
        min-height: 220px;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@7.6.1/tinymce.min.js" referrerpolicy="origin"></script>
<script>
window.initSaasRichEditor = function (selector, options) {
  if (!window.tinymce) return;
  var opts = options || {};
  var nodes = typeof selector === 'string'
    ? Array.prototype.slice.call(document.querySelectorAll(selector))
    : [selector];

  nodes.forEach(function (el) {
    if (!el || !el.id) return;
    if (window.tinymce.get(el.id)) return;

    var height = opts.height
      || parseInt(el.getAttribute('data-rich-height') || '360', 10)
      || 360;

    tinymce.init(Object.assign({
      selector: '#' + el.id,
      base_url: 'https://cdn.jsdelivr.net/npm/tinymce@7.6.1',
      suffix: '.min',
      height: height,
      menubar: false,
      branding: false,
      promotion: false,
      statusbar: true,
      resize: true,
      plugins: 'lists link autolink code',
      toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter | bullist numlist | link | removeformat | code',
      block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3',
      link_default_target: '_blank',
      link_assume_external_targets: true,
      convert_urls: false,
      content_style: 'body{font-family:Inter,system-ui,sans-serif;font-size:14.5px;line-height:1.65;color:#0f172a;padding:12px 14px}p{margin:0 0 .85em}h2{font-size:1.35em;margin:1.1em 0 .5em}h3{font-size:1.15em;margin:1em 0 .4em}ul,ol{margin:0 0 .85em;padding-left:1.35em}a{color:#2563EB}',
      setup: function (editor) {
        editor.on('change keyup SetContent Undo Redo', function () {
          editor.save();
          var node = document.getElementById(editor.id);
          if (node) {
            node.dispatchEvent(new Event('input', { bubbles: true }));
          }
          if (typeof opts.onUpdate === 'function') {
            opts.onUpdate(editor);
          }
        });
        editor.on('init', function () {
          if (typeof opts.onUpdate === 'function') {
            opts.onUpdate(editor);
          }
        });
      }
    }, opts.tinymce || {}));
  });
};

document.addEventListener('DOMContentLoaded', function () {
  if (typeof window.initSaasRichEditor === 'function') {
    window.initSaasRichEditor('textarea[data-rich-editor]');
  }
  document.querySelectorAll('form').forEach(function (form) {
    if (!form.querySelector('textarea[data-rich-editor]')) return;
    form.addEventListener('submit', function () {
      if (window.tinymce) {
        window.tinymce.triggerSave();
      }
    });
  });
});
</script>
@endpush
@endonce
