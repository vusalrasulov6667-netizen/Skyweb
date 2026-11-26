<?php
/**
 * SKYWEB.AZ — Oyun Sifariş Paneli
 * Biznes üçün Mini Oyun Sifarişi
 */
require_once __DIR__ . '/../../config/config.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="<?= e(__('games_panel_desc', 'Skyweb.az — Biznesiniz üçün Viktorina, Tapmaca, İdman kimi interaktiv mini oyunlar sifariş edin.')) ?>">
  <title><?= e(__('games_panel_title', 'Oyun Sifariş Paneli')) ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="<?= SITE_URL ?>/assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <style>
    .games-page { padding-top: 90px; min-height: 100vh; }

    /* Breadcrumb */
    .breadcrumb { display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:var(--text-muted);margin-bottom:2rem; }
    .breadcrumb a { color:var(--neon-cyan);text-decoration:none; }
    .breadcrumb a:hover { text-decoration:underline; }

    /* Hero */
    .games-hero {
      background: linear-gradient(135deg, rgba(16,185,129,0.08) 0%, rgba(99,102,241,0.06) 100%);
      border: 1px solid rgba(16,185,129,0.2); border-radius: var(--radius-xl);
      padding: 3rem 2.5rem; margin-bottom: 3rem; position: relative; overflow: hidden;
      display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
    }
    .games-hero::before {
      content:''; position:absolute; top:-40px; right:-40px;
      width:300px; height:300px; border-radius:50%;
      background: radial-gradient(circle, rgba(16,185,129,0.1) 0%, transparent 70%);
    }
    .games-hero-badge {
      display:inline-flex;align-items:center;gap:0.5rem;
      background:rgba(16,185,129,0.12);border:1px solid rgba(16,185,129,0.3);
      color:#6ee7b7;border-radius:999px;padding:0.3rem 1rem;
      font-size:0.78rem;font-weight:600;margin-bottom:0.75rem;
    }
    .games-hero-title { font-size:clamp(1.6rem,4vw,2.6rem);font-weight:800;line-height:1.2;margin-bottom:0.75rem; }
    .games-hero-desc { color:var(--text-muted);font-size:0.95rem;line-height:1.7;max-width:500px; }
    .games-hero-right { display:flex;flex-direction:column;gap:1rem;flex-shrink:0; }
    .hero-stat { text-align:center; }
    .hero-stat-val { font-size:2rem;font-weight:900;color:var(--neon-green); }
    .hero-stat-label { font-size:0.75rem;color:var(--text-muted);font-weight:500; }

    /* Game Cards Grid */
    .games-grid {
      display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));
      gap:1.5rem;margin-bottom:3rem;
    }
    .game-card {
      background:var(--sky-card);border:1px solid var(--sky-border);
      border-radius:var(--radius-lg);overflow:hidden;
      transition:var(--transition);position:relative;
    }
    .game-card:hover { border-color:var(--sky-border-glow);transform:translateY(-5px);box-shadow:0 25px 50px -20px rgba(16,185,129,0.15); }
    .game-card-preview {
      height:180px;display:flex;align-items:center;justify-content:center;
      font-size:5rem;position:relative;overflow:hidden;
    }
    .game-card-preview::after {
      content:'';position:absolute;inset:0;
      background:linear-gradient(to bottom, transparent 40%, var(--sky-card) 100%);
    }
    .game-badge {
      position:absolute;top:0.75rem;left:0.75rem;z-index:2;
      padding:0.2rem 0.7rem;border-radius:999px;font-size:0.7rem;font-weight:700;
    }
    .badge-new { background:rgba(16,185,129,0.9);color:#fff; }
    .badge-popular { background:rgba(99,102,241,0.9);color:#fff; }

    .game-card-body { padding:1.25rem 1.5rem 1.5rem;display:flex;flex-direction:column; }
    .game-name { font-size:1.1rem;font-weight:800;margin-bottom:0.4rem; }
    .game-desc { font-size:0.84rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem; }
    .game-features { display:flex;flex-wrap:wrap;gap:0.4rem;margin:0 0 1.25rem; }
    .game-feat-tag {
      padding:0.2rem 0.6rem;border-radius:6px;font-size:0.72rem;font-weight:600;
      background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--text-muted);
    }
    .game-demo-btn {
      width:100%;margin-top:auto;padding:0.7rem 1.4rem;border-radius:var(--radius-sm);
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      color:#fff;font-size:0.85rem;font-weight:700;
      border:none;cursor:pointer;transition:var(--transition);
    }
    .game-demo-btn:hover { box-shadow:0 0 20px rgba(16,185,129,0.4);transform:translateY(-2px); }

    /* Playable brand quiz */
    .quiz-overlay {
      position:fixed;inset:0;z-index:10000;padding:1rem;
      background:rgba(3,7,18,0.86);backdrop-filter:blur(8px);
      display:flex;align-items:center;justify-content:center;
      opacity:0;visibility:hidden;transition:opacity 0.25s ease,visibility 0.25s ease;
    }
    .quiz-overlay.open { opacity:1;visibility:visible; }
    .quiz-box {
      width:100%;max-width:560px;max-height:92vh;overflow-y:auto;
      background:#0d1127;border:1px solid var(--sky-border);
      border-radius:var(--radius-xl);padding:2rem;
      box-shadow:0 30px 80px -30px rgba(16,185,129,0.35);
      position:relative;transform:translateY(16px);transition:transform 0.25s ease;
    }
    .quiz-overlay.open .quiz-box { transform:translateY(0); }
    .quiz-close {
      position:absolute;top:0.9rem;right:0.9rem;width:34px;height:34px;
      display:flex;align-items:center;justify-content:center;cursor:pointer;
      background:rgba(255,255,255,0.06);border:1px solid var(--sky-border);
      border-radius:8px;color:var(--text-muted);font-size:1rem;transition:var(--transition);
    }
    .quiz-close:hover { background:rgba(244,63,94,0.15);color:var(--neon-rose); }

    /* Modern quiz identity — shared by the card preview and the game modal */
    .game-quiz-mark {
      position:relative;z-index:2;width:66px;height:66px;border-radius:19px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#38bdf8 0%,#818cf8 52%,#10b981 100%);
      box-shadow:0 16px 34px -12px rgba(56,189,248,0.75),inset 0 1px 0 rgba(255,255,255,0.45);
      transform:rotate(-6deg);transition:transform 0.3s ease;
    }
    .game-card:hover .game-quiz-mark { transform:rotate(0deg) scale(1.05); }
    .game-quiz-mark svg { width:38px;height:38px; }
    .quiz-brand { display:flex;align-items:center;gap:0.9rem;padding-right:2.5rem;margin-bottom:1.25rem; }
    .quiz-brand-mark {
      flex:0 0 48px;width:48px;height:48px;border-radius:14px;
      display:flex;align-items:center;justify-content:center;
      background:linear-gradient(135deg,#38bdf8 0%,#818cf8 52%,#10b981 100%);
      box-shadow:0 10px 26px -10px rgba(56,189,248,0.8),inset 0 1px 0 rgba(255,255,255,0.45);
    }
    .quiz-brand-mark svg { width:28px;height:28px; }
    .quiz-brand-copy { display:flex;flex-direction:column;gap:0.15rem;min-width:0; }
    .quiz-brand-name {
      font-family:'Outfit',var(--font-main);font-size:1.05rem;font-weight:800;
      background:linear-gradient(90deg,var(--neon-cyan),var(--neon-green));
      -webkit-background-clip:text;background-clip:text;color:transparent;
    }
    .quiz-brand-sub { font-size:0.72rem;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--text-muted); }
    .quiz-topic {
      display:inline-flex;align-items:center;gap:0.4rem;
      padding:0.3rem 0.7rem;margin-bottom:0.9rem;
      border:1px solid rgba(56,189,248,0.35);border-radius:999px;
      background:rgba(56,189,248,0.08);color:var(--neon-cyan);
      font-size:0.74rem;font-weight:700;letter-spacing:0.3px;
    }
    .quiz-topic::before { content:'';width:6px;height:6px;border-radius:50%;background:var(--neon-green);box-shadow:0 0 8px var(--neon-green); }
    .quiz-counter { font-size:0.82rem;color:var(--text-muted);margin:0 0 0.9rem; }
    .quiz-progress { height:6px;border-radius:999px;background:rgba(255,255,255,0.08);overflow:hidden;margin-bottom:1.5rem; }
    .quiz-progress-bar { height:100%;width:20%;border-radius:999px;background:linear-gradient(90deg,var(--neon-green),var(--neon-cyan));transition:width 0.3s ease; }
    .quiz-question { font-size:1.15rem;font-weight:700;line-height:1.5;margin-bottom:1.25rem; }
    .quiz-options { display:grid;gap:0.6rem; }
    .quiz-option {
      width:100%;text-align:left;padding:0.85rem 1rem;cursor:pointer;
      background:rgba(255,255,255,0.04);border:1px solid var(--sky-border);
      border-radius:var(--radius-sm);color:var(--text-primary);
      font-size:0.9rem;font-family:var(--font-main);transition:var(--transition);
    }
    .quiz-option:hover:not(:disabled) { border-color:rgba(16,185,129,0.55);background:rgba(16,185,129,0.08);transform:translateX(3px); }
    .quiz-option.is-correct { border-color:var(--neon-green);background:rgba(16,185,129,0.16);color:#6ee7b7; }
    .quiz-option.is-wrong { border-color:var(--neon-rose);background:rgba(244,63,94,0.12);color:#fda4af; }
    .quiz-option.is-muted { opacity:0.45; }
    .quiz-feedback { margin-top:1rem;font-size:0.88rem;font-weight:700;line-height:1.6; }
    .quiz-feedback-answer { display:block;font-weight:500;color:var(--text-muted);margin-top:0.2rem; }
    .quiz-next {
      width:100%;margin-top:1.25rem;padding:0.8rem 1.2rem;cursor:pointer;
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      border:none;border-radius:var(--radius-sm);color:#fff;
      font-size:0.9rem;font-weight:700;font-family:var(--font-main);transition:var(--transition);
    }
    .quiz-next:hover { box-shadow:0 0 24px rgba(16,185,129,0.4);transform:translateY(-2px); }
    .quiz-result { text-align:center;padding:1rem 0 0.25rem; }
    .quiz-result-icon { font-size:3rem;margin-bottom:0.75rem; }
    .quiz-result-title { font-size:1.35rem;font-weight:800;margin-bottom:0.35rem; }
    .quiz-result-score { color:var(--neon-green);font-weight:800;font-size:1.05rem;margin-bottom:0.5rem; }
    .quiz-result-msg { color:var(--text-muted);font-size:0.9rem; }
    .quiz-next[hidden],.quiz-feedback[hidden],.quiz-result[hidden],.quiz-feedback-answer[hidden] { display:none !important; }
    @media(max-width:600px){ .quiz-box { padding:1.5rem 1.25rem; } .quiz-question { font-size:1.02rem; } }
  </style>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<nav id="main-navbar" class="navbar" role="navigation" aria-label="Əsas naviqasiya">
  <div class="container nav-inner">
    <?= render_language_switcher('module-lang-switch') ?>
    <a href="<?= SITE_URL ?>" class="logo" id="logo-link" aria-label="Skyweb.az Ana Səhifə">
      <div class="logo-icon" aria-hidden="true">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="skySGrad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#38bdf8" />
              <stop offset="100%" stop-color="#0284c7" />
            </linearGradient>
            <filter id="skyLogoGlow" x="-20%" y="-20%" width="140%" height="140%">
              <feGaussianBlur stdDeviation="3" result="blur" />
              <feMerge>
                <feMergeNode in="blur" />
                <feMergeNode in="SourceGraphic" />
              </feMerge>
            </filter>
          </defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGrad)" />
          <g filter="url(#skyLogoGlow)">
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
      <span class="logo-text"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
    </a>
    <a href="<?= SITE_URL ?>" style="color:var(--text-muted);text-decoration:none;font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;">← Ana səhifəyə qayıt</a>
  </div>
</nav>

<main class="games-page">
  <div class="container">

    <nav class="breadcrumb" aria-label="Naviqasiya yolu">
      <a href="<?= SITE_URL ?>">Ana Səhifə</a>
      <span style="opacity:0.4">/</span>
      <span>Oyun Sifariş Paneli</span>
    </nav>

    <!-- Hero -->
    <div class="games-hero">
      <div style="flex:1;min-width:250px;">
        <div class="games-hero-badge">🎮 Gamification Xidmətləri</div>
        <h1 class="games-hero-title">Brendinizə <span class="gradient-text">Mini Oyun</span> Sifariş Edin</h1>
        <p class="games-hero-desc">İstənilən biznes üçün müştəri cəlb edəcək, loyallığı artıracaq interaktiv mini oyunlar hazırlayırıq. Web &amp; Wap uyumlu, tam hazır çatdırılır.</p>
        <div style="display:flex;gap:0.75rem;flex-wrap:wrap;margin-top:1.5rem;">
          <a href="#gamesGrid" class="btn-ghost"><span>Oyunlara Bax</span></a>
        </div>
      </div>
      <div class="games-hero-right">
        <div class="hero-stat"><div class="hero-stat-val">120+</div><div class="hero-stat-label">Tamamlanan layihə</div></div>
        <div class="hero-stat"><div class="hero-stat-val">98%</div><div class="hero-stat-label">Müştəri məmnuniyyəti</div></div>
        <div class="hero-stat"><div class="hero-stat-val">3-7</div><div class="hero-stat-label">Günlük çatdırılma</div></div>
      </div>
    </div>

    <!-- Game Cards -->
    <div class="games-grid" id="gamesGrid">

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(99,102,241,0.15),rgba(139,92,246,0.1));">
          <span class="game-quiz-mark" aria-hidden="true">
            <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M25 23a7 7 0 1 1 11 5.6c-2.2 1.7-4 2.7-4 5.4" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
              <circle cx="32" cy="43" r="2.6" fill="#fff"/>
              <path d="M49 7l1.4 4.1L54.5 12.5l-4.1 1.4L49 18l-1.4-4.1L43.5 12.5l4.1-1.4z" fill="#fff" opacity="0.9"/>
            </svg>
          </span>
          <div class="game-badge badge-popular">Populyar</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Viktorinası</div>
          <div class="game-desc">Brend və məhsullarınız haqqında suallar-cavablar oyunu. Müştərilər oynayır, brend bilinirliyi artır, sosial mediada paylaşılır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Çox oyunçu</span>
            <span class="game-feat-tag">Liderlik cədvəli</span>
            <span class="game-feat-tag">Mükafat sistemi</span>
            <span class="game-feat-tag">Avtomatik hesab</span>
          </div>
          <button class="game-demo-btn" id="quizDemoBtn" type="button">Demo / Yeni Ön Baxış</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(99,102,241,0.1),rgba(244,63,94,0.08));">
          <span style="position:relative;z-index:2;">🧠</span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Canlı Viktorina Müsabiqəsi</div>
          <div class="game-desc">Sosial media canlı yayımlarında istifadə üçün interaktiv viktorina. İzləyicilər real vaxtda iştirak edir, ən yaxşılar mükafat qazanır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Canlı rejim</span>
            <span class="game-feat-tag">İnstagram uyumlu</span>
            <span class="game-feat-tag">Moderasiya paneli</span>
          </div>
          <button class="game-demo-btn" type="button">Demo / Yeni Ön Baxış</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(56,189,248,0.12),rgba(99,102,241,0.08));">
          <span style="position:relative;z-index:2;">🧩</span>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend Tapmacaları</div>
          <div class="game-desc">Müştərinin həll etməsi üçün brend mövzusunda interaktiv tapmacalar. Oyunu bitirənə xüsusi endirim kodu göstərilir.</div>
          <div class="game-features">
            <span class="game-feat-tag">Avtomatik çatdırılma</span>
            <span class="game-feat-tag">Çətinlik səviyyəsi</span>
            <span class="game-feat-tag">Analitika</span>
          </div>
          <button class="game-demo-btn" type="button">Demo / Yeni Ön Baxış</button>
        </div>
      </div>

      <div class="game-card">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(56,189,248,0.08));">
          <span style="position:relative;z-index:2;">⚽</span>
        </div>
        <div class="game-card-body">
          <div class="game-name">Brend İdman Oyunu</div>
          <div class="game-desc">Futbol, basketbol və ya digər idman mövzusunda mini oyun. Korporativ tədbirlər, sponsorluqlar üçün mükəmməldir.</div>
          <div class="game-features">
            <span class="game-feat-tag">Tədbirlər üçün</span>
            <span class="game-feat-tag">Turnir rejimi</span>
            <span class="game-feat-tag">Liderlik cədvəli</span>
          </div>
          <button class="game-demo-btn" type="button">Demo / Yeni Ön Baxış</button>
        </div>
      </div>

    </div><!-- /games-grid -->

  </div>
</main>

<!-- Brend Viktorinası — oynanabilir demo -->
<div class="quiz-overlay" id="quizOverlay" role="dialog" aria-modal="true" aria-label="Brend Viktorinası">
  <div class="quiz-box">
    <button class="quiz-close" id="quizClose" type="button" aria-label="Oyunu bağla">✕</button>
    <div class="quiz-brand">
      <span class="quiz-brand-mark" aria-hidden="true">
        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M25 23a7 7 0 1 1 11 5.6c-2.2 1.7-4 2.7-4 5.4" stroke="#fff" stroke-width="4" stroke-linecap="round"/>
          <circle cx="32" cy="43" r="2.6" fill="#fff"/>
          <path d="M49 7l1.4 4.1L54.5 12.5l-4.1 1.4L49 18l-1.4-4.1L43.5 12.5l4.1-1.4z" fill="#fff" opacity="0.9"/>
        </svg>
      </span>
      <span class="quiz-brand-copy">
        <span class="quiz-brand-name">Brend Viktorinası</span>
        <span class="quiz-brand-sub">25 Azərbaycan sualı</span>
      </span>
    </div>
    <div class="quiz-topic" id="quizTopic">Azərbaycan coğrafiyası</div>
    <div class="quiz-counter"><span>Sual</span> <span id="quizQNum">1</span> / <span id="quizQTotal">25</span></div>
    <div class="quiz-progress"><div class="quiz-progress-bar" id="quizProgressBar"></div></div>

    <div id="quizPlay">
      <h2 class="quiz-question" id="quizQuestion"></h2>
      <div class="quiz-options" id="quizOptions"></div>
      <div class="quiz-feedback" id="quizFeedback" aria-live="polite" hidden>
        <span id="quizFeedbackText"></span>
        <span class="quiz-feedback-answer" id="quizFeedbackAnswerWrap" hidden><span>Doğru cavab:</span> <span id="quizFeedbackAnswer"></span></span>
      </div>
      <button class="quiz-next" id="quizNext" type="button" hidden>Növbəti sual</button>
    </div>

    <div class="quiz-result" id="quizResult" hidden>
      <div class="quiz-result-icon">🏆</div>
      <h2 class="quiz-result-title">Oyun bitdi!</h2>
      <p class="quiz-result-score"><span>Bal:</span> <span id="quizScore">0</span></p>
      <p class="quiz-result-msg" id="quizResultMsg"></p>
      <button class="quiz-next" id="quizRestart" type="button">Yenidən oyna</button>
    </div>
  </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>
(function () {
  var overlay     = document.getElementById('quizOverlay');
  var openBtn     = document.getElementById('quizDemoBtn');
  var closeBtn    = document.getElementById('quizClose');
  var play        = document.getElementById('quizPlay');
  var result      = document.getElementById('quizResult');
  var topicEl     = document.getElementById('quizTopic');
  var questionEl  = document.getElementById('quizQuestion');
  var optionsEl   = document.getElementById('quizOptions');
  var qNum        = document.getElementById('quizQNum');
  var qTotal      = document.getElementById('quizQTotal');
  var progress    = document.getElementById('quizProgressBar');
  var feedback    = document.getElementById('quizFeedback');
  var feedbackTxt = document.getElementById('quizFeedbackText');
  var answerWrap  = document.getElementById('quizFeedbackAnswerWrap');
  var answerEl    = document.getElementById('quizFeedbackAnswer');
  var nextBtn     = document.getElementById('quizNext');
  var restartBtn  = document.getElementById('quizRestart');
  var scoreEl     = document.getElementById('quizScore');
  var resultMsg   = document.getElementById('quizResultMsg');

  if (!overlay || !openBtn) return;

  // 25 Azerbaijan questions — 5 topics x 5 questions. AZ source strings are
  // translated through the shared SkyI18n literal map, so every option follows
  // the active language exactly like the rest of the site.
  var questions = [
    /* Coğrafiya */
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın ərazisi neçə kvadrat kilometrdir?',
      options: ['86,600 km²', '186,600 km²', '56,600 km²', '126,600 km²'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Ərazisinə görə Azərbaycanın ən böyük şəhəri hansıdır?',
      options: ['Bakı', 'Sumqayıt', 'Gəncə', 'Naxçıvan'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Əhalisinin sayına görə Azərbaycanda üçüncü ən böyük şəhər hansıdır?',
      options: ['Gəncə', 'Sumqayıt', 'Xırdalan', 'Mingəçevir'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın ən yüksək dağ zirvəsi hansıdır?',
      options: ['Bazardüzü', 'Şahdağ', 'Tufandağ', 'Qapıcıq'], answer: 0
    },
    {
      topic: 'Azərbaycan coğrafiyası',
      q: 'Azərbaycanın quru sərhədinin olduğu ölkələr hansılardır?',
      options: [
        'Rusiya, Gürcüstan, Ermənistan, İran və Türkiyə',
        'Rusiya, Ukrayna, İran və Türkiyə',
        'Gürcüstan, Ermənistan, İraq və İran',
        'İran, Türkiyə, Suriya və Rusiya'
      ], answer: 0
    },

    /* Tarix */
    {
      topic: 'Azərbaycan tarixi',
      q: 'İkinci Qarabağ müharibəsinin Zəfər Günü hansı tarixdir?',
      options: ['8 noyabr 2020', '10 noyabr 2020', '27 sentyabr 2020', '9 may 1945'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Vətən müharibəsi neçə gün davam etdi?',
      options: ['44 gün', '28 gün', '100 gün', '30 gün'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Zəfər Günündə azad edilən şəhər hansı oldu?',
      options: ['Şuşa', 'Gəncə', 'Bərdə', 'Tərtər'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Azərbaycan müstəqilliyini nə vaxt bərpa etdi?',
      options: ['18 oktyabr 1991', '28 may 1918', '2 mart 1992', '10 noyabr 2020'], answer: 0
    },
    {
      topic: 'Azərbaycan tarixi',
      q: 'Atəşkəs haqqında üçtərəfli bəyanat hansı tarixdə imzalandı?',
      options: ['10 noyabr 2020', '8 noyabr 2020', '27 sentyabr 2020', '1 dekabr 2020'], answer: 0
    },

    /* İdman */
    {
      topic: 'Azərbaycan idmanı',
      q: '1966-cı il Dünya Kuboku finalında qol qərarı ilə tanınan azərbaycanlı hakim kimdir?',
      options: ['Tofiq Bəhramov', 'Rəfael Ağayev', 'Elnur Məmmədli', 'Vüqar Həşimov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2008 Pekin Olimpiadasında cüdoda qızıl medal qazanan idmançı kimdir?',
      options: ['Elnur Məmmədli', 'Rəfael Ağayev', 'Mariya Stadnik', 'Şəhriyar Məmmədyarov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: 'Dünya karate çempionatlarında beş dəfə çempion olan idmançı kimdir?',
      options: ['Rəfael Ağayev', 'Tofiq Bəhramov', 'Elnur Məmmədli', 'Vüqar Həşimov'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2009-cu ildə dünya reytinqində 6-cı yerə qədər yüksələn şahmatçı kimdir?',
      options: ['Vüqar Həşimov', 'Şəhriyar Məmmədyarov', 'Tofiq Bəhramov', 'Rəfael Ağayev'], answer: 0
    },
    {
      topic: 'Azərbaycan idmanı',
      q: '2012 London Olimpiadasında güləş üzrə qızıl medal qazanan azərbaycanlı idmançı kimdir?',
      options: ['Toğrul Əsgərov', 'Mariya Stadnik', 'Rövşən Bayramov', 'Emin Əhmədov'], answer: 0
    },

    /* İncəsənət */
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Azərbaycanda ilk operanı — "Leyli və Məcnun"u kim yazdı?',
      options: ['Üzeyir Hacıbəyov', 'Qara Qarayev', 'Müslüm Maqomayev', 'Səttar Bəhlulzadə'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: '"Yeddi gözəl" baletinin bəstəkarı kimdir?',
      options: ['Qara Qarayev', 'Üzeyir Hacıbəyov', 'Soltan Hacıbəyov', 'Müslüm Maqomayev'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Rəssam Səttar Bəhlulzadə hansı mövzuda əsərləri ilə tanınır?',
      options: ['Qarabağ təbiəti', 'Dəniz limanları', 'Şəhər küçələri', 'Zavodlar'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: '1962-ci ildə Kreml Sarayında çıxışı ilə şöhrət qazanan müğənni kimdir?',
      options: ['Müslüm Maqomayev', 'Üzeyir Hacıbəyov', 'Qara Qarayev', 'Səttar Bəhlulzadə'], answer: 0
    },
    {
      topic: 'Azərbaycan incəsənəti',
      q: 'Şuşada yaşayıb yaradan məşhur azərbaycanlı şairə kimdir?',
      options: ['Xurşidbanu Natəvan', 'Səttar Bəhlulzadə', 'Müslüm Maqomayev', 'Qara Qarayev'], answer: 0
    },

    /* Təbiət */
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Hirkan meşələrində və Zəngəzurda rast gəlinən nadir iri pişik hansıdır?',
      options: ['Fars bəbiri', 'Qəhvəyi ayı', 'Qızıl tülkü', 'Vaşaq'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Kürü üçün ən dəyərli Xəzər balıqlarından biri hansıdır?',
      options: ['Ağ nərə (beluga)', 'Kütüm', 'Qızılbalıq', 'Sardina'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Azərbaycanın dağlıq ərazilərində yaşayan və markalarda təsvir edilən yırtıcı quş hansıdır?',
      options: ['Qızıl qartal', 'Flaminqo', 'Leylək', 'Qara quzğun'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Şirvan Milli Parkı hansı heyvanın əsas yaşayış yeridir?',
      options: ['Ceyranın', 'Qızıl qartalın', 'Fars bəbiri', 'Ağ nərənin'], answer: 0
    },
    {
      topic: 'Azərbaycan təbiəti',
      q: 'Naxçıvanda yaşayan yabanı dağ qoçu növü hansıdır?',
      options: ['Muflon', 'Maral', 'Dağ keçisi', 'Qaban'], answer: 0
    }
  ];

  var index = 0;
  var score = 0;
  var locked = false;

  // Use the site i18n engine so every dynamically generated string follows
  // the active language just like the SSR-translated markup above.
  function qt(text) {
    if (window.SkyI18n && typeof window.SkyI18n.tr === 'function') {
      return window.SkyI18n.tr(text, undefined, 'az');
    }
    return text;
  }

  // Rotate the four options by question index so the right answer is not
  // always in the same place. data-option-index keeps the source position
  // available for the end-to-end checks.
  function optionShift() {
    return index % 4;
  }

  function renderQuestion() {
    var item = questions[index];
    var shift = optionShift();
    qNum.textContent = String(index + 1);
    qTotal.textContent = String(questions.length);
    progress.style.width = ((index + 1) / questions.length * 100) + '%';
    topicEl.textContent = qt(item.topic);
    questionEl.textContent = qt(item.q);
    optionsEl.innerHTML = '';
    for (var j = 0; j < item.options.length; j++) {
      var sourceIndex = (j + shift) % item.options.length;
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'quiz-option';
      btn.dataset.optionIndex = String(sourceIndex);
      btn.textContent = qt(item.options[sourceIndex]);
      btn.addEventListener('click', (function (displayIndex) {
        return function () { choose(displayIndex); };
      })(j));
      optionsEl.appendChild(btn);
    }
    feedback.hidden = true;
    answerWrap.hidden = true;
    nextBtn.hidden = true;
    locked = false;
  }

  function choose(i) {
    if (locked) return;
    locked = true;
    var item = questions[index];
    var correctDisplay = (item.answer - optionShift() + item.options.length) % item.options.length;
    var correct = i === correctDisplay;
    if (correct) {
      score += 4;
      feedbackTxt.textContent = qt('Doğru cavab!');
      answerWrap.hidden = true;
    } else {
      feedbackTxt.textContent = qt('Yanlış cavab.');
      answerEl.textContent = qt(item.options[item.answer]);
      answerWrap.hidden = false;
    }
    feedback.hidden = false;
    Array.prototype.forEach.call(optionsEl.children, function (btn, j) {
      btn.disabled = true;
      btn.classList.add(j === correctDisplay ? 'is-correct' : (j === i ? 'is-wrong' : 'is-muted'));
    });
    nextBtn.textContent = qt(index === questions.length - 1 ? 'Nəticəni gör' : 'Növbəti sual');
    nextBtn.hidden = false;
  }

  function showResult() {
    play.hidden = true;
    result.hidden = false;
    scoreEl.textContent = String(score);
    resultMsg.textContent = qt(score >= 80 ? 'Əla nəticə!' : (score >= 40 ? 'Yaxşı başlanğıc!' : 'Yenidən cəhd edin!'));
  }

  function reset() {
    index = 0;
    score = 0;
    locked = false;
    play.hidden = false;
    result.hidden = true;
    scoreEl.textContent = '0';
    renderQuestion();
  }

  function openQuiz() {
    reset();
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    closeBtn.focus();
  }

  function closeQuiz() {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  openBtn.addEventListener('click', openQuiz);
  closeBtn.addEventListener('click', closeQuiz);
  restartBtn.addEventListener('click', reset);
  nextBtn.addEventListener('click', function () {
    if (index === questions.length - 1) showResult();
    else { index += 1; renderQuestion(); }
  });
  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeQuiz(); });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeQuiz();
  });
})();
</script></body>
</html>
