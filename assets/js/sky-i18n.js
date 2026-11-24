/**
 * SKYWEB.AZ — SkyI18n: Client-Side Dynamic Translation Engine
 * -----------------------------------------------------------
 * • Switches all [data-i18n*] tagged elements instantly (no reload).
 * • SSR language is authoritative on load; instant switches are written back
 *   to the URL, cookie, localStorage and PHP session so nothing diverges.
 * • A literal layer translates legacy hardcoded strings and any dynamically
 *   generated text (toasts, demos, CV/autobiography output) via MutationObserver.
 */
(function () {
  'use strict';

  // ── Config ────────────────────────────────────────────────────────────
  const SUPPORTED = ['az', 'ru', 'en', 'tr'];
  const LANG_META = {
    az: { short: 'AZ',  flagImg: 'https://flagcdn.com/w40/az.png', flagImg2x: 'https://flagcdn.com/w80/az.png', alt: 'Azerbaijan',     name: 'Azərbaycan' },
    ru: { short: 'RU',  flagImg: 'https://flagcdn.com/w40/ru.png', flagImg2x: 'https://flagcdn.com/w80/ru.png', alt: 'Russia',         name: 'Русский'    },
    en: { short: 'ENG', flagImg: 'https://flagcdn.com/w40/gb.png', flagImg2x: 'https://flagcdn.com/w80/gb.png', alt: 'United Kingdom', name: 'English'    },
    tr: { short: 'TR',  flagImg: 'https://flagcdn.com/w40/tr.png', flagImg2x: 'https://flagcdn.com/w80/tr.png', alt: 'Turkey',         name: 'Türkçe'     }
  };
  const SYNC_URL = (function () {
    const s = document.currentScript;
    if (s && s.dataset.syncUrl) return s.dataset.syncUrl;
    const base = document.querySelector('base');
    return (base ? base.href : window.location.origin + '/sky/') + 'api/set-lang.php';
  })();

  const DATA       = window.__SKY_I18N_DATA__ || {};
  const DICTS      = window.__SKY_I18N__ || DATA.dicts || {};
  const REVERSE    = window.__SKY_REVERSE__ || DATA.reverse || {};
  const LITERALS   = window.__SKY_LITERALS__ || DATA.literals || {};
  // Exact target → AZ mappings recorded by the SSR output-buffer translator.
  // These win over the generic reverse map when several AZ phrases translate
  // to the same target word on this particular page.
  const SSR_REVERSE = window.__SKY_SSR_REVERSE__ || {};
  let   activeLang = 'az';
  // Language currently rendered in the DOM. Kept separate from activeLang so a
  // switch can canonicalize the OLD text before applying the NEW language.
  let   renderedLang = 'az';

  // ── Reverse source map ───────────────────────────────────────────────
  // SSR may already render a translated page. Remember the target → AZ form so
  // switching back restores the canonical source instead of keeping EN/RU/TR.
  const SOURCE_REVERSE = {};
  const SOURCE_PATTERN = {};
  let sourceReverseReady = false;

  function buildSourceReverse () {
    if (sourceReverseReady) return;
    SUPPORTED.forEach(function (l) { SOURCE_REVERSE[l] = {}; });
    // Dictionary reverse entries first; explicit literals must win because a
    // generic dictionary value can otherwise steal a branded string.
    Object.keys(REVERSE).forEach(function (az) {
      const key = REVERSE[az];
      SUPPORTED.forEach(function (l) {
        if (l === 'az') return;
        const val = (DICTS[l] || {})[key];
        if (typeof val === 'string' && val !== '') SOURCE_REVERSE[l][val] = az;
      });
    });
    Object.keys(LITERALS).forEach(function (az) {
      const row = LITERALS[az];
      if (!row || typeof row !== 'object') return;
      SUPPORTED.forEach(function (l) {
        if (l !== 'az' && typeof row[l] === 'string' && row[l] !== '') {
          SOURCE_REVERSE[l][row[l]] = az;
        }
      });
    });
    // Page-specific SSR replacements have the highest priority.
    const ssrLang = SSR_REVERSE.lang;
    const ssrMap = SSR_REVERSE.map || {};
    if (SUPPORTED.indexOf(ssrLang) !== -1) {
      Object.keys(ssrMap).forEach(function (target) {
        if (typeof ssrMap[target] === 'string' && ssrMap[target] !== '') {
          SOURCE_REVERSE[ssrLang][target] = ssrMap[target];
        }
      });
    }
    SUPPORTED.forEach(function (l) {
      if (l === 'az') return;
      const keys = Object.keys(SOURCE_REVERSE[l]).sort(function (a, b) { return b.length - a.length; });
      // Letter boundaries only: "Month" must not match inside a name such as
      // "Monthsel", while values like "Items" still match after a digit.
      SOURCE_PATTERN[l] = keys.length
        ? new RegExp('(?<!\\p{L})(?:' + keys.map(escRe).join('|') + ')(?!\\p{L})', 'gu')
        : null;
    });
    sourceReverseReady = true;
  }

  function canonicalSource (text, lang) {
    if (!text || lang === 'az') return text;
    buildSourceReverse();
    const map = SOURCE_REVERSE[lang] || {};
    const re = SOURCE_PATTERN[lang];
    if (!re) return text;
    re.lastIndex = 0;
    return String(text).replace(re, function (m) { return map[m] !== undefined ? map[m] : m; });
  }

  // Original (Azerbaijani) values, so switching back and forth never stacks
  // translations on top of each other.
  const textOriginals  = new WeakMap();
  const textApplied    = new WeakMap();
  const attrOriginals  = new WeakMap();
  const attrApplied    = new WeakMap();
  const cache          = new Map();
  const TRACKED_ATTRS  = ['placeholder', 'title', 'aria-label', 'alt', 'value'];
  let translating      = false;
  let titleInfo        = null;

  // ── Language Detection ─────────────────────────────────────────────
  // The server rendered this page using session/cookie. That value wins on a
  // fresh load; localStorage is only a fallback for static/offline pages.
  function detectLang () {
    const htmlLang = document.documentElement.lang;
    if (htmlLang && SUPPORTED.includes(htmlLang)) return htmlLang;
    const match = document.cookie.match(/(?:^|;\s*)sky_lang=([a-z]{2})/);
    if (match && SUPPORTED.includes(match[1])) return match[1];
    const ls = localStorage.getItem('sky_lang');
    if (ls && SUPPORTED.includes(ls)) return ls;
    return 'az';
  }

  // ── Key lookup ──────────────────────────────────────────────────────
  function t (lang, key) {
    const d = DICTS[lang] || DICTS['az'] || {};
    const fallback = (DICTS['az'] || {})[key] || key;
    return d[key] !== undefined ? d[key] : fallback;
  }

  function tCurrent (key) { return t(activeLang, key); }

  // ── Literal lookup (hardcoded / generated strings) ─────────────────
  function escRe (s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }

  let literalPattern = null;
  function buildLiteralPattern () {
    if (literalPattern) return literalPattern;
    const keys = Object.keys(LITERALS).concat(Object.keys(REVERSE))
      .filter(function (k) { return typeof k === 'string' && k.trim().length > 1; })
      .sort(function (a, b) { return b.length - a.length; });
    // Longest first so "Səbətə At" wins over "Səbət". Letter boundaries stop
    // short dictionary values ("Ay", "Əli", "Seç") from rewriting proper names
    // and derived words (Aysel, Əliyev, Seçiminizə). Numbers are not boundaries
    // here, so "3 ədəd" still matches the value with a leading space.
    const uniq = keys.filter(function (k, i) { return keys.indexOf(k) === i; });
    literalPattern = uniq.length
      ? new RegExp('(?<!\\p{L})(?:' + uniq.map(escRe).join('|') + ')(?!\\p{L})', 'gu')
      : null;
    return literalPattern;
  }

  function translatePiece (piece, lang) {
    if (lang === 'az') return piece;
    const hit = LITERALS[piece];
    if (hit && typeof hit === 'object') return hit[lang] || hit.az || piece;
    const key = REVERSE[piece];
    if (key && DICTS[lang] && DICTS[lang][key]) return DICTS[lang][key];
    return piece;
  }

  /**
   * Translate a whole string, preserving untranslated fragments and markup.
   * `fromLang` is the language the supplied text is currently rendered in, so
   * targets can be canonicalized back to AZ before being re-translated. This
   * makes both EN→AZ and EN→RU switches work on an SSR-translated page.
   */
  function tr (text, lang, fromLang) {
    lang = lang || activeLang;
    if (!text) return text;
    const from = fromLang || renderedLang || activeLang;
    const ck = lang + '\u0000' + from + '\u0000' + text;
    if (cache.has(ck)) return cache.get(ck);

    // Canonicalize the incoming text back to its Azerbaijani source form.
    const source = (from && from !== 'az') ? canonicalSource(text, from) : text;
    let out = source;
    if (lang !== 'az') {
      const re = buildLiteralPattern();
      if (re && re.test(source)) {
        re.lastIndex = 0;
        out = source.replace(re, function (m) { return translatePiece(m, lang); });
      } else {
        out = translatePiece(source, lang);
      }
    }
    if (cache.size > 6000) cache.clear();
    cache.set(ck, out);
    return out;
  }

  // ── Literal DOM application ────────────────────────────────────────
  function isSkippable (node) {
    if (!node || node.nodeType !== 1) return false;
    const tag = node.tagName;
    if (tag === 'SCRIPT' || tag === 'STYLE' || tag === 'NOSCRIPT' || tag === 'svg' || tag === 'SVG') return true;
    return node.hasAttribute('data-sky-no-translate');
  }

  function translateTextNode (node, lang, from) {
    if (!node.nodeValue || !node.nodeValue.trim()) return;
    let parent = node.parentElement;
    while (parent) {
      if (isSkippable(parent) || parent.hasAttribute('data-i18n') || parent.hasAttribute('data-i18n-html')) return;
      parent = parent.parentElement;
    }
    let source = textOriginals.get(node);
    const lastApplied = textApplied.get(node);
    // A script may replace textContent directly (toasts, modal summaries…).
    // Treat that as a brand-new source instead of re-translating stale text.
    if (source === undefined || (lastApplied !== undefined && node.nodeValue !== lastApplied && node.nodeValue !== source)) {
      source = canonicalSource(node.nodeValue, from);
      textOriginals.set(node, source);
    }
    const next = tr(source, lang, 'az');
    if (next !== node.nodeValue) node.nodeValue = next;
    if (next !== source) textApplied.set(node, next); else textApplied.delete(node);
  }

  function walkTextNodes (root, lang, from) {
    const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, {
      acceptNode: function (node) {
        if (!node.nodeValue || !node.nodeValue.trim()) return NodeFilter.FILTER_REJECT;
        let p = node.parentElement;
        while (p) {
          if (isSkippable(p) || p.hasAttribute('data-i18n') || p.hasAttribute('data-i18n-html')) return NodeFilter.FILTER_REJECT;
          p = p.parentElement;
        }
        return NodeFilter.FILTER_ACCEPT;
      }
    });
    let n;
    while ((n = walker.nextNode())) translateTextNode(n, lang, from);
  }

  function applyLiterals (root, lang, fromLang) {
    const from = fromLang || renderedLang || activeLang;
    translating = true;
    try {
      walkTextNodes(root || document.body, lang, from);
      const scope = root && root.nodeType === 1 ? [root].concat(Array.prototype.slice.call(root.querySelectorAll('*'))) :
        Array.prototype.slice.call(document.querySelectorAll('body *'));
      scope.forEach(function (el) {
        if (isSkippable(el)) return;
        TRACKED_ATTRS.forEach(function (attr) {
          if (!el.hasAttribute(attr)) return;
          let m = attrOriginals.get(el);
          if (!m) { m = {}; attrOriginals.set(el, m); }
          let applied = attrApplied.get(el);
          if (!applied) { applied = {}; attrApplied.set(el, applied); }
          const current = el.getAttribute(attr);
          let source = m[attr];
          // Scripts may set placeholder/title directly after a switch. Treat
          // that fresh target-language value as a new source rather than
          // reusing stale text from a previous language.
          if (source === undefined || (applied[attr] !== undefined && current !== applied[attr] && current !== source)) {
            source = canonicalSource(current, from);
            m[attr] = source;
          }
          const next = tr(source, lang, 'az');
          if (next !== current) el.setAttribute(attr, next);
          if (next !== source) applied[attr] = next; else delete applied[attr];
        });
      });
    } finally {
      translating = false;
    }
  }

  // Watch for dynamically created content (SkyBot bubbles, CV preview, toasts…)
  let obsTimer = null;
  function observeDynamicContent () {
    if (!('MutationObserver' in window)) return;
    const obs = new MutationObserver(function (mutations) {
      if (translating || activeLang === 'az') return;
      let changed = false;
      for (let i = 0; i < mutations.length; i++) {
        const m = mutations[i];
        if (m.type === 'childList' && m.addedNodes.length) { changed = true; break; }
        if (m.type === 'characterData') { changed = true; break; }
        if (m.type === 'attributes' && m.target && m.target.nodeType === 1) { changed = true; break; }
      }
      if (!changed) return;
      if (obsTimer) clearTimeout(obsTimer);
      obsTimer = setTimeout(function () {
        mutations.forEach(function (m) {
          if (m.type === 'characterData' && m.target && m.target.parentElement) {
            applyLiterals(m.target.parentElement, activeLang);
          }
          if (m.type === 'attributes' && m.target && m.target.nodeType === 1) {
            applyLiterals(m.target, activeLang);
          }
          Array.prototype.forEach.call(m.addedNodes || [], function (node) {
            if (!node) return;
            if (node.nodeType === 3) {
              if (node.parentElement) applyLiterals(node.parentElement, activeLang);
              return;
            }
            if (node.nodeType === 1) applyLiterals(node, activeLang);
          });
        });
      }, 40);
    });
    obs.observe(document.body, { childList: true, subtree: true, characterData: true, attributes: true, attributeFilter: TRACKED_ATTRS });
  }

  // ── Document title ─────────────────────────────────────────────────
  // Store the canonical AZ title once. Every switch is then derived from that
  // source, so EN→AZ→RU→EN never stacks or gets stuck on an old title.
  function captureTitle (lang, from) {
    titleInfo = {
      canonicalValue: canonicalSource(document.title, from || lang),
      current: document.title,
      lang: lang
    };
  }

  function applyTitle (lang, from) {
    if (!titleInfo) captureTitle(lang, from);
    document.title = tr(titleInfo.canonicalValue, lang, 'az');
    titleInfo.current = document.title;
    titleInfo.lang = lang;
  }

  // ── DOM Application (keyed nodes) ──────────────────────────────────
  function applyLang (lang, fromLang) {
    if (!SUPPORTED.includes(lang)) lang = 'az';
    const from = fromLang || renderedLang || activeLang || 'az';
    activeLang = lang;

    document.querySelectorAll('[data-i18n]').forEach(function (el) {
      const val = t(lang, el.getAttribute('data-i18n'));
      if (el.children.length === 0) {
        el.textContent = val;
      } else {
        // Only the FIRST bare text node receives the translation. Replacing
        // every text node duplicated labels on mixed icon+text elements.
        let done = false;
        Array.prototype.forEach.call(el.childNodes, function (node) {
          if (done || node.nodeType !== Node.TEXT_NODE || !node.textContent.trim()) return;
          node.textContent = val;
          done = true;
        });
        if (!done) el.insertBefore(document.createTextNode(val), el.firstChild);
      }
    });

    document.querySelectorAll('[data-i18n-html]').forEach(function (el) {
      el.innerHTML = t(lang, el.getAttribute('data-i18n-html'));
    });
    document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
      el.placeholder = t(lang, el.getAttribute('data-i18n-placeholder'));
    });
    document.querySelectorAll('[data-i18n-title]').forEach(function (el) {
      el.title = t(lang, el.getAttribute('data-i18n-title'));
    });
    document.querySelectorAll('[data-i18n-value]').forEach(function (el) {
      el.value = t(lang, el.getAttribute('data-i18n-value'));
    });
    document.querySelectorAll('[data-i18n-attr]').forEach(function (el) {
      el.getAttribute('data-i18n-attr').split(';').forEach(function (pair) {
        const parts = pair.split(':');
        if (parts.length === 2) el.setAttribute(parts[0].trim(), t(lang, parts[1].trim()));
      });
    });

    document.documentElement.lang = lang;

    applyTitle(lang, from);

    // Keep demo deep-links in sync with the active language.
    // Demo pages also contain their own language pills whose hrefs point at
    // demo-* URLs — never rewrite those, or the visitor cannot switch at all.
    document.querySelectorAll('.sky-demo-btn-open, a[href*="modules/web-demos/demo-"]').forEach(function (link) {
      if (link.matches('.lang-btn, .lang-pill, .sky-lang-option, .sky-lang-mobile-item')) return;
      const href = link.getAttribute('href');
      if (!href) return;
      link.setAttribute('href', href.indexOf('lang=') !== -1
        ? href.replace(/([?&]lang=)[a-z]{2}/i, '$1' + lang)
        : href + (href.indexOf('?') !== -1 ? '&' : '?') + 'lang=' + lang);
    });

    applyLiterals(document.body, lang, from);
    renderedLang = lang;
    document.dispatchEvent(new CustomEvent('sky-lang-changed', { detail: { lang: lang } }));
  }

  // ── Switcher UI ────────────────────────────────────────────────────
  function updateSwitcherUI (lang) {
    const meta = LANG_META[lang] || LANG_META.az;
    document.querySelectorAll('#sky-lang-btn .sky-flag-img, .sky-lang-btn .sky-flag-img').forEach(function (img) {
      img.src = meta.flagImg;
      img.srcset = meta.flagImg2x + ' 2x';
      img.alt = meta.alt;
    });
    document.querySelectorAll('#sky-lang-btn .sky-lang-code, .sky-lang-btn .sky-lang-code').forEach(function (el) {
      el.textContent = meta.short;
    });
    document.querySelectorAll('.sky-lang-option').forEach(function (el) {
      const href = el.getAttribute('href') || '';
      const match = href.match(/[?&]lang=([a-z]{2})/);
      const c = match ? match[1] : el.getAttribute('data-sky-lang-switch');
      const isActive = (c === lang);
      el.classList.toggle('active', isActive);
      let check = el.querySelector('.sky-lang-check');
      if (isActive && !check) {
        check = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        check.setAttribute('class', 'sky-lang-check');
        check.setAttribute('viewBox', '0 0 24 24');
        check.setAttribute('width', '14');
        check.setAttribute('height', '14');
        check.setAttribute('fill', 'none');
        check.setAttribute('stroke', 'var(--neon-cyan)');
        check.setAttribute('stroke-width', '2.5');
        check.setAttribute('stroke-linecap', 'round');
        check.setAttribute('stroke-linejoin', 'round');
        const poly = document.createElementNS('http://www.w3.org/2000/svg', 'polyline');
        poly.setAttribute('points', '20 6 9 17 4 12');
        check.appendChild(poly);
        el.appendChild(check);
      } else if (!isActive && check) {
        check.remove();
      }
    });
    document.querySelectorAll('.sky-lang-mobile-item').forEach(function (el) {
      const href = el.getAttribute('href') || '';
      const match = href.match(/[?&]lang=([a-z]{2})/);
      const c = match ? match[1] : el.dataset.skyLangSwitch;
      el.classList.toggle('active', c === lang);
    });
  }

  function withFade (callback) {
    const body = document.body;
    body.style.transition = 'opacity 0.15s ease';
    body.style.opacity = '0.7';
    setTimeout(function () {
      callback();
      body.style.opacity = '1';
      setTimeout(function () { body.style.transition = ''; }, 200);
    }, 120);
  }

  // ── Persist & URL sync ─────────────────────────────────────────────
  function persist (lang) {
    localStorage.setItem('sky_lang', lang);
    const exp = new Date(Date.now() + 30 * 86400 * 1000).toUTCString();
    document.cookie = 'sky_lang=' + lang + '; path=/; expires=' + exp;
    fetch(SYNC_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ lang: lang }),
      credentials: 'same-origin'
    }).catch(function () { /* offline — cookie/localStorage still work */ });
  }

  function syncUrl (lang) {
    try {
      const u = new URL(window.location.href);
      u.searchParams.set('lang', lang);
      history.replaceState(history.state, '', u.pathname + u.search + u.hash);
    } catch (e) { /* file:// or restricted context */ }
  }

  function switchLang (lang) {
    if (!SUPPORTED.includes(lang) || lang === activeLang) return;
    withFade(function () {
      applyLang(lang, renderedLang);
      updateSwitcherUI(lang);
      syncUrl(lang);
      persist(lang);
      document.querySelectorAll('#sky-lang-selector').forEach(function (dd) {
        dd.classList.remove('open');
        const btn = dd.querySelector('.sky-lang-btn');
        if (btn) btn.setAttribute('aria-expanded', 'false');
      });
    });
  }

  // ── Init ───────────────────────────────────────────────────────────
  function init () {
    const lang = detectLang();
    activeLang = lang;
    renderedLang = lang;
    localStorage.setItem('sky_lang', lang);
    applyLang(lang, lang);
    updateSwitcherUI(lang);
    observeDynamicContent();

    document.addEventListener('click', function (e) {
      const target = e.target.closest('.sky-lang-option, .sky-lang-mobile-item, [data-sky-lang-switch]');
      if (!target) return;
      const href = target.getAttribute('href') || '';
      const match = href.match(/[?&]lang=([a-z]{2})/);
      const code = match ? match[1] : target.getAttribute('data-sky-lang-switch');
      if (code && SUPPORTED.includes(code)) {
        e.preventDefault();
        e.stopPropagation();
        switchLang(code);
      }
    });
  }

  window.SkyI18n = {
    init: init,
    switchLang: switchLang,
    t: tCurrent,
    tr: tr,
    currentLang: function () { return activeLang; }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
