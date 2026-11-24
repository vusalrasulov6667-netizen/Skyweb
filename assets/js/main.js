/**
 * SKYWEB.AZ — Main JavaScript
 * Canvas Particles, Scroll Animations, Navbar, Mobile Menu, Typewriter, Toast
 */

(function () {
  'use strict';

  /* ── 1. CANVAS PARTICLE BACKGROUND ─────────────────────── */
  const canvas = document.getElementById('sky-canvas');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let W, H, particles = [], animId;

        const PARTICLE_COUNT = window.innerWidth < 600 ? 35 : 70; // Daha çox partikul—parlaq mesh effekti

    function resize() {
      W = canvas.width  = window.innerWidth;
      H = canvas.height = window.innerHeight;
    }

    class Particle {
      constructor() { this.reset(true); }

      reset(init = false) {
        this.x  = Math.random() * W;
        this.y  = init ? Math.random() * H : H + 10;
        this.r  = Math.random() * 1.8 + 0.4;          // bir az daha böyük partikullar
        this.vx = (Math.random() - 0.5) * 0.15;
        this.vy = -(Math.random() * 0.22 + 0.05);
        this.alpha = Math.random() * 0.50 + 0.15;     // daha parlaq
        // Midnight purple → electric cyan palitra
        const palette = ['#00E5FF', '#00BFFF', '#4fc3f7', '#7c3aed', '#a855f7', '#c084fc', '#38bdf8', '#0ea5e9'];
        this.color = palette[Math.floor(Math.random() * palette.length)];
      }

      update() {
        this.x += this.vx;
        this.y += this.vy;
        if (this.y < -10) this.reset();
      }

      draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = this.color;
        ctx.globalAlpha = this.alpha;
        ctx.fill();
        ctx.globalAlpha = 1;
      }
    }

    // Connection lines — glowing digital mesh
    function drawLines() {
      const maxDist = 140;
      for (let i = 0; i < particles.length; i++) {
        for (let j = i + 1; j < particles.length; j++) {
          const dx = particles[i].x - particles[j].x;
          const dy = particles[i].y - particles[j].y;
          const dist = Math.sqrt(dx * dx + dy * dy);
          if (dist < maxDist) {
            const alpha = 0.18 * (1 - dist / maxDist);
            // Y position determines color: top=purple, bottom=cyan
            const avgY = (particles[i].y + particles[j].y) / 2;
            const t = Math.min(1, Math.max(0, avgY / (H || 1)));
            // Interpolate hue: purple(270) → cyan(186)
            const hue = Math.round(270 - t * 84);
            ctx.beginPath();
            ctx.moveTo(particles[i].x, particles[i].y);
            ctx.lineTo(particles[j].x, particles[j].y);
            ctx.strokeStyle = `hsla(${hue}, 100%, 75%, ${alpha})`;
            ctx.lineWidth = 0.6;
            ctx.stroke();
          }
        }
      }
    }

    function init() {
      resize();
      particles = Array.from({ length: PARTICLE_COUNT }, () => new Particle());
    }

    function loop() {
      ctx.clearRect(0, 0, W, H);
      drawLines();
      particles.forEach(p => { p.update(); p.draw(); });
      animId = requestAnimationFrame(loop);
    }

    window.addEventListener('resize', () => { resize(); });
    init();
    loop();
  }

  /* ── 2. NAVBAR SCROLL EFFECT ────────────────────────────── */
  const navbar = document.getElementById('main-navbar');
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 20) navbar.classList.add('scrolled');
      else navbar.classList.remove('scrolled');
    }, { passive: true });
  }

  /* ── 3. MOBILE MENU ─────────────────────────────────────── */
  const hamburger = document.getElementById('hamburger');
  const mobileNav = document.getElementById('mobile-nav');

  if (hamburger && mobileNav) {
    hamburger.addEventListener('click', () => {
      const isOpen = hamburger.classList.toggle('open');
      mobileNav.classList.toggle('open', isOpen);
      hamburger.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close on link click
    mobileNav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        hamburger.classList.remove('open');
        mobileNav.classList.remove('open');
        document.body.style.overflow = '';
      });
    });
  }

  /* ── 4. SCROLL-TRIGGERED ANIMATIONS ────────────────────── */
  const animEls = document.querySelectorAll('.animate-on-scroll');
  if (animEls.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
    );
    animEls.forEach(el => observer.observe(el));
  }

  /* ── 5. TYPEWRITER EFFECT ───────────────────────────────── */
  const typeEl = document.getElementById('typewriter-text');
  if (typeEl) {
    const words = typeEl.dataset.words ? JSON.parse(typeEl.dataset.words) : [];
    let wordIndex = 0, charIndex = 0, deleting = false;
    const SPEED_TYPE = 80, SPEED_DEL = 45, PAUSE = 2000;

    function type() {
      const current = words[wordIndex];
      if (!deleting) {
        typeEl.textContent = current.slice(0, ++charIndex);
        if (charIndex === current.length) {
          deleting = true;
          setTimeout(type, PAUSE);
          return;
        }
      } else {
        typeEl.textContent = current.slice(0, --charIndex);
        if (charIndex === 0) {
          deleting = false;
          wordIndex = (wordIndex + 1) % words.length;
        }
      }
      setTimeout(type, deleting ? SPEED_DEL : SPEED_TYPE);
    }

    if (words.length) type();
  }

  /* ── 6. COUNTER ANIMATION ───────────────────────────────── */
  const counters = document.querySelectorAll('[data-count]');
  if (counters.length) {
    const countObserver = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = +el.dataset.count;
        const suffix = el.dataset.suffix || '';
        const duration = 1800;
        let start = null;

        function step(ts) {
          if (!start) start = ts;
          const progress = Math.min((ts - start) / duration, 1);
          const eased = 1 - Math.pow(1 - progress, 3);
          el.textContent = Math.floor(eased * target) + suffix;
          if (progress < 1) requestAnimationFrame(step);
          else el.textContent = target + suffix;
        }

        requestAnimationFrame(step);
        countObserver.unobserve(el);
      });
    }, { threshold: 0.5 });

    counters.forEach(el => countObserver.observe(el));
  }

  /* ── 7. TOAST NOTIFICATION ──────────────────────────────── */
  window.skyToast = function (msg, icon = '✅', duration = 4000) {
    let toast = document.getElementById('sky-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'sky-toast';
      toast.className = 'toast';
      document.body.appendChild(toast);
    }
    toast.innerHTML = `<span class="toast-icon">${icon}</span><span>${msg}</span>`;
    if (icon === '❌') {
      toast.classList.add('toast-error');
    } else {
      toast.classList.remove('toast-error');
    }
    toast.classList.add('show');
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => toast.classList.remove('show'), duration);
  };

  /* ── 8b. GLOBAL CHIP TOOLTIP ENGINE ──────────────────────── */
  (function initChipTooltips() {
    let tip = document.getElementById('sky-chip-tooltip');
    if (!tip) {
      tip = document.createElement('div');
      tip.id = 'sky-chip-tooltip';
      document.body.appendChild(tip);
    }

    let hideTimer = null;
    let currentBtn = null;

    function showTip(btn) {
      if (currentBtn === btn) return;
      clearTimeout(hideTimer);
      hideTip(true);
      currentBtn = btn;
      btn.closest('.chip-wrap').classList.add('tip-open');

      tip.textContent = btn.dataset.tip || '';
      tip.classList.remove('tip-above', 'tip-below', 'visible');
      tip.style.cssText = 'opacity:0;';

      // Position
      const MARGIN = 10;
      const GAP = 10;
      const bRect = btn.getBoundingClientRect();
      const vw = window.innerWidth;
      const vh = window.innerHeight;

      // Measure tooltip
      tip.style.visibility = 'hidden';
      tip.style.display = 'block';
      const tRect = tip.getBoundingClientRect();
      tip.style.visibility = '';

      const tipW = tRect.width || 260;
      const tipH = tRect.height || 60;

      // Prefer above
      let top, left, arrowLeft, placement;
      if (bRect.top - tipH - GAP - MARGIN >= 0) {
        top = bRect.top - tipH - GAP;
        placement = 'tip-above';
      } else {
        top = bRect.bottom + GAP;
        placement = 'tip-below';
      }

      // Center horizontally on button, clamp to viewport
      left = bRect.left + bRect.width / 2 - tipW / 2;
      left = Math.max(MARGIN, Math.min(left, vw - tipW - MARGIN));

      // Arrow offset relative to tooltip
      const btnCenterX = bRect.left + bRect.width / 2;
      arrowLeft = Math.min(Math.max(btnCenterX - left, 12), tipW - 12);

      tip.style.setProperty('--arrow-left', arrowLeft + 'px');
      tip.style.top = top + 'px';
      tip.style.left = left + 'px';
      tip.classList.add(placement);

      // Fade in
      requestAnimationFrame(() => {
        tip.style.opacity = '';
        tip.classList.add('visible');
      });
    }

    function hideTip(immediate) {
      if (currentBtn) {
        const wrap = currentBtn.closest('.chip-wrap');
        if (wrap) wrap.classList.remove('tip-open');
      }
      currentBtn = null;
      tip.classList.remove('visible');
      if (immediate) {
        tip.classList.remove('tip-above', 'tip-below');
      } else {
        hideTimer = setTimeout(() => tip.classList.remove('tip-above', 'tip-below'), 200);
      }
    }

    // Desktop: hover
    document.addEventListener('mouseover', (e) => {
      const btn = e.target.closest('.chip-info-btn[data-tip]');
      if (btn) showTip(btn);
    });

    document.addEventListener('mouseout', (e) => {
      const btn = e.target.closest('.chip-info-btn[data-tip]');
      if (btn && currentBtn === btn) {
        hideTip(false);
      }
    });

    // Mobile: tap
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('.chip-info-btn[data-tip]');
      if (btn) {
        e.stopPropagation();
        if (currentBtn === btn) { hideTip(false); }
        else { showTip(btn); }
        return;
      }
      // Tap elsewhere — hide
      if (currentBtn) hideTip(false);
    }, true);

    // Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && currentBtn) hideTip(false);
    });
  })();

  /* ── 8. MODAL CONTROL & CONTACT SUBMIT ──────────────────── */
  const modal = document.getElementById('register-modal');
  const closeBtn = document.getElementById('btn-modal-close');
  const openBtns = document.querySelectorAll('#btn-register-nav, #btn-cta-register, #btn-cta-contact, #mob-register, a[href="#join"], a[href="#contact"]');

  function openModal(e) {
    if (e) e.preventDefault();
    if (!modal) return;
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    const firstInput = modal.querySelector('.form-input');
    if (firstInput) firstInput.focus();
  }

  function closeModal() {
    if (!modal) return;
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  /* Expose for inline onclick handlers in index.php (demo order CTAs) */
  window.openModal  = openModal;
  window.closeModal = closeModal;

  if (modal) {
    const overlay = modal.querySelector('.sky-modal-overlay');
    openBtns.forEach(btn => btn.addEventListener('click', openModal));
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay) overlay.addEventListener('click', closeModal);

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('open')) {
        closeModal();
      }
    });
  }

  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = contactForm.querySelector('[type="submit"]');
      const original = btn.innerHTML;
      btn.innerHTML = '<span>Göndərilir...</span>';
      btn.disabled = true;

      const data = Object.fromEntries(new FormData(contactForm));

      try {
        const res = await fetch('api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data),
        });
        const json = await res.json();
        if (json.success) {
          skyToast('Müraciətiniz qəbul edildi! Tezliklə əlaqə saxlayacağıq. 🚀', '✅');
          contactForm.reset();
          setTimeout(closeModal, 1500);
        } else {
          skyToast(json.message || 'Xəta baş verdi. Yenidən cəhd edin.', '❌');
        }
      } catch {
        skyToast('Müraciətiniz qeydə alındı! Tezliklə sizinlə əlaqə saxlayacağıq.', '✅');
        contactForm.reset();
        setTimeout(closeModal, 1500);
      } finally {
        btn.innerHTML = original;
        btn.disabled = false;
      }
    });
  }

  /* ── 8.5. PREMIUM CUSTOM SELECT DROPDOWN ─────────────────── */
  const selectWrapper = document.getElementById('custom-service-wrapper');
  const selectTrigger = document.getElementById('custom-service-trigger');
  const selectTriggerText = selectTrigger ? selectTrigger.querySelector('.custom-select-trigger-text') : null;
  const selectSelectedIcon = selectTrigger ? selectTrigger.querySelector('.custom-select-selected-icon') : null;
  const selectOptionsContainer = document.getElementById('custom-service-options');
  const hiddenInput = document.getElementById('contact-service');

  if (selectWrapper && selectTrigger && selectOptionsContainer && hiddenInput) {
    const options = selectOptionsContainer.querySelectorAll('.custom-option');

    // Toggle dropdown open/close
    selectTrigger.addEventListener('click', (e) => {
      e.stopPropagation();
      const isOpen = selectTrigger.classList.toggle('open');
      selectWrapper.classList.toggle('open', isOpen);
      selectTrigger.setAttribute('aria-expanded', isOpen);
    });

    // Support trigger click via keyboard (Enter or Space)
    selectTrigger.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        selectTrigger.click();
      }
    });

    // Select option logic
    options.forEach((opt) => {
      opt.addEventListener('click', (e) => {
        e.stopPropagation();
        const value = opt.dataset.value;
        const text = opt.querySelector('.custom-option-text').textContent;
        const iconWrap = opt.querySelector('.custom-option-icon');

        // Set hidden input value
        hiddenInput.value = value;
        // Trigger standard change event in case other listeners exist
        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));

        // Update trigger text & icon
        selectTriggerText.textContent = text;
        if (iconWrap) {
          selectSelectedIcon.innerHTML = iconWrap.innerHTML;
          selectSelectedIcon.style.display = 'inline-flex';
        } else {
          selectSelectedIcon.innerHTML = '';
          selectSelectedIcon.style.display = 'none';
        }

        // Mark selected element
        options.forEach(o => o.classList.remove('selected'));
        if (value !== '') {
          opt.classList.add('selected');
        }

        // Close dropdown
        closeDropdown();
      });
    });

    function closeDropdown() {
      selectTrigger.classList.remove('open');
      selectWrapper.classList.remove('open');
      selectTrigger.setAttribute('aria-expanded', 'false');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!selectWrapper.contains(e.target)) {
        closeDropdown();
      }
    });

    // Close dropdown on Escape key
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && selectWrapper.classList.contains('open')) {
        closeDropdown();
        selectTrigger.focus();
      }
    });

    // Sync on form reset (if form is reset, clear custom trigger)
    const parentForm = selectWrapper.closest('form');
    if (parentForm) {
      parentForm.addEventListener('reset', () => {
        setTimeout(() => {
          hiddenInput.value = '';
          selectTriggerText.textContent = '— Seçin —';
          selectSelectedIcon.innerHTML = '';
          selectSelectedIcon.style.display = 'none';
          options.forEach(o => o.classList.remove('selected'));
        }, 10);
      });
    }
  }

  /* ── 9. ACTIVE NAV LINK (Scroll Spy) ────────────────────── */
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');

  if (sections.length && navLinks.length) {
    window.addEventListener('scroll', () => {
      let current = '';
      sections.forEach(sec => {
        if (window.scrollY >= sec.offsetTop - 100) current = sec.id;
      });
      navLinks.forEach(link => {
        link.classList.toggle('active', link.getAttribute('href') === '#' + current);
      });
    }, { passive: true });
  }

  /* ── 10. SMOOTH REVEAL for Hero (init) ──────────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.hero-content > *').forEach((el, i) => {
      el.style.animation = `fadeInUp 0.7s ease ${i * 0.12}s both`;
    });
  });

  // ── 12. REGISTER SERVICE WORKER (PWA support) ─────────────
  // The worker lives at the site root. A relative 'sw.js' resolves to
  // /sky/modules/games/sw.js on subpages and throws a 404 there.
  const skyBasePath = ((document.currentScript && document.currentScript.src) || '')
    .replace(/\/assets\/js\/main\.js(?:\?.*)?$/, '') || (location.origin + '/sky');
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register(skyBasePath + '/sw.js', { scope: skyBasePath + '/' })
        .then((reg) => console.log('Service Worker qeydiyyatdan keçdi.', reg))
        .catch((err) => console.error('Service Worker xətası:', err));
    });
  }

  /* ── 13. MULTI-LANGUAGE SELECTOR DROPDOWN ───────────────── */
  document.addEventListener('DOMContentLoaded', () => {
    const langDropdown = document.getElementById('sky-lang-selector');
    if (!langDropdown) return;

    const langBtn = langDropdown.querySelector('.sky-lang-btn');
    if (langBtn) {
      langBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = langDropdown.classList.toggle('open');
        langBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
    }

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
      if (!langDropdown.contains(e.target)) {
        langDropdown.classList.remove('open');
        if (langBtn) langBtn.setAttribute('aria-expanded', 'false');
      }
    });

    // Close dropdown on Escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && langDropdown.classList.contains('open')) {
        langDropdown.classList.remove('open');
        if (langBtn) {
          langBtn.setAttribute('aria-expanded', 'false');
          langBtn.focus();
        }
      }
    });
  });

})();

/* Global Password Toggle Helper */
window.togglePasswordVisibility = function(id) {
  const input = document.getElementById(id);
  if (!input) return;
  const btn = input.nextElementSibling;
  if (input.type === 'password') {
    input.type = 'text';
    if (btn) btn.textContent = '🙈';
  } else {
    input.type = 'password';
    if (btn) btn.textContent = '👁️';
  }
};


