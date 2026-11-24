<?php
/**
 * SKYWEB.AZ — Analitika Paneli
 * SMM & Data Analitika Dashboard
 */
require_once __DIR__ . '/../../config/config.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="<?= e(__('analytics_panel_desc', 'Skyweb.az Analitika Paneli — Reklam kampaniyalarınızın performansını izləyin, statistikaları təhlil edin.')) ?>">
  <title><?= e(__('analytics_panel_title', 'Analitika Paneli')) ?> — <?= SITE_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="<?= SITE_URL ?>/assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <style>
    /* ── Analitika Paneli Styles ── */
    .analytics-page { padding-top: 90px; min-height: 100vh; }

    /* Breadcrumb */
    .breadcrumb {
      display: flex; align-items: center; gap: 0.5rem;
      font-size: 0.82rem; color: var(--text-muted);
      margin-bottom: 2rem;
    }
    .breadcrumb a { color: var(--neon-cyan); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .breadcrumb-sep { color: var(--text-muted); opacity: 0.4; }

    /* Page Header */
    .analytics-header {
      display: flex; align-items: flex-start; justify-content: space-between;
      gap: 1.5rem; flex-wrap: wrap; margin-bottom: 2.5rem;
    }
    .analytics-header-left { flex: 1; min-width: 200px; }
    .analytics-header-badge {
      display: inline-flex; align-items: center; gap: 0.5rem;
      background: rgba(99,102,241,0.12); border: 1px solid rgba(99,102,241,0.3);
      color: #a5b4fc; border-radius: 999px;
      padding: 0.3rem 1rem; font-size: 0.78rem; font-weight: 600;
      margin-bottom: 0.75rem;
    }
    .analytics-header-badge::before { content: '●'; font-size: 0.6rem; color: #6366f1; }
    .analytics-title {
      font-size: clamp(1.6rem, 4vw, 2.4rem); font-weight: 800;
      line-height: 1.2; margin-bottom: 0.5rem;
    }
    .analytics-subtitle { color: var(--text-muted); font-size: 0.95rem; }

    /* Date Filter */
    .date-filter-group {
      display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;
    }
    .date-filter-btn {
      padding: 0.45rem 1rem; border-radius: var(--radius-sm);
      background: rgba(255,255,255,0.04); border: 1px solid var(--sky-border);
      color: var(--text-muted); font-size: 0.82rem; font-weight: 500;
      cursor: pointer; transition: var(--transition); white-space: nowrap;
    }
    .date-filter-btn:hover, .date-filter-btn.active {
      background: rgba(56,189,248,0.1); border-color: var(--neon-cyan);
      color: var(--neon-cyan);
    }
    .date-filter-btn.active { font-weight: 700; }

    /* KPI Cards */
    .kpi-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.25rem; margin-bottom: 2rem;
    }
    .kpi-card {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-md); padding: 1.25rem 1.5rem;
      position: relative; overflow: hidden; transition: var(--transition);
    }
    .kpi-card:hover { border-color: var(--sky-border-glow); transform: translateY(-3px); }
    .kpi-card::before {
      content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    }
    .kpi-card.kpi-cyan::before   { background: linear-gradient(90deg, var(--neon-cyan), transparent); }
    .kpi-card.kpi-purple::before { background: linear-gradient(90deg, var(--neon-purple), transparent); }
    .kpi-card.kpi-green::before  { background: linear-gradient(90deg, var(--neon-green), transparent); }
    .kpi-card.kpi-amber::before  { background: linear-gradient(90deg, var(--neon-amber), transparent); }
    .kpi-card.kpi-rose::before   { background: linear-gradient(90deg, var(--neon-rose), transparent); }

    .kpi-label { font-size: 0.78rem; color: var(--text-muted); font-weight: 500; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .kpi-value { font-size: 1.9rem; font-weight: 800; line-height: 1; margin-bottom: 0.35rem; }
    .kpi-card.kpi-cyan   .kpi-value { color: var(--neon-cyan); }
    .kpi-card.kpi-purple .kpi-value { color: #a5b4fc; }
    .kpi-card.kpi-green  .kpi-value { color: var(--neon-green); }
    .kpi-card.kpi-amber  .kpi-value { color: var(--neon-amber); }
    .kpi-card.kpi-rose   .kpi-value { color: var(--neon-rose); }
    .kpi-change {
      display: inline-flex; align-items: center; gap: 0.3rem;
      font-size: 0.8rem; font-weight: 600;
    }
    .kpi-change.up   { color: var(--neon-green); }
    .kpi-change.down { color: var(--neon-rose); }
    .kpi-icon {
      position: absolute; right: 1rem; top: 1rem;
      width: 40px; height: 40px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; opacity: 0.2;
    }

    /* Charts Grid */
    .charts-grid {
      display: grid; grid-template-columns: 2fr 1fr;
      gap: 1.25rem; margin-bottom: 2rem;
    }
    @media (max-width: 900px) { .charts-grid { grid-template-columns: 1fr; } }

    .chart-card {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-md); padding: 1.5rem;
    }
    .chart-card-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem;
    }
    .chart-card-title { font-size: 1rem; font-weight: 700; }
    .chart-card-meta { font-size: 0.78rem; color: var(--text-muted); }
    .chart-canvas-wrap { position: relative; }
    .chart-canvas-wrap canvas { max-height: 240px; }

    /* Platform Cards Grid */
    .platforms-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.25rem; margin-bottom: 2rem;
    }
    .platform-card {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-md); padding: 1.25rem 1.5rem;
      transition: var(--transition);
    }
    .platform-card:hover { border-color: var(--sky-border-glow); }
    .platform-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem; }
    .platform-icon {
      width: 40px; height: 40px; border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem; flex-shrink: 0;
    }
    .platform-icon.meta     { background: rgba(66,103,178,0.2); }
    .platform-icon.google   { background: rgba(234,67,53,0.2); }
    .platform-icon.tiktok   { background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.08); }
    .platform-name { font-weight: 700; font-size: 0.95rem; }
    .platform-status { font-size: 0.75rem; color: var(--neon-green); }

    .platform-metric-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 0.4rem 0; border-bottom: 1px solid rgba(255,255,255,0.04);
      font-size: 0.83rem;
    }
    .platform-metric-row:last-child { border-bottom: none; }
    .platform-metric-label { color: var(--text-muted); }
    .platform-metric-val { font-weight: 600; }

    .progress-bar-wrap { margin-top: 0.75rem; }
    .progress-label { display: flex; justify-content: space-between; font-size: 0.78rem; color: var(--text-muted); margin-bottom: 0.3rem; }
    .progress-bar { height: 5px; background: rgba(255,255,255,0.07); border-radius: 99px; overflow: hidden; }
    .progress-fill { height: 100%; border-radius: 99px; transition: width 1s ease; }

    /* Reports Section */
    .reports-section { margin-bottom: 2rem; }
    .section-label-sm {
      font-size: 0.78rem; font-weight: 700; color: var(--neon-cyan);
      text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1rem;
    }
    .reports-header {
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;
    }
    .reports-title { font-size: 1.15rem; font-weight: 700; }
    .search-filter-row { display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; }
    .search-input {
      padding: 0.5rem 1rem; background: rgba(255,255,255,0.04);
      border: 1px solid var(--sky-border); border-radius: var(--radius-sm);
      color: var(--text-primary); font-size: 0.85rem; outline: none;
      transition: var(--transition); font-family: var(--font-main); min-width: 200px;
    }
    .search-input:focus { border-color: var(--neon-cyan); background: rgba(56,189,248,0.05); }
    .search-input::placeholder { color: var(--text-muted); }
    .filter-select {
      padding: 0.5rem 1rem; background: rgba(255,255,255,0.04);
      border: 1px solid var(--sky-border); border-radius: var(--radius-sm);
      color: var(--text-primary); font-size: 0.85rem; outline: none;
      cursor: pointer; transition: var(--transition); font-family: var(--font-main);
    }
    .filter-select:focus { border-color: var(--neon-cyan); }
    .filter-select option { background: #0d1127; }

    .reports-table-wrap {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-md); overflow: hidden;
    }
    .reports-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    .reports-table th {
      padding: 0.9rem 1.25rem; text-align: left; font-size: 0.75rem;
      font-weight: 700; color: var(--text-muted); text-transform: uppercase;
      letter-spacing: 0.5px; background: rgba(255,255,255,0.02);
      border-bottom: 1px solid var(--sky-border);
    }
    .reports-table td {
      padding: 0.9rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.04);
      color: var(--text-secondary); vertical-align: middle;
    }
    .reports-table tr:last-child td { border-bottom: none; }
    .reports-table tr:hover td { background: rgba(56,189,248,0.04); }
    .report-name { font-weight: 600; color: var(--text-primary); }

    .status-badge {
      display: inline-block; padding: 0.2rem 0.7rem; border-radius: 999px;
      font-size: 0.72rem; font-weight: 700;
    }
    .status-badge.active  { background: rgba(16,185,129,0.15); color: var(--neon-green); }
    .status-badge.paused  { background: rgba(245,158,11,0.15); color: var(--neon-amber); }
    .status-badge.ended   { background: rgba(148,163,184,0.1); color: var(--text-muted); }

    .btn-sm {
      padding: 0.35rem 0.8rem; border-radius: 6px; font-size: 0.78rem;
      font-weight: 600; cursor: pointer; border: none; transition: var(--transition);
      text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;
    }
    .btn-sm-ghost {
      background: rgba(56,189,248,0.08); color: var(--neon-cyan);
      border: 1px solid rgba(56,189,248,0.25);
    }
    .btn-sm-ghost:hover { background: rgba(56,189,248,0.18); }

    /* Package CTA */
    .packages-section { margin-bottom: 3rem; }
    .packages-grid {
      display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 1.25rem;
    }
    .pkg-card {
      background: var(--sky-card); border: 1px solid var(--sky-border);
      border-radius: var(--radius-lg); padding: 2rem; position: relative;
      transition: var(--transition); overflow: hidden;
    }
    .pkg-card:hover { border-color: var(--sky-border-glow); transform: translateY(-4px); box-shadow: 0 20px 50px -15px rgba(96,200,245,0.15); }
    .pkg-card.featured {
      border-color: rgba(99,102,241,0.5);
      background: linear-gradient(135deg, rgba(99,102,241,0.08) 0%, rgba(13,17,39,0.9) 100%);
    }
    .pkg-popular {
      position: absolute; top: 1rem; right: 1rem;
      background: linear-gradient(135deg, #6366f1, #8b5cf6);
      color: #fff; font-size: 0.7rem; font-weight: 700;
      padding: 0.25rem 0.7rem; border-radius: 999px;
    }
    .pkg-name { font-size: 0.85rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem; }
    .pkg-price { font-size: 2.4rem; font-weight: 900; line-height: 1; margin-bottom: 0.25rem; }
    .pkg-price span { font-size: 1rem; font-weight: 500; color: var(--text-muted); }
    .pkg-desc { font-size: 0.83rem; color: var(--text-muted); margin-bottom: 1.5rem; }
    .pkg-features { list-style: none; margin-bottom: 1.75rem; }
    .pkg-features li {
      display: flex; align-items: flex-start; gap: 0.6rem;
      font-size: 0.85rem; padding: 0.35rem 0; color: var(--text-secondary);
    }
    .pkg-features li::before { content: '✓'; color: var(--neon-green); font-weight: 700; flex-shrink: 0; }
    .pkg-btn {
      display: block; width: 100%; padding: 0.85rem;
      text-align: center; border-radius: var(--radius-sm);
      font-weight: 700; font-size: 0.9rem; cursor: pointer;
      text-decoration: none; border: none; transition: var(--transition);
    }
    .pkg-btn-primary {
      background: linear-gradient(135deg, var(--neon-cyan), #6366f1); color: #fff;
    }
    .pkg-btn-primary:hover { box-shadow: 0 0 25px rgba(56,189,248,0.4); transform: translateY(-2px); }
    .pkg-btn-ghost {
      background: rgba(255,255,255,0.04); color: var(--text-primary);
      border: 1px solid var(--sky-border);
    }
    .pkg-btn-ghost:hover { background: rgba(255,255,255,0.08); border-color: var(--sky-border-glow); }

    /* Payment Modal */
    .pay-modal-overlay {
      position: fixed; inset: 0; background: rgba(0,0,0,0.8);
      backdrop-filter: blur(8px); z-index: 10000;
      display: flex; align-items: center; justify-content: center; padding: 1rem;
      opacity: 0; visibility: hidden; transition: var(--transition);
    }
    .pay-modal-overlay.open { opacity: 1; visibility: visible; }
    .pay-modal {
      background: #0d1127; border: 1px solid var(--sky-border);
      border-radius: var(--radius-xl); padding: 2.5rem;
      max-width: 480px; width: 100%; position: relative;
      transform: translateY(20px); transition: transform 0.3s ease;
    }
    .pay-modal-overlay.open .pay-modal { transform: translateY(0); }
    .pay-modal-close {
      position: absolute; top: 1rem; right: 1rem;
      background: rgba(255,255,255,0.06); border: 1px solid var(--sky-border);
      border-radius: 8px; width: 32px; height: 32px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; color: var(--text-muted); font-size: 1.1rem;
      transition: var(--transition);
    }
    .pay-modal-close:hover { background: rgba(244,63,94,0.15); color: var(--neon-rose); }
    .pay-modal-title { font-size: 1.3rem; font-weight: 800; margin-bottom: 0.4rem; }
    .pay-modal-pkg { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.5rem; }
    .pay-form-group { margin-bottom: 1rem; }
    .pay-form-label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 0.4rem; }
    .pay-form-input {
      width: 100%; padding: 0.75rem 1rem; background: rgba(255,255,255,0.04);
      border: 1px solid var(--sky-border); border-radius: var(--radius-sm);
      color: var(--text-primary); font-size: 0.9rem; outline: none;
      font-family: var(--font-main); transition: var(--transition);
    }
    .pay-form-input:focus { border-color: var(--neon-cyan); background: rgba(56,189,248,0.04); }
    .pay-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .pay-summary {
      background: rgba(56,189,248,0.06); border: 1px solid rgba(56,189,248,0.15);
      border-radius: var(--radius-sm); padding: 1rem; margin: 1.25rem 0;
    }
    .pay-summary-row { display: flex; justify-content: space-between; font-size: 0.85rem; padding: 0.2rem 0; }
    .pay-summary-row.total { font-weight: 700; font-size: 1rem; padding-top: 0.5rem; border-top: 1px solid rgba(255,255,255,0.08); margin-top: 0.3rem; }
    .pay-submit {
      width: 100%; padding: 1rem; border: none; cursor: pointer;
      background: linear-gradient(135deg, var(--neon-cyan), #6366f1);
      color: #fff; font-size: 0.95rem; font-weight: 700;
      border-radius: var(--radius-sm); transition: var(--transition);
    }
    .pay-submit:hover { box-shadow: 0 0 30px rgba(56,189,248,0.4); transform: translateY(-2px); }
    .pay-secure { text-align: center; font-size: 0.75rem; color: var(--text-muted); margin-top: 0.75rem; }

    /* Success Screen */
    .pay-success { text-align: center; display: none; }
    .pay-success-icon { font-size: 3.5rem; margin-bottom: 1rem; }
    .pay-success-title { font-size: 1.4rem; font-weight: 800; margin-bottom: 0.5rem; }
    .pay-success-msg { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem; }

    /* Responsive */
    @media (max-width: 768px) {
      .analytics-header { flex-direction: column; }
      .kpi-grid { grid-template-columns: 1fr 1fr; }
      .reports-table th:nth-child(3),
      .reports-table td:nth-child(3),
      .reports-table th:nth-child(5),
      .reports-table td:nth-child(5) { display: none; }
    }
    @media (max-width: 480px) {
      .kpi-grid { grid-template-columns: 1fr; }
      .pay-form-row { grid-template-columns: 1fr; }
    }
  </style>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<!-- Navbar -->
<nav id="main-navbar" class="navbar" role="navigation" aria-label="Əsas naviqasiya">
  <div class="container nav-inner">
    <?= render_language_switcher('module-lang-switch') ?>
    <a href="<?= SITE_URL ?>" class="logo" aria-label="Skyweb.az Ana Səhifə">
      <div class="logo-icon" aria-hidden="true">
        <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <linearGradient id="skySGrad" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" stop-color="#38bdf8"/>
              <stop offset="100%" stop-color="#0284c7"/>
            </linearGradient>
          </defs>
          <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGrad)"/>
        </svg>
      </div>
      <span class="logo-text"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
    </a>
    <a href="<?= SITE_URL ?>" style="color: var(--text-muted); text-decoration: none; font-size: 0.85rem; display: flex; align-items: center; gap: 0.4rem;">
      ← Ana səhifəyə qayıt
    </a>
  </div>
</nav>

<main class="analytics-page">
  <div class="container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Naviqasiya yolu">
      <a href="<?= SITE_URL ?>">Ana Səhifə</a>
      <span class="breadcrumb-sep">/</span>
      <span>Analitika Paneli</span>
    </nav>

    <!-- Page Header -->
    <div class="analytics-header">
      <div class="analytics-header-left">
        <div class="analytics-header-badge">SMM &amp; Data Analitika</div>
        <h1 class="analytics-title">
          Reklam <span class="gradient-text">Analitika</span> Paneli
        </h1>
        <p class="analytics-subtitle">Bütün kampaniyalarınızın performansını real vaxtda izləyin və optimallaşdırın.</p>
      </div>
      <div class="date-filter-group">
        <button class="date-filter-btn" onclick="setDateFilter(this, 7)">7 gün</button>
        <button class="date-filter-btn active" onclick="setDateFilter(this, 30)">30 gün</button>
        <button class="date-filter-btn" onclick="setDateFilter(this, 90)">3 ay</button>
        <button class="date-filter-btn" onclick="setDateFilter(this, 365)">1 il</button>
      </div>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid" id="kpi-grid">
      <div class="kpi-card kpi-cyan">
        <div class="kpi-icon">👁️</div>
        <div class="kpi-label">Ümumi Baxış</div>
        <div class="kpi-value" data-count="284500" data-suffix="">284,500</div>
        <div class="kpi-change up">↑ +18.4% keçən aya görə</div>
      </div>
      <div class="kpi-card kpi-purple">
        <div class="kpi-icon">🖱️</div>
        <div class="kpi-label">Klik Sayı</div>
        <div class="kpi-value" data-count="12840" data-suffix="">12,840</div>
        <div class="kpi-change up">↑ +9.2% keçən aya görə</div>
      </div>
      <div class="kpi-card kpi-green">
        <div class="kpi-icon">🎯</div>
        <div class="kpi-label">Dönüşüm Sayı</div>
        <div class="kpi-value" data-count="1247" data-suffix="">1,247</div>
        <div class="kpi-change up">↑ +23.1% keçən aya görə</div>
      </div>
      <div class="kpi-card kpi-amber">
        <div class="kpi-icon">💰</div>
        <div class="kpi-label">Reklam Xərci (AZN)</div>
        <div class="kpi-value" data-count="3840" data-suffix=" ₼">3,840 ₼</div>
        <div class="kpi-change down">↓ -5.3% keçən aya görə</div>
      </div>
      <div class="kpi-card kpi-rose">
        <div class="kpi-icon">📈</div>
        <div class="kpi-label">ROI</div>
        <div class="kpi-value" data-count="340" data-suffix="%">340%</div>
        <div class="kpi-change up">↑ +28.7% keçən aya görə</div>
      </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
      <div class="chart-card">
        <div class="chart-card-header">
          <div>
            <div class="chart-card-title">Günlük Performans Məlumatları</div>
            <div class="chart-card-meta">Son 30 gün — baxış, klik &amp; dönüşüm</div>
          </div>
        </div>
        <div class="chart-canvas-wrap">
          <canvas id="lineChart"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <div class="chart-card-header">
          <div>
            <div class="chart-card-title">Platform Paylanması</div>
            <div class="chart-card-meta">Xərclər üzrə</div>
          </div>
        </div>
        <div class="chart-canvas-wrap" style="display:flex;align-items:center;justify-content:center;">
          <canvas id="doughnutChart" style="max-height:220px;max-width:220px;"></canvas>
        </div>
      </div>
    </div>

    <!-- Second row of charts -->
    <div class="charts-grid" style="grid-template-columns: 1fr 1fr;">
      <div class="chart-card">
        <div class="chart-card-header">
          <div class="chart-card-title">Həftəlik Klik Analizi</div>
          <div class="chart-card-meta">Platform müqayisəsi</div>
        </div>
        <div class="chart-canvas-wrap">
          <canvas id="barChart"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <div class="chart-card-header">
          <div class="chart-card-title">Dönüşüm Funnel</div>
          <div class="chart-card-meta">Addım-addım analiz</div>
        </div>
        <div class="chart-canvas-wrap">
          <canvas id="funnelBar"></canvas>
        </div>
      </div>
    </div>

    <!-- Platform Breakdown -->
    <div class="section-label-sm">// Platform Statistikaları</div>
    <div class="platforms-grid">
      <div class="platform-card">
        <div class="platform-header">
          <div class="platform-icon meta">📘</div>
          <div>
            <div class="platform-name">Meta Ads (Facebook/Instagram)</div>
            <div class="platform-status">● Aktiv kampaniya</div>
          </div>
        </div>
        <div class="platform-metric-row"><span class="platform-metric-label">Baxış</span><span class="platform-metric-val">142,300</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Klik</span><span class="platform-metric-val">6,840</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">CTR</span><span class="platform-metric-val">4.8%</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Xərc</span><span class="platform-metric-val">1,920 ₼</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Qazanc</span><span class="platform-metric-val">8,640 ₼</span></div>
        <div class="progress-bar-wrap">
          <div class="progress-label"><span>Büdcə istifadəsi</span><span>75%</span></div>
          <div class="progress-bar"><div class="progress-fill" style="width:75%;background:linear-gradient(90deg,#4267B2,#6366f1);"></div></div>
        </div>
      </div>

      <div class="platform-card">
        <div class="platform-header">
          <div class="platform-icon google">🔴</div>
          <div>
            <div class="platform-name">Google Ads</div>
            <div class="platform-status">● Aktiv kampaniya</div>
          </div>
        </div>
        <div class="platform-metric-row"><span class="platform-metric-label">Baxış</span><span class="platform-metric-val">98,600</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Klik</span><span class="platform-metric-val">4,720</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">CTR</span><span class="platform-metric-val">4.8%</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Xərc</span><span class="platform-metric-val">1,440 ₼</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Qazanc</span><span class="platform-metric-val">6,120 ₼</span></div>
        <div class="progress-bar-wrap">
          <div class="progress-label"><span>Büdcə istifadəsi</span><span>60%</span></div>
          <div class="progress-bar"><div class="progress-fill" style="width:60%;background:linear-gradient(90deg,#EA4335,#FBBC05);"></div></div>
        </div>
      </div>

      <div class="platform-card">
        <div class="platform-header">
          <div class="platform-icon tiktok">🎵</div>
          <div>
            <div class="platform-name">TikTok Ads</div>
            <div class="platform-status" style="color:var(--neon-amber);">● Dayandırılıb</div>
          </div>
        </div>
        <div class="platform-metric-row"><span class="platform-metric-label">Baxış</span><span class="platform-metric-val">43,600</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Klik</span><span class="platform-metric-val">1,280</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">CTR</span><span class="platform-metric-val">2.9%</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Xərc</span><span class="platform-metric-val">480 ₼</span></div>
        <div class="platform-metric-row"><span class="platform-metric-label">Qazanc</span><span class="platform-metric-val">1,960 ₼</span></div>
        <div class="progress-bar-wrap">
          <div class="progress-label"><span>Büdcə istifadəsi</span><span>40%</span></div>
          <div class="progress-bar"><div class="progress-fill" style="width:40%;background:linear-gradient(90deg,#010101,#69C9D0);"></div></div>
        </div>
      </div>
    </div>

    <!-- Reports Table -->
    <div class="reports-section">
      <div class="reports-header">
        <div>
          <div class="section-label-sm">// Kampaniya Hesabatları</div>
          <div class="reports-title">Aktiv &amp; Keçmiş Kampaniyalar</div>
        </div>
        <div class="search-filter-row">
          <input type="text" class="search-input" id="reportSearch" placeholder="🔍 Kampaniya axtar..." oninput="filterReports(this.value)">
          <select class="filter-select" id="statusFilter" onchange="filterReports(document.getElementById('reportSearch').value)">
            <option value="">Bütün statuslar</option>
            <option value="Aktiv">Aktiv</option>
            <option value="Dayandırılıb">Dayandırılıb</option>
            <option value="Tamamlandı">Tamamlandı</option>
          </select>
        </div>
      </div>
      <div class="reports-table-wrap">
        <table class="reports-table" id="reportsTable">
          <thead>
            <tr>
              <th>Kampaniya Adı</th>
              <th>Platform</th>
              <th>Baxış</th>
              <th>Klik</th>
              <th>Xərc (AZN)</th>
              <th>ROI</th>
              <th>Status</th>
              <th>Əməliyyat</th>
            </tr>
          </thead>
          <tbody id="reportsBody">
            <tr data-name="Yay Endirimləri Kampaniyası" data-status="Aktiv">
              <td><span class="report-name">Yay Endirimləri Kampaniyası</span></td>
              <td>Meta Ads</td>
              <td>84,200</td>
              <td>3,840</td>
              <td>960 ₼</td>
              <td style="color:var(--neon-green)">+380%</td>
              <td><span class="status-badge active">Aktiv</span></td>
              <td><button class="btn-sm btn-sm-ghost">📊 Hesabat</button></td>
            </tr>
            <tr data-name="Yeni Məhsul Tanıtımı" data-status="Aktiv">
              <td><span class="report-name">Yeni Məhsul Tanıtımı</span></td>
              <td>Google Ads</td>
              <td>58,100</td>
              <td>2,640</td>
              <td>720 ₼</td>
              <td style="color:var(--neon-green)">+290%</td>
              <td><span class="status-badge active">Aktiv</span></td>
              <td><button class="btn-sm btn-sm-ghost">📊 Hesabat</button></td>
            </tr>
            <tr data-name="TikTok Gənclik Kampaniyası" data-status="Dayandırılıb">
              <td><span class="report-name">TikTok Gənclik Kampaniyası</span></td>
              <td>TikTok Ads</td>
              <td>43,600</td>
              <td>1,280</td>
              <td>480 ₼</td>
              <td style="color:var(--neon-amber)">+125%</td>
              <td><span class="status-badge paused">Dayandırılıb</span></td>
              <td><button class="btn-sm btn-sm-ghost">📊 Hesabat</button></td>
            </tr>
            <tr data-name="Bayram Xüsusi Təklif" data-status="Tamamlandı">
              <td><span class="report-name">Bayram Xüsusi Təklif</span></td>
              <td>Meta Ads</td>
              <td>112,400</td>
              <td>5,840</td>
              <td>1,440 ₼</td>
              <td style="color:var(--neon-green)">+442%</td>
              <td><span class="status-badge ended">Tamamlandı</span></td>
              <td><button class="btn-sm btn-sm-ghost">📊 Hesabat</button></td>
            </tr>
            <tr data-name="Brendinq Kampaniyası" data-status="Aktiv">
              <td><span class="report-name">Brendinq Kampaniyası</span></td>
              <td>Google Ads</td>
              <td>40,500</td>
              <td>2,080</td>
              <td>720 ₼</td>
              <td style="color:var(--neon-green)">+310%</td>
              <td><span class="status-badge active">Aktiv</span></td>
              <td><button class="btn-sm btn-sm-ghost">📊 Hesabat</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Packages -->
    <div class="packages-section">
      <div class="section-label-sm">// Xidmət Paketlər</div>
      <h2 style="font-size:1.4rem;font-weight:800;margin-bottom:0.5rem;">SMM &amp; Analitika Paketləri</h2>
      <p style="color:var(--text-muted);font-size:0.9rem;margin-bottom:1.5rem;">Biznesinizin ölçüsünə uyğun paket seçin. Bütün paketlər aylıq hesabat daxildir.</p>
      <div class="packages-grid">

        <div class="pkg-card">
          <div class="pkg-name">Başlanğıc</div>
          <div class="pkg-price">149 <span>AZN/ay</span></div>
          <div class="pkg-desc">Kiçik bizneslər &amp; startaplar üçün ideal</div>
          <ul class="pkg-features">
            <li>1 platforma (Meta və ya Google)</li>
            <li>Aylıq 500 AZN-ə qədər reklam büdcəsi</li>
            <li>Hər ay 1 kreativ material</li>
            <li>Aylıq performans hesabatı</li>
            <li>E-poçt dəstəyi</li>
          </ul>
          <button class="pkg-btn pkg-btn-ghost" onclick="openPayModal('Başlanğıc Paketi', 149)">Sifariş Ver</button>
        </div>

        <div class="pkg-card featured">
          <div class="pkg-popular">Ən Populyar</div>
          <div class="pkg-name">Peşəkar</div>
          <div class="pkg-price">349 <span>AZN/ay</span></div>
          <div class="pkg-desc">Orta ölçülü bizneslər üçün</div>
          <ul class="pkg-features">
            <li>2 platforma (Meta + Google)</li>
            <li>Aylıq 2000 AZN-ə qədər büdcə</li>
            <li>Həftəlik 2 kreativ material</li>
            <li>Həftəlik analitika hesabatı</li>
            <li>A/B test kampaniyaları</li>
            <li>Şəxsi hesab meneceri</li>
            <li>WhatsApp dəstəyi</li>
          </ul>
          <button class="pkg-btn pkg-btn-primary" onclick="openPayModal('Peşəkar Paketi', 349)">Sifariş Ver</button>
        </div>

        <div class="pkg-card">
          <div class="pkg-name">Korporativ</div>
          <div class="pkg-price">749 <span>AZN/ay</span></div>
          <div class="pkg-desc">Böyük bizneslər &amp; e-ticarət üçün</div>
          <ul class="pkg-features">
            <li>Bütün platformalar (Meta + Google + TikTok)</li>
            <li>Limitsiz reklam büdcəsi idarəetməsi</li>
            <li>Gündəlik kreativ məzmun</li>
            <li>Gündəlik analitika paneli</li>
            <li>İnfluencer marketinq dəstəyi</li>
            <li>Dedike hesab meneceri</li>
            <li>7/24 prioritet dəstək</li>
            <li>Hər ay stratejik görüş</li>
          </ul>
          <button class="pkg-btn pkg-btn-ghost" onclick="openPayModal('Korporativ Paketi', 749)">Sifariş Ver</button>
        </div>

      </div>
    </div>

  </div><!-- /container -->
</main>

<!-- Payment Modal -->
<div class="pay-modal-overlay" id="payModal" onclick="handleModalClick(event)">
  <div class="pay-modal" role="dialog" aria-modal="true" aria-labelledby="payModalTitle">
    <button class="pay-modal-close" onclick="closePayModal()" aria-label="Bağla">✕</button>

    <!-- Form -->
    <div id="payFormSection">
      <div class="pay-modal-title" id="payModalTitle">💳 Sifariş &amp; Ödəniş</div>
      <div class="pay-modal-pkg" id="payModalPkg">Paket: — | Məbləğ: — AZN/ay</div>

      <form id="payForm" onsubmit="submitPayment(event)">
        <div class="pay-form-group">
          <label class="pay-form-label" for="pay-name">Ad Soyad *</label>
          <input class="pay-form-input" id="pay-name" type="text" placeholder="Əli Həsənov" required>
        </div>
        <div class="pay-form-row">
          <div class="pay-form-group">
            <label class="pay-form-label" for="pay-phone">Telefon *</label>
            <input class="pay-form-input" id="pay-phone" type="tel" placeholder="+994 55 xxx xx xx" required>
          </div>
          <div class="pay-form-group">
            <label class="pay-form-label" for="pay-email">E-poçt *</label>
            <input class="pay-form-input" id="pay-email" type="email" placeholder="info@biznes.az" required>
          </div>
        </div>
        <div class="pay-form-group">
          <label class="pay-form-label" for="pay-company">Şirkət adı</label>
          <input class="pay-form-input" id="pay-company" type="text" placeholder="Şirkətinizin adı (istəyə bağlı)">
        </div>
        <div class="pay-form-group">
          <label class="pay-form-label" for="pay-note">Qeyd</label>
          <input class="pay-form-input" id="pay-note" type="text" placeholder="Əlavə istəklərinizi yazın...">
        </div>

        <div class="pay-summary" id="paySummary">
          <div class="pay-summary-row"><span>Paket:</span><span id="sumPkg">—</span></div>
          <div class="pay-summary-row"><span>Müddət:</span><span>Aylıq</span></div>
          <div class="pay-summary-row total"><span>Cəmi:</span><span id="sumTotal">— AZN</span></div>
        </div>

        <button type="submit" class="pay-submit">🔐 Sifarişi Təsdiqlə</button>
        <div class="pay-secure">🔒 Məlumatlarınız şifrələnmiş kanalda təhlükəsiz ötürülür</div>
      </form>
    </div>

    <!-- Success -->
    <div class="pay-success" id="paySuccess">
      <div class="pay-success-icon">🎉</div>
      <div class="pay-success-title">Sifarişiniz qəbul edildi!</div>
      <div class="pay-success-msg" id="paySuccessMsg">Tezliklə WhatsApp və ya e-poçt vasitəsilə sizinlə əlaqə saxlayacağıq.</div>
      <button class="pkg-btn pkg-btn-primary" onclick="closePayModal()" style="display:inline-block;width:auto;padding:0.75rem 2rem;">Bağla</button>
    </div>
  </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
<script>
// Date filter
function setDateFilter(btn, days) {
  document.querySelectorAll('.date-filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  // In production, this would fetch new data
  if (typeof skyToast === 'function') skyToast(days + ' günlük məlumatlar yükləndi', '📊', 2500);
}

// Reports filter
function filterReports(query) {
  const statusVal = document.getElementById('statusFilter').value;
  const rows = document.querySelectorAll('#reportsBody tr');
  rows.forEach(row => {
    const name   = (row.dataset.name   || '').toLowerCase();
    const status = (row.dataset.status || '');
    const matchQ = !query || name.includes(query.toLowerCase());
    const matchS = !statusVal || status === statusVal;
    row.style.display = (matchQ && matchS) ? '' : 'none';
  });
}

// Pay modal
let currentPkg = '', currentPrice = 0;
function openPayModal(pkg, price) {
  currentPkg = pkg; currentPrice = price;
  document.getElementById('payModalPkg').textContent = 'Paket: ' + pkg + ' | Məbləğ: ' + price + ' AZN/ay';
  document.getElementById('sumPkg').textContent = pkg;
  document.getElementById('sumTotal').textContent = price + ' AZN';
  document.getElementById('payFormSection').style.display = '';
  document.getElementById('paySuccess').style.display = 'none';
  document.getElementById('payForm').reset();
  document.getElementById('payModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closePayModal() {
  document.getElementById('payModal').classList.remove('open');
  document.body.style.overflow = '';
}
function handleModalClick(e) { if (e.target === document.getElementById('payModal')) closePayModal(); }
async function submitPayment(e) {
  e.preventDefault();
  const btn = e.target.querySelector('.pay-submit');
  const orig = btn.textContent;
  btn.textContent = 'Göndərilir...';
  btn.disabled = true;
  await new Promise(r => setTimeout(r, 1400));
  const name = document.getElementById('pay-name').value;
  document.getElementById('payFormSection').style.display = 'none';
  document.getElementById('paySuccess').style.display = '';
  document.getElementById('paySuccessMsg').textContent =
    name + ', sifarişiniz qəbul edildi! Tezliklə WhatsApp (+994 55 000 00 00) vasitəsilə sizinlə əlaqə saxlayacağıq.';
  btn.textContent = orig;
  btn.disabled = false;
}

// Charts
document.addEventListener('DOMContentLoaded', () => {
  Chart.defaults.color = '#94a3b8';
  Chart.defaults.borderColor = 'rgba(255,255,255,0.06)';

  const tr = (s) => (window.SkyI18n && window.SkyI18n.tr) ? window.SkyI18n.tr(s) : s;
  const rand = (min, max) => Math.floor(Math.random() * (max - min) + min);
  const labels30 = Array.from({length: 30}, (_, i) => {
    const d = new Date();
    d.setDate(d.getDate() - 29 + i);
    return d.getDate() + '/' + (d.getMonth() + 1);
  });

  // Data is generated once so switching language does not reshuffle the charts.
  const data = {
    lineViews: labels30.map(() => rand(60, 180)),
    lineClicks: labels30.map(() => rand(200, 600)),
    lineConversions: labels30.map(() => rand(10, 80)),
    barMeta: [820, 940, 780, 1100, 960, 1240, 1080],
    barGoogle: [640, 720, 680, 840, 760, 920, 800],
    barTikTok: [220, 180, 260, 200, 240, 180, 160],
    funnel: [284500, 12840, 4820, 2140, 1247]
  };

  let charts = [];
  function buildCharts() {
    charts.forEach((c) => c.destroy());
    charts = [];

    charts.push(new Chart(document.getElementById('lineChart'), {
      type: 'line',
      data: {
        labels: labels30,
        datasets: [
          { label: tr('Baxış (÷100)'), data: data.lineViews, borderColor: '#38bdf8', backgroundColor: 'rgba(56,189,248,0.08)', tension: 0.4, fill: true, pointRadius: 0 },
          { label: tr('Klik'), data: data.lineClicks, borderColor: '#a5b4fc', backgroundColor: 'rgba(165,180,252,0.05)', tension: 0.4, fill: false, pointRadius: 0 },
          { label: tr('Dönüşüm'), data: data.lineConversions, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.05)', tension: 0.4, fill: false, pointRadius: 0 }
        ]
      },
      options: { responsive: true, interaction: { intersect: false, mode: 'index' }, plugins: { legend: { position: 'top', labels: { boxWidth: 10, padding: 16 } } }, scales: { x: { grid: { display: false }, ticks: { maxRotation: 0, maxTicksLimit: 8 } }, y: { grid: { color: 'rgba(255,255,255,0.04)' } } } }
    }));

    charts.push(new Chart(document.getElementById('doughnutChart'), {
      type: 'doughnut',
      data: {
        labels: ['Meta Ads', 'Google Ads', 'TikTok Ads'],
        datasets: [{
          data: [1920, 1440, 480],
          backgroundColor: ['rgba(66,103,178,0.8)', 'rgba(234,67,53,0.8)', 'rgba(0,0,0,0.6)'],
          borderColor: ['#4267B2', '#EA4335', '#69C9D0'],
          borderWidth: 2
        }]
      },
      options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { padding: 16, boxWidth: 12 } } } }
    }));

    charts.push(new Chart(document.getElementById('barChart'), {
      type: 'bar',
      data: {
        labels: [tr('B.E.'), tr('Ç.A.'), tr('Ç.'), tr('C.A.'), tr('C.'), tr('Ş.'), tr('B.')],
        datasets: [
          { label: 'Meta', data: data.barMeta, backgroundColor: 'rgba(66,103,178,0.7)', borderRadius: 4 },
          { label: 'Google', data: data.barGoogle, backgroundColor: 'rgba(234,67,53,0.7)', borderRadius: 4 },
          { label: 'TikTok', data: data.barTikTok, backgroundColor: 'rgba(105,201,208,0.7)', borderRadius: 4 }
        ]
      },
      options: { responsive: true, plugins: { legend: { position: 'top', labels: { boxWidth: 10, padding: 12 } } }, scales: { x: { stacked: false, grid: { display: false } }, y: { grid: { color: 'rgba(255,255,255,0.04)' } } } }
    }));

    charts.push(new Chart(document.getElementById('funnelBar'), {
      type: 'bar',
      data: {
        labels: [tr('Baxış'), tr('Klik'), tr('Maraq'), tr('Əlaqə'), tr('Alış')],
        datasets: [{ label: tr('İstifadəçilər'), data: data.funnel, backgroundColor: ['rgba(56,189,248,0.7)', 'rgba(99,102,241,0.7)', 'rgba(139,92,246,0.7)', 'rgba(245,158,11,0.7)', 'rgba(16,185,129,0.7)'], borderRadius: 6, borderSkipped: false }]
      },
      options: { indexAxis: 'y', responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { color: 'rgba(255,255,255,0.04)' } }, y: { grid: { display: false } } } }
    }));
  }

  buildCharts();
  document.addEventListener('sky-lang-changed', buildCharts);});
</script>
</body>
</html>
