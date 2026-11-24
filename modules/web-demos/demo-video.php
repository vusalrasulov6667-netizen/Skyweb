<?php
// modules/web-demos/demo-video.php
// CineSky Media — Video Prodakşn & Rəqəmsal Media Xidmətləri Demo
require_once __DIR__ . '/../../config/lang.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });

if (!function_exists('e')) {
    function e(string $str): string {
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

$lang = current_lang();

$demo_texts = [
    'az' => [
        'demo_banner' => 'Bu canlı nümayiş saytıdır — Skyweb tərəfindən video xidmətləri üçün hazırlanmışdır',
        'back_to_sky' => 'Skyweb-ə Qayıt',
        'order_site' => 'Bu Saytı Sifariş Et',
        'brand_name' => 'CINESKY MEDIA',
        'brand_sub' => 'Video Prodakşn & Kino Studiyası',
        'nav_home' => 'Ana Səhifə',
        'nav_services' => 'Xidmətlər',
        'nav_portfolio' => 'Şouril & Portfel',
        'nav_calc' => 'Qiymət Kalkulyatoru',
        'nav_contact' => 'Əlaqə',
        'hero_tag' => '🎬 PREMİUM VİDEO PRODAKŞN & 4K ÇƏKİLİŞLƏR',
        'hero_title_1' => 'Hekayənizi Kinematoqrafik',
        'hero_title_2' => 'Keyfiyyətlə Canlandırırıq.',
        'hero_desc' => 'Brendiniz üçün yüksək baxış və satış gətirən 4K reklam çarxları, dron aerofotoqrafiyası, musiqi klipləri və sosial media (Reels/TikTok) video həlləri.',
        'btn_hero_watch' => 'Şourili İzlə',
        'btn_hero_calc' => 'Qiyməti Hesabla',
        'stat_1_n' => '250+',
        'stat_1_t' => 'Tamamlanan Layihə',
        'stat_2_n' => '4K / 8K',
        'stat_2_t' => 'Kino Standartı',
        'stat_3_n' => '99%',
        'stat_3_t' => 'Müştəri Məmnuniyyəti',
        'portfolio_title' => 'Seçilmiş Video İşlərimiz',
        'portfolio_sub' => 'Hər bir video müştərilərimizin biznes hədəflərinə və estetik zövqünə uyğun çəkilmişdir.',
        'tab_all' => 'Bütün Videolar',
        'tab_commercial' => 'Reklam & Brend',
        'tab_drone' => 'Dron & 4K Aerofoto',
        'tab_reels' => 'Reels & SMM Video',
        'tab_corporate' => 'Korporativ & Tədbir',
        'calc_title' => 'İnteraktiv Video Büdcə Kalkulyatoru',
        'calc_sub' => 'Layihənizin parametrlərini seçin və təxmini çəkiliş büdcəsini anında görün.',
        'field_video_type' => 'Video Növü',
        'field_duration' => 'Layihə Çəkiliş Müddəti',
        'field_gear' => 'Əlavə İstehsalat Seçimləri',
        'calc_opt_drone' => '🚁 4K Dron Çəkilişi (+150 AZN)',
        'calc_opt_voice' => '🎙️ Peşəkar Diktor Səsləndirməsi (+100 AZN)',
        'calc_opt_anim' => '✨ 2D/3D Hərəkətli Qrafika (+120 AZN)',
        'calc_opt_davinci' => '🎨 DaVinci Rəng Korreksiyası (+80 AZN)',
        'est_total' => 'Təxmini Büdcə:',
        'btn_calc_order' => 'Bu Büdcə ilə WhatsApp-da Sifariş Et',
        'modal_specs_title' => 'Texniki Avadanlıq & Çəkiliş Detalları',
        'modal_btn_book' => 'Bu Video Formatını Sifariş Et',
        'calc_opt_commercial' => '🎬 Reklam & Brend Filmi (Baza 350 AZN)',
        'calc_opt_reels' => '📱 Viral Reels / TikTok Paketi (Baza 250 AZN)',
        'calc_opt_drone_item' => '🚁 4K Dron & Təbiət / Memarlıq (Baza 400 AZN)',
        'calc_opt_corp' => '🎤 Korporativ Tədbir & Müsahibə (Baza 300 AZN)',
        'calc_dur_half' => '⏱️ Yarım Gün Çəkiliş (4 Saata qədər) — Baza qiymət',
        'calc_dur_full' => '⏱️ Tam Gün Çəkiliş (8 Saat) — +60%',
        'calc_dur_2days' => '⏱️ 2 Günlük Tam Prodakşn — +150%',
        'btn_watch_explore' => 'İzlə & İncələ',
        'sound_on' => '🔊 Səsi Bağla',
        'sound_off' => '🔇 Səs Aç',
        'btn_fullscreen' => '⛶ Tam Ekran',
        'footer_desc' => 'CineSky Media — Skyweb.az tərəfindən video prodakşn şirkətləri, rejissorlar və kreativ agentliklər üçün hazırlanmış tam funksional portfel platforması.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'demo_banner' => 'This is a live demo — Crafted by Skyweb for video production agencies',
        'back_to_sky' => 'Back to Skyweb',
        'order_site' => 'Order This Website',
        'brand_name' => 'CINESKY MEDIA',
        'brand_sub' => 'Cinematic Video Production',
        'nav_home' => 'Home',
        'nav_services' => 'Services',
        'nav_portfolio' => 'Showreel & Work',
        'nav_calc' => 'Budget Estimator',
        'nav_contact' => 'Contact',
        'hero_tag' => '🎬 PREMIUM CINEMA PRODUCTION & 4K AERIALS',
        'hero_title_1' => 'Bringing Your Brand Story to Life',
        'hero_title_2' => 'With Cinematic Magic.',
        'hero_desc' => 'High-conversion 4K commercial videos, cinematic drone footage, brand films, and high-impact social media reels designed to inspire.',
        'btn_hero_watch' => 'Watch Showreel',
        'btn_hero_calc' => 'Estimate Budget',
        'stat_1_n' => '250+',
        'stat_1_t' => 'Projects Delivered',
        'stat_2_n' => '4K / 8K',
        'stat_2_t' => 'Cinema Standard',
        'stat_3_n' => '99%',
        'stat_3_t' => 'Client Satisfaction',
        'portfolio_title' => 'Featured Video Productions',
        'portfolio_sub' => 'Engineered for maximum engagement and brand elevation.',
        'tab_all' => 'All Works',
        'tab_commercial' => 'Commercials',
        'tab_drone' => 'Drone & Aerial',
        'tab_reels' => 'Reels & Viral',
        'tab_corporate' => 'Corporate & Event',
        'calc_title' => 'Interactive Video Production Estimator',
        'calc_sub' => 'Configure your production requirements for instant cost transparency.',
        'field_video_type' => 'Production Format',
        'field_duration' => 'Shoot Duration',
        'field_gear' => 'Production Add-ons',
        'calc_opt_drone' => '🚁 4K Drone Aerials (+150 AZN)',
        'calc_opt_voice' => '🎙️ Professional Voiceover (+100 AZN)',
        'calc_opt_anim' => '✨ 2D/3D Motion Graphics (+120 AZN)',
        'calc_opt_davinci' => '🎨 DaVinci Color Grading (+80 AZN)',
        'est_total' => 'Estimated Total:',
        'btn_calc_order' => 'Book This Setup via WhatsApp',
        'modal_specs_title' => 'Technical Specs & Production Gear',
        'modal_btn_book' => 'Order This Video Format',
        'calc_opt_commercial' => '🎬 Commercial & Brand Film (Base 350 AZN)',
        'calc_opt_reels' => '📱 Viral Reels / TikTok Package (Base 250 AZN)',
        'calc_opt_drone_item' => '🚁 4K Drone & Nature / Architecture (Base 400 AZN)',
        'calc_opt_corp' => '🎤 Corporate Event & Interview (Base 300 AZN)',
        'calc_dur_half' => '⏱️ Half Day Shoot (Up to 4h) — Base price',
        'calc_dur_full' => '⏱️ Full Day Shoot (8h) — +60%',
        'calc_dur_2days' => '⏱️ 2-Day Full Production — +150%',
        'btn_watch_explore' => 'Watch & Explore',
        'sound_on' => '🔊 Mute Sound',
        'sound_off' => '🔇 Unmute Sound',
        'btn_fullscreen' => '⛶ Fullscreen',
        'footer_desc' => 'CineSky Media — Live interactive video showcase engineered by Skyweb.az.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'demo_banner' => 'Bu canlı demo sitedir — Skyweb tarafından video prodüksiyon ajansları için tasarlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'order_site' => 'Bu Siteyi Sipariş Et',
        'brand_name' => 'CINESKY MEDIA',
        'brand_sub' => 'Video Prodüksiyon & Sinema Stüdyosu',
        'nav_home' => 'Ana Sayfa',
        'nav_services' => 'Hizmetler',
        'nav_portfolio' => 'Showreel & Portföy',
        'nav_calc' => 'Fiyat Hesaplayıcı',
        'nav_contact' => 'İletişim',
        'hero_tag' => '🎬 PREMİUM VİDEO PRODÜKSİYON & 4K ÇEKİM',
        'hero_title_1' => 'Markanızın Hikayesini',
        'hero_title_2' => 'Sinematik Kaliteyle Yaşatın.',
        'hero_desc' => 'Yüksek etkileşimli 4K reklam filmleri, drone çekimleri, kurumsal videolar ve sosyal medya içerikleri.',
        'btn_hero_watch' => 'Showreel İzle',
        'btn_hero_calc' => 'Bütçe Hesapla',
        'stat_1_n' => '250+',
        'stat_1_t' => 'Tamamlanan Proje',
        'stat_2_n' => '4K / 8K',
        'stat_2_t' => 'Sinema Standardı',
        'stat_3_n' => '99%',
        'stat_3_t' => 'Müşteri Memnuniyeti',
        'portfolio_title' => 'Öne Çıkan Video Çalışmalarımız',
        'portfolio_sub' => 'Her proje markanın büyüme hedeflerine özel kurgulanmıştır.',
        'tab_all' => 'Tüm Videolar',
        'tab_commercial' => 'Reklam Filmi',
        'tab_drone' => 'Drone & 4K Hava',
        'tab_reels' => 'Reels & SMM',
        'tab_corporate' => 'Kurumsal & Etkinlik',
        'calc_title' => 'İnteraktif Video Bütçe Hesaplayıcı',
        'calc_sub' => 'İhtiyacınız olan parametreleri seçin ve anında maliyet görün.',
        'field_video_type' => 'Video Formatı',
        'field_duration' => 'Çekim Süresi',
        'field_gear' => 'Ek Prodüksiyon Seçenekleri',
        'calc_opt_drone' => '🚁 4K Drone Çekimi (+150 AZN)',
        'calc_opt_voice' => '🎙️ Profesyonel Seslendirme (+100 AZN)',
        'calc_opt_anim' => '✨ 2D/3D Hareketli Grafik (+120 AZN)',
        'calc_opt_davinci' => '🎨 DaVinci Renk Düzenleme (+80 AZN)',
        'est_total' => 'Tahmini Bütçe:',
        'btn_calc_order' => 'WhatsApp İle Sipariş Ver',
        'modal_specs_title' => 'Teknik Ekipman ve Prodüksiyon Detayları',
        'modal_btn_book' => 'Bu Video Formatını Sipariş Et',
        'calc_opt_commercial' => '🎬 Reklam & Marka Filmi (Baz 350 AZN)',
        'calc_opt_reels' => '📱 Viral Reels / TikTok Paketi (Baz 250 AZN)',
        'calc_opt_drone_item' => '🚁 4K Dron & Doğa / Mimarlık (Baz 400 AZN)',
        'calc_opt_corp' => '🎤 Kurumsal Etkinlik & Röportaj (Baz 300 AZN)',
        'calc_dur_half' => '⏱️ Yarım Gün Çekim (4 Saate kadar) — Baz fiyat',
        'calc_dur_full' => '⏱️ Tam Gün Çekim (8 Saat) — +60%',
        'calc_dur_2days' => '⏱️ 2 Günlük Tam Prodüksiyon — +150%',
        'btn_watch_explore' => 'İzle & İncele',
        'sound_on' => '🔊 Sesi Kapat',
        'sound_off' => '🔇 Sesi Aç',
        'btn_fullscreen' => '⛶ Tam Ekran',
        'footer_desc' => 'CineSky Media — Skyweb.az tarafından geliştirilmiş video prodüksiyon platformu.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'demo_banner' => 'Это интерактивный демо-сайт — создан Skyweb для видеопродакшн студий',
        'back_to_sky' => 'Назад в Skyweb',
        'order_site' => 'Заказать такой сайт',
        'brand_name' => 'CINESKY MEDIA',
        'brand_sub' => 'Видеопродакшн и киностудия',
        'nav_home' => 'Главная',
        'nav_services' => 'Услуги',
        'nav_portfolio' => 'Шоурил и работы',
        'nav_calc' => 'Калькулятор бюджета',
        'nav_contact' => 'Контакты',
        'hero_tag' => '🎬 ПРЕМИУМ ВИДЕОПРОДАКШН И СЪЕМКА 4K',
        'hero_title_1' => 'Воплощаем историю бренда',
        'hero_title_2' => 'В кинематографическом качестве.',
        'hero_desc' => 'Рекламные ролики 4K, аэросъемка с дрона, корпоративные фильмы и вирусные видео для Reels/TikTok.',
        'btn_hero_watch' => 'Смотреть шоурил',
        'btn_hero_calc' => 'Рассчитать смету',
        'stat_1_n' => '250+',
        'stat_1_t' => 'Завершенных проектов',
        'stat_2_n' => '4K / 8K',
        'stat_2_t' => 'Киностандарт',
        'stat_3_n' => '99%',
        'stat_3_t' => 'Довольных клиентов',
        'portfolio_title' => 'Избранные видеопроекты',
        'portfolio_sub' => 'Каждый ролик решает бизнес-задачи клиента и привлекает аудиторию.',
        'tab_all' => 'Все видео',
        'tab_commercial' => 'Реклама и бренды',
        'tab_drone' => 'Дроны и аэросъемка',
        'tab_reels' => 'Reels и TikTok',
        'tab_corporate' => 'Корпоративные и Event',
        'calc_title' => 'Калькулятор стоимости видеосъемки',
        'calc_sub' => 'Выберите нужные параметры и получите моментальный расчет.',
        'field_video_type' => 'Тип видео',
        'field_duration' => 'Длительность съемки',
        'field_gear' => 'Дополнительные опции',
        'calc_opt_drone' => '🚁 Аэросъемка с дрона 4K (+150 AZN)',
        'calc_opt_voice' => '🎙️ Профессиональная озвучка (+100 AZN)',
        'calc_opt_anim' => '✨ 2D/3D Моушн-графика (+120 AZN)',
        'calc_opt_davinci' => '🎨 Цветокоррекция DaVinci (+80 AZN)',
        'est_total' => 'Примерный бюджет:',
        'btn_calc_order' => 'Заказать расчет в WhatsApp',
        'modal_specs_title' => 'Оборудование и детали съемки',
        'modal_btn_book' => 'Заказать данный формат видео',
        'calc_opt_commercial' => '🎬 Рекламный фильм бренда (База 350 AZN)',
        'calc_opt_reels' => '📱 Вирусный Reels / TikTok пакет (База 250 AZN)',
        'calc_opt_drone_item' => '🚁 4K Дрон и Архитектура (База 400 AZN)',
        'calc_opt_corp' => '🎤 Корпоративное событие и интервью (База 300 AZN)',
        'calc_dur_half' => '⏱️ Съемка на полдня (до 4 часов) — Базовая цена',
        'calc_dur_full' => '⏱️ Полный съемочный день (8 часов) — +60%',
        'calc_dur_2days' => '⏱️ 2 дня полного продакшна — +150%',
        'btn_watch_explore' => 'Смотреть и изучить',
        'sound_on' => '🔊 Выключить звук',
        'sound_off' => '🔇 Включить звук',
        'btn_fullscreen' => '⛶ Полный экран',
        'footer_desc' => 'CineSky Media — функциональное портфолио для видеостудий от Skyweb.az.',
        'all_rights' => 'Все права защищены.',
    ]
];

$t = $demo_texts[$lang] ?? $demo_texts['az'];

// Portfolio Video Items
$video_items = [
    [
        'id' => 1,
        'cat' => 'commercial',
        'title' => 'Aura Brand Story — Luxury Fashion Film',
        'client' => 'Aura Moda Boutique',
        'thumb' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=800&q=80',
        'video_src' => '../../assets/videos/demo1.mp4',
        'duration' => '01:24',
        'specs' => 'Sony FX3 Cinema 4K, 10-bit 4:2:2, Anamorphic Lenses, Studio Lighting'
    ],
    [
        'id' => 2,
        'cat' => 'drone',
        'title' => 'SkyVilla Baku — 4K Luxury Aerial Showcase',
        'client' => 'SkyVilla Realty',
        'thumb' => 'https://images.unsplash.com/photo-1508614589041-895b88991e3e?w=800&q=80',
        'video_src' => '../../assets/videos/demo2.mp4',
        'duration' => '02:05',
        'specs' => 'DJI Mavic 3 Cine, Apple ProRes 422 HQ, ND Filters, Golden Hour Flight'
    ],
    [
        'id' => 3,
        'cat' => 'reels',
        'title' => 'APEXFIT Turbo Training — Viral Reel Promo',
        'client' => 'APEXFIT Gym Club',
        'thumb' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80',
        'video_src' => '../../assets/videos/demo3.mp4',
        'duration' => '00:45',
        'specs' => 'High-Speed 120 FPS, DJI Ronin RS3 Pro Gimbal, Dynamic Sound Design'
    ],
    [
        'id' => 4,
        'cat' => 'corporate',
        'title' => 'TechVerse Summit — Global IT Forum Recap',
        'client' => 'TechVerse Academy',
        'thumb' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80',
        'video_src' => '../../assets/videos/demo4.mp4',
        'duration' => '02:40',
        'specs' => 'Multi-Cam Setup, Sennheiser Wireless Mics, Live Switcher Recording'
    ],
    [
        'id' => 5,
        'cat' => 'commercial',
        'title' => 'Velvet Brew — Gourmet Coffee Craft',
        'client' => 'Velvet Brew Lounge',
        'thumb' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80',
        'video_src' => '../../assets/videos/demo1.mp4',
        'duration' => '01:10',
        'specs' => 'Macro 100mm Lens, 4K 60fps Slow Motion, Warm Color Grade'
    ],
    [
        'id' => 6,
        'cat' => 'reels',
        'title' => 'Élégance Transformation — Glamour Reel',
        'client' => 'Élégance Salon & Spa',
        'thumb' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=800&q=80',
        'video_src' => '../../assets/videos/demo3.mp4',
        'duration' => '00:38',
        'specs' => 'Vertical 9:16 4K, Ring Light & RGB Accents, Fast-Paced Beat Cut'
    ]
];
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($t['brand_name']) ?> — <?= e($t['brand_sub']) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #01141a;
      --sky-surface: #032029;
      --sky-card: rgba(3, 34, 43, 0.85);
      --sky-card-hover: rgba(5, 46, 58, 0.95);
      --sky-border: rgba(0, 229, 255, 0.22);
      --neon-cyan: #00e5ff;
      --neon-purple: #c084fc;
      --neon-glow: 0 0 24px rgba(0, 229, 255, 0.35);
      --purple-glow: 0 0 24px rgba(192, 132, 252, 0.35);
      --text-main: #f0fdfe;
      --text-muted: #84a8b2;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: linear-gradient(180deg, #011217 0%, #021a22 35%, #03242f 70%, #010e13 100%);
      color: var(--text-main);
      font-family: var(--font-body);
      min-height: 100vh;
      line-height: 1.6;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }

    /* Top Demo Bar */
    .demo-bar {
      background: rgba(1, 18, 24, 0.96);
      border-bottom: 1px solid var(--sky-border);
      padding: 8px 24px;
      font-size: 13px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      position: sticky;
      top: 0;
      z-index: 1000;
      backdrop-filter: blur(14px);
    }
    .demo-bar-left { display: flex; align-items: center; gap: 10px; }
    .demo-badge {
      background: rgba(0, 229, 255, 0.12);
      color: var(--neon-cyan);
      border: 1px solid var(--neon-cyan);
      border-radius: 20px;
      padding: 2px 10px;
      font-weight: 700;
      font-size: 11px;
      text-transform: uppercase;
      box-shadow: var(--neon-glow);
    }
    .demo-text { color: var(--text-muted); font-weight: 500; font-size: 12px; }
    .demo-bar-right { display: flex; align-items: center; gap: 12px; }
    .demo-btn-sky {
      background: linear-gradient(135deg, var(--neon-cyan), #38bdf8);
      color: #01141a;
      padding: 5px 14px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 12px;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .demo-btn-sky:hover { box-shadow: var(--neon-glow); transform: translateY(-1px); }
    .demo-btn-back {
      color: var(--text-muted);
      font-size: 12px;
      font-weight: 600;
      padding: 4px 10px;
      border-radius: 6px;
      border: 1px solid rgba(255,255,255,0.1);
      transition: all 0.2s;
    }
    .demo-btn-back:hover { color: #fff; border-color: var(--neon-cyan); }
    .lang-pills { display: flex; gap: 4px; background: rgba(0,0,0,0.4); padding: 2px; border-radius: 6px; }
    .lang-pill {
      font-size: 11px;
      padding: 2px 8px;
      border-radius: 4px;
      color: var(--text-muted);
      font-weight: 600;
      text-transform: uppercase;
    }
    .lang-pill.active { background: var(--neon-cyan); color: #01141a; }

    /* Studio Header */
    .studio-nav {
      background: rgba(2, 24, 32, 0.88);
      border-bottom: 1px solid rgba(0, 229, 255, 0.14);
      backdrop-filter: blur(16px);
      padding: 16px 32px;
      position: sticky;
      top: 41px;
      z-index: 900;
    }
    .nav-wrap {
      max-width: 1260px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .brand-box { display: flex; align-items: center; gap: 12px; }
    .brand-icon {
      width: 42px; height: 42px;
      border-radius: 12px;
      background: linear-gradient(135deg, rgba(0,229,255,0.15), rgba(192,132,252,0.15));
      border: 1px solid rgba(0, 229, 255, 0.35);
      display: flex; align-items: center; justify-content: center;
      color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0,229,255,0.2);
    }
    .brand-name {
      font-family: var(--font-heading);
      font-size: 20px;
      font-weight: 900;
      letter-spacing: 1.5px;
      color: #fff;
    }
    .brand-sub {
      display: block;
      font-size: 11px;
      letter-spacing: 2px;
      color: var(--neon-cyan);
      font-weight: 600;
      text-transform: uppercase;
    }
    .nav-links { display: flex; gap: 24px; align-items: center; }
    .nav-link {
      font-size: 14px;
      font-weight: 600;
      color: var(--text-muted);
      transition: all 0.2s;
    }
    .nav-link:hover { color: var(--neon-cyan); }
    .nav-cta-btn {
      background: linear-gradient(135deg, rgba(0,229,255,0.18), rgba(192,132,252,0.18));
      border: 1px solid rgba(0,229,255,0.4);
      color: var(--neon-cyan);
      padding: 8px 18px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 700;
      transition: all 0.25s;
    }
    .nav-cta-btn:hover {
      background: var(--neon-cyan);
      color: #01141a;
      box-shadow: var(--neon-glow);
    }

    /* Hero Section */
    .hero-sec {
      max-width: 1260px;
      margin: 0 auto;
      padding: 60px 24px 40px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: center;
    }
    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      color: var(--neon-cyan);
      background: rgba(0, 229, 255, 0.08);
      border: 1px solid rgba(0, 229, 255, 0.25);
      padding: 6px 14px;
      border-radius: 30px;
      margin-bottom: 18px;
    }
    .hero-h1 {
      font-family: var(--font-heading);
      font-size: clamp(32px, 4.5vw, 52px);
      font-weight: 900;
      line-height: 1.15;
      color: #fff;
      margin-bottom: 18px;
    }
    .glow-cyan {
      background: linear-gradient(135deg, #00e5ff 0%, #38bdf8 60%, #c084fc 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      filter: drop-shadow(0 0 20px rgba(0,229,255,0.4));
    }
    .hero-desc {
      font-size: 16px;
      color: var(--text-muted);
      line-height: 1.7;
      margin-bottom: 28px;
      max-width: 520px;
    }
    .hero-actions { display: flex; flex-wrap: wrap; gap: 14px; align-items: center; margin-bottom: 36px; }
    .btn-hero-primary {
      background: linear-gradient(135deg, #00e5ff 0%, #00b4d8 100%);
      color: #01141a;
      font-weight: 800;
      font-size: 15px;
      padding: 13px 28px;
      border-radius: 10px;
      border: none;
      box-shadow: 0 0 25px rgba(0,229,255,0.4);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.25s;
    }
    .btn-hero-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 35px rgba(0,229,255,0.6);
    }
    .btn-hero-secondary {
      background: rgba(3, 34, 43, 0.8);
      border: 1px solid rgba(0, 229, 255, 0.3);
      color: #fff;
      font-weight: 700;
      font-size: 15px;
      padding: 13px 24px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .btn-hero-secondary:hover {
      border-color: var(--neon-cyan);
      background: rgba(0, 229, 255, 0.12);
      color: var(--neon-cyan);
    }
    .hero-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      padding-top: 24px;
      border-top: 1px solid rgba(0, 229, 255, 0.12);
    }
    .hero-stat-n {
      font-family: var(--font-heading);
      font-size: 26px;
      font-weight: 800;
      color: var(--neon-cyan);
    }
    .hero-stat-t { font-size: 12px; color: var(--text-muted); }

    /* Interactive Hero Showreel Player Card */
    .hero-player-card {
      position: relative;
      background: linear-gradient(160deg, #032530 0%, #01171f 100%);
      border: 1px solid rgba(0, 229, 255, 0.3);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0, 8, 12, 0.75), 0 0 30px rgba(0, 229, 255, 0.15);
    }
    .hero-player-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 50%, #c084fc 100%);
      box-shadow: 0 0 12px rgba(0, 240, 255, 0.7);
      z-index: 10;
    }
    .hero-video-wrap {
      position: relative;
      width: 100%;
      height: 330px;
      background: #000;
      overflow: hidden;
    }
    .hero-video-wrap video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .hero-video-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(2, 22, 29, 0.85) 0%, transparent 60%);
      pointer-events: none;
    }
    .hero-video-bar {
      padding: 14px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(2, 22, 29, 0.95);
      border-top: 1px solid rgba(0, 229, 255, 0.15);
    }
    .hero-video-meta { display: flex; flex-direction: column; }
    .hero-video-title { font-size: 14px; font-weight: 700; color: #fff; }
    .hero-video-sub { font-size: 11px; color: var(--neon-cyan); letter-spacing: 0.5px; }
    .hero-video-ctrls { display: flex; gap: 8px; }
    .ctrl-pill-btn {
      background: rgba(0, 229, 255, 0.1);
      border: 1px solid rgba(0, 229, 255, 0.25);
      color: var(--neon-cyan);
      padding: 5px 12px;
      border-radius: 6px;
      font-size: 12px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .ctrl-pill-btn:hover { background: var(--neon-cyan); color: #01141a; }

    /* Portfolio Section */
    .portfolio-sec {
      max-width: 1260px;
      margin: 50px auto 70px;
      padding: 0 24px;
    }
    .sec-head { text-align: center; margin-bottom: 36px; }
    .sec-title {
      font-family: var(--font-heading);
      font-size: 32px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 8px;
    }
    .sec-sub { color: var(--text-muted); font-size: 15px; max-width: 600px; margin: 0 auto; }

    /* Category Filter Tabs */
    .filter-pills {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 32px;
    }
    .filter-btn {
      background: rgba(3, 34, 43, 0.7);
      border: 1px solid rgba(0, 229, 255, 0.2);
      color: var(--text-muted);
      padding: 8px 20px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .filter-btn:hover, .filter-btn.active {
      background: linear-gradient(135deg, rgba(0,229,255,0.22), rgba(192,132,252,0.15));
      border-color: var(--neon-cyan);
      color: #fff;
      box-shadow: 0 0 15px rgba(0,229,255,0.3);
    }

    /* Video Portfolio Grid */
    .video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 24px;
    }
    .video-card {
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 18px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
    }
    .video-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--neon-cyan), transparent);
      opacity: 0;
      transition: opacity 0.3s;
      z-index: 5;
    }
    .video-card:hover {
      background: var(--sky-card-hover);
      border-color: rgba(0, 229, 255, 0.45);
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.6), 0 0 25px rgba(0,229,255,0.15);
    }
    .video-card:hover::before { opacity: 1; }
    .video-thumb-wrap {
      position: relative;
      height: 210px;
      background: #000;
      overflow: hidden;
    }
    .video-thumb-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
      filter: brightness(0.85);
    }
    .video-card:hover .video-thumb-wrap img { transform: scale(1.08); filter: brightness(0.95); }
    .video-card-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: rgba(1, 20, 26, 0.85);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      backdrop-filter: blur(6px);
      z-index: 2;
    }
    .video-duration {
      position: absolute;
      bottom: 12px;
      right: 12px;
      background: rgba(0,0,0,0.8);
      color: #fff;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 8px;
      border-radius: 6px;
      border: 1px solid rgba(255,255,255,0.15);
      z-index: 2;
    }
    .play-btn-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 54px;
      height: 54px;
      border-radius: 50%;
      background: rgba(0, 229, 255, 0.9);
      color: #01141a;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 25px var(--neon-cyan);
      transition: all 0.3s ease;
      z-index: 3;
    }
    .video-card:hover .play-btn-overlay {
      transform: translate(-50%, -50%) scale(1.15);
      background: #fff;
    }
    .video-card-body {
      padding: 18px 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
      gap: 8px;
    }
    .video-card-title {
      font-family: var(--font-heading);
      font-size: 17px;
      font-weight: 700;
      color: #fff;
      line-height: 1.3;
    }
    .video-card-client {
      font-size: 12px;
      color: var(--neon-cyan);
      font-weight: 600;
    }
    .video-card-specs {
      font-size: 12px;
      color: var(--text-muted);
      line-height: 1.4;
      margin-top: 4px;
    }
    .video-card-action {
      margin-top: auto;
      padding-top: 14px;
      border-top: 1px solid rgba(0, 229, 255, 0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .btn-play-trigger {
      color: var(--neon-cyan);
      font-weight: 700;
      font-size: 13px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    /* Video Budget Calculator Section */
    .calc-sec {
      max-width: 960px;
      margin: 40px auto 80px;
      padding: 0 24px;
    }
    .calc-card {
      background: linear-gradient(160deg, #032732 0%, #01171f 100%);
      border: 1px solid rgba(0, 229, 255, 0.3);
      border-radius: 24px;
      padding: 36px;
      box-shadow: 0 20px 60px rgba(0, 8, 12, 0.75), 0 0 30px rgba(0, 229, 255, 0.12);
      position: relative;
      overflow: hidden;
    }
    .calc-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, #00f0ff 0%, #38bdf8 50%, #c084fc 100%);
      box-shadow: 0 0 14px rgba(0, 240, 255, 0.8);
    }
    .calc-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 28px;
      margin-top: 24px;
    }
    .calc-group { display: flex; flex-direction: column; gap: 8px; }
    .calc-label { font-size: 13px; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.5px; }
    .calc-select {
      background: rgba(1, 20, 26, 0.85);
      border: 1px solid rgba(0, 229, 255, 0.25);
      color: #fff;
      padding: 12px 14px;
      border-radius: 10px;
      font-size: 14px;
      outline: none;
      transition: all 0.2s;
    }
    .calc-select:focus { border-color: var(--neon-cyan); box-shadow: 0 0 12px rgba(0,229,255,0.25); }
    .calc-checkboxes { display: flex; flex-direction: column; gap: 10px; margin-top: 6px; }
    .calc-check-item {
      display: flex;
      align-items: center;
      gap: 10px;
      background: rgba(1, 20, 26, 0.55);
      border: 1px solid rgba(0, 229, 255, 0.15);
      padding: 10px 14px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 13px;
      transition: all 0.2s;
    }
    .calc-check-item:hover { border-color: var(--neon-cyan); background: rgba(0, 229, 255, 0.08); }
    .calc-check-item input { accent-color: var(--neon-cyan); transform: scale(1.15); cursor: pointer; }
    .calc-bottom {
      margin-top: 28px;
      padding-top: 24px;
      border-top: 1px solid rgba(0, 229, 255, 0.15);
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }
    .calc-total-box { display: flex; align-items: baseline; gap: 12px; }
    .calc-total-lbl { font-size: 14px; color: var(--text-muted); font-weight: 600; }
    .calc-total-val {
      font-family: var(--font-heading);
      font-size: 34px;
      font-weight: 900;
      color: var(--neon-cyan);
      text-shadow: 0 0 20px rgba(0,229,255,0.4);
    }
    .btn-calc-submit {
      background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
      color: #fff;
      font-weight: 800;
      font-size: 15px;
      padding: 14px 28px;
      border-radius: 12px;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      box-shadow: 0 0 25px rgba(37, 211, 102, 0.35);
      transition: all 0.25s;
    }
    .btn-calc-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 35px rgba(37, 211, 102, 0.5);
    }

    /* Video Lightbox Modal */
    .video-modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0, 8, 12, 0.92);
      backdrop-filter: blur(14px);
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .video-modal-overlay.active { opacity: 1; visibility: visible; }
    .video-modal {
      background: linear-gradient(165deg, #032430 0%, #01141b 100%);
      border: 1px solid rgba(0, 229, 255, 0.35);
      border-radius: 20px;
      width: 100%;
      max-width: 900px;
      overflow: hidden;
      box-shadow: 0 25px 70px rgba(0,0,0,0.8), 0 0 40px rgba(0,229,255,0.2);
      transform: scale(0.95);
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .video-modal-overlay.active .video-modal { transform: scale(1); }
    .video-modal-header {
      padding: 14px 20px;
      background: rgba(1, 18, 24, 0.9);
      border-bottom: 1px solid rgba(0, 229, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .video-modal-title { font-size: 16px; font-weight: 700; color: #fff; }
    .video-modal-close {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.15);
      color: #fff;
      font-size: 20px;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
    }
    .video-modal-close:hover { background: rgba(239,68,68,0.25); border-color: rgba(239,68,68,0.5); color: #fca5a5; }
    .video-modal-player {
      width: 100%;
      height: 440px;
      background: #000;
    }
    .video-modal-player video {
      width: 100%;
      height: 100%;
      object-fit: contain;
      display: block;
    }
    .video-modal-footer {
      padding: 16px 24px;
      background: rgba(1, 18, 24, 0.95);
      border-top: 1px solid rgba(0, 229, 255, 0.15);
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 14px;
    }
    .video-modal-specs { font-size: 13px; color: var(--text-muted); }

    /* Footer */
    footer {
      background: rgba(1, 15, 20, 0.95);
      border-top: 1px solid var(--sky-border);
      padding: 36px 24px 28px;
      text-align: center;
      color: var(--text-muted);
      font-size: 14px;
    }
    footer p { margin-bottom: 10px; }

    @media (max-width: 900px) {
      .hero-sec { grid-template-columns: 1fr; gap: 36px; padding-top: 30px; }
      .calc-grid { grid-template-columns: 1fr; }
      .video-modal-player { height: 260px; }
      .studio-nav .nav-links { display: none; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="video" data-dk-accent="#00e5ff" data-dk-phone="994503936998" data-dk-sticky data-dk-action="submitVideoQuoteWhatsApp" data-dk-sticky-label="Təklif al">
  <script src="assets/demo-kit.js"></script>


  <!-- Top Demo Bar -->
  <div class="demo-bar">
    <div class="demo-bar-left">
      <span class="demo-badge">LIVE DEMO</span>
      <span class="demo-text"><?= e($t['demo_banner']) ?></span>
    </div>
    <div class="demo-bar-right">
      <div class="lang-pills">
        <a href="?lang=az" class="lang-pill <?= $lang === 'az' ? 'active' : '' ?>">AZ</a>
        <a href="?lang=en" class="lang-pill <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
        <a href="?lang=tr" class="lang-pill <?= $lang === 'tr' ? 'active' : '' ?>">TR</a>
        <a href="?lang=ru" class="lang-pill <?= $lang === 'ru' ? 'active' : '' ?>">RU</a>
      </div>
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-btn-back">← <?= e($t['back_to_sky']) ?></a>
      <a href="https://wa.me/994503936998?text=Salam,%20CineSky%20video%20saytı%20haqqında%20məlumat%20almaq%20istəyirəm" target="_blank" class="demo-btn-sky">
        <?= e($t['order_site']) ?> →
      </a>
    </div>
  </div>

  <!-- Studio Header -->
  <header class="studio-nav">
    <div class="nav-wrap">
      <div class="brand-box">
        <div class="brand-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
        </div>
        <div>
          <span class="brand-name"><?= e($t['brand_name']) ?></span>
          <span class="brand-sub"><?= e($t['brand_sub']) ?></span>
        </div>
      </div>
      <nav class="nav-links">
        <a href="#hero" class="nav-link"><?= e($t['nav_home']) ?></a>
        <a href="#portfolio" class="nav-link"><?= e($t['nav_portfolio']) ?></a>
        <a href="#calculator" class="nav-link"><?= e($t['nav_calc']) ?></a>
        <a href="https://wa.me/994503936998" target="_blank" class="nav-cta-btn"><?= e($t['nav_contact']) ?> →</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero-sec" id="hero">
    <div>
      <span class="hero-tag"><?= e($t['hero_tag']) ?></span>
      <h1 class="hero-h1">
        <?= e($t['hero_title_1']) ?><br>
        <span class="glow-cyan"><?= e($t['hero_title_2']) ?></span>
      </h1>
      <p class="hero-desc"><?= e($t['hero_desc']) ?></p>
      <div class="hero-actions">
        <button class="btn-hero-primary" onclick="openVideoModal(1)">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
          <?= e($t['btn_hero_watch']) ?>
        </button>
        <a href="#calculator" class="btn-hero-secondary">
          <?= e($t['btn_hero_calc']) ?> ↓
        </a>
      </div>
      <div class="hero-stats">
        <div>
          <div class="hero-stat-n"><?= e($t['stat_1_n']) ?></div>
          <div class="hero-stat-t"><?= e($t['stat_1_t']) ?></div>
        </div>
        <div>
          <div class="hero-stat-n"><?= e($t['stat_2_n']) ?></div>
          <div class="hero-stat-t"><?= e($t['stat_2_t']) ?></div>
        </div>
        <div>
          <div class="hero-stat-n"><?= e($t['stat_3_n']) ?></div>
          <div class="hero-stat-t"><?= e($t['stat_3_t']) ?></div>
        </div>
      </div>
    </div>

    <!-- Featured Showreel Video Card -->
    <div class="hero-player-card">
      <div class="hero-video-wrap">
        <video id="heroShowreelVideo" autoplay muted loop playsinline preload="auto">
          <source src="../../assets/videos/demo1.mp4" type="video/mp4">
        </video>
        <div class="hero-video-overlay"></div>
      </div>
      <div class="hero-video-bar">
        <div class="hero-video-meta">
          <span class="hero-video-title">CineSky Studio Showreel 2026</span>
          <span class="hero-video-sub">4K UHD Cinema Reel & Aerials</span>
        </div>
        <div class="hero-video-ctrls">
          <button class="ctrl-pill-btn" onclick="toggleHeroSound()">
            <span id="soundIcon"><?= e($t['sound_off']) ?></span>
          </button>
          <button class="ctrl-pill-btn" onclick="openVideoModal(1)">
            <?= e($t['btn_fullscreen']) ?>
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
  <section class="portfolio-sec" id="portfolio">
    <div class="sec-head">
      <h2 class="sec-title"><?= e($t['portfolio_title']) ?></h2>
      <p class="sec-sub"><?= e($t['portfolio_sub']) ?></p>
    </div>

    <!-- Filter Buttons -->
    <div class="filter-pills">
      <button class="filter-btn active" onclick="filterVideos('all', this)"><?= e($t['tab_all']) ?></button>
      <button class="filter-btn" onclick="filterVideos('commercial', this)">🎬 <?= e($t['tab_commercial']) ?></button>
      <button class="filter-btn" onclick="filterVideos('drone', this)">🚁 <?= e($t['tab_drone']) ?></button>
      <button class="filter-btn" onclick="filterVideos('reels', this)">📱 <?= e($t['tab_reels']) ?></button>
      <button class="filter-btn" onclick="filterVideos('corporate', this)">🎤 <?= e($t['tab_corporate']) ?></button>
    </div>

    <!-- Video Cards -->
    <div class="video-grid" id="videoGrid">
      <?php foreach ($video_items as $item): ?>
        <div class="video-card" data-cat="<?= e($item['cat']) ?>" onclick="openVideoModal(<?= (int)$item['id'] ?>)">
          <div class="video-thumb-wrap">
            <span class="video-card-badge"><?= strtoupper(e($item['cat'])) ?></span>
            <span class="video-duration"><?= e($item['duration']) ?></span>
            <img src="<?= e($item['thumb']) ?>" alt="<?= e($item['title']) ?>" loading="lazy">
            <div class="play-btn-overlay">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </div>
          </div>
          <div class="video-card-body">
            <div class="video-card-title"><?= e($item['title']) ?></div>
            <div class="video-card-client"><?= e($item['client']) ?></div>
            <div class="video-card-specs"><?= e($item['specs']) ?></div>
            <div class="video-card-action">
              <span class="btn-play-trigger">
                <span><?= e($t['btn_watch_explore']) ?></span> ➔
              </span>
              <span style="font-size:11px; color:var(--neon-purple); font-weight:700;">4K CINEMA</span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Video Budget Calculator Section -->
  <section class="calc-sec" id="calculator">
    <div class="calc-card">
      <div class="sec-head" style="text-align:left; margin-bottom:16px;">
        <h2 class="sec-title" style="font-size:26px;"><?= e($t['calc_title']) ?></h2>
        <p class="sec-sub" style="margin:0;"><?= e($t['calc_sub']) ?></p>
      </div>

      <div class="calc-grid">
        <div class="calc-group">
          <label class="calc-label"><?= e($t['field_video_type']) ?></label>
          <select class="calc-select" id="calcVideoType" onchange="calculateBudget()">
            <option value="350"><?= e($t['calc_opt_commercial']) ?></option>
            <option value="250"><?= e($t['calc_opt_reels']) ?></option>
            <option value="400"><?= e($t['calc_opt_drone_item']) ?></option>
            <option value="300"><?= e($t['calc_opt_corp']) ?></option>
          </select>

          <label class="calc-label" style="margin-top:14px;"><?= e($t['field_duration']) ?></label>
          <select class="calc-select" id="calcDuration" onchange="calculateBudget()">
            <option value="1"><?= e($t['calc_dur_half']) ?></option>
            <option value="1.6"><?= e($t['calc_dur_full']) ?></option>
            <option value="2.5"><?= e($t['calc_dur_2days']) ?></option>
          </select>
        </div>

        <div class="calc-group">
          <label class="calc-label"><?= e($t['field_gear']) ?></label>
          <div class="calc-checkboxes">
            <label class="calc-check-item">
              <input type="checkbox" id="optDrone" value="150" onchange="calculateBudget()">
              <span><?= e($t['calc_opt_drone']) ?></span>
            </label>
            <label class="calc-check-item">
              <input type="checkbox" id="optVoice" value="100" onchange="calculateBudget()">
              <span><?= e($t['calc_opt_voice']) ?></span>
            </label>
            <label class="calc-check-item">
              <input type="checkbox" id="optAnim" value="120" onchange="calculateBudget()">
              <span><?= e($t['calc_opt_anim']) ?></span>
            </label>
            <label class="calc-check-item">
              <input type="checkbox" id="optDavinci" value="80" onchange="calculateBudget()">
              <span><?= e($t['calc_opt_davinci']) ?></span>
            </label>
          </div>
        </div>
      </div>

      <div class="calc-bottom">
        <div class="calc-total-box">
          <span class="calc-total-lbl"><?= e($t['est_total']) ?></span>
          <span class="calc-total-val" id="calcTotalDisplay">350 AZN</span>
        </div>
        <button type="button" class="btn-calc-submit" onclick="submitVideoQuoteWhatsApp()">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/></svg>
          <?= e($t['btn_calc_order']) ?>
        </button>
      </div>
    </div>
  </section>

  <!-- Video Lightbox Modal -->
  <div class="video-modal-overlay" id="videoModalOverlay" onclick="if(event.target===this)closeVideoModal()">
    <div class="video-modal" id="videoModal">
      <div class="video-modal-header">
        <span class="video-modal-title" id="videoModalTitle">Video Başlığı</span>
        <button class="video-modal-close" onclick="closeVideoModal()">&times;</button>
      </div>
      <div class="video-modal-player">
        <video id="activeModalVideo" controls playsinline preload="metadata">
          <source src="" type="video/mp4">
          Brauzeriniz video formatını dəstəkləmir.
        </video>
      </div>
      <div class="video-modal-footer">
        <span class="video-modal-specs" id="videoModalSpecs">4K UHD • Cinema Gear</span>
        <button class="btn-hero-primary" style="padding:8px 18px; font-size:13px;" onclick="bookCurrentModalVideo()">
          <?= e($t['modal_btn_book']) ?> →
        </button>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Powered by <span style="color:var(--neon-cyan); font-weight:700;">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    const videoData = <?= json_encode($video_items, JSON_UNESCAPED_UNICODE) ?>;
    let currentSelectedVideo = null;

    function toggleHeroSound() {
      const vid = document.getElementById('heroShowreelVideo');
      const icon = document.getElementById('soundIcon');
      if (vid.muted) {
        vid.muted = false;
        icon.innerText = <?= json_encode($t['sound_on']) ?>;
      } else {
        vid.muted = true;
        icon.innerText = <?= json_encode($t['sound_off']) ?>;
      }
    }

    function filterVideos(cat, btn) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const cards = document.querySelectorAll('.video-card');
      cards.forEach(card => {
        if (cat === 'all' || card.getAttribute('data-cat') === cat) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    function openVideoModal(id) {
      const item = videoData.find(v => v.id === id) || videoData[0];
      currentSelectedVideo = item;
      document.getElementById('videoModalTitle').innerText = item.title + " (" + item.client + ")";
      document.getElementById('videoModalSpecs').innerText = "🎥 " + item.specs;
      const vid = document.getElementById('activeModalVideo');
      vid.src = item.video_src;
      vid.poster = item.thumb;
      document.getElementById('videoModalOverlay').classList.add('active');
      vid.play().catch(e => {});
    }

    function closeVideoModal() {
      const vid = document.getElementById('activeModalVideo');
      vid.pause();
      document.getElementById('videoModalOverlay').classList.remove('active');
    }

    function bookCurrentModalVideo() {
      const title = currentSelectedVideo ? currentSelectedVideo.title : DK.pick('4K Video Çəkilişi', '4K Video Production', '4K видеосъёмка', '4K Video Çekimi');
      const client = currentSelectedVideo && currentSelectedVideo.client ? ' · ' + currentSelectedVideo.client : '';
      DK.order({
        eyebrow: DK.pick('VİDEO SİFARİŞİ', 'VIDEO ORDER', 'ЗАКАЗ ВИДЕО', 'VİDEO SİPARİŞİ'),
        title: DK.pick('Layihəni müzakirə edək', 'Let\'s discuss your project', 'Обсудим проект', 'Projeyi konuşalım'),
        brand: 'CineSky Media',
        summary: DK.pick('Format: ', 'Format: ', 'Формат: ', 'Format: ') + title + client,
        lines: [
          DK.pick('Büdcə kalkulyatorundan dəqiq qiymət ala bilərsiniz.',
                  'You can get an exact price from the budget calculator.',
                  'Точную цену можно рассчитать в калькуляторе бюджета.',
                  'Kesin fiyatı bütçe hesaplayıcısından alabilirsiniz.')
        ]
      });
    }

    function calculateBudget() {
      const baseType = parseFloat(document.getElementById('calcVideoType').value) || 350;
      const mult = parseFloat(document.getElementById('calcDuration').value) || 1;
      let total = baseType * mult;

      if (document.getElementById('optDrone').checked) total += 150;
      if (document.getElementById('optVoice').checked) total += 100;
      if (document.getElementById('optAnim').checked) total += 120;
      if (document.getElementById('optDavinci').checked) total += 80;

      document.getElementById('calcTotalDisplay').innerText = Math.round(total) + " AZN";
      return Math.round(total);
    }

    function submitVideoQuoteWhatsApp() {
      const typeSelect = document.getElementById('calcVideoType');
      const durSelect = document.getElementById('calcDuration');
      const typeName = typeSelect.options[typeSelect.selectedIndex].text;
      const durName = durSelect.options[durSelect.selectedIndex].text;
      const baseType = parseFloat(typeSelect.value) || 350;
      const mult = parseFloat(durSelect.value) || 1;
      const total = calculateBudget();

      const items = [{ title: typeName, price: Math.round(baseType * mult), qty: 1, meta: durName }];
      if (document.getElementById('optDrone').checked) items.push({ title: DK.pick('4K Dron çəkilişi', '4K Drone footage', '4K съёмка с дрона', '4K Drone çekimi'), price: 150, qty: 1 });
      if (document.getElementById('optVoice').checked) items.push({ title: DK.pick('Peşəkar diktor səsləndirməsi', 'Pro voice-over', 'Профессиональная озвучка', 'Profesyonel seslendirme'), price: 100, qty: 1 });
      if (document.getElementById('optAnim').checked) items.push({ title: DK.pick('2D/3D hərəkətli qrafika', '2D/3D motion graphics', '2D/3D моушн-графика', '2D/3D hareketli grafik'), price: 120, qty: 1 });
      if (document.getElementById('optDavinci').checked) items.push({ title: DK.pick('DaVinci rəng korreksiyası', 'DaVinci color grading', 'Цветокоррекция DaVinci', 'DaVinci renk düzenleme'), price: 80, qty: 1 });

      DK.order({
        eyebrow: DK.pick('BÜDCƏ TƏKLİFİ', 'BUDGET QUOTE', 'СМЕТА', 'BÜTÇE TEKLİFİ'),
        title: DK.pick('Video büdcə təklifi', 'Video budget quote', 'Смета на видео', 'Video bütçe teklifi'),
        brand: 'CineSky Media',
        items: items,
        addressRequired: false,
        summary: DK.pick('Təxmini büdcə: ' + total + ' AZN · qiymətə çəkiliş, montaj və icarə daxildir.',
                        'Estimated budget: ' + total + ' AZN · includes shooting, editing and gear rental.',
                        'Ориентировочный бюджет: ' + total + ' AZN · включает съёмку, монтаж и аренду техники.',
                        'Tahmini bütçe: ' + total + ' AZN · çekim, kurgu ve ekipman kirası dahildir.')
      });
    }
  </script>
</body>
</html>
