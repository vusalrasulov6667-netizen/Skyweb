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
    'brand_name' => 'GUSTO RESTOBAR',
    'brand_sub' => 'Müasir Mətbəx & Grill',
    'nav_home' => 'Ana Səhifə',
    'nav_menu' => 'Rəqəmsal Menyu',
    'nav_reserve' => 'Masa Rezerv Et',
    'hero_tag' => '🔥 ODUN SOFASINDA MÜƏLLİF TƏAMLARI',
    'hero_title_1' => 'Dadın Ən Yüksək Həddi,',
    'hero_title_2' => 'Qapınızda və ya Masanızda.',
    'hero_desc' => 'Təbii kənd ərzaqları, kömür ateşində dinləndirilmiş steyklər və əfsanəvi burgerlər. Bakı daxili 30 dəqiqəyə qaynar çatdırılma.',
    'hero_btn_menu' => 'Menyunu İncələ',
    'hero_btn_reserve' => 'Masa Rezervasiyası',
    'hero_delivery_note' => '🚀 25 AZN üzəri sifarişlərdə çatdırılma PULSUZDUR',
    'filter_all' => 'Hamısı',
    'filter_starters' => 'Qəlyanaltılar',
    'filter_mains' => 'Steyk & Əsas',
    'filter_fast' => 'Burger & Pizza',
    'filter_desserts' => 'Desertlər',
    'filter_drinks' => 'İçkilər',
    'btn_add_dish' => 'Sifarişə At',
    'chef_pick' => 'Şefin Seçimi',
    'spicy' => 'Acılı',
    'cart_title' => 'Sifariş Səbəti',
    'cart_empty' => 'Səbətinizdə hələ təam yoxdur',
    'cart_total' => 'Cəmi:',
    'btn_checkout_wa' => 'WhatsApp ilə Sifariş Ver',
    'deliv_1' => '⚡ 30-45 Dəqiqə Qaynar Çatdırılma',
    'deliv_2' => '🛡️ Termo-Çanta & 100% Gigiyenik Qablaşdırma',
    'deliv_3' => '💳 Qapıda Nağd və ya POS Terminal ilə Ödəniş',
    'res_title' => 'Masa Rezervasiyası',
    'res_desc' => 'Axşamınızı unudulmaz etmək üçün masanızı əvvəlcədən təmin edin.',
    'res_btn' => 'Rezervasiyanı Təsdiqlə',
    'input_name' => 'Adınız və Soyadınız',
    'input_phone' => 'Əlaqə nömrəsi: +994 50...',
    'guests_2' => '2 nəfər',
    'guests_4' => '4 nəfər',
    'guests_6' => '6 nəfər',
    'toast_added' => 'səbətə əlavə edildi',
    'toast_reserved' => 'Rezervasiya qəbul edildi!',
    'toast_empty' => 'Səbətiniz boşdur!',
    'footer_desc' => 'Gusto Restobar — Bakının mərkəzində kulinariya sənəti. Skyweb.az tərəfindən restoran və kafe biznesləri üçün hazırlanmış onlayn sifariş sistemi.',
  ],
  'en' => [
    'demo_banner' => 'This is a demo website — Created by Skyweb',
    'back_to_sky' => 'Back to Skyweb',
    'order_site' => 'Order This Website',
    'brand_name' => 'GUSTO RESTOBAR',
    'brand_sub' => 'Craft Kitchen & Grill',
    'nav_home' => 'Home',
    'nav_menu' => 'Digital Menu',
    'nav_reserve' => 'Book Table',
    'hero_tag' => '🔥 WOOD-FIRED ARTISANAL CUISINE',
    'hero_title_1' => 'Culinary Excellence,',
    'hero_title_2' => 'Delivered Hot & Fresh.',
    'hero_desc' => 'Prime cut dry-aged steaks, artisan burgers, and handcrafted desserts. Savor gourmet dining delivered to your doorstep in 30 minutes.',
    'hero_btn_menu' => 'Explore Menu',
    'hero_btn_reserve' => 'Reserve Table',
    'hero_delivery_note' => '🚀 FREE delivery on all orders over 25 AZN',
    'filter_all' => 'All Dishes',
    'filter_starters' => 'Starters',
    'filter_mains' => 'Steaks & Mains',
    'filter_fast' => 'Burgers & Pizza',
    'filter_desserts' => 'Desserts',
    'filter_drinks' => 'Drinks',
    'btn_add_dish' => 'Add to Order',
    'chef_pick' => 'Chef Choice',
    'spicy' => 'Spicy',
    'cart_title' => 'Order Bag',
    'cart_empty' => 'Your food bag is currently empty',
    'cart_total' => 'Total:',
    'btn_checkout_wa' => 'Place Order via WhatsApp',
    'deliv_1' => '⚡ 30-45 Min Steaming Hot Delivery',
    'deliv_2' => '🛡️ Insulated Bags & 100% Sealed Packaging',
    'deliv_3' => '💳 Pay on Delivery (Cash or POS Card)',
    'res_title' => 'Table Reservation',
    'res_desc' => 'Book your table in advance for an exquisite gastronomic evening.',
    'res_btn' => 'Confirm Booking',
    'input_name' => 'Your Full Name',
    'input_phone' => 'Phone: +994 50...',
    'guests_2' => '2 Guests',
    'guests_4' => '4 Guests',
    'guests_6' => '6 Guests',
    'toast_added' => 'added to cart',
    'toast_reserved' => 'Reservation received!',
    'toast_empty' => 'Your cart is empty!',
    'footer_desc' => 'Gusto Restobar — artisan food and warm ambiance. A high-converting digital ordering website engineered by Skyweb.az.',
  ],
  'tr' => [
    'demo_banner' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
    'back_to_sky' => 'Skyweb\'e Dön',
    'order_site' => 'Bu Siteyi Sipariş Et',
    'brand_name' => 'GUSTO RESTOBAR',
    'brand_sub' => 'Modern Mutfak & Izgara',
    'nav_home' => 'Ana Sayfa',
    'nav_menu' => 'Dijital Menü',
    'nav_reserve' => 'Masa Ayırt',
    'hero_tag' => '🔥 TAŞ FIRINDA LEZZET ŞÖLENİ',
    'hero_title_1' => 'Gurme Lezzetler,',
    'hero_title_2' => 'Kapınızda veya Masanızda.',
    'hero_desc' => 'Kömür ateşinde dinlendirilmiş biftekler, el yapımı gurme burgerler ve taze tatlılar. 30 dakikada sıcacık kapınıza teslim.',
    'hero_btn_menu' => 'Menüyü İncele',
    'hero_btn_reserve' => 'Masa Rezervasyonu',
    'hero_delivery_note' => '🚀 25 AZN üzeri siparişlerde kurye ÜCRETSİZ',
    'filter_all' => 'Tümü',
    'filter_starters' => 'Başlangıçlar',
    'filter_mains' => 'Biftek & Izgara',
    'filter_fast' => 'Burger & Pizza',
    'filter_desserts' => 'Tatlılar',
    'filter_drinks' => 'İçecekler',
    'btn_add_dish' => 'Siparişe Ekle',
    'chef_pick' => 'Şefin Önerisi',
    'spicy' => 'Acılı',
    'cart_title' => 'Sipariş Sepeti',
    'cart_empty' => 'Sepetinizde ürün bulunmuyor',
    'cart_total' => 'Toplam:',
    'btn_checkout_wa' => 'WhatsApp ile Sipariş Ver',
    'deliv_1' => '⚡ 30-45 Dakikada Sıcacık Teslimat',
    'deliv_2' => '🛡️ Termo Çanta ile Korunan Tazelik',
    'deliv_3' => '💳 Kapıda Nakit ya da POS Cihazı ile Ödeme',
    'res_title' => 'Masa Rezervasyonu',
    'res_desc' => 'Unutulmaz bir akşam yemeği için yerinizi şimdiden ayırtın.',
    'res_btn' => 'Rezervasyonu Tamamla',
    'input_name' => 'Adınız ve Soyadınız',
    'input_phone' => 'İletişim: +994 50...',
    'guests_2' => '2 Kişi',
    'guests_4' => '4 Kişi',
    'guests_6' => '6 Kişi',
    'toast_added' => 'sepete eklendi',
    'toast_reserved' => 'Rezervasyon alındı!',
    'toast_empty' => 'Sepetiniz boş!',
    'footer_desc' => 'Gusto Restobar — gastronomi tutkusu. Skyweb.az tarafından restoran ve kafeler için geliştirilen yeni nesil online sipariş demosu.',
  ],
  'ru' => [
    'demo_banner' => 'Это демонстрационный сайт — Создано Skyweb',
    'back_to_sky' => 'Вернуться в Skyweb',
    'order_site' => 'Заказать такой сайт',
    'brand_name' => 'GUSTO RESTOBAR',
    'brand_sub' => 'Авторская Кухня и Гриль',
    'nav_home' => 'Главная',
    'nav_menu' => 'Цифровое Меню',
    'nav_reserve' => 'Бронь столика',
    'hero_tag' => '🔥 БЛЮДА НА ОТКРЫТОМ ОГНЕ',
    'hero_title_1' => 'Вершина вкуса,',
    'hero_title_2' => 'У вас дома или за столиком.',
    'hero_desc' => 'Мраморные стейки сухого вызревания, сочные крафтовые бургеры и изысканные десерты. Горячая доставка по Баку за 30 минут.',
    'hero_btn_menu' => 'Открыть меню',
    'hero_btn_reserve' => 'Забронировать стол',
    'hero_delivery_note' => '🚀 БЕСПЛАТНАЯ доставка при заказе от 25 AZN',
    'filter_all' => 'Все блюда',
    'filter_starters' => 'Закуски',
    'filter_mains' => 'Стейки и горячее',
    'filter_fast' => 'Бургеры и пицца',
    'filter_desserts' => 'Десерты',
    'filter_drinks' => 'Напитки',
    'btn_add_dish' => 'В заказ',
    'chef_pick' => 'Выбор шефа',
    'spicy' => 'Острое',
    'cart_title' => 'Корзина заказа',
    'cart_empty' => 'В вашей корзине пока нет блюд',
    'cart_total' => 'Итого:',
    'btn_checkout_wa' => 'Заказать через WhatsApp',
    'deliv_1' => '⚡ 30-45 минут быстрая доставка горячих блюд',
    'deliv_2' => '🛡️ Термосумки сохраняют еду с пылу с жару',
    'deliv_3' => '💳 Оплата при получении курьеру наличными или картой',
    'res_title' => 'Бронирование столика',
    'res_desc' => 'Забронируйте столик заранее для вашего гастрономического вечера.',
    'res_btn' => 'Подтвердить бронь',
    'input_name' => 'Ваше имя и фамилия',
    'input_phone' => 'Телефон: +994 50...',
    'guests_2' => '2 персоны',
    'guests_4' => '4 персоны',
    'guests_6' => '6 персон',
    'toast_added' => 'добавлено в корзину',
    'toast_reserved' => 'Бронь принята!',
    'toast_empty' => 'Ваша корзина пуста!',
    'footer_desc' => 'Gusto Restobar — атмосфера уюта и вкуса. Демонстрационный веб-сайт с онлайн-заказом для ресторанов от Skyweb.az.',
  ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$dishes = [
  ['id' => 101, 'cat' => 'fast', 'price' => 16.50, 'tag' => 'chef', 'icon' => '🍔', 'img' => 'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=700&q=80', 'title' => ['az' => 'Black Angus Truffle Burger', 'en' => 'Black Angus Truffle Burger', 'tr' => 'Black Angus Trüflü Burger', 'ru' => 'Трюфельный бургер Black Angus'], 'desc' => ['az' => '200q mal əti, tüstülənmiş çedar, qara trüfel sousu və kartof fri.', 'en' => '200g prime Angus patty, smoked cheddar, black truffle aioli with fries.', 'tr' => '200g köfte, füme cheddar, siyah trüf mayonezi ve çıtır patates.', 'ru' => '200г котлета Black Angus, копченый чеддер, трюфельный соус и картофель фри.']],
  ['id' => 102, 'cat' => 'mains', 'price' => 34.00, 'tag' => 'chef', 'icon' => '🥩', 'img' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=700&q=80', 'title' => ['az' => 'Ribeye Steyk Kərə Yağında', 'en' => 'Dry-Aged Ribeye Butter Steak', 'tr' => 'Tereyağlı Ribeye Steyk', 'ru' => 'Рибай стейк на сливочном масле'], 'desc' => ['az' => '320q mərmər əti, rozmarinli sarımsaq yağı, qril qulançar.', 'en' => '320g dry-aged marble ribeye, rosemary garlic butter, asparagus.', 'tr' => '320g dinlendirilmiş antrikot, biberiye sarımsak tereyağı, ızgara kuşkonmaz.', 'ru' => '320г мраморный рибай, розмариновое масло, спаржа гриль.']],
  ['id' => 103, 'cat' => 'starters', 'price' => 14.50, 'tag' => 'spicy', 'icon' => '🍲', 'img' => 'https://images.unsplash.com/photo-1548943487-a2e4e43b4853?w=700&q=80', 'title' => ['az' => 'Krevetli Tom Yum Şorbası', 'en' => 'Royal Tiger Prawn Tom Yum', 'tr' => 'Kral Karidesli Tom Yum', 'ru' => 'Том Ям с королевскими креветками'], 'desc' => ['az' => 'Pələng krevetləri, limonotu və ədviyyatlı kokos bulyonu.', 'en' => 'Tiger prawns, lemongrass, shiitake in aromatic spicy broth.', 'tr' => 'Kaplan karides, limon otu, mantar ve acı hindistancevizi çorbası.', 'ru' => 'Тигровые креветки, лемонграсс, грибы шиитаке, пряный бульон.']],
  ['id' => 104, 'cat' => 'mains', 'price' => 15.00, 'tag' => 'chef', 'icon' => '🍝', 'img' => 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=700&q=80', 'title' => ['az' => 'İtalyan Karbonara Pastası', 'en' => 'Authentic Italian Carbonara', 'tr' => 'Orijinal İtalyan Carbonara', 'ru' => 'Аутентичная паста Карбонара'], 'desc' => ['az' => 'Klassik Guanciale, təzə yumurta sarısı və Pecorino pendiri.', 'en' => 'Traditional guanciale, egg yolks and aged Pecorino Romano.', 'tr' => 'Geleneksel kuru et, taze yumurta sarısı ve pecorino peyniri.', 'ru' => 'Традиционный гуанчиале, желтки и выдержанный Пекорино.']],
  ['id' => 105, 'cat' => 'starters', 'price' => 13.50, 'tag' => '', 'icon' => '🥗', 'img' => 'https://images.unsplash.com/photo-1540420773420-3366772f4999?w=700&q=80', 'title' => ['az' => 'Qızılbalıqlı Sezar Salatı', 'en' => 'Grilled Salmon Caesar Salad', 'tr' => 'Somon Fümeli Sezar Salata', 'ru' => 'Салат Цезарь с лососем'], 'desc' => ['az' => 'Aysberq, qızılbalıq filesi, parmezan ovuntuları və sezar sous.', 'en' => 'Crisp romaine, grilled salmon fillet, aged parmesan flakes.', 'tr' => 'Çıtır marul, ızgara somon dilimleri, parmesan ve sezar sosu.', 'ru' => 'Хрустящий романо, филе лосося на гриле, пармезан и соус.']],
  ['id' => 106, 'cat' => 'fast', 'price' => 17.00, 'tag' => 'chef', 'icon' => '🍕', 'img' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=700&q=80', 'title' => ['az' => 'Quattro Formaggi Pizzası', 'en' => 'Stone-Baked 4-Cheese Pizza', 'tr' => 'Taş Fırın Dört Peynirli Pizza', 'ru' => 'Пицца 4 сыра из печи'], 'desc' => ['az' => 'Motsarella, Qorqonzola, Parmezan və Rikkota pendirləri.', 'en' => 'Mozzarella, gorgonzola dolce, aged parmigiano and ricotta.', 'tr' => 'Mozzarella, gorgonzola, parmesan ve ricotta peynirleri.', 'ru' => 'Моцарелла, горгонзола, пармезан и рикотта на тонком тесте.']],
  ['id' => 107, 'cat' => 'desserts', 'price' => 9.50, 'tag' => 'chef', 'icon' => '🍰', 'img' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=700&q=80', 'title' => ['az' => 'San Sebastian Çizkeyk', 'en' => 'San Sebastian Cheesecake', 'tr' => 'San Sebastian Cheesecake', 'ru' => 'Чизкейк Сан-Себастьян'], 'desc' => ['az' => 'Krem tekstura, qızılı qabıq və isti Belçika şokoladı.', 'en' => 'Silky molten center served with hot Belgian chocolate.', 'tr' => 'Akışkan kremsi doku ve sıcak Belçika çikolatası.', 'ru' => 'Нежная текстура с карамельной корочкой и горячим шоколадом.']],
  ['id' => 108, 'cat' => 'drinks', 'price' => 6.50, 'tag' => '', 'icon' => '🍹', 'img' => 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=700&q=80', 'title' => ['az' => 'Marakuya & Nanəli Limonad', 'en' => 'Passion Fruit & Mint Breeze', 'tr' => 'Çarkıfelek & Naneli Limonata', 'ru' => 'Лимонад Маракуйя-Мята'], 'desc' => ['az' => 'Təbii marakuya püresi, təzə nanə, laym və buzlu qazlı su.', 'en' => 'Real passion fruit puree, fresh mint, lime and sparkling water.', 'tr' => 'Doğal çarkıfelek meyvesi, taze nane yaprakları ve ferahlatıcı soda.', 'ru' => 'Пюре маракуйи, свежая мята, сок лайма и родниковая вода.']],
];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($t['brand_name']) ?> — <?= e(sky_literal_translate('Skyweb Food Demo')) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: rgba(0, 32, 40, 0.85);
      --sky-border: rgba(0, 255, 255, 0.18);
      --neon-cyan: #00FFFF;
      --neon-gold: #ffb703;
      --neon-glow: 0 0 20px rgba(0, 255, 255, 0.35);
      --text-main: #f0fefe;
      --text-muted: #8ec5c5;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: linear-gradient(180deg, #001515 0%, #001f22 30%, #002b33 70%, #001417 100%); color: var(--text-main); font-family: var(--font-body); min-height: 100vh; line-height: 1.6; }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }
    .demo-bar { background: rgba(0, 22, 22, 0.95); border-bottom: 1px solid var(--sky-border); padding: 8px 16px; font-size: 13px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 10px; position: sticky; top: 0; z-index: 1000; backdrop-filter: blur(12px); }
    .demo-badge { background: rgba(0, 255, 255, 0.15); color: var(--neon-cyan); border: 1px solid var(--neon-cyan); border-radius: 20px; padding: 2px 10px; font-weight: 700; font-size: 11px; text-transform: uppercase; box-shadow: var(--neon-glow); }
    .demo-btn-sky { background: var(--neon-cyan); color: #001a1a; padding: 4px 12px; border-radius: 6px; font-weight: 700; font-size: 12px; transition: 0.25s; }
    .demo-btn-sky:hover { box-shadow: var(--neon-glow); transform: translateY(-1px); }
    .demo-btn-back { color: var(--text-muted); font-size: 12px; font-weight: 600; padding: 4px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1); }
    .lang-pills { display: flex; gap: 4px; background: rgba(0,0,0,0.4); padding: 2px; border-radius: 6px; }
    .lang-pill { font-size: 11px; padding: 2px 7px; border-radius: 4px; color: var(--text-muted); font-weight: 600; text-transform: uppercase; }
    .lang-pill.active { background: var(--neon-cyan); color: #001a1a; }
    .resto-nav { background: rgba(0, 20, 24, 0.88); border-bottom: 1px solid rgba(0, 255, 255, 0.12); backdrop-filter: blur(16px); padding: 14px 24px; position: sticky; top: 41px; z-index: 900; }
    .nav-wrap { max-width: 1240px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; }
    .brand-title { font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: #fff; line-height: 1.1; }
    .brand-title span { font-size: 10px; letter-spacing: 2px; color: var(--neon-cyan); font-weight: 600; text-transform: uppercase; display: block; }
    .btn-reserve-nav { background: transparent; border: 1px solid var(--neon-gold); color: var(--neon-gold); padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 700; transition: 0.25s; }
    .btn-reserve-nav:hover { background: var(--neon-gold); color: #001a1a; box-shadow: 0 0 15px rgba(255,183,3,0.4); }
    .cart-btn-header { background: rgba(0, 255, 255, 0.1); border: 1px solid var(--sky-border); color: var(--neon-cyan); padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 8px; }
    .cart-pill { background: var(--neon-cyan); color: #001a1a; font-size: 11px; font-weight: 800; padding: 1px 7px; border-radius: 12px; }
    .resto-hero { max-width: 1240px; margin: 0 auto; padding: 60px 24px 40px; display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 40px; align-items: center; }
    .hero-fire-tag { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; letter-spacing: 2px; color: var(--neon-gold); background: rgba(255, 183, 3, 0.12); border: 1px solid rgba(255, 183, 3, 0.3); padding: 5px 14px; border-radius: 30px; margin-bottom: 16px; }
    .hero-food-h1 { font-family: var(--font-heading); font-size: clamp(32px, 5vw, 54px); line-height: 1.15; font-weight: 900; color: #fff; margin-bottom: 16px; }
    .hero-food-h1 .glow-cyan { color: var(--neon-cyan); text-shadow: 0 0 25px rgba(0,255,255,0.4); }
    .hero-food-desc { color: var(--text-muted); font-size: 15px; line-height: 1.7; margin-bottom: 24px; max-width: 500px; }
    .hero-actions-row { display: flex; flex-wrap: wrap; gap: 14px; align-items: center; margin-bottom: 20px; }
    .btn-main-cyan { background: linear-gradient(135deg, var(--neon-cyan) 0%, #00b4d8 100%); color: #001a1a; font-weight: 700; font-size: 14px; padding: 12px 24px; border-radius: 10px; border: none; box-shadow: 0 0 25px rgba(0,255,255,0.4); }
    .btn-book-table { background: rgba(255, 183, 3, 0.15); border: 1px solid var(--neon-gold); color: var(--neon-gold); font-weight: 700; font-size: 14px; padding: 12px 24px; border-radius: 10px; transition: 0.25s; }
    .btn-book-table:hover { background: var(--neon-gold); color: #001a1a; }
    .hero-special-plate { background: linear-gradient(145deg, rgba(0, 40, 48, 0.8), rgba(0, 20, 24, 0.95)); border: 1px solid var(--sky-border); border-radius: 24px; padding: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.6); }
    .hero-plate-img { height: 250px; border-radius: 16px; overflow: hidden; margin-bottom: 14px; position: relative; }
    .hero-plate-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; display: block; }
    .hero-special-plate:hover .hero-plate-img img { transform: scale(1.05); }
    .menu-section { max-width: 1240px; margin: 20px auto 60px; padding: 0 24px; }
    .menu-tabs { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 30px; }
    .tab-btn { background: rgba(0, 30, 36, 0.7); border: 1px solid rgba(0, 255, 255, 0.15); color: var(--text-muted); padding: 7px 18px; border-radius: 30px; font-size: 13px; font-weight: 600; transition: 0.2s; }
    .tab-btn.active, .tab-btn:hover { background: var(--neon-cyan); color: #001a1a; border-color: var(--neon-cyan); box-shadow: 0 0 15px rgba(0,255,255,0.4); }
    .dishes-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 24px; }
    .dish-card { background: var(--sky-card); border: 1px solid var(--sky-border); border-radius: 18px; padding: 16px; display: flex; flex-direction: column; position: relative; transition: 0.25s; overflow: hidden; }
    .dish-card:hover { transform: translateY(-5px); border-color: var(--neon-cyan); box-shadow: 0 12px 30px rgba(0,0,0,0.5), 0 0 20px rgba(0,255,255,0.2); }
    .dish-tag-badge { position: absolute; top: 12px; left: 12px; font-size: 11px; font-weight: 700; padding: 3px 9px; border-radius: 12px; z-index: 2; backdrop-filter: blur(4px); }
    .tag-chef { background: rgba(0, 20, 25, 0.85); border: 1px solid var(--neon-gold); color: var(--neon-gold); }
    .tag-spicy { background: rgba(0, 20, 25, 0.85); border: 1px solid #ff3366; color: #ff3366; }
    .dish-icon-box { height: 180px; border-radius: 12px; overflow: hidden; margin-bottom: 14px; position: relative; background: #00252d; }
    .dish-icon-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; display: block; }
    .dish-card:hover .dish-icon-box img { transform: scale(1.06); }
    .dish-title { font-family: var(--font-heading); font-size: 17px; font-weight: 700; color: #fff; margin-bottom: 6px; }
    .dish-desc { font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 16px; flex: 1; }
    .dish-bottom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 12px; border-top: 1px solid rgba(0,255,255,0.1); }
    .dish-price { font-size: 19px; font-weight: 800; color: #fff; }
    .dish-price span { color: var(--neon-cyan); font-size: 13px; }
    .btn-add-food { background: rgba(0, 255, 255, 0.12); border: 1px solid var(--neon-cyan); color: var(--neon-cyan); padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; transition: 0.2s; }
    .btn-add-food:hover { background: var(--neon-cyan); color: #001a1a; box-shadow: 0 0 15px rgba(0,255,255,0.4); }
    .delivery-section { background: rgba(0, 24, 30, 0.6); border-top: 1px solid var(--sky-border); border-bottom: 1px solid var(--sky-border); padding: 40px 24px; margin-bottom: 60px; }
    .deliv-grid { max-width: 1240px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px; }
    .deliv-item { background: rgba(0, 32, 40, 0.7); border: 1px solid rgba(0,255,255,0.15); border-radius: 14px; padding: 18px; text-align: center; font-weight: 600; color: #fff; font-size: 14px; }
    .cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 2000; opacity: 0; visibility: hidden; transition: 0.3s; }
    .cart-overlay.active { opacity: 1; visibility: visible; }
    .cart-drawer-box { position: fixed; top: 0; right: -420px; width: 100%; max-width: 380px; height: 100%; background: #001a1a; border-left: 1px solid var(--sky-border); z-index: 2001; display: flex; flex-direction: column; transition: right 0.35s ease; box-shadow: -10px 0 40px rgba(0,0,0,0.7); }
    .cart-drawer-box.active { right: 0; }
    .cart-header { padding: 18px; border-bottom: 1px solid rgba(0,255,255,0.15); display: flex; justify-content: space-between; align-items: center; color: #fff; font-family: var(--font-heading); }
    .cart-items-body { flex: 1; padding: 18px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px; }
    .cart-item { display: flex; align-items: center; gap: 10px; background: rgba(0, 32, 40, 0.5); border: 1px solid rgba(0,255,255,0.1); border-radius: 10px; padding: 10px; font-size: 13px; }
    .cart-footer { padding: 18px; border-top: 1px solid rgba(0,255,255,0.15); background: rgba(0, 20, 25, 0.95); }
    .btn-wa-order { width: 100%; background: #25d366; color: #001a1a; border: none; padding: 13px; border-radius: 10px; font-weight: 800; font-size: 14px; margin-top: 12px; }
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); z-index: 2500; opacity: 0; visibility: hidden; display: flex; align-items: center; justify-content: center; padding: 20px; transition: 0.3s; }
    .modal-backdrop.active { opacity: 1; visibility: visible; }
    .modal-content { background: #001f24; border: 1px solid var(--neon-gold); border-radius: 20px; max-width: 440px; width: 100%; padding: 24px; position: relative; }
    .form-ctrl { width: 100%; background: rgba(0,0,0,0.4); border: 1px solid rgba(0,255,255,0.2); border-radius: 8px; padding: 10px 12px; color: #fff; font-family: inherit; font-size: 13px; margin-top: 4px; margin-bottom: 12px; outline: none; }
    .btn-submit-booking { width: 100%; background: var(--neon-gold); color: #001a1a; border: none; padding: 12px; border-radius: 8px; font-weight: 800; font-size: 14px; }
    .floating-box { position: fixed; bottom: 24px; right: 24px; display: flex; flex-direction: column; gap: 10px; z-index: 1500; }
    .float-round { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; border: none; box-shadow: 0 8px 24px rgba(0,0,0,0.5); }
    .toast-notice { position: fixed; bottom: 85px; left: 50%; transform: translateX(-50%) translateY(40px); background: rgba(0, 32, 40, 0.95); border: 1px solid var(--neon-cyan); color: #fff; padding: 10px 20px; border-radius: 30px; font-size: 13px; font-weight: 600; opacity: 0; visibility: hidden; transition: 0.3s; z-index: 3000; }
    .toast-notice.show { transform: translateX(-50%) translateY(0); opacity: 1; visibility: visible; }
    .resto-footer { background: #001114; border-top: 1px solid var(--sky-border); padding: 40px 24px 24px; text-align: center; }
    @media (max-width: 850px) { .resto-hero { grid-template-columns: 1fr; text-align: center; } .hero-actions-row { justify-content: center; } }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="food" data-dk-accent="#f97316" data-dk-phone="994503936998" data-dk-sticky data-dk-action="checkoutFoodWhatsApp" data-dk-sticky-label="Sifariş">
  <script src="assets/demo-kit.js"></script>

  <!-- Top Demo Banner -->
  <div class="demo-bar">
    <div style="display:flex; align-items:center; gap:8px;">
      <span class="demo-badge">SKYWEB DEMO</span>
      <span style="color:var(--text-muted); font-weight:500;"><?= htmlspecialchars($t['demo_banner']) ?></span>
    </div>
    <div style="display:flex; align-items:center; gap:10px;">
      <div class="lang-pills">
        <a href="?lang=az" class="lang-pill <?= $lang === 'az' ? 'active' : '' ?>">AZ</a>
        <a href="?lang=en" class="lang-pill <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
        <a href="?lang=tr" class="lang-pill <?= $lang === 'tr' ? 'active' : '' ?>">TR</a>
        <a href="?lang=ru" class="lang-pill <?= $lang === 'ru' ? 'active' : '' ?>">RU</a>
      </div>
      <a href="../../index.php?lang=<?= htmlspecialchars($lang) ?>#contact" class="demo-btn-sky"><?= htmlspecialchars($t['order_site']) ?> →</a>
      <a href="../../index.php?lang=<?= htmlspecialchars($lang) ?>" class="demo-btn-back">← <?= htmlspecialchars($t['back_to_sky']) ?></a>
    </div>
  </div>

  <!-- Navbar -->
  <nav class="resto-nav">
    <div class="nav-wrap">
      <div class="brand-title">
        <?= htmlspecialchars($t['brand_name']) ?>
        <span><?= htmlspecialchars($t['brand_sub']) ?></span>
      </div>
      <div style="display:flex; align-items:center; gap:10px;">
        <button class="btn-reserve-nav" onclick="openReservationModal()"><?= htmlspecialchars($t['nav_reserve']) ?></button>
        <button class="cart-btn-header" onclick="toggleCartDrawer()">
          <span>🛍️</span><span class="cart-pill" id="cartTopCount">0</span>
        </button>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="resto-hero">
    <div>
      <span class="hero-fire-tag"><?= htmlspecialchars($t['hero_tag']) ?></span>
      <h1 class="hero-food-h1"><?= htmlspecialchars($t['hero_title_1']) ?><br><span class="glow-cyan"><?= htmlspecialchars($t['hero_title_2']) ?></span></h1>
      <p class="hero-food-desc"><?= htmlspecialchars($t['hero_desc']) ?></p>
      <div class="hero-actions-row">
        <a href="#menu" class="btn-main-cyan"><?= htmlspecialchars($t['hero_btn_menu']) ?> ↓</a>
        <button class="btn-book-table" onclick="openReservationModal()"><?= htmlspecialchars($t['hero_btn_reserve']) ?></button>
      </div>
      <div style="font-size:12px; color:var(--neon-cyan); font-weight:600;"><?= htmlspecialchars($t['hero_delivery_note']) ?></div>
    </div>
    <div>
      <div class="hero-special-plate">
        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
          <span class="dish-tag-badge tag-chef">⭐ TOP RATED</span>
          <span style="font-size:12px; color:var(--neon-cyan); font-weight:700;">CHEF SPECIAL</span>
        </div>
        <div class="hero-plate-img">
          <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=700&q=80" alt="Black Angus Truffle Burger" loading="lazy">
        </div>
        <div style="display:flex; justify-content:space-between; font-weight:700; font-size:15px; color:#fff;">
          <span>Black Angus Truffle</span>
          <span style="color:var(--neon-cyan);">16.50 AZN</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Digital Menu -->
  <section class="menu-section" id="menu">
    <div class="menu-tabs">
      <button class="tab-btn active" onclick="filterMenu('all', this)"><?= htmlspecialchars($t['filter_all']) ?></button>
      <button class="tab-btn" onclick="filterMenu('starters', this)"><?= htmlspecialchars($t['filter_starters']) ?></button>
      <button class="tab-btn" onclick="filterMenu('mains', this)"><?= htmlspecialchars($t['filter_mains']) ?></button>
      <button class="tab-btn" onclick="filterMenu('fast', this)"><?= htmlspecialchars($t['filter_fast']) ?></button>
      <button class="tab-btn" onclick="filterMenu('desserts', this)"><?= htmlspecialchars($t['filter_desserts']) ?></button>
      <button class="tab-btn" onclick="filterMenu('drinks', this)"><?= htmlspecialchars($t['filter_drinks']) ?></button>
    </div>

    <div class="dishes-grid">
      <?php foreach ($dishes as $d): ?>
        <?php $title = $d['title'][$lang] ?? $d['title']['az']; $desc = $d['desc'][$lang] ?? $d['desc']['az']; ?>
        <div class="dish-card" data-cat="<?= $d['cat'] ?>">
          <?php if ($d['tag'] === 'chef'): ?>
            <span class="dish-tag-badge tag-chef">⭐ <?= htmlspecialchars($t['chef_pick']) ?></span>
          <?php elseif ($d['tag'] === 'spicy'): ?>
            <span class="dish-tag-badge tag-spicy">🌶️ <?= htmlspecialchars($t['spicy']) ?></span>
          <?php endif; ?>
          <div class="dish-icon-box">
            <img src="<?= htmlspecialchars($d['img']) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
          </div>
          <h3 class="dish-title"><?= htmlspecialchars($title) ?></h3>
          <p class="dish-desc"><?= htmlspecialchars($desc) ?></p>
          <div class="dish-bottom">
            <span class="dish-price"><?= number_format($d['price'], 2) ?> <span>AZN</span></span>
            <button class="btn-add-food" onclick="addDishToCart(<?= $d['id'] ?>, '<?= htmlspecialchars(addslashes($title)) ?>', <?= $d['price'] ?>, '<?= htmlspecialchars(addslashes($d['img'])) ?>')">
              + <?= htmlspecialchars($t['btn_add_dish']) ?>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Delivery Info -->
  <div class="delivery-section">
    <div class="deliv-grid">
      <div class="deliv-item"><?= htmlspecialchars($t['deliv_1']) ?></div>
      <div class="deliv-item"><?= htmlspecialchars($t['deliv_2']) ?></div>
      <div class="deliv-item"><?= htmlspecialchars($t['deliv_3']) ?></div>
    </div>
  </div>

  <!-- Cart Drawer -->
  <div class="cart-overlay" id="cartOverlay" onclick="toggleCartDrawer()"></div>
  <aside class="cart-drawer-box" id="cartDrawer">
    <div class="cart-header">
      <h3><?= htmlspecialchars($t['cart_title']) ?></h3>
      <button style="background:none; border:none; color:var(--text-muted); font-size:20px;" onclick="toggleCartDrawer()">✕</button>
    </div>
    <div class="cart-items-body" id="cartItemsList">
      <div style="text-align:center; padding: 40px 10px; color:var(--text-muted);" id="emptyCartNotice">
        <div style="font-size:36px; margin-bottom:8px;">🍽️</div>
        <?= htmlspecialchars($t['cart_empty']) ?>
      </div>
    </div>
    <div class="cart-footer">
      <div class="dk-field" style="margin-bottom:10px;">
        <label class="dk-label" for="zoneSelect"><?= htmlspecialchars($t['deliv_1']) ?></label>
        <select class="dk-select" id="zoneSelect" onchange="renderFoodCart()">
          <option value="3">Bakı mərkəzi — 3 AZN (40 AZN-dən pulsuz)</option>
          <option value="5">Bakı ətrafı — 5 AZN</option>
          <option value="8">Abşeron / Sumqayıt — 8 AZN</option>
        </select>
      </div>
      <div class="dk-ship" id="foodShipNote"></div>
      <div style="display:flex; justify-content:space-between; font-weight:700; color:#fff; margin-top:10px; font-size:13px;">
        <span><?= htmlspecialchars($t['cart_total']) ?></span>
        <span style="color:var(--neon-cyan); font-size:20px;" id="cartTotalVal">0.00 AZN</span>
      </div>
      <button class="btn-wa-order" onclick="checkoutFoodWhatsApp()">💬 <?= htmlspecialchars($t['btn_checkout_wa']) ?></button>
    </div>
  </aside>

  <!-- Reservation Modal -->
  <div class="modal-backdrop" id="reserveModal">
    <div class="modal-content">
      <button style="position:absolute; top:14px; right:14px; background:none; border:none; color:var(--text-muted); font-size:20px;" onclick="closeReservationModal()">✕</button>
      <h3 style="font-family:var(--font-heading); color:#fff; font-size:20px; margin-bottom:4px;"><?= htmlspecialchars($t['res_title']) ?></h3>
      <p style="color:var(--text-muted); font-size:12px; margin-bottom:14px;"><?= htmlspecialchars($t['res_desc']) ?></p>
      <form onsubmit="handleReserveSubmit(event)">
        <input type="text" class="form-ctrl" required placeholder="<?= htmlspecialchars($t['input_name']) ?>" id="resName">
        <input type="tel" class="form-ctrl" required placeholder="<?= htmlspecialchars($t['input_phone']) ?>" id="resPhone">
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
          <select class="form-ctrl" id="resGuests">
            <option value="2"><?= htmlspecialchars($t['guests_2']) ?></option>
            <option value="4"><?= htmlspecialchars($t['guests_4']) ?></option>
            <option value="6"><?= htmlspecialchars($t['guests_6']) ?></option>
          </select>
          <input type="time" class="form-ctrl" value="19:30" id="resTime">
        </div>
        <button type="submit" class="btn-submit-booking"><?= htmlspecialchars($t['res_btn']) ?></button>
      </form>
    </div>
  </div>

  <!-- Floating Buttons -->
  <div class="floating-box">
    <button class="float-round" style="background:var(--neon-cyan); color:#001a1a; position:relative;" onclick="toggleCartDrawer()" title="Səbət">
      🛍️<span style="position:absolute; top:-4px; right:-4px; background:#ff3366; color:#fff; font-size:11px; font-weight:800; width:18px; height:18px; border-radius:50%; display:flex; align-items:center; justify-content:center;" id="cartFloatCount">0</span>
    </button>
    <button class="float-round" style="background:#25d366; color:#fff;" onclick="window.open('https://wa.me/994503936998?text=Salam,%20Gusto%20Restobar%20sualım%20var', '_blank')" title="WhatsApp">💬</button>
  </div>

  <div class="toast-notice" id="foodToast">Əlavə olundu!</div>

  <!-- Footer -->
  <footer class="resto-footer">
    <div style="font-family:var(--font-heading); font-size:22px; font-weight:800; color:#fff; margin-bottom:6px;"><?= htmlspecialchars($t['brand_name']) ?></div>
    <p style="color:var(--text-muted); font-size:13px; max-width:600px; margin:0 auto 16px;"><?= htmlspecialchars($t['footer_desc']) ?></p>
    <div style="font-size:12px; color:rgba(255,255,255,0.4);">© 2026 <?= htmlspecialchars($t['brand_name']) ?>. Crafted with ⚡ by Skyweb.az</div>
  </footer>

  <script>
    /* ── Gusto Restobar · səbət + çatdırılma zonası + rezervasiya ── */
    const MIN_ORDER = 15;
    const FREE_FROM = 40;
    const foodCart = DK.cart('food-cart', function () { renderFoodCart(); });

    function toggleCartDrawer() {
      document.getElementById('cartOverlay').classList.toggle('active');
      document.getElementById('cartDrawer').classList.toggle('active');
    }
    function showToast(text) { DK.toast(text); }

    function addDishToCart(id, title, price, icon) {
      foodCart.add({ id: id, title: title, price: price, img: String(icon).indexOf('http') === 0 ? icon : '' }, 1);
      DK.toast(title + ' — ' + DK.t.added);
    }

    function setFoodQty(id, dir) {
      const item = foodCart.items.find(function (i) { return String(i.id) === String(id); });
      if (!item) return;
      foodCart.setQty(id, '', item.qty + dir);
    }

    function removeDishFromCart(id) {
      foodCart.remove(id, '');
      DK.toast(DK.t.removed, 'info');
    }

    function zoneFee(subtotal) {
      const sel = document.getElementById('zoneSelect');
      const zone = sel ? Number(sel.value) : 3;
      return subtotal >= FREE_FROM ? 0 : zone;
    }

    function renderFoodCart() {
      const container = document.getElementById('cartItemsList');
      const totalEl = document.getElementById('cartTotalVal');
      const items = foodCart.items;
      const subtotal = foodCart.total();
      const fee = zoneFee(subtotal);
      const grand = subtotal + fee;

      const top = document.getElementById('cartTopCount');
      if (top) top.textContent = foodCart.count();

      if (!items.length) {
        container.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">🍽️</span>' + DK.esc(DK.t.emptyCart) + '</div>';
        totalEl.textContent = '0.00 AZN';
      } else {
        container.innerHTML = items.map(function (i) {
          return '<div class="cart-item">' +
            (i.img ? '<img src="' + DK.esc(i.img) + '" alt="" style="width:48px;height:48px;border-radius:8px;object-fit:cover">' : '<span style="font-size:24px">🍽️</span>') +
            '<div style="flex:1;min-width:0"><div style="color:#fff;font-weight:600">' + DK.esc(i.title) + '</div>' +
            '<div style="color:var(--neon-cyan);font-size:12px">' + i.qty + ' × ' + i.price.toFixed(2) + ' AZN</div></div>' +
            '<div class="dk-qty">' +
              '<button class="dk-qty__btn" onclick="setFoodQty(' + i.id + ', -1)" aria-label="−">−</button>' +
              '<span class="dk-qty__val">' + i.qty + '</span>' +
              '<button class="dk-qty__btn" onclick="setFoodQty(' + i.id + ', 1)" aria-label="+">+</button>' +
            '</div>' +
            '<button style="background:none;border:none;color:#ff4d6d;font-size:15px;cursor:pointer" onclick="removeDishFromCart(' + i.id + ')" aria-label="Sil">✕</button>' +
          '</div>';
        }).join('');

        totalEl.innerHTML = '<span style="font-size:12px;color:#8ec5c5;display:block;font-weight:600">' +
          subtotal.toFixed(2) + ' + ' + fee.toFixed(2) + ' ' + DK.pick('çatdırılma', 'delivery', 'доставка', 'teslimat') + '</span>' +
          grand.toFixed(2) + ' AZN';
      }

      const note = document.getElementById('foodShipNote');
      if (note) {
        const left = FREE_FROM - subtotal;
        note.innerHTML = left > 0
          ? '<b>' + left.toFixed(2) + ' AZN</b> ' + DK.esc(DK.t.freeShip) +
            '<div class="dk-track"><i style="width:' + Math.min(100, (subtotal / FREE_FROM) * 100) + '%"></i></div>'
          : DK.esc(DK.t.freeShipDone);
      }
    }

    function filterMenu(cat, btn) {
      document.querySelectorAll('.tab-btn').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      document.querySelectorAll('.dish-card').forEach(function (c) {
        c.style.display = (cat === 'all' || c.getAttribute('data-cat') === cat) ? 'flex' : 'none';
      });
    }

    function openReservationModal() {
      DK.sheet({
        eyebrow: DK.pick('MASA REZERVİ', 'TABLE BOOKING', 'БРОНЬ СТОЛА', 'MASA REZERVASYONU'),
        title: '<?= htmlspecialchars(addslashes($t['res_title'])) ?>',
        sub: '<?= htmlspecialchars(addslashes($t['res_desc'])) ?>',
        submitText: '<?= htmlspecialchars(addslashes($t['res_btn'])) ?>',
        submitIcon: '💬',
        fields: [
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'guests', label: DK.pick('Qonaq sayı', 'Guests', 'Гостей', 'Kişi sayısı'), type: 'select', required: true, options: ['2', '4', '6', '8+'] },
          { name: 'date', label: DK.t.date, type: 'date', min: new Date().toISOString().slice(0, 10), required: true },
          { name: 'time', label: DK.t.time, type: 'time', value: '19:30', required: true },
          { name: 'note', label: DK.t.note, type: 'textarea', rows: 2, placeholder: DK.t.notePh }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast('<?= htmlspecialchars(addslashes($t['toast_reserved'])) ?>');
        DK.wa('Salam! Gusto Restobar — masa rezervi:\nAd: ' + d.name +
          '\nTel: +994 ' + DK.fmtPhone(d.phone) + '\nQonaq: ' + d.guests +
          '\nTarix: ' + d.date + '\nSaat: ' + d.time + (d.note ? '\nQeyd: ' + d.note : ''));
      });
    }
    function closeReservationModal() { DK.closeSheet(); }
    function handleReserveSubmit(ev) { if (ev) ev.preventDefault(); openReservationModal(); }

    function checkoutFoodWhatsApp() {
      if (!foodCart.items.length) return DK.toast(DK.t.emptyCart, 'err');
      const subtotal = foodCart.total();
      if (subtotal < MIN_ORDER) {
        DK.toast(DK.pick('Minimum sifariş ' + MIN_ORDER + ' AZN-dir', 'Minimum order is ' + MIN_ORDER + ' AZN', 'Минимальный заказ ' + MIN_ORDER + ' AZN', 'Minimum sipariş ' + MIN_ORDER + ' AZN'), 'err');
        return;
      }
      const sel = document.getElementById('zoneSelect');
      const zoneName = sel ? sel.options[sel.selectedIndex].text.split('—')[0].trim() : 'Bakı';
      const fee = zoneFee(subtotal);
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: 'Gusto Restobar',
        items: foodCart.items,
        addressRequired: true,
        summary: 'Zona: ' + zoneName + ' · ' + DK.pick('Çatdırılma: ', 'Delivery: ', 'Доставка: ', 'Teslimat: ') + (fee ? fee.toFixed(2) + ' AZN' : DK.pick('pulsuz', 'free', 'бесплатно', 'ücretsiz'))
      }).then(function (d) {
        if (!d) return;
        foodCart.clear();
        toggleCartDrawer();
      });
    }

    renderFoodCart();
  </script>
</body>
</html>
