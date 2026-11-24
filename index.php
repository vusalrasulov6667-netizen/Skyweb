<?php
/**
 * SKYWEB.AZ — Ana Səhifə (Landing Page)
 * Premium Dark Cyber-Sky UI | Responsive | Azərbaycanca
 */
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });



function render_avatar(?string $avatar_url, string $name): string {
    $initials = mb_strtoupper(mb_substr($name, 0, 2, 'UTF-8'), 'UTF-8');
    
    if (empty($avatar_url)) {
        return '<div class="avatar-initials">' . e($initials) . '</div>';
    }
    
    if (strpos($avatar_url, 'preset:') === 0) {
        $preset = substr($avatar_url, 7);
        
        switch ($preset) {
            case 'avatar1':
            case 'avatar2':
                return '<div class="avatar-preset"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="preset-svg"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div>';
            case 'avatar3':
                return '<div class="avatar-preset robot-preset"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="preset-svg"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M12 2v2"></path><path d="M12 8v3"></path><path d="M8 5h8"></path><circle cx="9" cy="15" r="1"></circle><circle cx="15" cy="15" r="1"></circle></svg></div>';
            case 'avatar4':
                return '<div class="avatar-preset company-preset"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="preset-svg"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg></div>';
            default:
                return '<div class="avatar-initials">' . e($initials) . '</div>';
        }
    }
    
    return '<div class="avatar-img-box"><img src="' . e($avatar_url) . '" alt="' . e($name) . '" class="avatar-img"></div>';
}

/**
 * ─────────────────────────────────────────────────────────────
 *  WEB DEMO PORTFOLIO — single source of truth
 *  Used by the "Layihələrimiz / Websites" showcase section.
 *  Add / edit demos here; the section renders automatically.
 * ─────────────────────────────────────────────────────────────
 */
$SKY_WEB_DEMOS = [
    [
        'slug'   => 'clothing',
        'file'   => 'demo-clothing.php',
        'cats'   => ['ecommerce'],
        'icon'   => '👗',
        'accent' => '#ec4899',
        'img'    => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=900&q=80',
        'title'  => ['demo_title_clothing', 'Aura Moda — Geyim Butiki'],
        'badge'  => ['demo_badge_clothing', 'E-Ticarət / Geyim'],
        'desc'   => ['demo_desc_clothing', 'Geyim butikləri üçün səbət idarəetməsi, ölçü seçimi (S/M/L), endirim kuponu və WhatsApp ilə 1 kliklə sürətli sifariş axını.'],
        'result' => ['demo_result_clothing', 'Səbət → WhatsApp sifarişi: 1 klik'],
    ],
    [
        'slug'   => 'food',
        'file'   => 'demo-food.php',
        'cats'   => ['food'],
        'icon'   => '🍔',
        'accent' => '#f97316',
        'img'    => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=900&q=80',
        'title'  => ['demo_title_food', 'LəzzətExpress — Restoran & Çatdırılma'],
        'badge'  => ['demo_badge_food', 'Restoran & Qida'],
        'desc'   => ['demo_desc_food', 'Elektron menyu, canlı çatdırılma zonası kalkulyatoru, kombo təkliflər və anında WhatsApp vasitəsilə sifariş qəbulu.'],
        'result' => ['demo_result_food', 'Çatdırılma zonası: avtomatik hesablama'],
    ],
    [
        'slug'   => 'whatsapp',
        'file'   => 'demo-whatsapp.php',
        'cats'   => ['ecommerce'],
        'icon'   => '💬',
        'accent' => '#22c55e',
        'img'    => 'https://images.unsplash.com/photo-1611746872915-64382b5c76da?w=900&q=80',
        'title'  => ['demo_title_whatsapp', 'ChatSatış — WhatsApp Satış Kataloqu'],
        'badge'  => ['demo_badge_whatsapp', 'WhatsApp Ticarət'],
        'desc'   => ['demo_desc_whatsapp', 'Instagram və kiçik bizneslər üçün müştərinin seçdiyi məhsulları avtomatik WhatsApp sifariş mesajına çevirən platforma.'],
        'result' => ['demo_result_whatsapp', 'Sifariş mesajı: avtomatik formalaşır'],
    ],
    [
        'slug'   => 'pharmacy',
        'file'   => 'demo-pharmacy.php',
        'cats'   => ['health'],
        'icon'   => '💊',
        'accent' => '#38bdf8',
        'img'    => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?w=900&q=80',
        'title'  => ['demo_title_pharmacy', 'Şəfa Aptek — Onlayn Aptek & Tibb'],
        'badge'  => ['demo_badge_pharmacy', 'Aptek & Tibb'],
        'desc'   => ['demo_desc_pharmacy', 'Həkimin əl xətti reseptlərini tanıyan AI OCR skaneri, redaktə edilə bilən resept mətni, canlı anbar yoxlanışı və əczaçı təsdiqi.'],
        'result' => ['demo_result_pharmacy', 'Resept skanı: 3 saniyə'],
    ],
    [
        'slug'   => 'beauty',
        'file'   => 'demo-beauty.php',
        'cats'   => ['lifestyle'],
        'icon'   => '✂️',
        'accent' => '#f472b6',
        'img'    => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=900&q=80',
        'title'  => ['demo_title_beauty', 'Élégance — Gözəllik & Qadın Salonu'],
        'badge'  => ['demo_badge_beauty', 'Gözəllik Salonu'],
        'desc'   => ['demo_desc_beauty', 'Canlı onlayn növbə qeydiyyatı, usta və xidmət seçimi, interaktiv Əvvəl/Sonra slayderi və müvəqqəti foto önbaxış paneli.'],
        'result' => ['demo_result_beauty', 'Onlayn növbə: 24/7 açıq'],
    ],
    [
        'slug'   => 'fitness',
        'file'   => 'demo-fitness.php',
        'cats'   => ['lifestyle'],
        'icon'   => '🏋️',
        'accent' => '#c084fc',
        'img'    => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=900&q=80',
        'title'  => ['demo_title_fitness', 'APEXFIT — Fitnes & İdman Zalı'],
        'badge'  => ['demo_badge_fitness', 'İdman & Fitnes'],
        'desc'   => ['demo_desc_fitness', 'Gündəlik dərslər cədvəli filtri, interaktiv məşq video icmalları, məşqçi rezervasiyası və illik endirimli abunəlik kalkulyatoru.'],
        'result' => ['demo_result_fitness', 'Abunəlik: illik −25%'],
    ],
    [
        'slug'   => 'education',
        'file'   => 'demo-education.php',
        'cats'   => ['edu'],
        'icon'   => '🎓',
        'accent' => '#818cf8',
        'img'    => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=900&q=80',
        'title'  => ['demo_title_education', 'EduVerse — Təhsil & Kurs Mərkəzi'],
        'badge'  => ['demo_badge_education', 'Təhsil & Karyera'],
        'desc'   => ['demo_desc_education', 'Kurslar kataloqu, hər ixtisasa uyğun canlı video dərs pleyeri, modul sillabusları, mentor reytinqi və qeydiyyat axını.'],
        'result' => ['demo_result_education', 'Video dərs: birbaşa brauzerdə'],
    ],
    [
        'slug'   => 'video',
        'file'   => 'demo-video.php',
        'cats'   => ['edu'],
        'icon'   => '🎬',
        'accent' => '#00e5ff',
        'img'    => 'https://images.unsplash.com/photo-1574717024653-61fd2cf4d44d?w=900&q=80',
        'title'  => ['demo_title_video', 'CineSky — Video Prodakşn Studiyası'],
        'badge'  => ['demo_badge_video', 'Video Prodakşn'],
        'desc'   => ['demo_desc_video', '4K reklam filmləri, dron aerofotoqrafiyası və sosial media (Reels) üçün canlı video pleyerli şouril və büdcə kalkulyatoru.'],
        'result' => ['demo_result_video', '4K şouril: canlı pleyer'],
    ],
    [
        'slug'   => 'cafe',
        'file'   => 'demo-cafe.php',
        'cats'   => ['food'],
        'icon'   => '☕',
        'accent' => '#f59e0b',
        'img'    => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=900&q=80',
        'title'  => ['demo_title_cafe', 'Velvet Brew — Kafe & Qəhvəxana'],
        'badge'  => ['demo_badge_cafe', 'Kafe & Qəhvəxana'],
        'desc'   => ['demo_desc_cafe', 'İnteraktiv fincan ölçüsü seçimi (S/M/L), təzə desertlər və 6-cı fincanı hədiyyə edən rəqəmsal loyallıq ştamp kartı sistemi.'],
        'result' => ['demo_result_cafe', 'Loyallıq: 6-cı fincan hədiyyə'],
    ],
    [
        'slug'   => 'realestate',
        'file'   => 'demo-realestate.php',
        'cats'   => ['property'],
        'icon'   => '🏡',
        'accent' => '#06b6d4',
        'img'    => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=900&q=80',
        'title'  => ['demo_title_realestate', 'SkyVilla — Daşınmaz Əmlak Agentliyi'],
        'badge'  => ['demo_badge_realestate', 'Daşınmaz Əmlak'],
        'desc'   => ['demo_desc_realestate', 'Çoxkriteriyalı canlı axtarış filtri, otaq xüsusiyyətləri, interaktiv 360° virtual tur modalı və qiymətləndirmə sorğusu.'],
        'result' => ['demo_result_realestate', '360° virtual tur: bir kliklə'],
    ],
    [
        'slug'   => 'grocery',
        'file'   => 'demo-grocery.php',
        'cats'   => ['ecommerce'],
        'icon'   => '🍏',
        'accent' => '#10b981',
        'img'    => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=900&q=80',
        'title'  => ['demo_title_grocery', 'Yaşıl Bazar — Onlayn Supermarket'],
        'badge'  => ['demo_badge_grocery', 'Supermarket & Qida'],
        'desc'   => ['demo_desc_grocery', 'Meyvə-tərəvəz və orqanik məhsullar, canlı flash-deals geri sayım taymeri, sürətli kuryer zonaları və keşbek kartı.'],
        'result' => ['demo_result_grocery', 'Flash deal: canlı geri sayım'],
    ],
];

?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="description" content="<?= e(__('site_meta_desc', 'Skyweb.az — Biznes tətbiqləri, ağıllı CV hazırlama, mini oyunlar və SMM xidmətləri. Azərbaycanın yeni nəsil rəqəmsal ekosistemi.')) ?>">
  <meta name="keywords" content="biznes tətbiq, CV hazırla, skyweb, SMM, mini oyunlar">
  <meta property="og:title" content="<?= e(__('site_title', 'Skyweb.az — Rəqəmsal Gələcəyin Ekosistemi')) ?>">
  <meta property="og:description" content="<?= e(__('site_meta_desc', 'Freelance, biznes həlləri, ağıllı CV, mini oyunlar — hamısı bir platformada.')) ?>">
  <meta property="og:type" content="website">
  
  <!-- PWA & Mobil Tənzimləmələr -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#080a1c">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/uploads/1b7acda823126b63d3350ccc5fe1bfe3.png">
  
  <title><?= e(__('site_title', 'Skyweb.az — Rəqəmsal Gələcəyin Ekosistemi')) ?></title>

  <!-- Preconnect -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="assets/js/sky-i18n.js?v=<?= time() ?>"></script>

  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body>

<!-- Animated Canvas Background -->
<canvas id="sky-canvas" aria-hidden="true"></canvas>

<!-- ════════════════════════════════════════════════════════════
     NAVBAR
════════════════════════════════════════════════════════════ -->
<header>
  <nav id="main-navbar" class="navbar" role="navigation" aria-label="<?= e(__('aria_main_nav', 'Əsas naviqasiya')) ?>">
    <div class="container nav-inner">

      <!-- Logo -->
      <a href="<?= SITE_URL ?>" class="logo" id="logo-link" aria-label="<?= e(__('aria_logo_home', 'Skyweb.az Ana Səhifə')) ?>">
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

      <!-- Desktop Text Slider Flow -->
      <div class="skyweb-slider-flow" aria-hidden="true">
        <div class="skyweb-slider-track">
          <span class="skyweb-slider-text">
            <span class="highlight">Skyweb</span> <?= e(__('slider_text', 'ilə rəqəmsal dünyaya uçuş başlayır!')) ?> &nbsp;✦&nbsp;
            <span class="highlight">Skyweb</span> <?= e(__('slider_text', 'ilə rəqəmsal dünyaya uçuş başlayır!')) ?> &nbsp;✦&nbsp;
            <span class="highlight">Skyweb</span> <?= e(__('slider_text', 'ilə rəqəmsal dünyaya uçuş başlayır!')) ?> &nbsp;✦&nbsp;
            <span class="highlight">Skyweb</span> <?= e(__('slider_text', 'ilə rəqəmsal dünyaya uçuş başlayır!')) ?> &nbsp;✦&nbsp;
          </span>
        </div>
      </div>

      <!-- Desktop Actions -->
      <div class="nav-actions">
        <?php if (isLoggedIn()): ?>
          <?php $user = currentUser(); ?>
          <span class="user-greeting" style="font-size: 0.85rem; font-weight:600; color: var(--text-secondary); display:flex; align-items:center; gap:0.5rem; margin-right: 0.25rem;">
            <?= render_avatar($user['avatar_url'] ?? '', $user['fullname'] ?? 'User') ?>
            <span class="user-fullname" style="max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= e($user['fullname']) ?></span>
          </span>
          <a href="auth/logout.php" class="btn-login-nav" style="border-color: rgba(239,68,68,0.25); color: #fca5a5; background: rgba(239, 68, 68, 0.08);">
            <span><?= __('nav_logout', 'Çıxış') ?></span>
          </a>
        <?php else: ?>
          <a href="auth/login.php" class="btn-login-nav" id="btn-login">
            <span><?= __('nav_login', 'Daxil ol') ?></span>
          </a>
          <a href="auth/register.php" class="btn-register-nav">
            <span><?= __('nav_register', 'Qeydiyyat') ?></span>
          </a>
        <?php endif; ?>

        <!-- Language Selector Dropdown (Top-Right) -->
        <?= render_language_switcher() ?>
      </div>

      <!-- Hamburger -->
      <button class="hamburger" id="hamburger" aria-label="<?= e(__('aria_menu_toggle', 'Menyu aç/bağla')) ?>" aria-expanded="false" aria-controls="mobile-nav">
        <span></span><span></span><span></span>
      </button>

    </div>
  </nav>

  <!-- Mobile Nav -->
  <div id="mobile-nav" class="mobile-nav" role="navigation" aria-label="<?= e(__('aria_mobile_nav', 'Mobil naviqasiya')) ?>">

    <a href="#business"  id="mob-business">  <?= __('nav_business', '🏢 Biznes & İaşə Həlləri') ?></a>
    <a href="#marketing" id="mob-marketing"> <?= __('nav_marketing', '📊 SMM & Data Analitika') ?></a>
    <a href="#games"     id="mob-games">     <?= __('nav_games', '🎮 Mini Oyunlar (Gamification)') ?></a>
    <a href="#cv-builder"id="mob-cv">        <?= __('nav_cv', '📄 Ağıllı CV Hazırlama') ?></a>
    <a href="#services"  id="mob-projects" onclick="if(typeof openWebServicesModal==='function'){openWebServicesModal();return false;}">  <?= __('nav_projects', '🎨 Layihələrimiz') ?></a>
    
    <!-- Mobile Language Selector -->
    <?= render_mobile_language_selector() ?>

    <?php if (isLoggedIn()): ?>
      <?php $user = currentUser(); ?>
      <div style="padding: 1rem; border-top: 1px solid var(--sky-border); margin-top: 0.5rem; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;">
        <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem;">
          <?= render_avatar($user['avatar_url'] ?? '', $user['fullname'] ?? 'User') ?>
          <?= e($user['fullname']) ?>
        </span>
        <a href="auth/logout.php" style="border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; background: rgba(239, 68, 68, 0.1); padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; text-decoration: none; display: flex; align-items: center;"><?= __('nav_logout', 'Çıxış') ?></a>
      </div>
    <?php else: ?>
      <div style="padding: 1rem; border-top: 1px solid var(--sky-border); margin-top: 0.5rem; display: flex; gap: 0.5rem;">
        <a href="auth/login.php" style="flex: 1; text-align: center; border: 1px solid var(--sky-border); background: rgba(255,255,255,0.02); padding: 0.6rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; text-decoration: none; color: var(--text-primary); display: block;"><?= __('nav_login', 'Daxil ol') ?></a>
        <a href="auth/register.php" style="flex: 1; text-align: center; background: linear-gradient(135deg, var(--neon-cyan), #6366f1); padding: 0.6rem; border-radius: var(--radius-sm); font-size: 0.85rem; font-weight: 600; text-decoration: none; color: #fff; display: block;"><?= __('nav_register', 'Qeydiyyat') ?></a>
      </div>
    <?php endif; ?>
  </div>
</header>

<main>

<!-- ════════════════════════════════════════════════════════════
     HERO SECTION
════════════════════════════════════════════════════════════ -->
<section id="home" class="board-section">
  <!-- Background glows -->
  <div class="hero-bg-glow hero-bg-glow-1" aria-hidden="true"></div>
  <div class="hero-bg-glow hero-bg-glow-2" aria-hidden="true"></div>

  <div class="container" style="position:relative; z-index:2; width:100%; max-width:1440px;">
    
    <style>
      /* ── Hero Master Layout (2027 Cyber-Sky Architecture) ── */
      .hero-layout-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.75rem;
        margin-top: clamp(2.5rem, 5vw, 4.25rem);
        width: 100%;
        max-width: 1380px;
        margin-left: auto;
        margin-right: auto;
        box-sizing: border-box;
        position: relative;
        z-index: 2;
      }
      .hero-layout-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        text-align: center;
        margin-bottom: 0.25rem;
      }

      /* ── Hero Main Row (Sky 1 Left & Sky 2/3 Right) ── */
      .hero-main-row {
        display: grid;
        grid-template-columns: minmax(0, 1.48fr) minmax(320px, 380px);
        gap: 1.5rem;
        align-items: stretch;
        width: 100%;
        box-sizing: border-box;
      }

      /* ── Sky 1: Services Showcase Card (Matches Sky 2 & 3 Visual Style) ── */
      .sky-services-card {
        position: relative;
        background: linear-gradient(160deg, rgba(6, 32, 42, 0.95) 0%, rgba(2, 17, 24, 0.98) 100%);
        border: 1px solid rgba(0, 229, 255, 0.28);
        border-radius: var(--radius-md);
        box-shadow: 0 12px 35px rgba(0, 10, 15, 0.6), 0 0 25px rgba(0, 229, 255, 0.08);
        padding: 1.35rem 1.6rem;
        display: flex;
        flex-direction: column;
        gap: 1.15rem;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
      }
      .sky-services-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 55%, #c084fc 100%);
        box-shadow: 0 0 14px rgba(0, 240, 255, 0.85);
      }
      .sky-services-card:hover {
        border-color: rgba(0, 240, 255, 0.45);
        box-shadow: 0 16px 45px rgba(0, 8, 12, 0.8), 0 0 35px rgba(0, 229, 255, 0.18);
      }

      /* Sky 1 Header */
      .sky-svc-head {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
      }
      .sky-svc-head-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
      }
      .sky-svc-title {
        font-size: clamp(1.05rem, 2vw, 1.25rem);
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1.25;
        margin: 0;
        letter-spacing: -0.01em;
      }
      .sky-svc-title .gtext {
        background: linear-gradient(90deg, #38bdf8, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }
      .sky-svc-desc {
        font-size: 0.8rem;
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
      }

      /* ── Orderly Sequence Navigation (Clean Sequence, No Sliding/Carousel) ── */
      .sky-svc-seq-nav {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        background: rgba(0, 10, 18, 0.6);
        border: 1px solid rgba(0, 229, 255, 0.14);
        border-radius: 12px;
        padding: 5px;
        box-sizing: border-box;
      }
      .sky-seq-btn {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.6rem 0.65rem;
        background: transparent;
        border: 1px solid transparent;
        border-radius: 9px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: left;
        font-family: inherit;
        -webkit-tap-highlight-color: transparent;
        user-select: none;
        outline: none;
        min-width: 0;
      }
      .sky-seq-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--text-muted);
        flex-shrink: 0;
        transition: all 0.25s ease;
      }
      .sky-seq-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        flex-shrink: 0;
        transition: all 0.25s ease;
      }
      .sky-seq-icon svg {
        width: 15px;
        height: 15px;
        stroke: var(--text-secondary);
        transition: stroke 0.25s ease;
      }
      .sky-seq-text {
        display: flex;
        flex-direction: column;
        min-width: 0;
        overflow: hidden;
      }
      .sky-seq-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--text-secondary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        transition: color 0.25s ease;
      }
      .sky-seq-sub {
        font-size: 0.65rem;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .sky-seq-btn:hover {
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-primary);
        border-color: rgba(255, 255, 255, 0.1);
      }
      .sky-seq-btn:hover .sky-seq-icon svg {
        stroke: #fff;
      }
      /* Active sequence item */
      .sky-seq-btn.active {
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.12) 0%, rgba(129, 140, 248, 0.08) 100%);
        border-color: rgba(0, 229, 255, 0.4);
        box-shadow: 0 4px 15px rgba(0, 229, 255, 0.15);
      }
      .sky-seq-btn.active .sky-seq-num {
        background: rgba(0, 229, 255, 0.2);
        border-color: rgba(0, 229, 255, 0.5);
        color: #00f0ff;
      }
      .sky-seq-btn.active .sky-seq-icon {
        background: rgba(0, 229, 255, 0.18);
        border-color: rgba(0, 229, 255, 0.5);
      }
      .sky-seq-btn.active .sky-seq-icon svg {
        stroke: #00f0ff;
        filter: drop-shadow(0 0 5px rgba(0, 240, 255, 0.6));
      }
      .sky-seq-btn.active .sky-seq-name {
        color: #ffffff;
      }
      .sky-seq-btn.active .sky-seq-sub {
        color: #38bdf8;
      }

      /* ── Sky 1 Service Detail Stage ── */
      .sky-svc-stage {
        position: relative;
        min-height: 220px;
        border-radius: 14px;
        background: rgba(0, 15, 26, 0.45);
        border: 1px solid rgba(0, 229, 255, 0.12);
        padding: 1.15rem 1.25rem;
        box-sizing: border-box;
      }
      .sky-svc-panel {
        display: none;
        width: 100%;
      }
      .sky-svc-panel.active {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(0, 1fr);
        gap: 1.25rem;
        align-items: center;
        animation: skyPanelFade 0.32s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      }
      @keyframes skyPanelFade {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
      }

      /* Panel Info Column */
      .sky-svc-info {
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
      }
      .sky-svc-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        width: fit-content;
      }
      .sky-badge-cyan {
        background: rgba(0, 229, 255, 0.1);
        border: 1px solid rgba(0, 229, 255, 0.35);
        color: #00f0ff;
      }
      .sky-badge-purple {
        background: rgba(129, 140, 248, 0.1);
        border: 1px solid rgba(129, 140, 248, 0.35);
        color: #a5b4fc;
      }
      .sky-badge-green {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.35);
        color: #34d399;
      }
      .sky-badge-pink {
        background: rgba(236, 72, 153, 0.1);
        border: 1px solid rgba(236, 72, 153, 0.35);
        color: #f472b6;
      }

      .sky-svc-panel-title {
        font-size: 1.15rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
        line-height: 1.2;
      }
      .sky-svc-panel-desc {
        font-size: 0.81rem;
        color: rgba(200, 225, 245, 0.88);
        line-height: 1.6;
        margin: 0;
      }
      .sky-svc-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
        margin-top: 0.15rem;
      }
      .sky-svc-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.71rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.09);
        color: var(--text-secondary);
        transition: all 0.2s ease;
      }
      .sky-svc-chip.active-chip {
        background: rgba(0, 229, 255, 0.08);
        border-color: rgba(0, 229, 255, 0.28);
        color: #d8f4fa;
      }
      .sky-svc-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #00e5ff;
        background: rgba(0, 229, 255, 0.06);
        border: 1px solid rgba(0, 229, 255, 0.45);
        border-radius: 9px;
        padding: 0.45rem 1rem;
        text-decoration: none;
        width: fit-content;
        box-shadow: 0 0 15px rgba(0, 229, 255, 0.12);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        margin-top: 0.25rem;
      }
      .sky-svc-action-btn:hover {
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.25), rgba(129, 140, 248, 0.2));
        border-color: #00f0ff;
        color: #ffffff;
        box-shadow: 0 0 25px rgba(0, 229, 255, 0.4);
        transform: translateY(-2px);
      }

      /* ── 2027 Futuristic Animation Stage Widgets ── */
      .sky-hud-stage {
        position: relative;
        width: 100%;
        height: 180px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.03) 0%, rgba(3, 15, 28, 0.85) 100%);
        border: 1px solid rgba(0, 229, 255, 0.16);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: inset 0 0 30px rgba(0, 229, 255, 0.04);
      }
      /* Laser scanline sweep */
      .sky-hud-stage::after {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(0, 240, 255, 0.75) 50%, transparent 100%);
        box-shadow: 0 0 10px rgba(0, 240, 255, 0.8);
        animation: cyberScanSweep 3.6s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        pointer-events: none;
        z-index: 5;
      }
      @keyframes cyberScanSweep {
        0% { transform: translateY(-10px); opacity: 0; }
        20% { opacity: 0.9; }
        80% { opacity: 0.9; }
        100% { transform: translateY(190px); opacity: 0; }
      }

      /* 2027 Keyframe Animations */
      @keyframes cyberDeviceFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(0.4deg); }
      }
      @keyframes cyberPhoneFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(5px) rotate(-0.8deg); }
      }
      @keyframes cyberWaveFlow {
        0% { stroke-dashoffset: 300; }
        100% { stroke-dashoffset: 0; }
      }
      @keyframes cyberBeaconPulse {
        0% { transform: scale(0.85); opacity: 1; }
        50% { transform: scale(1.35); opacity: 0.35; filter: drop-shadow(0 0 10px #818cf8); }
        100% { transform: scale(0.85); opacity: 1; }
      }
      @keyframes cyberCoin3D {
        0% { transform: rotateY(0deg) translateY(0px); }
        50% { transform: rotateY(180deg) translateY(-6px); filter: drop-shadow(0 10px 18px rgba(16, 185, 129, 0.5)); }
        100% { transform: rotateY(360deg) translateY(0px); }
      }
      @keyframes cyberGamepadPulse {
        0%, 100% { transform: scale(1) translateY(0); filter: drop-shadow(0 4px 12px rgba(16, 185, 129, 0.3)); }
        50% { transform: scale(1.04) translateY(-4px); filter: drop-shadow(0 10px 22px rgba(16, 185, 129, 0.6)); }
      }
      @keyframes cyberCartFloat {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-5px) rotate(-1deg); filter: drop-shadow(0 8px 18px rgba(236, 72, 153, 0.45)); }
      }
      @keyframes cyberCheckBadge {
        0%, 100% { transform: scale(1); opacity: 0.95; }
        50% { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 12px #ec4899); }
      }

      /* Floating Metric HUD Pills */
      .hud-metric-pill {
        position: absolute;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: rgba(3, 20, 32, 0.88);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 229, 255, 0.35);
        border-radius: 20px;
        padding: 0.22rem 0.55rem;
        font-size: 0.68rem;
        font-weight: 700;
        color: #d8f4fa;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.5);
        z-index: 4;
        white-space: nowrap;
      }

      /* ── Side Cards Stack (Sky 2 & Sky 3) ── */
      .hero-side-cards-stack {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        height: 100%;
      }
      .sky-side-card {
        width: 100%;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid var(--sky-border);
        border-radius: var(--radius-md);
        padding: 1.05rem 1.25rem;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
      }
      .sky-side-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: transparent;
        transition: all 0.3s ease;
      }
      .sky-side-card.sky-side-services {
        background: linear-gradient(160deg, rgba(6, 32, 42, 0.95) 0%, rgba(2, 17, 24, 0.98) 100%);
        border: 1px solid rgba(0, 229, 255, 0.28);
        box-shadow: 0 12px 35px rgba(0, 10, 15, 0.6), 0 0 25px rgba(0, 229, 255, 0.08);
        flex: 1;
        cursor: pointer;
      }
      .sky-side-card.sky-side-services::before {
        background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 55%, #c084fc 100%);
        box-shadow: 0 0 14px rgba(0, 240, 255, 0.85);
      }
      .sky-side-card.sky-side-projects {
        background: linear-gradient(160deg, rgba(16, 10, 32, 0.95) 0%, rgba(8, 4, 18, 0.98) 100%);
        border: 1px solid rgba(168, 85, 247, 0.28);
        box-shadow: 0 12px 35px rgba(0, 10, 15, 0.6), 0 0 25px rgba(168, 85, 247, 0.08);
        flex: 1;
        cursor: pointer;
      }
      .sky-side-card.sky-side-projects::before {
        background: linear-gradient(90deg, #a855f7 0%, #c084fc 100%);
        box-shadow: 0 0 10px #c084fc;
      }
      .sky-side-card:hover {
        transform: translateY(-3px);
      }
      .sky-side-card.sky-side-services:hover {
        background: linear-gradient(160deg, rgba(8, 42, 54, 0.98) 0%, rgba(3, 22, 30, 0.99) 100%);
        border-color: rgba(0, 240, 255, 0.55);
        box-shadow: 0 16px 45px rgba(0, 8, 12, 0.8), 0 0 35px rgba(0, 229, 255, 0.25);
      }
      .sky-side-card.sky-side-projects:hover {
        border-color: rgba(168, 85, 247, 0.45);
        box-shadow: 0 16px 45px rgba(0, 8, 12, 0.8), 0 0 35px rgba(168, 85, 247, 0.22);
      }

      /* ── Requirement 4: CV & Autobiography Services (Balanced Horizontal Row) ── */
      .hero-cv-autobio-row {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1.5rem;
        width: 100%;
        align-items: stretch;
        box-sizing: border-box;
      }
      .sky-cv-card {
        background: linear-gradient(160deg, rgba(6, 32, 42, 0.95) 0%, rgba(2, 17, 24, 0.98) 100%);
        border: 1px solid rgba(0, 229, 255, 0.28);
        box-shadow: 0 12px 35px rgba(0, 10, 15, 0.6), 0 0 25px rgba(0, 229, 255, 0.08);
        border-radius: var(--radius-md);
        padding: 1.25rem 1.4rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
      }
      .sky-cv-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 100%);
        box-shadow: 0 0 12px rgba(0, 240, 255, 0.8);
      }
      .sky-cv-card:hover {
        border-color: rgba(0, 240, 255, 0.5);
        box-shadow: 0 16px 40px rgba(0, 8, 12, 0.8), 0 0 30px rgba(0, 229, 255, 0.22);
        transform: translateY(-3px);
      }
      .sky-autobio-card {
        background: linear-gradient(160deg, rgba(16, 10, 32, 0.95) 0%, rgba(8, 4, 18, 0.98) 100%);
        border: 1px solid rgba(168, 85, 247, 0.28);
        box-shadow: 0 12px 35px rgba(0, 10, 15, 0.6), 0 0 25px rgba(168, 85, 247, 0.08);
        border-radius: var(--radius-md);
        padding: 1.25rem 1.4rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-sizing: border-box;
      }
      .sky-autobio-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 3px;
        background: linear-gradient(90deg, #a855f7 0%, #c084fc 100%);
        box-shadow: 0 0 12px rgba(168, 85, 247, 0.8);
      }
      .sky-autobio-card:hover {
        border-color: rgba(168, 85, 247, 0.5);
        box-shadow: 0 16px 40px rgba(0, 8, 12, 0.8), 0 0 30px rgba(168, 85, 247, 0.22);
        transform: translateY(-3px);
      }

      /* Card Internal Top & Bottom Containers */
      .cv-card-top {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
      }
      .cv-card-bottom {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 1rem;
        padding-top: 0.65rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
      }

      /* Icons inside cards */
      .cv-hero-widget-head {
        display: flex;
        align-items: center;
        gap: 0.75rem;
      }
      .cv-hero-icon, .autobio-hero-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px; height: 42px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        flex-shrink: 0;
      }
      .sky-cv-icon-wrap {
        background: rgba(0, 229, 255, 0.08);
        border-color: rgba(0, 229, 255, 0.32);
      }
      .sky-cv-icon-wrap svg {
        stroke: #00e5ff;
        width: 20px; height: 20px;
      }
      .sky-autobio-icon-wrap {
        background: rgba(168, 85, 247, 0.08);
        border-color: rgba(168, 85, 247, 0.32);
      }
      .sky-autobio-icon-wrap svg {
        stroke: #c084fc;
        width: 20px; height: 20px;
      }
      .sky-side-card:hover .cv-hero-icon {
        transform: scale(1.08) rotate(-3deg);
      }
      .sky-side-card.sky-side-services:hover .cv-hero-icon {
        border-color: #00e5ff;
        background: rgba(0, 229, 255, 0.18);
        box-shadow: 0 0 15px rgba(0, 229, 255, 0.35);
      }
      .sky-side-card.sky-side-projects:hover .cv-hero-icon {
        border-color: #c084fc;
        background: rgba(168, 85, 247, 0.18);
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.35);
      }
      .sky-cv-card:hover .sky-cv-icon-wrap {
        border-color: #00e5ff;
        background: rgba(0, 229, 255, 0.18);
        box-shadow: 0 0 15px rgba(0, 229, 255, 0.35);
      }
      .sky-autobio-card:hover .sky-autobio-icon-wrap {
        border-color: #c084fc;
        background: rgba(168, 85, 247, 0.18);
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.35);
      }

      /* Card Typography */
      .cv-hero-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.2;
        letter-spacing: -0.01em;
      }
      .cv-hero-sub {
        font-size: 0.78rem;
        font-weight: 600;
        margin-top: 2px;
      }
      .cv-hero-desc {
        font-size: 0.79rem;
        color: rgba(185, 215, 235, 0.88);
        line-height: 1.55;
        margin: 0.2rem 0;
      }
      .cv-hero-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.35rem;
      }
      .cv-hero-chip {
        font-size: 0.73rem;
        font-weight: 500;
        padding: 0.25rem 0.65rem;
        border-radius: 14px;
        background: rgba(8, 38, 48, 0.75);
        border: 1px solid rgba(0, 229, 255, 0.2);
        color: #d8f4fa;
      }
      .cv-hero-chip.purple-chip {
        background: rgba(28, 12, 48, 0.75);
        border: 1px solid rgba(168, 85, 247, 0.25);
        color: #e9d5ff;
      }

      /* Card Buttons */
      .cv-hero-btn, .autobio-hero-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.8rem;
        font-weight: 700;
        border-radius: 9px;
        padding: 0.45rem 1rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        width: fit-content;
        outline: none;
        border: 1px solid transparent;
        font-family: inherit;
      }
      .sky-cv-card .cv-hero-btn {
        background: rgba(0, 229, 255, 0.08);
        border-color: rgba(0, 229, 255, 0.45);
        color: #00e5ff;
        box-shadow: 0 0 15px rgba(0, 229, 255, 0.12);
      }
      .sky-cv-card:hover .cv-hero-btn {
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.25), rgba(56, 189, 248, 0.3));
        border-color: #00f0ff;
        color: #ffffff;
        box-shadow: 0 0 25px rgba(0, 229, 255, 0.4);
        transform: translateY(-2px);
      }
      .sky-autobio-card .autobio-hero-btn {
        background: rgba(168, 85, 247, 0.1);
        border-color: rgba(168, 85, 247, 0.45);
        color: #c084fc;
        box-shadow: 0 0 15px rgba(168, 85, 247, 0.12);
      }
      .sky-autobio-card:hover .autobio-hero-btn {
        background: linear-gradient(135deg, rgba(168, 85, 247, 0.25), rgba(192, 132, 252, 0.3));
        border-color: #c084fc;
        color: #ffffff;
        box-shadow: 0 0 25px rgba(168, 85, 247, 0.4);
        transform: translateY(-2px);
      }

      /* ── Info Popup Button ── */
      .hsvc-info-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1.5px solid rgba(56,189,248,0.45);
        background: rgba(56,189,248,0.08);
        cursor: pointer;
        color: #38bdf8;
        font-size: 12px;
        font-weight: 700;
        font-style: italic;
        font-family: Georgia, serif;
        transition: background 0.2s, transform 0.2s;
        flex-shrink: 0;
        outline: none;
      }
      .hsvc-info-btn:hover {
        background: rgba(56,189,248,0.25);
        transform: scale(1.1);
      }

      /* ── Cross-Platform & Responsive Rules (Zero Overflow, Perfect Alignment) ── */
      @media (max-width: 1100px) {
        .hero-main-row {
          grid-template-columns: 1fr;
          gap: 1.25rem;
        }
        .hero-side-cards-stack {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 1rem;
        }
      }
      @media (max-width: 860px) {
        .sky-svc-seq-nav {
          grid-template-columns: repeat(2, 1fr);
        }
        .sky-svc-panel.active {
          grid-template-columns: 1fr;
          gap: 1rem;
        }
        .hero-side-cards-stack {
          grid-template-columns: 1fr;
        }
        .hero-cv-autobio-row {
          grid-template-columns: 1fr;
          gap: 1rem;
        }
      }
      @media (max-width: 480px) {
        .hero-layout-wrapper {
          margin-top: 1.75rem;
          gap: 1.25rem;
        }
        .sky-services-card {
          padding: 1rem 1.1rem;
        }
        .sky-svc-seq-nav {
          grid-template-columns: 1fr;
        }
        .sky-side-card {
          padding: 0.9rem 1rem;
        }
        .sky-hud-stage {
          height: 160px;
        }
        .cv-hero-title {
          font-size: 0.96rem;
        }
        .cv-hero-desc {
          font-size: 0.76rem;
        }
      }

      /* ── Web Services Showcase Modal ── */
      .sky-demos-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 5, 12, 0.88);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        overscroll-behavior: contain;
      }
      .sky-demos-modal-overlay.active {
        opacity: 1;
        visibility: visible;
      }
      .sky-demos-modal {
        background: linear-gradient(170deg, #021620 0%, #03212c 50%, #010f16 100%);
        border: 1px solid rgba(0, 229, 255, 0.3);
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 45px rgba(0, 229, 255, 0.18);
        border-radius: 20px;
        width: 100%;
        max-width: 1320px;
        max-height: 92vh;
        max-height: 92dvh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transform: scale(0.96) translateY(12px);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        box-sizing: border-box;
      }
      .sky-demos-modal::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 50%, #c084fc 100%);
        box-shadow: 0 0 16px rgba(0, 240, 255, 0.8);
        z-index: 10;
      }
      .sky-demos-modal-overlay.active .sky-demos-modal {
        transform: scale(1) translateY(0);
      }
      .sky-demos-header {
        padding: 1.25rem 1.75rem 0.95rem;
        background: rgba(1, 18, 26, 0.9);
        border-bottom: 1px solid rgba(0, 229, 255, 0.14);
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        position: relative;
        flex-shrink: 0;
      }
      .sky-demos-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #fff;
        margin: 0.15rem 0 0.3rem 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.6rem;
      }
      .sky-demos-desc {
        font-size: 0.86rem;
        color: var(--text-secondary);
        margin: 0;
        line-height: 1.45;
      }
      .sky-demos-close {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(0, 229, 255, 0.25);
        color: var(--text-muted);
        font-size: 1.4rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
      }
      .sky-demos-close:hover {
        background: rgba(239, 68, 68, 0.25);
        border-color: rgba(239, 68, 68, 0.5);
        color: #fca5a5;
        transform: rotate(90deg);
      }
      .sky-demos-filters {
        padding: 0.85rem 1.75rem;
        background: rgba(1, 14, 20, 0.95);
        border-bottom: 1px solid rgba(0, 229, 255, 0.14);
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem 0.6rem;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
        flex-shrink: 0;
        overflow-x: auto;
        overflow-y: visible;
        scrollbar-width: thin;
        scrollbar-color: rgba(0, 229, 255, 0.3) transparent;
      }
      .sky-demo-filter-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.46rem 0.95rem;
        border-radius: 20px;
        background: rgba(3, 34, 43, 0.8);
        border: 1px solid rgba(0, 229, 255, 0.22);
        color: var(--text-muted);
        font-size: 0.81rem;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        flex-shrink: 0;
        line-height: 1.25;
        transition: all 0.2s ease;
        user-select: none;
        min-width: 0;
      }
      .sky-demo-filter-btn:hover {
        color: #fff;
        border-color: rgba(0, 229, 255, 0.55);
        background: rgba(0, 229, 255, 0.14);
      }
      .sky-demo-filter-btn.active {
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.28), rgba(192, 132, 252, 0.22));
        border-color: var(--neon-cyan);
        color: #fff;
        box-shadow: 0 0 16px rgba(0, 229, 255, 0.38);
      }
      .sky-demos-body {
        padding: 1.4rem 1.75rem;
        overflow-y: auto;
        overflow-x: hidden;
        flex: 1;
        min-height: 0;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
        grid-auto-rows: max-content;
        align-content: start;
        gap: 1.25rem;
        box-sizing: border-box;
        overscroll-behavior: contain;
      }
      .sky-demo-item {
        background: linear-gradient(165deg, rgba(4, 30, 39, 0.95) 0%, rgba(2, 17, 23, 0.98) 100%);
        border: 1px solid rgba(0, 229, 255, 0.22);
        border-radius: 16px;
        padding: 0;
        display: flex;
        flex-direction: column;
        height: auto;
        min-height: 0;
        min-width: 0;
        width: 100%;
        box-sizing: border-box;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        flex: 0 0 auto;
      }

      .sky-demo-item::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 2px;
        background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 50%, #c084fc 100%);
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 5;
      }
      .sky-demo-item:hover {
        background: linear-gradient(165deg, rgba(6, 40, 52, 0.98) 0%, rgba(3, 22, 30, 0.99) 100%);
        border-color: rgba(0, 229, 255, 0.55);
        transform: translateY(-4px);
        box-shadow: 0 16px 35px rgba(0, 0, 0, 0.6), 0 0 25px rgba(0, 229, 255, 0.2);
      }
      .sky-demo-item:hover::before {
        opacity: 1;
      }
      .sky-demo-media {
        position: relative;
        height: 135px;
        background: linear-gradient(135deg, rgba(3, 25, 34, 0.95) 0%, rgba(6, 42, 54, 0.9) 100%);
        overflow: hidden;
        flex-shrink: 0;
        width: 100%;
        box-sizing: border-box;
      }
      .sky-demo-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
        filter: brightness(0.85);
      }
      .sky-demo-item:hover .sky-demo-media img {
        transform: scale(1.06);
        filter: brightness(0.95);
      }
      .sky-demo-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(2, 18, 25, 0.95) 0%, transparent 60%);
        pointer-events: none;
      }
      .sky-demo-media-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 0.25rem 0.65rem;
        border-radius: 20px;
        background: rgba(1, 20, 27, 0.88);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(0, 229, 255, 0.35);
        color: var(--neon-cyan);
        z-index: 2;
      }
      .sky-demo-live {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.64rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #d1fae5;
        background: rgba(1, 20, 27, 0.88);
        border: 1px solid rgba(16, 185, 129, 0.45);
        border-radius: 20px;
        padding: 0.22rem 0.55rem;
        backdrop-filter: blur(6px);
      }
      .sky-demo-live i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #34d399;
      }
      .sky-demo-media-icon {
        position: absolute;
        bottom: 10px;
        left: 14px;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(1, 22, 30, 0.9);
        border: 1px solid rgba(0, 229, 255, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.5);
        z-index: 2;
      }
      .sky-demo-content {
        padding: 1.1rem 1.25rem 1.25rem;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 0.65rem;
        min-width: 0;
        width: 100%;
        box-sizing: border-box;
      }
      .sky-demo-name {
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1.38;
        display: block;
        word-break: normal;
        overflow-wrap: break-word;
      }
      .sky-demo-summary {
        font-size: 0.82rem;
        color: rgba(185, 225, 235, 0.88);
        line-height: 1.5;
        margin: 0;
        flex: 1;
        display: block;
        word-break: normal;
        overflow-wrap: break-word;
      }
      .sky-demo-result {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.15rem;
        padding: 0.42rem 0.6rem;
        font-size: 0.74rem;
        font-weight: 700;
        line-height: 1.35;
        color: var(--card-accent, var(--neon-cyan));
        background: rgba(255, 255, 255, 0.035);
        border: 1px dashed rgba(255, 255, 255, 0.12);
        border-radius: 10px;
        overflow-wrap: break-word;
      }
      .sky-demo-result-ico { font-size: 0.85rem; flex-shrink: 0; }
      .sky-demo-item .sky-demo-media-badge {
        color: var(--card-accent, var(--neon-cyan));
        border-color: var(--card-accent, rgba(0, 229, 255, 0.35));
      }
      .sky-demo-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 0.6rem;
        width: 100%;
      }
      .sky-demo-btn-open {
        flex: 1;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.65rem 1rem;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(0, 229, 255, 0.16), rgba(192, 132, 252, 0.1));
        border: 1px solid rgba(0, 229, 255, 0.45);
        color: var(--neon-cyan);
        font-size: 0.84rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
        box-sizing: border-box;
      }
      .sky-demo-btn-open:hover {
        background: linear-gradient(135deg, #00e5ff 0%, #38bdf8 100%);
        color: #01141a;
        box-shadow: 0 0 20px rgba(0, 229, 255, 0.5);
        transform: translateY(-1px);
      }
      .sky-demo-btn-order {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.65rem 1rem;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(0, 229, 255, 0.28);
        color: var(--text-secondary);
        font-family: inherit;
        font-size: 0.84rem;
        font-weight: 700;
        line-height: 1.2;
        cursor: pointer;
        box-sizing: border-box;
        transition: all 0.25s ease;
        -webkit-tap-highlight-color: transparent;
      }
      .sky-demo-btn-order:hover {
        color: #fff;
        border-color: var(--card-accent, var(--neon-cyan));
        background: rgba(0, 229, 255, 0.12);
        transform: translateY(-1px);
      }

      .sky-demos-footer {
        padding: 1.1rem 1.75rem;
        background: rgba(1, 14, 20, 0.9);
        border-top: 1px solid rgba(0, 229, 255, 0.14);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        flex-shrink: 0;
      }

      /* Tablet & iPad screens (<= 920px) */
      @media (max-width: 920px) {
        .sky-demos-modal {
          max-height: 94vh;
          max-height: 94dvh;
        }
        .sky-demos-filters {
          flex-wrap: nowrap;
          overflow-x: auto;
          overflow-y: hidden;
          -webkit-overflow-scrolling: touch;
          padding: 0.75rem 1.25rem;
          gap: 0.5rem;
          scrollbar-width: thin;
          scrollbar-color: rgba(0, 229, 255, 0.35) transparent;
        }
        .sky-demos-filters::after {
          content: '';
          display: block;
          flex-shrink: 0;
          width: 1.25rem;
          height: 1px;
        }
        .sky-demos-filters::-webkit-scrollbar {
          height: 5px;
        }
        .sky-demos-filters::-webkit-scrollbar-track {
          background: rgba(0, 15, 22, 0.6);
        }
        .sky-demos-filters::-webkit-scrollbar-thumb {
          background: rgba(0, 229, 255, 0.35);
          border-radius: 4px;
        }
        .sky-demos-filters::-webkit-scrollbar-thumb:hover {
          background: rgba(0, 229, 255, 0.65);
        }
        .sky-demos-body {
          grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
          padding: 1.25rem;
          gap: 1.1rem;
        }
      }

      /* Mobile screens (<= 640px) */
      @media (max-width: 640px) {
        .sky-demos-modal-overlay {
          padding: 0.5rem;
        }
        .sky-demos-modal {
          max-height: 96vh;
          max-height: 96dvh;
          border-radius: 16px;
        }
        .sky-demos-header {
          padding: 1rem 1.15rem 0.8rem;
        }
        .sky-demos-title {
          font-size: 1.2rem;
        }
        .sky-demos-desc {
          font-size: 0.82rem;
          line-height: 1.45;
        }
        .sky-demos-filters {
          padding: 0.65rem 0.85rem;
          gap: 0.45rem;
        }
        .sky-demo-filter-btn {
          padding: 0.42rem 0.85rem;
          font-size: 0.78rem;
        }
        .sky-demos-body {
          grid-template-columns: 1fr;
          padding: 1rem 0.85rem;
          gap: 1rem;
        }
        .sky-demo-content {
          padding: 1rem;
          gap: 0.55rem;
        }
        .sky-demos-footer {
          padding: 0.9rem 1.15rem;
          flex-direction: column;
          align-items: stretch;
          gap: 0.75rem;
          text-align: center;
        }
        .sky-demos-footer button,
        .sky-demos-footer a {
          width: 100%;
          justify-content: center;
        }
      }

      /* Ultra-compact mobile screens (<= 380px down to 320px) */
      @media (max-width: 380px) {
        .sky-demos-modal-overlay {
          padding: 0.25rem;
        }
        .sky-demos-modal {
          max-height: 98vh;
          max-height: 98dvh;
          border-radius: 12px;
        }
        .sky-demos-header {
          padding: 0.8rem 0.75rem 0.6rem;
        }
        .sky-demos-title {
          font-size: 1.05rem;
        }
        .sky-demos-desc {
          font-size: 0.75rem;
          line-height: 1.35;
        }
        .sky-demos-filters {
          padding: 0.55rem 0.65rem;
          gap: 0.35rem;
        }
        .sky-demo-filter-btn {
          padding: 0.38rem 0.75rem;
          font-size: 0.74rem;
        }
        .sky-demos-body {
          padding: 0.75rem 0.55rem;
          gap: 0.75rem;
        }
        .sky-demo-media {
          height: 120px;
        }
        .sky-demo-content {
          padding: 0.85rem 0.75rem 0.95rem;
          gap: 0.45rem;
        }
        .sky-demo-name {
          font-size: 0.9rem;
        }
        .sky-demo-summary {
          font-size: 0.77rem;
          line-height: 1.45;
        }
        .sky-demos-footer {
          padding: 0.75rem 0.75rem;
        }
      }

      /* ── Our Projects Modal ── */
      .sky-proj-modal {
        background: linear-gradient(135deg, #100a20 0%, #160c2b 50%, #0c0818 100%);
        border: 1px solid rgba(168, 85, 247, 0.28);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.75), 0 0 35px rgba(168, 85, 247, 0.12);
        border-radius: 20px;
        width: 100%;
        max-width: 640px;
        overflow: hidden;
        padding: 0;
      }

      /* ── Avtobioqrafiya Modal ── */
      .autobio-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
      }
      .autobio-modal-overlay.active {
        opacity: 1;
        visibility: visible;
      }
      .autobio-modal {
        background: linear-gradient(135deg, #0d1b3e 0%, #0a1428 50%, #111827 100%);
        border: 1px solid rgba(168, 85, 247, 0.25);
        border-radius: 20px;
        width: 100%;
        max-width: 680px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 2rem;
        position: relative;
        transform: translateY(30px) scale(0.97);
        transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        scrollbar-width: thin;
        scrollbar-color: rgba(168,85,247,0.3) transparent;
      }
      .autobio-modal-overlay.active .autobio-modal {
        transform: translateY(0) scale(1);
      }
      .autobio-modal::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #a855f7, #7c3aed, #a855f7);
        border-radius: 20px 20px 0 0;
        background-size: 200% 100%;
        animation: autobioTopBar 3s linear infinite;
      }
      @keyframes autobioTopBar {
        0% { background-position: 0% 0%; }
        100% { background-position: 200% 0%; }
      }
      .autobio-modal-close {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text-muted);
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        transition: all 0.2s ease;
        z-index: 10;
      }
      .autobio-modal-close:hover {
        background: rgba(168,85,247,0.15);
        border-color: rgba(168,85,247,0.4);
        color: #a855f7;
      }
      .autobio-modal-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-right: 2.5rem;
      }
      .autobio-modal-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: rgba(168, 85, 247, 0.12);
        border: 1px solid rgba(168, 85, 247, 0.25);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }
      .autobio-modal-icon svg { width: 26px; height: 26px; stroke: #a855f7; }
      .autobio-modal-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.4px;
      }
      .autobio-modal-subtitle {
        font-size: 0.78rem;
        color: var(--text-muted);
        margin-top: 0.1rem;
      }
      .autobio-steps {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
      }
      .autobio-step-dot {
        flex: 1;
        height: 4px;
        border-radius: 2px;
        background: rgba(255,255,255,0.08);
        transition: background 0.3s ease;
      }
      .autobio-step-dot.active {
        background: linear-gradient(90deg, #a855f7, #7c3aed);
      }
      .autobio-step-dot.done {
        background: rgba(168, 85, 247, 0.4);
      }
      .autobio-form-section {
        display: none;
      }
      .autobio-form-section.active {
        display: block;
      }
      .autobio-section-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #a855f7;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }
      .autobio-field-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.85rem;
        margin-bottom: 0.85rem;
      }
      .autobio-field-group.full {
        grid-template-columns: 1fr;
      }
      .autobio-field {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
      }
      .autobio-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-muted);
        letter-spacing: 0.05em;
        text-transform: uppercase;
      }
      .autobio-input, .autobio-textarea, .autobio-select {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 0.6rem 0.9rem;
        font-size: 0.88rem;
        color: var(--text-primary);
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        width: 100%;
        box-sizing: border-box;
      }
      .autobio-input:focus, .autobio-textarea:focus, .autobio-select:focus {
        border-color: rgba(168, 85, 247, 0.5);
        background: rgba(168, 85, 247, 0.05);
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
      }
      .autobio-input::placeholder, .autobio-textarea::placeholder {
        color: rgba(255,255,255,0.2);
      }
      .autobio-select option {
        background: #0d1b3e;
        color: var(--text-primary);
      }
      .autobio-textarea {
        resize: vertical;
        min-height: 90px;
        line-height: 1.55;
      }
      .autobio-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1.5rem;
        gap: 0.75rem;
      }
      .autobio-btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text-muted);
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
      }
      .autobio-btn-back:hover {
        background: rgba(255,255,255,0.08);
        color: var(--text-secondary);
      }
      .autobio-btn-next {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        background: linear-gradient(135deg, #a855f7, #7c3aed);
        border: none;
        color: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
        box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
        margin-left: auto;
      }
      .autobio-btn-next:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(168, 85, 247, 0.45);
      }
      .autobio-btn-next:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
      }
      .autobio-result-area {
        display: none;
      }
      .autobio-result-area.active {
        display: block;
      }
      .autobio-result-box {
        background: rgba(168, 85, 247, 0.04);
        border: 1px solid rgba(168, 85, 247, 0.2);
        border-radius: 14px;
        padding: 1.5rem;
        margin-top: 1rem;
        position: relative;
      }
      .autobio-result-text {
        font-size: 0.9rem;
        line-height: 1.75;
        color: var(--text-secondary);
        white-space: pre-wrap;
      }
      .autobio-copy-btn {
        position: absolute;
        top: 0.75rem; right: 0.75rem;
        padding: 0.35rem 0.8rem;
        border-radius: 8px;
        background: rgba(168, 85, 247, 0.12);
        border: 1px solid rgba(168, 85, 247, 0.25);
        color: #a855f7;
        font-size: 0.72rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: inherit;
        display: flex;
        align-items: center;
        gap: 0.3rem;
      }
      .autobio-copy-btn:hover {
        background: rgba(168, 85, 247, 0.22);
      }
      .autobio-loading {
        display: none;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        color: #a855f7;
        font-size: 0.9rem;
      }
      .autobio-loading.active {
        display: flex;
      }
      .autobio-loader-dots {
        display: flex; gap: 4px;
      }
      .autobio-loader-dots span {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #a855f7;
        animation: autobioDot 1.2s ease-in-out infinite;
      }
      .autobio-loader-dots span:nth-child(2) { animation-delay: 0.2s; }
      .autobio-loader-dots span:nth-child(3) { animation-delay: 0.4s; }
      @keyframes autobioDot {
        0%, 80%, 100% { transform: scale(0.7); opacity: 0.4; }
        40% { transform: scale(1); opacity: 1; }
      }
      .autobio-char-count {
        font-size: 0.68rem;
        color: rgba(255,255,255,0.2);
        text-align: right;
        margin-top: 0.2rem;
      }

      /* Dynamic input styles for improved autobiography */
      .autobio-checkbox-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 0.75rem;
        margin-top: 0.5rem;
      }
      .autobio-checkbox-item {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 10px;
        padding: 0.6rem 0.85rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: all 0.25s ease;
      }
      .autobio-checkbox-item:hover {
        background: rgba(168, 85, 247, 0.05);
        border-color: rgba(168, 85, 247, 0.3);
      }
      .autobio-checkbox-item.checked {
        background: rgba(168, 85, 247, 0.08);
        border-color: rgba(168, 85, 247, 0.5);
      }
      .autobio-checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--text-secondary);
        font-weight: 500;
        cursor: pointer;
        user-select: none;
        width: 100%;
      }
      .autobio-checkbox-label input[type="checkbox"] {
        accent-color: #a855f7;
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin: 0;
      }
      .dynamic-inputs {
        display: none;
        gap: 0.4rem;
        margin-top: 0.4rem;
        padding-top: 0.4rem;
        border-top: 1px dashed rgba(255, 255, 255, 0.1);
      }
      .dynamic-inputs.active {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        animation: autobioFadeIn 0.25s ease forwards;
      }
      .dynamic-row {
        display: flex;
        gap: 0.4rem;
      }
      .dynamic-row input {
        padding: 0.4rem 0.6rem !important;
        font-size: 0.78rem !important;
        border-radius: 6px !important;
      }
      .autobio-signature-area {
        margin-top: 1rem;
        border: 1px dashed rgba(168, 85, 247, 0.3);
        border-radius: 12px;
        background: rgba(0, 0, 0, 0.25);
        padding: 0.6rem;
        position: relative;
      }
      .autobio-canvas {
        background: #060d1e;
        border-radius: 8px;
        display: block;
        width: 100%;
        height: 120px;
        touch-action: none;
        cursor: crosshair;
      }
      .autobio-canvas-clear {
        position: absolute;
        bottom: 12px; right: 12px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text-primary);
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s;
      }
      .autobio-canvas-clear:hover {
        background: rgba(239, 68, 68, 0.2);
        border-color: rgba(239, 68, 68, 0.4);
        color: #ef4444;
      }
      @keyframes autobioFadeIn {
        from { opacity: 0; transform: translateY(-5px); }
        to { opacity: 1; transform: translateY(0); }
      }

      /* Responsive styling for Web, WAP, iOS, Android */
      @media (max-width: 640px) {
        .autobio-modal {
          padding: 1.25rem 1rem !important;
          border-radius: 16px !important;
          max-height: 95vh !important;
        }
        .autobio-modal-header {
          padding-right: 2rem !important;
          margin-bottom: 1.25rem !important;
          gap: 0.75rem !important;
        }
        .autobio-modal-icon {
          width: 42px !important;
          height: 42px !important;
          border-radius: 10px !important;
        }
        .autobio-modal-icon svg {
          width: 20px !important;
          height: 20px !important;
        }
        .autobio-modal-title {
          font-size: 1.1rem !important;
        }
        .autobio-field-group {
          grid-template-columns: 1fr !important;
          gap: 0.75rem !important;
          margin-bottom: 0.75rem !important;
        }
        .autobio-checkbox-grid {
          grid-template-columns: 1fr !important;
          max-height: 220px !important;
        }
        .autobio-signature-area {
          padding: 0.4rem !important;
        }
        .autobio-canvas {
          height: 100px !important;
        }
        .autobio-nav {
          flex-direction: column !important;
          align-items: stretch !important;
          gap: 0.6rem !important;
        }
        .autobio-btn-next, .autobio-btn-back {
          width: 100% !important;
          justify-content: center !important;
          margin-left: 0 !important;
          padding: 0.75rem !important;
          box-sizing: border-box !important;
        }
        .family-member-block {
          padding: 0.5rem !important;
        }
        .family-member-block .autobio-field-group {
          grid-template-columns: 1fr !important;
          gap: 0.5rem !important;
        }
      }


    </style>
    <div class="hero-layout-wrapper">
      <!-- Board Section Title (Logo and Slogan) -->
      <div class="board-header hero-layout-center" style="margin-top: 0; width: 100%;">
      <style>
        .az-logo-wrap {
          display: flex;
          justify-content: center;
          align-items: center;
          margin: -100px auto 28px;
          perspective: 1000px;
          position: relative;
          z-index: 10;
        }
        .az-logo-card {
          width: 120px;
          height: 120px;
          position: relative;
          transform-style: preserve-3d;
          -webkit-transform-style: preserve-3d;
          cursor: pointer;
          transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .az-logo-card.flipped {
          transform: rotateY(180deg);
        }
        .az-logo-face {
          width: 100%;
          height: 100%;
          position: absolute;
          top: 0; left: 0;
          backface-visibility: hidden;
          -webkit-backface-visibility: hidden;
          border-radius: 50%;
          overflow: hidden;
          display: flex;
          align-items: center;
          justify-content: center;
          box-shadow: 0 0 28px rgba(56, 189, 248, 0.35);
          transform: translateZ(0);
          -webkit-transform: translateZ(0);
        }
        .az-logo-face.back {
          transform: rotateY(180deg);
          -webkit-transform: rotateY(180deg);
        }
        .az-logo-face svg {
          width: 100%;
          height: 100%;
          display: block;
        }
        .az-logo-face img {
          width: 100%;
          height: 100%;
          display: block;
          object-fit: cover;
        }
        @media (max-width: 768px) {
          .az-logo-card { width: 90px; height: 90px; }
          .az-logo-wrap { margin: -20px auto 20px; }
        }
      </style>

      <div class="az-logo-wrap">
        <div class="az-logo-card" id="azLogoCard">
          <!-- ÖN ÜZ: Azərbaycan Bayrağı -->
          <div class="az-logo-face">
            <svg viewBox="0 0 450 300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice">
              <defs>
                <clipPath id="flag-clip">
                  <circle cx="225" cy="150" r="150"/>
                </clipPath>
              </defs>
              <g clip-path="url(#flag-clip)">
                <rect width="450" height="100" fill="#0092BC"/>
                <rect y="100" width="450" height="100" fill="#EF3340"/>
                <rect y="200" width="450" height="100" fill="#509E2F"/>
                <circle cx="200" cy="150" r="44" fill="white"/>
                <circle cx="220" cy="150" r="36" fill="#EF3340"/>
                <polygon fill="white" points="260,132 262.9,143.1 272.7,137.3 266.9,147.1 278,150 266.9,152.9 272.7,162.7 262.9,156.9 260,168 257.1,156.9 247.3,162.7 253.1,152.9 242,150 253.1,147.1 247.3,137.3 257.1,143.1"/>
              </g>
            </svg>
          </div>
          <!-- ARXA ÜZ: Azərbaycan Dövlət Gerbi -->
          <div class="az-logo-face back">
            <img src="assets/img/gerb.png" alt="Azərbaycan Dövlət Gerbi">
          </div>
        </div>
      </div>

      <script>
        (function() {
          var card = document.getElementById('azLogoCard');
          if (!card) return;
          var autoFlipInterval = setInterval(function() {
            card.classList.toggle('flipped');
          }, 5000);
          card.addEventListener('click', function() {
            clearInterval(autoFlipInterval);
            card.classList.toggle('flipped');
          });
        })();
      </script>

      <p class="board-sub" data-i18n-html="hero_slogan" style="font-size: 0.88rem; max-width: 680px; margin: 0.4rem auto 0; line-height: 1.65;">
        <?= __('hero_slogan', 'Biznesinizi <span style="color: var(--neon-cyan); font-weight: 700; text-shadow: 0 0 10px rgba(56, 189, 248, 0.35);">Skyweb</span> ilə inkişaf etdirib, nəticələri özünüz analiz edin.') ?>
      </p>
    </div><!-- /.hero-layout-center -->

    <!-- ══════════════════════════════════════════════
         HERO MAIN ROW: Sky 1 (Left) & Sky 2 / Sky 3 (Right)
    ══════════════════════════════════════════════ -->
    <div class="hero-main-row">
      <!-- ── Sky 1: Services Showcase Card (Matches Sky 2 & 3 Visual Style) ── -->
      <section class="sky-services-card" id="sky-services-section" aria-label="<?= e(__('aria_svc_section', 'Skyweb Xidmətləri')) ?>">
        <!-- Sky 1 Head -->
        <div class="sky-svc-head">
          <div class="sky-svc-head-top">
            <h2 class="sky-svc-title">
              <?= e(__('svc_title_prefix', 'Müştərilərə təklif olunan')) ?> <span class="gtext"><?= e(__('svc_title_highlight', 'xidmətlərimiz')) ?></span>
            </h2>
            <button type="button" class="hsvc-info-btn" aria-label="<?= e(__('aria_svc_info', 'Xidmətlər haqqında ətraflı')) ?>" onclick="openSvcInfoPopup();" title="<?= e(__('svc_info_title', 'Məlumat')) ?>">i</button>
          </div>
          <p class="sky-svc-desc" data-i18n="svc_hero_desc"><?= e(__('svc_hero_desc', 'Biznesinizin böyüməsinə, satışların artmasına kömək edən real layihələr.')) ?></p>
        </div>

        <!-- Orderly Sequence Navigation: Clean, No Carousels, No Sliding Windows -->
        <div class="sky-svc-seq-nav" role="tablist" aria-label="<?= e(__('aria_svc_seq', 'Xidmətlər Sırası')) ?>">
          <!-- 01: Web & WAP -->
          <button type="button" class="sky-seq-btn active" id="seq-tab-web" data-svc="web" onclick="switchSkyService('web')" role="tab" aria-selected="true" aria-controls="panel-svc-web">
            <span class="sky-seq-num">01</span>
            <span class="sky-seq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>
              </svg>
            </span>
            <span class="sky-seq-text">
              <span class="sky-seq-name"><?= e(__('svc_card1_title', 'Web & WAP')) ?></span>
              <span class="sky-seq-sub"><?= e(__('svc_card1_sub', 'Sayt · Tətbiq')) ?></span>
            </span>
          </button>

          <!-- 02: SMM & Data -->
          <button type="button" class="sky-seq-btn" id="seq-tab-smm" data-svc="smm" onclick="switchSkyService('smm')" role="tab" aria-selected="false" aria-controls="panel-svc-smm">
            <span class="sky-seq-num">02</span>
            <span class="sky-seq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
              </svg>
            </span>
            <span class="sky-seq-text">
              <span class="sky-seq-name"><?= e(__('svc_card2_title', 'SMM & Data')) ?></span>
              <span class="sky-seq-sub"><?= e(__('svc_card2_sub', 'Analitika')) ?></span>
            </span>
          </button>

          <!-- 03: Mini Oyunlar -->
          <button type="button" class="sky-seq-btn" id="seq-tab-games" data-svc="games" onclick="switchSkyService('games')" role="tab" aria-selected="false" aria-controls="panel-svc-games">
            <span class="sky-seq-num">03</span>
            <span class="sky-seq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 12h4M8 10v4"/><line x1="15" y1="13" x2="15.01" y2="13"/><line x1="18" y1="11" x2="18.01" y2="11"/>
              </svg>
            </span>
            <span class="sky-seq-text">
              <span class="sky-seq-name"><?= e(__('svc_card3_title', 'Mini Oyunlar')) ?></span>
              <span class="sky-seq-sub">iOS · Android · Web</span>
            </span>
          </button>

          <!-- 04: E-Ticarət -->
          <button type="button" class="sky-seq-btn" id="seq-tab-biz" data-svc="biz" onclick="switchSkyService('biz')" role="tab" aria-selected="false" aria-controls="panel-svc-biz">
            <span class="sky-seq-num">04</span>
            <span class="sky-seq-icon">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
              </svg>
            </span>
            <span class="sky-seq-text">
              <span class="sky-seq-name"><?= e(__('svc_card4_title', 'E-Ticarət')) ?></span>
              <span class="sky-seq-sub"><?= e(__('svc_card4_sub', 'Biznes Həlləri')) ?></span>
            </span>
          </button>
        </div>

        <!-- ── Service Information Display Stage (Clean & Instant Information) ── -->
        <div class="sky-svc-stage">
          <!-- Panel 1: Web & WAP -->
          <div class="sky-svc-panel active" id="panel-svc-web" data-panel="web" role="tabpanel" aria-labelledby="seq-tab-web">
            <div class="sky-svc-info">
              <div class="sky-svc-badge sky-badge-cyan" data-i18n="svc_panel1_badge"><?= e(__('svc_panel1_badge', '💻 Web & WAP Platformaları')) ?></div>
              <h3 class="sky-svc-panel-title" data-i18n="svc_panel1_title"><?= e(__('svc_panel1_title', 'Müasir Vebsayt & Mobil Platformalar')) ?></h3>
              <p class="sky-svc-panel-desc" data-i18n="svc_panel1_desc">
                <?= e(__('svc_panel1_desc', 'iOS, Android, Web və WAP platformaları üçün tam uyğun, sürətli yüklənən, premium dizaynlı vebsayt və mobil tətbiqlər. Donma, gecikmə yoxdur — Yüksək yerli performans.')) ?>
              </p>
              <div class="sky-svc-chips">
                <span class="sky-svc-chip active-chip">📱 <?= e(__('svc_chip_ios', 'iOS uyğun')) ?></span>
                <span class="sky-svc-chip active-chip">🤖 <?= e(__('svc_chip_android', 'Android')) ?></span>
                <span class="sky-svc-chip active-chip">🌐 <?= e(__('svc_chip_wap', 'WAP')) ?></span>
                <span class="sky-svc-chip active-chip">📲 <?= e(__('svc_chip_pwa', 'Quraşdırılan tətbiq')) ?></span>
                <span class="sky-svc-chip active-chip">🖥️ <?= e(__('svc_chip_responsive', 'Bütün ekranlara uyğun')) ?></span>
              </div>
              <a href="#services" class="sky-svc-action-btn" onclick="if(typeof openWebServicesModal==='function'){openWebServicesModal();return false;}">
                <span><?= e(__('svc_link_examples', 'Nümunələrə bax')) ?></span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
            <!-- 2027 Futuristic Animation HUD: Web & WAP -->
            <div class="sky-hud-stage">
              <div class="hud-metric-pill" style="top: 14px; left: 14px; border-color: rgba(0,229,255,0.4);">
                <span data-i18n="svc_hud1_a"><?= e(__('svc_hud1_a', '⚡ 100/100 Sürət')) ?></span>
              </div>
              <div class="hud-metric-pill" style="bottom: 14px; right: 14px; border-color: rgba(56,189,248,0.4); color:#38bdf8;">
                <span data-i18n="svc_hud1_b"><?= e(__('svc_hud1_b', '🛡️ Yüksək Yerli Performans')) ?></span>
              </div>
              <div style="position:relative; width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                <!-- Cyber Laptop (2027 Style) -->
                <svg width="128" height="85" viewBox="0 0 128 85" fill="none" style="animation: cyberDeviceFloat 4s ease-in-out infinite; filter: drop-shadow(0 10px 20px rgba(0, 229, 255, 0.25));">
                  <rect x="14" y="8" width="100" height="62" rx="6" fill="#04121d" stroke="#00f0ff" stroke-width="2"/>
                  <rect x="20" y="14" width="88" height="50" rx="3" fill="rgba(0, 229, 255, 0.08)"/>
                  <path d="M4 72 L124 72 L116 78 L12 78 Z" fill="#061c2d" stroke="#00f0ff" stroke-width="1.8"/>
                  <!-- Glowing screen UI lines -->
                  <line x1="28" y1="24" x2="65" y2="24" stroke="#00f0ff" stroke-width="2.5" stroke-linecap="round"/>
                  <line x1="28" y1="34" x2="90" y2="34" stroke="rgba(0, 229, 255, 0.6)" stroke-width="2" stroke-linecap="round"/>
                  <line x1="28" y1="44" x2="80" y2="44" stroke="rgba(0, 229, 255, 0.4)" stroke-width="2" stroke-linecap="round"/>
                  <line x1="28" y1="54" x2="55" y2="54" stroke="rgba(0, 229, 255, 0.5)" stroke-width="2" stroke-linecap="round"/>
                  <circle cx="94" cy="50" r="5" fill="#00f0ff" style="filter: drop-shadow(0 0 6px #00f0ff);"/>
                </svg>
                <!-- Cyber Phone (Floating alongside) -->
                <svg width="36" height="60" viewBox="0 0 36 60" fill="none" style="position:absolute; right: 28px; bottom: 20px; animation: cyberPhoneFloat 3.6s ease-in-out infinite; filter: drop-shadow(0 6px 14px rgba(129, 140, 248, 0.45));">
                  <rect x="2" y="2" width="32" height="56" rx="6" fill="#08142b" stroke="#818cf8" stroke-width="2"/>
                  <rect x="6" y="8" width="24" height="44" rx="3" fill="rgba(129, 140, 248, 0.12)"/>
                  <line x1="12" y1="16" x2="24" y2="16" stroke="#818cf8" stroke-width="2" stroke-linecap="round"/>
                  <line x1="12" y1="24" x2="20" y2="24" stroke="rgba(129, 140, 248, 0.6)" stroke-width="1.8" stroke-linecap="round"/>
                  <circle cx="18" cy="46" r="2.5" fill="#818cf8"/>
                </svg>
              </div>
            </div>
          </div>

          <!-- Panel 2: SMM & Data -->
          <div class="sky-svc-panel" id="panel-svc-smm" data-panel="smm" role="tabpanel" aria-labelledby="seq-tab-smm">
            <div class="sky-svc-info">
              <div class="sky-svc-badge sky-badge-purple" data-i18n="svc_panel2_badge"><?= e(__('svc_panel2_badge', '📊 Data & Hədəfli Reklam')) ?></div>
              <h3 class="sky-svc-panel-title" data-i18n="svc_panel2_title"><?= e(__('svc_panel2_title', 'SMM & Real-Time Data Analitika')) ?></h3>
              <p class="sky-svc-panel-desc">
                <?= e(__('svc_card2_desc', 'Sosial şəbəkələrdə hədəfli reklam kampaniyaları, məzmun planlaması və real-time data analitika. Brendinizi gücləndir, satışları artır.')) ?>
              </p>
              <div class="sky-svc-chips">
                <span class="sky-svc-chip active-chip">🎯 <?= e(__('svc_chip_meta_ads', 'Meta Ads')) ?></span>
                <span class="sky-svc-chip active-chip">📈 <?= e(__('svc_chip_google_ads', 'Google Ads')) ?></span>
                <span class="sky-svc-chip active-chip">📱 <?= e(__('svc_chip_tiktok', 'TikTok')) ?></span>
                <span class="sky-svc-chip active-chip">📊 <?= e(__('svc_chip_dashboard', 'Dashboard')) ?></span>
              </div>
              <a href="modules/analytics/" class="sky-svc-action-btn" style="color:#a5b4fc; border-color:rgba(129,140,248,0.45); box-shadow:0 0 15px rgba(129,140,248,0.15);">
                <span><?= e(__('svc_link_analytics', 'Analitika Paneli')) ?></span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
            <!-- 2027 Futuristic Animation HUD: SMM & Data -->
            <div class="sky-hud-stage" style="background: linear-gradient(135deg, rgba(129, 140, 248, 0.04) 0%, rgba(12, 10, 32, 0.88) 100%); border-color: rgba(129, 140, 248, 0.22);">
              <div class="hud-metric-pill" style="top: 14px; left: 14px; border-color: rgba(129,140,248,0.45); color:#c7d2fe;">
                <span data-i18n="svc_hud2_a"><?= e(__('svc_hud2_a', '📈 +248% Satış Artımı')) ?></span>
              </div>
              <div class="hud-metric-pill" style="bottom: 14px; right: 14px; border-color: rgba(168,85,247,0.45); color:#d8b4fe;">
                <span data-i18n="svc_hud2_b"><?= e(__('svc_hud2_b', '🎯 ROI: 5.2x Hədəf')) ?></span>
              </div>
              <svg width="220" height="110" viewBox="0 0 220 110" fill="none" style="filter: drop-shadow(0 0 15px rgba(129, 140, 248, 0.35));">
                <defs>
                  <linearGradient id="smmWaveGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#818cf8" stop-opacity="0.35"/>
                    <stop offset="100%" stop-color="#818cf8" stop-opacity="0.0"/>
                  </linearGradient>
                </defs>
                <!-- Grid background lines -->
                <line x1="20" y1="20" x2="200" y2="20" stroke="rgba(129,140,248,0.12)" stroke-dasharray="3 3"/>
                <line x1="20" y1="50" x2="200" y2="50" stroke="rgba(129,140,248,0.12)" stroke-dasharray="3 3"/>
                <line x1="20" y1="80" x2="200" y2="80" stroke="rgba(129,140,248,0.12)" stroke-dasharray="3 3"/>
                <!-- Filled growth area -->
                <path d="M 20 90 Q 60 85, 90 60 T 160 38 T 200 18 L 200 95 L 20 95 Z" fill="url(#smmWaveGrad)"/>
                <!-- Exponential Growth Curve -->
                <path d="M 20 90 Q 60 85, 90 60 T 160 38 T 200 18" stroke="#818cf8" stroke-width="3" fill="none" stroke-linecap="round" style="filter: drop-shadow(0 0 8px #818cf8);"/>
                <!-- Glowing Peak Beacon Dot -->
                <circle cx="200" cy="18" r="6" fill="#c7d2fe" style="animation: cyberBeaconPulse 2.2s infinite; transform-origin: 200px 18px; filter: drop-shadow(0 0 8px #fff);"/>
                <circle cx="160" cy="38" r="4" fill="#818cf8"/>
                <circle cx="90" cy="60" r="4" fill="#818cf8"/>
              </svg>
            </div>
          </div>

          <!-- Panel 3: Mini Oyunlar -->
          <div class="sky-svc-panel" id="panel-svc-games" data-panel="games" role="tabpanel" aria-labelledby="seq-tab-games">
            <div class="sky-svc-info">
              <div class="sky-svc-badge sky-badge-green" data-i18n="svc_panel3_badge"><?= e(__('svc_panel3_badge', '🎮 Gamification & Əyləncə')) ?></div>
              <h3 class="sky-svc-panel-title" data-i18n="svc_panel3_title"><?= e(__('svc_panel3_title', 'Biznesə Özəl İnteraktiv Mini Oyunlar')) ?></h3>
              <p class="sky-svc-panel-desc">
                <?= e(__('svc_card3_desc', 'Biznesinizə özəl interaktiv mini oyunlar — iOS, Android, Web & WAP tam uyğun. Gamification ilə müştəri loyallığını artır. Donma, tıxanma yoxdur.')) ?>
              </p>
              <div class="sky-svc-chips">
                <span class="sky-svc-chip active-chip">🎡 <?= e(__('svc_chip_wheel', 'Fırlanan Çarx')) ?></span>
                <span class="sky-svc-chip active-chip">❓ <?= e(__('svc_chip_quiz', 'Viktorina')) ?></span>
                <span class="sky-svc-chip active-chip">🎰 <?= e(__('svc_chip_slot', 'Mini Slot')) ?></span>
                <span class="sky-svc-chip active-chip">🧩 <?= e(__('svc_chip_puzzle', 'Tapmaca')) ?></span>
              </div>
              <a href="modules/games/" class="sky-svc-action-btn" style="color:#34d399; border-color:rgba(16,185,129,0.45); box-shadow:0 0 15px rgba(16,185,129,0.15);">
                <span><?= e(__('svc_link_order_game', 'Oyun Sifariş Et')) ?></span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
            <!-- 2027 Futuristic Animation HUD: Mini Games -->
            <div class="sky-hud-stage" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.04) 0%, rgba(5, 24, 18, 0.88) 100%); border-color: rgba(16, 185, 129, 0.22);">
              <div class="hud-metric-pill" style="top: 14px; left: 14px; border-color: rgba(16,185,129,0.45); color:#a7f3d0;">
                <span data-i18n="svc_hud3_a"><?= e(__('svc_hud3_a', '🎮 60 FPS Axıcı Performans')) ?></span>
              </div>
              <div class="hud-metric-pill" style="bottom: 14px; right: 14px; border-color: rgba(52,211,153,0.45); color:#6ee7b7;">
                <span data-i18n="svc_hud3_b"><?= e(__('svc_hud3_b', '🏆 +500 XP Loyallıq')) ?></span>
              </div>
              <div style="position:relative; width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                <!-- Cyber Gamepad Engine -->
                <svg width="105" height="75" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="1.6" style="animation: cyberGamepadPulse 3.5s ease-in-out infinite; transform-origin: center;">
                  <rect x="2" y="6" width="20" height="12" rx="6" fill="rgba(16,185,129,0.12)"/>
                  <path d="M6 12h4M8 10v4" stroke-width="2.2" stroke-linecap="round"/>
                  <circle cx="15.5" cy="13.5" r="1.5" fill="#34d399" style="filter: drop-shadow(0 0 4px #34d399);"/>
                  <circle cx="18.5" cy="10.5" r="1.5" fill="#10b981" style="filter: drop-shadow(0 0 4px #10b981);"/>
                </svg>
                <!-- 3D Floating Reward Coin / Gem -->
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" style="position:absolute; right: 35px; top: 22px; animation: cyberCoin3D 3.5s linear infinite;">
                  <circle cx="12" cy="12" r="10" stroke="#34d399" stroke-width="2.2" fill="rgba(16,185,129,0.2)"/>
                  <path d="M12 6v12M9 9h6M9 15h6" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>
            </div>
          </div>

          <!-- Panel 4: E-Ticarət -->
          <div class="sky-svc-panel" id="panel-svc-biz" data-panel="biz" role="tabpanel" aria-labelledby="seq-tab-biz">
            <div class="sky-svc-info">
              <div class="sky-svc-badge sky-badge-pink" data-i18n="svc_panel4_badge"><?= e(__('svc_panel4_badge', '🛒 E-Ticarət & Ödəniş')) ?></div>
              <h3 class="sky-svc-panel-title" data-i18n="svc_panel4_title"><?= e(__('svc_panel4_title', 'Online Satış & Biznes Platformaları')) ?></h3>
              <p class="sky-svc-panel-desc">
                <?= e(__('svc_card4_desc', 'Online mağaza, rezervasiya sistemi, menyu tətbiqi — istənilən biznes növü üçün fərdi e-ticarət həlləri. Ödəniş inteqrasiyası, admin panel daxildir.')) ?>
              </p>
              <div class="sky-svc-chips">
                <span class="sky-svc-chip active-chip">🛍️ <?= e(__('svc_chip_online_store', 'Online Mağaza')) ?></span>
                <span class="sky-svc-chip active-chip">💳 <?= e(__('svc_chip_payment', 'Ödəniş')) ?></span>
                <span class="sky-svc-chip active-chip">⚙️ <?= e(__('svc_chip_admin_panel', 'Admin Panel')) ?></span>
                <span class="sky-svc-chip active-chip">📋 <?= e(__('svc_chip_menu_app', 'Menyu App')) ?></span>
              </div>
              <a href="#services" class="sky-svc-action-btn" style="color:#f472b6; border-color:rgba(236,72,153,0.45); box-shadow:0 0 15px rgba(236,72,153,0.15);" onclick="if(typeof openWebServicesModal==='function'){openWebServicesModal();return false;}">
                <span><?= e(__('svc_link_projects', 'Layihələrə bax')) ?></span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
              </a>
            </div>
            <!-- 2027 Futuristic Animation HUD: E-Commerce -->
            <div class="sky-hud-stage" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.04) 0%, rgba(26, 6, 20, 0.88) 100%); border-color: rgba(236, 72, 153, 0.22);">
              <div class="hud-metric-pill" style="top: 14px; left: 14px; border-color: rgba(236,72,153,0.45); color:#fbcfe8;">
                <span data-i18n="svc_hud4_a"><?= e(__('svc_hud4_a', '✔ 3D Qorunan Ödəniş')) ?></span>
              </div>
              <div class="hud-metric-pill" style="bottom: 14px; right: 14px; border-color: rgba(244,114,182,0.45); color:#f472b6;">
                <span data-i18n="svc_hud4_b"><?= e(__('svc_hud4_b', '⚡ 1-Kliklə Sifariş')) ?></span>
              </div>
              <div style="position:relative; width:100%; height:100%; display:flex; align-items:center; justify-content:center;">
                <!-- Cyber Store Bag / Card -->
                <svg width="76" height="76" viewBox="0 0 24 24" fill="none" stroke="#ec4899" stroke-width="1.8" style="animation: cyberCartFloat 3.8s ease-in-out infinite;">
                  <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" fill="rgba(236, 72, 153, 0.12)"/>
                  <line x1="3" y1="6" x2="21" y2="6"/>
                  <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <!-- Glowing Floating Credit Card Element -->
                <svg width="48" height="32" viewBox="0 0 24 24" fill="rgba(236, 72, 153, 0.85)" style="position:absolute; left: 40px; bottom: 26px; animation: cyberCardSlide3D 3.8s ease-in-out infinite;">
                  <rect x="1" y="4" width="22" height="16" rx="2" stroke="#fff" stroke-width="1.2"/>
                  <line x1="1" y1="9" x2="23" y2="9" stroke="#080f26" stroke-width="2.5"/>
                  <rect x="3" y="14" width="4" height="3" rx="0.5" fill="#fbcfe8"/>
                </svg>
                <!-- Verification Pulse Badge -->
                <div style="position:absolute; top: 32px; right: 42px; background: #ec4899; border-radius: 50%; padding: 5px; display:flex; align-items:center; justify-content:center; box-shadow:0 0 15px #ec4899; animation: cyberCheckBadge 3s ease-in-out infinite;">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.sky-svc-stage -->
      </section><!-- /.sky-services-card -->

      <!-- ── Sky 2 & Sky 3: Side Cards Stack ── -->
      <div class="hero-side-cards-stack">
        <!-- Sky 2: Web Sayt & Xidmətlər (10 Demos Showcase) -->
        <div class="sky-side-card sky-side-services" id="card-services-demo" onclick="openWebServicesModal()" role="button" tabindex="0" aria-label="<?= e(__('hero_tab_services_title', 'Veb Sayt & Xidmətlər')) ?>" onkeydown="if(event.key==='Enter'||event.key===' ')openWebServicesModal()">
          <div class="cv-hero-widget-head">
            <div class="cv-hero-icon" style="background:rgba(0,229,255,0.08); border:1px solid rgba(0,229,255,0.32); width:42px; height:42px; border-radius:12px;">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#00e5ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px; height:20px;">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
              </svg>
            </div>
            <div>
              <div class="cv-hero-title" data-i18n="hero_tab_services_title"><?= e(__('hero_tab_services_title', 'Veb Sayt & Xidmətlər')) ?></div>
              <div class="cv-hero-sub" style="color:#00e5ff;"><span data-i18n="hero_tab_services_sub"><?= e(__('hero_tab_services_sub', 'İnteraktiv Demo')) ?></span></div>
            </div>
          </div>
          <p class="cv-hero-desc" data-i18n="hero_tab_services_desc">
            <?= e(__('hero_tab_services_desc', 'Geyim, yemək, WhatsApp ticarət, aptek və kiçik bizneslər üçün hazır satış saytları.')) ?>
          </p>
          <div class="cv-hero-chips" style="margin-bottom:0.45rem;">
            <span class="cv-hero-chip">👗 <span data-i18n="demo_cat_clothing"><?= e(__('demo_cat_clothing', 'Geyim')) ?></span></span>
            <span class="cv-hero-chip">🍔 <span data-i18n="demo_cat_food"><?= e(__('demo_cat_food', 'Yemək')) ?></span></span>
            <span class="cv-hero-chip">💬 <span data-i18n="demo_cat_whatsapp"><?= e(__('demo_cat_whatsapp', 'WhatsApp')) ?></span></span>
            <span class="cv-hero-chip">💊 <span data-i18n="demo_cat_pharmacy"><?= e(__('demo_cat_pharmacy', 'Aptek')) ?></span></span>
            <span class="cv-hero-chip" style="background:rgba(0,229,255,0.12); border-color:rgba(0,229,255,0.38); color:#00e5ff; font-weight:700;">+6 Demo</span>
          </div>
          <div style="margin-top:auto; padding-top:0.4rem;">
            <span class="cv-hero-btn" onclick="event.stopPropagation(); openWebServicesModal();" role="button" tabindex="0">
              <span data-i18n="btn_view_demos"><?= e(__('btn_view_demos', '10 Demo Sayta Bax')) ?></span>
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </div>

        <!-- Sky 3: Təklif Olunan Layihələr (Portfel & Gələcək Layihələr) -->
        <div class="sky-side-card sky-side-projects" id="card-our-projects" onclick="openOurProjectsModal()" role="button" tabindex="0" aria-label="<?= e(__('hero_tab_projects_title', 'Təklif Olunan Layihələr')) ?>" onkeydown="if(event.key==='Enter'||event.key===' ')openOurProjectsModal()">
          <div class="cv-hero-widget-head">
            <div class="cv-hero-icon" style="background:rgba(168,85,247,0.08); border-color:rgba(168,85,247,0.22); width:42px; height:42px;">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#c084fc" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px; height:20px;">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                <polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline>
              </svg>
            </div>
            <div>
              <div class="cv-hero-title" data-i18n="hero_tab_projects_title"><?= e(__('hero_tab_projects_title', 'Təklif Olunan Layihələr')) ?></div>
              <div class="cv-hero-sub" style="color:#c084fc;"><span data-i18n="hero_tab_projects_sub">📁 <?= e(__('hero_tab_projects_sub', 'Portfel & Gələcək Layihələr')) ?></span></div>
            </div>
          </div>
          <p class="cv-hero-desc" data-i18n="hero_tab_projects_desc">
            <?= e(__('hero_tab_projects_desc', 'Tamamlanan müştəri saytları və gələcək rəqəmsal layihələrimiz tezliklə burada nümayiş olunacaq.')) ?>
          </p>
          <div class="cv-hero-chips" style="margin-bottom:0.45rem;">
            <span class="cv-hero-chip purple-chip">⏳ <span data-i18n="status_coming_soon"><?= e(__('status_coming_soon', 'Hazırlıq Mərhələsində')) ?></span></span>
            <span class="cv-hero-chip purple-chip" data-i18n="chip_live_cases"><?= e(__('chip_live_cases', 'Real Keyslər')) ?></span>
            <span class="cv-hero-chip purple-chip" data-i18n="chip_custom_dev"><?= e(__('chip_custom_dev', 'Fərdi Həllər')) ?></span>
          </div>
          <div style="margin-top:auto; padding-top:0.4rem;">
            <span class="cv-hero-btn" onclick="event.stopPropagation(); openOurProjectsModal();" role="button" tabindex="0">
              <span data-i18n="btn_project_details"><?= e(__('btn_project_details', 'Layihə Məlumatı')) ?></span>
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </span>
          </div>
        </div>
      </div><!-- /.hero-side-cards-stack -->
    </div><!-- /.hero-main-row -->

    <!-- ══════════════════════════════════════════════
         REQUIREMENT 4: CV & AUTOBIOGRAPHY SERVICES
         Aligned horizontally on the same row, equal width,
         equal height, spacing, and perfect visual balance.
    ══════════════════════════════════════════════ -->
    <div class="hero-cv-autobio-row" id="hero-cv-autobio-section">
      <!-- ── CV Hazırlama ── -->
      <div class="sky-cv-card" id="card-cv-service">
        <div class="cv-card-top">
          <div class="cv-hero-widget-head">
            <div class="cv-hero-icon sky-cv-icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><circle cx="9" cy="13" r="1.5" fill="currentColor"/><line x1="12" y1="13" x2="16" y2="13"/><line x1="9" y1="17" x2="16" y2="17"/>
              </svg>
            </div>
            <div>
              <div class="cv-hero-title"><?= e(__('hero_tab_cv_title', 'CV Hazırlama')) ?></div>
              <div class="cv-hero-sub" style="color:var(--neon-cyan);" data-i18n="cv_hero_sub"><?= e(__('cv_hero_sub', '✨ Peşəkar HR Şablonları · Generator')) ?></div>
            </div>
          </div>
          <p class="cv-hero-desc">
            <?= e(__('hero_tab_cv_desc', 'Peşəkar şablonlarla HR standartlarına uyğun CV-lər hazırlayın.')) ?> <span data-i18n="cv_hero_desc2"><?= e(__('cv_hero_desc2', 'Vakansiyalara tam uyğunlaşdırılmış müasir formatlar və ani PDF yükləmə.')) ?></span>
          </p>
          <div class="cv-hero-chips">
            <span class="cv-hero-chip" data-i18n="cv_chip_ats"><?= e(__('cv_chip_ats', '📄 ATS Standartı')) ?></span>
            <span class="cv-hero-chip" data-i18n="cv_chip_templates"><?= e(__('cv_chip_templates', '🎨 6+ Peşəkar Şablon')) ?></span>
            <span class="cv-hero-chip" data-i18n="cv_chip_pdf"><?= e(__('cv_chip_pdf', '💾 PDF Yükləmə')) ?></span>
            <span class="cv-hero-chip" data-i18n="cv_chip_fast"><?= e(__('cv_chip_fast', '⚡ Sürətli Yaratma')) ?></span>
          </div>
        </div>
        <div class="cv-card-bottom">
          <a href="modules/cv-builder/" class="cv-hero-btn" aria-label="<?= e(__('aria_cv_goto', 'CV Hazırlama xidmətinə keç')) ?>">
            <span><?= e(__('hero_tab_cv_btn', 'CV-ni Hazırla')) ?></span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
        </div>
      </div>

      <!-- ── Avtobioqrafiya ── -->
      <div class="sky-autobio-card" id="card-autobio-service">
        <div class="cv-card-top">
          <div class="cv-hero-widget-head">
            <div class="cv-hero-icon sky-autobio-icon-wrap">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
              </svg>
            </div>
            <div>
              <div class="cv-hero-title"><?= e(__('hero_tab_autobio_title', 'Avtobioqrafiya')) ?></div>
              <div class="cv-hero-sub" style="color:#c084fc;" data-i18n="autobio_hero_sub"><?= e(__('autobio_hero_sub', '🏛️ Rəsmi Tərcümeyi-hal · AI Dəstəkli')) ?></div>
            </div>
          </div>
          <p class="cv-hero-desc">
            <?= e(__('hero_tab_autobio_desc', 'Dövlət qulluğu və müəssisələr üçün rəsmi tərcümeyi-hal hazırlayın.')) ?> <span data-i18n="autobio_hero_desc2"><?= e(__('autobio_hero_desc2', 'AI redaktə köməkçisi, rəqəmsal imza inteqrasiyası və rəsmi dövlət standartı.')) ?></span>
          </p>
          <div class="cv-hero-chips">
            <span class="cv-hero-chip purple-chip" data-i18n="autobio_chip_ai"><?= e(__('autobio_chip_ai', '🤖 AI Köməkçi')) ?></span>
            <span class="cv-hero-chip purple-chip" data-i18n="autobio_chip_std"><?= e(__('autobio_chip_std', '🏛️ Dövlət Qulluğu Standartı')) ?></span>
            <span class="cv-hero-chip purple-chip" data-i18n="autobio_chip_pdf"><?= e(__('autobio_chip_pdf', '📄 PDF / Çap')) ?></span>
            <span class="cv-hero-chip purple-chip" data-i18n="autobio_chip_sign"><?= e(__('autobio_chip_sign', '🖋️ Rəqəmsal İmza')) ?></span>
          </div>
        </div>
        <div class="cv-card-bottom">
          <button type="button" class="autobio-hero-btn" onclick="openAutobioModal()" aria-label="<?= e(__('aria_autobio_goto', 'Avtobioqrafiya xidmətinə keç')) ?>">
            <span><?= e(__('hero_tab_autobio_btn', 'Avtobioqrafiya Yarat')) ?></span>
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>
      </div>
    </div><!-- /.hero-cv-autobio-row -->
    </div>
  </div>
</section>

<!-- ════════════════════════════════════════════════════════════
     LEGACY SERVICE-FOLDER STYLES (kept for hero widgets)
════════════════════════════════════════════════════════════ -->
<style>
  /* ── Main Trigger for Service Folders ── */
  .svc-main-trigger-wrap {
    display: flex;
    justify-content: center;
    margin-top: 1.75rem;
    margin-bottom: 0;
  }
  .svc-main-trigger {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    background: rgba(255,255,255,0.025);
    border: 1px solid var(--sky-border);
    padding: 0.6rem 1.25rem;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
  }
  .svc-main-trigger:hover {
    background: rgba(255,255,255,0.06);
    border-color: rgba(56,189,248,0.4);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
  }
  .svc-folders-title {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin: 0;
  }
  .svc-main-chevron {
    width: 16px;
    height: 16px;
    color: var(--text-secondary);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), color 0.3s;
  }
  .svc-main-trigger.smc-active .svc-main-chevron {
    transform: rotate(180deg);
    color: #38bdf8;
  }
  .svc-main-trigger.smc-active {
    border-color: rgba(56,189,248,0.4);
    background: rgba(56,189,248,0.05);
  }
  /* Main Collapse Container */
  .svc-main-collapse {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.6s cubic-bezier(0.4,0,0.2,1);
  }
  .svc-main-collapse.smc-open {
    max-height: 2000px; /* enough to show all grid items */
  }
  .svc-info-trigger {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: 1.5px solid rgba(56,189,248,0.5);
    background: rgba(56,189,248,0.08);
    cursor: pointer;
    color: #38bdf8;
    font-size: 13px;
    font-weight: 700;
    font-style: italic;
    font-family: Georgia, serif;
    transition: background 0.2s, transform 0.2s, border-color 0.2s;
    flex-shrink: 0;
    -webkit-tap-highlight-color: transparent;
  }
  .svc-info-trigger:hover {
    background: rgba(56,189,248,0.22);
    border-color: #38bdf8;
    transform: scale(1.12);
  }
  /* ── Service Folder Grid ─────────────────────────────────── */
  .svc-folders-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
    justify-content: center;
    margin-bottom: 2.5rem;
    padding-top: 0.5rem;
    align-items: flex-start;
  }

  /* Collapsed cards — compact pill row */
  .svc-folder-card {
    position: relative;
    background: rgba(255,255,255,0.025);
    border: 1px solid var(--sky-border);
    border-radius: 14px;
    padding: 0;
    cursor: pointer;
    flex: 1 1 140px;
    min-width: 130px;
    max-width: 195px;
    overflow: visible; /* allow panel shadow */
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.25s, flex 0.4s, max-width 0.4s;
    -webkit-tap-highlight-color: transparent;
    opacity: 0;
    transform: translateY(20px);
  }

  /* Active (expanded) card takes full row */
  .svc-folder-card.sfc-active {
    flex: 0 0 100%;
    max-width: 100%;
    border-color: var(--card-accent, #38bdf8);
    background: rgba(56,189,248,0.05);
    box-shadow: 0 8px 32px rgba(56,189,248,0.12);
    transform: none !important;
  }

  .smc-open .svc-folder-card {
    opacity: 1;
    transform: translateY(0);
  }
  .smc-open .svc-folder-card:not(.sfc-active):hover {
    border-color: var(--card-accent, rgba(56,189,248,0.45));
    box-shadow: 0 6px 22px rgba(0,0,0,0.3);
    transform: translateY(-3px);
  }

  /* Sequential entrance animation */
  .smc-open .svc-folder-card:nth-child(1) { transition: opacity 0.4s 0.1s, transform 0.4s 0.1s, border-color 0.3s, box-shadow 0.3s, flex 0.4s, max-width 0.4s; }
  .smc-open .svc-folder-card:nth-child(2) { transition: opacity 0.4s 0.2s, transform 0.4s 0.2s, border-color 0.3s, box-shadow 0.3s, flex 0.4s, max-width 0.4s; }
  .smc-open .svc-folder-card:nth-child(3) { transition: opacity 0.4s 0.3s, transform 0.4s 0.3s, border-color 0.3s, box-shadow 0.3s, flex 0.4s, max-width 0.4s; }
  .smc-open .svc-folder-card:nth-child(4) { transition: opacity 0.4s 0.4s, transform 0.4s 0.4s, border-color 0.3s, box-shadow 0.3s, flex 0.4s, max-width 0.4s; }
  .smc-open .svc-folder-card:nth-child(5) { transition: opacity 0.4s 0.5s, transform 0.4s 0.5s, border-color 0.3s, box-shadow 0.3s, flex 0.4s, max-width 0.4s; }

  .smc-entered .svc-folder-card {
    transition: border-color 0.3s, box-shadow 0.3s, transform 0.25s, flex 0.4s, max-width 0.4s !important;
  }

  /* ── Header ──────────────────────────────────────────────── */
  .svc-folder-header {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1rem;
  }
  .svc-folder-card.sfc-active .svc-folder-header {
    padding-bottom: 0.75rem;
  }
  .svc-folder-icon-wrap {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .svc-folder-icon-wrap svg {
    width: 18px;
    height: 18px;
  }
  .svc-folder-meta {
    flex: 1;
    min-width: 0;
  }
  .svc-folder-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  /* When card is active, show full name */
  .svc-folder-card.sfc-active .svc-folder-name {
    white-space: normal;
    font-size: 1rem;
  }
  .svc-folder-sub {
    font-size: 0.72rem;
    color: var(--text-secondary);
    margin-top: 0.12rem;
  }
  .svc-folder-card.sfc-active .svc-folder-sub {
    font-size: 0.8rem;
  }
  .svc-folder-chevron {
    width: 14px;
    height: 14px;
    color: var(--text-secondary);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), color 0.2s;
    flex-shrink: 0;
  }
  .svc-folder-card.sfc-active .svc-folder-chevron {
    transform: rotate(90deg);
    color: #38bdf8;
  }

  /* ── Expandable panel ────────────────────────────────────── */
  .svc-folder-panel {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.45s cubic-bezier(0.4,0,0.2,1);
    border-top: 0px solid transparent;
  }
  .svc-folder-card.sfc-active .svc-folder-panel {
    max-height: 1200px;   /* generous height for all content */
    border-top: 1px solid rgba(255,255,255,0.06);
  }
  .svc-folder-panel-inner {
    padding: 1rem 1.25rem 1.25rem;
    background: rgba(0,0,0,0.15);
  }

  /* Layout for expanded card: description + example side by side on wide screens */
  .svc-folder-card.sfc-active .svc-folder-panel-inner {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    align-items: flex-start;
  }
  .sfc-panel-info {
    flex: 1 1 240px;
    min-width: 220px;
  }
  .sfc-example-wrap {
    flex: 2 1 320px;
    min-width: 280px;
    margin-top: 0 !important;
  }

  .sfc-desc {
    font-size: 0.875rem;
    color: rgba(190,210,240,0.92);
    line-height: 1.7;
    margin-bottom: 0.8rem;
  }
  .sfc-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.35rem;
    margin-bottom: 0.8rem;
  }
  .sfc-chip {
    font-size: 0.72rem;
    padding: 0.22rem 0.65rem;
    border-radius: 20px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    color: var(--text-secondary);
    font-weight: 500;
    letter-spacing: 0.01em;
  }
  .sfc-link {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.8rem;
    font-weight: 600;
    color: #38bdf8;
    text-decoration: none;
    transition: opacity 0.2s;
  }
  .sfc-link:hover { opacity: 0.75; }

  /* Info Popup Overlay */
  #svc-info-popup-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 999998;
    background: rgba(5,10,30,0.7);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
  }
  #svc-info-popup-overlay.sip-open {
    display: flex;
  }
  #svc-info-popup-box {
    position: relative;
    background: linear-gradient(145deg, rgba(8,15,38,0.98) 0%, rgba(12,22,50,0.98) 100%);
    border: 1px solid rgba(56,189,248,0.35);
    border-radius: 18px;
    padding: 1.8rem 1.8rem 1.6rem;
    box-shadow: 0 24px 60px rgba(0,0,0,0.75), 0 0 0 1px rgba(56,189,248,0.08);
    max-width: 560px;
    width: 100%;
    animation: sipFadeIn 0.3s cubic-bezier(0.175,0.885,0.32,1.275);
  }
  @keyframes sipFadeIn {
    from { opacity:0; transform: translateY(16px) scale(0.96); }
    to   { opacity:1; transform: translateY(0) scale(1); }
  }
  #svc-info-popup-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.12);
    color: #fff;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.2s;
    font-size: 1rem;
    line-height: 1;
  }
  #svc-info-popup-close:hover {
    background: rgba(239,68,68,0.75);
    transform: rotate(90deg);
  }
  .sip-emoji {
    font-size: 2rem;
    line-height: 1;
    margin-bottom: 0.9rem;
    display: block;
  }
  .sip-text {
    font-size: 0.95rem;
    color: rgba(210,225,255,0.92);
    line-height: 1.7;
  }
  .sip-text strong {
    color: #e2e8f0;
    font-weight: 700;
  }
  @media (max-width: 600px) {
    #svc-info-popup-box {
      padding: 1.4rem 1.2rem 1.3rem;
      border-radius: 14px;
    }
    .sip-text { font-size: 0.88rem; }
  }

  /* ── Responsive Overrides ────────────────────────────────── */
  @media (max-width: 768px) {
    .svc-folders-grid {
      gap: 0.5rem;
    }
    .svc-folder-card {
      flex: 1 1 130px;
      min-width: 120px;
      max-width: 180px;
    }
    .svc-folder-card.sfc-active {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .svc-folder-card.sfc-active .svc-folder-panel-inner {
      flex-direction: column;
      gap: 1rem;
    }
    .sfc-panel-info, .sfc-example-wrap {
      flex: none;
      width: 100%;
      min-width: 0;
    }
  }

  @media (max-width: 480px) {
    .svc-folders-grid {
      gap: 0.4rem;
    }
    .svc-folder-card {
      flex: 1 1 calc(50% - 0.4rem);
      max-width: calc(50% - 0.2rem);
      min-width: 0;
    }
    .svc-folder-card.sfc-active {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .svc-folder-name { font-size: 0.78rem; }
    .svc-folder-sub  { font-size: 0.65rem; }
    .svc-folder-header { padding: 0.65rem 0.75rem; gap: 0.45rem; }
    .svc-folder-card.sfc-active .svc-folder-header { padding: 0.75rem; }
    .svc-folder-card.sfc-active .svc-folder-name { font-size: 0.92rem; }
    .svc-folder-panel-inner { padding: 0.85rem 0.9rem 1rem; }
    .sfc-desc { font-size: 0.82rem; }
  }
  .portfolio-item {
    transition: opacity 0.4s ease, transform 0.4s ease;
  }
</style>

    <!-- Info Popup Overlay (Kept for Hero section) -->
    <div id="svc-info-popup-overlay" role="dialog" aria-modal="true" aria-labelledby="sip-title" onclick="closeSvcInfoPopupOnOverlay(event)">
      <div id="svc-info-popup-box">
        <button id="svc-info-popup-close" onclick="closeSvcInfoPopup()" aria-label="<?= e(__('btn_close', 'Bağla')) ?>">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <span class="sip-emoji" aria-hidden="true">💡</span>
        <p class="sip-text" id="sip-title">
          <?= __('svc_info_popup_text', '<strong>Nümunə Layihələr:</strong> Bu bölmədə nümayiş etdirilən xidmətlər və layihə tipləri yalnız təklif etdiyimiz nümunələrdir. Sizin biznesinizin fərdi ehtiyaclarına və xüsusi tələblərinə uyğun olaraq <strong>istənilən fərdi layihə (custom requests) qəbul edilir və sıfırdan eksklüziv dizayn olunur.</strong>') ?>
        </p>
      </div>
    </div>


<script>

  /* ── Sky 1: Service Sequence Controller (Orderly Sequence Navigation) ── */
  function switchSkyService(svcId) {
    if (!svcId) return;
    var btns = document.querySelectorAll('.sky-seq-btn');
    var panels = document.querySelectorAll('.sky-svc-panel');

    btns.forEach(function(btn) {
      var isTarget = btn.getAttribute('data-svc') === svcId;
      btn.classList.toggle('active', isTarget);
      btn.setAttribute('aria-selected', isTarget ? 'true' : 'false');
    });

    panels.forEach(function(panel) {
      var isTarget = panel.getAttribute('data-panel') === svcId;
      panel.classList.toggle('active', isTarget);
    });
  }

  // Safe backward-compatibility fallback wrappers
  function heroToggleSvc() {}
  function heroToggleCard(id) {
    if (id === 'hsvc-web') switchSkyService('web');
    else if (id === 'hsvc-smm') switchSkyService('smm');
    else if (id === 'hsvc-games') switchSkyService('games');
    else if (id === 'hsvc-biz') switchSkyService('biz');
  }

  /* ── Hero Left Card: Accordion Folder Toggle ── */
  function heroFolderToggle(id) {
    var el = document.getElementById(id);
    if (!el) return;
    var isOpen = el.classList.contains('hf-open');
    // Close all others
    document.querySelectorAll('.hf-folder-item').forEach(function(item) {
      item.classList.remove('hf-open');
      var btn = item.querySelector('.hf-folder-trigger');
      if (btn) btn.setAttribute('aria-expanded', 'false');
    });
    if (!isOpen) {
      el.classList.add('hf-open');
      var btn = el.querySelector('.hf-folder-trigger');
      if (btn) btn.setAttribute('aria-expanded', 'true');
    }
  }

  /* ── Projects Section: Service Folder Cards Toggle ── */
  function toggleSvcFolder(id) {
    var el = document.getElementById(id);
    if (!el) return;
    var isOpen = el.classList.contains('sfc-active');
    // Close all
    document.querySelectorAll('.svc-folder-card').forEach(function(c) {
      c.classList.remove('sfc-active');
    });
    if (!isOpen) {
      el.classList.add('sfc-active');
      // Scroll into view on mobile
      if (window.innerWidth < 768) {
        setTimeout(function() {
          el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
      }
    }
  }



  /* ── Toggle Main Service Folders Accordion ── */
  function toggleMainSvcFolders() {
    var collapse = document.getElementById('svc-main-collapse');
    var trigger = document.getElementById('svc-main-trigger-btn');
    if (!collapse || !trigger) return;
    
    var isOpen = collapse.classList.contains('smc-open');
    if (isOpen) {
      collapse.classList.remove('smc-open');
      collapse.classList.remove('smc-entered');
      trigger.classList.remove('smc-active');
      trigger.setAttribute('aria-expanded', 'false');
      // close inner folders as well
      document.querySelectorAll('.svc-folder-card').forEach(function(c) {
        c.classList.remove('sfc-active');
      });
    } else {
      collapse.classList.add('smc-open');
      trigger.classList.add('smc-active');
      trigger.setAttribute('aria-expanded', 'true');
      // Set a timer to remove delays once entrance is done
      setTimeout(function() {
        if (collapse.classList.contains('smc-open')) {
          collapse.classList.add('smc-entered');
        }
      }, 900); // Wait for the longest animation (0.5s delay + 0.4s duration)
    }
  }

  /* ── Info Popup ── */
  function openSvcInfoPopup() {
    var overlay = document.getElementById('svc-info-popup-overlay');
    if (!overlay) return;
    overlay.classList.add('sip-open');
    document.body.style.overflow = 'hidden';
    // Focus close button for accessibility
    setTimeout(function() {
      var closeBtn = document.getElementById('svc-info-popup-close');
      if (closeBtn) closeBtn.focus();
    }, 100);
  }

  function closeSvcInfoPopup() {
    var overlay = document.getElementById('svc-info-popup-overlay');
    if (!overlay) return;
    overlay.classList.remove('sip-open');
    document.body.style.overflow = '';
    // Return focus to trigger button
    var btn = document.getElementById('svc-info-btn');
    if (btn) btn.focus();
  }

  function closeSvcInfoPopupOnOverlay(e) {
    if (e.target === document.getElementById('svc-info-popup-overlay')) {
      closeSvcInfoPopup();
    }
  }

  // Close popup on Escape key
  document.addEventListener('keydown', function(e) {
    if ((e.key === 'Escape' || e.key === 'Esc') &&
        document.getElementById('svc-info-popup-overlay') &&
        document.getElementById('svc-info-popup-overlay').classList.contains('sip-open')) {
      closeSvcInfoPopup();
    }
  });
</script>

<!-- WALKTHROUGH MODAL & SCRIPTS -->
<style>
  .premium-svg {
    width: 100%;
    height: 100%;
    transform-origin: center;
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  .project-card:hover .premium-svg {
    transform: scale(1.08);
  }
  .float-anim-1 { animation: float1 4s ease-in-out infinite; }
  .float-anim-2 { animation: float2 5s ease-in-out infinite alternate; }
  @keyframes float1 {
    0% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0); }
  }
  @keyframes float2 {
    0% { transform: translateY(0) translateX(0); }
    50% { transform: translateY(5px) translateX(5px); }
    100% { transform: translateY(0) translateX(0); }
  }

  .project-card.portfolio-item {
    position: relative;
    border: 1px solid rgba(255,255,255,0.05);
    transition: all 0.3s ease;
  }
  .project-card.portfolio-item:hover {
    border-color: rgba(56, 189, 248, 0.5);
    box-shadow: 0 10px 30px -10px rgba(56, 189, 248, 0.2);
  }
  .demo-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: rgba(56,189,248,0.15);
    border: 1px solid rgba(56,189,248,0.4);
    color: #38bdf8;
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin-top: 1.2rem;
    width: 100%;
  }
  .demo-btn:hover {
    background: rgba(56,189,248,0.3);
    border-color: #38bdf8;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(56, 189, 248, 0.3);
  }
  .demo-btn:active {
    transform: translateY(1px);
  }
  /* Modal Styles */
  .walkthrough-overlay {
    position: fixed;
    inset: 0;
    z-index: 999999;
    background: rgba(8, 12, 30, 0.85);
    backdrop-filter: blur(16px);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.4s ease;
  }
  .walkthrough-overlay.active {
    opacity: 1;
    pointer-events: auto;
  }
  .walkthrough-container {
    width: 90%;
    max-width: 800px;
    background: linear-gradient(145deg, rgba(30,41,59,0.95), rgba(15,23,42,0.98));
    border: 1px solid rgba(56, 189, 248, 0.3);
    border-radius: 20px;
    padding: 2.5rem 2rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
    transform: translateY(30px) scale(0.95);
    transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
  }
  .walkthrough-overlay.active .walkthrough-container {
    transform: translateY(0) scale(1);
  }
  .walkthrough-close {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: #fff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    z-index: 10;
  }
  .walkthrough-close:hover {
    background: rgba(239, 68, 68, 0.8);
    border-color: rgba(239, 68, 68, 1);
    transform: rotate(90deg);
  }
  
  .walkthrough-header {
    margin-bottom: 1.5rem;
    text-align: center;
  }
  .walkthrough-title {
    font-size: 1.8rem;
    color: #fff;
    margin-bottom: 0.5rem;
    font-weight: 700;
  }
  .walkthrough-subtitle {
    color: var(--sky-blue);
    font-size: 1.05rem;
    font-weight: 500;
  }
  
  /* Custom Video Player Styles */
  .video-wrapper {
    position: relative;
    width: 100%;
    border-radius: 12px;
    overflow: hidden;
    background: #000;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    display: flex;
  }
  .video-element {
    width: 100%;
    max-height: 500px;
    object-fit: cover;
    display: block;
  }
  
  /* Video Controls Overlay */
  .video-controls {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
    padding: 20px 15px 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    transition: opacity 0.3s ease;
  }
  .video-wrapper:hover .video-controls,
  .video-wrapper.paused .video-controls {
    opacity: 1;
  }
  
  /* Seek Bar */
  .seek-bar-container {
    width: 100%;
    height: 6px;
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
    cursor: pointer;
    position: relative;
  }
  .seek-bar-fill {
    height: 100%;
    background: var(--sky-blue);
    border-radius: 3px;
    width: 0%;
    pointer-events: none;
    box-shadow: 0 0 8px rgba(56,189,248,0.6);
  }
  
  /* Control Buttons Row */
  .controls-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
  }
  .controls-left, .controls-right {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  .control-btn {
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 5px;
    transition: color 0.2s, transform 0.2s;
  }
  .control-btn:hover {
    color: var(--sky-blue);
    transform: scale(1.1);
  }

  /* Narrow screens (WAP/small phones): the control row used to be wider than
     the video box, so the right-hand buttons were clipped away. */
  @media (max-width: 480px) {
    .video-controls {
      padding: 14px 10px 10px;
      gap: 6px;
    }
    .controls-row {
      flex-wrap: wrap;
      gap: 4px;
    }
    .controls-left,
    .controls-right {
      gap: 6px;
    }
    .control-btn {
      padding: 2px;
    }
    .time-display {
      font-size: 0.72rem;
    }
    .big-play-btn {
      width: 54px;
      height: 54px;
    }
  }
  .time-display {
    color: #e2e8f0;
    font-size: 0.85rem;
    font-family: monospace;
  }
  
  /* Centered Big Play Button */
  .big-play-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 70px;
    height: 70px;
    background: rgba(56, 189, 248, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    border: none;
    box-shadow: 0 0 20px rgba(56,189,248,0.5);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    z-index: 5;
  }
  .big-play-btn:hover {
    transform: translate(-50%, -50%) scale(1.15);
    background: rgba(56, 189, 248, 1);
  }
  .video-wrapper.playing .big-play-btn {
    opacity: 0;
    pointer-events: none;
    transform: translate(-50%, -50%) scale(1.5);
  }
  @media(max-width: 768px) {
    .walkthrough-container { padding: 1.5rem; }
    .walkthrough-title { font-size: 1.4rem; }
  }
</style>

<div class="walkthrough-overlay" id="walkthrough-overlay">
  <div class="walkthrough-container">
    <button class="walkthrough-close" aria-label="<?= e(__('btn_close', 'Bağla')) ?>" onclick="closeWalkthrough()">
      <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
    <div class="walkthrough-header">
      <h3 class="walkthrough-title" id="wt-title">Title</h3>
      <div class="walkthrough-subtitle" id="wt-subtitle">Subtitle</div>
    </div>
    
    <div class="video-wrapper paused" id="custom-video-wrapper">
      <video id="demo-video" class="video-element" playsinline>
        <!-- Source injected by JS -->
      </video>
      
      <button class="big-play-btn" id="big-play-btn" aria-label="Play Video">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" stroke="none" style="margin-left:4px;"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
      </button>

      <div class="video-controls">
        <div class="seek-bar-container" id="seek-bar">
          <div class="seek-bar-fill" id="seek-fill"></div>
        </div>
        <div class="controls-row">
          <div class="controls-left">
            <button class="control-btn" id="play-pause-btn" title="Play/Pause">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
            </button>
            <button class="control-btn" id="rewind-btn" title="Rewind 10s">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 19 2 12 11 5 11 19"></polygon><polygon points="22 19 13 12 22 5 22 19"></polygon></svg>
            </button>
            <button class="control-btn" id="forward-btn" title="Forward 10s">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 19 22 12 13 5 13 19"></polygon><polygon points="2 19 11 12 2 5 2 19"></polygon></svg>
            </button>
            <div class="time-display">
              <span id="current-time">0:00</span> / <span id="duration-time">0:00</span>
            </div>
          </div>
          <div class="controls-right">
            <button class="control-btn" id="mute-btn" title="Mute/Unmute">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>
            </button>
            <button class="control-btn" id="fullscreen-btn" title="Fullscreen">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Placeholder Production Video Assets
const videoConfig = {
    mobile: {
      title: '<?= e(__('video_demo_mobile_title', '"Dönərçi" Cafe & Restoran')) ?>',
      subtitle: '<?= e(__('video_demo_mobile_sub', 'Müştəri Sifariş Təcrübəsi')) ?>',
      videoUrl: 'assets/videos/demo1.mp4',
      posterUrl: 'assets/images/mobile_demo_thumb.png'
    },
    web: {
      title: '<?= e(__('video_demo_web_title', '"EcoMart" E-Ticarət Modulu')) ?>',
      subtitle: '<?= e(__('video_demo_web_sub', 'Alış-Veriş və Yüksək Sürət Təcrübəsi')) ?>',
      videoUrl: 'assets/videos/demo2.mp4',
      posterUrl: 'assets/images/web_demo_thumb.png'
    },
    smm: {
      title: '<?= e(__('video_demo_smm_title', 'SMM & Analitika Paneli')) ?>',
      subtitle: '<?= e(__('video_demo_smm_sub', 'Real-Time Data İzləmə')) ?>',
      videoUrl: 'assets/videos/demo3.mp4',
      posterUrl: 'assets/images/smm_demo_thumb.png'
    },
    game: {
      title: '<?= e(__('video_demo_game_title', 'Gamification (Fırlanan Çarx)')) ?>',
      subtitle: '<?= e(__('video_demo_game_sub', 'İnteraktiv Loyallıq Kampaniyası')) ?>',
      videoUrl: 'assets/videos/demo4.mp4',
      posterUrl: 'assets/images/game_demo_thumb.png'
    }
  };

  const videoEl = document.getElementById('demo-video');
  const videoWrapper = document.getElementById('custom-video-wrapper');
  const playPauseBtn = document.getElementById('play-pause-btn');
  const bigPlayBtn = document.getElementById('big-play-btn');
  const muteBtn = document.getElementById('mute-btn');
  const fullscreenBtn = document.getElementById('fullscreen-btn');
  const rewindBtn = document.getElementById('rewind-btn');
  const forwardBtn = document.getElementById('forward-btn');
  const seekBar = document.getElementById('seek-bar');
  const seekFill = document.getElementById('seek-fill');
  const currentTimeEl = document.getElementById('current-time');
  const durationTimeEl = document.getElementById('duration-time');

  // Format Time Helper
  function formatTime(seconds) {
    if (isNaN(seconds)) return '0:00';
    const m = Math.floor(seconds / 60);
    const s = Math.floor(seconds % 60);
    return m + ':' + (s < 10 ? '0' + s : s);
  }

  // Core Playback Controls
  function togglePlay() {
    if (videoEl.paused || videoEl.ended) {
      videoEl.play();
    } else {
      videoEl.pause();
    }
  }

  function updatePlayState() {
    if (videoEl.paused || videoEl.ended) {
      videoWrapper.classList.remove('playing');
      videoWrapper.classList.add('paused');
      playPauseBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>';
    } else {
      videoWrapper.classList.add('playing');
      videoWrapper.classList.remove('paused');
      playPauseBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="none"><rect x="6" y="4" width="4" height="16"></rect><rect x="14" y="4" width="4" height="16"></rect></svg>';
    }
  }

  function openWalkthrough(category) {
    const data = videoConfig[category];
    if (!data) return;
    
    document.getElementById('wt-title').textContent = data.title;
    document.getElementById('wt-subtitle').textContent = data.subtitle;
    
    videoEl.src = data.videoUrl;
    videoEl.poster = data.posterUrl;
    videoEl.load();
    
    document.getElementById('walkthrough-overlay').classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeWalkthrough() {
    document.getElementById('walkthrough-overlay').classList.remove('active');
    document.body.style.overflow = '';
    videoEl.pause();
    videoEl.currentTime = 0;
  }

  // Event Listeners for Video UI
  playPauseBtn.addEventListener('click', togglePlay);
  bigPlayBtn.addEventListener('click', togglePlay);
  videoEl.addEventListener('click', togglePlay);
  videoEl.addEventListener('play', updatePlayState);
  videoEl.addEventListener('pause', updatePlayState);

  videoEl.addEventListener('timeupdate', () => {
    const percent = (videoEl.currentTime / videoEl.duration) * 100;
    seekFill.style.width = percent + '%';
    currentTimeEl.textContent = formatTime(videoEl.currentTime);
  });

  videoEl.addEventListener('loadedmetadata', () => {
    durationTimeEl.textContent = formatTime(videoEl.duration);
    seekFill.style.width = '0%';
  });

  seekBar.addEventListener('click', (e) => {
    const rect = seekBar.getBoundingClientRect();
    const pos = (e.clientX - rect.left) / rect.width;
    videoEl.currentTime = pos * videoEl.duration;
  });

  rewindBtn.addEventListener('click', () => {
    videoEl.currentTime = Math.max(0, videoEl.currentTime - 10);
  });

  forwardBtn.addEventListener('click', () => {
    videoEl.currentTime = Math.min(videoEl.duration, videoEl.currentTime + 10);
  });

  muteBtn.addEventListener('click', () => {
    videoEl.muted = !videoEl.muted;
    if (videoEl.muted) {
      muteBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>';
    } else {
      muteBtn.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>';
    }
  });

  fullscreenBtn.addEventListener('click', () => {
    if (!document.fullscreenElement) {
      if (videoWrapper.requestFullscreen) {
        videoWrapper.requestFullscreen();
      } else if (videoWrapper.webkitRequestFullscreen) { /* Safari */
        videoWrapper.webkitRequestFullscreen();
      } else if (videoWrapper.msRequestFullscreen) { /* IE11 */
        videoWrapper.msRequestFullscreen();
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
      }
    }
  });
</script>

</main>

<?php
/* ── Footer daxilində partner brendlər ────────────────────────
   Publik ziyarətçi yalnız admin «Saytda göstər» etdikdə görür.
   Admin isə bölmə gizli olsa da görür və idarəetmə düymələri alır.
   ───────────────────────────────────────────────────────────── */
require_once __DIR__ . '/config/admin.php';
require_once __DIR__ . '/config/partners.php';

$skyPartnerAdmin   = sky_admin_is_logged_in();
if ($skyPartnerAdmin) {
    // Aktiv baxış zamanı sessiyanın vaxtını yenilə (idle timeout-a düşməsin)
    sky_admin_touch();
}
$skyPartnerStore   = sky_partners_load();
$skyPartnerVisible = !empty($skyPartnerStore['visible']);
$skyPartnerPublic  = sky_partners_public_items();
$skyPartnerList    = $skyPartnerAdmin ? $skyPartnerStore['items'] : $skyPartnerPublic;
$skyPartnerShow    = $skyPartnerAdmin || $skyPartnerPublic !== [];
$skyPartnerActive  = count($skyPartnerPublic);
$skyPartnerFlash   = $skyPartnerAdmin ? sky_partners_take_flash() : [];
?>

<!-- ════════════════════════════════════════════════════════════
     FOOTER
════════════════════════════════════════════════════════════ -->
<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="footer-grid <?= $skyPartnerShow ? 'has-partners' : 'no-partners' ?>">

      <div class="footer-brand">
        <a href="<?= SITE_URL ?>" class="logo" style="display:inline-flex;margin-bottom:.5rem;">
          <div class="logo-icon" aria-hidden="true" style="height:36px;">
            <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <linearGradient id="skyLogoGradFooter" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#ffffff" />
                  <stop offset="100%" stop-color="var(--neon-cyan)" />
                </linearGradient>
                <linearGradient id="skySGradFooter" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#38bdf8" />
                  <stop offset="100%" stop-color="#0284c7" />
                </linearGradient>
                <filter id="skyLogoGlowFooter" x="-20%" y="-20%" width="140%" height="140%">
                  <feGaussianBlur stdDeviation="3" result="blur" />
                  <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                  </feMerge>
                </filter>
              </defs>
              <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skySGradFooter)" />
              <g filter="url(#skyLogoGlowFooter)">
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
          <span class="logo-text" style="font-size:1.2rem;"><span class="logo-sky">sky</span><span class="logo-web">web</span><span class="dot-az">.az</span></span>
        </a>
        <p><?= e(__('footer_brand_desc', 'Azərbaycanın yeni nəsil rəqəmsal ekosistemi. Biznes həlləri, ağıllı CV və gamification — hamısı bir platformada.')) ?></p>

      </div>

      <?php if ($skyPartnerShow): ?>
      <section class="footer-partners<?= $skyPartnerAdmin && !$skyPartnerVisible ? ' is-hidden' : '' ?>" id="partners" aria-labelledby="partners-title">
        <div class="footer-partners-head">
          <h4 class="footer-col-title" id="partners-title"><?= e(__('partners_footer_title', 'Partnyor brendlər')) ?></h4>

          <?php if ($skyPartnerAdmin): ?>
          <div class="footer-partners-admin">
            <details class="fp-add-wrap">
              <summary class="fp-admin-btn fp-admin-btn-add">+ Brend Əlavə Et</summary>
              <form class="fp-add-form" method="post" action="admin/partner-action.php" enctype="multipart/form-data">
                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                <input type="hidden" name="action" value="add">

                <label class="fp-field">
                  <span>Brend adı</span>
                  <input type="text" name="name" maxlength="120" placeholder="Məs: Bravo Supermarket">
                </label>
                <label class="fp-field">
                  <span>Loqo (PNG/JPG/WEBP/GIF)</span>
                  <input type="file" name="logo" accept="image/png,image/jpeg,image/webp,image/gif">
                </label>
                <label class="fp-field">
                  <span>Vebsayt (istəyə bağlı)</span>
                  <input type="url" name="url" maxlength="300" placeholder="https://brend.az">
                </label>

                <button type="submit" class="fp-admin-btn fp-admin-btn-primary">Brendi əlavə et</button>
              </form>
            </details>

            <form method="post" action="admin/partner-action.php" class="fp-toggle-form">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="action" value="toggle">
              <input type="hidden" name="visible" value="<?= $skyPartnerVisible ? '0' : '1' ?>">
              <button type="submit" class="fp-admin-btn <?= $skyPartnerVisible ? 'fp-admin-btn-on' : 'fp-admin-btn-off' ?>">
                <?= $skyPartnerVisible ? 'Saytda gizlət' : 'Saytda göstər' ?>
              </button>
            </form>
          </div>
          <?php endif; ?>
        </div>

        <?php if ($skyPartnerAdmin): ?>
        <div class="fp-admin-note">
          <?php if (!$skyPartnerVisible): ?>
            Bölmə gizlidir — ziyarətçilər görmür.
          <?php elseif ($skyPartnerActive === 0): ?>
            Bölmə aktivdir, lakin aktiv brend yoxdur.
          <?php else: ?>
            Saytda <?= (int) $skyPartnerActive ?> brend görünür.
          <?php endif; ?>
        </div>

        <?php foreach ($skyPartnerFlash as $fpFlash): ?>
          <div class="fp-flash fp-flash-<?= e((string) $fpFlash['type']) ?>"><?= e((string) $fpFlash['message']) ?></div>
        <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($skyPartnerList): ?>
        <ul class="footer-partners-grid" role="list">
          <?php foreach ($skyPartnerList as $partner): ?>
            <?php
              $pName = (string) ($partner['name'] ?? '');
              $pLogo = sky_partner_logo_url((string) ($partner['logo'] ?? ''));
              $pUrl  = (string) ($partner['url'] ?? '');
              $pTag  = $pUrl !== '' ? 'a' : 'span';
              $pOff  = $skyPartnerAdmin && empty($partner['visible']);
            ?>
            <li class="footer-partner<?= $pOff ? ' is-off' : '' ?>">
              <<?= $pTag ?> class="footer-partner-inner"<?php if ($pTag === 'a'): ?> href="<?= e($pUrl) ?>" target="_blank" rel="noopener noreferrer nofollow"<?php endif; ?>>
                <?php if ($pLogo !== ''): ?>
                  <img src="<?= e($pLogo) ?>" alt="" class="footer-partner-logo" loading="lazy" decoding="async">
                <?php else: ?>
                  <span class="footer-partner-initials" aria-hidden="true"><?= e(sky_partner_initials($pName)) ?></span>
                <?php endif; ?>
                <?php if ($pName !== ''): ?>
                  <span class="footer-partner-name"><?= e($pName) ?></span>
                <?php endif; ?>
              </<?= $pTag ?>>
              <?php if ($skyPartnerAdmin): ?>
              <div class="fp-item-actions">
                <form method="post" action="admin/partner-action.php" class="fp-item-form">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="toggle_item">
                  <input type="hidden" name="id" value="<?= e((string) ($partner['id'] ?? '')) ?>">
                  <button type="submit" class="fp-chip-btn" title="<?= $pOff ? 'Saytda göstər' : 'Saytda gizlət' ?>">
                    <?= $pOff ? 'Göstər' : 'Gizlət' ?>
                  </button>
                </form>
                <form method="post" action="admin/partner-action.php" class="fp-item-form"
                      onsubmit="return confirm('«<?= e($pName !== '' ? $pName : 'Brend') ?>» silinsin?');">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= e((string) ($partner['id'] ?? '')) ?>">
                  <button type="submit" class="fp-chip-btn fp-chip-btn-del" title="Brendi sil">Sil</button>
                </form>
              </div>
              <?php endif; ?>
              <?php if ($pOff): ?><span class="fp-item-badge">gizli</span><?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php elseif ($skyPartnerAdmin): ?>
        <p class="footer-partners-empty">Hələ brend yoxdur — «+ Brend Əlavə Et» ilə başlayın.</p>
        <?php endif; ?>
      </section>
      <?php endif; ?>

      <div>
        <h4 class="footer-col-title"><?= e(__('nav_about', 'Haqqımızda')) ?></h4>
        <ul class="footer-col-links">
          <li><a href="#contact"><?= e(__('nav_contact', 'Əlaqə')) ?></a></li>
          <li><a href="#services" onclick="if(typeof openWebServicesModal==='function'){openWebServicesModal();return false;}"><?= e(__('footer_link_projects', 'Layihələrimiz')) ?></a></li>
          <li><a href="privacy.php"><?= e(__('footer_privacy', 'Gizlilik Siyasəti')) ?></a></li>
          <li><a href="terms.php"><?= e(__('footer_terms', 'İstifadə Şərtləri')) ?></a></li>
          <li><a href="faq.php"><?= e(__('nav_faq', 'FAQ')) ?></a></li>
          <li><a href="blog.php"><?= e(__('nav_blog', 'Blog')) ?></a></li>
        </ul>
      </div>

    </div>

    <!-- Footer Welcome & Platforms --><!-- TEST_MARKER_FOOTER_WELCOME -->
    
    <div class="footer-welcome-section" aria-labelledby="footer-welcome-title">
      <div class="footer-welcome-content">
        <h3 id="footer-welcome-title" class="footer-welcome-title"><?= e(__('footer_welcome', 'Skyweb-ə xoş gəlmisiniz!')) ?></h3>
        <p class="footer-welcome-subtitle"><?= e(__('footer_welcome_subtitle', 'Rəqəmsal imkanlarınızı kəşf etməyə başlayın.')) ?></p>
      </div>
      <div class="footer-platforms" role="list" aria-label="<?= e(__('aria_platforms', 'Platform seçimləri')) ?>">
        <!-- Wap Platform -->
        <a href="<?= SKY_LINK_WAP ?>" class="footer-platform-btn wap" aria-label="<?= e(__('footer_platform_wap', 'Wap Tətbiqi')) ?>" target="_blank" rel="noopener">
          <span class="footer-platform-icon" aria-hidden="true">
            <svg class="footer-svg phone-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
              <rect class="phone-body" x="5" y="2" width="14" height="20" rx="2" ry="2" />
              <path class="phone-notch" d="M10 2a1 1 0 0 1 1 1v0.5a0.5 0.5 0 0 0 0.5 0.5h1a0.5 0.5 0 0 0 0.5-0.5V3a1 1 0 0 1 1-1" stroke-width="1" />
              <circle class="phone-btn" cx="12" cy="19" r="1" />
              <path class="phone-screen-lines" d="M8 7h8M8 11h5M8 15h3" opacity="0.5" stroke-width="1.5" />
            </svg>
          </span>
          <span class="footer-platform-label"><?= e(__('footer_platform_wap', 'Wap Tətbiqi')) ?></span>
        </a>

        <!-- Web Platform -->
        <a href="<?= SKY_LINK_WEB ?>" class="footer-platform-btn web" aria-label="<?= e(__('footer_platform_web', 'Web Tətbiqi')) ?>" target="_blank" rel="noopener">
          <span class="footer-platform-icon" aria-hidden="true">
            <svg class="footer-svg laptop-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
              <rect class="laptop-screen" x="3" y="4" width="18" height="12" rx="2" ry="2" />
              <line class="laptop-base" x1="1" y1="19" x2="23" y2="19" />
              <line class="laptop-trackpad" x1="10" y1="19" x2="14" y2="19" stroke-width="3" />
              <path class="laptop-glow-rect" d="M6 7h12v6H6z" opacity="0.3" stroke-width="1" />
            </svg>
          </span>
          <span class="footer-platform-label"><?= e(__('footer_platform_web', 'Web Tətbiqi')) ?></span>
        </a>

        <!-- Google Play Platform -->
        <a href="<?= SKY_LINK_PLAY ?>" class="footer-platform-btn android" aria-label="<?= e(__('footer_platform_android', 'Google Play')) ?>" target="_blank" rel="noopener noreferrer">
          <span class="footer-platform-icon" aria-hidden="true">
            <svg class="footer-svg play-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path class="play-path" d="M19.14 10.22L6.14 2.8c-.89-.51-2.02.13-2.02 1.16v16.08c0 1.03 1.13 1.67 2.02 1.16L19 13.68c.84-.49.84-1.7 0-2.18z" fill="currentColor" />
              <path class="play-inner-glow" d="M4.12 3.96L12.5 12 4.12 20.04V3.96z" fill="#ffffff" opacity="0.1" />
            </svg>
          </span>
          <span class="footer-platform-label"><?= e(__('footer_platform_android', 'Google Play')) ?></span>
        </a>

        <!-- App Store Platform -->
        <a href="<?= SKY_LINK_APPLE ?>" class="footer-platform-btn ios" aria-label="<?= e(__('footer_platform_ios', 'App Store')) ?>" target="_blank" rel="noopener noreferrer">
          <span class="footer-platform-icon" aria-hidden="true">
            <svg class="footer-svg apple-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path class="apple-path" d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.21.67-2.93 1.49-.62.69-1.16 1.84-1.01 2.96 1.12.09 2.27-.58 2.95-1.39z" fill="currentColor" />
            </svg>
          </span>
          <span class="footer-platform-label"><?= e(__('footer_platform_ios', 'App Store')) ?></span>
        </a>
      </div>
    </div>

    <div class="footer-bottom">
      <span>© <?= date('Y') ?> <?= SITE_NAME ?>. <?= e(__('footer_rights', 'Bütün hüquqlar qorunur.')) ?></span>
      <div class="footer-bottom-links">
        <a href="privacy.php"><?= e(__('footer_privacy', 'Gizlilik')) ?></a>
        <a href="terms.php"><?= e(__('footer_terms', 'Şərtlər')) ?></a>
        <a href="#contact"><?= e(__('nav_contact', 'Əlaqə')) ?></a>
        <a href="admin/" class="footer-admin-link" rel="nofollow"><?= e(__('footer_admin_link', 'Admin')) ?></a>
      </div>
    </div>
  </div>
</footer>

<!-- Registration / Contact Modal -->
<div id="register-modal" class="sky-modal" aria-hidden="true" role="dialog" aria-labelledby="modal-title">
  <div class="sky-modal-overlay" tabindex="-1"></div>
  <div class="sky-modal-container">
    <div class="sky-modal-content glass-card">
      <button class="sky-modal-close" id="btn-modal-close" aria-label="<?= e(__('btn_close', 'Bağla')) ?>">&times;</button>
      
      <div class="contact-grid" style="margin-top: 1rem;">
        <!-- Contact Info -->
        <div>
          <h3 class="contact-info-title" id="modal-title"><?= e(__('contact_modal_title', 'Sizi dinləməyə hazırıq')) ?> <span class="waving-hand">👋</span></h3>
          <p class="contact-info-desc">
            <?= e(__('contact_modal_desc', 'İstənilən sualınızı, ideya və təklifinizi mesaj bölməsindən ünvanlaya bilərsiniz. Müraciətiniz 24 saat ərzində cavablandırılacaq.')) ?>
          </p>
          <div class="contact-item">
            <div class="contact-item-icon" aria-hidden="true">
              <svg class="modern-contact-icon email-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
              </svg>
            </div>
            <a href="mailto:<?= SITE_EMAIL ?>" class="contact-link"><?= SITE_EMAIL ?></a>
          </div>
          <div class="contact-item">
            <div class="contact-item-icon" aria-hidden="true">
              <svg class="modern-contact-icon phone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
              </svg>
            </div>
            <a href="tel:+994550000000" class="contact-link"><?= SITE_PHONE ?></a>
          </div>
          <div class="contact-item">
            <div class="contact-item-icon whatsapp-icon-box" aria-hidden="true">
              <svg class="modern-contact-icon whatsapp-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.746.953 3.71 1.455 5.703 1.456h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </div>
            <a href="https://wa.me/994550000000" target="_blank" rel="noopener noreferrer" class="contact-link"><?= SITE_PHONE ?></a>
          </div>
          <div class="contact-item">
            <div class="contact-item-icon" aria-hidden="true">
              <svg class="modern-contact-icon location-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
            </div>
            <span class="contact-link" style="cursor: default;"><?= e(__('contact_address', 'Bakı, Azərbaycan')) ?></span>
          </div>
          <div class="contact-item">
            <div class="contact-item-icon" aria-hidden="true">
              <svg class="modern-contact-icon clock-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
              </svg>
            </div>
            <span class="contact-link" style="cursor: default;"><?= e(__('contact_hours', 'B.e – C: 09:00 – 20:00')) ?></span>
          </div>
        </div>

        <!-- Contact/Registration Form -->
        <div>
          <form id="contact-form" class="sky-form" novalidate>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

            <div class="form-row">
              <div class="form-group">
                <label class="form-label" for="contact-name"><?= e(__('contact_name', 'Ad Soyad *')) ?></label>
                <input type="text" id="contact-name" name="name" class="form-input"
                       placeholder="<?= e(__('contact_name_ph', 'Əli Həsənov')) ?>" required minlength="2">
              </div>
              <div class="form-group">
                <label class="form-label" for="contact-phone"><?= e(__('contact_phone', 'Telefon *')) ?></label>
                <input type="tel" id="contact-phone" name="phone" class="form-input"
                       placeholder="+994 55 000 00 00" required>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-email"><?= e(__('auth_email', 'E-poçt ünvanı')) ?></label>
              <input type="email" id="contact-email" name="email" class="form-input"
                     placeholder="ali@example.com">
            </div>

            <div class="form-group">
              <label class="form-label" style="margin-bottom: 0.5rem;"><?= e(__('contact_service', 'Hansı xidmətlərimizdən yararlanmaq istəyirsiniz?')) ?></label>
              <div class="custom-select-wrapper" id="custom-service-wrapper">
                <div class="custom-select-trigger" id="custom-service-trigger" tabindex="0" role="combobox" aria-expanded="false" aria-haspopup="listbox" aria-controls="custom-service-options">
                  <span class="custom-select-selected-icon"></span>
                  <span class="custom-select-trigger-text">— <span data-i18n="contact_service_select" data-sky-no-translate><?= e(__('contact_service_select', 'Seçin')) ?></span> —</span>
                  <svg class="custom-select-arrow" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </div>
                <div class="custom-options-container" id="custom-service-options" role="listbox">
                  <div class="custom-option" data-value="" role="option" aria-selected="false">
                    <span class="custom-option-text">— <?= e(__('contact_service_select', 'Seçin')) ?> —</span>
                  </div>

                </div>
              </div>
              <input type="hidden" name="service" id="contact-service" value="">
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-message"><?= e(__('contact_message', 'Mesajınız')) ?></label>
              <textarea id="contact-message" name="message" class="form-textarea"
                        placeholder="<?= e(__('contact_message_ph', 'Layihəniz haqqında qısaca məlumat verin...')) ?>"></textarea>
            </div>

            <button type="submit" class="btn-primary" id="btn-contact-submit" style="width:100%;justify-content:center;">
              <span><?= e(__('contact_btn_submit', 'Müraciəti Göndər')) ?></span>
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ════════════════════════════════════════════════════════════
     INFO GUIDE MODAL (Freelance & Biznes tabs)
════════════════════════════════════════════════════════════ -->
<div id="info-modal" class="sky-modal" aria-hidden="true" role="dialog" aria-labelledby="info-modal-title">
  <div class="sky-modal-overlay" tabindex="-1" onclick="closeInfoModal()"></div>
  <div class="sky-modal-container" style="max-width:760px;">
    <div class="sky-modal-content glass-card" style="padding:2rem;">
      <button class="sky-modal-close" id="btn-info-modal-close" aria-label="<?= e(__('btn_close', 'Bağla')) ?>" onclick="closeInfoModal()">&#215;</button>

      <!-- BUSINESS TAB CONTENT -->
      <div class="info-tab-content active" id="content-business">
        <div class="info-article">
          <div class="info-article-header">
            <div class="info-article-icon indigo">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v4H3z"/><path d="M3 10h18v11H3z"/><path d="M9 10v11M15 10v11"/></svg>
            </div>
            <div>
              <h3 class="info-article-title"><?= e(__('business_modal_title', 'Biznesinizi Skyweb ilə Böyüdün')) ?></h3>
              <p class="info-article-subtitle"><?= e(__('business_modal_subtitle', 'Rəqəmsal dünyada güclü yer tutmaq üçün lazım olan hər şey bir platformada')) ?></p>
            </div>
          </div>

          <p class="info-article-lead" data-i18n-html="business_modal_lead"><?= __('business_modal_lead', 'Bugün Azərbaycanda hər 10 biznesdən 7-si rəqəmsal mövcudluğu olmadığı üçün müştəri itirir. Onlayn görünmək artıq seçim deyil — <strong>zərurətdir.</strong> Skyweb sizin biznesinizin inkişafı üçün bütün rəqəmsal prosesləri uçdən uca həll edir.') ?></p>

          <div class="info-steps">
            <div class="info-step">
              <div class="info-step-num">01</div>
              <div>
                <strong><?= __('business_modal_step1_title', '🌐 Peşəkar Veb-sayt &amp; Mobil Tətbiq Həlləri') ?></strong>
                <p><?= e(__('business_modal_step1_desc', 'Gözəllik salonları, butiklər, fitnes salonları, idman zalları və növləri, apteklər, həkim və tibbi xidmət sahələri, marketlər və bir çox digər iaşə obyektləri üçün xüsusi Android, iOS tətbiqlərinin və peşəkar veb-saytların hazırlanmasını təmin edirik. Müştəriləriniz rahatlıqla onlayn sifariş verə və rezervasiya edə biləcəklər.')) ?></p>
              </div>
            </div>
            <div class="info-step">
              <div class="info-step-num">02</div>
              <div>
                <strong><?= __('business_modal_step2_title', '📊 Hədəfli Reklam &amp; SMM İdarəetməsi') ?></strong>
                <p><?= e(__('business_modal_step2_desc', 'Meta Ads, Google Ads, TikTok Ads — düzgün hədəf auditoriyasına, düzgün vaxtda, düzgün mesajla çatdırırıq. Ortalama investisiya geri dönüşü x3–x8 arasındadır. Biznesinizin böyüməsini real zamanlı data ilə izləyir və strategiyanı daim optimallaşdırırıq.')) ?></p>
              </div>
            </div>
            <div class="info-step">
              <div class="info-step-num">03</div>
              <div>
                <strong><?= __('business_modal_step3_title', '🎮 Gamification — Müştəri Loyallığını Artır') ?></strong>
                <p><?= e(__('business_modal_step3_desc', 'Fırlanan çarx, viktorina, mini slot, tapmaca oyunları — müştəriniz əylənir, siz isə brend loyallığı qazanırsınız. İnteraktiv oyunlar müştərini biznesimizdə saxlayır, təkrar müraciəti artırır və rəqiblərdən fərqləndirir.')) ?></p>
              </div>
            </div>
            <div class="info-step">
              <div class="info-step-num">04</div>
              <div>
                <strong><?= __('business_modal_step4_title', '🛡️ Kompleks &amp; Davamlı Dəstək') ?></strong>
                <p><?= e(__('business_modal_step4_desc', 'Layihə bitdikdən sonra da yanınızdayıq. Texniki dəstək, kontent hazırlanması, reklam optimallaşdırması, analitika hesabatları — hamısını biz həll edirik. Bir nöqtəyə zəng edirsiniz, qalan hər şey Skyweb öhdəsindədir.')) ?></p>
              </div>
            </div>
          </div>

          <div class="info-advantages">
            <h4 class="info-services-title"><?= e(__('business_modal_adv_title', 'Niyə məhz Skyweb?')) ?></h4>
            <ul class="info-adv-list">
              <li><span class="adv-check">✓</span> <span data-i18n-html="business_modal_adv_1"><?= __('business_modal_adv_1', '<strong>Yerli bazarı tanıyırıq</strong> — Azərbaycan müştəri davranışına uyğun, Azərbaycan dilini düzgün istifadə edən həllər hazırlayırıq') ?></span></li>
              <li><span class="adv-check">✓</span> <span data-i18n-html="business_modal_adv_2"><?= __('business_modal_adv_2', '<strong>Sərfəli &amp; şəffaf qiymətlər</strong> — xarici agentliklərin 3–5 dəfə aşağı qiymətinə eyni keyfiyyət, heç bir gizli ödəniş yoxdur') ?></span></li>
              <li><span class="adv-check">✓</span> <span data-i18n-html="business_modal_adv_3"><?= __('business_modal_adv_3', '<strong>Sürətli icra</strong> — standart layihə 7–21 iş günü ərzində hazır olur, müştəri hər mərhələni izləyir') ?></span></li>
              <li><span class="adv-check">✓</span> <span data-i18n-html="business_modal_adv_4"><?= __('business_modal_adv_4', '<strong>Nəticə əsaslı ödəniş</strong> — işi tam qəbul edib razı qaldıqdan sonra ödəniş aparılır, tam zəmanət verilir') ?></span></li>
              <li><span class="adv-check">✓</span> <span data-i18n-html="business_modal_adv_5"><?= __('business_modal_adv_5', '<strong>End-to-end xidmət</strong> — sayt, tətbiq, reklam, analitika, oyun — hamısı bir komandadan, bir koordinasiyada') ?></span></li>
            </ul>
          </div>

          <a href="#contact" class="btn-primary info-cta-btn" onclick="closeInfoModal()">
            <span><?= e(__('business_modal_cta', 'Pulsuz Məsləhət Al →')) ?></span>
          </a>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════
     MODAL 1: WEB SERVICES SHOWCASE (11 DEMOS)
══════════════════════════════════════════════ -->
<div class="sky-demos-modal-overlay" id="web-services-modal-overlay" aria-modal="true" role="dialog" aria-labelledby="web-services-modal-title" onclick="if(event.target===this)closeWebServicesModal()">
  <div class="sky-demos-modal" id="web-services-modal">
    <div class="sky-demos-header">
      <div>
        <div style="font-size:0.75rem; font-weight:800; color:var(--neon-cyan); letter-spacing:0.08em; text-transform:uppercase;" data-i18n="demos_modal_kicker"><?= e(__('demos_modal_kicker', '✨ 11 İNTERAKTİV DEMO PORTFELİ')) ?></div>
        <h3 class="sky-demos-title" id="web-services-modal-title" data-i18n="demos_modal_title"><?= e(__('demos_modal_title', 'Veb Sayt & Rəqəmsal Xidmətlər')) ?></h3>
        <p class="sky-demos-desc" data-i18n="demos_modal_sub"><?= e(__('demos_modal_sub', 'Geyim, yemək, WhatsApp ticarət, aptek, tibbi xidmətlər, gözəllik, idman, video prodakşn və təhsil üçün canlı interaktiv satış saytları')) ?></p>
      </div>
      <button class="sky-demos-close" onclick="closeWebServicesModal()" aria-label="<?= e(__('btn_close', 'Bağla')) ?>">&times;</button>
    </div>

    <!-- Category Filter Tabs -->
    <div class="sky-demos-filters">
      <button type="button" class="sky-demo-filter-btn active" onclick="filterDemoCategories('all', this)" data-i18n="proj_filter_all"><?= e(__('proj_filter_all', 'Hamısı')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('ecommerce', this)" data-i18n="proj_filter_ecommerce"><?= e(__('proj_filter_ecommerce', 'E-Ticarət')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('food', this)" data-i18n="proj_filter_food"><?= e(__('proj_filter_food', 'Restoran & Kafe')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('health', this)" data-i18n="proj_filter_health"><?= e(__('proj_filter_health', 'Aptek & Tibb')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('lifestyle', this)" data-i18n="proj_filter_lifestyle"><?= e(__('proj_filter_lifestyle', 'Gözəllik & İdman')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('edu', this)" data-i18n="proj_filter_edu"><?= e(__('proj_filter_edu', 'Təhsil & Media')) ?></button>
      <button type="button" class="sky-demo-filter-btn" onclick="filterDemoCategories('property', this)" data-i18n="proj_filter_property"><?= e(__('proj_filter_property', 'Daşınmaz Əmlak')) ?></button>
    </div>

    <!-- 11 demo cards — rendered from $SKY_WEB_DEMOS (single source of truth) -->
    <div class="sky-demos-body" id="sky-demos-body">
      <?php foreach ($SKY_WEB_DEMOS as $demo): ?>
        <?php
          $demoHref = 'modules/web-demos/' . $demo['file'] . '?lang=' . rawurlencode(current_lang());
          $demoName = __($demo['title'][0], $demo['title'][1]);
        ?>
        <article class="sky-demo-item" data-category="<?= e(implode(' ', $demo['cats'])) ?>" style="--card-accent: <?= e($demo['accent']) ?>;">
          <div class="sky-demo-media">
            <img src="<?= e($demo['img']) ?>" alt="<?= e($demoName) ?>" loading="lazy" width="900" height="600">
            <div class="sky-demo-overlay"></div>
            <span class="sky-demo-live"><i aria-hidden="true"></i><span data-i18n="proj_live"><?= e(__('proj_live', 'Canlı demo')) ?></span></span>
            <span class="sky-demo-media-badge" data-i18n="<?= e($demo['badge'][0]) ?>"><?= e(__($demo['badge'][0], $demo['badge'][1])) ?></span>
            <div class="sky-demo-media-icon" aria-hidden="true"><?= $demo['icon'] ?></div>
          </div>
          <div class="sky-demo-content">
            <h4 class="sky-demo-name" data-i18n="<?= e($demo['title'][0]) ?>"><?= e($demoName) ?></h4>
            <p class="sky-demo-summary" data-i18n="<?= e($demo['desc'][0]) ?>"><?= e(__($demo['desc'][0], $demo['desc'][1])) ?></p>
            <div class="sky-demo-result">
              <span class="sky-demo-result-ico" aria-hidden="true">⚡</span>
              <span data-i18n="<?= e($demo['result'][0]) ?>"><?= e(__($demo['result'][0], $demo['result'][1])) ?></span>
            </div>
            <div class="sky-demo-actions">
              <a href="<?= e($demoHref) ?>" target="_blank" rel="noopener" class="sky-demo-btn-open">
                <span data-i18n="demos_btn_preview"><?= e(__('demos_btn_preview', 'Demoya bax')) ?></span> <span aria-hidden="true">➔</span>
              </a>
              <button type="button" class="sky-demo-btn-order" onclick="closeWebServicesModal(); if(typeof openModal==='function')openModal(event);" data-i18n="demos_btn_order"><?= e(__('demos_btn_order', 'Sifariş Et')) ?></button>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
    <!-- Modal Footer -->
    <div class="sky-demos-footer">
      <div>
        <span style="font-weight:700; color:#fff;" data-i18n="demos_modal_footer_q"><?= e(__('demos_modal_footer_q', 'Öz Biznesiniz Üçün Belə Bir Sayt İstəyirsiniz?')) ?></span>
        <span style="color:var(--text-muted); font-size:0.8rem; margin-left:0.5rem;" data-i18n="demos_modal_footer_sub"><?= e(__('demos_modal_footer_sub', 'Sıfırdan brendinizə uyğun eksklüziv dizayn və texniki icra.')) ?></span>
      </div>
      <button type="button" class="btn-primary btn-open-modal" onclick="closeWebServicesModal(); if(typeof openModal==='function')openModal();" style="padding:0.55rem 1.25rem; font-size:0.85rem; border-radius:8px;">
        <span data-i18n="demos_modal_footer_btn"><?= e(__('demos_modal_footer_btn', 'Bizimlə Əlaqə Saxlayın →')) ?></span>
      </button>
    </div>
  </div>
</div>

<!-- ══════════════════════════════════════════════
     MODAL 2: OUR PROJECTS (PROPOSED / PORTFOLIO)
══════════════════════════════════════════════ -->
<div class="sky-demos-modal-overlay" id="our-projects-modal-overlay" aria-modal="true" role="dialog" aria-labelledby="our-projects-modal-title" onclick="if(event.target===this)closeOurProjectsModal()">
  <div class="sky-demos-modal sky-proj-modal" id="our-projects-modal">
    <div class="sky-demos-header" style="border-bottom-color: rgba(168, 85, 247, 0.2);">
      <div>
        <div style="font-size:0.72rem; font-weight:700; color:#c084fc; letter-spacing:0.08em; text-transform:uppercase;" data-i18n="projects_modal_kicker"><?= e(__('projects_modal_kicker', '🚀 RƏSMİ ARXİV & GƏLƏCƏK LAYİHƏLƏR')) ?></div>
        <h3 class="sky-demos-title" id="our-projects-modal-title" data-i18n="projects_modal_title"><?= e(__('projects_modal_title', 'Təklif Olunan Layihələr & Portfel')) ?></h3>
        <p class="sky-demos-desc" data-i18n="projects_modal_desc"><?= e(__('projects_modal_desc', 'Bu bölmə Skyweb tərəfindən tamamlanmış real müştəri vebsaytlarının və fərdi platformaların rəsmi arxivi üçün hazırlanmışdır. Yeni layihələr əlavə olunduqca burada nümayiş ediləcəkdir.')) ?></p>
      </div>
      <button class="sky-demos-close" onclick="closeOurProjectsModal()" aria-label="<?= e(__('btn_close', 'Bağla')) ?>">&times;</button>
    </div>

    <div style="padding: 1.75rem; display: flex; flex-direction: column; gap: 1.25rem;">
      <div style="background: rgba(168, 85, 247, 0.05); border: 1px dashed rgba(168, 85, 247, 0.35); border-radius: 14px; padding: 1.5rem; text-align: center;">
        <div style="font-size: 2.2rem; margin-bottom: 0.5rem;">📂</div>
        <div style="font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 0.35rem;" data-i18n="hero_tab_projects_title"><?= e(__('hero_tab_projects_title', 'Təklif Olunan Layihələr')) ?></div>
        <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; max-width: 480px; margin: 0 auto 1rem auto;" data-i18n="hero_tab_projects_desc">
          <?= e(__('hero_tab_projects_desc', 'Tamamlanan müştəri saytları və gələcək rəqəmsal layihələrimiz tezliklə burada nümayiş olunacaq.')) ?>
        </p>
        <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.35rem 0.9rem; border-radius: 20px; background: rgba(168,85,247,0.15); border: 1px solid rgba(168,85,247,0.3); color: #c084fc; font-size: 0.78rem; font-weight: 600;">
          ⏳ <span data-i18n="status_coming_soon"><?= e(__('status_coming_soon', 'Hazırlıq Mərhələsində')) ?></span>
        </span>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 0.75rem;">
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 0.9rem;">
          <div style="color: #c084fc; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.25rem;" data-i18n="projects_feat1_title"><?= e(__('projects_feat1_title', '✔️ Real Keyslər')) ?></div>
          <div style="font-size: 0.76rem; color: var(--text-muted); line-height: 1.4;" data-i18n="projects_feat1_desc"><?= e(__('projects_feat1_desc', 'Təhvil verilmiş kommersiya platformaları')) ?></div>
        </div>
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 0.9rem;">
          <div style="color: #c084fc; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.25rem;" data-i18n="projects_feat2_title"><?= e(__('projects_feat2_title', '✔️ Fərdi Həllər')) ?></div>
          <div style="font-size: 0.76rem; color: var(--text-muted); line-height: 1.4;" data-i18n="projects_feat2_desc"><?= e(__('projects_feat2_desc', 'Müştəri tələblərinə uyğun sıfırdan dizayn')) ?></div>
        </div>
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 10px; padding: 0.9rem;">
          <div style="color: #c084fc; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.25rem;" data-i18n="projects_feat3_title"><?= e(__('projects_feat3_title', '✔️ Dəstək & SLA')) ?></div>
          <div style="font-size: 0.76rem; color: var(--text-muted); line-height: 1.4;" data-i18n="projects_feat3_desc"><?= e(__('projects_feat3_desc', '24/7 texniki müşayiət və analitika')) ?></div>
        </div>
      </div>
    </div>

    <div class="sky-demos-footer" style="border-top-color: rgba(168, 85, 247, 0.2);">
      <span style="font-size: 0.82rem; color: var(--text-muted);" data-i18n="projects_modal_footer_text"><?= e(__('projects_modal_footer_text', 'Yeni layihənizi ilk olaraq təqdim etmək üçün:')) ?></span>
      <button type="button" class="btn-primary" onclick="closeOurProjectsModal(); if(typeof openModal==='function')openModal();" style="background: linear-gradient(135deg, #a855f7, #6366f1); border-color: rgba(168,85,247,0.4); padding:0.55rem 1.25rem; font-size:0.85rem; border-radius:8px;">
        <span data-i18n="projects_modal_cta"><?= e(__('projects_modal_cta', 'Fərdi Layihə Sifariş Et')) ?></span> →
      </button>
    </div>
  </div>
</div>

<script>
/* ── Web Services Showcase & Our Projects Modals JS ── */
function openWebServicesModal() {
  var overlay = document.getElementById('web-services-modal-overlay');
  if (overlay) {
    var curLang = (typeof SkyI18n !== 'undefined' && SkyI18n.currentLang) ? SkyI18n.currentLang() : (document.documentElement.lang || 'az');
    document.querySelectorAll('.sky-demo-btn-open').forEach(function(link) {
      var href = link.getAttribute('href');
      if (href) {
        link.setAttribute('href', href.replace(/([?&]lang=)[a-z]{2}/i, '$1' + curLang));
      }
    });
    var filterContainer = overlay.querySelector('.sky-demos-filters');
    if (filterContainer) {
      filterContainer.scrollLeft = 0;
      var allBtn = filterContainer.querySelector('.sky-demo-filter-btn[data-i18n="demos_filter_all"]') || filterContainer.firstElementChild;
      if (allBtn && !allBtn.classList.contains('active')) {
        filterDemoCategories('all', allBtn);
      }
    }
    var bodyContainer = overlay.querySelector('.sky-demos-body');
    if (bodyContainer) {
      bodyContainer.scrollTop = 0;
    }
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeWebServicesModal() {
  var overlay = document.getElementById('web-services-modal-overlay');
  if (overlay) {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }
}
function openOurProjectsModal() {
  var overlay = document.getElementById('our-projects-modal-overlay');
  if (overlay) {
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }
}
function closeOurProjectsModal() {
  var overlay = document.getElementById('our-projects-modal-overlay');
  if (overlay) {
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }
}
function filterDemoCategories(cat, btn) {
  document.querySelectorAll('.sky-demo-filter-btn').forEach(function(b) {
    b.classList.remove('active');
  });
  if (btn) {
    btn.classList.add('active');
    var filterContainer = document.querySelector('.sky-demos-filters');
    if (filterContainer && filterContainer.scrollWidth > filterContainer.clientWidth) {
      var btnLeft = btn.offsetLeft - filterContainer.offsetLeft;
      var targetScroll = btnLeft - (filterContainer.clientWidth / 2) + (btn.clientWidth / 2);
      filterContainer.scrollTo({ left: Math.max(0, targetScroll), behavior: 'smooth' });
    }
  }
  var items = document.querySelectorAll('.sky-demo-item');
  items.forEach(function(item) {
    var raw = (item.getAttribute('data-category') || '').trim();
    var cats = raw.split(/\s+/);
    if (cat === 'all' || cats.includes(cat) || raw === cat) {
      item.style.display = 'flex';
    } else {
      item.style.display = 'none';
    }
  });
  var bodyContainer = document.querySelector('.sky-demos-body');
  if (bodyContainer) {
    bodyContainer.scrollTop = 0;
  }
}
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    closeWebServicesModal();
    closeOurProjectsModal();
  }
});
</script>

<!-- Toast Container -->
<div id="sky-toast" class="toast" role="alert" aria-live="polite"></div>

<!-- ══════════════════════════════════════════════
     AVTOBİOQRAFİYA MODAL
══════════════════════════════════════════════ -->
<div class="autobio-modal-overlay" id="autobio-modal-overlay" aria-modal="true" role="dialog" aria-labelledby="autobio-modal-title-text" onclick="if(event.target===this)closeAutobioModal()">
  <div class="autobio-modal" id="autobio-modal">
    <button class="autobio-modal-close" onclick="closeAutobioModal()" aria-label="<?= e(__('btn_close', 'Bağla')) ?>">✕</button>

    <!-- Header -->
    <div class="autobio-modal-header">
      <div class="autobio-modal-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
        </svg>
      </div>
      <div>
        <div class="autobio-modal-title" id="autobio-modal-title-text"><?php echo __('autobio_modal_title', 'Avtobioqrafiya Hazırla'); ?></div>
        <div class="autobio-modal-subtitle"><?php echo __('autobio_modal_subtitle', 'Aşağıdakı sahələri qısaca doldurun, qalanını AI sistemi tamamlasın.'); ?></div>
      </div>
    </div>

    <!-- Unified Form Section -->
    <div class="autobio-form-section active" id="autobio-form-area">
      
      <!-- 1. Şəxsi Məlumatlar Group -->
      <div style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem;">
        <div class="autobio-section-title">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
          <?= e(__('autobio_personal_info', 'Şəxsi Məlumatlar')) ?>
        </div>
        <div class="autobio-field-group">
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-firstname"><?= e(__('autobio_firstname', 'Ad')) ?> *</label>
            <input class="autobio-input" id="autobio-firstname" type="text" placeholder="<?= e(__('autobio_firstname_ph', 'Əli')) ?>" autocomplete="given-name" oninput="this.value=toTitleCaseAz(this.value)">
          </div>
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-lastname"><?= e(__('autobio_lastname', 'Soyad')) ?> *</label>
            <input class="autobio-input" id="autobio-lastname" type="text" placeholder="<?= e(__('autobio_lastname_ph', 'Həsənov')) ?>" autocomplete="family-name" oninput="this.value=toTitleCaseAz(this.value)">
          </div>
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-patronymic"><?= e(__('autobio_patronymic', 'Ata adı')) ?> *</label>
            <input class="autobio-input" id="autobio-patronymic" type="text" placeholder="<?= e(__('autobio_patronymic_ph', 'Murad oğlu')) ?>" oninput="this.value=toTitleCaseAzPatronymic(this.value)">
          </div>
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-gender-select"><?= e(__('autobio_gender', 'Cinsiyyət')) ?> *</label>
            <select class="autobio-select" id="autobio-gender-select">
              <option value="kisi"><?= e(__('autobio_male', 'Kişi (Oğlu)')) ?></option>
              <option value="qadin"><?= e(__('autobio_female', 'Qadın (Qızı)')) ?></option>
            </select>
          </div>
        </div>
        <div class="autobio-field-group" style="margin-top: 0.85rem;">
          <div class="autobio-field">
            <label class="autobio-label"><?= e(__('autobio_birthdate_full', 'Doğum Tarixi (Gün / Ay / İl)')) ?> *</label>
            <div style="display: flex; gap: 0.4rem;">
              <select class="autobio-select" id="autobio-birth-day" style="flex: 1.2;">
                <option value=""><?= e(__('autobio_birthday', 'Gün')) ?></option>
                <?php for($i=1; $i<=31; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
              <select class="autobio-select" id="autobio-birth-month" style="flex: 2;">
                <option value=""><?= e(__('autobio_birthmonth', 'Ay')) ?></option>
                <?php 
                $months = ["Yanvar", "Fevral", "Mart", "Aprel", "May", "İyun", "İyul", "Avqust", "Sentyabr", "Oktyabr", "Noyabr", "Dekabr"];
                foreach($months as $m) echo "<option value='$m'>$m</option>";
                ?>
              </select>
              <input class="autobio-input" id="autobio-birth-year" type="number" placeholder="<?= e(__('autobio_birthyear', 'İl')) ?>" style="flex: 1.5;" min="1940" max="2026">
            </div>
          </div>
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-age"><?= e(__('autobio_age', 'Yaş')) ?></label>
            <select class="autobio-select" id="autobio-age">
              <option value=""><?= e(__('autobio_age_select', 'Yaş seçin')) ?></option>
              <?php for($i=18; $i<=100; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <div style="margin-top: 0.85rem;">
          <label class="autobio-label" style="display:block; margin-bottom:0.5rem;"><?= e(__('autobio_family_members', 'Ailə Üzvləri')) ?> <span style="color:var(--text-muted);font-size:0.78rem;"><?= e(__('autobio_family_members_note', '(Vəfat tarixi varsa qeyd edin)')) ?></span></label>
          
          <!-- Father -->
          <div class="family-member-block" id="fam-block-father" style="margin-bottom:0.7rem; padding:0.6rem; background:rgba(255,255,255,0.02); border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
            <div class="autobio-field-group" style="margin-bottom:0.3rem;">
              <div class="autobio-field" style="flex:2;">
                <input class="autobio-input" id="autobio-father" type="text" placeholder="<?= e(__('autobio_family_father_ph', 'Ata adı (məs: Ramiz)')) ?>" oninput="this.value=toTitleCaseAz(this.value)">
              </div>
              <div class="autobio-field" style="flex:1; display:flex; align-items:center; gap:0.4rem;">
                <label style="font-size:0.75rem; color:var(--text-muted); white-space:nowrap; cursor:pointer;">
                  <input type="checkbox" id="fam-father-deceased" onchange="toggleDeceasedDate('father')" style="margin-right:4px;"><?= e(__('autobio_deceased', 'Vəfat etmişdir')) ?>
                </label>
              </div>
            </div>
            <div id="fam-father-death-row" style="display:none; margin-top:0.3rem;">
              <input class="autobio-input" id="fam-father-deathdate" type="text" placeholder="<?= e(__('autobio_father_deathdate_ph', 'Vəfat tarixi (məs: 15 Mart 2010)')) ?>" style="font-size:0.82rem;">
            </div>
          </div>

          <!-- Mother -->
          <div class="family-member-block" id="fam-block-mother" style="margin-bottom:0.7rem; padding:0.6rem; background:rgba(255,255,255,0.02); border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
            <div class="autobio-field-group" style="margin-bottom:0.3rem;">
              <div class="autobio-field" style="flex:2;">
                <input class="autobio-input" id="autobio-mother" type="text" placeholder="<?= e(__('autobio_family_mother_ph', 'Ana adı (məs: Sevil)')) ?>" oninput="this.value=toTitleCaseAz(this.value)">
              </div>
              <div class="autobio-field" style="flex:1; display:flex; align-items:center; gap:0.4rem;">
                <label style="font-size:0.75rem; color:var(--text-muted); white-space:nowrap; cursor:pointer;">
                  <input type="checkbox" id="fam-mother-deceased" onchange="toggleDeceasedDate('mother')" style="margin-right:4px;"><?= e(__('autobio_deceased', 'Vəfat etmişdir')) ?>
                </label>
              </div>
            </div>
            <div id="fam-mother-death-row" style="display:none; margin-top:0.3rem;">
              <input class="autobio-input" id="fam-mother-deathdate" type="text" placeholder="<?= e(__('autobio_mother_deathdate_ph', 'Vəfat tarixi (məs: 2 İyun 2018)')) ?>" style="font-size:0.82rem;">
            </div>
          </div>

          <!-- Spouse -->
          <div class="family-member-block" id="fam-block-spouse" style="margin-bottom:0.7rem; padding:0.6rem; background:rgba(255,255,255,0.02); border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
            <div class="autobio-field-group" style="margin-bottom:0.3rem;">
              <div class="autobio-field" style="flex:2;">
                <input class="autobio-input" id="autobio-spouse" type="text" placeholder="<?= e(__('autobio_family_spouse_ph', 'Həyat yoldaşı adı')) ?>" oninput="this.value=toTitleCaseAz(this.value)">
              </div>
              <div class="autobio-field" style="flex:1; display:flex; align-items:center; gap:0.4rem;">
                <label style="font-size:0.75rem; color:var(--text-muted); white-space:nowrap; cursor:pointer;">
                  <input type="checkbox" id="fam-spouse-deceased" onchange="toggleDeceasedDate('spouse')" style="margin-right:4px;"><?= e(__('autobio_deceased', 'Vəfat etmişdir')) ?>
                </label>
              </div>
            </div>
            <div id="fam-spouse-death-row" style="display:none; margin-top:0.3rem;">
              <input class="autobio-input" id="fam-spouse-deathdate" type="text" placeholder="<?= e(__('autobio_spouse_deathdate_ph', 'Vəfat tarixi')) ?>" style="font-size:0.82rem;">
            </div>
          </div>

          <!-- Children -->
          <div class="family-member-block" id="fam-block-children" style="margin-bottom:0.5rem; padding:0.6rem; background:rgba(255,255,255,0.02); border-radius:10px; border:1px solid rgba(255,255,255,0.05);">
            <label style="font-size:0.78rem; color:var(--text-muted); display:block; margin-bottom:0.4rem;"><?= e(__('autobio_children_names', 'Övlad adları (hər birini vergüllə ayırın)')) ?></label>
            <input class="autobio-input" id="autobio-children" type="text" placeholder="<?= e(__('autobio_children_ph', 'məs: Ayla, Aysu, Murad')) ?>" oninput="this.value=capitalizeChildrenNames(this.value)">
            <label style="font-size:0.75rem; color:var(--text-muted); white-space:nowrap; cursor:pointer; margin-top:0.4rem; display:inline-flex; align-items:center; gap:4px;">
              <input type="checkbox" id="fam-children-deceased" onchange="toggleDeceasedDate('children')" style="margin-right:4px;"><?= e(__('autobio_children_deceased_label', 'Övladlardan biri/bir neçəsi vəfat etmişdir')) ?>
            </label>
            <div id="fam-children-death-row" style="display:none; margin-top:0.3rem;">
              <input class="autobio-input" id="fam-children-deathdate" type="text" placeholder="<?= e(__('autobio_children_deathdate_ph', 'Vəfat tarixi qeydi (məs: Murad 5 May 2020-ci ildə vəfat etmişdir)')) ?>" style="font-size:0.82rem;">
            </div>
          </div>

          <!-- Other family note -->
          <div style="margin-top:0.4rem;">
            <input class="autobio-input" id="autobio-family" type="text" placeholder="<?= e(__('autobio_family_note_ph', 'Digər qeyd (könüllü)')) ?>">
          </div>
        </div>
      </div>

      <!-- 2. Peşəkar Fəaliyyət Group -->
      <div style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem;">
        <div class="autobio-section-title">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
          <?= e(__('autobio_career_title', 'Peşəkar Fəaliyyət & Karyera')) ?>
        </div>
        
        <div class="autobio-field full" style="margin-bottom: 1rem;">
          <label class="autobio-label"><?= e(__('autobio_sectors_usage_note', 'İşlədiyiniz Sahələr və İllər (İşlədiyiniz sahələri seçib daxil olduğunuz illəri qeyd edin)')) ?></label>
          <div class="autobio-checkbox-grid" style="max-height: 280px; overflow-y: auto; padding: 0.4rem; border: 1px solid rgba(255,255,255,0.05); border-radius: 12px; background: rgba(0,0,0,0.15);">
            
            <?php 
            $sectors = [
              "it" => "İT / Proqramlaşdırma",
              "satis" => "Satış və Marketinq",
              "maliyye" => "Maliyyə və Mühasibat",
              "tehsil" => "Təhsil və Elm",
              "tibbi" => "Səhiyyə və Tibb",
              "tikinti" => "Tikinti və Mühəndislik",
              "musteri" => "Müştəri Xidmətləri",
              "hr" => "İnsan Resursları (HR)",
              "neqliyyat" => "Nəqliyyat və Logistika",
              "huquq" => "Hüquq və Qanunvericilik",
              "dizayn" => "İncəsənət və Dizayn",
              "dovlet" => "Dövlət Qulluğu",
              "turizm" => "Turizm və Otelçilik",
              "istehsalat" => "İstehsalat və Sənaye",
              "diger" => "Digər / Özəl Sahə"
            ];
            foreach($sectors as $key => $name):
            ?>
            <div class="autobio-checkbox-item" id="sector-item-<?= $key ?>">
              <label class="autobio-checkbox-label">
                <input type="checkbox" class="sector-checkbox" value="<?= $name ?>" onchange="toggleSectorInputs('<?= $key ?>')">
                <span><?= $name ?></span>
              </label>
              <div class="dynamic-inputs" id="sector-inputs-<?= $key ?>">
                <div class="dynamic-row">
                  <input class="autobio-input sector-start-year" type="number" id="sector-start-<?= $key ?>" placeholder="<?= e(__('autobio_sectors_start_ph', 'Giriş ili')) ?>" min="1950" max="2026">
                  <input class="autobio-input sector-end-year" type="number" id="sector-end-<?= $key ?>" placeholder="<?= e(__('autobio_sectors_end_ph', 'Çıxış ili')) ?>" min="1950" max="2026">
                </div>
                <div style="margin-top:0.35rem;">
                  <input class="autobio-input" type="text" id="sector-place-<?= $key ?>" placeholder="<?= e(__('autobio_sectors_place_ph', 'İşlədiyin yer (müəssisə/təşkilat adı - əl ilə yazın)')) ?>" style="font-size:0.82rem;">
                </div>
                <label class="autobio-checkbox-label" style="font-size: 0.72rem; margin-top: 0.2rem;">
                  <input type="checkbox" class="sector-current" id="sector-current-<?= $key ?>" onchange="toggleSectorCurrent('<?= $key ?>')">
                  <span><?= e(__('autobio_sectors_current', 'Hazırda çalışıram')) ?></span>
                </label>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>

        <div class="autobio-field-group">
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-services"><?= e(__('autobio_services_label', 'Göstərdiyiniz Xidmətlərin / Fəaliyyətlərin Adı')) ?></label>
            <textarea class="autobio-textarea" style="min-height:60px;" id="autobio-services" placeholder="<?= e(__('autobio_services_ph', 'Məs: Saytların hazırlanması, texniki dəstək göstərilməsi...')) ?>"></textarea>
          </div>
          <div class="autobio-field">
            <label class="autobio-label" for="autobio-current-job"><?= e(__('autobio_current_job_label', 'Hazırda Nə İşləyirsiniz (Cari Vəzifəniz)?')) ?></label>
            <input class="autobio-input" id="autobio-current-job" type="text" placeholder="<?= e(__('autobio_current_job_ph', 'Məs: Aparıcı proqramçı, SMM menecer...')) ?>">
          </div>
        </div>
      </div>

      <!-- 3. Təhsillər Group -->
      <div style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem;">
        <div class="autobio-section-title">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/></svg>
          <?= e(__('autobio_education_title', 'Aldığınız Təhsillər')) ?>
        </div>
        
        <div class="autobio-checkbox-grid">
          <?php 
          $edus = [
            "orta" => "Orta Təhsil",
            "pese" => "Peşə Təhsili",
            "kollec" => "Kollec / Subbakalavr",
            "bakalavr" => "Bakalavr",
            "magistr" => "Magistr",
            "doktorantura" => "Doktorantura"
          ];
          foreach($edus as $key => $name):
          ?>
          <div class="autobio-checkbox-item" id="edu-item-<?= $key ?>">
            <label class="autobio-checkbox-label">
              <input type="checkbox" class="edu-checkbox" value="<?= $name ?>" onchange="toggleEduInputs('<?= $key ?>')">
              <span><?= $name ?></span>
            </label>
            <div class="dynamic-inputs" id="edu-inputs-<?= $key ?>">
              <input class="autobio-input edu-school" type="text" id="edu-school-<?= $key ?>" placeholder="<?= e(__('autobio_edu_school_ph', 'Müəssisə (məs: BDU)')) ?>">
              <div class="dynamic-row" style="margin-top: 0.3rem;">
                <input class="autobio-input edu-start-year" type="number" id="edu-start-<?= $key ?>" placeholder="<?= e(__('autobio_edu_start_ph', 'Giriş ili')) ?>" min="1950" max="2026">
                <input class="autobio-input edu-end-year" type="number" id="edu-end-<?= $key ?>" placeholder="<?= e(__('autobio_edu_end_ph', 'Bitmə ili')) ?>" min="1950" max="2026">
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- 4. Gələcək Hədəflər Group -->
      <div style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem;">
        <div class="autobio-section-title">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
          <?= e(__('autobio_goals_title', 'Gələcək Hədəfləriniz')) ?>
        </div>
        <div class="autobio-checkbox-grid" style="margin-bottom: 0.85rem;">
          <?php 
          $goals = [
            "rehber" => "Rəhbər vəzifəyə yüksəlmək",
            "beynelxalq" => "Beynəlxalq şirkətdə çalışmaq",
            "biznes" => "Öz biznesini qurmaq",
            "sertifikat" => "Yeni sertifikatlar qazanmaq",
            "xaric" => "Xaricdə təcrübə qazanmaq",
            "elm" => "Elmi fəaliyyətlə məşğul olmaq",
            "ekspert" => "Sahədə tanınmış ekspert olmaq"
          ];
          foreach($goals as $key => $name):
          ?>
          <div class="autobio-checkbox-item" id="goal-item-<?= $key ?>">
            <label class="autobio-checkbox-label">
              <input type="checkbox" class="goal-checkbox" value="<?= $name ?>" onchange="toggleGoalItem('<?= $key ?>')">
              <span><?= $name ?></span>
            </label>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="autobio-field">
          <label class="autobio-label" for="autobio-goals-custom"><?= e(__('autobio_goals_custom_label', 'Digər hədəfiniz (Könüllü)')) ?></label>
          <input class="autobio-input" id="autobio-goals-custom" type="text" placeholder="<?= e(__('autobio_goals_custom_ph', 'Məs: Öz startapımı qurmaq və qlobal bazara çıxmaq...')) ?>">
        </div>
      </div>

      <!-- 5. İmza Sahəsi Group -->
      <div style="margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 1rem;">
        <div class="autobio-section-title">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"/><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"/></svg>
          <?= e(__('autobio_signature_title', 'İmza Sahəsi (Könüllü)')) ?>
        </div>
        <div class="autobio-signature-area">
          <canvas id="autobio-signature-canvas" class="autobio-canvas" width="600" height="120"></canvas>
          <button type="button" class="autobio-canvas-clear" onclick="clearSignatureCanvas()"><?= e(__('autobio_signature_clear', 'Təmizlə')) ?></button>
        </div>
      </div>

      <!-- 6. Üslub Seçimi -->
      <div class="autobio-field-group" style="margin-bottom: 1.5rem;">
        <div class="autobio-field">
          <label class="autobio-label" for="autobio-tone"><?= e(__('autobio_tone', 'Yazı Üslubu')) ?></label>
          <select class="autobio-select" id="autobio-tone">
            <option value="resmi"><?= e(__('autobio_tone_formal', 'Rəsmi & Peşəkar (Tövsiyə olunur)')) ?></option>
            <option value="samimi" selected><?= e(__('autobio_tone_friendly', 'Səmimi & İstiqlal')) ?></option>
            <option value="akademik"><?= e(__('autobio_tone_academic', 'Akademik')) ?></option>
            <option value="yaradici"><?= e(__('autobio_tone_creative', 'Yaradıcı & Dinamik')) ?></option>
          </select>
        </div>
        <div class="autobio-field">
          <label class="autobio-label" for="autobio-length"><?= e(__('autobio_length', 'Uzunluq')) ?></label>
          <select class="autobio-select" id="autobio-length">
            <option value="orta" selected><?= e(__('autobio_length_standard', 'Standart')) ?></option>
            <option value="uzun"><?= e(__('autobio_length_detailed', 'Ətraflı')) ?></option>
          </select>
        </div>
      </div>

      <div class="autobio-nav">
        <button class="autobio-btn-next" id="autobio-generate-btn" onclick="generateAutobio()" style="width:100%; justify-content:center; padding: 0.85rem;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="margin-right: 4px;"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
          <?= e(__('autobio_generate_btn', 'Avtobioqrafiyanı Hazırla')) ?>
        </button>
      </div>
    </div>

    <!-- ── Nəticə Area ── -->
    <div class="autobio-result-area" id="autobio-result-area">
      <div class="autobio-section-title">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
        <?= e(__('autobio_success_title', 'Avtobioqrafiyanız Hazırdır!')) ?>
      </div>
      <div class="autobio-loading" id="autobio-loading">
        <div class="autobio-loader-dots">
          <span></span><span></span><span></span>
        </div>
        <?= e(__('autobio_loader_text', 'Mətn tərtib edilir...')) ?>
      </div>
      <div class="autobio-result-box" id="autobio-result-box" data-sky-no-translate style="display:none;">
        <button class="autobio-copy-btn" id="autobio-copy-btn" onclick="copyAutobio()">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
          <?= e(__('autobio_copy', 'Kopyala')) ?>
        </button>
        <p class="autobio-result-text" id="autobio-result-text" style="font-family: 'Times New Roman', Times, serif; font-size: 1.05rem; line-height: 1.7; color: var(--text-primary);"></p>
      </div>
      <div class="autobio-nav" style="margin-top:1.2rem; gap: 0.5rem; flex-wrap: wrap;">
        <button class="autobio-btn-back" onclick="autobioReset()">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.39"/></svg>
          <?= e(__('autobio_rewrite', 'Yenidən Yaz')) ?>
        </button>
        <button class="autobio-btn-back" onclick="downloadAutobio()" style="margin-left: auto;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
          <?= e(__('autobio_txt', 'TXT Yüklə')) ?>
        </button>
        <button class="autobio-btn-next" onclick="downloadAutobioPDF()" style="background: linear-gradient(135deg, #ef4444, #b91c1c); box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); margin-left: 0;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          <?= e(__('autobio_pdf', 'PDF Yüklə / Çap Et')) ?>
        </button>
      </div>
    </div>

  </div>
</div>

<!-- Scripts -->
<script src="assets/js/main.js?v=<?= time() ?>" defer></script>

<script>
/* ══════════════════════════════════════════════
   AVTOBİOQRAFİYA MODAL JS
══════════════════════════════════════════════ */
var sigCanvas, sigCtx, isDrawingSig = false;

function initSignaturePad() {
  sigCanvas = document.getElementById('autobio-signature-canvas');
  if (!sigCanvas) return;
  sigCtx = sigCanvas.getContext('2d');
  
  // Set up ctx styling
  sigCtx.strokeStyle = '#a855f7'; // Purple line to match style
  sigCtx.lineWidth = 3;
  sigCtx.lineCap = 'round';
  sigCtx.lineJoin = 'round';

  // Mouse events
  sigCanvas.addEventListener('mousedown', function(e) {
    isDrawingSig = true;
    var rect = sigCanvas.getBoundingClientRect();
    sigCtx.beginPath();
    sigCtx.moveTo(e.clientX - rect.left, e.clientY - rect.top);
  });

  sigCanvas.addEventListener('mousemove', function(e) {
    if (!isDrawingSig) return;
    var rect = sigCanvas.getBoundingClientRect();
    sigCtx.lineTo(e.clientX - rect.left, e.clientY - rect.top);
    sigCtx.stroke();
  });

  window.addEventListener('mouseup', function() {
    isDrawingSig = false;
  });

  // Touch events for mobile support
  sigCanvas.addEventListener('touchstart', function(e) {
    isDrawingSig = true;
    var rect = sigCanvas.getBoundingClientRect();
    var touch = e.touches[0];
    sigCtx.beginPath();
    sigCtx.moveTo(touch.clientX - rect.left, touch.clientY - rect.top);
    e.preventDefault();
  }, { passive: false });

  sigCanvas.addEventListener('touchmove', function(e) {
    if (!isDrawingSig) return;
    var rect = sigCanvas.getBoundingClientRect();
    var touch = e.touches[0];
    sigCtx.lineTo(touch.clientX - rect.left, touch.clientY - rect.top);
    sigCtx.stroke();
    e.preventDefault();
  }, { passive: false });

  sigCanvas.addEventListener('touchend', function(e) {
    isDrawingSig = false;
  }, { passive: false });
}

function clearSignatureCanvas() {
  if (sigCanvas && sigCtx) {
    sigCtx.clearRect(0, 0, sigCanvas.width, sigCanvas.height);
  }
}

function isCanvasEmpty(canvas) {
  const blank = document.createElement('canvas');
  blank.width = canvas.width;
  blank.height = canvas.height;
  return canvas.toDataURL() === blank.toDataURL();
}

function toggleSectorInputs(key) {
  var container = document.getElementById('sector-inputs-' + key);
  var item = document.getElementById('sector-item-' + key);
  var checkbox = item.querySelector('.sector-checkbox');
  
  if (checkbox.checked) {
    container.classList.add('active');
    item.classList.add('checked');
  } else {
    container.classList.remove('active');
    item.classList.remove('checked');
    // Clear inputs
    document.getElementById('sector-start-' + key).value = '';
    document.getElementById('sector-end-' + key).value = '';
    document.getElementById('sector-place-' + key).value = '';
    document.getElementById('sector-current-' + key).checked = false;
    document.getElementById('sector-end-' + key).disabled = false;
  }
}

function toggleSectorCurrent(key) {
  var currentCheckbox = document.getElementById('sector-current-' + key);
  var endInput = document.getElementById('sector-end-' + key);
  if (currentCheckbox.checked) {
    endInput.value = '';
    endInput.disabled = true;
  } else {
    endInput.disabled = false;
  }
}

function toggleEduInputs(key) {
  var container = document.getElementById('edu-inputs-' + key);
  var item = document.getElementById('edu-item-' + key);
  var checkbox = item.querySelector('.edu-checkbox');
  
  if (checkbox.checked) {
    container.classList.add('active');
    item.classList.add('checked');
  } else {
    container.classList.remove('active');
    item.classList.remove('checked');
    // Clear inputs
    document.getElementById('edu-school-' + key).value = '';
    document.getElementById('edu-start-' + key).value = '';
    document.getElementById('edu-end-' + key).value = '';
  }
}

function toggleGoalItem(key) {
  var item = document.getElementById('goal-item-' + key);
  var checkbox = item.querySelector('.goal-checkbox');
  if (checkbox.checked) {
    item.classList.add('checked');
  } else {
    item.classList.remove('checked');
  }
}

function switchCvAutobioTab(tab) {
  const widget = document.getElementById('cv-autobio-widget');
  const btnCv = document.querySelector('.widget-tab-btn[data-tab="cv"]');
  const btnAutobio = document.querySelector('.widget-tab-btn[data-tab="autobio"]');
  const contentCv = document.getElementById('content-cv');
  const contentAutobio = document.getElementById('content-autobio');

  if (!widget || !btnCv || !btnAutobio || !contentCv || !contentAutobio) return;

  if (tab === 'cv') {
    widget.classList.add('tab-cv');
    widget.classList.remove('tab-autobio');
    btnCv.classList.add('active');
    btnAutobio.classList.remove('active');
    contentCv.classList.add('active');
    contentAutobio.classList.remove('active');
  } else {
    widget.classList.add('tab-autobio');
    widget.classList.remove('tab-cv');
    btnAutobio.classList.add('active');
    btnCv.classList.remove('active');
    contentAutobio.classList.add('active');
    contentCv.classList.remove('active');
  }
}

function openAutobioModal() {
  document.getElementById('autobio-modal-overlay').classList.add('active');
  document.body.style.overflow = 'hidden';
  autobioReset();
  setTimeout(initSignaturePad, 150); // Small delay to ensure modal transitions are complete and canvas width is correct
}

function closeAutobioModal() {
  document.getElementById('autobio-modal-overlay').classList.remove('active');
  document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeAutobioModal();
});

/* ── Azerbaijani Title Case helper ── */
function toTitleCaseAz(str) {
  // Capitalize first letter of each word (supports az chars)
  return str.replace(/(?:^|\s|-)\S/g, function(c) { return c.toUpperCase(); });
}
function toTitleCaseAzPatronymic(str) {
  // Capitalize first letter only, keep rest as typed (oğlu/qızı stays lowercase)
  if (!str) return str;
  return str.charAt(0).toUpperCase() + str.slice(1);
}
function capitalizeChildrenNames(str) {
  // Capitalize first letter of each name after commas
  return str.split(',').map(function(n) {
    var t = n.trim();
    if (!t) return '';
    return t.charAt(0).toUpperCase() + t.slice(1);
  }).join(', ');
}
function toggleDeceasedDate(member) {
  var cb = document.getElementById('fam-' + member + '-deceased');
  var row = document.getElementById('fam-' + member + '-death-row');
  if (cb && row) {
    row.style.display = cb.checked ? 'block' : 'none';
  }
}

function detectGender(firstName) {
  if (!firstName) return 'kisi';
  var nameLower = firstName.toLowerCase().trim();
  // Suffixes for female names
  var femaleEndings = ['a', 'ə', 'i', 'u', 'y', 'la', 'nə', 'ra', 'da', 'fa', 'ta', 'ma', 'za', 'sa', 'va', 'qa', 'ya', 'el', 'ül', 'il'];
  var femaleNames = ['sevil', 'könül', 'günel', 'nigar', 'fidan', 'leyla', 'aysel', 'aygün', 'arzu', 'sevinc', 'xoşqədəm', 'bahar', 'lalə', 'turanə', 'səbinə', 'ayla', 'aysu'];
  
  if (femaleNames.indexOf(nameLower) !== -1) {
    return 'qadin';
  }
  
  for (var i = 0; i < femaleEndings.length; i++) {
    if (nameLower.endsWith(femaleEndings[i])) {
      var maleExceptions = ['əli', 'vəli', 'ilqar', 'ismayıl', 'mikayıl', 'cəmil', 'aqil', 'adil', 'amil', 'ramil', 'şamil', 'kamran', 'kənan', 'süleyman', 'ramiz', 'vüsal', 'tural', 'elmir', 'elvin', 'elçin', 'emin'];
      if (maleExceptions.indexOf(nameLower) === -1) {
        return 'qadin';
      }
    }
  }
  return 'kisi';
}

// Bind event listeners for real-time gender detection and patronymic placeholder update
(function() {
  var genderSelect = document.getElementById('autobio-gender-select');
  var firstnameInput = document.getElementById('autobio-firstname');
  var patronymicInput = document.getElementById('autobio-patronymic');

  if (genderSelect && patronymicInput) {
    genderSelect.addEventListener('change', function() {
      if (this.value === 'qadin') {
        patronymicInput.placeholder = 'Murad qızı';
      } else {
        patronymicInput.placeholder = 'Murad oğlu';
      }
    });
  }

  if (firstnameInput && genderSelect) {
    firstnameInput.addEventListener('input', function() {
      var detected = detectGender(this.value);
      genderSelect.value = detected;
      genderSelect.dispatchEvent(new Event('change'));
    });
  }
})();

function generateAutobio() {
  var firstname = document.getElementById('autobio-firstname').value.trim();
  var lastname = document.getElementById('autobio-lastname').value.trim();
  var patronymic = document.getElementById('autobio-patronymic').value.trim();
  
  // Validate Name and Birth Year
  if (!firstname || !lastname) {
    var el = !firstname ? document.getElementById('autobio-firstname') : document.getElementById('autobio-lastname');
    el.focus();
    el.style.borderColor = 'rgba(239,68,68,0.6)';
    setTimeout(function(){ el.style.borderColor = ''; }, 2000);
    return;
  }

  // Enforce "oğlu" or "qızı" suffix in patronymic if not present
  var genderSelect = document.getElementById('autobio-gender-select');
  var gender = genderSelect ? genderSelect.value : detectGender(firstname);
  if (patronymic && !patronymic.toLowerCase().endsWith('oğlu') && !patronymic.toLowerCase().endsWith('qızı') && !patronymic.toLowerCase().endsWith('oglu') && !patronymic.toLowerCase().endsWith('qizi')) {
    if (gender === 'qadin') {
      patronymic += ' qızı';
    } else {
      patronymic += ' oğlu';
    }
  }

  // Build full name in Soyad Ad format
  var name = [lastname, firstname].filter(Boolean).join(' ');
  var birthDay = document.getElementById('autobio-birth-day').value;
  var birthMonth = document.getElementById('autobio-birth-month').value;
  var birthYear = document.getElementById('autobio-birth-year').value.trim();

  if (!birthYear || birthYear < 1930 || birthYear > 2026) {
    document.getElementById('autobio-birth-year').focus();
    document.getElementById('autobio-birth-year').style.borderColor = 'rgba(239,68,68,0.6)';
    setTimeout(function(){ document.getElementById('autobio-birth-year').style.borderColor = ''; }, 2000);
    return;
  }

  // Gender hidden (not shown in bio anymore)
  var age = document.getElementById('autobio-age').value;
  
  // Family fields
  var fatherName = document.getElementById('autobio-father').value.trim();
  var fatherDeceased = document.getElementById('fam-father-deceased').checked;
  var fatherDeathDate = fatherDeceased ? document.getElementById('fam-father-deathdate').value.trim() : '';
  var motherName = document.getElementById('autobio-mother').value.trim();
  var motherDeceased = document.getElementById('fam-mother-deceased').checked;
  var motherDeathDate = motherDeceased ? document.getElementById('fam-mother-deathdate').value.trim() : '';
  var spouseName = document.getElementById('autobio-spouse').value.trim();
  var spouseDeceased = document.getElementById('fam-spouse-deceased').checked;
  var spouseDeathDate = spouseDeceased ? document.getElementById('fam-spouse-deathdate').value.trim() : '';
  var childrenRaw = document.getElementById('autobio-children').value.trim();
  var childrenDeceased = document.getElementById('fam-children-deceased').checked;
  var childrenDeathNote = childrenDeceased ? document.getElementById('fam-children-deathdate').value.trim() : '';
  var familyGeneral = document.getElementById('autobio-family').value.trim();

  // Sectors & Years
  var selectedSectorsData = [];
  var sectorCheckboxes = document.querySelectorAll('.sector-checkbox:checked');
  sectorCheckboxes.forEach(function(cb) {
    var key = cb.closest('.autobio-checkbox-item').id.replace('sector-item-', '');
    var nameVal = cb.value;
    var startYear = document.getElementById('sector-start-' + key).value.trim();
    var endYear = document.getElementById('sector-end-' + key).value.trim();
    var isCurrent = document.getElementById('sector-current-' + key).checked;
    var place = document.getElementById('sector-place-' + key).value.trim();
    selectedSectorsData.push({
      name: nameVal,
      start: startYear,
      end: endYear,
      current: isCurrent,
      place: place
    });
  });
  // Sort sectors by start year (chronological)
  selectedSectorsData.sort(function(a, b) {
    var sa = parseInt(a.start) || 0;
    var sb = parseInt(b.start) || 0;
    return sa - sb;
  });

  // Services & Current Job
  var services = document.getElementById('autobio-services').value.trim();
  var currentJob = document.getElementById('autobio-current-job').value.trim();

  // Educations
  var selectedEdusData = [];
  var eduCheckboxes = document.querySelectorAll('.edu-checkbox:checked');
  eduCheckboxes.forEach(function(cb) {
    var key = cb.closest('.autobio-checkbox-item').id.replace('edu-item-', '');
    var nameVal = cb.value;
    var school = document.getElementById('edu-school-' + key).value.trim();
    var startYear = document.getElementById('edu-start-' + key).value.trim();
    var endYear = document.getElementById('edu-end-' + key).value.trim();
    selectedEdusData.push({
      name: nameVal,
      school: school,
      start: startYear,
      end: endYear
    });
  });

  // Goals
  var selectedGoals = [];
  var goalCheckboxes = document.querySelectorAll('.goal-checkbox:checked');
  goalCheckboxes.forEach(function(cb) {
    selectedGoals.push(cb.value);
  });
  var customGoal = document.getElementById('autobio-goals-custom').value.trim();
  if (customGoal) {
    selectedGoals.push(customGoal);
  }

  // Get Signature
  var hasSignature = false;
  var signatureDataUrl = '';
  if (sigCanvas && !isCanvasEmpty(sigCanvas)) {
    hasSignature = true;
    signatureDataUrl = sigCanvas.toDataURL();
  }

  var tone = document.getElementById('autobio-tone').value;
  var length = document.getElementById('autobio-length').value;

  // Toggle layout
  document.getElementById('autobio-form-area').style.display = 'none';
  document.getElementById('autobio-result-area').classList.add('active');
  document.getElementById('autobio-loading').classList.add('active');
  document.getElementById('autobio-result-box').style.display = 'none';
  document.getElementById('autobio-modal').scrollTop = 0;

  // Store signature globally or attach to printing
  window.currentAutobioSignature = signatureDataUrl;

  // Keep the latest form state so an instant language switch can regenerate
  // the whole document in the newly selected language.
  window.__lastAutobioArgs = [name, patronymic, birthDay, birthMonth, birthYear, gender, age, fatherName, fatherDeceased, fatherDeathDate, motherName, motherDeceased, motherDeathDate, spouseName, spouseDeceased, spouseDeathDate, childrenRaw, childrenDeceased, childrenDeathNote, familyGeneral, selectedSectorsData, services, currentJob, selectedEdusData, selectedGoals, tone, length];

  // Simulate AI smart writing
  setTimeout(function() {
    var bio = buildAutobioBio.apply(null, window.__lastAutobioArgs);
    document.getElementById('autobio-loading').classList.remove('active');
    document.getElementById('autobio-result-box').style.display = 'block';
    
    // Add signature block below the generated text inside the result box
    var signatureBlockHtml = buildAutobioSignatureBlock(name, patronymic, signatureDataUrl);
    
    // Render text with typewriter effect
    typewriterEffect(document.getElementById('autobio-result-text'), bio, 10, function() {
      // Append signature block after typewriter completes
      var container = document.getElementById('autobio-result-box');
      // Remove any existing signature blocks first
      var oldBlock = container.querySelector('.autobio-signature-block');
      if (oldBlock) oldBlock.remove();
      
      var newBlock = document.createElement('div');
      newBlock.className = 'autobio-signature-block';
      newBlock.innerHTML = signatureBlockHtml;
      container.appendChild(newBlock);
    });
  }, 1500);
}

/* ── Localized autobiography helpers (az / en / ru / tr) ── */
function abLang() {
  try { if (window.SkyI18n && window.SkyI18n.currentLang) return window.SkyI18n.currentLang(); } catch (e) {}
  return (document.documentElement.lang || 'az');
}
function abT(key, vars) {
  var all = window.__SKY_AB__ || {};
  var pack = all[abLang()] || all.az || {};
  var fallback = all.az || {};
  var s = (pack[key] !== undefined ? pack[key] : (fallback[key] !== undefined ? fallback[key] : key));
  s = String(s);
  if (vars) {
    Object.keys(vars).forEach(function (k) {
      s = s.split('{' + k + '}').join(vars[k] === undefined || vars[k] === null ? '' : vars[k]);
    });
  }
  return s;
}
function abTr(value) {
  if (value === undefined || value === null) return '';
  var s = String(value);
  try { if (window.SkyI18n && window.SkyI18n.tr) return window.SkyI18n.tr(s, abLang()); } catch (e) {}
  return s;
}
function abLower(s) {
  var map = { az: 'az-AZ', en: 'en-US', ru: 'ru-RU', tr: 'tr-TR' };
  try { return String(s).toLocaleLowerCase(map[abLang()] || 'en-US'); } catch (e) { return String(s).toLowerCase(); }
}
function abCap(s) {
  var l = abLang();
  try { return String(s).charAt(0).toLocaleUpperCase(mapLocale(l)) + String(s).slice(1); } catch (e) { return String(s).charAt(0).toUpperCase() + String(s).slice(1); }
}
function mapLocale(l) { return ({ az: 'az-AZ', en: 'en-US', ru: 'ru-RU', tr: 'tr-TR' })[l] || 'en-US'; }

function buildAutobioSignatureBlock(name, patronymic, signatureDataUrl) {
  var who = name + (patronymic ? ' ' + patronymic : '');
  var html = '<div style="margin-top: 2rem; display: flex; justify-content: space-between; border-top: 1px dashed rgba(255,255,255,0.1); padding-top: 1.5rem; text-align: left;">' +
             '  <div><span style="color: var(--text-muted); font-size: 0.8rem;">' + abT('date_label') + '</span><br><strong style="color: #fff; font-size: 0.9rem;">' + getFormattedDate() + '</strong></div>' +
             '  <div style="text-align: right;"><span style="color: var(--text-muted); font-size: 0.8rem;">' + abT('signature_label') + '</span><br>';
  if (signatureDataUrl) {
    html += '    <div style="margin: 0.2rem 0; height: 50px; display: inline-flex; align-items: center; justify-content: flex-end;">' +
            '      <img src="' + signatureDataUrl + '" style="height: 50px; max-width: 150px; filter: drop-shadow(0 0 4px rgba(168,85,247,0.3));">' +
            '    </div>' +
            '    <div style="color: #fff; font-weight: bold; border-top: 1px solid rgba(255,255,255,0.2); padding-top: 0.25rem;">' + who + '</div>';
  } else {
    html += '    <div style="margin: 0.5rem 0; color: rgba(255,255,255,0.2);">____________________</div>' +
            '    <div style="color: #fff; font-weight: bold; padding-top: 0.25rem;">' + who + '</div>';
  }
  return html + '  </div></div>';
}

// Instant language switch: regenerate an already visible autobiography instead
// of leaving the old-language document on screen.
document.addEventListener('sky-lang-changed', function () {
  var box = document.getElementById('autobio-result-box');
  var result = document.getElementById('autobio-result-text');
  if (!box || !result || box.style.display === 'none' || !window.__lastAutobioArgs) return;
  result.textContent = buildAutobioBio.apply(null, window.__lastAutobioArgs);
  var block = box.querySelector('.autobio-signature-block');
  if (block) {
    block.innerHTML = buildAutobioSignatureBlock(window.__lastAutobioArgs[0], window.__lastAutobioArgs[1], window.currentAutobioSignature);
  }
});

function getFormattedDate() {
  var months = abT('months') || [];
  var d = new Date();
  return d.getDate() + ' ' + (months[d.getMonth()] || '') + ' ' + d.getFullYear() + abT('date_suffix');
}

function buildAutobioBio(name, patronymic, day, month, year, gender, age, fatherName, fatherDeceased, fatherDeathDate, motherName, motherDeceased, motherDeathDate, spouseName, spouseDeceased, spouseDeathDate, childrenRaw, childrenDeceased, childrenDeathNote, familyGeneral, sectors, services, currentJob, edus, goals, tone, length) {
  var paragraphs = [];

  /* Paragraph 1 — identity, birth date, family */
  var fullName = name + (patronymic ? ' ' + patronymic : '');
  var p1 = abT('intro_i', { name: fullName });
  if (day && month && year) {
    p1 += abT('born_full', { day: day, month: abTr(month), year: year, suffix: abT('date_suffix') });
  } else if (year) {
    p1 += abT('born_year', { year: year, suffix: abT('date_suffix') });
  } else {
    p1 += abT('born_unknown');
  }
  if (age) p1 += abT('age', { age: age });

  function fmtMember(labelKey, memberName, isDeceased, deathDate) {
    if (!memberName) return null;
    var s = abT(labelKey) + ' ' + String(memberName).trim();
    if (isDeceased) s += abT(deathDate ? 'deceased_date' : 'deceased', { date: deathDate || '' });
    return s;
  }

  var familyParts = [];
  [fmtMember('father', fatherName, fatherDeceased, fatherDeathDate),
   fmtMember('mother', motherName, motherDeceased, motherDeathDate),
   fmtMember('spouse', spouseName, spouseDeceased, spouseDeathDate)].forEach(function (entry) {
    if (entry) familyParts.push(entry);
  });

  var childrenList = [];
  if (childrenRaw) {
    childrenList = String(childrenRaw).split(',').map(function (n) { return n.trim(); })
      .filter(Boolean).map(function (n) { return abCap(n); });
  }
  var cleanNote = function (v) { return abTr(v).replace(/[.\s]+$/, ''); };

  var familySentence = '';
  if (familyParts.length > 0) {
    familySentence = abT('family_intro');
    if (familyParts.length === 1) {
      familySentence += abT('family_one', { list: familyParts[0] });
    } else if (familyParts.length === 2) {
      familySentence += abT('family_two', { a: familyParts[0], b: familyParts[1] });
    } else {
      familySentence += abT('family_many', { list: familyParts.slice(0, -1).join(', '), last: familyParts[familyParts.length - 1] });
    }
    if (childrenList.length > 0) {
      if (childrenList.length === 1) {
        familySentence += abT('child_one', { child: childrenList[0] });
      } else {
        familySentence += abT('child_many', { list: childrenList.slice(0, -1).join(', '), last: childrenList[childrenList.length - 1] });
      }
      if (childrenDeceased && childrenDeathNote) {
        familySentence += ' (' + abTr(childrenDeathNote) + ')';
      } else if (childrenDeceased) {
        familySentence += abT('child_deceased');
      }
    }
    if (familyGeneral) familySentence += abT('family_note', { note: abLower(cleanNote(familyGeneral)) });
  } else if (childrenList.length > 0) {
    if (childrenList.length === 1) {
      familySentence = abT('child_only_one', { child: childrenList[0] });
    } else {
      familySentence = abT('child_only_many', { list: childrenList.slice(0, -1).join(', '), last: childrenList[childrenList.length - 1] });
    }
    if (childrenDeceased && childrenDeathNote) familySentence += ' (' + abTr(childrenDeathNote) + ')';
    if (familyGeneral) familySentence += abT('child_only_note', { note: cleanNote(familyGeneral) });
  } else if (familyGeneral) {
    familySentence = abT('family_general', { note: cleanNote(familyGeneral) });
  } else {
    familySentence = abT('family_default');
  }
  p1 += ' ' + familySentence;
  paragraphs.push(p1);

  /* Paragraph 2 — education */
  var p2 = '';
  if (edus && edus.length > 0) {
    p2 += abT('edu_intro');
    var eduSentences = [];
    edus.forEach(function (edu) {
      var eduName = abLower(abTr(edu.name));
      var school = abTr(edu.school);
      var suffix = abT('date_suffix');
      if (school) {
        if (edu.start && edu.end) {
          eduSentences.push(abT('edu_school_years', { start: edu.start, end: edu.end, suffix: suffix, school: school, name: eduName }));
        } else {
          eduSentences.push(abT('edu_school', { school: school, name: eduName }));
        }
      } else {
        if (edu.start && edu.end) {
          eduSentences.push(abT('edu_years', { start: edu.start, end: edu.end, suffix: suffix, name: eduName }));
        } else {
          eduSentences.push(abT('edu_level', { name: abTr(edu.name) }));
        }
      }
    });
    if (eduSentences.length === 1) {
      p2 += eduSentences[0] + '.';
    } else if (eduSentences.length > 1) {
      p2 += eduSentences.slice(0, -1).join(', ') + abT('edu_join') + eduSentences[eduSentences.length - 1] + '.';
    }
    p2 += abT('edu_closing_one');
  } else {
    p2 += abT('edu_closing_two');
  }
  paragraphs.push(p2);

  /* Paragraph 3 — career */
  var p3 = '';
  if ((sectors && sectors.length > 0) || services || currentJob) {
    p3 += abT('career_intro');
    if (sectors && sectors.length > 0) {
      var sectorSentences = [];
      sectors.forEach(function (sec) {
        var suffix = abT('date_suffix');
        var timeStr = '';
        if (sec.start && sec.end) {
          timeStr = abT('career_years', { start: sec.start, end: sec.end, suffix: suffix });
        } else if (sec.start && sec.current) {
          timeStr = abT('career_since_now', { start: sec.start, suffix: suffix });
        } else if (sec.start) {
          timeStr = abT('career_since', { start: sec.start, suffix: suffix });
        }
        var secName = abTr(sec.name);
        var secLow = abLower(secName);
        var isOther = /digər|diger|özəl|ozel|other|друг|diğer|özel/i.test(secLow) || sec.id === 'other' || sec.key === 'other';
        var place = abTr(sec.place);
        var workStr = '';
        if (place) {
          var pl = abLower(place);
          if (isOther) {
            if (/mmc|məhdud|bank|təşkilat|teskilat|şirkət|sirket|firma|maxe|llc|ltd|company|inc|ооо|оао|ао/i.test(pl)) {
              workStr = abT('work_org', { place: place });
            } else {
              workStr = abT('work_enterprise', { place: place });
            }
          } else {
            workStr = abT('work_sector', { place: place, sector: secLow });
          }
        } else {
          workStr = isOther ? abT('work_various') : abT('work_in_sector', { sector: secLow });
        }
        sectorSentences.push(timeStr + workStr);
      });
      if (sectorSentences.length === 1) {
        p3 += abT('career_one', { item: sectorSentences[0] });
      } else if (sectorSentences.length > 1) {
        p3 += abT('career_many', { list: sectorSentences.slice(0, -1).join(', '), last: sectorSentences[sectorSentences.length - 1] });
      }
    }
    if (services) p3 += abT('career_services', { services: abLower(abTr(services)) });
    if (currentJob) p3 += abT('career_current', { job: abTr(currentJob) });
  } else {
    p3 += abT('career_default');
  }
  paragraphs.push(p3);

  /* Paragraph 4 — future goals */
  var p4 = '';
  if (goals && goals.length > 0) {
    p4 += abT('goals_intro');
    var gl = goals.map(function (g) { return abLower(abTr(g)); });
    if (gl.length === 1) {
      p4 += abT('goals_one', { a: gl[0] });
    } else if (gl.length === 2) {
      p4 += abT('goals_two', { a: gl[0], b: gl[1] });
    } else {
      p4 += abT('goals_many', { list: gl.slice(0, -1).join(', '), last: gl[gl.length - 1] });
    }
    p4 += abT('goals_effort');
  } else {
    p4 += abT('goals_default');
  }
  paragraphs.push(p4);

  /* Tone-specific closing */
  var ab = (window.__SKY_AB__ && (window.__SKY_AB__[abLang()] || window.__SKY_AB__.az)) || {};
  var toneKey = 'tone_' + (tone || 'samimi');
  paragraphs.push(ab[toneKey] ? abT(toneKey) : abT('tone_samimi'));

  return paragraphs.join('\n\n');
}
function typewriterEffect(el, text, speed, callback) {
  el.textContent = '';
  var i = 0;
  function type() {
    if (i < text.length) {
      el.textContent += text.charAt(i);
      i++;
      setTimeout(type, speed);
    } else {
      if (typeof callback === 'function') {
        callback();
      }
    }
  }
  type();
}

function copyAutobio() {
  var text = document.getElementById('autobio-result-text').textContent;
  var firstname = (document.getElementById('autobio-firstname') ? document.getElementById('autobio-firstname').value.trim() : '');
  var lastname = (document.getElementById('autobio-lastname') ? document.getElementById('autobio-lastname').value.trim() : '');
  var patronymic = (document.getElementById('autobio-patronymic') ? document.getElementById('autobio-patronymic').value.trim() : '');
  var name = [firstname, lastname, patronymic].filter(Boolean).join(' ') || abT('doc_title');
  var dateStr = getFormattedDate();
  var textToCopy = text + "\n\n" + abT('date_label') + " " + dateStr + "\n" + abT('signature_label') + " ____________________ (" + name + ")";
  
  if (navigator.clipboard) {
    navigator.clipboard.writeText(textToCopy).then(function() {
      var btn = document.getElementById('autobio-copy-btn');
      btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> ' + abT('copied');
      btn.style.color = '#10b981';
      btn.style.borderColor = 'rgba(16,185,129,0.4)';
      setTimeout(function(){
        btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> ' + abT('copy');
        btn.style.color = '';
        btn.style.borderColor = '';
      }, 2200);
    });
  } else {
    var ta = document.createElement('textarea');
    ta.value = textToCopy;
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
  }
}

function downloadAutobio() {
  var text = document.getElementById('autobio-result-text').textContent;
  var firstname = (document.getElementById('autobio-firstname') ? document.getElementById('autobio-firstname').value.trim() : '');
  var lastname = (document.getElementById('autobio-lastname') ? document.getElementById('autobio-lastname').value.trim() : '');
  var patronymic = (document.getElementById('autobio-patronymic') ? document.getElementById('autobio-patronymic').value.trim() : '');
  var name = [firstname, lastname, patronymic].filter(Boolean).join(' ') || abT('doc_title');
  var dateStr = getFormattedDate();
  var textWithSig = text + "\n\n" + abT('date_label') + " " + dateStr + "\n" + abT('signature_label') + " ____________________ (" + name + ")";
  
  var blob = new Blob([textWithSig], { type: 'text/plain;charset=utf-8' });
  var url = URL.createObjectURL(blob);
  var a = document.createElement('a');
  a.href = url;
  a.download = name.replace(/\s+/g,'_') + '_' + abT('doc_title') + '.txt';
  a.click();
  URL.revokeObjectURL(url);
}

function downloadAutobioPDF() {
  var docTitle = abT('doc_title');
  var dateLabel = abT('date_label');
  var signLabel = abT('signature_label');
  var text = document.getElementById('autobio-result-text').textContent;
  var firstname = (document.getElementById('autobio-firstname') ? document.getElementById('autobio-firstname').value.trim() : '');
  var lastname = (document.getElementById('autobio-lastname') ? document.getElementById('autobio-lastname').value.trim() : '');
  var patronymic = (document.getElementById('autobio-patronymic') ? document.getElementById('autobio-patronymic').value.trim() : '');
  var name = [firstname, lastname, patronymic].filter(Boolean).join(' ') || abT('doc_title');
  
  // Format text to HTML paragraphs for clean styling
  var paragraphs = text.split('\n\n');
  var contentHtml = '';
  
  paragraphs.forEach(function(para) {
    var pTrimmed = para.trim();
    if (!pTrimmed.startsWith(dateLabel) && !pTrimmed.startsWith(signLabel) && !pTrimmed.startsWith('Tarix:') && !pTrimmed.startsWith('İmza:') && pTrimmed) {
      contentHtml += '<p class="content-para">' + pTrimmed + '</p>';
    }
  });

  var printWindow = window.open('', '_blank', 'width=850,height=1100');
  printWindow.document.write('<!DOCTYPE html><html lang="' + abLang() + '"><head><title>' + docTitle + ' - ' + name + '</title>');
  printWindow.document.write('<style>');
  printWindow.document.write('@page { size: A4; margin: 2.5cm 2cm; }');
  printWindow.document.write('body { font-family: "Times New Roman", Times, serif; font-size: 14pt; line-height: 1.65; color: #000; background: #fff; padding: 0; margin: 0; }');
  printWindow.document.write('.title { text-align: center; font-weight: bold; font-size: 18pt; margin-bottom: 2.2cm; text-transform: uppercase; letter-spacing: 1.5px; }');
  printWindow.document.write('.content-para { text-align: justify; text-indent: 1.25cm; margin-bottom: 0.6cm; margin-top: 0; }');
  printWindow.document.write('.footer-section { margin-top: 2.5cm; font-size: 12pt; display: flex; justify-content: space-between; align-items: flex-end; }');
  printWindow.document.write('.footer-left { text-align: left; }');
  printWindow.document.write('.footer-right { text-align: right; line-height: 1.5; position: relative; min-width: 200px; }');
  printWindow.document.write('</style></head><body>');
  printWindow.document.write('<div class="title">' + docTitle + '</div>');
  printWindow.document.write('<div class="content">' + contentHtml + '</div>');
  
  var dateStr = getFormattedDate();
  printWindow.document.write('<div class="footer-section">');
  printWindow.document.write('  <div class="footer-left"><strong>' + dateLabel + '</strong> ' + dateStr + '</div>');
  
  var signatureDataUrl = window.currentAutobioSignature;
  if (signatureDataUrl) {
    printWindow.document.write('  <div class="footer-right">');
    printWindow.document.write('    <div style="position: absolute; bottom: 22px; right: 25px; height: 50px;">');
    printWindow.document.write('      <img src="' + signatureDataUrl + '" style="height: 55px; max-width: 150px;">');
    printWindow.document.write('    </div>');
    printWindow.document.write('    <strong>' + signLabel + '</strong> <span style="color: transparent;">____________________</span><br>(' + name + ')');
    printWindow.document.write('  </div>');
  } else {
    printWindow.document.write('  <div class="footer-right"><strong>' + signLabel + '</strong> ____________________<br>(' + name + ')</div>');
  }
  printWindow.document.write('</div>');
  
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  
  printWindow.focus();
  setTimeout(function() {
    printWindow.print();
    printWindow.close();
  }, 400);
}

function autobioReset() {
  document.getElementById('autobio-form-area').style.display = 'block';
  document.getElementById('autobio-result-area').classList.remove('active');
  
  // Clear inputs
  document.getElementById('autobio-firstname').value = '';
  document.getElementById('autobio-lastname').value = '';
  document.getElementById('autobio-patronymic').value = '';
  document.getElementById('autobio-birth-day').value = '';
  document.getElementById('autobio-birth-month').value = '';
  document.getElementById('autobio-birth-year').value = '';
  document.getElementById('autobio-age').value = '';
  
  var genderSelect = document.getElementById('autobio-gender-select');
  if (genderSelect) {
    genderSelect.value = 'kisi';
    genderSelect.dispatchEvent(new Event('change'));
  }
  
  document.getElementById('autobio-father').value = '';
  document.getElementById('autobio-mother').value = '';
  document.getElementById('autobio-spouse').value = '';
  document.getElementById('autobio-children').value = '';
  document.getElementById('autobio-family').value = '';

  // Reset deceased checkboxes and death dates
  ['father', 'mother', 'spouse', 'children'].forEach(function(m) {
    var cb = document.getElementById('fam-' + m + '-deceased');
    if (cb) { cb.checked = false; }
    var row = document.getElementById('fam-' + m + '-death-row');
    if (row) { row.style.display = 'none'; }
    var dd = document.getElementById('fam-' + m + '-deathdate');
    if (dd) { dd.value = ''; }
  });
  
  // Reset Sectors
  var sectorCheckboxes = document.querySelectorAll('.sector-checkbox');
  sectorCheckboxes.forEach(function(cb) {
    cb.checked = false;
    var item = cb.closest('.autobio-checkbox-item');
    var key = item.id.replace('sector-item-', '');
    toggleSectorInputs(key);
  });
  
  // Reset Edus
  var eduCheckboxes = document.querySelectorAll('.edu-checkbox');
  eduCheckboxes.forEach(function(cb) {
    cb.checked = false;
    var item = cb.closest('.autobio-checkbox-item');
    var key = item.id.replace('edu-item-', '');
    toggleEduInputs(key);
  });
  
  // Reset Goals
  var goalCheckboxes = document.querySelectorAll('.goal-checkbox');
  goalCheckboxes.forEach(function(cb) {
    cb.checked = false;
    var item = cb.closest('.autobio-checkbox-item');
    var key = item.id.replace('goal-item-', '');
    toggleGoalItem(key);
  });
  document.getElementById('autobio-goals-custom').value = '';
  
  // Reset Services & Current Job
  document.getElementById('autobio-services').value = '';
  document.getElementById('autobio-current-job').value = '';
  
  // Reset signature
  clearSignatureCanvas();
}
</script>

<!-- ══════════════════════════════════════════════════════════════
     SKYBOT — Skyweb.az Intelligent Website Guide
     Floating chat widget · Internal knowledge search · No external AI
══════════════════════════════════════════════════════════════ -->
<style>
/* ── SkyBot Widget Styles ─────────────────────────────────────────────────── */
#skybot-widget {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 9990;
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 12px;
  pointer-events: none;
}
#skybot-widget > * { pointer-events: auto; }

/* ── FAB (Floating Action Button) ── */
#skybot-fab {
  position: relative;
  width: 62px;
  height: 62px;
  border-radius: 50%;
  background: linear-gradient(135deg, #003d52 0%, #001e2b 100%);
  border: 2px solid rgba(0,229,255,0.55);
  box-shadow: 0 0 0 0 rgba(0,229,255,0.45), 0 8px 30px rgba(0,0,0,0.6);
  cursor: pointer;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 2px;
  transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1),
              border-color 0.3s ease,
              box-shadow 0.3s ease;
  animation: skybot-pulse 3s ease-in-out infinite;
}
#skybot-fab:hover {
  transform: scale(1.08);
  border-color: rgba(0,229,255,0.9);
  box-shadow: 0 0 0 8px rgba(0,229,255,0.12), 0 8px 30px rgba(0,0,0,0.7);
}
#skybot-fab.skybot-fab-active {
  animation: none;
  border-color: rgba(0,229,255,0.9);
  box-shadow: 0 0 0 6px rgba(0,229,255,0.15), 0 8px 30px rgba(0,0,0,0.7);
}
@keyframes skybot-pulse {
  0%, 100% { box-shadow: 0 0 0 0 rgba(0,229,255,0.45), 0 8px 30px rgba(0,0,0,0.6); }
  50%       { box-shadow: 0 0 0 14px rgba(0,229,255,0.0), 0 8px 30px rgba(0,0,0,0.6); }
}
.skybot-fab-ring {
  position: absolute;
  inset: -6px;
  border-radius: 50%;
  border: 1.5px solid rgba(0,229,255,0.25);
  animation: skybot-ring-spin 8s linear infinite;
}
@keyframes skybot-ring-spin {
  from { transform: rotate(0deg); }
  to   { transform: rotate(360deg); }
}
/* Skyweb monogram — a single modern "S" mark (replaces the old icon). */
.skybot-fab-icon {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
}
.skybot-fab-mark {
  font-family: var(--font-heading, inherit);
  font-size: 30px;
  font-weight: 900;
  line-height: 1;
  letter-spacing: -0.06em;
  background: linear-gradient(160deg, #ffffff 0%, #7df9ff 45%, #00a8c6 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 0 7px rgba(0,229,255,0.65));
  transform: translateY(-1px);
}
#skybot-fab.skybot-fab-active .skybot-fab-icon {
  transform: scale(1.06);
}
.skybot-fab-label {
  font-size: 9px;
  font-weight: 700;
  color: rgba(0,229,255,0.8);
  letter-spacing: 0.06em;
  line-height: 1;
}
.skybot-fab-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  width: 20px;
  height: 20px;
  background: linear-gradient(135deg,#00e5ff,#38bdf8);
  border-radius: 50%;
  border: 2px solid #020f18;
  font-size: 10px;
  font-weight: 800;
  color: #020f18;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: skybot-badge-pop 0.4s cubic-bezier(0.34,1.56,0.64,1) both;
}
@keyframes skybot-badge-pop {
  from { transform: scale(0); opacity: 0; }
  to   { transform: scale(1); opacity: 1; }
}

/* ── Chat Panel ── */
.skybot-panel {
  width: 360px;
  max-height: 0;
  overflow: hidden;
  background: linear-gradient(160deg, rgba(3,22,32,0.98) 0%, rgba(1,12,18,0.99) 100%);
  border: 1px solid rgba(0,229,255,0.28);
  border-radius: 18px;
  box-shadow: 0 24px 60px rgba(0,0,0,0.7), 0 0 40px rgba(0,229,255,0.08);
  display: flex;
  flex-direction: column;
  opacity: 0;
  transform: translateY(16px) scale(0.97);
  transform-origin: bottom right;
  transition: max-height 0.45s cubic-bezier(0.16,1,0.3,1),
              opacity 0.35s ease,
              transform 0.35s cubic-bezier(0.16,1,0.3,1);
  will-change: transform, opacity;
}
.skybot-panel.skybot-open {
  max-height: 580px;
  opacity: 1;
  transform: translateY(0) scale(1);
}

/* ── Header ── */
.skybot-header {
  position: relative;
  padding: 1rem 1.1rem 0.85rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(0,229,255,0.15);
  overflow: hidden;
  flex-shrink: 0;
}
.skybot-header::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 2px;
  background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 55%, #c084fc 100%);
  box-shadow: 0 0 12px rgba(0,240,255,0.7);
}
/* Animated scanline behind header */
.skybot-header::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(0,229,255,0.03) 0%, transparent 100%);
  pointer-events: none;
}
.skybot-header-left {
  display: flex;
  align-items: center;
  gap: 0.7rem;
}
.skybot-avatar {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(0,229,255,0.15), rgba(192,132,252,0.1));
  border: 1.5px solid rgba(0,229,255,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  flex-shrink: 0;
  overflow: hidden;
}
.skybot-avatar::before {
  content: '';
  position: absolute;
  inset: -2px;
  border-radius: 50%;
  background: conic-gradient(from 0deg, transparent 60%, rgba(0,229,255,0.5) 80%, transparent 100%);
  animation: skybot-avatar-spin 3s linear infinite;
}
@keyframes skybot-avatar-spin {
  from { transform: rotate(0deg); }
  to   { transform: rotate(360deg); }
}
.skybot-avatar-inner {
  position: relative;
  z-index: 1;
  width: 22px;
  height: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.skybot-avatar-letter {
  font-family: var(--font-heading, inherit);
  font-size: 22px;
  font-weight: 900;
  line-height: 1;
  letter-spacing: -0.05em;
  background: linear-gradient(160deg, #ffffff 0%, #7df9ff 50%, #00b4d8 100%);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  filter: drop-shadow(0 0 4px rgba(0,229,255,0.85));
}
.skybot-name {
  font-size: 0.9rem;
  font-weight: 700;
  color: #e2e8f0;
  letter-spacing: 0.01em;
}
.skybot-status {
  font-size: 0.72rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 4px;
}
.skybot-status-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 0 6px rgba(34,197,94,0.7);
  animation: skybot-blink 2s ease-in-out infinite;
}
@keyframes skybot-blink {
  0%,100% { opacity: 1; }
  50%      { opacity: 0.4; }
}
.skybot-header-actions {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}
.skybot-clear-btn,
.skybot-close-btn {
  background: none;
  border: none;
  color: #64748b;
  cursor: pointer;
  font-size: 0.95rem;
  padding: 0.3rem 0.4rem;
  border-radius: 7px;
  transition: color 0.2s, background 0.2s;
  line-height: 1;
}
.skybot-clear-btn svg,
.skybot-close-btn svg {
  width: 15px;
  height: 15px;
  display: block;
  stroke: currentColor;
}
.skybot-clear-btn:hover { color: #f87171; background: rgba(248,113,113,0.1); }
.skybot-close-btn:hover { color: #e2e8f0; background: rgba(255,255,255,0.07); }

/* Quick-reply chips intentionally removed: the bot only answers questions. */

/* ── Messages Area ── */
.skybot-messages {
  flex: 1;
  overflow-y: auto;
  padding: 0.85rem 1rem;
  display: flex;
  flex-direction: column;
  gap: 0.65rem;
  scroll-behavior: smooth;
  min-height: 0;
}
.skybot-messages::-webkit-scrollbar { width: 4px; }
.skybot-messages::-webkit-scrollbar-track { background: transparent; }
.skybot-messages::-webkit-scrollbar-thumb { background: rgba(0,229,255,0.2); border-radius: 4px; }

/* Message bubbles */
.skybot-msg { display: flex; }
.skybot-msg-bot { justify-content: flex-start; }
.skybot-msg-user { justify-content: flex-end; }
.skybot-bubble {
  max-width: 85%;
  padding: 0.65rem 0.9rem;
  border-radius: 14px;
  font-size: 0.83rem;
  line-height: 1.55;
  word-break: break-word;
  animation: skybot-msg-in 0.3s cubic-bezier(0.16,1,0.3,1) both;
}
@keyframes skybot-msg-in {
  from { opacity: 0; transform: translateY(8px) scale(0.96); }
  to   { opacity: 1; transform: translateY(0) scale(1); }
}
.skybot-msg-bot .skybot-bubble {
  background: rgba(0,229,255,0.07);
  border: 1px solid rgba(0,229,255,0.18);
  border-bottom-left-radius: 4px;
  color: #cbd5e1;
}
.skybot-msg-user .skybot-bubble {
  background: linear-gradient(135deg, rgba(0,229,255,0.22) 0%, rgba(56,189,248,0.18) 100%);
  border: 1px solid rgba(0,229,255,0.35);
  border-bottom-right-radius: 4px;
  color: #e2e8f0;
}
/* Links inside bot messages */
.skybot-links {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
  margin-top: 0.5rem;
}
.skybot-link-btn {
  display: inline-block;
  background: rgba(0,229,255,0.1);
  border: 1px solid rgba(0,229,255,0.3);
  color: #00e5ff;
  font-size: 0.75rem;
  padding: 0.3rem 0.7rem;
  border-radius: 8px;
  text-decoration: none;
  transition: background 0.2s;
}
.skybot-link-btn:hover { background: rgba(0,229,255,0.2); }

/* Typing indicator */
.skybot-typing-indicator .skybot-bubble {
  display: flex;
  align-items: center;
  gap: 5px;
  padding: 0.65rem 0.9rem;
  min-width: 56px;
}
.skybot-typing-indicator .skybot-bubble span {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #00e5ff;
  opacity: 0.5;
  animation: skybot-dot 1.2s ease-in-out infinite;
}
.skybot-typing-indicator .skybot-bubble span:nth-child(2) { animation-delay: 0.2s; }
.skybot-typing-indicator .skybot-bubble span:nth-child(3) { animation-delay: 0.4s; }
@keyframes skybot-dot {
  0%,80%,100% { transform: scale(0.7); opacity: 0.4; }
  40%          { transform: scale(1.1); opacity: 1; }
}

/* ── Input Area ── */
.skybot-input-area {
  display: flex;
  align-items: flex-end;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  border-top: 1px solid rgba(0,229,255,0.12);
  flex-shrink: 0;
}
#skybot-input {
  flex: 1;
  background: rgba(0,229,255,0.05);
  border: 1px solid rgba(0,229,255,0.2);
  border-radius: 14px;
  color: #e2e8f0;
  font-size: 0.85rem;
  padding: 0.65rem 0.9rem;
  resize: none;
  outline: none;
  min-height: 40px;
  max-height: 120px;
  line-height: 1.45;
  font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  overflow-y: auto;
  /* No up/down arrows or scrollbar grip inside the message box. */
  scrollbar-width: none;
  -ms-overflow-style: none;
  appearance: none;
}
#skybot-input::-webkit-scrollbar { width: 0; height: 0; display: none; }
#skybot-input:focus {
  border-color: rgba(0,229,255,0.6);
  background: rgba(0,229,255,0.075);
  box-shadow: 0 0 0 3px rgba(0,229,255,0.08);
}
#skybot-input::placeholder { color: #64748b; }
.skybot-send-btn {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: linear-gradient(135deg, #00e5ff, #38bdf8);
  border: none;
  color: #020f18;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: transform 0.2s, opacity 0.2s;
}
.skybot-send-btn:hover { transform: scale(1.07); }
.skybot-send-btn:active { transform: scale(0.95); }

/* ── Footer ── */
.skybot-footer {
  text-align: center;
  font-size: 0.68rem;
  color: #1e3a4a;
  padding: 0.4rem 0.5rem 0.7rem;
  flex-shrink: 0;
  letter-spacing: 0.04em;
}

/* ── Mobile Responsive ── */
@media (max-width: 480px) {
  #skybot-widget { right: 12px; bottom: 16px; }
  .skybot-panel { width: calc(100vw - 24px); }
  .skybot-panel.skybot-open { max-height: 75vh; }
}
@media (max-width: 360px) {
  #skybot-fab { width: 54px; height: 54px; }
}
</style>

<div id="skybot-widget" role="complementary" aria-label="<?= e(__('skybot_aria_assistant', 'SkyBot Köməkçi')) ?>">
  <!-- ── Floating Action Button ── -->
  <button id="skybot-fab" type="button" aria-label="<?= e(__('skybot_fab_aria', 'SkyBot köməkçisini aç')) ?>" onclick="skybotToggle()" aria-expanded="false">
    <div class="skybot-fab-ring"></div>
    <div class="skybot-fab-icon" aria-hidden="true">
      <span class="skybot-fab-mark">S</span>
    </div>
    <span class="skybot-fab-label" data-i18n="skybot_title"><?= e(__('skybot_title', 'SkyBot')) ?></span>
    <span class="skybot-fab-badge" id="skybot-fab-badge" aria-hidden="true" style="display:none">1</span>
  </button>

  <!-- ── Chat Panel ── -->
  <div id="skybot-panel" class="skybot-panel" aria-hidden="true" role="dialog" aria-label="<?= e(__('skybot_title', 'SkyBot Chat')) ?>">

    <!-- Header -->
    <div class="skybot-header">
      <div class="skybot-header-left">
        <div class="skybot-avatar" aria-hidden="true">
          <span class="skybot-avatar-inner"><span class="skybot-avatar-letter">S</span></span>
        </div>
        <div>
          <div class="skybot-name" data-i18n="skybot_title"><?= e(__('skybot_title', 'SkyBot')) ?></div>
          <div class="skybot-status">
            <span class="skybot-status-dot" aria-hidden="true"></span>
            <span id="skybot-status-text" data-i18n="skybot_status_online"><?= e(__('skybot_status_online', 'Online')) ?></span>
          </div>
        </div>
      </div>
      <div class="skybot-header-actions">
        <button class="skybot-clear-btn" onclick="skybotClear()" title="<?= e(__('skybot_clear_title', 'Söhbəti təmizlə')) ?>" aria-label="<?= e(__('skybot_clear_title', 'Söhbəti təmizlə')) ?>" data-i18n-title="skybot_clear_title">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13M10 11v5M14 11v5"/>
          </svg>
        </button>
        <button class="skybot-close-btn" onclick="skybotToggle()" aria-label="<?= e(__('skybot_close_aria', 'SkyBot-u bağla')) ?>" data-i18n-aria="skybot_close_aria">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 6l12 12M18 6L6 18"/>
          </svg>
        </button>
      </div>
    </div>

    <!-- No quick-reply chips: the assistant only answers asked questions. -->

    <!-- Messages -->
    <div class="skybot-messages" id="skybot-messages" aria-live="polite" aria-label="<?= e(__('skybot_title', 'Söhbət')) ?>"></div>

    <!-- Input -->
    <div class="skybot-input-area">
      <textarea
        id="skybot-input"
        placeholder="<?= e(__('skybot_input_ph', 'Sualınızı yazın...')) ?>"
        rows="1"
        aria-label="<?= e(__('skybot_input_ph', 'Sualınızı yazın')) ?>"
        data-i18n-placeholder="skybot_input_ph"
        onkeydown="skybotKeyDown(event)"
        oninput="skybotAutoResize(this)"
      ></textarea>
      <button class="skybot-send-btn" onclick="skybotSend()" aria-label="<?= e(__('skybot_send_aria', 'Göndər')) ?>" data-i18n-aria="skybot_send_aria">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M4.5 12h14"/>
          <path d="M13 6.5 18.5 12 13 17.5"/>
        </svg>
      </button>
    </div>

    <div class="skybot-footer" data-i18n="skybot_footer_text"><?= e(__('skybot_footer_text', 'Skyweb.az • Rəsmi Ağıllı Xidmət Köməkçisi')) ?></div>
  </div><!-- /.skybot-panel -->
</div><!-- /#skybot-widget -->

<script>
/* ══════════════════════════════════════════════════════
   SKYBOT — Skyweb.az Multilingual Intelligent Assistant
   Full AZ / EN / RU / TR support · Verified Service Guide
══════════════════════════════════════════════════════ */
(function () {
  'use strict';

  /* ── State ── */
  var skybotOpen     = false;
  var skybotGreeted  = false;
  var skybotLang     = 'az';

  /* ── Multilingual UI dictionary for dynamic switching ──
   * No chip/query prompts: the widget never offers suggestions. It greets once,
   * then only replies to what the visitor actually asks. */
  var botI18n = {
    az: {
      status: 'Online',
      ph: 'Sualınızı yazın...',
      footer: 'Skyweb.az • Rəsmi Ağıllı Xidmət Köməkçisi',
      greetingText: 'Salam, mən Sky botam. Sizə necə kömək edə bilərəm? Kömək edə bilməyim üçün fikrinizi sual şəklində ifadə edin.',
      err_no_reply: '⚠️ Cavab alınmadı. Yenidən cəhd edin.',
      err_conn: '⚠️ Bağlantı xətası. Zəhmət olmasa yenidən cəhd edin.'
    },
    en: {
      status: 'Online',
      ph: 'Ask your question...',
      footer: 'Skyweb.az • Official Smart Support Assistant',
      greetingText: "Hello, I'm Sky bot. How can I help you? Write your question so I can help you.",
      err_no_reply: '⚠️ No response received. Please try again.',
      err_conn: '⚠️ Connection error. Please try again.'
    },
    ru: {
      status: 'В сети',
      ph: 'Напишите ваш вопрос...',
      footer: 'Skyweb.az • Официальный умный ассистент',
      greetingText: 'Здравствуйте, я Sky bot. Чем могу помочь? Напишите ваш вопрос, чтобы я мог помочь.',
      err_no_reply: '⚠️ Ответ не получен. Попробуйте еще раз.',
      err_conn: '⚠️ Ошибка соединения. Попробуйте еще раз.'
    },
    tr: {
      status: 'Çevrimiçi',
      ph: 'Sorunuzu yazın...',
      footer: 'Skyweb.az • Resmi Akıllı Destek Asistanı',
      greetingText: 'Merhaba, ben Sky bot. Size nasıl yardımcı olabilirim? Yardımcı olabilmem için sorunuzu yazın.',
      err_no_reply: '⚠️ Yanıt alınamadı. Lütfen tekrar deneyin.',
      err_conn: '⚠️ Bağlantı hatası. Lütfen tekrar deneyin.'
    }
  };

  /* Detect initial language */
  function detectLang() {
    var valid = ['az', 'en', 'ru', 'tr'];
    if (typeof SkyI18n !== 'undefined' && SkyI18n.currentLang && valid.indexOf(SkyI18n.currentLang()) !== -1) {
      return SkyI18n.currentLang();
    }
    var cookieMatch = document.cookie.match(/sky_lang=([a-z]{2})/);
    if (cookieMatch && valid.indexOf(cookieMatch[1]) !== -1) {
      return cookieMatch[1];
    }
    var htmlLang = (document.documentElement.lang || '').slice(0, 2);
    if (valid.indexOf(htmlLang) !== -1) {
      return htmlLang;
    }
    return 'az';
  }
  skybotLang = detectLang();

  /* Apply language to UI elements */
  function skybotSetLang(lang) {
    if (!botI18n[lang]) lang = 'az';
    skybotLang = lang;
    var t = botI18n[lang];

    var statusEl = document.getElementById('skybot-status-text');
    if (statusEl) statusEl.textContent = t.status;

    var inputEl = document.getElementById('skybot-input');
    if (inputEl) inputEl.setAttribute('placeholder', t.ph);

    var footerEl = document.querySelector('.skybot-footer');
    if (footerEl) footerEl.textContent = t.footer;

    // Greeting is rendered locally, so switch it in place instead of calling
    // the API with a keyword (which used to produce suggestion lists).
    var greetingBubble = document.querySelector('#skybot-messages [data-bot-greeting="1"] .skybot-bubble');
    if (greetingBubble) greetingBubble.textContent = t.greetingText;
  }

  /* ── Local greeting (no API call, no suggestion lists) ── */
  function skybotAddGreeting() {
    var msgs = document.getElementById('skybot-messages');
    if (!msgs) return;
    var old = msgs.querySelector('[data-bot-greeting="1"]');
    if (old && old.parentNode) old.parentNode.removeChild(old);

    var div = document.createElement('div');
    div.className = 'skybot-msg skybot-msg-bot';
    div.setAttribute('data-bot-greeting', '1');
    var bubble = document.createElement('div');
    bubble.className = 'skybot-bubble';
    bubble.textContent = (botI18n[skybotLang] || botI18n.az).greetingText;
    div.appendChild(bubble);
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  /* Re-ask previously answered questions in the newly selected language,
     so the conversation does not stay half-Azerbaijani after a switch. */
  function skybotRerenderHistory() {
    var old = document.querySelectorAll('#skybot-messages .skybot-msg-bot[data-bot-query]');
    Array.prototype.forEach.call(old, function (el) {
      skybotSendToApi(el.getAttribute('data-bot-query'), el);
    });
  }

  // Listen to site language changes
  document.addEventListener('sky-lang-changed', function (e) {
    if (e && e.detail && e.detail.lang) {
      skybotSetLang(e.detail.lang);
      skybotRerenderHistory();
    }
  });

  /* ── Toggle Open/Close ── */
  function skybotToggle() {
    skybotOpen = !skybotOpen;
    var panel  = document.getElementById('skybot-panel');
    var fab    = document.getElementById('skybot-fab');
    var badge  = document.getElementById('skybot-fab-badge');

    panel.classList.toggle('skybot-open', skybotOpen);
    panel.setAttribute('aria-hidden', skybotOpen ? 'false' : 'true');
    fab.setAttribute('aria-expanded', skybotOpen ? 'true' : 'false');
    fab.classList.toggle('skybot-fab-active', skybotOpen);

    if (skybotOpen) {
      if (badge) badge.style.display = 'none';
      /* Show the greeting on first open — locally, without API suggestions. */
      if (!skybotGreeted) {
        skybotGreeted = true;
        setTimeout(skybotAddGreeting, 250);
      }
      setTimeout(function () {
        var inp = document.getElementById('skybot-input');
        if (inp) inp.focus();
      }, 420);
    }
  }

  /* ── Send on Enter ── */
  function skybotKeyDown(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      skybotSend();
    }
  }

  /* ── Auto-resize textarea ── */
  function skybotAutoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
  }

  /* ── Send user message ── */
  function skybotSend() {
    var input = document.getElementById('skybot-input');
    if (!input) return;
    var msg = input.value.trim();
    if (!msg) return;
    input.value = '';
    input.style.height = 'auto';
    skybotAddMessage('user', msg, []);
    skybotSendToApi(msg);
  }

  /* ── Add message bubble ── */
  function skybotAddMessage(role, text, links, query, target) {
    var msgs = document.getElementById('skybot-messages');
    if (!msgs && !target) return;

    var div = target || document.createElement('div');
    div.className = 'skybot-msg skybot-msg-' + role;
    if (role === 'bot' && query) div.setAttribute('data-bot-query', query);

    /* Sanitize & format: **bold**, newlines */
    var safe = text
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
      .replace(/\n/g, '<br>');

    var bubble = document.createElement('div');
    bubble.className = 'skybot-bubble';
    bubble.innerHTML = safe;
    div.appendChild(bubble);

    /* Action links */
    if (links && links.length) {
      var linksDiv = document.createElement('div');
      linksDiv.className = 'skybot-links';
      links.forEach(function (l) {
        var a = document.createElement('a');
        a.href        = l.url   || '#';
        a.textContent = l.label || l.url;
        a.className   = 'skybot-link-btn';
        if (l.url && (l.url.indexOf('http') === 0 || l.url.indexOf('modules/') === 0)) {
          a.target = '_blank';
          a.rel    = 'noopener';
        }
        linksDiv.appendChild(a);
      });
      div.appendChild(linksDiv);
    }

    if (!target) msgs.appendChild(div);
    if (msgs) msgs.scrollTop = msgs.scrollHeight;
  }

  /* ── Typing indicator ── */
  function skybotShowTyping() {
    var msgs = document.getElementById('skybot-messages');
    if (!msgs) return;
    var div = document.createElement('div');
    div.className = 'skybot-msg skybot-msg-bot skybot-typing-indicator';
    div.id        = 'skybot-typing';
    div.innerHTML = '<div class="skybot-bubble"><span></span><span></span><span></span></div>';
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function skybotHideTyping() {
    var t = document.getElementById('skybot-typing');
    if (t && t.parentNode) t.parentNode.removeChild(t);
  }

  /* ── Clear conversation ── */
  function skybotClear() {
    var msgs = document.getElementById('skybot-messages');
    if (msgs) msgs.innerHTML = '';
    skybotGreeted = true;
    setTimeout(skybotAddGreeting, 150);
  }

  /* ── API call to chat.php ── */
  function skybotSendToApi(message, replaceEl) {
    if (!replaceEl) skybotShowTyping();
    var payload = JSON.stringify({ message: message, lang: skybotLang });

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'skybot/chat.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.timeout = 10000;

    xhr.onload = function () {
      if (!replaceEl) skybotHideTyping();
      var t = botI18n[skybotLang] || botI18n.az;
      try {
        var data = JSON.parse(xhr.responseText);
        skybotAddMessage('bot', data.reply || '...', data.links || [], message, replaceEl);
      } catch (e) {
        skybotAddMessage('bot', t.err_no_reply, [], message, replaceEl);
      }
    };
    xhr.onerror = xhr.ontimeout = function () {
      if (!replaceEl) skybotHideTyping();
      var t = botI18n[skybotLang] || botI18n.az;
      skybotAddMessage('bot', t.err_conn, [], message, replaceEl);
    };
    xhr.send(payload);
  }

  /* ── Show badge after 4s if still closed ── */
  setTimeout(function () {
    if (!skybotOpen) {
      var badge = document.getElementById('skybot-fab-badge');
      if (badge) {
        badge.style.display = 'flex';
        badge.setAttribute('aria-label', '1');
      }
    }
  }, 4000);

  /* Initialize language on load */
  skybotSetLang(skybotLang);

  /* ── Expose globals ── */
  window.skybotToggle        = skybotToggle;
  window.skybotSend          = skybotSend;
  window.skybotClear         = skybotClear;
  window.skybotKeyDown       = skybotKeyDown;
  window.skybotAutoResize    = skybotAutoResize;
  window.skybotSetLang       = skybotSetLang;

})();
</script>

</body>
</html>
