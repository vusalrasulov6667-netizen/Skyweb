<?php
require_once __DIR__ . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="<?= current_lang() ?>" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title><?= e(__('blog_title', 'Skyweb Blog')) ?> — <?= SITE_NAME ?></title>
  
  <!-- PWA & Mobil Tənzimləmələr -->
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#080a1c">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <link rel="apple-touch-icon" href="assets/uploads/1b7acda823126b63d3350ccc5fe1bfe3.png">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/sky.css?v=<?= time() ?>">
  <?= render_i18n_script() ?>
  <script src="assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
  <style>
    .page-wrap { min-height: 100vh; padding: 120px 0 60px; position: relative; z-index: 2; }
    .content-title { font-size: 2.25rem; font-weight: 800; margin-bottom: 2.5rem; text-align: center; }
    
    /* Blog Grid */
    .blog-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(320px, 100%), 1fr)); gap: 2rem; margin-top: 2rem; }
    .blog-card { display: flex; flex-direction: column; height: 100%; transition: transform var(--transition); border-radius: var(--radius-lg); }
    .blog-card:hover { transform: translateY(-5px); }
    .blog-body { padding: 1.75rem; display: flex; flex-direction: column; flex-grow: 1; }
    .blog-date { font-size: 0.78rem; font-weight: 700; color: var(--neon-cyan); letter-spacing: 0.5px; text-transform: uppercase; margin-bottom: 0.6rem; }
    .blog-title { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 0.75rem; line-height: 1.4; }
    .blog-desc { font-size: 0.88rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 1.5rem; }
    .blog-link { font-size: 0.88rem; font-weight: 700; color: var(--neon-cyan); text-decoration: none; margin-top: auto; display: inline-flex; align-items: center; gap: 0.35rem; }
    .blog-link:hover { text-decoration: underline; }
  </style>
</head>
<body>

<canvas id="sky-canvas" aria-hidden="true"></canvas>

<header>
  <nav id="main-navbar" class="navbar" role="navigation" aria-label="<?= e(__('aria_main_nav', 'Əsas naviqasiya')) ?>">
    <div class="container nav-inner">
      <a href="index.php" class="logo" id="logo-link" aria-label="<?= e(__('aria_logo_home', 'Skyweb.az Ana Səhifə')) ?>">
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
      <div style="flex-grow: 1;"></div>
      <div class="nav-actions">
        <a href="index.php" class="btn-primary" style="font-weight: 700;">
          <span data-i18n="nav_home"><?= __('nav_home', 'Ana Səhifə') ?></span>
        </a>
        <?= render_language_switcher() ?>
      </div>
    </div>
  </nav>
</header>

<main class="page-wrap">
  <div class="container">
    <h1 class="content-title gradient-text" data-i18n="blog_title"><?= __('blog_title', 'Skyweb Blog') ?></h1>
    <p style="text-align:center; color: var(--text-secondary); max-width: 650px; margin: -1.5rem auto 2.5rem;" data-i18n="blog_desc"><?= __('blog_desc', 'Rəqəmsal texnologiyalar, frilans dünyası, karyera və biznes inkişafı məqalələri.') ?></p>
    
    <div class="blog-grid">
      <!-- Blog Post 1 -->
      <article class="blog-card glass-card">
        <div class="blog-body">
          <div class="blog-date" data-i18n="blog_post1_meta"><?= __('blog_post1_meta', '02 İyun 2026 // Freelance') ?></div>
          <h2 class="blog-title" data-i18n="blog_post1_title"><?= __('blog_post1_title', 'Azərbaycanda Freelance bazarının inkişaf tempi') ?></h2>
          <p class="blog-desc" data-i18n="blog_post1_desc"><?= __('blog_post1_desc', 'Süni intellekt və uzaqdan iş modellərinin yayılması ilə yerli mütəxəssislər artıq qlobal bazarda iş tapırlar. Məsafədən işləməyin üstünlükləri, hüquqi tənzimlənməsi və Skyweb vasitəsilə necə sərbəst qazanmağa başlamaq olar?') ?></p>
          <a href="#" class="blog-link"><span data-i18n="blog_read_more"><?= __('blog_read_more', 'Məqaləni Oxu →') ?></span></a>
        </div>
      </article>

      <!-- Blog Post 2 -->
      <article class="blog-card glass-card">
        <div class="blog-body">
          <div class="blog-date" data-i18n="blog_post2_meta"><?= __('blog_post2_meta', '28 May 2026 // CV Hazırlama') ?></div>
          <h2 class="blog-title" data-i18n="blog_post2_title"><?= __('blog_post2_title', 'ATS standartlarına uyğun CV necə olmalıdır?') ?></h2>
          <p class="blog-desc" data-i18n="blog_post2_desc"><?= __('blog_post2_desc', 'Böyük şirkətlərin HR şöbələri artıq süni intellekt əsaslı ATS (Applicant Tracking System) alətlərindən istifadə edirlər. CV-nizin bu sistemlərdən keçməsi üçün şablonun, açar sözlərin və strukturun önəmi.') ?></p>
          <a href="#" class="blog-link"><span data-i18n="blog_read_more"><?= __('blog_read_more', 'Məqaləni Oxu →') ?></span></a>
        </div>
      </article>

      <!-- Blog Post 3 -->
      <article class="blog-card glass-card">
        <div class="blog-body">
          <div class="blog-date" data-i18n="blog_post3_meta"><?= __('blog_post3_meta', '24 May 2026 // SMM & Reklam') ?></div>
          <h2 class="blog-title" data-i18n="blog_post3_title"><?= __('blog_post3_title', 'Mini oyunlar (Gamification) ilə sayt satışlarını artırmaq') ?></h2>
          <p class="blog-desc" data-i18n="blog_post3_desc"><?= __('blog_post3_desc', 'Sadə reklamların effektivliyi düşdüyü bir dövrdə mini oyunlar vasitəsilə müştəriləri veb-saytda saxlamaq və onlara endirim kuponları təqdim etmək satışı necə 45% artırır? Praktik nümunələrlə.') ?></p>
          <a href="#" class="blog-link"><span data-i18n="blog_read_more"><?= __('blog_read_more', 'Məqaləni Oxu →') ?></span></a>
        </div>
      </article>
    </div>
  </div>
</main>

<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="index.php" class="logo" style="display:inline-flex;margin-bottom:.5rem;">
          <div class="logo-icon" style="height:36px;">
            <svg class="sky-logo-svg" viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg">
              <defs>
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
        <p data-i18n="footer_brand_desc"><?= __('footer_brand_desc', 'Azərbaycanın yeni nəsil rəqəmsal ekosistemi. Biznes həlləri, ağıllı CV və gamification — hamısı bir platformada.') ?></p>
      </div>
      <div>
        <h4 class="footer-col-title" data-i18n="hero_btn_services"><?= __('hero_btn_services', 'Xidmətlərimiz') ?></h4>
        <ul class="footer-col-links">
          <li><a href="index.php#business" data-i18n="nav_business"><?= __('nav_business', 'Biznes & İaşə Həlləri') ?></a></li>
          <li><a href="index.php#marketing" data-i18n="nav_marketing"><?= __('nav_marketing', 'SMM & Data Analitika') ?></a></li>
          <li><a href="index.php#games" data-i18n="nav_games"><?= __('nav_games', 'Mini Oyunlar (Gamification)') ?></a></li>
          <li><a href="index.php#cv-builder" data-i18n="nav_cv"><?= __('nav_cv', 'Ağıllı CV Hazırlama') ?></a></li>
          <li><a href="modules/cv-builder/">CV Builder</a></li>
        </ul>
      </div>
      <div>
        <h4 class="footer-col-title" data-i18n="nav_about"><?= __('nav_about', 'Haqqımızda') ?></h4>
        <ul class="footer-col-links">
          <li><a href="index.php#contact" data-i18n="nav_contact"><?= __('nav_contact', 'Əlaqə') ?></a></li>
          <li><a href="index.php#projects" data-i18n="nav_projects"><?= __('nav_projects', 'Layihələrimiz') ?></a></li>
          <li><a href="privacy.php" data-i18n="nav_privacy"><?= __('nav_privacy', 'Gizlilik Siyasəti') ?></a></li>
          <li><a href="terms.php" data-i18n="nav_terms"><?= __('nav_terms', 'İstifadə Şərtləri') ?></a></li>
          <li><a href="faq.php" data-i18n="nav_faq"><?= __('nav_faq', 'FAQ') ?></a></li>
          <li><a href="blog.php" data-i18n="nav_blog"><?= __('nav_blog', 'Blog') ?></a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <?= date('Y') ?> <?= SITE_NAME ?>. <span data-i18n="footer_rights"><?= __('footer_rights', 'Bütün hüquqlar qorunur.') ?></span></span>
      <div class="footer-bottom-links">
        <a href="admin/" class="footer-admin-link" rel="nofollow"><?= e(__('footer_admin_link', 'Admin')) ?></a>
      </div>
    </div>
  </div>
</footer>

<script src="assets/js/main.js" defer></script>
</body>
</html>
