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
  <meta name="description" content="<?= e(__('games_panel_desc', 'Skyweb.az — Biznesiniz üçün Fırlanan Çarx, Viktorina, Tapmaca kimi interaktiv mini oyunlar sifariş edin.')) ?>">
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

    /* Section Label */
    .section-label-sm { font-size:0.78rem;font-weight:700;color:var(--neon-green);text-transform:uppercase;letter-spacing:1px;margin-bottom:1rem; }

    /* Game Categories */
    .categories-tabs {
      display:flex;gap:0.5rem;flex-wrap:wrap;margin-bottom:2rem;
    }
    .cat-tab {
      display:flex;align-items:center;gap:0.5rem;
      padding:0.55rem 1.2rem;border-radius:999px;
      background:rgba(255,255,255,0.04);border:1px solid var(--sky-border);
      color:var(--text-muted);font-size:0.85rem;font-weight:500;
      cursor:pointer;transition:var(--transition);
    }
    .cat-tab:hover,.cat-tab.active {
      background:rgba(16,185,129,0.1);border-color:rgba(16,185,129,0.4);
      color:var(--neon-green);
    }
    .cat-tab.active { font-weight:700; }

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
    .badge-hot { background:rgba(244,63,94,0.9);color:#fff; }

    .game-card-body { padding:1.25rem 1.5rem 1.5rem; }
    .game-name { font-size:1.1rem;font-weight:800;margin-bottom:0.4rem; }
    .game-desc { font-size:0.84rem;color:var(--text-muted);line-height:1.6;margin-bottom:1rem; }
    .game-features { display:flex;flex-wrap:wrap;gap:0.4rem;margin-bottom:1.25rem; }
    .game-feat-tag {
      padding:0.2rem 0.6rem;border-radius:6px;font-size:0.72rem;font-weight:600;
      background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);color:var(--text-muted);
    }
    .game-price-row { display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap; }
    .game-price { font-size:1.4rem;font-weight:900; }
    .game-price-from { font-size:0.75rem;color:var(--text-muted);font-weight:500; }
    .game-order-btn {
      padding:0.6rem 1.4rem;border-radius:var(--radius-sm);
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      color:#fff;font-size:0.85rem;font-weight:700;
      border:none;cursor:pointer;transition:var(--transition);
    }
    .game-order-btn:hover { box-shadow:0 0 20px rgba(16,185,129,0.4);transform:translateY(-2px); }

    /* Order History */
    .history-section { margin-bottom:3rem; }
    .history-cards { display:flex;flex-direction:column;gap:0.75rem; }
    .history-card {
      background:var(--sky-card);border:1px solid var(--sky-border);
      border-radius:var(--radius-md);padding:1.1rem 1.5rem;
      display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;
      transition:var(--transition);
    }
    .history-card:hover { border-color:var(--sky-border-glow); }
    .history-icon { font-size:2rem;flex-shrink:0; }
    .history-info { flex:1;min-width:150px; }
    .history-name { font-weight:700;font-size:0.95rem;margin-bottom:0.2rem; }
    .history-meta { font-size:0.78rem;color:var(--text-muted); }
    .history-price { font-weight:800;font-size:1.1rem;color:var(--neon-green); }
    .history-status-badge {
      padding:0.25rem 0.8rem;border-radius:999px;font-size:0.72rem;font-weight:700;
    }
    .hs-delivered { background:rgba(16,185,129,0.15);color:var(--neon-green); }
    .hs-inprogress { background:rgba(99,102,241,0.15);color:#a5b4fc; }
    .hs-pending { background:rgba(245,158,11,0.15);color:var(--neon-amber); }

    /* Pay Modal */
    .pay-modal-overlay {
      position:fixed;inset:0;background:rgba(0,0,0,0.82);
      backdrop-filter:blur(8px);z-index:10000;
      display:flex;align-items:center;justify-content:center;padding:1rem;
      opacity:0;visibility:hidden;transition:var(--transition);
    }
    .pay-modal-overlay.open { opacity:1;visibility:visible; }
    .pay-modal {
      background:#0d1127;border:1px solid var(--sky-border);
      border-radius:var(--radius-xl);padding:2.5rem;
      max-width:500px;width:100%;position:relative;
      transform:translateY(20px);transition:transform 0.3s ease;max-height:90vh;overflow-y:auto;
    }
    .pay-modal-overlay.open .pay-modal { transform:translateY(0); }
    .pay-modal-close {
      position:absolute;top:1rem;right:1rem;
      background:rgba(255,255,255,0.06);border:1px solid var(--sky-border);
      border-radius:8px;width:32px;height:32px;
      display:flex;align-items:center;justify-content:center;
      cursor:pointer;color:var(--text-muted);font-size:1.1rem;transition:var(--transition);
    }
    .pay-modal-close:hover { background:rgba(244,63,94,0.15);color:var(--neon-rose); }
    .pay-modal-title { font-size:1.3rem;font-weight:800;margin-bottom:0.4rem; }
    .pay-modal-sub { font-size:0.85rem;color:var(--text-muted);margin-bottom:1.5rem; }
    .pay-form-group { margin-bottom:1rem; }
    .pay-form-label { display:block;font-size:0.82rem;font-weight:600;color:var(--text-secondary);margin-bottom:0.4rem; }
    .pay-form-input {
      width:100%;padding:0.75rem 1rem;background:rgba(255,255,255,0.04);
      border:1px solid var(--sky-border);border-radius:var(--radius-sm);
      color:var(--text-primary);font-size:0.9rem;outline:none;
      font-family:var(--font-main);transition:var(--transition);
    }
    .pay-form-input:focus { border-color:var(--neon-green);background:rgba(16,185,129,0.04); }
    .pay-form-row { display:grid;grid-template-columns:1fr 1fr;gap:1rem; }
    .pay-summary {
      background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.15);
      border-radius:var(--radius-sm);padding:1rem;margin:1.25rem 0;
    }
    .pay-summary-row { display:flex;justify-content:space-between;font-size:0.85rem;padding:0.2rem 0; }
    .pay-summary-row.total { font-weight:700;font-size:1rem;padding-top:0.5rem;border-top:1px solid rgba(255,255,255,0.08);margin-top:0.3rem; }
    .pay-submit {
      width:100%;padding:1rem;border:none;cursor:pointer;
      background:linear-gradient(135deg,var(--neon-green),#0d9488);
      color:#fff;font-size:0.95rem;font-weight:700;
      border-radius:var(--radius-sm);transition:var(--transition);
    }
    .pay-submit:hover { box-shadow:0 0 30px rgba(16,185,129,0.4);transform:translateY(-2px); }
    .pay-secure { text-align:center;font-size:0.75rem;color:var(--text-muted);margin-top:0.75rem; }
    .pay-success { text-align:center;display:none; }
    .pay-success-icon { font-size:3.5rem;margin-bottom:1rem; }
    .pay-success-title { font-size:1.4rem;font-weight:800;margin-bottom:0.5rem; }
    .pay-success-msg { color:var(--text-muted);font-size:0.9rem;margin-bottom:1.5rem; }

    @media(max-width:480px){ .pay-form-row { grid-template-columns:1fr; } }
  </style>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<nav id="main-navbar" class="navbar" role="navigation" aria-label="Əsas naviqasiya">
  <div class="container nav-inner">
    <?= render_language_switcher('module-lang-switch') ?>
    <a href="<?= SITE_URL ?>" class="logo" aria-label="Skyweb.az Ana Səhifə">
      <div class="logo-icon" aria-hidden="true">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs><linearGradient id="skySGrad" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#38bdf8"/><stop offset="100%" stop-color="#0284c7"/></linearGradient></defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGrad)"/>
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
          <a href="#game-categories" class="btn-ghost"><span>Oyunlara Bax</span></a>
        </div>
      </div>
      <div class="games-hero-right">
        <div class="hero-stat"><div class="hero-stat-val">120+</div><div class="hero-stat-label">Tamamlanan layihə</div></div>
        <div class="hero-stat"><div class="hero-stat-val">98%</div><div class="hero-stat-label">Müştəri məmnuniyyəti</div></div>
        <div class="hero-stat"><div class="hero-stat-val">3-7</div><div class="hero-stat-label">Günlük çatdırılma</div></div>
      </div>
    </div>

    <!-- Category Tabs -->
    <div id="game-categories">
      <div class="section-label-sm">// Oyun Kateqoriyaları</div>
      <div class="categories-tabs" id="catTabs">
        <button class="cat-tab active" onclick="filterGames(this,'all')">🎲 Hamısı</button>
        <button class="cat-tab" onclick="filterGames(this,'carx')">🎡 Çarx Oyunları</button>
        <button class="cat-tab" onclick="filterGames(this,'quiz')">❓ Viktorina</button>
        <button class="cat-tab" onclick="filterGames(this,'puzzle')">🧩 Tapmacalar</button>
        <button class="cat-tab" onclick="filterGames(this,'other')">⚡ Digər</button>
      </div>
    </div>

    <!-- Game Cards -->
    <div class="games-grid" id="gamesGrid">

      <div class="game-card" data-cat="carx">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(16,185,129,0.15),rgba(6,182,212,0.1));">
          <span style="position:relative;z-index:2;">🎡</span>
          <div class="game-badge badge-popular">Populyar</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Fırlanan Çarx</div>
          <div class="game-desc">Müştərilər çarxı fırladır, endirim kodu, hədiyyə və ya xüsusi təklif qazanır. Sayta trafiği artırır, müştərini geri qaytarır.</div>
          <div class="game-features">
            <span class="game-feat-tag">Web &amp; Wap</span>
            <span class="game-feat-tag">Brend uyğunluğu</span>
            <span class="game-feat-tag">CRM inteqrasiyası</span>
            <span class="game-feat-tag">QR kod</span>
          </div>
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:var(--neon-green)">180 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Fırlanan Çarx',180)">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="carx">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(16,185,129,0.12),rgba(245,158,11,0.08));">
          <span style="position:relative;z-index:2;">🎪</span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">3D Şans Çarxı</div>
          <div class="game-desc">Klassik fırlanan çarxın müasir 3D animasiyalı versiyası. Daha cəlbedici vizual effektlər ilə müştəri diqqətini cəlb edin.</div>
          <div class="game-features">
            <span class="game-feat-tag">3D Animasiya</span>
            <span class="game-feat-tag">Sosial paylaşım</span>
            <span class="game-feat-tag">Real vaxt statistika</span>
          </div>
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:var(--neon-green)">280 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('3D Şans Çarxı',280)">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="quiz">
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
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:#a5b4fc)">220 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Brend Viktorinası',220)" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="quiz">
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
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:#a5b4fc">340 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Canlı Viktorina Müsabiqəsi',340)" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="puzzle">
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
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:var(--neon-cyan)">160 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Brend Tapmacaları',160)" style="background:linear-gradient(135deg,#38bdf8,#6366f1);">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="other">
        <div class="game-card-preview" style="background:linear-gradient(135deg,rgba(244,63,94,0.12),rgba(139,92,246,0.08));">
          <span style="position:relative;z-index:2;">🃏</span>
          <div class="game-badge badge-new">Yeni</div>
        </div>
        <div class="game-card-body">
          <div class="game-name">Uğur Kartı Oyunu</div>
          <div class="game-desc">Müştərilər kart çevirir, gizli mükafat qazanır. E-ticarət saytları üçün alış-verişdən sonra müştəri məmnuniyyətini artırır.</div>
          <div class="game-features">
            <span class="game-feat-tag">E-ticarət uyumlu</span>
            <span class="game-feat-tag">E-poçt inteqrasiyası</span>
            <span class="game-feat-tag">Özelləşdirilə bilər</span>
          </div>
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:var(--neon-rose)">200 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Uğur Kartı Oyunu',200)" style="background:linear-gradient(135deg,#f43f5e,#8b5cf6);">Sifariş Et</button>
          </div>
        </div>
      </div>

      <div class="game-card" data-cat="other">
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
          <div class="game-price-row">
            <div><div class="game-price-from">Başlayan qiymət</div><div class="game-price" style="color:var(--neon-cyan)">320 ₼</div></div>
            <button class="game-order-btn" onclick="openPayModal('Brend İdman Oyunu',320)" style="background:linear-gradient(135deg,#38bdf8,#10b981);">Sifariş Et</button>
          </div>
        </div>
      </div>

    </div><!-- /games-grid -->

    <!-- Order History -->
    <div class="history-section">
      <div class="section-label-sm">// Son Sifarişlər</div>
      <h2 style="font-size:1.2rem;font-weight:800;margin-bottom:1.25rem;">Sifariş Tarixçəsi</h2>
      <div class="history-cards">
        <div class="history-card">
          <div class="history-icon">🎡</div>
          <div class="history-info">
            <div class="history-name">Fırlanan Çarx — "TechStore" üçün</div>
            <div class="history-meta">Sifariş tarixi: 5 İyun 2026 · Sifariş #SKY-2847</div>
          </div>
          <div class="history-price">180 ₼</div>
          <span class="history-status-badge hs-delivered">✓ Çatdırıldı</span>
        </div>
        <div class="history-card">
          <div class="history-icon">❓</div>
          <div class="history-info">
            <div class="history-name">Brend Viktorinası — "AzurMart" üçün</div>
            <div class="history-meta">Sifariş tarixi: 10 İyun 2026 · Sifariş #SKY-2863</div>
          </div>
          <div class="history-price">220 ₼</div>
          <span class="history-status-badge hs-inprogress">⚙ Hazırlanır</span>
        </div>
      </div>
    </div>

  </div>
</main>

<!-- Payment Modal -->
<div class="pay-modal-overlay" id="payModal" onclick="handleModalClick(event)">
  <div class="pay-modal" role="dialog" aria-modal="true">
    <button class="pay-modal-close" onclick="closePayModal()">✕</button>
    <div id="payFormSection">
      <div class="pay-modal-title">🎮 Oyun Sifarişi &amp; Ödəniş</div>
      <div class="pay-modal-sub" id="payModalSub">Seçdiyiniz oyun: —</div>
      <div class="pay-form-group">
        <label class="pay-form-label" for="pf-name">Ad Soyad *</label>
        <input class="pay-form-input" id="pf-name" type="text" placeholder="Əli Həsənov" required>
      </div>
      <div class="pay-form-row">
        <div class="pay-form-group">
          <label class="pay-form-label" for="pf-phone">Telefon *</label>
          <input class="pay-form-input" id="pf-phone" type="tel" placeholder="+994 55 xxx xx xx">
        </div>
        <div class="pay-form-group">
          <label class="pay-form-label" for="pf-email">E-poçt *</label>
          <input class="pay-form-input" id="pf-email" type="email" placeholder="info@biznes.az">
        </div>
      </div>
      <div class="pay-form-group">
        <label class="pay-form-label" for="pf-note">Qeyd</label>
        <input class="pay-form-input" id="pf-note" type="text" placeholder="Xüsusi istəkləriniz...">
      </div>
      <div class="pay-summary">
        <div class="pay-summary-row"><span>Oyun:</span><span id="psum-game">—</span></div>
        <div class="pay-summary-row"><span>Növ:</span><span>Bir dəfəlik ödəniş</span></div>
        <div class="pay-summary-row total"><span>Cəmi:</span><span id="psum-total">— AZN</span></div>
      </div>
      <button class="pay-submit" onclick="submitGamePay(event)">🔐 Sifarişi Təsdiqlə</button>
      <div class="pay-secure">🔒 Məlumatlarınız şifrələnmiş kanalda təhlükəsiz ötürülür</div>
    </div>
    <div class="pay-success" id="paySuccess">
      <div class="pay-success-icon">🎉</div>
      <div class="pay-success-title">Sifarişiniz qəbul edildi!</div>
      <div class="pay-success-msg" id="paySuccessMsg">Tezliklə sizinlə əlaqə saxlayacağıq.</div>
      <button onclick="closePayModal()" style="padding:0.75rem 2rem;background:linear-gradient(135deg,var(--neon-green),#0d9488);color:#fff;border:none;border-radius:var(--radius-sm);font-weight:700;cursor:pointer;">Bağla</button>
    </div>
  </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>
// Game filter
function filterGames(btn, cat) {
  document.querySelectorAll('.cat-tab').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#gamesGrid .game-card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.cat === cat) ? '' : 'none';
  });
}

// Pay modal
let _payGame='', _payPrice=0;
function openPayModal(game, price) {
  _payGame=game; _payPrice=price;
  document.getElementById('payModalSub').textContent = 'Seçdiyiniz oyun: '+game+' — '+price+' AZN';
  document.getElementById('psum-game').textContent = game;
  document.getElementById('psum-total').textContent = price+' AZN';
  document.getElementById('payFormSection').style.display='';
  document.getElementById('paySuccess').style.display='none';
  document.getElementById('payModal').classList.add('open');
  document.body.style.overflow='hidden';
}
function closePayModal() {
  document.getElementById('payModal').classList.remove('open');
  document.body.style.overflow='';
}
function handleModalClick(e) { if(e.target===document.getElementById('payModal')) closePayModal(); }
async function submitGamePay(e) {
  e.preventDefault();
  const btn=e.target; btn.textContent='Göndərilir...'; btn.disabled=true;
  await new Promise(r=>setTimeout(r,1300));
  const name=document.getElementById('pf-name').value||'Hörmətli müştəri';
  document.getElementById('payFormSection').style.display='none';
  document.getElementById('paySuccess').style.display='';
  document.getElementById('paySuccessMsg').textContent=name+', '+_payGame+' sifarişiniz qəbul edildi! Tezliklə WhatsApp (+994 55 000 00 00) vasitəsilə sizinlə əlaqə saxlayacağıq.';
  btn.textContent='🔐 Sifarişi Təsdiqlə'; btn.disabled=false;
}

</script>
</body>
</html>
