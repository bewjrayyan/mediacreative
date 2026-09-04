/**
 * Bridges Adminator 2026 shell with Laravel admin routes + auth user.
 * Runs after the 2026 bundle mounts the shell (same DOMContentLoaded queue order).
 */
(function () {
  function basePath() {
    if (typeof window.ADMINATOR_BASE_PATH === 'string') {
      return window.ADMINATOR_BASE_PATH.replace(/\/$/, '');
    }
    var home = (window.ADMINATOR_USER && window.ADMINATOR_USER.homeUrl) || '';
    try {
      var path = new URL(home, window.location.origin).pathname.replace(/\/admin\/?$/, '');
      return path === '/' ? '' : path.replace(/\/$/, '');
    } catch (e) {
      return '';
    }
  }

  function withBase(href) {
    if (!href || href === '#' || href.indexOf('javascript:') === 0) return href;
    if (/^https?:\/\//i.test(href) || href.indexOf('mailto:') === 0) return href;
    var prefix = basePath();
    if (!prefix) return href;
    if (href.indexOf(prefix + '/') === 0 || href === prefix) return href;
    if (href.charAt(0) === '/') return prefix + href;
    return href;
  }

  function patchAdminPaths() {
    document.querySelectorAll('a[href]').forEach(function (a) {
      var href = a.getAttribute('href') || '';
      if (href === '/admin' || href.indexOf('/admin/') === 0) {
        a.setAttribute('href', withBase(href));
      }
    });
  }

  function patchHtmlLinks() {
    var map = window.ADMINATOR_ROUTES || {};
    document.querySelectorAll('a[href$=".html"]').forEach(function (a) {
      var href = a.getAttribute('href') || '';
      var file = href.split('/').pop();
      if (map[file]) a.setAttribute('href', map[file]);
    });
  }

  function patchNavHrefs() {
    var map = window.ADMINATOR_ROUTES || {};
    document.querySelectorAll('.d-sidebar a.nav-link[href], .nav-submenu a[href]').forEach(function (a) {
      var href = a.getAttribute('href') || '';
      var file = href.split('/').pop();
      if (map[file]) {
        a.setAttribute('href', map[file]);
      } else if (href === 'index.html' && map['index.html']) {
        a.setAttribute('href', map['index.html']);
      }
    });
  }

  function injectFrontendButton() {
    var u = window.ADMINATOR_USER;
    var actions = document.querySelector('.d-topbar .topbar-actions');
    if (!u || !u.frontendUrl || !actions) return;
    if (actions.querySelector('.topbar-frontend')) return;

    var link = document.createElement('a');
    link.className = 'topbar-frontend';
    link.href = u.frontendUrl;
    link.target = '_blank';
    link.rel = 'noopener noreferrer';
    link.setAttribute('aria-label', 'View frontend website');
    link.innerHTML =
      '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">' +
      '<path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>' +
      '<path d="M15 3h6v6"/><path d="M10 14 21 3"/>' +
      '</svg>' +
      '<span>View site</span>';

    var search = actions.querySelector('.cmd');
    if (search) {
      actions.insertBefore(link, search);
    } else {
      actions.insertBefore(link, actions.firstChild);
    }
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function patchFooter() {
    var u = window.ADMINATOR_USER;
    var footer = document.querySelector('.d-footer');
    if (!footer || !u) return;

    var copyrightEl = footer.querySelector(':scope > div:not(.d-footer-meta)');
    if (copyrightEl && u.copyright) {
      copyrightEl.textContent = u.copyright;
    }

    var meta = footer.querySelector('.d-footer-meta');
    if (meta) {
      var version = u.appVersion ? 'v' + String(u.appVersion).replace(/^v/i, '') : '';
      var site = u.siteName || '';
      meta.innerHTML =
        (version ? '<span>' + escapeHtml(version) + '</span>' : '') +
        (site ? '<span>' + escapeHtml(site) + '</span>' : '');
    }
  }

  function personalizeShell() {
    var u = window.ADMINATOR_USER;
    if (!u) return;

    var workspaceName = document.querySelector('.workspace-name');
    var workspaceRole = document.querySelector('.workspace-role');
    var workspaceAvatar = document.querySelector('.workspace-avatar');
    if (workspaceName) workspaceName.textContent = u.name;
    if (workspaceRole) workspaceRole.textContent = u.role;
    if (workspaceAvatar) workspaceAvatar.textContent = u.initials;

    var profileName = document.querySelector('.dd-profile-name');
    var profileEmail = document.querySelector('.dd-profile-email');
    var topAvatar = document.querySelector('.d-topbar .avatar');
    if (profileName) profileName.textContent = u.name;
    if (profileEmail) profileEmail.textContent = u.email;
    if (topAvatar) topAvatar.textContent = u.initials;

    var brand = document.querySelector('.d-sidebar .brand');
    if (brand && u.homeUrl) {
      brand.style.cursor = 'pointer';
      brand.addEventListener('click', function () {
        window.location.href = u.homeUrl;
      });
    }

    document.querySelectorAll('.dd-profile a.dd-menu-item').forEach(function (a) {
      var text = (a.textContent || '').trim();
      if (text === 'Settings' && u.settingsUrl) a.setAttribute('href', u.settingsUrl);
      if (text === 'Messages' && u.messagesUrl) a.setAttribute('href', u.messagesUrl);
      if (text === 'Logout') {
        a.setAttribute('href', '#');
        a.addEventListener('click', function (e) {
          e.preventDefault();
          var form = document.getElementById('adminLogoutForm');
          if (form) form.submit();
        });
      }
    });

    patchFooter();
  }

  function dismissFlash() {
    document.querySelectorAll('.flash-alert').forEach(function (el) {
      setTimeout(function () {
        el.style.opacity = '0';
        el.style.transition = 'opacity .5s';
        setTimeout(function () { el.remove(); }, 500);
      }, 4000);
    });
  }

  function start() {
    // Shell mounts in the 2026 bundle's DOMContentLoaded handler, registered first.
    // Defer one tick so mountShell has painted the chrome.
    setTimeout(function () {
      patchAdminPaths();
      patchNavHrefs();
      patchHtmlLinks();
      injectFrontendButton();
      personalizeShell();
      dismissFlash();
    }, 0);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', start);
  } else {
    start();
  }
})();
