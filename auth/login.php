<?php
/**
 * SKYWEB.AZ — Login Səhifəsi (Stub)
 * Tam implementasiya növbəti mərhələdə
 */
require_once __DIR__ . '/../config/config.php';
if (isLoggedIn()) redirect('');
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title><?= e(__('auth_login_title', 'Daxil ol')) ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
  <style>
    .auth-wrap { 
      min-height: 100vh; 
      display: flex; 
      align-items: center; 
      justify-content: center; 
      padding: 1.5rem; 
      position: relative; 
      z-index: 2; 
    }
    .auth-card { 
      width: 100%; 
      max-width: 440px; 
      padding: 2.5rem 2.25rem; 
      border-radius: 24px; 
      background: rgba(8, 10, 28, 0.85) !important;
      border: 1.5px solid rgba(56, 189, 248, 0.25) !important;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 30px rgba(56, 189, 248, 0.08);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
    }
    .auth-title { 
      font-size: 1.85rem; 
      font-weight: 800; 
      margin-bottom: .25rem; 
      color: #ffffff;
    }
    .auth-sub { 
      font-size: .875rem; 
      color: #cbd5e1; 
      margin-bottom: 1.5rem; 
    }
    .auth-divider { 
      text-align: center; 
      color: #64748b; 
      font-size: .85rem; 
      margin: 1.25rem 0; 
      position: relative; 
    }
    .auth-divider::before, .auth-divider::after { 
      content: ''; 
      position: absolute; 
      top: 50%; 
      width: 40%; 
      height: 1px; 
      background: rgba(255, 255, 255, 0.1); 
    }
    .auth-divider::before { left: 0; } 
    .auth-divider::after { right: 0; }
    
    .auth-footer { 
      text-align: center; 
      font-size: .875rem; 
      color: #cbd5e1; 
      margin-top: 1.5rem; 
    }
    .auth-footer a { 
      color: #38bdf8; 
      text-decoration: none; 
      font-weight: 600; 
      transition: var(--transition); 
    }
    .auth-footer a:hover { 
      color: #7dd3fc; 
      text-decoration: underline; 
    }
    
    .form-group {
      margin-bottom: 1.25rem;
    }
    .form-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: #f1f5f9;
      margin-bottom: 0.5rem;
    }
    .forgot-link {
      font-size: 0.8rem;
      color: #38bdf8;
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition);
    }
    .forgot-link:hover {
      color: #7dd3fc;
      text-decoration: underline;
    }
    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }
    .form-input-pass {
      padding-right: 2.75rem !important;
    }
    .password-toggle {
      position: absolute;
      right: 0.75rem;
      background: transparent;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 0.25rem;
      transition: var(--transition);
      user-select: none;
    }
    .password-toggle:hover {
      color: #f1f5f9;
    }
    
    .form-input {
      height: 48px;
      background: #ffffff !important;
      border: 1.5px solid #cbd5e1 !important;
      color: #0f172a !important;
      border-radius: 14px;
      padding: 0 1rem;
      width: 100%;
      transition: var(--transition);
      -webkit-appearance: none;
    }
    .form-input::placeholder {
      color: #64748b !important;
    }
    .form-input:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
      outline: none;
    }
    .btn-login-submit {
      width: 100%;
      height: 52px;
      justify-content: center;
      margin-top: 0.75rem;
      font-size: 1rem;
      font-weight: 700;
      border-radius: 14px;
      background: linear-gradient(90deg, #38bdf8 0%, #6366f1 100%) !important;
      color: #ffffff !important;
      border: none;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      -webkit-tap-highlight-color: transparent;
    }
    .btn-login-submit:hover {
      opacity: 0.95;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
    }
    
    .logo-sky { color: var(--text-primary) !important; }
    .logo-web { color: var(--neon-cyan) !important; }
    .logo-text .dot-az { color: var(--neon-cyan) !important; }
  </style>
</head>
<body>
<canvas id="sky-canvas" aria-hidden="true"></canvas>
<div class="auth-wrap">
  <div class="auth-card glass-card">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
      <a href="../" class="logo" style="display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;">
        <div class="logo-icon" style="height:32px;">
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
        <span class="logo-text" style="font-size:1.15rem;font-weight:800;"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
      </a>
      <?= render_language_switcher() ?>
    </div>

    <h1 class="auth-title"><?= e(__('auth_login_title', 'Hesabınıza Daxil Olun')) ?></h1>
    <p class="auth-sub"><?= e(__('auth_login_subtitle', 'Skyweb ekosisteminə xoş gəlmisiniz')) ?></p>

    <form class="sky-form" id="login-form" method="POST" action="login-process.php">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="form-group">
        <label class="form-label" for="login-email"><?= e(__('auth_email', 'E-poçt / Telefon')) ?></label>
        <input type="text" id="login-email" name="email" class="form-input" placeholder="ali@example.com / +994..." required autocomplete="email" autocapitalize="none" autocorrect="off" spellcheck="false">
      </div>
      <div class="form-group">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
          <label class="form-label" for="login-pass" style="margin-bottom: 0;"><?= e(__('auth_password', 'Şifrə')) ?></label>
          <a href="forgot-password.php" class="forgot-link"><?= e(__('auth_forgot', 'Şifrəni unutmusunuz?')) ?></a>
        </div>
        <div class="input-wrapper">
          <input type="password" id="login-pass" name="password" class="form-input form-input-pass" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="password-toggle" onclick="togglePasswordVisibility('login-pass')">👁️</button>
        </div>
      </div>
      <button type="submit" class="btn-primary btn-login-submit" id="btn-login-submit">
        <span><?= e(__('auth_login_btn', 'Daxil ol')) ?></span>
      </button>
    </form>

    <div class="auth-divider"><?= e(__('or', 'və ya')) ?></div>

    <div class="auth-footer">
      <?= e(__('auth_no_account', 'Hesabınız yoxdur?')) ?> <a href="register.php" id="link-to-register"><?= e(__('auth_register_now', 'Pulsuz Qeydiyyat →')) ?></a>
    </div>
    <div class="auth-footer" style="margin-top:.5rem;">
      <a href="../">← <?= e(__('nav_home', 'Ana Səhifəyə Qayıt')) ?></a>
    </div>
  </div>
</div>
<script src="../assets/js/main.js" defer></script>
<script>
  window.skyLang = {
      logging_in: "<?= e(__('auth_logging_in', 'Daxil edilir...')) ?>",
      login_failed: "<?= e(__('auth_login_failed', 'Giriş uğursuz oldu.')) ?>",
      network_error: "<?= e(__('auth_network_error', 'Şəbəkə xətası baş verdi. Yenidən cəhd edin.')) ?>"
  };

  document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
      loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const btn = document.getElementById('btn-login-submit');
        const originalContent = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span>' + window.skyLang.logging_in + '</span>';
        
        const formData = new FormData(loginForm);
        
        try {
          const response = await fetch('login-process.php', {
            method: 'POST',
            body: formData
          });
          
          const result = await response.json();
          
          if (result.success) {
            window.skyToast(result.message, '✅');
            setTimeout(() => {
              window.location.href = result.redirect;
            }, 1500);
          } else {
            window.skyToast(result.message || window.skyLang.login_failed, '❌');
            btn.disabled = false;
            btn.innerHTML = originalContent;
          }
        } catch (error) {
          window.skyToast(window.skyLang.network_error, '❌');
          btn.disabled = false;
          btn.innerHTML = originalContent;
        }
      });
    }
  });
</script>
</body>
</html>
