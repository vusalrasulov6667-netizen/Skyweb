<?php
/**
 * SKYWEB.AZ — Şifrəmi Unutdum Səhifəsi
 * Premium Dark Cyber-Sky UI | Multi-step Verification | Responsive
 */
require_once __DIR__ . '/../config/config.php';
if (isLoggedIn()) redirect('');
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title><?= e(__('auth_forgot_title', 'Şifrəni bərpa et')) ?> — <?= SITE_NAME ?></title>
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
      text-align: center;
      transition: all 0.3s ease-in-out;
    }
    .auth-title { 
      font-size: 1.75rem; 
      font-weight: 800; 
      margin-bottom: .35rem; 
      color: #ffffff;
      font-family: var(--font-headings);
    }
    .auth-sub { 
      font-size: .875rem; 
      color: #cbd5e1; 
      margin-bottom: 1.75rem; 
      line-height: 1.4;
    }
    .form-label {
      display: block;
      font-weight: 600;
      color: #ffffff !important;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
      text-align: left;
    }
    .form-input {
      font-size: 16px !important; /* Auto-zoom fix for iOS */
      height: 52px;
      background: #e8f4fd !important;
      border: 2px solid #b9ddfc !important;
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
    .btn-submit {
      width: 100%;
      height: 52px;
      justify-content: center;
      margin-top: 1rem;
      font-size: 1rem;
      font-weight: 700;
      border-radius: 14px;
      background: linear-gradient(90deg, #38bdf8 0%, #6366f1 100%) !important;
      color: #ffffff !important;
      border: none;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      display: flex;
      align-items: center;
      gap: 0.5rem;
      -webkit-tap-highlight-color: transparent;
    }
    .btn-submit:hover {
      opacity: 0.95;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(99, 102, 241, 0.45);
    }
    .btn-submit:disabled {
      background: #475569 !important;
      box-shadow: none;
      cursor: not-allowed;
      opacity: 0.6;
    }
    .auth-footer { 
      text-align: center; 
      margin-top: 1.5rem; 
      font-size: .875rem; 
      color: #cbd5e1; 
    }
    .auth-footer a { 
      color: #38bdf8; 
      text-decoration: none; 
      font-weight: 600; 
      transition: color 0.2s;
    }
    .auth-footer a:hover {
      color: #7dd3fc;
      text-decoration: underline;
    }

    /* 6-Digit input layout */
    .code-inputs-container {
      display: flex;
      gap: 0.5rem;
      justify-content: center;
      margin: 1.5rem 0;
    }
    .code-digit-input {
      width: 48px;
      height: 54px;
      text-align: center;
      font-size: 1.6rem;
      font-weight: 700;
      border-radius: 12px;
      background: #e8f4fd !important;
      border: 2px solid #b9ddfc !important;
      color: #0f172a !important;
      transition: all 0.2s ease;
      -webkit-appearance: none;
    }
    .code-digit-input:focus {
      border-color: #3b82f6 !important;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25) !important;
      transform: scale(1.05);
      outline: none;
    }

    /* Resend timer design */
    .resend-box {
      margin-top: 1rem;
      font-size: 0.85rem;
      color: #94a3b8;
    }
    .btn-resend {
      background: none;
      border: none;
      color: #38bdf8;
      font-weight: 600;
      cursor: pointer;
      padding: 0;
      font-size: 0.85rem;
      text-decoration: underline;
    }
    .btn-resend:disabled {
      color: #64748b;
      cursor: not-allowed;
      text-decoration: none;
    }

    /* Password input wrappers */
    .input-wrapper {
      position: relative;
      display: block;
    }
    .form-input-pass {
      padding-right: 2.75rem !important;
    }
    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #475569;
      font-size: 1.1rem;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 10;
      -webkit-tap-highlight-color: transparent;
    }

    /* Steps visibility controller */
    .step-content {
      display: none;
    }
    .step-content.active {
      display: block;
      animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Logo styles matching dark theme */
    .logo-sky {
      color: var(--text-primary) !important;
    }
    .logo-web {
      color: var(--neon-cyan) !important;
    }
    .logo-text .dot-az {
      color: var(--neon-cyan) !important;
    }
  </style>
</head>
<body>
<canvas id="sky-canvas" aria-hidden="true"></canvas>
<div class="auth-wrap">
  <div class="auth-card glass-card">
    <!-- Platform Logo -->
    <a href="../" class="logo" style="display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;margin-bottom:1.5rem;">
      <div class="logo-icon" style="height:32px;">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="skySGradFP" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#38bdf8" />
              <stop offset="100%" stop-color="#0284c7" />
            </linearGradient>
            <filter id="skyLogoGlowFP" x="-20%" y="-20%" width="140%" height="140%">
              <feGaussianBlur stdDeviation="3" result="blur" />
              <feMerge>
                <feMergeNode in="blur" />
                <feMergeNode in="SourceGraphic" />
              </feMerge>
            </filter>
          </defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGradFP)" />
          <g filter="url(#skyLogoGlowFP)">
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

    <!-- CSRF token for forms -->
    <input type="hidden" id="csrf-token" value="<?= e(csrf_token()) ?>">

    <!-- ── STEP 1: ENTER EMAIL ── -->
    <div id="step-1" class="step-content active">
      <h1 class="auth-title">Şifrəni bərpa et</h1>
      <p class="auth-sub">Qeydiyyatdan keçdiyiniz e-poçt (Gmail) ünvanınızı daxil edin. Sizə bərpa kodu göndərəcəyik.</p>
      
      <form id="form-send-code" onsubmit="handleSendCode(event)">
        <div class="form-group">
          <label class="form-label" for="recovery-email">Bərpa E-poçtu</label>
          <input type="email" id="recovery-email" class="form-input" placeholder="nümunə@gmail.com" required autocomplete="email" inputmode="email">
        </div>
        <button type="submit" class="btn-submit" id="btn-send-code">
          <span>Kod göndər</span>
        </button>
      </form>
      
      <div class="auth-footer">
        <a href="login.php">← Giriş səhifəsinə qayıt</a>
      </div>
    </div>

    <!-- ── STEP 2: VERIFY CODE ── -->
    <div id="step-2" class="step-content">
      <h1 class="auth-title">Təsdiq kodu</h1>
      <p class="auth-sub" id="verify-sub-text">Bərpa kodu e-poçt ünvanınıza göndərildi. 6 rəqəmli kodu daxil edin.</p>
      
      <form id="form-verify-code" onsubmit="handleVerifyCode(event)">
        <div class="form-group">
          <label class="form-label">Təsdiq Kodu</label>
          
          <div class="code-inputs-container" id="code-container">
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
            <input type="text" maxlength="1" class="code-digit-input" inputmode="numeric" pattern="[0-9]*" required>
          </div>
        </div>
        
        <button type="submit" class="btn-submit" id="btn-verify-code">
          <span>Kodu təsdiqlə</span>
        </button>
      </form>

      <div class="resend-box">
        Kodu almadınız? <button type="button" class="btn-resend" id="btn-resend-trigger" onclick="resendCode()" disabled>Yenidən göndər (<span id="timer-sec">60</span>s)</button>
      </div>
      
      <div class="auth-footer">
        <a href="#" onclick="goToStep(1)">← E-poçtu dəyişdir</a>
      </div>
    </div>

    <!-- ── STEP 3: RESET PASSWORD ── -->
    <div id="step-3" class="step-content">
      <h1 class="auth-title">Yeni şifrə</h1>
      <p class="auth-sub">Hesabınız üçün yeni etibarlı şifrə daxil edin.</p>
      
      <form id="form-reset-password" onsubmit="handleResetPassword(event)">
        <div class="form-group" style="margin-bottom: 1rem;">
          <label class="form-label" for="new-pass">Yeni Şifrə</label>
          <div class="input-wrapper">
            <input type="password" id="new-pass" class="form-input form-input-pass" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('new-pass')">👁️</button>
          </div>
        </div>
        <div class="form-group" style="margin-bottom: 1rem;">
          <label class="form-label" for="new-pass-confirm">Şifrənin Təkrarı</label>
          <div class="input-wrapper">
            <input type="password" id="new-pass-confirm" class="form-input form-input-pass" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('new-pass-confirm')">👁️</button>
          </div>
        </div>
        <button type="submit" class="btn-submit" id="btn-reset-password">
          <span>Şifrəni yenilə</span>
        </button>
      </form>
    </div>

  </div>
</div>

<script src="../assets/js/main.js" defer></script>
<script>
  let recoveryEmail = '';
  let resendTimer = null;
  let secondsRemaining = 0;

  function goToStep(stepNumber) {
    document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
    document.getElementById(`step-${stepNumber}`).classList.add('active');
    
    if (stepNumber === 2) {
      // Focus first digit input automatically
      setTimeout(() => {
        const firstInput = document.querySelector('.code-digit-input');
        if (firstInput) firstInput.focus();
      }, 350);
    }
  }

  // Handle 6-Digit focus shifting
  document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('code-container');
    if (container) {
      const inputs = container.querySelectorAll('input');
      
      inputs.forEach((input, index) => {
        // Automatically jump to next input on type
        input.addEventListener('input', (e) => {
          const val = e.target.value;
          // Only allow digits
          e.target.value = val.replace(/[^0-9]/g, '');
          
          if (e.target.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
          }
        });

        // Go to previous input on Backspace press
        input.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && !input.value && index > 0) {
            inputs[index - 1].focus();
          }
        });

        // Paste functionality
        input.addEventListener('paste', (e) => {
          e.preventDefault();
          const text = (e.clipboardData || window.clipboardData).getData('text').trim();
          if (/^\d{6}$/.test(text)) {
            inputs.forEach((inp, idx) => {
              inp.value = text[idx];
            });
            inputs[inputs.length - 1].focus();
          }
        });
      });
    }
  });

  // Start resend code timer
  function startResendTimer() {
    clearInterval(resendTimer);
    secondsRemaining = 60;
    const btn = document.getElementById('btn-resend-trigger');
    const label = document.getElementById('timer-sec');
    
    btn.disabled = true;
    label.textContent = secondsRemaining;
    
    resendTimer = setInterval(() => {
      secondsRemaining--;
      label.textContent = secondsRemaining;
      
      if (secondsRemaining <= 0) {
        clearInterval(resendTimer);
        btn.disabled = false;
        btn.innerHTML = 'Yenidən göndər';
      }
    }, 1000);
  }

  // STEP 1: Submit email
  async function handleSendCode(e) {
    e.preventDefault();
    const emailInput = document.getElementById('recovery-email');
    recoveryEmail = emailInput.value.trim().toLowerCase();
    
    const btn = document.getElementById('btn-send-code');
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span>Göndərilir...</span>';
    
    const csrf = document.getElementById('csrf-token').value;
    
    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('action', 'send_code');
    formData.append('email', recoveryEmail);
    
    try {
      const response = await fetch('forgot-password-process.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        window.skyToast(result.message, '✅');
        document.getElementById('verify-sub-text').innerHTML = `Təsdiq kodu <strong>${escapeHtml(recoveryEmail)}</strong> ünvanına göndərildi. Zəhmət olmasa yoxlayın.`;
        goToStep(2);
        startResendTimer();
      } else {
        window.skyToast(result.message || 'Xəta baş verdi.', '❌');
      }
    } catch (err) {
      window.skyToast('Şəbəkə xətası baş verdi. Yenidən cəhd edin.', '❌');
    } finally {
      btn.disabled = false;
      btn.innerHTML = originalContent;
    }
  }

  // Resend code trigger
  async function resendCode() {
    const btn = document.getElementById('btn-resend-trigger');
    btn.disabled = true;
    btn.innerHTML = 'Göndərilir...';
    
    const csrf = document.getElementById('csrf-token').value;
    
    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('action', 'send_code');
    formData.append('email', recoveryEmail);
    
    try {
      const response = await fetch('forgot-password-process.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        window.skyToast('Yeni kod göndərildi.', '✅');
        startResendTimer();
      } else {
        window.skyToast(result.message || 'Xəta baş verdi.', '❌');
        btn.disabled = false;
        btn.innerHTML = 'Yenidən göndər';
      }
    } catch (err) {
      window.skyToast('Şəbəkə xətası baş verdi. Yenidən cəhd edin.', '❌');
      btn.disabled = false;
      btn.innerHTML = 'Yenidən göndər';
    }
  }

  // STEP 2: Verify code
  async function handleVerifyCode(e) {
    e.preventDefault();
    const inputs = document.querySelectorAll('.code-digit-input');
    let code = '';
    inputs.forEach(inp => code += inp.value);
    
    if (code.length !== 6) {
      window.skyToast('Zəhmət olmasa 6 rəqəmli kodu tam daxil edin.', '❌');
      return;
    }
    
    const btn = document.getElementById('btn-verify-code');
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span>Yoxlanılır...</span>';
    
    const csrf = document.getElementById('csrf-token').value;
    
    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('action', 'verify_code');
    formData.append('email', recoveryEmail);
    formData.append('code', code);
    
    try {
      const response = await fetch('forgot-password-process.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        window.skyToast(result.message, '✅');
        goToStep(3);
      } else {
        window.skyToast(result.message || 'Yanlış təsdiq kodu.', '❌');
        // Flash inputs red on error
        inputs.forEach(inp => {
          inp.style.borderColor = '#ef4444';
          setTimeout(() => {
            inp.style.borderColor = '#b9ddfc';
            inp.value = '';
          }, 1500);
        });
        inputs[0].focus();
      }
    } catch (err) {
      window.skyToast('Şəbəkə xətası baş verdi. Yenidən cəhd edin.', '❌');
    } finally {
      btn.disabled = false;
      btn.innerHTML = originalContent;
    }
  }

  // STEP 3: Reset password
  async function handleResetPassword(e) {
    e.preventDefault();
    const pass = document.getElementById('new-pass').value;
    const confirm = document.getElementById('new-pass-confirm').value;
    
    if (pass.length < 6) {
      window.skyToast('Şifrə minimum 6 simvoldan ibarət olmalıdır.', '❌');
      return;
    }
    
    if (pass !== confirm) {
      window.skyToast('Şifrələr eyni deyil.', '❌');
      return;
    }
    
    const btn = document.getElementById('btn-reset-password');
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span>Yenilənir...</span>';
    
    const csrf = document.getElementById('csrf-token').value;
    
    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('action', 'reset_password');
    formData.append('email', recoveryEmail);
    formData.append('password', pass);
    formData.append('password_confirm', confirm);
    
    try {
      const response = await fetch('forgot-password-process.php', {
        method: 'POST',
        body: formData
      });
      
      const result = await response.json();
      
      if (result.success) {
        window.skyToast(result.message, '✅');
        setTimeout(() => {
          window.location.href = result.redirect;
        }, 2000);
      } else {
        window.skyToast(result.message || 'Xəta baş verdi.', '❌');
      }
    } catch (err) {
      window.skyToast('Şəbəkə xətası baş verdi. Yenidən cəhd edin.', '❌');
    } finally {
      btn.disabled = false;
      btn.innerHTML = originalContent;
    }
  }

  function escapeHtml(text) {
    return text
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
  }
</script>
</body>
</html>
