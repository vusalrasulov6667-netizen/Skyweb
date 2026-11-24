<?php require_once __DIR__ . '/../../config/lang.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });

if (!function_exists('e')) {
    function e(string $str): string {
        return htmlspecialchars($str, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
} ?>
<?php
$demo_texts = [
  'az' => [
    'demo_banner' => 'Bu nümunə saytdır — Skyweb tərəfindən hazırlanmışdır',
    'back_to_sky' => 'Skyweb-ə Qayıt',
    'order_site' => 'Bu Saytı Sifariş Et',
    'brand_name' => 'AURA MODA',
    'brand_sub' => 'Premium Dəb & Stil',
    'nav_home' => 'Ana Səhifə',
    'nav_catalog' => 'Kolleksiya',
    'hero_tag' => 'YENİ YAZ-YAY 2026',
    'hero_title_1' => 'Gələcəyin Zərifliyi,',
    'hero_title_2' => 'Sənin Stilində.',
    'hero_desc' => 'Eleqant dizayn, yüksək keyfiyyətli parçalar və cəsur kəsimlər. İndi sifariş edin, xüsusi 25% endirim və Bakı daxili pulsuz çatdırılmadan yararlanın.',
    'hero_cta' => 'Kolleksiyaya Bax',
    'hero_discount' => 'Kod: AURA25 (-25%)',
    'ticker' => '✨ BAKI DAXİLİ 2 SAATA ÇATDIRILMA • 💳 BİRKART İLƏ 6 AY FAİZSİZ • 🔄 14 GÜN ƏRZİNDƏ QAYTARMA • 👗 DƏRZİ XİDMƏTİ',
    'filter_all' => 'Hamısı',
    'filter_dresses' => 'Donlar',
    'filter_outer' => 'Paltolar',
    'filter_shoes' => 'Ayaqqabılar',
    'filter_acc' => 'Aksesuarlar',
    'add_to_cart' => 'Səbətə At',
    'order_whatsapp' => 'WhatsApp ilə Al',
    'select_size' => 'Ölçü:',
    'cart_title' => 'Sizin Səbətiniz',
    'cart_empty' => 'Səbətiniz hazırda boşdur',
    'cart_total' => 'Cəmi Məbləğ:',
    'cart_checkout' => 'WhatsApp ilə Sifariş Et',
    'feat_1' => '🚀 2 Saata Çatdırılma (Bakı)',
    'feat_2' => '💎 100% Orijinal İtalyan Parçalar',
    'feat_3' => '🛡️ Qapıda Nağd və ya POS Ödəniş',
    'feat_4' => '💬 24/7 Şəxsi Stilist Dəstəyi',
    'footer_desc' => 'Aura Moda — müasir və təkrarolunmaz dəb dünyası. Skyweb.az tərəfindən bizneslər üçün hazırlanmış tam funksional onlayn mağaza nümunəsi.',
  ],
  'en' => [
    'demo_banner' => 'This is a demo website — Created by Skyweb',
    'back_to_sky' => 'Back to Skyweb',
    'order_site' => 'Order This Website',
    'brand_name' => 'AURA FASHION',
    'brand_sub' => 'Premium Style & Couture',
    'nav_home' => 'Home',
    'nav_catalog' => 'Collection',
    'hero_tag' => 'NEW SPRING-SUMMER 2026',
    'hero_title_1' => 'Futuristic Elegance,',
    'hero_title_2' => 'Tailored For You.',
    'hero_desc' => 'Bespoke tailoring, ultra-luxurious fabrics, and bold contemporary silhouettes. Order today and enjoy 25% off with free Baku express delivery.',
    'hero_cta' => 'Explore Collection',
    'hero_discount' => 'Code: AURA25 (-25%)',
    'ticker' => '✨ 2-HOUR EXPRESS COURIER IN BAKU • 💳 0% INSTALLMENT PLANS • 🔄 14-DAY HASSLE-FREE RETURNS • 👗 CUSTOM FITTING',
    'filter_all' => 'All Products',
    'filter_dresses' => 'Dresses',
    'filter_outer' => 'Coats & Jackets',
    'filter_shoes' => 'Footwear',
    'filter_acc' => 'Accessories',
    'add_to_cart' => 'Add to Cart',
    'order_whatsapp' => 'Buy via WhatsApp',
    'select_size' => 'Size:',
    'cart_title' => 'Your Shopping Bag',
    'cart_empty' => 'Your bag is currently empty',
    'cart_total' => 'Total Amount:',
    'cart_checkout' => 'Complete Order via WhatsApp',
    'feat_1' => '🚀 2-Hour Express Delivery (Baku)',
    'feat_2' => '💎 100% Italian Fabrics',
    'feat_3' => '🛡️ Cash / POS on Delivery',
    'feat_4' => '💬 24/7 Personal VIP Stylist',
    'footer_desc' => 'Aura Fashion — where trend meets timeless elegance. A high-converting boutique website demo engineered by Skyweb.az.',
  ],
  'tr' => [
    'demo_banner' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
    'back_to_sky' => 'Skyweb\'e Dön',
    'order_site' => 'Bu Siteyi Sipariş Et',
    'brand_name' => 'AURA BUTİK',
    'brand_sub' => 'Özel Tasarım & Moda',
    'nav_home' => 'Ana Sayfa',
    'nav_catalog' => 'Koleksiyon',
    'hero_tag' => 'YENİ İLKBAHAR-YAZ 2026',
    'hero_title_1' => 'Geleceğin Zarafeti,',
    'hero_title_2' => 'Sizin Tarzınız.',
    'hero_desc' => 'Lüks kumaşlar, zarif dikişler ve modern çizgiler. Hemen sipariş verin, %25 özel indirim ve aynı gün hızlı kargo fırsatını kaçırmayın.',
    'hero_cta' => 'Koleksiyonu Keşfet',
    'hero_discount' => 'Kupon: AURA25 (%25)',
    'ticker' => '✨ AYNI GÜN JET TESLİMAT • 💳 TÜM KARTLARA VADE FARKSIZ TAKSİT • 🔄 14 GÜN KOŞULSUZ İADE • 👗 KİŞİYE ÖZEL TERZİ',
    'filter_all' => 'Tümü',
    'filter_dresses' => 'Elbiseler',
    'filter_outer' => 'Kabanlar',
    'filter_shoes' => 'Ayakkabılar',
    'filter_acc' => 'Aksesuarlar',
    'add_to_cart' => 'Sepete Ekle',
    'order_whatsapp' => 'WhatsApp ile Al',
    'select_size' => 'Beden:',
    'cart_title' => 'Alışveriş Sepetiniz',
    'cart_empty' => 'Sepetiniz şu anda boş',
    'cart_total' => 'Toplam Tutar:',
    'cart_checkout' => 'WhatsApp ile Siparişi Tamamla',
    'feat_1' => '🚀 2 Saatte Hızlı Teslimat',
    'feat_2' => '💎 %100 Orijinal İtalyan Kumaşlar',
    'feat_3' => '🛡️ Kapıda Nakit ya da Kartla Ödeme',
    'feat_4' => '💬 7/24 Stil Danışmanı Desteği',
    'footer_desc' => 'Aura Butik — özgün ve modern moda anlayışı. Skyweb.az tarafından e-ticaret işletmeleri için hazırlanmış şık demo.',
  ],
  'ru' => [
    'demo_banner' => 'Это демонстрационный сайт — Создано Skyweb',
    'back_to_sky' => 'Вернуться в Skyweb',
    'order_site' => 'Заказать такой сайт',
    'brand_name' => 'AURA FASHION',
    'brand_sub' => 'Премиум Мода и Стиль',
    'nav_home' => 'Главная',
    'nav_catalog' => 'Коллекция',
    'hero_tag' => 'КОЛЛЕКЦИЯ ВЕСНА-ЛЕТО 2026',
    'hero_title_1' => 'Элегантность будущего,',
    'hero_title_2' => 'В твоем стиле.',
    'hero_desc' => 'Итальянский шелк, идеальный крой и утонченные силуэты. Закажите прямо сейчас со скидкой 25% и бесплатной экспресс-доставкой по Баку.',
    'hero_cta' => 'Смотреть Коллекцию',
    'hero_discount' => 'Код: AURA25 (-25%)',
    'ticker' => '✨ ЭКСПРЕСС-ДОСТАВКА ПО БАКУ ЗА 2 ЧАСА • 💳 БЕСПРОЦЕНТНАЯ РАССРОЧКА • 🔄 ВОЗВРАТ 14 ДНЕЙ • 👗 ПОДГОНКА ПО ФИГУРЕ',
    'filter_all' => 'Все товары',
    'filter_dresses' => 'Платья',
    'filter_outer' => 'Пальто',
    'filter_shoes' => 'Обувь',
    'filter_acc' => 'Аксессуары',
    'add_to_cart' => 'В корзину',
    'order_whatsapp' => 'Купить в WhatsApp',
    'select_size' => 'Размер:',
    'cart_title' => 'Ваша корзина',
    'cart_empty' => 'В корзине пока пусто',
    'cart_total' => 'Итого к оплате:',
    'cart_checkout' => 'Оформить в WhatsApp',
    'feat_1' => '🚀 Экспресс-доставка за 2 часа (Баку)',
    'feat_2' => '💎 Натуральные итальянские ткани',
    'feat_3' => '🛡️ Оплата при получении (наличные/карта)',
    'feat_4' => '💬 Поддержка стилиста 24/7 в WhatsApp',
    'footer_desc' => 'Aura Fashion — мир утонченного стиля. Полнофункциональный интернет-магазин, разработанный веб-студией Skyweb.az.',
  ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$products = [
  ['id' => 1, 'cat' => 'dresses', 'price' => 149, 'old' => 199, 'badge' => '-25%', 'icon' => '👗', 'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=700&q=80', 'sizes' => ['XS','S','M','L'], 'title' => ['az' => 'Zümrüd İpək Axşam Donu', 'en' => 'Emerald Silk Evening Gown', 'tr' => 'Zümrüt İpek Gece Elbisesi', 'ru' => 'Изумрудное шелковое платье']],
  ['id' => 2, 'cat' => 'outer', 'price' => 185, 'old' => 240, 'badge' => 'TREND', 'icon' => '🧥', 'img' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=700&q=80', 'sizes' => ['S','M','L','XL'], 'title' => ['az' => 'Cyber Teal Bomber Jaket', 'en' => 'Cyber Teal Neon Bomber', 'tr' => 'Siber Neon Bomber Ceket', 'ru' => 'Бомбер Cyber Neon Teal']],
  ['id' => 3, 'cat' => 'shoes', 'price' => 125, 'old' => 160, 'badge' => 'HOT', 'icon' => '👠', 'img' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=700&q=80', 'sizes' => ['36','37','38','39'], 'title' => ['az' => 'Futuristik Neon Daban Stiletto', 'en' => 'Futuristic Neon Stiletto', 'tr' => 'Fütüristik Neon Topuklu', 'ru' => 'Футуристические шпильки']],
  ['id' => 4, 'cat' => 'acc', 'price' => 95, 'old' => 130, 'badge' => 'NEW', 'icon' => '👜', 'img' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=700&q=80', 'sizes' => ['One Size'], 'title' => ['az' => 'Həndəsi Qızıl Qıfıllı Dəri Çanta', 'en' => 'Geometric Leather Clutch', 'tr' => 'Geometrik Altın Tokalı Çanta', 'ru' => 'Кожаная клатч-сумка']],
  ['id' => 5, 'cat' => 'outer', 'price' => 245, 'old' => 310, 'badge' => 'LUXURY', 'icon' => '🧥', 'img' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=700&q=80', 'sizes' => ['S','M','L'], 'title' => ['az' => 'İtalyan Yunundan Uzun Palto', 'en' => 'Italian Wool Longline Trench', 'tr' => 'İtalyan Yün Kaşe Palto', 'ru' => 'Пальто из итальянской шерсти']],
  ['id' => 6, 'cat' => 'dresses', 'price' => 165, 'old' => 210, 'badge' => 'LIMITED', 'icon' => '✨', 'img' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=700&q=80', 'sizes' => ['XS','S','M'], 'title' => ['az' => 'Gümüşü Parlaq Kokteyl Donu', 'en' => 'Liquid Silver Cocktail Dress', 'tr' => 'Gümüş Işıltılı Gece Elbisesi', 'ru' => 'Серебристое коктейльное платье']],
  ['id' => 7, 'cat' => 'acc', 'price' => 65, 'old' => 85, 'badge' => 'POPULAR', 'icon' => '💎', 'img' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=700&q=80', 'sizes' => ['Universal'], 'title' => ['az' => 'Qızılı Cyber Zəncir & Kulon Dəsti', 'en' => 'Cyan Glow Pendant Set', 'tr' => 'Altın Kaplama Kolye Seti', 'ru' => 'Набор цепочка и неоновый кулон']],
  ['id' => 8, 'cat' => 'shoes', 'price' => 110, 'old' => 145, 'badge' => '-24%', 'icon' => '👟', 'img' => 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=700&q=80', 'sizes' => ['38','39','40','41'], 'title' => ['az' => 'Aura Pro İşıqsaçan Şəhər Sneaker', 'en' => 'Aura Pro City Sneakers', 'tr' => 'Aura Pro Işıklı Sneaker', 'ru' => 'Кроссовки Aura Pro Cyber']],
];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($t['brand_name']) ?> — Skyweb Demo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: rgba(0, 32, 40, 0.78);
      --sky-border: rgba(0, 255, 255, 0.18);
      --neon-cyan: #00FFFF;
      --neon-glow: 0 0 20px rgba(0, 255, 255, 0.35);
      --text-main: #f0fefe;
      --text-muted: #8ec5c5;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: linear-gradient(180deg, #001414 0%, #001f22 35%, #002830 75%, #001a1a 100%); color: var(--text-main); font-family: var(--font-body); min-height: 100vh; line-height: 1.6; }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }
    .demo-bar { background: rgba(0, 24, 24, 0.95); border-bottom: 1px solid var(--sky-border); padding: 8px 16px; font-size: 13px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(12px); }
    .demo-badge { background: rgba(0, 255, 255, 0.15); color: var(--neon-cyan); border: 1px solid var(--neon-cyan); border-radius: 20px; padding: 2px 10px; font-weight: 700; font-size: 11px; text-transform: uppercase; box-shadow: var(--neon-glow); }
    .demo-btn-sky { background: var(--neon-cyan); color: #001a1a; padding: 4px 12px; border-radius: 6px; font-weight: 700; font-size: 12px; transition: 0.25s; }
    .demo-btn-sky:hover { box-shadow: var(--neon-glow); transform: translateY(-1px); }
    .demo-btn-back { color: var(--text-muted); font-size: 12px; font-weight: 600; padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
    .nav { background: rgba(0, 20, 24, 0.85); border-bottom: 1px solid rgba(0, 255, 255, 0.1); backdrop-filter: blur(16px); padding: 14px 24px; position: sticky; top: 41px; z-index: 900; }
    .nav-container { max-width: 1240px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .brand-title { font-family: var(--font-heading); font-size: 22px; font-weight: 800; letter-spacing: 2px; color: #fff; line-height: 1.1; }
    .brand-title span { font-size: 10px; letter-spacing: 3px; color: var(--neon-cyan); font-weight: 600; text-transform: uppercase; display: block; }
    .cart-trigger-btn { background: rgba(0, 255, 255, 0.08); border: 1px solid var(--sky-border); color: var(--neon-cyan); padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; transition: 0.2s; }
    .cart-trigger-btn:hover { background: rgba(0, 255, 255, 0.2); box-shadow: var(--neon-glow); }
    .cart-badge-count { background: var(--neon-cyan); color: #001a1a; font-size: 11px; font-weight: 800; padding: 1px 7px; border-radius: 12px; }
    .hero { max-width: 1240px; margin: 0 auto; padding: 60px 24px 40px; display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 40px; align-items: center; }
    .hero-tag { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: 2px; color: var(--neon-cyan); background: rgba(0, 255, 255, 0.1); border: 1px solid var(--sky-border); padding: 5px 12px; border-radius: 30px; margin-bottom: 16px; }
    .hero-h1 { font-family: var(--font-heading); font-size: clamp(32px, 5vw, 54px); line-height: 1.15; font-weight: 900; color: #fff; margin-bottom: 16px; }
    .hero-h1 .glow { color: var(--neon-cyan); text-shadow: 0 0 25px rgba(0,255,255,0.4); }
    .hero-p { color: var(--text-muted); font-size: 15px; line-height: 1.7; margin-bottom: 24px; max-width: 500px; }
    .hero-btns { display: flex; flex-wrap: wrap; gap: 14px; align-items: center; }
    .btn-primary { background: linear-gradient(135deg, var(--neon-cyan) 0%, #00b4d8 100%); color: #001a1a; font-weight: 700; font-size: 14px; padding: 12px 26px; border-radius: 10px; border: none; box-shadow: 0 0 25px rgba(0,255,255,0.4); transition: 0.25s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(0,255,255,0.6); }
    .promo-chip { background: rgba(0, 32, 40, 0.8); border: 1px dashed var(--neon-cyan); padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; color: var(--neon-cyan); }
    .lookbook-card { background: linear-gradient(145deg, rgba(0, 40, 50, 0.7), rgba(0, 20, 25, 0.9)); border: 1px solid var(--sky-border); border-radius: 24px; padding: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.5); }
    .lookbook-avatar { height: 260px; border-radius: 16px; overflow: hidden; margin-bottom: 14px; position: relative; }
    .lookbook-avatar img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .lookbook-card:hover .lookbook-avatar img { transform: scale(1.05); }
    .ticker-bar { background: rgba(0, 30, 35, 0.9); border-top: 1px solid var(--sky-border); border-bottom: 1px solid var(--sky-border); padding: 10px 0; overflow: hidden; white-space: nowrap; margin: 20px 0 40px; }
    .ticker-text { display: inline-block; font-size: 12px; font-weight: 700; letter-spacing: 1px; color: var(--neon-cyan); animation: ticker 25s linear infinite; }
    @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .catalog-section { max-width: 1240px; margin: 0 auto 60px; padding: 0 24px; }
    .filter-tabs { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 30px; }
    .filter-btn { background: rgba(0, 32, 40, 0.6); border: 1px solid rgba(0, 255, 255, 0.15); color: var(--text-muted); padding: 7px 18px; border-radius: 30px; font-size: 13px; font-weight: 600; transition: 0.2s; }
    .filter-btn.active, .filter-btn:hover { background: var(--neon-cyan); color: #001a1a; border-color: var(--neon-cyan); box-shadow: 0 0 15px rgba(0,255,255,0.4); }
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 24px; }
    .product-card { background: var(--sky-card); border: 1px solid var(--sky-border); border-radius: 18px; padding: 16px; display: flex; flex-direction: column; position: relative; transition: 0.25s; overflow: hidden; }
    .product-card:hover { transform: translateY(-5px); border-color: var(--neon-cyan); box-shadow: 0 10px 30px rgba(0,0,0,0.5), 0 0 20px rgba(0,255,255,0.2); }
    .card-badge { position: absolute; top: 12px; left: 12px; background: rgba(0, 20, 25, 0.85); border: 1px solid var(--neon-cyan); color: var(--neon-cyan); padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 700; z-index: 2; backdrop-filter: blur(4px); }
    .card-img-box { height: 230px; border-radius: 12px; overflow: hidden; margin-bottom: 14px; position: relative; background: #00232b; }
    .card-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; display: block; }
    .product-card:hover .card-img-box img { transform: scale(1.06); }
    .card-title { font-family: var(--font-heading); font-size: 16px; font-weight: 700; color: #fff; margin-bottom: 8px; min-height: 40px; }
    .card-price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px; }
    .current-price { font-size: 19px; font-weight: 800; color: #fff; }
    .current-price span { color: var(--neon-cyan); font-size: 13px; }
    .old-price { font-size: 13px; color: rgba(255,255,255,0.4); text-decoration: line-through; }
    .size-opts { display: flex; gap: 5px; margin-bottom: 14px; }
    .size-opt { font-size: 11px; padding: 2px 8px; background: rgba(0,0,0,0.3); border: 1px solid rgba(0,255,255,0.2); border-radius: 4px; color: var(--text-muted); cursor: pointer; }
    .size-opt.active { background: var(--neon-cyan); color: #001a1a; font-weight: 700; border-color: var(--neon-cyan); }
    .card-actions { display: flex; gap: 8px; margin-top: auto; }
    .btn-add-cart { flex: 1; background: rgba(0, 255, 255, 0.12); border: 1px solid var(--neon-cyan); color: var(--neon-cyan); padding: 9px; border-radius: 8px; font-size: 13px; font-weight: 700; transition: 0.2s; }
    .btn-add-cart:hover { background: var(--neon-cyan); color: #001a1a; box-shadow: 0 0 15px rgba(0,255,255,0.4); }
    .btn-wa-direct { background: #25d366; color: #001a1a; border: none; padding: 9px 12px; border-radius: 8px; font-size: 15px; }
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; max-width: 1240px; margin: 0 auto 60px; padding: 0 24px; }
    .feature-item { background: rgba(0, 26, 32, 0.6); border: 1px solid var(--sky-border); border-radius: 14px; padding: 18px; font-size: 14px; font-weight: 600; color: #fff; text-align: center; }
    .cart-drawer-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 2000; opacity: 0; visibility: hidden; transition: 0.3s; }
    .cart-drawer-overlay.active { opacity: 1; visibility: visible; }
    .cart-drawer { position: fixed; top: 0; right: -420px; width: 100%; max-width: 380px; height: 100%; background: #001a1a; border-left: 1px solid var(--sky-border); z-index: 2001; display: flex; flex-direction: column; transition: right 0.35s ease; box-shadow: -10px 0 40px rgba(0,0,0,0.7); }
    .cart-drawer.active { right: 0; }
    .cart-header { padding: 18px; border-bottom: 1px solid rgba(0,255,255,0.15); display: flex; justify-content: space-between; align-items: center; color: #fff; font-family: var(--font-heading); }
    .cart-close-btn { background: transparent; border: none; color: var(--text-muted); font-size: 20px; }
    .cart-items-body { flex: 1; padding: 18px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
    .cart-item { display: flex; align-items: center; gap: 10px; background: rgba(0, 32, 40, 0.5); border: 1px solid rgba(0,255,255,0.1); border-radius: 10px; padding: 10px; font-size: 13px; }
    .cart-footer { padding: 18px; border-top: 1px solid rgba(0,255,255,0.15); background: rgba(0, 20, 25, 0.95); }
    .btn-wa-checkout { width: 100%; background: #25d366; color: #001a1a; border: none; padding: 13px; border-radius: 10px; font-weight: 800; font-size: 14px; margin-top: 12px; }
    .floating-tools { position: fixed; bottom: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 1500; }
    .float-btn { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.5); }
    .toast-msg { position: fixed; bottom: 85px; left: 50%; transform: translateX(-50%) translateY(40px); background: rgba(0, 32, 40, 0.95); border: 1px solid var(--neon-cyan); color: #fff; padding: 10px 20px; border-radius: 30px; font-size: 13px; font-weight: 600; opacity: 0; visibility: hidden; transition: 0.3s; z-index: 3000; }
    .toast-msg.show { transform: translateX(-50%) translateY(0); opacity: 1; visibility: visible; }
    .boutique-footer { background: #001012; border-top: 1px solid var(--sky-border); padding: 40px 24px 24px; text-align: center; }
    @media (max-width: 850px) { .hero { grid-template-columns: 1fr; text-align: center; } .hero-btns { justify-content: center; } }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="clothing" data-dk-accent="#ec4899" data-dk-phone="994503936998" data-dk-sticky data-dk-action="toggleCart" data-dk-sticky-label="Səbət">
  <script src="assets/demo-kit.js"></script>

  <!-- Top Demo Banner -->
  <div class="demo-bar">
    <div style="display:flex; align-items:center; gap:8px;">
      <span class="demo-badge">SKYWEB DEMO</span>
      <span style="color:var(--text-muted); font-weight:500;"><?= htmlspecialchars($t['demo_banner']) ?></span>
    </div>
    <div style="display:flex; align-items:center; gap:10px;">
      <a href="../../index.php?lang=<?= e($lang) ?>#contact" class="demo-btn-sky"><?= htmlspecialchars($t['order_site']) ?> →</a>
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-btn-back">← <?= htmlspecialchars($t['back_to_sky']) ?></a>
    </div>
  </div>

  <!-- Navbar -->
  <header class="nav">
    <div class="nav-container">
      <div class="brand-title">
        <?= htmlspecialchars($t['brand_name']) ?>
        <span><?= htmlspecialchars($t['brand_sub']) ?></span>
      </div>
      <button class="cart-trigger-btn" onclick="toggleCart()">
        <span>🛒</span>
        <span><?= htmlspecialchars($t['cart_title']) ?></span>
        <span class="cart-badge-count" id="cartTopCount">0</span>
      </button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div>
      <span class="hero-tag"><?= htmlspecialchars($t['hero_tag']) ?></span>
      <h1 class="hero-h1"><?= htmlspecialchars($t['hero_title_1']) ?><br><span class="glow"><?= htmlspecialchars($t['hero_title_2']) ?></span></h1>
      <p class="hero-p"><?= htmlspecialchars($t['hero_desc']) ?></p>
      <div class="hero-btns">
        <a href="#catalog" class="btn-primary"><?= htmlspecialchars($t['hero_cta']) ?> ↓</a>
        <div class="promo-chip">🎁 <?= htmlspecialchars($t['hero_discount']) ?></div>
      </div>
    </div>
    <div>
      <div class="lookbook-card">
        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
          <span class="card-badge">LOOKBOOK 2026</span>
          <span style="color:var(--neon-cyan); font-weight:700; font-size:12px;">★ TOP PICK</span>
        </div>
        <div class="lookbook-avatar">
          <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=700&q=80" alt="Aura Lookbook 2026" loading="lazy">
        </div>
        <div style="display:flex; justify-content:space-between; font-weight:700; font-size:15px; color:#fff;">
          <span>Emerald Silk Dress</span>
          <span style="color:var(--neon-cyan);">149 AZN</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Ticker Banner -->
  <div class="ticker-bar">
    <div class="ticker-text"><?= htmlspecialchars($t['ticker']) ?> • <?= htmlspecialchars($t['ticker']) ?></div>
  </div>

  <!-- Catalog Section -->
  <section class="catalog-section" id="catalog">
    <div class="filter-tabs">
      <button class="filter-btn active" onclick="filterCategory('all', this)"><?= htmlspecialchars($t['filter_all']) ?></button>
      <button class="filter-btn" onclick="filterCategory('dresses', this)"><?= htmlspecialchars($t['filter_dresses']) ?></button>
      <button class="filter-btn" onclick="filterCategory('outer', this)"><?= htmlspecialchars($t['filter_outer']) ?></button>
      <button class="filter-btn" onclick="filterCategory('shoes', this)"><?= htmlspecialchars($t['filter_shoes']) ?></button>
      <button class="filter-btn" onclick="filterCategory('acc', this)"><?= htmlspecialchars($t['filter_acc']) ?></button>
    </div>

    <div class="products-grid">
      <?php foreach ($products as $prod): ?>
        <?php $title = $prod['title'][$lang] ?? $prod['title']['az']; ?>
        <div class="product-card" data-cat="<?= $prod['cat'] ?>">
          <span class="card-badge"><?= $prod['badge'] ?></span>
          <div class="card-img-box">
            <img src="<?= htmlspecialchars($prod['img']) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy" />
          </div>
          <h3 class="card-title"><?= htmlspecialchars($title) ?></h3>
          <div class="card-price-row">
            <span class="current-price"><?= $prod['price'] ?> <span>AZN</span></span>
            <span class="old-price"><?= $prod['old'] ?> AZN</span>
          </div>
          <div class="size-opts">
            <?php foreach ($prod['sizes'] as $idx => $s): ?>
              <span class="size-opt <?= $idx === 0 ? 'active' : '' ?>" onclick="selectSize(this)"><?= $s ?></span>
            <?php endforeach; ?>
          </div>
          <div class="card-actions">
            <button class="btn-add-cart" onclick="addToCart(<?= $prod['id'] ?>, '<?= htmlspecialchars(addslashes($title)) ?>', <?= $prod['price'] ?>, '<?= htmlspecialchars(addslashes($prod['img'])) ?>', this)">
              + <?= htmlspecialchars($t['add_to_cart']) ?>
            </button>
            <button class="btn-wa-direct" onclick="buyDirectWhatsApp('<?= htmlspecialchars(addslashes($title)) ?>', <?= $prod['price'] ?>, this)">💬</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Features -->
  <div class="features-grid">
    <div class="feature-item"><?= htmlspecialchars($t['feat_1']) ?></div>
    <div class="feature-item"><?= htmlspecialchars($t['feat_2']) ?></div>
    <div class="feature-item"><?= htmlspecialchars($t['feat_3']) ?></div>
    <div class="feature-item"><?= htmlspecialchars($t['feat_4']) ?></div>
  </div>

  <!-- Cart Drawer -->
  <div class="cart-drawer-overlay" id="cartOverlay" onclick="toggleCart()"></div>
  <aside class="cart-drawer" id="cartDrawer">
    <div class="cart-header">
      <h3><?= htmlspecialchars($t['cart_title']) ?></h3>
      <button class="cart-close-btn" onclick="toggleCart()">✕</button>
    </div>
    <div class="cart-items-body" id="cartItemsList">
      <div style="text-align:center; padding: 40px 10px; color:var(--text-muted);" id="emptyCartNotice">
        <div style="font-size:36px; margin-bottom:8px;">🛍️</div>
        <?= htmlspecialchars($t['cart_empty']) ?>
      </div>
    </div>
    <div class="cart-footer">
      <div class="dk-coupon" id="couponChip" onclick="toggleCoupon()" role="button" tabindex="0">
        <span class="dk-coupon__val">AURA25</span>
        <small id="couponHint"><?= htmlspecialchars($t['hero_discount']) ?> — <?= htmlspecialchars($t['cart_title']) ?></small>
      </div>
      <div class="dk-ship" id="shipNote" style="margin-top:10px;"></div>
      <div style="display:flex; justify-content:space-between; font-weight:700; color:#fff; margin-top:10px;">
        <span><?= htmlspecialchars($t['cart_total']) ?></span>
        <span style="color:var(--neon-cyan); font-size:20px;" id="cartTotalSum">0 AZN</span>
      </div>
      <button class="btn-wa-checkout" onclick="checkoutWhatsApp()">💬 <?= htmlspecialchars($t['cart_checkout']) ?></button>
    </div>
  </aside>

  <!-- Floating Buttons -->
  <div class="floating-tools">
    <button class="float-btn" style="background:var(--neon-cyan); color:#001a1a; position:relative;" onclick="toggleCart()" title="<?= htmlspecialchars($t['cart_title']) ?>">
      <span data-dk-count class="dk-count">0</span>🛒
    </button>
    <button class="float-btn" style="background:#25d366; color:#fff;" onclick="buyDirectWhatsApp('Ümumi Sual', 0)" title="WhatsApp">💬</button>
  </div>

  <!-- Mobile sticky CTA -->
  <div class="dk-stickybar">
    <button class="dk-btn dk-btn--ghost" onclick="toggleCart()" style="position:relative;">
      <span data-dk-count class="dk-count">0</span> 🛒 <?= htmlspecialchars($t['cart_title']) ?>
    </button>
    <button class="dk-btn dk-btn--primary" onclick="document.getElementById('catalog').scrollIntoView({behavior:'smooth'});"><?= htmlspecialchars($t['hero_cta']) ?></button>
  </div>

  <div class="toast-msg" id="toastBox">Əlavə edildi!</div>

  <!-- Footer -->
  <footer class="boutique-footer">
    <div style="font-family:var(--font-heading); font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;"><?= htmlspecialchars($t['brand_name']) ?></div>
    <p style="color:var(--text-muted); font-size:13px; max-width:600px; margin:0 auto 16px;"><?= htmlspecialchars($t['footer_desc']) ?></p>
    <div style="font-size:12px; color:rgba(255,255,255,0.4);">© 2026 <?= htmlspecialchars($t['brand_name']) ?>. Crafted with ⚡ by Skyweb.az</div>
  </footer>

  <script>
    /* ── Aura Moda · səbət, kupon, pulsuz çatdırılma və sifariş ── */
    const COUPON_CODE = 'AURA25';
    const FREE_SHIP = 100;
    let couponOn = false;

    const cart = DK.cart('bag', () => renderCart());

    function toggleCart() {
      document.getElementById('cartOverlay').classList.toggle('active');
      document.getElementById('cartDrawer').classList.toggle('active');
    }

    function showToast(text) { DK.toast(text); }

    function selectedSize(btn) {
      const card = btn && btn.closest ? btn.closest('.product-card') : null;
      const s = card ? card.querySelector('.size-opt.active') : null;
      return s ? s.textContent.trim() : '';
    }

    function addToCart(id, title, price, img, btn) {
      const size = selectedSize(btn);
      cart.add({ id, title, price, img, meta: size ? 'Ölçü: ' + size : '' }, 1);
      DK.toast(title + ' — ' + DK.t.added);
      const badge = document.getElementById('cartTopCount');
      if (badge) { badge.classList.remove('dk-shake'); void badge.offsetWidth; badge.classList.add('dk-shake'); }
    }

    function setQty(id, meta, dir) {
      const item = cart.items.find(i => String(i.id) === String(id) && (i.meta || '') === (meta || ''));
      if (!item) return;
      cart.setQty(id, meta, item.qty + dir);
    }

    function removeFromCart(id, meta) {
      cart.remove(id, meta);
      DK.toast(DK.t.removed, 'info');
    }

    function toggleCoupon() {
      if (!cart.count()) return DK.toast(DK.t.emptyCart, 'err');
      couponOn = !couponOn;
      renderCart();
      DK.toast(
        couponOn
          ? DK.pick('AURA25 tətbiq olundu −25%', 'AURA25 applied −25%', 'AURA25 применён −25%', 'AURA25 uygulandı −25%')
          : DK.pick('Kupon ləğv edildi', 'Coupon removed', 'Купон отменён', 'Kupon kaldırıldı'),
        couponOn ? 'ok' : 'info'
      );
    }

    function renderCart() {
      const container = document.getElementById('cartItemsList');
      const totalEl = document.getElementById('cartTotalSum');
      const items = cart.items;
      const sub = cart.total();
      const discount = couponOn ? sub * 0.25 : 0;
      const total = Math.max(0, sub - discount);

      const topCount = document.getElementById('cartTopCount');
      if (topCount) topCount.textContent = cart.count();

      if (!items.length) {
        container.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">🛍️</span>' + DK.esc(DK.t.emptyCart) + '</div>';
        totalEl.textContent = '0 AZN';
      } else {
        container.innerHTML = items.map(i => {
          const safeMeta = DK.esc(i.meta || '');
          return '<div class="cart-item">' +
            (i.img ? '<img src="' + DK.esc(i.img) + '" alt="" style="width:48px;height:48px;border-radius:8px;object-fit:cover;border:1px solid rgba(0,255,255,.2)">' : '<span style="font-size:24px">🛍️</span>') +
            '<div style="flex:1;min-width:0">' +
              '<div style="color:#fff;font-weight:600">' + DK.esc(i.title) + '</div>' +
              (i.meta ? '<div style="font-size:11px;color:#8ec5c5">' + safeMeta + '</div>' : '') +
              '<div style="color:var(--neon-cyan);font-size:12px">' + i.qty + ' × ' + i.price + ' AZN</div>' +
            '</div>' +
            '<div class="dk-qty">' +
              '<button class="dk-qty__btn" onclick="setQty(' + i.id + ', \'' + safeMeta + '\', -1)" aria-label="−">−</button>' +
              '<span class="dk-qty__val">' + i.qty + '</span>' +
              '<button class="dk-qty__btn" onclick="setQty(' + i.id + ', \'' + safeMeta + '\', 1)" aria-label="+">+</button>' +
            '</div>' +
            '<button style="background:none;border:none;color:#ff4d6d;font-size:15px;cursor:pointer;padding:4px" onclick="removeFromCart(' + i.id + ', \'' + safeMeta + '\')" aria-label="Sil">✕</button>' +
          '</div>';
        }).join('');

        totalEl.innerHTML = couponOn
          ? '<s style="color:#7fa4a4;font-size:12px">' + sub + ' AZN</s> &nbsp;' + (Math.round(total * 100) / 100) + ' AZN'
          : total + ' AZN';
      }

      const shipNote = document.getElementById('shipNote');
      if (shipNote) {
        const left = FREE_SHIP - total;
        shipNote.innerHTML = left > 0
          ? '<b>' + Math.ceil(left) + ' AZN</b> ' + DK.esc(DK.t.freeShip) +
            '<div class="dk-track"><i style="width:' + Math.min(100, (total / FREE_SHIP) * 100) + '%"></i></div>'
          : DK.esc(DK.t.freeShipDone);
      }

      const chip = document.getElementById('couponChip');
      if (chip) chip.style.borderStyle = couponOn ? 'solid' : 'dashed';
    }

    function filterCategory(cat, btn) {
      document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.product-card').forEach(c => {
        c.style.display = (cat === 'all' || c.getAttribute('data-cat') === cat) ? 'flex' : 'none';
      });
    }

    function selectSize(span) {
      span.closest('.size-opts').querySelectorAll('.size-opt').forEach(s => s.classList.remove('active'));
      span.classList.add('active');
    }

    function buyDirectWhatsApp(title, price, btn) {
      const size = selectedSize(btn);
      DK.order({
        title: title,
        brand: '<?= htmlspecialchars(addslashes($t['brand_name'])) ?>',
        items: [{ title: title, price: price, qty: 1, meta: size ? 'Ölçü: ' + size : '' }]
      });
    }

    function checkoutWhatsApp() {
      if (!cart.items.length) return DK.toast(DK.t.emptyCart, 'err');
      const sub = cart.total();
      const discount = couponOn ? sub * 0.25 : 0;
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: '<?= htmlspecialchars(addslashes($t['brand_name'])) ?>',
        items: cart.items,
        addressRequired: true,
        discountAmount: discount,
        discountLabel: couponOn ? 'Kupon AURA25' : ''
      }).then(d => {
        if (!d) return;
        cart.clear();
        couponOn = false;
        toggleCart();
      });
    }

    renderCart();
  </script>
</body>
</html>
