<?php
require_once __DIR__ . '/../../config/lang.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });

if (!function_exists('e')) {
    function e(string $str): string {
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

$demo_texts = [
    'az' => [
        'banner_text' => 'Bu nümunə saytdır — Skyweb tərəfindən hazırlanmışdır',
        'back_to_sky' => 'Skyweb-ə Qayıt',
        'brand_name' => 'Velvet Brew',
        'brand_sub' => 'Xüsusi Qovrulmuş Qəhvə & Şirniyyat Evi',
        'nav_menu' => 'Qəhvə Menyu',
        'nav_pastry' => 'Şirniyyatlar',
        'nav_loyalty' => 'Sadiqlik Kartı',
        'nav_ambiance' => 'Atmosfer',
        'nav_baristas' => 'Baristalar',
        'nav_order' => 'Onlayn Sifariş',
        'hero_badge' => 'BAKININ MƏRKƏZİNDƏ SPESİALİTİ QƏHVƏ MƏKANI',
        'hero_title_1' => 'Hər Qurtumda Sənət,',
        'hero_title_2' => 'Hər Dəndə Sevgi.',
        'hero_desc' => 'Təzə qovrulmuş 100% Arabika dənələri, xüsusi reseptlər və isti fransız kruassanları ilə gününüzü fərqli edin.',
        'toggle_pickup' => 'Özünlə Götür (Pickup)',
        'toggle_delivery' => 'Çatdırılma (30 dəq)',
        'hero_cta' => 'Menyunu İncələ',
        'stat_beans' => '12+ Ölkədən Qəhvə',
        'stat_roasted' => 'Gündəlik Təzə Qovrulma',
        'stat_rating' => '4.95/5 Ziyarətçi Rəyi',
        'menu_title' => 'Qəhvə & İçki Menyumuz',
        'menu_sub' => 'Ölçü seçin: Kiçik (S), Orta (M), Böyük (L) — qiymət anında yenilənir.',
        'size_s' => 'Kiçik (S)',
        'size_m' => 'Orta (M)',
        'size_l' => 'Böyük (L)',
        'btn_add_cup' => 'Sifarişə Əlavə Et',
        'pastry_title' => 'Fırından Təzə Çıxan Şirniyyatlar',
        'pastry_sub' => 'Hər səhər təbii fransız kərə yağı ilə bişirilən desertlər.',
        'badge_fresh' => 'GÜNLÜK TƏZƏ',
        'loyalty_title' => 'Rəqəmsal Qəhvə Kartınız',
        'loyalty_sub' => '5 qəhvə sifariş edin, 6-cı fincan tamamilə BİZİM HƏDİYYƏMİZDİR!',
        'loyalty_status' => '5 / 6 fincan yığıldı — Növbəti qəhvəniz PULSUZDUR!',
        'loyalty_btn' => 'Son Fincanı Möhürlə',
        'loyalty_gift_alert' => 'Təbriklər! Siz pulsuz xüsusi latte qazandınız! Baristamıza göstərin.',
        'ambiance_title' => 'Məkanımızın Ruhunu Hiss Edin',
        'ambiance_sub' => 'İşləmək, oxumaq və ya dostlarla söhbət üçün ideal rahatlıq.',
        'barista_title' => 'Qəhvə Ustalarımız',
        'barista_sub' => 'Beynəlxalq SCA sertifikatlı çempion baristalarımız.',
        'cart_title' => 'Sifariş Səbəti',
        'cart_empty' => 'Səbətiniz hələlik boşdur',
        'subtotal' => 'Cəmi:',
        'order_whatsapp' => 'WhatsApp ilə Sifariş Et',
        'added_toast' => 'Fincan səbətə əlavə edildi!',
        'footer_hours' => 'Hər gün: 07:30 – 23:30',
        'footer_wifi' => 'Pulsuz WiFi: VelvetBrew_Guest / Şifrə: velvet2026',
        'footer_desc' => 'Bu demo kafe, qəhvəxana və şirniyyat mağazaları üçün Skyweb tərəfindən hazırlanmışdır.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'banner_text' => 'This is a demo website — Created by Skyweb',
        'back_to_sky' => 'Back to Skyweb',
        'brand_name' => 'Velvet Brew',
        'brand_sub' => 'Artisanal Specialty Coffee & Roastery',
        'nav_menu' => 'Coffee Menu',
        'nav_pastry' => 'Bakery',
        'nav_loyalty' => 'Stamp Card',
        'nav_ambiance' => 'Ambiance',
        'nav_baristas' => 'Baristas',
        'nav_order' => 'Order Now',
        'hero_badge' => 'SPECIALTY ROASTERY IN DOWNTOWN BAKU',
        'hero_title_1' => 'Crafted With Soul,',
        'hero_title_2' => 'Brewed To Perfection.',
        'hero_desc' => 'Freshly micro-roasted single-origin Arabica, hand-crafted specialty signatures, and hot French viennoiserie.',
        'toggle_pickup' => 'Takeaway / Pickup',
        'toggle_delivery' => 'Delivery (30 mins)',
        'hero_cta' => 'Explore Menu',
        'stat_beans' => '12+ Origins',
        'stat_roasted' => 'In-House Daily Roast',
        'stat_rating' => '4.95/5 Guest Rating',
        'menu_title' => 'Artisan Coffee & Craft Drinks',
        'menu_sub' => 'Select your preferred size: Small, Medium, Large — prices auto-update.',
        'size_s' => 'Small (S)',
        'size_m' => 'Medium (M)',
        'size_l' => 'Large (L)',
        'btn_add_cup' => 'Add to Order',
        'pastry_title' => 'Fresh From The Oven Pastries',
        'pastry_sub' => 'Baked every morning using pure Normandy butter.',
        'badge_fresh' => 'FRESH TODAY',
        'loyalty_title' => 'Digital Coffee Stamp Card',
        'loyalty_sub' => 'Collect 5 stamps and enjoy your 6th cup on the house!',
        'loyalty_status' => '5 of 6 stamps collected — Your next cup is FREE!',
        'loyalty_btn' => 'Stamp Final Cup',
        'loyalty_gift_alert' => 'Congratulations! You unlocked a Free Signature Latte! Show this to your barista.',
        'ambiance_title' => 'Experience Our Ambiance',
        'ambiance_sub' => 'A cozy haven for creative minds, book lovers, and coffee enthusiasts.',
        'barista_title' => 'Meet Our Master Baristas',
        'barista_sub' => 'SCA-certified champions dedicated to brewing magic.',
        'cart_title' => 'Your Order Bag',
        'cart_empty' => 'Your order bag is currently empty',
        'subtotal' => 'Subtotal:',
        'order_whatsapp' => 'Confirm via WhatsApp',
        'added_toast' => 'Added to your order bag!',
        'footer_hours' => 'Daily: 07:30 – 23:30',
        'footer_wifi' => 'Free WiFi: VelvetBrew_Guest / Pass: velvet2026',
        'footer_desc' => 'This demo was created by Skyweb to showcase modern, interactive websites for specialty cafes and coffee shops.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'banner_text' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'brand_name' => 'Velvet Brew',
        'brand_sub' => 'Özel Kavrum Kahve & Fırın Evi',
        'nav_menu' => 'Kahve Menüsü',
        'nav_pastry' => 'Tatlı & Fırın',
        'nav_loyalty' => 'Sadakat Kartı',
        'nav_ambiance' => 'Mekan',
        'nav_baristas' => 'Baristalar',
        'nav_order' => 'Sipariş Ver',
        'hero_badge' => 'BAKÜ MERKEZİNDE NİTELİKLİ KAHVE DURAĞI',
        'hero_title_1' => 'Her Yudumda Sanat,',
        'hero_title_2' => 'Her Çekirdekte Tutku.',
        'hero_desc' => 'Taze kavrulmuş %100 Arabica çekirdekleri, imza içecekler ve sıcak Fransız kruvasanları ile güne harika başlayın.',
        'toggle_pickup' => 'Gel Al (Paket)',
        'toggle_delivery' => 'Adrese Teslimat',
        'hero_cta' => 'Menüyü İncele',
        'stat_beans' => '12+ Ülke Çekirdeği',
        'stat_roasted' => 'Günlük Taze Kavrum',
        'stat_rating' => '4.95/5 Ziyaretçi Puanı',
        'menu_title' => 'Nitelikli Kahve Menümüz',
        'menu_sub' => 'Boyutunuzu seçin: Küçük (S), Orta (M), Büyük (L) — fiyatlar dinamik güncellenir.',
        'size_s' => 'Küçük (S)',
        'size_m' => 'Orta (M)',
        'size_l' => 'Büyük (L)',
        'btn_add_cup' => 'Siparişe Ekle',
        'pastry_title' => 'Fırından Yeni Çıkan Lezzetler',
        'pastry_sub' => 'Her sabah doğal tereyağı ile özenle hazırlanan taze tatlılar.',
        'badge_fresh' => 'GÜNLÜK TAZE',
        'loyalty_title' => 'Dijital Kahve Damga Kartı',
        'loyalty_sub' => '5 kahve alın, 6. fincan BİZDEN HEDİYE olsun!',
        'loyalty_status' => '5 / 6 damga tamamlandı — Sıradaki kahveniz BEDAVA!',
        'loyalty_btn' => 'Son Damgayı Vur',
        'loyalty_gift_alert' => 'Tebrikler! Ücretsiz Özel Latte hakkı kazandınız. Baristanıza gösterin.',
        'ambiance_title' => 'Sıcak ve İlham Veren Atmosfer',
        'ambiance_sub' => 'Çalışmak, kitap okumak veya keyifli sohbetler için eşsiz ortam.',
        'barista_title' => 'Kahve Ustalarımız',
        'barista_sub' => 'SCA sertifikalı şampiyon baristalarımız.',
        'cart_title' => 'Sipariş Çantanız',
        'cart_empty' => 'Sipariş çantanız henüz boş',
        'subtotal' => 'Toplam:',
        'order_whatsapp' => 'WhatsApp ile Tamamla',
        'added_toast' => 'Fincan siparişinize eklendi!',
        'footer_hours' => 'Her gün: 07:30 – 23:30',
        'footer_wifi' => 'Ücretsiz WiFi: VelvetBrew_Guest / Şifre: velvet2026',
        'footer_desc' => 'Bu demo, kahve dükkanları ve kafeler için Skyweb tarafından özel olarak geliştirilmiştir.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'banner_text' => 'Это демонстрационный сайт — Создан в Skyweb',
        'back_to_sky' => 'Назад в Skyweb',
        'brand_name' => 'Velvet Brew',
        'brand_sub' => 'Спешелти кофейня и собственная обжарка',
        'nav_menu' => 'Кофейная карта',
        'nav_pastry' => 'Выпечка',
        'nav_loyalty' => 'Карта гостя',
        'nav_ambiance' => 'Атмосфера',
        'nav_baristas' => 'Бариста',
        'nav_order' => 'Заказать',
        'hero_badge' => 'СПЕШЕЛТИ КОФЕЙНЯ В ЦЕНТРЕ БАКУ',
        'hero_title_1' => 'Искусство в каждой чашке,',
        'hero_title_2' => 'страсть в каждом зерне.',
        'hero_desc' => 'Свежеобжаренная 100% Арабика лучших терруаров мира, авторские напитки и хрустящие французские круассаны.',
        'toggle_pickup' => 'Навынос (Самовывоз)',
        'toggle_delivery' => 'Доставка курьером',
        'hero_cta' => 'Открыть меню',
        'stat_beans' => '12+ Сортов зерна',
        'stat_roasted' => 'Свежая обжарка каждый день',
        'stat_rating' => '4.95/5 Рейтинг гостей',
        'menu_title' => 'Авторское кофейное меню',
        'menu_sub' => 'Выберите размер чашки: S, M, L — стоимость обновится автоматически.',
        'size_s' => 'Маленький (S)',
        'size_m' => 'Средний (M)',
        'size_l' => 'Большой (L)',
        'btn_add_cup' => 'Добавить в заказ',
        'pastry_title' => 'Свежая выпечка из печи',
        'pastry_sub' => 'Выпекается каждое утро на натуральном нормандском масле.',
        'badge_fresh' => 'ИЗ ПЕЧИ',
        'loyalty_title' => 'Цифровая карта постоянного гостя',
        'loyalty_sub' => 'Закажите 5 чашек кофе, и 6-я будет БЕСПЛАТНОЙ!',
        'loyalty_status' => 'Собрано 5 из 6 штампов — Следующая чашка В ПОДАРОК!',
        'loyalty_btn' => 'Поставить финальный штамп',
        'loyalty_gift_alert' => 'Поздравляем! Вы получили бесплатный авторский латте. Покажите экран бариста.',
        'ambiance_title' => 'Уютная атмосфера кофейни',
        'ambiance_sub' => 'Идеальное пространство для работы с ноутбуком, чтения и теплых встреч.',
        'barista_title' => 'Наши шеф-бариста',
        'barista_sub' => 'Сертифицированные мастера SCA и чемпионы по латте-арту.',
        'cart_title' => 'Ваш заказ',
        'cart_empty' => 'В заказе пока пусто',
        'subtotal' => 'Сумма заказа:',
        'order_whatsapp' => 'Оформить через WhatsApp',
        'added_toast' => 'Напиток добавлен в заказ!',
        'footer_hours' => 'Ежедневно: 07:30 – 23:30',
        'footer_wifi' => 'Бесплатный WiFi: VelvetBrew_Guest / Пароль: velvet2026',
        'footer_desc' => 'Данный демонстрационный сайт разработан веб-студией Skyweb для кофеен и пекарен.',
        'all_rights' => 'Все права защищены.',
    ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$coffees = [
    [
        'id' => 1,
        'title' => [
            'az' => 'Velvet Spanish Latte (İmza)',
            'en' => 'Velvet Signature Spanish Latte',
            'tr' => 'Velvet İspanyol Latte',
            'ru' => 'Испанский латте Velvet'
        ],
        'desc' => 'Qatılaşdırılmış südlü qaymaqlı ikili şot espresso və darçın tozu.',
        'prices' => ['s' => 5.00, 'm' => 6.00, 'l' => 7.00],
        'img' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=400&q=80',
        'roast' => 'Efiopiya Yirgacheffe'
    ],
    [
        'id' => 2,
        'title' => [
            'az' => 'Püstəli Kortado (Pistachio Cortado)',
            'en' => 'Pistachio Velvet Cortado',
            'tr' => 'Antep Fıstıklı Cortado',
            'ru' => 'Фисташковый Кортадо'
        ],
        'desc' => '100% təbii püstə pastası, ipək toxumalı buxarlanmış süd və zərif mikroköpük.',
        'prices' => ['s' => 5.50, 'm' => 6.50, 'l' => 7.50],
        'img' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=400&q=80',
        'roast' => 'Kolumbiya Supremo'
    ],
    [
        'id' => 3,
        'title' => [
            'az' => 'Filter V60 Hand-Drip',
            'en' => 'Single-Origin V60 Hand Brew',
            'tr' => 'V60 Demleme Filtre Kahve',
            'ru' => 'Фильтр-кофе V60 Ручной завар'
        ],
        'desc' => 'Çiçək və giləmeyvə notaları ilə parlaq, təmiz gövdəli xüsusi dəmləmə.',
        'prices' => ['s' => 4.50, 'm' => 5.50, 'l' => 6.50],
        'img' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=400&q=80',
        'roast' => 'Keniya AA Nyeri'
    ],
    [
        'id' => 4,
        'title' => [
            'az' => 'Klassik Kapuçino & İncə Köpük',
            'en' => 'Classic Velvety Cappuccino',
            'tr' => 'Klasik Kadife Köpüklü Cappuccino',
            'ru' => 'Классический шелковистый Капучино'
        ],
        'desc' => 'Dərin şokolad və fındıq notları ilə balanslaşdırılmış mükəmməl espresso harmoniyası.',
        'prices' => ['s' => 4.00, 'm' => 5.00, 'l' => 6.00],
        'img' => 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=400&q=80',
        'roast' => 'Braziliya Cerrado'
    ],
    [
        'id' => 5,
        'title' => [
            'az' => 'Soyuq Dəmləmə Qəhvə (Nitro Cold Brew)',
            'en' => 'Nitro Infused Cold Brew',
            'tr' => 'Nitro Soğuk Demleme (Cold Brew)',
            'ru' => 'Нитро Колд Брю 18-часовой экстракции'
        ],
        'desc' => '18 saat soyuq suda ekstraksiya olunmuş, məxməri azot köpüklü qara qəhvə.',
        'prices' => ['s' => 5.20, 'm' => 6.20, 'l' => 7.20],
        'img' => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=400&q=80',
        'roast' => 'Qvatemala Antigua'
    ],
    [
        'id' => 6,
        'title' => [
            'az' => 'Uji Matcha Latte (Yapon Çayı)',
            'en' => 'Ceremonial Uji Matcha Latte',
            'tr' => 'Japon Uji Matcha Latte',
            'ru' => 'Церемониальный зеленый Матча Латте'
        ],
        'desc' => 'Kyotodan gətirilmiş ən yüksək dərəcəli seremonial yaşıl çay tozu və yulaf südü.',
        'prices' => ['s' => 5.80, 'm' => 6.80, 'l' => 7.80],
        'img' => 'https://images.unsplash.com/photo-1536256263959-770b48d82b0a?w=400&q=80',
        'roast' => 'Kyoto Organic Matcha'
    ],
];

$pastries = [
    [
        'name' => 'San Sebastian Çizkeyk',
        'name_en' => 'San Sebastian Cheesecake',
        'desc' => 'İsti Belçika şokolad sousu ilə təqdim olunur.',
        'price' => 7.50,
        'img' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=400&q=80'
    ],
    [
        'name' => 'Püstəli & Qaymaqlı Kruassan',
        'name_en' => 'Pistachio Supreme Croissant',
        'desc' => 'Təbii kərə yağı ilə 72 qatlı xırtıldayan xəmir.',
        'price' => 5.80,
        'img' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=400&q=80'
    ],
    [
        'name' => 'Qozlu Brauni & Dondurma',
        'name_en' => 'Warm Fudge Brownie',
        'desc' => '70% tünd şokolad və vanilli İtalyan gelatosu.',
        'price' => 6.20,
        'img' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400&q=80'
    ],
    [
        'name' => 'Moruqlu Badam Tartı',
        'name_en' => 'Raspberry Almond Tart',
        'desc' => 'Təzə moruq və fransız badam kremi frangipane.',
        'price' => 5.40,
        'img' => 'https://images.unsplash.com/photo-1519869325930-281384150729?w=400&q=80'
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
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: #002626;
      --sky-card-hover: #003636;
      --neon-cyan: #00FFFF;
      --neon-glow: rgba(0, 255, 255, 0.35);
      --amber: #f59e0b;
      --amber-glow: rgba(245, 158, 11, 0.35);
      --emerald: #10b981;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --border-glass: rgba(0, 255, 255, 0.16);
      --font-heading: 'Outfit', sans-serif;
      --font-body: 'Plus Jakarta Sans', sans-serif;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      background-color: var(--sky-bg);
      background-image: 
        radial-gradient(circle at 10% 20%, rgba(0, 255, 255, 0.08) 0%, transparent 45%),
        radial-gradient(circle at 85% 75%, rgba(245, 158, 11, 0.08) 0%, transparent 45%);
      color: var(--text-main);
      font-family: var(--font-body);
      line-height: 1.6;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; }

    /* Top Skyweb Bar */
    .sky-demo-bar {
      background: linear-gradient(90deg, #001010 0%, #002828 50%, #001010 100%);
      border-bottom: 1px solid var(--border-glass);
      padding: 8px 16px;
      font-size: 13px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      backdrop-filter: blur(10px);
    }
    .demo-pill {
      background: rgba(0, 255, 255, 0.15);
      color: var(--neon-cyan);
      border: 1px solid var(--neon-cyan);
      padding: 2px 8px;
      border-radius: 999px;
      font-weight: 800;
      font-size: 11px;
    }
    .demo-back-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--neon-cyan);
      font-weight: 600;
    }
    .demo-back-btn:hover { text-shadow: 0 0 10px var(--neon-cyan); }
    .lang-switcher { display: flex; gap: 6px; }
    .lang-btn {
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-muted);
      background: rgba(255,255,255,0.06);
      transition: all 0.2s;
    }
    .lang-btn.active, .lang-btn:hover {
      color: #000;
      background: var(--neon-cyan);
      box-shadow: 0 0 10px var(--neon-glow);
    }

    /* Navbar */
    .navbar {
      max-width: 1240px;
      margin: 0 auto;
      padding: 20px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-heading);
      font-weight: 900;
      font-size: 26px;
      color: #fff;
    }
    .brand svg { color: var(--neon-cyan); filter: drop-shadow(0 0 8px var(--neon-cyan)); }
    .nav-links { display: flex; gap: 28px; list-style: none; font-size: 15px; font-weight: 600; }
    .nav-links a { color: var(--text-muted); transition: color 0.2s; }
    .nav-links a:hover { color: var(--neon-cyan); }
    .nav-cart-btn {
      background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(245, 158, 11, 0.2));
      border: 1px solid var(--neon-cyan);
      color: #fff;
      font-weight: 800;
      padding: 10px 20px;
      border-radius: 999px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .nav-cart-btn:hover { background: var(--neon-cyan); color: #000; box-shadow: 0 0 20px var(--neon-glow); }
    .cart-badge { background: var(--amber); color: #000; font-size: 12px; font-weight: 800; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }

    /* Hero */
    .hero {
      margin: 20px auto 50px;
      background: linear-gradient(135deg, rgba(0, 36, 36, 0.88) 0%, rgba(0, 18, 18, 0.96) 100%),
                  url('https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=1600&q=80') center/cover;
      border: 1px solid var(--border-glass);
      border-radius: 28px;
      padding: 70px 48px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.6);
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 40px;
      align-items: center;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 0.5px;
      margin-bottom: 20px;
    }
    .hero h1 {
      font-family: var(--font-heading);
      font-size: clamp(34px, 5.5vw, 60px);
      line-height: 1.1;
      font-weight: 900;
      margin-bottom: 16px;
    }
    .hero h1 span {
      background: linear-gradient(90deg, #fff 0%, var(--neon-cyan) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero p { color: #cbd5e1; font-size: 16px; max-width: 520px; margin-bottom: 30px; }

    .service-toggle-wrap {
      display: inline-flex;
      background: rgba(0, 20, 20, 0.8);
      border: 1px solid var(--border-glass);
      border-radius: 999px;
      padding: 4px;
      margin-bottom: 32px;
    }
    .toggle-opt {
      padding: 8px 20px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 700;
      color: var(--text-muted);
      transition: all 0.2s;
    }
    .toggle-opt.active { background: var(--neon-cyan); color: #000; box-shadow: 0 0 15px var(--neon-glow); }

    .hero-stats {
      display: flex;
      gap: 28px;
      padding-top: 24px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }
    .hero-stat strong { display: block; font-size: 20px; font-weight: 800; color: var(--neon-cyan); font-family: var(--font-heading); }
    .hero-stat span { font-size: 13px; color: var(--text-muted); }

    .hero-photo-wrap {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid var(--border-glass);
      box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }
    .hero-photo-wrap img { width: 100%; height: 340px; object-fit: cover; display: block; }

    /* Section Headings */
    .section-head { text-align: center; margin: 60px 0 36px; }
    .section-head h2 { font-family: var(--font-heading); font-size: 32px; font-weight: 800; color: #fff; }
    .section-head p { color: var(--text-muted); font-size: 15px; margin-top: 4px; }

    /* Coffee Grid */
    .coffee-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
      gap: 28px;
      margin-bottom: 70px;
    }
    .coffee-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 22px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s;
    }
    .coffee-card:hover {
      transform: translateY(-6px);
      border-color: var(--neon-cyan);
      box-shadow: 0 15px 35px rgba(0, 255, 255, 0.15);
    }
    .coffee-img-box { height: 210px; position: relative; overflow: hidden; }
    .coffee-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
    .coffee-card:hover .coffee-img-box img { transform: scale(1.08); }
    .coffee-roast-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: rgba(0, 24, 24, 0.85);
      border: 1px solid var(--border-glass);
      color: var(--amber);
      font-size: 12px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 6px;
    }
    .coffee-body { padding: 22px; display: flex; flex-direction: column; flex: 1; }
    .coffee-title { font-family: var(--font-heading); font-size: 19px; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .coffee-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 18px; flex: 1; }

    .size-selector {
      display: flex;
      gap: 6px;
      background: rgba(0, 16, 16, 0.6);
      padding: 4px;
      border-radius: 10px;
      border: 1px solid rgba(255,255,255,0.06);
      margin-bottom: 18px;
    }
    .size-btn {
      flex: 1;
      padding: 6px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      color: var(--text-muted);
      background: none;
      transition: all 0.2s;
    }
    .size-btn.active {
      background: var(--neon-cyan);
      color: #000;
      box-shadow: 0 0 10px var(--neon-glow);
    }

    .coffee-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid rgba(255,255,255,0.06);
      padding-top: 14px;
    }
    .live-price { font-size: 22px; font-weight: 900; color: var(--neon-cyan); font-family: var(--font-heading); }
    .btn-add-cup {
      background: linear-gradient(135deg, var(--neon-cyan), #00e5ff);
      color: #000;
      font-weight: 800;
      font-size: 13px;
      padding: 10px 18px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 0 15px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-add-cup:hover { transform: translateY(-2px); box-shadow: 0 0 25px var(--neon-cyan); }

    /* Pastry Grid */
    .pastry-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 24px;
      margin-bottom: 70px;
    }
    .pastry-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 18px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }
    .pastry-img-box { height: 180px; position: relative; }
    .pastry-img-box img { width: 100%; height: 100%; object-fit: cover; }
    .pastry-body { padding: 18px; display: flex; flex-direction: column; flex: 1; }
    .pastry-title { font-family: var(--font-heading); font-size: 17px; font-weight: 800; color: #fff; margin-bottom: 6px; }
    .pastry-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 14px; flex: 1; }
    .pastry-footer { display: flex; justify-content: space-between; align-items: center; }

    /* Loyalty Stamp Card */
    .loyalty-section {
      background: linear-gradient(135deg, #002b2b 0%, #001717 100%);
      border: 1px solid var(--border-glass);
      border-radius: 26px;
      padding: 44px;
      margin-bottom: 80px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .stamp-grid-card {
      background: #001e1e;
      border: 2px dashed var(--neon-cyan);
      border-radius: 20px;
      padding: 28px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }
    .stamp-slot {
      height: 74px;
      border-radius: 14px;
      border: 1px solid var(--border-glass);
      background: rgba(0, 32, 32, 0.6);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      font-size: 11px;
      font-weight: 700;
      color: var(--text-muted);
      position: relative;
    }
    .stamp-slot.active {
      border-color: var(--amber);
      background: rgba(245, 158, 11, 0.15);
      color: var(--amber);
    }
    .stamp-slot.active svg { color: var(--amber); filter: drop-shadow(0 0 8px var(--amber)); }
    .stamp-slot.free-slot {
      border-color: var(--neon-cyan);
      background: rgba(0, 255, 255, 0.15);
      color: var(--neon-cyan);
    }

    /* Ambiance Gallery */
    .ambiance-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 80px;
    }
    .ambiance-photo {
      height: 220px;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid var(--border-glass);
    }
    .ambiance-photo:first-child { grid-column: span 2; }
    .ambiance-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
    .ambiance-photo:hover img { transform: scale(1.08); }

    /* Baristas */
    .baristas-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 28px;
      margin-bottom: 80px;
    }
    .barista-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      gap: 20px;
      align-items: center;
    }
    .barista-avatar { width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 2px solid var(--neon-cyan); }
    .barista-info h4 { font-family: var(--font-heading); font-size: 19px; color: #fff; }
    .barista-info p { font-size: 13px; color: var(--neon-cyan); font-weight: 600; margin: 4px 0 8px; }
    .barista-info span { font-size: 13px; color: var(--text-muted); }

    /* Cart Drawer */
    .cart-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.7);
      backdrop-filter: blur(5px);
      z-index: 2000;
      display: none;
    }
    .cart-overlay.active { display: block; }
    .cart-drawer {
      position: fixed;
      top: 0; right: -420px; bottom: 0;
      width: 100%;
      max-width: 400px;
      background: #001e1e;
      border-left: 1px solid var(--border-glass);
      z-index: 2001;
      display: flex;
      flex-direction: column;
      transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .cart-drawer.active { right: 0; }
    .cart-header {
      padding: 20px;
      border-bottom: 1px solid var(--border-glass);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-close { background: none; color: #fff; font-size: 24px; }
    .cart-body { flex: 1; overflow-y: auto; padding: 20px; }
    .cart-order-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 12px 0;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .cart-footer { padding: 20px; border-top: 1px solid var(--border-glass); background: #001616; }
    .btn-checkout-wa {
      width: 100%;
      background: #25d366;
      color: #fff;
      font-weight: 900;
      padding: 14px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
      transition: all 0.2s;
    }
    .btn-checkout-wa:hover { background: #20bd5a; transform: translateY(-2px); }

    /* Toast */
    .toast-box {
      position: fixed;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%) translateY(100px);
      background: var(--neon-cyan);
      color: #000;
      font-weight: 800;
      padding: 12px 24px;
      border-radius: 999px;
      box-shadow: 0 10px 25px var(--neon-glow);
      z-index: 3000;
      transition: transform 0.3s;
      pointer-events: none;
    }
    .toast-box.show { transform: translateX(-50%) translateY(0); }

    /* Floating WhatsApp */
    .float-wa {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #25d366;
      color: #fff;
      width: 58px;
      height: 58px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
      z-index: 999;
      transition: all 0.3s;
    }
    .float-wa:hover { transform: scale(1.1); box-shadow: 0 10px 30px rgba(37, 211, 102, 0.7); }

    /* Footer */
    footer {
      background: #001010;
      border-top: 1px solid var(--border-glass);
      padding: 40px 24px 24px;
      text-align: center;
    }
    footer p { color: var(--text-muted); font-size: 13px; margin-bottom: 6px; }

    @media (max-width: 900px) {
      .nav-links { display: none; }
      .hero { grid-template-columns: 1fr; padding: 36px 20px; }
      .hero-photo-wrap { display: none; }
      .loyalty-section, .baristas-grid { grid-template-columns: 1fr; }
      .ambiance-grid { grid-template-columns: 1fr 1fr; }
      .ambiance-photo:first-child { grid-column: span 1; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="cafe" data-dk-accent="#f59e0b" data-dk-phone="994503936998" data-dk-sticky data-dk-action="checkoutCafeOrder" data-dk-sticky-label="Sifariş">
  <script src="assets/demo-kit.js"></script>


  <!-- Demo Bar -->
  <div class="sky-demo-bar">
    <div style="display: flex; align-items: center; gap: 8px;">
      <span class="demo-pill">DEMO</span>
      <span><?= e($t['banner_text']) ?></span>
    </div>
    <div style="display: flex; align-items: center; gap: 16px;">
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-back-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        <?= e($t['back_to_sky']) ?>
      </a>
      <div class="lang-switcher">
        <?php foreach (['az', 'en', 'tr', 'ru'] as $code): ?>
          <a href="<?= e(lang_url($code)) ?>" class="lang-btn <?= $code === $lang ? 'active' : '' ?>">
            <?= strtoupper($code) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Navbar -->
  <header class="navbar">
    <a href="#" class="brand">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"/>
      </svg>
      <?= e($t['brand_name']) ?>
    </a>
    <ul class="nav-links">
      <li><a href="#menu"><?= e($t['nav_menu']) ?></a></li>
      <li><a href="#pastry"><?= e($t['nav_pastry']) ?></a></li>
      <li><a href="#loyalty"><?= e($t['nav_loyalty']) ?></a></li>
      <li><a href="#ambiance"><?= e($t['nav_ambiance']) ?></a></li>
      <li><a href="#baristas"><?= e($t['nav_baristas']) ?></a></li>
    </ul>
    <button class="nav-cart-btn" id="openBagBtn">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4zM3 6h18M16 10a4 4 0 0 1-8 0"/></svg>
      <span class="cart-badge" id="bagCount" data-dk-count>0</span>
    </button>
  </header>

  <main class="container">
    <!-- Hero Section -->
    <section class="hero">
      <div>
        <span class="hero-badge">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <?= e($t['hero_badge']) ?>
        </span>
        <h1><?= e($t['hero_title_1']) ?><br><span><?= e($t['hero_title_2']) ?></span></h1>
        <p><?= e($t['hero_desc']) ?></p>

        <!-- Mode Toggle -->
        <div class="service-toggle-wrap">
          <button class="toggle-opt active" onclick="setMode(this, 'pickup')"><?= e($t['toggle_pickup']) ?></button>
          <button class="toggle-opt" onclick="setMode(this, 'delivery')"><?= e($t['toggle_delivery']) ?></button>
        </div>

        <div>
          <a href="#menu" class="btn-add-cup" style="display:inline-flex; padding:14px 32px; font-size:15px; border-radius:999px;">
            <?= e($t['hero_cta']) ?>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
        </div>

        <div class="hero-stats">
          <div class="hero-stat">
            <strong><?= e($t['stat_beans']) ?></strong>
            <span>Direct Trade</span>
          </div>
          <div class="hero-stat">
            <strong><?= e($t['stat_roasted']) ?></strong>
            <span>Giesen W6A Roaster</span>
          </div>
          <div class="hero-stat">
            <strong><?= e($t['stat_rating']) ?></strong>
            <span>Google Reviews</span>
          </div>
        </div>
      </div>

      <div class="hero-photo-wrap">
        <img src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80" alt="Artisan Cafe Bar">
      </div>
    </section>

    <!-- Coffee Menu -->
    <section id="menu">
      <div class="section-head">
        <h2><?= e($t['menu_title']) ?></h2>
        <p><?= e($t['menu_sub']) ?></p>
      </div>

      <div class="coffee-grid">
        <?php foreach ($coffees as $c): ?>
          <?php $ctitle = $c['title'][$lang] ?? $c['title']['az']; ?>
          <div class="coffee-card" data-id="<?= e($c['id']) ?>" data-prices='<?= json_encode($c['prices']) ?>'>
            <div class="coffee-img-box">
              <img src="<?= e($c['img']) ?>" alt="<?= e($ctitle) ?>" loading="lazy">
              <span class="coffee-roast-badge"><?= e($c['roast']) ?></span>
            </div>
            <div class="coffee-body">
              <h3 class="coffee-title"><?= e($ctitle) ?></h3>
              <p class="coffee-desc"><?= e($c['desc']) ?></p>

              <!-- Size selector -->
              <div class="size-selector">
                <button class="size-btn active" onclick="changeSize(this, <?= $c['id'] ?>, 's')"><?= e($t['size_s']) ?></button>
                <button class="size-btn" onclick="changeSize(this, <?= $c['id'] ?>, 'm')"><?= e($t['size_m']) ?></button>
                <button class="size-btn" onclick="changeSize(this, <?= $c['id'] ?>, 'l')"><?= e($t['size_l']) ?></button>
              </div>

              <div class="coffee-footer">
                <div class="live-price" id="price-<?= $c['id'] ?>"><?= number_format($c['prices']['s'], 2) ?> ₼</div>
                <button class="btn-add-cup" onclick="addCoffeeToBag(<?= $c['id'] ?>, '<?= e(addslashes($ctitle)) ?>')">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  <?= e($t['btn_add_cup']) ?>
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Pastry Showcase -->
    <section id="pastry">
      <div class="section-head">
        <h2><?= e($t['pastry_title']) ?></h2>
        <p><?= e($t['pastry_sub']) ?></p>
      </div>

      <div class="pastry-grid">
        <?php foreach ($pastries as $p): ?>
          <div class="pastry-card">
            <div class="pastry-img-box">
              <img src="<?= e($p['img']) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
            </div>
            <div class="pastry-body">
              <h3 class="pastry-title"><?= e($p['name']) ?></h3>
              <p class="pastry-desc"><?= e($p['desc']) ?></p>
              <div class="pastry-footer">
                <span style="font-size:18px; font-weight:800; color:var(--amber);"><?= number_format($p['price'], 2) ?> ₼</span>
                <button class="btn-add-cup" style="padding:6px 14px; font-size:12px;" onclick="addPastryToBag('<?= e(addslashes($p['name'])) ?>', <?= $p['price'] ?>)">
                  + Səbətə
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Loyalty Stamp Card -->
    <section id="loyalty" class="loyalty-section">
      <div>
        <span style="background:var(--amber); color:#000; font-weight:800; font-size:11px; padding:3px 10px; border-radius:999px;">LOYALTY CLUB</span>
        <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:900; margin:12px 0;"><?= e($t['loyalty_title']) ?></h2>
        <p style="color:var(--text-muted); font-size:15px; margin-bottom:18px;"><?= e($t['loyalty_sub']) ?></p>
        <p style="color:var(--neon-cyan); font-weight:700; margin-bottom:24px;"><?= e($t['loyalty_status']) ?></p>
        <button class="btn-add-cup" style="padding:14px 28px; border-radius:999px;" onclick="stampFinalCard()"><?= e($t['loyalty_btn']) ?></button>
      </div>

      <div class="stamp-grid-card">
        <div class="stamp-slot active">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>1. Fincan</span>
        </div>
        <div class="stamp-slot active">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>2. Fincan</span>
        </div>
        <div class="stamp-slot active">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>3. Fincan</span>
        </div>
        <div class="stamp-slot active">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>4. Fincan</span>
        </div>
        <div class="stamp-slot active">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
          <span>5. Fincan</span>
        </div>
        <div class="stamp-slot free-slot" id="sixthSlot">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <span>PULSUZ!</span>
        </div>
      </div>
    </section>

    <!-- Ambiance Gallery -->
    <section id="ambiance">
      <div class="section-head">
        <h2><?= e($t['ambiance_title']) ?></h2>
        <p><?= e($t['ambiance_sub']) ?></p>
      </div>
      <div class="ambiance-grid">
        <div class="ambiance-photo">
          <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=800&q=80" alt="Cafe Interior">
        </div>
        <div class="ambiance-photo">
          <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&q=80" alt="Coffee Table">
        </div>
        <div class="ambiance-photo">
          <img src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?w=600&q=80" alt="Roasting Beans">
        </div>
        <div class="ambiance-photo">
          <img src="https://images.unsplash.com/photo-1511920170033-f8396924c348?w=600&q=80" alt="Latte Art">
        </div>
        <div class="ambiance-photo">
          <img src="https://images.unsplash.com/photo-1521017432531-fbd92d768814?w=600&q=80" alt="Outdoor Patio">
        </div>
      </div>
    </section>

    <!-- Baristas -->
    <section id="baristas">
      <div class="section-head">
        <h2><?= e($t['barista_title']) ?></h2>
        <p><?= e($t['barista_sub']) ?></p>
      </div>
      <div class="baristas-grid">
        <div class="barista-card">
          <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80" class="barista-avatar" alt="Aysel">
          <div class="barista-info">
            <h4>Aysel Kərimova</h4>
            <p>Baş Roaster & SCA Barista Pro</p>
            <span>Sevimlisi: Efiopiya V60 Filter dəmləməsi</span>
          </div>
        </div>
        <div class="barista-card">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80" class="barista-avatar" alt="Elmir">
          <div class="barista-info">
            <h4>Elmir Qasımov</h4>
            <p>Bakı Latte Art 2024 Çempionu</p>
            <span>Sevimlisi: İkiqat şot Pistachio Cortado</span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Bag Drawer -->
  <div class="cart-overlay" id="bagOverlay"></div>
  <aside class="cart-drawer" id="bagDrawer">
    <div class="cart-header">
      <h3 style="font-family:var(--font-heading); font-size:18px;"><?= e($t['cart_title']) ?></h3>
      <button class="cart-close" id="closeBagBtn">&times;</button>
    </div>
    <div class="cart-body" id="bagItemsList">
      <p style="text-align:center; color:var(--text-muted); margin-top:40px;"><?= e($t['cart_empty']) ?></p>
    </div>
    <div class="cart-footer">
      <div style="display:flex; justify-content:space-between; margin-bottom:16px; font-weight:800; font-size:17px;">
        <span><?= e($t['subtotal']) ?></span>
        <span style="color:var(--neon-cyan);" id="bagSubtotal">0.00 ₼</span>
      </div>
      <button class="btn-checkout-wa" onclick="checkoutCafeOrder()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2Z"/>
        </svg>
        <?= e($t['order_whatsapp']) ?>
      </button>
    </div>
  </aside>

  <!-- Toast -->
  <div class="toast-box" id="toastBox"><?= e($t['added_toast']) ?></div>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/994503936998?text=Salam,%20Velvet%20Brew%20sifarişi%20vermək%20istəyirəm" target="_blank" class="float-wa" title="WhatsApp Sifariş">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/>
    </svg>
  </a>

  <!-- Footer -->
  <footer>
    <p>☕ <?= e($t['footer_hours']) ?> &bull; 📍 Nizami küç. 12, Bakı &bull; <?= e($t['footer_wifi']) ?></p>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Crafted by <span style="color:var(--neon-cyan); font-weight:700;">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    /* ── Velvet Brew · səbət + rəqəmsal loyallıq kartı ── */
    const coffeeSizes = {};
    const coffeesData = <?= json_encode($coffees) ?>;

    const bagApi = DK.cart('cafe-bag', function () { updateBagUI(); });
    Object.defineProperty(window, 'bag', {
      get: function () { return bagApi.items; },
      set: function (v) { bagApi.items = v; bagApi.bump(); }
    });

    /* ── Loyalty stamp card (persistent) ── */
    const STAMP_KEY = 'cafe-stamps';
    const MAX_STAMPS = 5;
    let stamps = Number(DK.store(STAMP_KEY));
    if (isNaN(stamps)) stamps = 4;
    let freeCupReady = false;

    function renderStamps() {
      const slots = document.querySelectorAll('.stamp-slot');
      slots.forEach(function (slot, i) {
        if (i < MAX_STAMPS) slot.classList.toggle('active', i < stamps);
      });
      const sixth = document.getElementById('sixthSlot');
      freeCupReady = stamps >= MAX_STAMPS;
      if (sixth) {
        sixth.classList.toggle('active', freeCupReady);
        sixth.classList.toggle('free-slot', !freeCupReady);
      }
      const card = document.querySelector('.stamp-grid-card');
      if (card) {
        let note = document.getElementById('stampNote');
        if (!note) {
          note = document.createElement('div');
          note.id = 'stampNote';
          note.className = 'dk-ship';
          note.style.cssText = 'grid-column:1/-1;text-align:center;margin-top:.6rem;font-size:12px';
          card.parentNode.insertBefore(note, card.nextSibling);
        }
        note.innerHTML = freeCupReady
          ? '🎁 ' + DK.pick('Pulsuz fincan hazırdır — sifarişə avtomatik əlavə olunur',
              'Free cup unlocked — added to your order automatically',
              'Бесплатная чашка доступна — добавляется в заказ',
              'Ücretsiz fincan hazır — siparişe otomatik eklenir')
          : '<b>' + (MAX_STAMPS - stamps) + '</b> ' + DK.pick('fincan sonra pulsuz içki',
              'more cups until a free drink', 'чашек до бесплатного напитка', 'fincan sonra ücretsiz içecek') +
            '<div class="dk-track"><i style="width:' + (stamps / MAX_STAMPS * 100) + '%"></i></div>';
      }
    }

    function stampFinalCard() {
      if (stamps >= MAX_STAMPS) {
        DK.toast(DK.pick('Pulsuz fincanınız artıq aktivdir 🎁', 'Your free cup is already active 🎁',
          'Бесплатная чашка уже активна 🎁', 'Ücretsiz fincanınız zaten aktif 🎁'), 'info');
        return;
      }
      stamps++;
      DK.store(STAMP_KEY, stamps);
      renderStamps();
      DK.toast('<?= e(addslashes($t['loyalty_gift_alert'])) ?>');
      if (stamps >= MAX_STAMPS) {
        DK.toast(DK.pick('6-cı fincan PULSUZDUR!', 'Your 6th cup is FREE!',
          '6-я чашка БЕСПЛАТНО!', '6. fincan ÜCRETSİZ!'));
      }
    }

    function changeSize(btn, id, size) {
      const card = btn.closest('.coffee-card');
      card.querySelectorAll('.size-btn').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      coffeeSizes[id] = size;
      const coffee = coffeesData.find(function (c) { return c.id === id; });
      const priceEl = document.getElementById('price-' + id);
      if (coffee && coffee.prices[size] && priceEl) {
        priceEl.textContent = coffee.prices[size].toFixed(2) + ' ₼';
      }
    }

    function addCoffeeToBag(id, title) {
      const size = coffeeSizes[id] || 's';
      const coffee = coffeesData.find(function (c) { return c.id === id; });
      const price = coffee ? coffee.prices[size] : 5.00;
      bagApi.add({ id: id, title: title, price: price, meta: size.toUpperCase() }, 1);
      DK.toast(title + ' (' + size.toUpperCase() + ') — ' + DK.t.added);
    }

    function addPastryToBag(name, price) {
      bagApi.add({ id: 'p-' + name, title: name, price: price, meta: '' }, 1);
      DK.toast(name + ' — ' + DK.t.added);
    }

    function updateBagUI() {
      const count = bagApi.count();
      const subtotal = bagApi.total();
      const countEl = document.getElementById('bagCount');
      const subEl = document.getElementById('bagSubtotal');
      if (countEl) countEl.textContent = count;
      if (subEl) subEl.textContent = subtotal.toFixed(2) + ' ₼';

      const list = document.getElementById('bagItemsList');
      if (!bagApi.items.length) {
        list.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">☕</span>' +
          DK.esc('<?= e(addslashes($t['cart_empty'])) ?>') + '</div>';
        return;
      }
      list.innerHTML = bagApi.items.map(function (item) {
        return '<div class="cart-order-item">' +
          '<div><div style="font-size:14px;font-weight:700;color:#fff">' + DK.esc(item.title) +
          (item.meta ? ' · ' + DK.esc(item.meta) : '') + '</div>' +
          '<div style="font-size:12px;color:var(--neon-cyan)">' + item.qty + ' × ' +
          (item.price * item.qty).toFixed(2) + ' ₼</div></div>' +
          '<div class="dk-qty">' +
            '<button class="dk-qty__btn" onclick="bumpBag(\'' + DK.esc(item.id) + '\',\'' + DK.esc(item.meta) + '\',-1)">−</button>' +
            '<span class="dk-qty__val">' + item.qty + '</span>' +
            '<button class="dk-qty__btn" onclick="bumpBag(\'' + DK.esc(item.id) + '\',\'' + DK.esc(item.meta) + '\',1)">+</button>' +
          '</div>' +
        '</div>';
      }).join('');
    }

    function bumpBag(id, meta, dir) {
      const item = bagApi.items.find(function (i) {
        return String(i.id) === String(id) && (i.meta || '') === (meta || '');
      });
      if (!item) return;
      bagApi.setQty(id, meta, item.qty + dir);
    }

    function removeItem(key) { bagApi.remove(key, ''); }

    function showToast() { DK.toast(DK.t.added); }

    function checkoutCafeOrder() {
      if (!bagApi.items.length) return DK.toast(DK.t.emptyCart, 'err');
      const items = bagApi.items.slice();
      let discount = 0;
      if (freeCupReady) {
        items.push({ title: DK.pick('Pulsuz fincan (loyallıq)', 'Free cup (loyalty)', 'Бесплатная чашка (лояльность)', 'Ücretsiz fincan (sadakat)'), price: 0, qty: 1, meta: '' });
      }
      const mode = document.querySelector('.toggle-opt.active');
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: 'Velvet Brew',
        items: items,
        withTime: true,
        slots: ['09:00', '11:00', '13:00', '15:00', '17:00', '19:00'],
        summary: 'Format: ' + (mode ? mode.textContent.trim() : 'Pickup'),
        discountAmount: discount
      }).then(function (d) {
        if (!d) return;
        bagApi.clear();
        if (freeCupReady) {
          stamps = 0;
          DK.store(STAMP_KEY, 0);
          renderStamps();
        }
        closeBag();
      });
    }

    function setMode(btn, mode) {
      document.querySelectorAll('.toggle-opt').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    }

    /* Drawer */
    function openBag() {
      document.getElementById('bagOverlay').classList.add('active');
      document.getElementById('bagDrawer').classList.add('active');
    }
    function closeBag() {
      document.getElementById('bagOverlay').classList.remove('active');
      document.getElementById('bagDrawer').classList.remove('active');
    }
    document.getElementById('openBagBtn').addEventListener('click', openBag);
    document.getElementById('closeBagBtn').addEventListener('click', closeBag);
    document.getElementById('bagOverlay').addEventListener('click', closeBag);

    renderStamps();
    updateBagUI();
  </script>
</body>
</html>
