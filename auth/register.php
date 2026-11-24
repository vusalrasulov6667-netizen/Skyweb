<?php
/**
 * SKYWEB.AZ — Qeydiyyat Səhifəsi (Register Page)
 * Premium Dark Cyber-Sky UI | Fully Responsive | iOS & Android Optimized
 */
require_once __DIR__ . '/../config/config.php';
if (isLoggedIn()) redirect('');
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title><?= e(__('auth_register_title', 'Yeni Hesab Yarat')) ?> — <?= SITE_NAME ?></title>
  
  <!-- Preconnect and Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="../assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">

  <style>
    /* Base Container & Safe Area Support for iOS & Android */
    .auth-wrap { 
      min-height: 100vh;
      min-height: 100dvh;
      display: flex; 
      align-items: center; 
      justify-content: center; 
      padding: calc(1.5rem + env(safe-area-inset-top, 0px)) calc(1.25rem + env(safe-area-inset-right, 0px)) calc(1.5rem + env(safe-area-inset-bottom, 0px)) calc(1.25rem + env(safe-area-inset-left, 0px));
      position: relative; 
      z-index: 2; 
      box-sizing: border-box;
      -webkit-overflow-scrolling: touch;
    }

    /* Glassmorphism Card */
    .auth-card { 
      width: 100%; 
      max-width: 460px; 
      padding: 2.25rem 2rem; 
      border-radius: 24px;
      background: rgba(8, 10, 28, 0.88) !important;
      border: 1px solid rgba(56, 189, 248, 0.28) !important;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6), 0 0 35px rgba(56, 189, 248, 0.08);
      backdrop-filter: blur(24px);
      -webkit-backdrop-filter: blur(24px);
      position: relative;
      box-sizing: border-box;
      transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    /* Card Header (Logo & Language Switcher) */
    .auth-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 1rem;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 25;
    }
    .auth-logo {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
      transition: transform 0.2s ease;
    }
    .auth-logo:hover {
      transform: translateY(-1px);
    }
    .auth-logo-icon {
      height: 32px;
      display: flex;
      align-items: center;
    }
    .logo-sky { color: var(--text-primary) !important; }
    .logo-web { color: var(--neon-cyan) !important; }
    .logo-text .dot-az { color: var(--neon-cyan) !important; }

    /* Typography */
    .auth-title { 
      font-size: 1.8rem; 
      font-weight: 800; 
      margin: 0 0 0.35rem 0; 
      color: #ffffff;
      letter-spacing: -0.02em;
      line-height: 1.25;
      font-family: var(--font-headings, 'Outfit', sans-serif);
      text-align: left;
    }
    .auth-sub { 
      font-size: 0.88rem; 
      color: #94a3b8; 
      margin: 0 0 1.5rem 0; 
      line-height: 1.45;
      text-align: left;
    }

    /* Form Groups & Labels */
    .form-group {
      margin-bottom: 1.15rem;
      text-align: left;
    }
    .form-label {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-weight: 600;
      color: #f1f5f9 !important;
      font-size: 0.875rem;
      margin-bottom: 0.45rem;
      line-height: 1.3;
    }

    /* High-contrast mobile-friendly inputs (iOS auto-zoom proof) */
    .form-input {
      font-size: 16px !important; /* Prevents auto-zoom on iOS Safari */
      height: 50px; /* Touch target >= 48px */
      background: #f8fafc !important;
      border: 1.5px solid #cbd5e1 !important;
      color: #0f172a !important;
      border-radius: 12px;
      padding: 0 1rem;
      width: 100%;
      box-sizing: border-box;
      transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
      -webkit-appearance: none;
      appearance: none;
      font-family: inherit;
    }
    .form-input::placeholder {
      color: #94a3b8 !important;
      font-size: 0.92rem;
    }
    .form-input:focus {
      background: #ffffff !important;
      border-color: #38bdf8 !important;
      box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25) !important;
      outline: none;
    }

    /* Password Input & Eye Toggle */
    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
      width: 100%;
    }
    .form-input-pass {
      padding-right: 3rem !important;
    }
    .password-toggle {
      position: absolute;
      right: 0.5rem;
      top: 50%;
      transform: translateY(-50%);
      width: 38px;
      height: 38px;
      background: transparent;
      border: none;
      color: #64748b;
      font-size: 1.15rem;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      transition: background 0.2s, color 0.2s;
      z-index: 5;
      -webkit-tap-highlight-color: transparent;
      user-select: none;
    }
    .password-toggle:hover {
      color: #0f172a;
      background: rgba(15, 23, 42, 0.08);
    }
    .password-toggle:focus-visible {
      outline: 2px solid #38bdf8;
    }

    /* Form Two-Column Row */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.75rem;
    }

    /* Live Password Match & Strength Feedback */
    .password-feedback {
      display: none;
      align-items: center;
      gap: 0.45rem;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.45rem 0.75rem;
      border-radius: 10px;
      margin-top: -0.35rem;
      margin-bottom: 1.15rem;
      line-height: 1.35;
      animation: fadeInFeedback 0.2s ease-out;
    }
    @keyframes fadeInFeedback {
      from { opacity: 0; transform: translateY(-4px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .password-feedback.warn {
      display: flex;
      background: rgba(239, 68, 68, 0.12);
      border: 1px solid rgba(239, 68, 68, 0.35);
      color: #fca5a5;
    }
    .password-feedback.valid {
      display: flex;
      background: rgba(16, 185, 129, 0.12);
      border: 1px solid rgba(16, 185, 129, 0.35);
      color: #6ee7b7;
    }
    .password-feedback.match {
      display: flex;
      background: rgba(56, 189, 248, 0.14);
      border: 1px solid rgba(56, 189, 248, 0.4);
      color: #7dd3fc;
    }

    /* Submit Button */
    .btn-submit {
      width: 100%;
      height: 50px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.5rem;
      font-size: 1rem;
      font-weight: 700;
      border-radius: 12px;
      background: linear-gradient(135deg, #0ea5e9 0%, #6366f1 100%) !important;
      color: #ffffff !important;
      border: none;
      cursor: pointer;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: 0 4px 18px rgba(14, 165, 233, 0.35);
      -webkit-tap-highlight-color: transparent;
      user-select: none;
    }
    .btn-submit:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 6px 24px rgba(14, 165, 233, 0.5);
      filter: brightness(1.08);
    }
    .btn-submit:active:not(:disabled) {
      transform: translateY(0);
    }
    .btn-submit:disabled {
      opacity: 0.7;
      cursor: not-allowed;
      filter: grayscale(0.2);
    }

    /* Auth Footer with unified links */
    .auth-footer { 
      text-align: center; 
      margin-top: 1.5rem; 
      padding-top: 1.25rem;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      font-size: 0.875rem; 
      color: #cbd5e1; 
      display: flex;
      flex-direction: column;
      gap: 0.65rem;
      align-items: center;
    }
    .auth-footer-prompt {
      margin: 0;
    }
    .auth-footer a { 
      color: #38bdf8; 
      text-decoration: none; 
      font-weight: 600; 
      transition: color 0.2s ease;
    }
    .auth-footer a:hover { 
      color: #7dd3fc; 
      text-decoration: underline; 
    }
    .auth-back-link {
      font-size: 0.825rem;
      color: #94a3b8 !important;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: color 0.2s ease;
    }
    .auth-back-link:hover {
      color: #ffffff !important;
      text-decoration: none !important;
    }

    /* Responsive Adaptation: Mobile, WAP, iOS & Android */
    @media (max-width: 540px) {
      .auth-wrap {
        padding: 1rem 0.75rem;
      }
      .auth-card {
        padding: 1.75rem 1.25rem;
        border-radius: 20px;
      }
      .auth-title {
        font-size: 1.6rem;
      }
      .auth-sub {
        margin-bottom: 1.25rem;
      }
      .form-row {
        grid-template-columns: 1fr;
        gap: 0;
      }
    }

    /* Small screens / WAP devices (<= 360px) */
    @media (max-width: 360px) {
      .auth-card {
        padding: 1.5rem 1rem;
        border-radius: 16px;
      }
      .auth-title {
        font-size: 1.45rem;
      }
      .form-input {
        height: 48px;
        padding: 0 0.85rem;
      }
      .btn-submit {
        height: 48px;
        font-size: 0.95rem;
      }
    }
  </style>
</head>
<body>

<!-- Particle Background -->
<canvas id="sky-canvas" aria-hidden="true"></canvas>

<div class="auth-wrap">
  <div class="auth-card glass-card">
    
    <!-- Header: Logo & Language Switcher -->
    <div class="auth-card-header">
      <a href="../" class="logo auth-logo" aria-label="SkyWeb">
        <div class="logo-icon auth-logo-icon">
          <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <linearGradient id="skySGradAuth" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="#38bdf8" />
                <stop offset="100%" stop-color="#0284c7" />
              </linearGradient>
              <filter id="skyLogoGlowAuth" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="3" result="blur" />
                <feMerge>
                  <feMergeNode in="blur" />
                  <feMergeNode in="SourceGraphic" />
                </feMerge>
              </filter>
            </defs>
            <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGradAuth)" />
            <g filter="url(#skyLogoGlowAuth)">
              <path d="M48,20 Q64,13 80,13 L110,13" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
              <circle cx="110" cy="13" r="2.2" fill="var(--neon-cyan)" />
              <path d="M54,32 Q70,30 84,30 L110,30" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
              <circle cx="110" cy="30" r="2.2" fill="var(--neon-cyan)" />
              <path d="M60,48 L110,48" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
              <circle cx="110" cy="48" r="2.2" fill="var(--neon-cyan)" />
              <path d="M54,64 Q70,66 84,66 L110,66" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
              <circle cx="110" cy="66" r="2.2" fill="var(--neon-cyan)" />
              <path d="M48,76 Q64,83 80,83 L110,83" stroke="var(--neon-cyan)" stroke-width="1.8" stroke-linecap="round" fill="none" opacity="0.85" />
              <circle cx="110" cy="83" r="2.2" fill="var(--neon-cyan)" />
              <g transform="translate(122, 5)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
                <path d="M2.5,12 h10 a2.5,2.5 0 0,0 2.2,-3.7 a3.5,3.5 0 0,0 -6.2,-2.3 a3,3 0 0,0 -5.3,1.5 a2,2 0 0,0 -0.7,4.5 z" />
              </g>
              <g transform="translate(122, 22)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
                <rect x="1" y="2" width="13" height="4.5" rx="1" />
                <rect x="1" y="8.5" width="13" height="4.5" rx="1" />
                <circle cx="3.5" cy="4.25" r="0.5" fill="var(--neon-cyan)" />
                <circle cx="3.5" cy="10.75" r="0.5" fill="var(--neon-cyan)" />
              </g>
              <g transform="translate(122, 40)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
                <path d="M1,2 L7.5,0.5 L14,2 L14,6 C14,10 11,12.5 7.5,14.5 C4,12.5 1,10 1,6 Z" />
                <path d="M4.5,7.5 L6.5,9.5 L10.5,5.5" />
              </g>
              <g transform="translate(122, 58.5)" stroke="var(--neon-cyan)" stroke-width="1.5" fill="none">
                <circle cx="7.5" cy="7.5" r="7" />
                <ellipse cx="7.5" cy="7.5" rx="2.5" ry="7" />
                <line x1="0.5" y1="7.5" x2="14.5" y2="7.5" stroke-linecap="round" stroke-linejoin="round" />
              </g>
              <g transform="translate(122, 75.5)" stroke="var(--neon-cyan)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none">
                <path d="M 7.5,0 L 14,3.5 L 14,11.5 L 7.5,15 L 1,11.5 L 1,3.5 Z" />
                <path d="M 1,3.5 L 7.5,7.5 L 14,3.5" />
                <path d="M 7.5,7.5 L 7.5,15" />
              </g>
            </g>
          </svg>
        </div>
        <span class="logo-text" style="font-size:1.15rem; font-weight:800;"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
      </a>

      <!-- Language Selector -->
      <?= render_language_switcher('auth-lang-switcher') ?>
    </div>
    
    <!-- Title & Subtitle -->
    <h1 class="auth-title" data-i18n="auth_register_title"><?= e(__('auth_register_title', 'Yeni Hesab Yarat')) ?></h1>
    <p class="auth-sub" data-i18n="auth_register_subtitle"><?= e(__('auth_register_subtitle', 'Biznes imkanlarına qoşulun')) ?></p>

    <!-- Registration Form -->
    <form class="sky-form" id="register-form" method="POST" novalidate>
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      
      <!-- Fullname -->
      <div class="form-group">
        <label class="form-label" for="reg-fullname" data-i18n="auth_fullname"><?= e(__('auth_fullname', 'Ad və Soyad')) ?></label>
        <input type="text" id="reg-fullname" name="fullname" class="form-input" placeholder="Məs. Əli Əliyev" required autocomplete="name">
      </div>
      
      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="reg-email" data-i18n="auth_email"><?= e(__('auth_email', 'E-poçt ünvanı')) ?></label>
        <input type="email" id="reg-email" name="email" class="form-input" placeholder="ali@example.com" required autocomplete="email" autocapitalize="none" autocorrect="off" spellcheck="false" inputmode="email">
      </div>
      
      <!-- Phone -->
      <div class="form-group">
        <label class="form-label" for="reg-phone" data-i18n="auth_phone"><?= e(__('auth_phone', 'Telefon nömrəsi')) ?></label>
        <input type="tel" id="reg-phone" name="phone" class="form-input" placeholder="+994 50 123 45 67" required autocomplete="tel" inputmode="tel">
      </div>
      
      <!-- Passwords (side-by-side on desktop, stacked on mobile) -->
      <div class="form-row">
        <div class="form-group">
          <label class="form-label" for="reg-pass" data-i18n="auth_password"><?= e(__('auth_password', 'Şifrə')) ?></label>
          <div class="input-wrapper">
            <input type="password" id="reg-pass" name="password" class="form-input form-input-pass" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('reg-pass')" aria-label="Toggle password visibility">👁️</button>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="reg-pass-confirm" data-i18n="auth_confirm_password"><?= e(__('auth_confirm_password', 'Şifrəni Təsdiq Edin')) ?></label>
          <div class="input-wrapper">
            <input type="password" id="reg-pass-confirm" name="password_confirm" class="form-input form-input-pass" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('reg-pass-confirm')" aria-label="Toggle password visibility">👁️</button>
          </div>
        </div>
      </div>
      
      <!-- Live Password match feedback -->
      <div id="password-match-feedback" class="password-feedback" role="status" aria-live="polite"></div>
      
      <!-- Submit Button -->
      <button type="submit" class="btn-primary btn-submit" id="btn-reg-submit">
        <span data-i18n="auth_register_btn"><?= e(__('auth_register_btn', 'Qeydiyyatı Tamamla')) ?></span>
      </button>
    </form>

    <!-- Unified Footer Links (No duplicates, proper hierarchy) -->
    <div class="auth-footer">
      <p class="auth-footer-prompt">
        <span data-i18n="auth_has_account"><?= e(__('auth_has_account', 'Artıq hesabınız var?')) ?></span> 
        <a href="login.php" id="link-to-login"><span data-i18n="auth_login_btn"><?= e(__('auth_login_btn', 'Daxil Ol')) ?></span> →</a>
      </p>
      <a href="../" class="auth-back-link">
        ← <span data-i18n="nav_home"><?= e(__('nav_home', 'Ana Səhifəyə Qayıt')) ?></span>
      </a>
    </div>

  </div><!-- /.auth-card -->
</div><!-- /.auth-wrap -->

<!-- Scripts -->
<script src="../assets/js/main.js" defer></script>
<script>
  // Ensure Password Visibility Toggle is available immediately
  window.togglePasswordVisibility = window.togglePasswordVisibility || function(id) {
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

  // Dynamic I18N Helper for JS messages
  function getMsg(key, fallback) {
    const lang = localStorage.getItem('sky_lang') || document.documentElement.lang || 'az';
    if (window.__SKY_I18N__ && window.__SKY_I18N__[lang] && window.__SKY_I18N__[lang][key]) {
      return window.__SKY_I18N__[lang][key];
    }
    return fallback;
  }

  // Safe Toast Helper
  function showToast(msg, icon) {
    if (typeof window.skyToast === 'function') {
      window.skyToast(msg, icon || 'ℹ️');
    } else {
      alert((icon ? icon + ' ' : '') + msg);
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    const passInput = document.getElementById('reg-pass');
    const confirmInput = document.getElementById('reg-pass-confirm');
    const feedback = document.getElementById('password-match-feedback');

    function checkPasswords() {
      if (!passInput || !confirmInput || !feedback) return;
      const pass = passInput.value;
      const confirm = confirmInput.value;
      
      if (pass === '' && confirm === '') {
        feedback.className = 'password-feedback';
        feedback.style.display = 'none';
        feedback.textContent = '';
        return;
      }
      
      feedback.style.display = 'flex';
      
      if (pass.length < 6) {
        feedback.className = 'password-feedback warn';
        feedback.textContent = '⚠️ ' + getMsg('auth_pass_min', 'Şifrə minimum 6 simvoldan ibarət olmalıdır.');
      } else if (confirm !== '' && pass !== confirm) {
        feedback.className = 'password-feedback warn';
        feedback.textContent = '❌ ' + getMsg('auth_pass_mismatch', 'Şifrələr üst-üstə düşmür.');
      } else if (confirm !== '' && pass === confirm) {
        feedback.className = 'password-feedback match';
        feedback.textContent = '✅ ' + getMsg('auth_pass_match', 'Şifrələr eynidir.');
      } else {
        feedback.className = 'password-feedback valid';
        feedback.textContent = '✓ ' + getMsg('auth_pass_length_ok', 'Şifrə uzunluğu uyğundur.');
      }
    }

    if (passInput && confirmInput) {
      passInput.addEventListener('input', checkPasswords);
      confirmInput.addEventListener('input', checkPasswords);
    }

    // Re-check passwords on language switch
    document.addEventListener('click', (e) => {
      if (e.target.closest('.sky-lang-option') || e.target.closest('.sky-lang-mobile-item')) {
        setTimeout(checkPasswords, 300);
      }
    });

    const regForm = document.getElementById('register-form');
    if (regForm) {
      regForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.getElementById('btn-reg-submit');
        const originalContent = btn.innerHTML;
        
        // Passwords clientside matching check
        const pass = passInput.value;
        const passConfirm = confirmInput.value;
        
        if (pass.length < 6) {
          showToast(getMsg('auth_pass_min', 'Şifrə minimum 6 simvoldan ibarət olmalıdır.'), '❌');
          passInput.focus();
          return;
        }
        
        if (pass !== passConfirm) {
          showToast(getMsg('auth_pass_mismatch', 'Şifrələr üst-üstə düşmür.'), '❌');
          confirmInput.focus();
          return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span>' + getMsg('loading', 'Yüklənir...') + '</span>';
        
        const formData = new FormData(regForm);
        
        try {
          const response = await fetch('register-process.php', {
            method: 'POST',
            body: formData
          });
          
          const result = await response.json();
          
          if (result.success) {
            showToast(result.message, '✅');
            setTimeout(() => {
              window.location.href = result.redirect || '../index.php';
            }, 1200);
          } else {
            showToast(result.message || getMsg('auth_error', 'Xəta baş verdi.'), '❌');
            btn.disabled = false;
            btn.innerHTML = originalContent;
          }
        } catch (error) {
          showToast(getMsg('auth_network_error', 'Şəbəkə xətası baş verdi. Zəhmət olmasa yenidən cəhd edin.'), '❌');
          btn.disabled = false;
          btn.innerHTML = originalContent;
        }
      });
    }
  });
</script>
</body>
</html>
