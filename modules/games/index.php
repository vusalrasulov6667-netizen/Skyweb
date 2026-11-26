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
          <span style="position:relative;z-index:2;">❓</span>
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
          <button class="game-demo-btn" type="button">Demo / Yeni Ön Baxış</button>
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

<script src="<?= SITE_URL ?>/assets/js/main.js"></script></body>
</html>
