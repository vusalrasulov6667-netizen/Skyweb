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
        'brand_name' => 'Yaşıl Bazar',
        'brand_tagline' => 'Təbii & Təzə Qida Çatdırılması',
        'search_placeholder' => 'Məhsul, meyvə, süd məhsulları axtar...',
        'delivery_to' => 'Çatdırılma:',
        'city_baku' => 'Bakı şəhəri (25 dəqiqəyə)',
        'hero_title' => 'Tarladan Süfrənizə Ən Təzə Məhsullar',
        'hero_subtitle' => '100% orqanik meyvə, tərəvəz və gündəlik tələbat malları. Bakı daxilində 30 dəqiqəyə qapınızda!',
        'hero_cta' => 'İndi Sifariş Et',
        'promo_badge' => 'İlk sifarişə 20% ENDİRİM — KOD: YASIL20',
        'stat_products' => '3,500+ Məhsul',
        'stat_time' => '25 Dəqiqəyə Çatdırılma',
        'stat_rating' => '4.9/5 Müştəri Məmnuniyyəti',
        'cat_all' => 'Hamısı',
        'cat_fruits' => 'Meyvələr',
        'cat_veg' => 'Tərəvəzlər',
        'cat_dairy' => 'Süd Məhsulları',
        'cat_bakery' => 'Çörək & Şirniyyat',
        'cat_drinks' => 'İçkilər',
        'daily_deals' => 'Günün Təklifləri',
        'deals_subtitle' => 'Xüsusi endirimlər bitmədən tələsin!',
        'ends_in' => 'Bitmə vaxtı:',
        'add_to_cart' => 'Səbətə At',
        'loyalty_title' => 'YaşılClub Sadiqlik Kartı',
        'loyalty_sub' => 'Hər alış-verişdə 5% keşbek qazanın, xalları növbəti sifarişinizdə istifadə edin.',
        'loyalty_badge' => 'GOLD ÜZV',
        'loyalty_points' => 'Mövcud Xal: 1,420 ₼',
        'loyalty_btn' => 'Proqrama Qoşul',
        'delivery_title' => 'Çatdırılma Zonalarımız',
        'zone_1_title' => 'Mərkəz Bakı',
        'zone_1_desc' => 'Səbail, Nəsimi, Nərimanov — 20-30 dəq',
        'zone_1_price' => '30 ₼ yuxarı PULSUZ',
        'zone_2_title' => 'Geniş Bakı',
        'zone_2_desc' => 'Xətai, Binəqədi, Yasamal — 35-45 dəq',
        'zone_2_price' => '40 ₼ yuxarı PULSUZ',
        'zone_3_title' => 'Abşeron & Bağlar',
        'zone_3_desc' => 'Mərdəkan, Bilgəh, Xırdalan — 60 dəq',
        'zone_3_price' => 'Sabit 4 ₼ çatdırılma',
        'cart_title' => 'Səbətiniz',
        'cart_empty' => 'Səbətiniz hələ boşdur',
        'subtotal' => 'Cəmi:',
        'checkout_whatsapp' => 'WhatsApp ilə Sifariş Et',
        'added_toast' => 'Səbətə əlavə edildi!',
        'footer_desc' => 'Bu demo Skyweb tərəfindən onlayn marketlər və ərzaq çatdırılması biznesləri üçün yaradılmışdır.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'banner_text' => 'This is a demo website — Created by Skyweb',
        'back_to_sky' => 'Back to Skyweb',
        'brand_name' => 'GreenBazaar',
        'brand_tagline' => 'Fresh & Organic Grocery Delivery',
        'search_placeholder' => 'Search fruits, dairy, veggies...',
        'delivery_to' => 'Delivery to:',
        'city_baku' => 'Baku City (within 25 mins)',
        'hero_title' => 'Farm Fresh Groceries Delivered In Minutes',
        'hero_subtitle' => '100% organic fruits, vegetables and everyday essentials delivered right to your doorstep.',
        'hero_cta' => 'Shop Now',
        'promo_badge' => '20% OFF first order — CODE: GREEN20',
        'stat_products' => '3,500+ Products',
        'stat_time' => '25 Min Fast Delivery',
        'stat_rating' => '4.9/5 Customer Rating',
        'cat_all' => 'All Items',
        'cat_fruits' => 'Fruits',
        'cat_veg' => 'Vegetables',
        'cat_dairy' => 'Dairy & Milk',
        'cat_bakery' => 'Bakery & Sweets',
        'cat_drinks' => 'Beverages',
        'daily_deals' => 'Flash Deals of the Day',
        'deals_subtitle' => 'Grab limited-time discounts before they expire!',
        'ends_in' => 'Ends in:',
        'add_to_cart' => 'Add to Cart',
        'loyalty_title' => 'GreenClub Rewards Program',
        'loyalty_sub' => 'Earn 5% cashback on every purchase and redeem on future grocery orders.',
        'loyalty_badge' => 'GOLD MEMBER',
        'loyalty_points' => 'Available Points: $14.20',
        'loyalty_btn' => 'Join Rewards',
        'delivery_title' => 'Delivery Zones & Speeds',
        'zone_1_title' => 'Downtown Baku',
        'zone_1_desc' => 'Sabail, Nasimi, Narimanov — 20-30 mins',
        'zone_1_price' => 'FREE over 30 ₼',
        'zone_2_title' => 'Greater Baku',
        'zone_2_desc' => 'Khatai, Yasamal, Bineqedi — 35-45 mins',
        'zone_2_price' => 'FREE over 40 ₼',
        'zone_3_title' => 'Suburbs & Villas',
        'zone_3_desc' => 'Mardakan, Bilgah, Khirdalan — 60 mins',
        'zone_3_price' => 'Flat 4 ₼ delivery',
        'cart_title' => 'Your Basket',
        'cart_empty' => 'Your basket is empty',
        'subtotal' => 'Subtotal:',
        'checkout_whatsapp' => 'Order via WhatsApp',
        'added_toast' => 'Added to basket!',
        'footer_desc' => 'This demo was created by Skyweb to showcase premium e-commerce solutions for grocery & supermarkets.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'banner_text' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'brand_name' => 'Yeşil Market',
        'brand_tagline' => 'Taze & Doğal Market Siparişi',
        'search_placeholder' => 'Meyve, sebze, süt ürünü ara...',
        'delivery_to' => 'Teslimat:',
        'city_baku' => 'Bakü (25 dakikada kapıda)',
        'hero_title' => 'Çiftlikten Sofranıza En Taze Ürünler',
        'hero_subtitle' => '%100 organik meyve, sebze ve günlük ihtiyaçlar. 25-30 dakikada kapınızda!',
        'hero_cta' => 'Hemen Sipariş Ver',
        'promo_badge' => 'İlk siparişe %20 İNDİRİM — KOD: YESIL20',
        'stat_products' => '3,500+ Ürün Çeşidi',
        'stat_time' => '25 Dk Hızlı Teslimat',
        'stat_rating' => '4.9/5 Müşteri Puanı',
        'cat_all' => 'Tümü',
        'cat_fruits' => 'Meyveler',
        'cat_veg' => 'Sebzeler',
        'cat_dairy' => 'Süt & Kahvaltılık',
        'cat_bakery' => 'Fırın & Ekmek',
        'cat_drinks' => 'İçecekler',
        'daily_deals' => 'Günün İndirimleri',
        'deals_subtitle' => 'Fırsat ürünlerini tükenmeden yakalayın!',
        'ends_in' => 'Kalan Süre:',
        'add_to_cart' => 'Sepete Ekle',
        'loyalty_title' => 'YeşilClub Sadakat Kartı',
        'loyalty_sub' => 'Her siparişte %5 nakit iade kazanın, sonraki siparişinizde anında indirim alın.',
        'loyalty_badge' => 'GOLD ÜYE',
        'loyalty_points' => 'Biriken Puan: 14.20 ₼',
        'loyalty_btn' => 'Kulübe Katıl',
        'delivery_title' => 'Teslimat Bölgelerimiz',
        'zone_1_title' => 'Merkez Bakü',
        'zone_1_desc' => 'Sebail, Nesimi, Nerimanov — 20-30 dk',
        'zone_1_price' => '30 ₼ üzeri ÜCRETSİZ',
        'zone_2_title' => 'Geniş Bakü',
        'zone_2_desc' => 'Hatai, Yasamal, Binegedi — 35-45 dk',
        'zone_2_price' => '40 ₼ üzeri ÜCRETSİZ',
        'zone_3_title' => 'Banliyö & Bağlar',
        'zone_3_desc' => 'Merdekan, Bilgeh, Hırdalan — 60 dk',
        'zone_3_price' => 'Sabit 4 ₼ teslimat',
        'cart_title' => 'Sepetiniz',
        'cart_empty' => 'Sepetiniz henüz boş',
        'subtotal' => 'Toplam:',
        'checkout_whatsapp' => 'WhatsApp ile Sipariş Ver',
        'added_toast' => 'Sepete eklendi!',
        'footer_desc' => 'Bu demo, süpermarket ve bakkal işletmeleri için Skyweb tarafından özel tasarlanmıştır.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'banner_text' => 'Это демонстрационный сайт — Создан в Skyweb',
        'back_to_sky' => 'Назад в Skyweb',
        'brand_name' => 'Зеленый Базар',
        'brand_tagline' => 'Доставка свежих органических продуктов',
        'search_placeholder' => 'Поиск овощей, фруктов, молочки...',
        'delivery_to' => 'Доставка:',
        'city_baku' => 'Баку (за 25 минут)',
        'hero_title' => 'Свежие фермерские продукты у вашей двери',
        'hero_subtitle' => '100% органические фрукты, свежие овощи и продукты первой необходимости за полчаса.',
        'hero_cta' => 'Заказать сейчас',
        'promo_badge' => 'Скидка 20% на первый заказ — ПРОМОКОД: GREEN20',
        'stat_products' => '3,500+ Товаров',
        'stat_time' => 'Доставка за 25 мин',
        'stat_rating' => '4.9/5 Рейтинг сервиса',
        'cat_all' => 'Все товары',
        'cat_fruits' => 'Фрукты',
        'cat_veg' => 'Овощи',
        'cat_dairy' => 'Молочные продукты',
        'cat_bakery' => 'Выпечка и хлеб',
        'cat_drinks' => 'Напитки и соки',
        'daily_deals' => 'Скидки дня',
        'deals_subtitle' => 'Успейте купить по выгодным ценам до окончания акции!',
        'ends_in' => 'До конца акции:',
        'add_to_cart' => 'В корзину',
        'loyalty_title' => 'Карта лояльности GreenClub',
        'loyalty_sub' => 'Получайте 5% кэшбэка с каждой покупки и расплачивайтесь баллами.',
        'loyalty_badge' => 'GOLD КАРТА',
        'loyalty_points' => 'Доступно бонусов: 14.20 ₼',
        'loyalty_btn' => 'Вступить в клуб',
        'delivery_title' => 'Зоны быстрой доставки',
        'zone_1_title' => 'Центр Баку',
        'zone_1_desc' => 'Сабаил, Насими, Нариманов — 20-30 мин',
        'zone_1_price' => 'БЕСПЛАТНО от 30 ₼',
        'zone_2_title' => 'Большой Баку',
        'zone_2_desc' => 'Хатаи, Ясамал, Бинагади — 35-45 мин',
        'zone_2_price' => 'БЕСПЛАТНО от 40 ₼',
        'zone_3_title' => 'Пригород и Дачи',
        'zone_3_desc' => 'Мардакян, Бильгя, Хырдалан — 60 мин',
        'zone_3_price' => 'Фикс 4 ₼ доставка',
        'cart_title' => 'Ваша корзина',
        'cart_empty' => 'В корзине пока пусто',
        'subtotal' => 'Итого к оплате:',
        'checkout_whatsapp' => 'Заказ через WhatsApp',
        'added_toast' => 'Товар добавлен в корзину!',
        'footer_desc' => 'Демо-страница создана веб-студией Skyweb для супермаркетов и сервисов доставки еды.',
        'all_rights' => 'Все права защищены.',
    ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$products = [
    [
        'id' => 1,
        'cat' => 'fruits',
        'name' => [
            'az' => 'Quba Alması (Qırmızı)',
            'en' => 'Organic Red Apples',
            'tr' => 'Kırmızı Köy Elması',
            'ru' => 'Яблоки красные сладкие'
        ],
        'weight' => '1 kg',
        'price' => 2.40,
        'old_price' => 3.20,
        'badge' => '-25%',
        'img' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=400&q=80',
        'deal' => true,
    ],
    [
        'id' => 2,
        'cat' => 'fruits',
        'name' => [
            'az' => 'Kənd Çiyələyi',
            'en' => 'Fresh Strawberries',
            'tr' => 'Taze Tarla Çileği',
            'ru' => 'Клубника фермерская'
        ],
        'weight' => '500 g',
        'price' => 4.50,
        'old_price' => 5.80,
        'badge' => '-22%',
        'img' => 'https://images.unsplash.com/photo-1464965911861-746a04b4bca6?w=400&q=80',
        'deal' => true,
    ],
    [
        'id' => 3,
        'cat' => 'veg',
        'name' => [
            'az' => 'Zirə Pomidoru (Premium)',
            'en' => 'Zira Heirloom Tomatoes',
            'tr' => 'Zira Özel Köy Domatesi',
            'ru' => 'Томаты Зиринские'
        ],
        'weight' => '1 kg',
        'price' => 3.80,
        'old_price' => 4.90,
        'badge' => 'EKO',
        'img' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=400&q=80',
        'deal' => false,
    ],
    [
        'id' => 4,
        'cat' => 'veg',
        'name' => [
            'az' => 'Təzə Xiyar & Göyərti Dəsti',
            'en' => 'Crisp Cucumbers & Herbs',
            'tr' => 'Çıtır Salatalık & Yeşillik',
            'ru' => 'Огурцы хрустящие и зелень'
        ],
        'weight' => '800 g',
        'price' => 2.10,
        'old_price' => 2.80,
        'badge' => '-25%',
        'img' => 'https://images.unsplash.com/photo-1604977042946-1eecc30f269e?w=400&q=80',
        'deal' => true,
    ],
    [
        'id' => 5,
        'cat' => 'dairy',
        'name' => [
            'az' => 'İvanovka Kərə Yağı (82.5%)',
            'en' => 'Artisan Farm Butter',
            'tr' => 'Ivanovka Köy Tereyağı',
            'ru' => 'Масло сливочное Ивановка'
        ],
        'weight' => '400 g',
        'price' => 7.20,
        'old_price' => 8.90,
        'badge' => 'Premium',
        'img' => 'https://images.unsplash.com/photo-1589985270826-4b7bb135bc9d?w=400&q=80',
        'deal' => false,
    ],
    [
        'id' => 6,
        'cat' => 'dairy',
        'name' => [
            'az' => 'Təbii Kənd Pendiri (Motol)',
            'en' => 'Aged Artisan Cheese',
            'tr' => 'Doğal Köy Peyniri',
            'ru' => 'Сыр домашний деревенский'
        ],
        'weight' => '500 g',
        'price' => 5.60,
        'old_price' => 6.90,
        'badge' => '-18%',
        'img' => 'https://images.unsplash.com/photo-1552767059-ce182ead6c1b?w=400&q=80',
        'deal' => true,
    ],
    [
        'id' => 7,
        'cat' => 'bakery',
        'name' => [
            'az' => 'Təbii Maya ilə Qara Çörək',
            'en' => 'Artisan Sourdough Rye',
            'tr' => 'Ekşi Mayalı Köy Ekmeği',
            'ru' => 'Ржаной хлеб на закваске'
        ],
        'weight' => '650 g',
        'price' => 1.80,
        'old_price' => 2.30,
        'badge' => 'Təzə',
        'img' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&q=80',
        'deal' => false,
    ],
    [
        'id' => 8,
        'cat' => 'drinks',
        'name' => [
            'az' => 'Təbii Nar Şirəsi (Soyuq Sıxım)',
            'en' => 'Cold-Pressed Pomegranate Juice',
            'tr' => 'Soğuk Sıkım Doğal Nar Suyu',
            'ru' => 'Гранатовый сок прямого отжима'
        ],
        'weight' => '1 Liter',
        'price' => 4.90,
        'old_price' => 6.50,
        'badge' => '-24%',
        'img' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=400&q=80',
        'deal' => true,
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($t['brand_name']) ?> — <?= e($t['brand_tagline']) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: #002626;
      --sky-card-hover: #003838;
      --neon-cyan: #00FFFF;
      --neon-glow: rgba(0, 255, 255, 0.35);
      --emerald: #10b981;
      --emerald-glow: rgba(16, 185, 129, 0.35);
      --amber: #f59e0b;
      --text-main: #f0fdfa;
      --text-muted: #94a3b8;
      --border-glass: rgba(0, 255, 255, 0.15);
      --font-heading: 'Outfit', sans-serif;
      --font-body: 'Plus Jakarta Sans', sans-serif;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background-color: var(--sky-bg);
      background-image: 
        radial-gradient(circle at 15% 20%, rgba(0, 255, 255, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 85% 75%, rgba(16, 185, 129, 0.08) 0%, transparent 45%);
      color: var(--text-main);
      font-family: var(--font-body);
      line-height: 1.6;
      min-height: 100vh;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; }

    /* Top Skyweb Demo Bar */
    .sky-demo-bar {
      background: linear-gradient(90deg, #001212 0%, #002b2b 50%, #001212 100%);
      border-bottom: 1px solid var(--border-glass);
      padding: 8px 16px;
      font-size: 13px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
      backdrop-filter: blur(8px);
    }
    .demo-badge-wrap { display: flex; align-items: center; gap: 8px; }
    .demo-pill {
      background: rgba(0, 255, 255, 0.15);
      color: var(--neon-cyan);
      border: 1px solid var(--neon-cyan);
      padding: 2px 8px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 11px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .demo-back-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--neon-cyan);
      font-weight: 600;
      transition: all 0.2s;
    }
    .demo-back-btn:hover { text-shadow: 0 0 10px var(--neon-cyan); transform: translateX(-2px); }

    /* Navbar */
    .navbar {
      max-width: 1240px;
      margin: 0 auto;
      padding: 16px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 20px;
    }
    .brand-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: var(--font-heading);
      font-weight: 800;
      font-size: 24px;
      color: #fff;
    }
    .brand-logo svg { color: var(--neon-cyan); filter: drop-shadow(0 0 8px var(--neon-cyan)); }
    .nav-search {
      flex: 1;
      max-width: 500px;
      position: relative;
    }
    .nav-search input {
      width: 100%;
      background: rgba(0, 38, 38, 0.7);
      border: 1px solid var(--border-glass);
      padding: 12px 18px 12px 42px;
      border-radius: 999px;
      color: #fff;
      font-size: 14px;
      outline: none;
      transition: all 0.3s;
    }
    .nav-search input:focus {
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
    }
    .nav-search svg {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--neon-cyan);
    }
    .nav-actions { display: flex; align-items: center; gap: 14px; }
    .cart-btn-nav {
      background: linear-gradient(135deg, rgba(0, 255, 255, 0.15), rgba(16, 185, 129, 0.2));
      border: 1px solid var(--neon-cyan);
      color: #fff;
      padding: 10px 18px;
      border-radius: 999px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
      position: relative;
    }
    .cart-btn-nav:hover {
      background: var(--neon-cyan);
      color: #000;
      box-shadow: 0 0 20px var(--neon-glow);
    }
    .cart-count {
      background: var(--amber);
      color: #000;
      font-size: 12px;
      font-weight: 800;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Container */
    .container { max-width: 1240px; margin: 0 auto; padding: 0 20px; }

    /* Hero */
    .hero {
      margin: 20px auto 40px;
      background: linear-gradient(135deg, rgba(0, 40, 40, 0.8) 0%, rgba(0, 20, 20, 0.9) 100%);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 48px;
      position: relative;
      overflow: hidden;
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 30px;
      align-items: center;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .hero::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(0, 255, 255, 0.2), transparent 70%);
      pointer-events: none;
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid var(--emerald);
      color: #34d399;
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 13px;
      font-weight: 700;
      margin-bottom: 20px;
    }
    .hero h1 {
      font-family: var(--font-heading);
      font-size: clamp(32px, 4.5vw, 48px);
      line-height: 1.15;
      font-weight: 800;
      margin-bottom: 16px;
    }
    .hero h1 span {
      background: linear-gradient(90deg, #fff 0%, var(--neon-cyan) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero p { color: var(--text-muted); font-size: 16px; max-width: 520px; margin-bottom: 28px; }
    .hero-cta {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, var(--neon-cyan), #00e5ff);
      color: #000;
      font-weight: 800;
      font-size: 15px;
      padding: 14px 32px;
      border-radius: 999px;
      box-shadow: 0 0 25px rgba(0, 255, 255, 0.4);
      transition: all 0.3s;
    }
    .hero-cta:hover { transform: translateY(-3px); box-shadow: 0 0 35px rgba(0, 255, 255, 0.7); }
    .hero-stats {
      display: flex;
      gap: 20px;
      margin-top: 32px;
      padding-top: 24px;
      border-top: 1px solid var(--border-glass);
    }
    .hero-stat-item { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; }
    .hero-stat-item strong { color: #fff; }
    .hero-img-wrap {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid var(--border-glass);
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }
    .hero-img-wrap img { width: 100%; height: 320px; object-fit: cover; display: block; }
    .hero-float-tag {
      position: absolute;
      bottom: 16px;
      left: 16px;
      right: 16px;
      background: rgba(0, 20, 20, 0.85);
      backdrop-filter: blur(8px);
      padding: 12px 18px;
      border-radius: 14px;
      border: 1px solid var(--border-glass);
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 13px;
      font-weight: 600;
    }

    /* Category Filter */
    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-bottom: 24px;
    }
    .section-title {
      font-family: var(--font-heading);
      font-size: 26px;
      font-weight: 700;
      color: #fff;
    }
    .section-sub { color: var(--text-muted); font-size: 14px; margin-top: 4px; }
    .cat-bar {
      display: flex;
      gap: 10px;
      overflow-x: auto;
      padding-bottom: 10px;
      margin-bottom: 30px;
      scrollbar-width: thin;
    }
    .cat-pill {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      color: var(--text-muted);
      padding: 10px 20px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 14px;
      white-space: nowrap;
      transition: all 0.2s;
    }
    .cat-pill:hover, .cat-pill.active {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px var(--neon-glow);
    }

    /* Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 24px;
      margin-bottom: 50px;
    }
    .product-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 18px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s;
      position: relative;
    }
    .product-card:hover {
      transform: translateY(-6px);
      border-color: var(--neon-cyan);
      box-shadow: 0 12px 30px rgba(0, 255, 255, 0.15);
    }
    .card-img-wrap {
      position: relative;
      height: 190px;
      overflow: hidden;
      background: #001f1f;
    }
    .card-img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }
    .product-card:hover .card-img-wrap img { transform: scale(1.08); }
    .card-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: var(--amber);
      color: #000;
      font-weight: 800;
      font-size: 12px;
      padding: 4px 10px;
      border-radius: 999px;
    }
    .card-body {
      padding: 18px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .card-weight { font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }
    .card-title {
      font-size: 16px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 12px;
      line-height: 1.3;
      flex: 1;
    }
    .card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: auto;
      padding-top: 14px;
      border-top: 1px solid rgba(255,255,255,0.06);
    }
    .price-wrap { display: flex; flex-direction: column; }
    .curr-price { font-size: 19px; font-weight: 800; color: var(--neon-cyan); }
    .old-price { font-size: 13px; color: var(--text-muted); text-decoration: line-through; }
    .btn-add {
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .btn-add:hover {
      background: var(--neon-cyan);
      color: #000;
      box-shadow: 0 0 15px var(--neon-glow);
    }

    /* Loyalty & Delivery Sections */
    .extra-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      margin-bottom: 60px;
    }
    .loyalty-box {
      background: linear-gradient(135deg, #002e2e 0%, #001a1a 100%);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 32px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }
    .loyalty-box::before {
      content: '★ VIP';
      position: absolute;
      right: -20px;
      bottom: -15px;
      font-size: 80px;
      font-weight: 900;
      color: rgba(0, 255, 255, 0.04);
      pointer-events: none;
    }
    .loyalty-header { display: flex; justify-content: space-between; align-items: flex-start; }
    .loyalty-badge {
      background: linear-gradient(90deg, #f59e0b, #fbbf24);
      color: #000;
      font-weight: 800;
      font-size: 12px;
      padding: 4px 12px;
      border-radius: 999px;
    }
    .loyalty-btn {
      margin-top: 24px;
      align-self: flex-start;
      background: var(--neon-cyan);
      color: #000;
      font-weight: 700;
      padding: 10px 22px;
      border-radius: 999px;
      box-shadow: 0 0 15px var(--neon-glow);
      transition: all 0.2s;
    }
    .loyalty-btn:hover { transform: translateY(-2px); }

    .delivery-box {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 32px;
    }
    .zone-list { display: flex; flex-direction: column; gap: 14px; margin-top: 16px; }
    .zone-item {
      background: rgba(0, 18, 18, 0.6);
      border: 1px solid rgba(0, 255, 255, 0.1);
      border-radius: 12px;
      padding: 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .zone-info h4 { font-size: 14px; color: #fff; margin-bottom: 2px; }
    .zone-info p { font-size: 12px; color: var(--text-muted); }
    .zone-price { font-size: 12px; font-weight: 700; color: var(--emerald); }

    /* Floating WhatsApp Button */
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

    /* Cart Drawer */
    .cart-drawer-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.7);
      backdrop-filter: blur(5px);
      z-index: 2000;
      display: none;
    }
    .cart-drawer-overlay.active { display: block; }
    .cart-drawer {
      position: fixed;
      top: 0; right: -420px; bottom: 0;
      width: 100%;
      max-width: 400px;
      background: #001f1f;
      border-left: 1px solid var(--border-glass);
      z-index: 2001;
      display: flex;
      flex-direction: column;
      transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .cart-drawer.active { right: 0; }
    .cart-drawer-header {
      padding: 20px;
      border-bottom: 1px solid var(--border-glass);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-close-btn { background: none; color: #fff; font-size: 24px; }
    .cart-items-body { flex: 1; overflow-y: auto; padding: 20px; }
    .cart-item {
      display: flex;
      gap: 12px;
      align-items: center;
      padding: 12px 0;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }
    .cart-item-img { width: 55px; height: 55px; border-radius: 8px; object-fit: cover; }
    .cart-item-info { flex: 1; }
    .cart-item-title { font-size: 14px; font-weight: 600; color: #fff; }
    .cart-item-price { font-size: 13px; color: var(--neon-cyan); font-weight: 700; }
    .cart-qty-ctrl { display: flex; align-items: center; gap: 8px; }
    .cart-qty-btn {
      width: 26px; height: 26px;
      border-radius: 6px;
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      color: #fff;
      display: flex; align-items: center; justify-content: center;
    }
    .cart-drawer-footer {
      padding: 20px;
      border-top: 1px solid var(--border-glass);
      background: #001717;
    }
    .subtotal-row { display: flex; justify-content: space-between; font-weight: 700; margin-bottom: 16px; font-size: 16px; }
    .checkout-btn {
      width: 100%;
      background: #25d366;
      color: #fff;
      font-weight: 800;
      padding: 14px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
      transition: all 0.2s;
    }
    .checkout-btn:hover { background: #20bd5a; transform: translateY(-2px); }

    /* Toast */
    .toast-notify {
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
    .toast-notify.show { transform: translateX(-50%) translateY(0); }

    /* Footer */
    footer {
      background: #001111;
      border-top: 1px solid var(--border-glass);
      padding: 40px 20px 24px;
      margin-top: 60px;
      text-align: center;
    }
    footer p { color: var(--text-muted); font-size: 13px; margin-bottom: 8px; }
    .footer-sky-tag { color: var(--neon-cyan); font-weight: 700; }

    @media (max-width: 860px) {
      .hero { grid-template-columns: 1fr; padding: 28px 20px; }
      .hero-img-wrap { display: none; }
      .extra-grid { grid-template-columns: 1fr; }
      .nav-search { display: none; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="grocery" data-dk-accent="#10b981" data-dk-phone="994503936998" data-dk-sticky data-dk-action="sendWhatsAppOrder" data-dk-sticky-label="Sifariş">
  <script src="assets/demo-kit.js"></script>


  <!-- Top Demo Banner -->
  <div class="sky-demo-bar">
    <div class="demo-badge-wrap">
      <span class="demo-pill">DEMO</span>
      <span><?= e($t['banner_text']) ?></span>
    </div>
    <div style="display: flex; align-items: center; gap: 16px;">
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-back-btn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
        <?= e($t['back_to_sky']) ?>
      </a>
    </div>
  </div>

  <!-- Navbar -->
  <header class="navbar">
    <a href="#" class="brand-logo">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
      </svg>
      <?= e($t['brand_name']) ?>
    </a>

    <div class="nav-search">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" placeholder="<?= e($t['search_placeholder']) ?>">
    </div>

    <div class="nav-actions">
      <button class="cart-btn-nav" id="openCartBtn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        <span class="cart-count" id="cartCount">0</span>
      </button>
    </div>
  </header>

  <main class="container">
    <!-- Hero Section -->
    <section class="hero">
      <div>
        <div class="hero-badge">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          <?= e($t['promo_badge']) ?>
        </div>
        <h1><?= e($t['hero_title']) ?></h1>
        <p><?= e($t['hero_subtitle']) ?></p>
        <a href="#productsSection" class="hero-cta">
          <?= e($t['hero_cta']) ?>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <div class="hero-stats">
          <div class="hero-stat-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span><strong><?= e($t['stat_products']) ?></strong></span>
          </div>
          <div class="hero-stat-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span><strong><?= e($t['stat_time']) ?></strong></span>
          </div>
          <div class="hero-stat-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <span><strong><?= e($t['stat_rating']) ?></strong></span>
          </div>
        </div>
      </div>

      <div class="hero-img-wrap">
        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80" alt="Fresh Groceries">
        <div class="hero-float-tag">
          <span><?= e($t['delivery_to']) ?> <strong style="color:var(--neon-cyan);"><?= e($t['city_baku']) ?></strong></span>
          <span style="color:var(--emerald);">● Online</span>
        </div>
      </div>
    </section>

    <!-- Categories & Products Section -->
    <section id="productsSection">
      <div class="section-header">
        <div>
          <h2 class="section-title"><?= e($t['daily_deals']) ?></h2>
          <p class="section-sub"><?= e($t['deals_subtitle']) ?> <span style="color:var(--amber); font-weight:700;" id="dealTimer">03:45:12</span></p>
        </div>
      </div>

      <!-- Categories Filter Tabs -->
      <div class="cat-bar">
        <button class="cat-pill active" data-filter="all"><?= e($t['cat_all']) ?></button>
        <button class="cat-pill" data-filter="fruits"><?= e($t['cat_fruits']) ?></button>
        <button class="cat-pill" data-filter="veg"><?= e($t['cat_veg']) ?></button>
        <button class="cat-pill" data-filter="dairy"><?= e($t['cat_dairy']) ?></button>
        <button class="cat-pill" data-filter="bakery"><?= e($t['cat_bakery']) ?></button>
        <button class="cat-pill" data-filter="drinks"><?= e($t['cat_drinks']) ?></button>
      </div>

      <!-- Product Cards Grid -->
      <div class="product-grid" id="productGrid">
        <?php foreach ($products as $p): ?>
          <?php $pname = $p['name'][$lang] ?? $p['name']['az']; ?>
          <div class="product-card" data-cat="<?= e($p['cat']) ?>" data-id="<?= e($p['id']) ?>">
            <div class="card-img-wrap">
              <img src="<?= e($p['img']) ?>" alt="<?= e($pname) ?>" loading="lazy">
              <span class="card-badge"><?= e($p['badge']) ?></span>
            </div>
            <div class="card-body">
              <span class="card-weight"><?= e($p['weight']) ?></span>
              <h3 class="card-title"><?= e($pname) ?></h3>
              <div class="card-footer">
                <div class="price-wrap">
                  <span class="curr-price"><?= number_format($p['price'], 2) ?> ₼</span>
                  <span class="old-price"><?= number_format($p['old_price'], 2) ?> ₼</span>
                </div>
                <button class="btn-add" onclick="addToCart(<?= $p['id'] ?>, '<?= e(addslashes($pname)) ?>', <?= $p['price'] ?>, '<?= e($p['img']) ?>')">
                  <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                  <?= e($t['add_to_cart']) ?>
                </button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Loyalty & Delivery Zones -->
    <section class="extra-grid">
      <!-- Loyalty Box -->
      <div class="loyalty-box">
        <div class="loyalty-header">
          <div>
            <span class="loyalty-badge"><?= e($t['loyalty_badge']) ?></span>
            <h3 style="font-family:var(--font-heading); font-size:22px; margin-top:12px;"><?= e($t['loyalty_title']) ?></h3>
            <p style="color:var(--text-muted); font-size:14px; margin-top:6px; max-width:380px;"><?= e($t['loyalty_sub']) ?></p>
          </div>
        </div>
        <div style="margin-top:20px;">
          <div style="font-size:18px; font-weight:800; color:var(--neon-cyan);"><?= e($t['loyalty_points']) ?></div>
          <button class="loyalty-btn" onclick="alert('GreenClub ID: #SK-88219 (Aktiv)')"><?= e($t['loyalty_btn']) ?></button>
        </div>
      </div>

      <!-- Delivery Zones -->
      <div class="delivery-box">
        <h3 style="font-family:var(--font-heading); font-size:20px;"><?= e($t['delivery_title']) ?></h3>
        <div class="zone-list">
          <div class="zone-item">
            <div class="zone-info">
              <h4><?= e($t['zone_1_title']) ?></h4>
              <p><?= e($t['zone_1_desc']) ?></p>
            </div>
            <span class="zone-price"><?= e($t['zone_1_price']) ?></span>
          </div>
          <div class="zone-item">
            <div class="zone-info">
              <h4><?= e($t['zone_2_title']) ?></h4>
              <p><?= e($t['zone_2_desc']) ?></p>
            </div>
            <span class="zone-price"><?= e($t['zone_2_price']) ?></span>
          </div>
          <div class="zone-item">
            <div class="zone-info">
              <h4><?= e($t['zone_3_title']) ?></h4>
              <p><?= e($t['zone_3_desc']) ?></p>
            </div>
            <span class="zone-price"><?= e($t['zone_3_price']) ?></span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Floating WhatsApp Action -->
  <a href="https://wa.me/994503936998?text=Salam,%20GreenBazaar%20sifarişi%20vermək%20istəyirəm" target="_blank" class="float-wa" title="WhatsApp Sifariş">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/>
    </svg>
  </a>

  <!-- Cart Drawer -->
  <div class="cart-drawer-overlay" id="cartOverlay"></div>
  <aside class="cart-drawer" id="cartDrawer">
    <div class="cart-drawer-header">
      <h3 style="font-family:var(--font-heading); font-size:18px;"><?= e($t['cart_title']) ?></h3>
      <button class="cart-close-btn" id="closeCartBtn">&times;</button>
    </div>
    <div class="cart-items-body" id="cartItemsList">
      <p style="text-align:center; color:var(--text-muted); margin-top:40px;"><?= e($t['cart_empty']) ?></p>
    </div>
    <div class="cart-drawer-footer">
      <div class="dk-field" style="margin-bottom:10px;">
        <label class="dk-label" for="grocerySlot"><?= e($t['checkout_whatsapp']) ?> · <?= e($t['subtotal']) ?></label>
        <select class="dk-select" id="grocerySlot" onchange="updateCartUI()">
          <option value="0">Bu gün 18:00 – 20:00</option>
          <option value="1">Sabah 09:00 – 12:00</option>
          <option value="2">Sabah 18:00 – 21:00</option>
        </select>
      </div>
      <div class="dk-ship" id="groceryShipNote" style="margin-bottom:8px;"></div>
      <div class="subtotal-row">
        <span><?= e($t['subtotal']) ?></span>
        <span style="color:var(--neon-cyan);" id="cartSubtotal">0.00 ₼</span>
      </div>
      <button class="checkout-btn" onclick="sendWhatsAppOrder()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2Z"/>
        </svg>
        <?= e($t['checkout_whatsapp']) ?>
      </button>
    </div>
  </aside>

  <!-- Toast Notification -->
  <div class="toast-notify" id="toastNotify"><?= e($t['added_toast']) ?></div>

  <!-- Footer -->
  <footer>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Powered by <span class="footer-sky-tag">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    /* ── GreenBazaar · səbət + çatdırılma slotu + flash deal ── */
    const MIN_ORDER = 20;
    const FREE_FROM = 40;

    const cartApi = DK.cart('grocery-cart', function () { updateCartUI(); });
    // keep a live reference for legacy helpers
    Object.defineProperty(window, 'cart', {
      get: function () { return cartApi.items; },
      set: function (v) { cartApi.items = v; cartApi.bump(); }
    });

    function addToCart(id, name, price, img) {
      cartApi.add({ id: id, title: name, price: price, img: img }, 1);
      DK.toast(name + ' — ' + DK.t.added);
    }

    function changeQty(id, delta) {
      const item = cartApi.items.find(function (i) { return String(i.id) === String(id); });
      if (!item) return;
      cartApi.setQty(id, item.meta || '', item.qty + delta);
    }

    function updateCartUI() {
      const totalCount = cartApi.count();
      const subtotal = cartApi.total();
      const countEl = document.getElementById('cartCount');
      const subEl = document.getElementById('cartSubtotal');
      if (countEl) countEl.textContent = totalCount;
      if (subEl) subEl.textContent = subtotal.toFixed(2) + ' ₼';

      const list = document.getElementById('cartItemsList');
      if (!cartApi.items.length) {
        list.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">🧺</span>' +
          DK.esc('<?= e(addslashes($t['cart_empty'])) ?>') + '</div>';
      } else {
        list.innerHTML = cartApi.items.map(function (item) {
          return '<div class="cart-item">' +
            (item.img ? '<img src="' + DK.esc(item.img) + '" class="cart-item-img" alt="">' : '') +
            '<div class="cart-item-info">' +
              '<div class="cart-item-title">' + DK.esc(item.title) + '</div>' +
              '<div class="cart-item-price">' + (item.price * item.qty).toFixed(2) + ' ₼</div>' +
            '</div>' +
            '<div class="cart-qty-ctrl">' +
              '<button class="cart-qty-btn" onclick="changeQty(' + item.id + ', -1)">−</button>' +
              '<span style="font-weight:700;font-size:14px;min-width:18px;text-align:center">' + item.qty + '</span>' +
              '<button class="cart-qty-btn" onclick="changeQty(' + item.id + ', 1)">+</button>' +
            '</div>' +
          '</div>';
        }).join('');
      }

      const note = document.getElementById('groceryShipNote');
      if (note) {
        const left = FREE_FROM - subtotal;
        note.innerHTML = left > 0
          ? '<b>' + left.toFixed(2) + ' ₼</b> ' + DK.esc(DK.t.freeShip) +
            '<div class="dk-track"><i style="width:' + Math.min(100, (subtotal / FREE_FROM) * 100) + '%"></i></div>'
          : DK.esc(DK.t.freeShipDone);
      }
    }

    function showToast() { DK.toast(DK.t.added); }

    function sendWhatsAppOrder() {
      if (!cartApi.items.length) return DK.toast(DK.t.emptyCart, 'err');
      const subtotal = cartApi.total();
      if (subtotal < MIN_ORDER) {
        return DK.toast(DK.pick('Minimum sifariş ' + MIN_ORDER + ' ₼', 'Minimum order ' + MIN_ORDER + ' AZN',
          'Минимальный заказ ' + MIN_ORDER + ' AZN', 'Minimum sipariş ' + MIN_ORDER + ' AZN'), 'err');
      }
      const slotSel = document.getElementById('grocerySlot');
      const slot = slotSel ? slotSel.options[slotSel.selectedIndex].text : '';
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: 'GreenBazaar',
        items: cartApi.items,
        addressRequired: true,
        summary: 'Çatdırılma vaxtı: ' + slot
      }).then(function (d) {
        if (!d) return;
        cartApi.clear();
        closeDrawer();
      });
    }

    /* Category filter */
    document.querySelectorAll('.cat-pill').forEach(function (btn) {
      btn.addEventListener('click', function () {
        document.querySelectorAll('.cat-pill').forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        document.querySelectorAll('.product-card').forEach(function (card) {
          card.style.display = (filter === 'all' || card.dataset.cat === filter) ? 'flex' : 'none';
        });
      });
    });

    /* Drawer */
    function openDrawer() {
      document.getElementById('cartOverlay').classList.add('active');
      document.getElementById('cartDrawer').classList.add('active');
    }
    function closeDrawer() {
      document.getElementById('cartOverlay').classList.remove('active');
      document.getElementById('cartDrawer').classList.remove('active');
    }
    document.getElementById('openCartBtn').addEventListener('click', openDrawer);
    document.getElementById('closeCartBtn').addEventListener('click', closeDrawer);
    document.getElementById('cartOverlay').addEventListener('click', closeDrawer);

    /* Flash-deal countdown, persisted across reloads */
    (function () {
      const KEY = 'dk.grocery.dealEnd';
      let end = Number(localStorage.getItem(KEY) || 0);
      if (!end || end < Date.now()) {
        end = Date.now() + (3 * 3600 + 45 * 60 + 12) * 1000;
        try { localStorage.setItem(KEY, String(end)); } catch (e) {}
      }
      const node = document.getElementById('dealTimer');
      function tick() {
        if (!node) return;
        const left = Math.max(0, Math.floor((end - Date.now()) / 1000));
        const h = String(Math.floor(left / 3600)).padStart(2, '0');
        const m = String(Math.floor((left % 3600) / 60)).padStart(2, '0');
        const s = String(left % 60).padStart(2, '0');
        node.textContent = h + ':' + m + ':' + s;
      }
      tick();
      setInterval(tick, 1000);
    })();

    updateCartUI();
  </script>
</body>
</html>
