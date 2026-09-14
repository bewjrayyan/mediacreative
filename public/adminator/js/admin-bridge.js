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
      } else if (href.indexOf('/admin/') === 0) {
        a.setAttribute('href', withBase(href));
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

  function patchBrand() {
    var u = window.ADMINATOR_USER;
    if (!u) return;

    var brandName = document.querySelector('.d-sidebar .brand-name');
    if (brandName && u.siteName) {
      brandName.textContent = u.siteName;
    }

    var brandTag = document.querySelector('.d-sidebar .brand-tag');
    if (brandTag && u.appVersion) {
      brandTag.textContent = 'v' + String(u.appVersion).replace(/^v/i, '');
    }

    var brandLogo = document.querySelector('.d-sidebar .brand-logo');
    if (brandLogo && u.logoUrl) {
      brandLogo.classList.add('brand-logo--image');
      brandLogo.innerHTML =
        '<img src="' + escapeHtml(u.logoUrl) + '" alt="' + escapeHtml(u.siteName || 'Logo') + '">';
    }
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
      if (text === 'Profile' && u.profileUrl) a.setAttribute('href', u.profileUrl);
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

    patchBrand();
    patchFooter();
  }

  function injectModuleNav() {
    var sidebar = document.querySelector('.d-sidebar');
    if (!sidebar) return;

    var activeKey = document.body.getAttribute('data-active') || '';
    var modulesUrl = window.ADMINATOR_MODULES_INDEX_URL || withBase('/admin/modules');
    var leadsUrl = window.ADMINATOR_LEADS_INDEX_URL || withBase('/admin/leads');
    var allModules = window.ADMINATOR_ALL_MODULES || [];
    var activeModules = window.ADMINATOR_ACTIVE_MODULES || allModules.filter(function (m) { return m.status === 'active'; });

    // Clean up static bundle "Modules" section or previous dynamic section to avoid duplicates
    sidebar.querySelectorAll('.nav-section').forEach(function (sec) {
      var l = sec.querySelector('.nav-label');
      if (l && (l.textContent || '').trim().toLowerCase() === 'modules') {
        sec.remove();
      }
      if (sec.classList.contains('nav-section--dynamic-modules')) {
        sec.remove();
      }
    });

    var moduleSec = document.createElement('nav');
    moduleSec.className = 'nav-section nav-section--dynamic-modules';

    var label = document.createElement('div');
    label.className = 'nav-label';
    label.textContent = 'Modules & Apps';
    moduleSec.appendChild(label);

    // 1. Modules Manager link
    var isModulesActive = (activeKey === 'modules');
    var allModLink = document.createElement('a');
    allModLink.className = 'nav-link' + (isModulesActive ? ' is-active' : '');
    allModLink.href = modulesUrl;
    allModLink.innerHTML =
      '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
      '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>' +
      '<rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>' +
      '</svg>' +
      '<span>Module Manager</span>' +
      '<span class="nav-badge new" style="background:#3B82F6;color:#fff">' + (allModules.length || 0) + ' TOTAL</span>';
    moduleSec.appendChild(allModLink);

    // 2. Active Module Menus (directly in main navbar)
    activeModules.forEach(function (mod) {
      var isCurrentActive = (activeKey === mod.slug || (mod.slug === 'lead-form' && activeKey === 'lead-form'));
      var linkHref = mod.url || (mod.slug === 'lead-form' ? leadsUrl : modulesUrl);
      var iconHtml = mod.icon || '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>';

      var item = document.createElement('a');
      item.className = 'nav-link' + (isCurrentActive ? ' is-active' : '');
      item.href = linkHref;
      item.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' + iconHtml + '</svg>' +
        '<span>' + escapeHtml(mod.name) + '</span>' +
        '<span class="nav-badge pro" style="background:#10B981;color:#fff">ACTIVE</span>';
      moduleSec.appendChild(item);
    });

    // 3. Dropdown Group for "Available Modules" in main navbar showing every available module
    if (allModules.length > 0) {
      var group = document.createElement('div');
      group.className = 'nav-item-group';
      group.setAttribute('data-nav-group', '');

      var isSubmenuOpen = allModules.some(function (m) { return m.slug === activeKey; });
      if (isSubmenuOpen) {
        group.classList.add('is-open');
      }

      var toggle = document.createElement('a');
      toggle.className = 'nav-link';
      toggle.href = 'javascript:void(0)';
      toggle.setAttribute('data-nav-toggle', '');
      toggle.innerHTML =
        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">' +
        '<path d="M4 6h16M4 12h16M4 18h16"/>' +
        '</svg>' +
        '<span>Available Modules</span>' +
        '<svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m9 18 6-6-6-6"/></svg>';

      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        group.classList.toggle('is-open');
      });

      var submenu = document.createElement('div');
      submenu.className = 'nav-submenu';

      allModules.forEach(function (mod) {
        var subItem = document.createElement('a');
        subItem.href = mod.status === 'active' ? (mod.url || modulesUrl) : modulesUrl;

        var badgeColor = mod.status === 'active' ? '#10B981' : (mod.status === 'installed' ? '#3B82F6' : '#6B7280');
        var badgeLabel = mod.status.toUpperCase();

        subItem.style.display = 'flex';
        subItem.style.alignItems = 'center';
        subItem.style.justifyContent = 'space-between';

        subItem.innerHTML =
          '<span>' + escapeHtml(mod.name) + '</span>' +
          '<span style="font-size:9.5px;font-weight:700;padding:2px 6px;border-radius:4px;background:' + badgeColor + ';color:#fff;margin-left:6px;flex-shrink:0;">' + badgeLabel + '</span>';

        if (activeKey === mod.slug) {
          subItem.classList.add('is-active');
        }
        submenu.appendChild(subItem);
      });

      group.appendChild(toggle);
      group.appendChild(submenu);
      moduleSec.appendChild(group);
    }

    // Insert section before System section or append to sidebar before footer
    var systemSec = null;
    sidebar.querySelectorAll('.nav-section').forEach(function (sec) {
      var l = sec.querySelector('.nav-label');
      if (l && (l.textContent || '').trim().toLowerCase() === 'system') {
        systemSec = sec;
      }
    });

    if (systemSec) {
      sidebar.insertBefore(moduleSec, systemSec);
    } else {
      var footer = sidebar.querySelector('.sidebar-footer');
      if (footer) {
        sidebar.insertBefore(moduleSec, footer);
      } else {
        sidebar.appendChild(moduleSec);
      }
    }
  }

  function injectTopbarModulesMenu() {
    var actions = document.querySelector('.d-topbar .topbar-actions');
    if (!actions || actions.querySelector('.topbar-modules-dd')) return;

    var allModules = window.ADMINATOR_ALL_MODULES || [];
    var modulesUrl = window.ADMINATOR_MODULES_INDEX_URL || withBase('/admin/modules');

    var ddWrap = document.createElement('div');
    ddWrap.className = 'dd-wrap topbar-modules-dd';

    var btn = document.createElement('button');
    btn.className = 'topbar-frontend';
    btn.setAttribute('aria-label', 'Available modules list');
    btn.style.cursor = 'pointer';
    btn.innerHTML =
      '<svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">' +
      '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>' +
      '<rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>' +
      '</svg>' +
      '<span>Modules (' + allModules.length + ')</span>';

    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      ddWrap.classList.toggle('is-open');
    });

    document.addEventListener('click', function(e) {
      if (!ddWrap.contains(e.target)) {
        ddWrap.classList.remove('is-open');
      }
    });

    var ddMenu = document.createElement('div');
    ddMenu.className = 'dd-menu';
    ddMenu.setAttribute('role', 'menu');
    ddMenu.style.width = '300px';

    var ddHead = document.createElement('div');
    ddHead.className = 'dd-head';
    ddHead.innerHTML = 'Available Modules (' + allModules.length + ')';
    ddMenu.appendChild(ddHead);

    var ddList = document.createElement('div');
    ddList.className = 'dd-list';

    allModules.forEach(function(mod) {
      var item = document.createElement('a');
      item.className = 'dd-item';
      item.href = mod.status === 'active' ? (mod.url || modulesUrl) : modulesUrl;

      var badgeColor = mod.status === 'active' ? '#10B981' : (mod.status === 'installed' ? '#3B82F6' : '#6B7280');
      var iconSvg = mod.icon || '<rect x="3" y="3" width="7" height="7" rx="1"/>';

      item.innerHTML =
        '<div class="dd-avatar" style="background:var(--primary-soft);color:var(--primary);">' +
        '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">' + iconSvg + '</svg>' +
        '</div>' +
        '<div class="dd-body">' +
        '<div class="dd-text"><strong>' + escapeHtml(mod.name) + '</strong></div>' +
        '<div class="dd-time" style="color:' + badgeColor + ';font-weight:700;">STATUS: ' + mod.status.toUpperCase() + '</div>' +
        '</div>';
      ddList.appendChild(item);
    });

    var viewAllItem = document.createElement('a');
    viewAllItem.className = 'dd-item';
    viewAllItem.href = modulesUrl;
    viewAllItem.style.background = 'var(--bg-muted)';
    viewAllItem.style.justifyContent = 'center';
    viewAllItem.style.fontWeight = '700';
    viewAllItem.style.color = 'var(--primary)';
    viewAllItem.innerHTML = 'Open Module Manager &rarr;';
    ddList.appendChild(viewAllItem);

    ddMenu.appendChild(ddList);
    ddWrap.appendChild(btn);
    ddWrap.appendChild(ddMenu);

    var search = actions.querySelector('.cmd');
    if (search) {
      actions.insertBefore(ddWrap, search);
    } else {
      actions.appendChild(ddWrap);
    }
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
      injectModuleNav();
      injectTopbarModulesMenu();
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
