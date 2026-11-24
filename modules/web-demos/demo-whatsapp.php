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
    'brand_name' => 'BAZAR PRO',
    'brand_sub' => 'WhatsApp ilə Sürətli Ticarət',
    'op_status' => 'Operator Onlayndır • 1 dəqiqəyə cavab',
    'nav_catalog' => 'Kataloq',
    'nav_how' => 'Necə İşləyir?',
    'nav_reviews' => 'Müştəri Rəyləri',
    'nav_contact' => 'Əlaqə & Qrafik',
    'hero_badge' => '⚡ 1 KLİKLƏ WHATSAPP SİFARİŞİ',
    'hero_title_1' => 'Qeydiyyatsız, Gözləmədən,',
    'hero_title_2' => 'Birbaşa WhatsApp-da Sifariş!',
    'hero_desc' => 'Bəyəndiyiniz məhsulun üzərinə vurun, birbaşa operatorumuzla WhatsApp-da əlaqə saxlayın. Bakı daxili qapıda ödəmə və sürətli kuryer çatdırılması.',
    'hero_cta' => 'Məhsulları Seçin',
    'hero_direct_chat' => 'Operatora Birbaşa Yaz',
    'filter_all' => 'Bütün Qadjetlər',
    'filter_smart' => 'Ağıllı Saat & Qulaqlıq',
    'filter_auto' => 'Avto Aksesuarlar',
    'filter_home' => 'Ev & Gündəlik',
    'btn_order_wa' => 'WhatsApp-la Sifariş Et',
    'stock_ready' => 'Anbarda Var • Sürətli Göndəriş',
    'info_title' => 'İş Rejimi və Çatdırılma Şərtləri',
    'hours_label' => 'İş Saatları:',
    'hours_val' => 'Hər gün 09:00 - 23:00 (Fasiləsiz)',
    'baku_deliv' => 'Bakı daxili:',
    'baku_deliv_val' => '2-3 saat ərzində birbaşa ünvana kuryer',
    'region_deliv' => 'Bölgələrə:',
    'region_deliv_val' => 'Azərpoçt və ya rayon taksiləri ilə 24 saata çatdırılma',
    'pay_label' => 'Ödəniş:',
    'pay_val' => 'Məhsulu təhvil alarkən nağd və ya kartla (Qapıda ödəniş)',
    'reviews_title' => 'WhatsApp Rəyləri',
    'reviews_sub' => 'Real alıcılarımızın WhatsApp-dan göndərdiyi rəylər',
    'faq_title' => 'Tez-tez Verilən Suallar',
    'faq_q1' => 'Məhsulu alarkən necə ödəyirəm?',
    'faq_a1' => 'Kuryer məhsulu gətirəndə yerindəcə yoxlayır, bəyəndikdən sonra nağd və ya karta köçürmə ilə ödəyirsiniz.',
    'faq_q2' => 'Məhsullara zəmanət varmı?',
    'faq_a2' => 'Bəli, bütün elektron cihazlarımıza 14 gün yoxlama və dəyişdirmə zəmanəti təqdim olunur.',
    'faq_q3' => 'WhatsApp-da sifariş verəndən sonra nə baş verir?',
    'faq_a3' => 'Operatorumuz 1-2 dəqiqə ərzində cavab verir, çatdırılma ünvanınızı və əlaqə nömrənizi təsdiqləyib kuryerə yönləndirir.',
    'footer_desc' => 'Bazar Pro — kiçik və orta bizneslər üçün WhatsApp əsaslı rəqəmsal vitrin modeli. Skyweb.az tərəfindən hazırlanmışdır.',
    'footer_rights' => 'Bütün hüquqlar qorunur.',
    'review_verified' => '✓ Təsdiqlənmiş Alıcı',
    'review_1_text' => '"Salam, saat bu gün çatdı! Çox sağ olun, keyfiyyəti gözlədiyimdən də əla çıxdı, zənglər çox aydın eşidilir. Kuryer də tez gətirdi."',
    'review_2_text' => '"Mini projektoru aldıq, uşaqlar üçün axşamlar cizgi filmi açırıq, tavanı böyük kinoteatra çevirdi! Qapıda yoxlayıb pulunu verdik, təşəkkürlər!"',
    'review_3_text' => '"Maşın tutacağı çox möhkəmdir, telefonu qoyan kimi dərhal tutur və sürətli doldurur. Əsl tapıntıdır, dostlarıma da məsləhət gördüm."',
  ],
  'en' => [
    'demo_banner' => 'This is a demo website — Created by Skyweb',
    'back_to_sky' => 'Back to Skyweb',
    'order_site' => 'Order This Website',
    'brand_name' => 'BAZAR PRO',
    'brand_sub' => 'Fast WhatsApp Commerce',
    'op_status' => 'Operator Online • Replies in 1 min',
    'nav_catalog' => 'Catalog',
    'nav_how' => 'How it Works',
    'nav_reviews' => 'Customer Reviews',
    'nav_contact' => 'Hours & Delivery',
    'hero_badge' => '⚡ 1-CLICK WHATSAPP COMMERCE',
    'hero_title_1' => 'No Sign-Up, No Friction,',
    'hero_title_2' => 'Instant WhatsApp Checkout!',
    'hero_desc' => 'Tap any product and connect straight to WhatsApp with pre-filled order specs. Cash on delivery across Baku with rapid dispatch.',
    'hero_cta' => 'Browse Catalog',
    'hero_direct_chat' => 'Chat with Operator',
    'filter_all' => 'All Gadgets',
    'filter_smart' => 'Wearables & Audio',
    'filter_auto' => 'Auto Gadgets',
    'filter_home' => 'Home & Lifestyle',
    'btn_order_wa' => 'Order via WhatsApp',
    'stock_ready' => 'In Stock • Ready to Ship',
    'info_title' => 'Operating Hours & Dispatch Terms',
    'hours_label' => 'Working Hours:',
    'hours_val' => 'Daily 09:00 - 23:00 (No days off)',
    'baku_deliv' => 'Baku Delivery:',
    'baku_deliv_val' => 'Within 2-3 hours straight to your doorstep',
    'region_deliv' => 'Regions:',
    'region_deliv_val' => 'National Post / Express Taxi within 24 hours',
    'pay_label' => 'Payment Method:',
    'pay_val' => 'Cash or Card upon physical delivery (Risk-Free)',
    'reviews_title' => 'WhatsApp Testimonials',
    'reviews_sub' => 'Unfiltered chats from our verified satisfied customers',
    'faq_title' => 'Frequently Asked Questions',
    'faq_q1' => 'How do I pay for my order?',
    'faq_a1' => 'You inspect the item when the courier arrives, then pay cash or card on delivery.',
    'faq_q2' => 'Do products include a warranty?',
    'faq_a2' => 'Yes, 14-day replacement and inspection guarantee on all electronic items.',
    'faq_q3' => 'What happens after I send a WhatsApp message?',
    'faq_a3' => 'Our live operator replies in 1-2 minutes, confirms your address and dispatches your courier.',
    'footer_desc' => 'Bazar Pro — direct WhatsApp ordering engine for modern retail. Designed and developed by Skyweb.az.',
    'footer_rights' => 'All rights reserved.',
    'review_verified' => '✓ Verified Buyer',
    'review_1_text' => '"Hello, the watch arrived today! Thank you so much, the build quality exceeded my expectations and calls are crystal clear. Fast delivery!"',
    'review_2_text' => '"Got the mini projector, we put on cartoons for the kids in the evening, turned the ceiling into a home theater! Tested and paid at the door, thanks!"',
    'review_3_text' => '"The car mount is rock solid, auto-clamps the phone instantly and charges very fast. Great find, recommended it to my friends."',
  ],
  'tr' => [
    'demo_banner' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
    'back_to_sky' => 'Skyweb\'e Dön',
    'order_site' => 'Bu Siteyi Sipariş Et',
    'brand_name' => 'BAZAR PRO',
    'brand_sub' => 'WhatsApp ile Hızlı Alışveriş',
    'op_status' => 'Müşteri Temsilcisi Çevrimiçi • 1 dk yanıt',
    'nav_catalog' => 'Katalog',
    'nav_how' => 'Nasıl Çalışır?',
    'nav_reviews' => 'Müşteri Yorumları',
    'nav_contact' => 'Çalışma Saatleri',
    'hero_badge' => '⚡ TEK TIKLA WHATSAPP SİPARİŞİ',
    'hero_title_1' => 'Üyeliksiz, Beklemeden,',
    'hero_title_2' => 'WhatsApp Üzerinden Sipariş!',
    'hero_desc' => 'Beğendiğiniz ürüne dokunun, sipariş detaylarıyla otomatik olarak WhatsApp\'a geçin. Kapıda ödeme kolaylığı ve aynı gün jet teslimat.',
    'hero_cta' => 'Ürünleri İncele',
    'hero_direct_chat' => 'Canlı Destekle Konuş',
    'filter_all' => 'Tüm Aletler',
    'filter_smart' => 'Akıllı Saat & Kulaklık',
    'filter_auto' => 'Oto Aksesuar',
    'filter_home' => 'Ev & Yaşam',
    'btn_order_wa' => 'WhatsApp ile Sipariş Ver',
    'stock_ready' => 'Stokta Hazır • Hızlı Gönderim',
    'info_title' => 'Çalışma Saatleri & Kargo Bilgisi',
    'hours_label' => 'Çalışma Saatleri:',
    'hours_val' => 'Hergün 09:00 - 23:00 Kesintisiz',
    'baku_deliv' => 'Şehir İçi Teslimat:',
    'baku_deliv_val' => '2-3 saat içinde kurye ile kapıya teslim',
    'region_deliv' => 'Tüm Şehirlere:',
    'region_deliv_val' => 'Kargo ile 24 saat içinde adrese gönderim',
    'pay_label' => 'Ödeme Seçenekleri:',
    'pay_val' => 'Ürünü kontrol ettikten sonra kapıda nakit veya kartla',
    'reviews_title' => 'WhatsApp Müşteri Yorumları',
    'reviews_sub' => 'Müşterilerimizin bizzat WhatsApp üzerinden paylaştığı memnuniyetler',
    'faq_title' => 'Sıkça Sorulan Sorular',
    'faq_q1' => 'Ödemeyi nasıl yapıyorum?',
    'faq_a1' => 'Kurye ürünü teslim ettiğinde ürünü kontrol edip kapıda nakit veya POS ile ödersiniz.',
    'faq_q2' => 'Garanti var mı?',
    'faq_a2' => 'Evet, tüm elektronik ürünlerimizde 14 gün koşulsuz değişim garantisi mevcuttur.',
    'faq_q3' => 'WhatsApp\'tan yazdıktan sonra süreç nasıl ilerler?',
    'faq_a3' => 'Temsilcimiz 1-2 dakika içinde siparişi onaylar ve kuryeyi anında yola çıkarır.',
    'footer_desc' => 'Bazar Pro — doğrudan WhatsApp ile satış modeli. Skyweb.az tarafından e-ticaret satıcıları için özel geliştirildi.',
    'footer_rights' => 'Tüm hakları saklıdır.',
    'review_verified' => '✓ Doğrulanmış Alıcı',
    'review_1_text' => '"Selam, saat bugün ulaştı! Çok teşekkürler, kalitesi beklediğimden çok daha iyi çıktı, aramalar çok net duyuluyor. Hızlı teslimat!"',
    'review_2_text' => '"Mini projektörü aldık, akşamları çocuklar için çizgi film açıyoruz, tavanı adeta sinemaya çevirdi! Kapıda kontrol edip ödedik, teşekkürler!"',
    'review_3_text' => '"Araç tutucu çok sağlam, telefonu koyar koymaz kavrayıp hızlı şarj ediyor. Gerçekten harika bir ürün, arkadaşlarıma da tavsiye ettim."',
  ],
  'ru' => [
    'demo_banner' => 'Это демонстрационный сайт — Создано Skyweb',
    'back_to_sky' => 'Вернуться в Skyweb',
    'order_site' => 'Заказать такой сайт',
    'brand_name' => 'BAZAR PRO',
    'brand_sub' => 'Быстрые продажи через WhatsApp',
    'op_status' => 'Оператор онлайн • Ответ за 1 минуту',
    'nav_catalog' => 'Каталог',
    'nav_how' => 'Как заказать',
    'nav_reviews' => 'Отзывы в WhatsApp',
    'nav_contact' => 'График и доставка',
    'hero_badge' => '⚡ ЗАКАЗ В 1 КЛИК ЧЕРЕЗ WHATSAPP',
    'hero_title_1' => 'Без регистрации и ожидания,',
    'hero_title_2' => 'Прямой заказ в WhatsApp!',
    'hero_desc' => 'Нажмите на понравившийся товар и мгновенно перейдите в чат с готовым сообщением. Быстрая доставка по Баку с оплатой при получении.',
    'hero_cta' => 'Выбрать товар',
    'hero_direct_chat' => 'Чат с оператором',
    'filter_all' => 'Все гаджеты',
    'filter_smart' => 'Смарт-часы и аудио',
    'filter_auto' => 'Авто-аксессуары',
    'filter_home' => 'Дом и комфорт',
    'btn_order_wa' => 'Заказать в WhatsApp',
    'stock_ready' => 'В наличии • Экспресс-отправка',
    'info_title' => 'График работы и доставка',
    'hours_label' => 'Часы работы:',
    'hours_val' => 'Ежедневно с 09:00 до 23:00 без выходных',
    'baku_deliv' => 'По Баку:',
    'baku_deliv_val' => 'Курьером к двери в течение 2-3 часов',
    'region_deliv' => 'В регионы:',
    'region_deliv_val' => 'Почтой или экспресс-доставкой за 24 часа',
    'pay_label' => 'Оплата:',
    'pay_val' => 'При получении после проверки — наличными или картой',
    'reviews_title' => 'Отзывы из WhatsApp',
    'reviews_sub' => 'Реальные сообщения от покупателей из нашего чата',
    'faq_title' => 'Частые вопросы',
    'faq_q1' => 'Как происходит оплата?',
    'faq_a1' => 'Вы осматриваете товар при курьере, убеждаетесь в качестве и оплачиваете на месте.',
    'faq_q2' => 'Есть ли гарантия на технику?',
    'faq_a2' => 'Да, 14 дней на проверку качества и обмен на все устройства.',
    'faq_q3' => 'Что происходит после перехода в WhatsApp?',
    'faq_a3' => 'Менеджер отвечает в течение минуты, уточняет адрес и отправляет курьера.',
    'footer_desc' => 'Bazar Pro — удобная платформа для продаж через WhatsApp. Разработано студией Skyweb.az.',
    'footer_rights' => 'Все права защищены.',
    'review_verified' => '✓ Подтвержденный покупатель',
    'review_1_text' => '"Здравствуйте, часы доставили сегодня! Огромное спасибо, качество превзошло все ожидания, слышимость при звонках отличная. Доставка быстрая!"',
    'review_2_text' => '"Купили мини-проектор, по вечерам включаем мультики детям, потолок превратился в настоящий кинотеатр! Проверили и оплатили при получении, спасибо!"',
    'review_3_text' => '"Автодержатель держит очень надежно, моментально фиксирует телефон и быстро заряжает. Настоящая находка, уже порекомендовал друзьям."',
  ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$gadgets = [
  [
    'id' => 201,
    'cat' => 'smart',
    'price' => 69,
    'old_price' => 95,
    'icon' => '⌚',
    'img' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=700&q=80',
    'badge' => 'TOP 1 XİT',
    'title' => [
      'az' => 'Smart Saat Ultra Pro Series 9 (Amoled)',
      'en' => 'Smart Watch Ultra Pro Series 9 (Amoled)',
      'tr' => 'Smart Saat Ultra Pro Seri 9 (Amoled)',
      'ru' => 'Смарт-часы Ultra Pro Series 9 Amoled',
    ],
    'desc' => [
      'az' => 'Zənglərə cavab vermə, addımölçən, ürək döyüntüsü, 49mm titan korpus və 2 ədəd silikon kəmər hədiyyə.',
      'en' => 'Bluetooth calls, fitness tracking, heart rate, 49mm titanium alloy casing + 2 free straps.',
      'tr' => 'Bluetooth arama, nabız ölçer, 49mm titanyum kasa ve yanında 2 adet kordon hediye.',
      'ru' => 'Прием звонков, пульсометр, титановый корпус 49мм и 2 ремешка в подарок.',
    ],
  ],
  [
    'id' => 202,
    'cat' => 'smart',
    'price' => 45,
    'old_price' => 65,
    'icon' => '🎧',
    'img' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=700&q=80',
    'badge' => 'SUPER BASS',
    'title' => [
      'az' => 'Simsiz Qulaqlıq ANC Pro Noise Cancelling',
      'en' => 'Wireless Earbuds ANC Pro Noise Cancelling',
      'tr' => 'Kablosuz Kulaklık ANC Pro Gürültü Engelleyici',
      'ru' => 'Беспроводные наушники ANC Pro с шумоподавлением',
    ],
    'desc' => [
      'az' => 'Aktiv kənar səs boğucu (ANC), 30 saatadək batareya ömrü, təmiz mikrofon və simsiz şarj dəstəyi.',
      'en' => 'Active noise cancellation, up to 30h total battery life, crystal clear mics, wireless case.',
      'tr' => 'Aktif gürültü engelleme, 30 saat pil ömrü, net mikrofon ve kablosuz şarj kutusu.',
      'ru' => 'Активное шумоподавление, до 30 часов работы, чистый микрофон и беспроводной кейс.',
    ],
  ],
  [
    'id' => 203,
    'cat' => 'auto',
    'price' => 29,
    'old_price' => 45,
    'icon' => '🚗',
    'img' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=700&q=80',
    'badge' => 'AVTO SEÇİMİ',
    'title' => [
      'az' => 'Avtomobil Sensorlu Fast Charger Tutacaq',
      'en' => 'Smart Sensor Car Fast Wireless Charger Mount',
      'tr' => 'Akıllı Sensörlü Hızlı Araç Şarj Tutucu',
      'ru' => 'Сенсорный автодержатель с беспроводной зарядкой',
    ],
    'desc' => [
      'az' => 'Telefonu yaxınlaşdırdıqda avtomatik açılıb-bağlanan qollar, 15W sürətli simsiz şarj və 360° fırlanma.',
      'en' => 'Auto-clamping sensor clips, 15W fast wireless inductive charging and 360 rotation.',
      'tr' => 'Otomatik açılan sensörlü kollar, 15W hızlı kablosuz şarj ve 360 derece dönebilen başlık.',
      'ru' => 'Автоматический зажим при поднесении телефона, 15W быстрая зарядка и вращение 360°.',
    ],
  ],
  [
    'id' => 204,
    'cat' => 'home',
    'price' => 139,
    'old_price' => 190,
    'icon' => '📽️',
    'img' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?w=700&q=80',
    'badge' => 'EV KİNOTEATRI',
    'title' => [
      'az' => 'Portativ Mini Smart Projektor Android 11',
      'en' => 'Portable Smart Mini Cinema Projector Android 11',
      'tr' => 'Taşınabilir Akıllı Mini Sinema Projeksiyonu',
      'ru' => 'Портативный смарт мини-проектор Android 11',
    ],
    'desc' => [
      'az' => 'YouTube, Netflix daxilindədir, Wi-Fi və Bluetooth, tavana və ya divara 130 düym ekran proyeksiyası.',
      'en' => 'Built-in YouTube and Netflix, 5G Wi-Fi, rotates 180° to beam a 130-inch screen anywhere.',
      'tr' => 'Dahili YouTube & Netflix, 5G Wi-Fi, tavana ya da duvara 130 inç dev sinema ekranı.',
      'ru' => 'Встроенный YouTube и Netflix, Wi-Fi 5G, проекция до 130 дюймов на стену или потолок.',
    ],
  ],
  [
    'id' => 205,
    'cat' => 'home',
    'price' => 38,
    'old_price' => 55,
    'icon' => '💆',
    'img' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?w=700&q=80',
    'badge' => 'RELAX',
    'title' => [
      'az' => 'Elektrikli Əzələ Masaj Aparatı (Fascia Gun)',
      'en' => 'Deep Tissue Muscle Massage Gun 6 Heads',
      'tr' => 'Derin Doku Titreşimli Masaj Tabancası',
      'ru' => 'Перкуссионный массажер для тела Fascia Gun',
    ],
    'desc' => [
      'az' => '6 fərqli dəyişən masaj başlığı, 30 sürət dərəcəsi, ağrıları və gərginliyi dərhal aradan qaldırır.',
      'en' => '6 interchangeable massage heads, 30 speed levels, eases muscle soreness and stiffness.',
      'tr' => '6 adet değiştirilebilir başlık, 30 kademeli hız, boyun ve bel ağrılarına anında rahatlama.',
      'ru' => '6 насадок, 30 скоростей, моментально снимает мышечное напряжение и усталость.',
    ],
  ],
  [
    'id' => 206,
    'cat' => 'home',
    'price' => 19,
    'old_price' => 30,
    'icon' => '☕',
    'img' => 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=700&q=80',
    'badge' => 'HƏDİYYƏLİK',
    'title' => [
      'az' => 'Smart Termos LED Temperatur Ekranlı 500ml',
      'en' => 'Smart Vacuum Thermos with LED Temp Display 500ml',
      'tr' => 'LED Sıcaklık Göstergeli Çelik Termos 500ml',
      'ru' => 'Умный термос с LED дисплеем температуры 500мл',
    ],
    'desc' => [
      'az' => 'Qapağına toxunduqda içkinin dərəcəsini göstərir, paslanmaz polad, 12 saat isti və soyuq saxlayır.',
      'en' => 'Touch the cap to reveal water temp, 304 food-grade stainless steel, 12h thermal lock.',
      'tr' => 'Kapağa dokununca sıcaklığı gösterir, paslanmaz çelik, 12 saat sıcak ve soğuk koruma.',
      'ru' => 'Сенсорный дисплей показывает температуру напитка, нержавеющая сталь, 12ч держит тепло.',
    ],
  ],
];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($t['brand_name']) ?> — <?= e(sky_literal_translate('WhatsApp Sürətli Ticarət Demo')) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: rgba(0, 32, 38, 0.85);
      --sky-border: rgba(0, 255, 255, 0.18);
      --neon-cyan: #00FFFF;
      --wa-green: #25d366;
      --wa-dark: #128c7e;
      --wa-glow: 0 0 20px rgba(37, 211, 102, 0.4);
      --neon-glow: 0 0 20px rgba(0, 255, 255, 0.35);
      --text-main: #f0fefe;
      --text-muted: #8ec5c5;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: linear-gradient(180deg, #001414 0%, #001f22 35%, #002b33 75%, #001214 100%);
      color: var(--text-main);
      font-family: var(--font-body);
      min-height: 100vh;
      line-height: 1.6;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }

    /* Top Skyweb Demo Banner */
    .demo-bar {
      background: rgba(0, 24, 24, 0.95);
      border-bottom: 1px solid var(--sky-border);
      padding: 8px 16px;
      font-size: 13px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      position: sticky;
      top: 0;
      z-index: 1000;
      backdrop-filter: blur(12px);
    }
    .demo-bar-left { display: flex; align-items: center; gap: 10px; }
    .demo-badge {
      background: rgba(0, 255, 255, 0.15);
      color: var(--neon-cyan);
      border: 1px solid var(--neon-cyan);
      border-radius: 20px;
      padding: 2px 10px;
      font-weight: 700;
      font-size: 11px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      box-shadow: var(--neon-glow);
    }
    .demo-text { color: var(--text-muted); font-weight: 500; }
    .demo-bar-right { display: flex; align-items: center; gap: 12px; }
    .demo-btn-sky {
      background: var(--neon-cyan);
      color: #001a1a;
      padding: 4px 12px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 12px;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .demo-btn-sky:hover { box-shadow: var(--neon-glow); transform: translateY(-1px); }
    .demo-btn-back {
      color: var(--text-muted);
      font-size: 12px;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 6px;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .demo-btn-back:hover { color: #fff; border-color: var(--neon-cyan); }
    .lang-pills { display: flex; gap: 4px; background: rgba(0,0,0,0.4); padding: 2px; border-radius: 6px; }
    .lang-pill {
      font-size: 11px;
      padding: 2px 7px;
      border-radius: 4px;
      color: var(--text-muted);
      font-weight: 600;
      text-transform: uppercase;
    }
    .lang-pill.active { background: var(--neon-cyan); color: #001a1a; }

    /* Store Header */
    .wa-nav {
      background: rgba(0, 20, 24, 0.88);
      border-bottom: 1px solid rgba(0, 255, 255, 0.12);
      backdrop-filter: blur(16px);
      padding: 14px 24px;
      position: sticky;
      top: 41px;
      z-index: 900;
    }
    .nav-wrap {
      max-width: 1240px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .brand-group {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .brand-icon-wa {
      width: 44px;
      height: 44px;
      background: radial-gradient(circle, rgba(37,211,102,0.3) 0%, rgba(0,34,40,0.9) 100%);
      border: 1.5px solid var(--wa-green);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      box-shadow: 0 0 15px rgba(37,211,102,0.3);
    }
    .brand-text {
      font-family: var(--font-heading);
      font-size: 22px;
      font-weight: 800;
      color: #fff;
      display: flex;
      flex-direction: column;
      line-height: 1.1;
    }
    .brand-text span {
      font-size: 10px;
      letter-spacing: 2px;
      color: var(--wa-green);
      font-weight: 600;
      text-transform: uppercase;
    }
    .operator-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(37, 211, 102, 0.12);
      border: 1px solid rgba(37, 211, 102, 0.35);
      border-radius: 30px;
      padding: 6px 14px;
      font-size: 12px;
      font-weight: 600;
      color: var(--wa-green);
    }
    .pulse-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--wa-green);
      box-shadow: 0 0 10px var(--wa-green);
      animation: pulse 1.8s infinite;
    }
    @keyframes pulse {
      0% { opacity: 1; transform: scale(1); }
      50% { opacity: 0.4; transform: scale(1.3); }
      100% { opacity: 1; transform: scale(1); }
    }
    .btn-top-chat {
      background: #25d366;
      color: #001a1a;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 13px;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.25s;
    }
    .btn-top-chat:hover {
      box-shadow: var(--wa-glow);
      transform: translateY(-1px);
    }

    /* Hero Section */
    .wa-hero {
      max-width: 1240px;
      margin: 0 auto;
      padding: 60px 24px 40px;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 40px;
      align-items: center;
    }
    .hero-badge-tag {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 1.5px;
      color: var(--neon-cyan);
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--sky-border);
      padding: 6px 14px;
      border-radius: 30px;
      margin-bottom: 20px;
      text-transform: uppercase;
    }
    .hero-title {
      font-family: var(--font-heading);
      font-size: clamp(32px, 4.8vw, 54px);
      line-height: 1.15;
      font-weight: 900;
      color: #fff;
      margin-bottom: 18px;
    }
    .hero-title .wa-glow-txt {
      color: var(--wa-green);
      text-shadow: 0 0 25px rgba(37,211,102,0.4);
    }
    .hero-desc {
      color: var(--text-muted);
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 28px;
      max-width: 520px;
    }
    .hero-btn-row {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: center;
    }
    .btn-green-wa {
      background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
      color: #fff;
      font-weight: 800;
      font-size: 15px;
      padding: 14px 28px;
      border-radius: 10px;
      border: none;
      box-shadow: 0 0 25px rgba(37, 211, 102, 0.4);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.25s ease;
    }
    .btn-green-wa:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 35px rgba(37, 211, 102, 0.6);
    }

    /* Hero Simulated Phone Preview */
    .hero-phone-preview {
      background: rgba(0, 26, 32, 0.85);
      border: 1px solid var(--sky-border);
      border-radius: 28px;
      padding: 24px;
      box-shadow: 0 25px 60px rgba(0,0,0,0.6), inset 0 0 20px rgba(37,211,102,0.1);
      position: relative;
    }
    .phone-chat-head {
      display: flex;
      align-items: center;
      gap: 12px;
      padding-bottom: 16px;
      border-bottom: 1px solid rgba(0,255,255,0.1);
      margin-bottom: 20px;
    }
    .chat-avatar {
      width: 42px;
      height: 42px;
      background: #25d366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: #fff;
    }
    .chat-bubble-user {
      background: rgba(0, 48, 56, 0.9);
      border: 1px solid rgba(0,255,255,0.2);
      border-radius: 14px 14px 4px 14px;
      padding: 14px;
      font-size: 13px;
      color: #fff;
      margin-bottom: 12px;
      margin-left: 20px;
    }
    .chat-bubble-admin {
      background: rgba(18, 140, 126, 0.35);
      border: 1px solid rgba(37,211,102,0.3);
      border-radius: 14px 14px 14px 4px;
      padding: 14px;
      font-size: 13px;
      color: #f0fefe;
      margin-bottom: 12px;
      margin-right: 20px;
    }
    .chat-time {
      font-size: 10px;
      color: rgba(255,255,255,0.4);
      text-align: right;
      margin-top: 4px;
    }

    /* Catalog Section */
    .catalog-wrap {
      max-width: 1240px;
      margin: 40px auto 80px;
      padding: 0 24px;
    }
    .catalog-top {
      text-align: center;
      margin-bottom: 36px;
    }
    .catalog-top h2 {
      font-family: var(--font-heading);
      font-size: 34px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 8px;
    }

    /* Filter Pills */
    .cat-tabs {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 40px;
    }
    .cat-pill {
      background: rgba(0, 32, 40, 0.7);
      border: 1px solid rgba(0, 255, 255, 0.15);
      color: var(--text-muted);
      padding: 9px 20px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.25s ease;
    }
    .cat-pill:hover, .cat-pill.active {
      background: var(--wa-green);
      color: #001a1a;
      border-color: var(--wa-green);
      box-shadow: var(--wa-glow);
    }

    /* Grid */
    .gadgets-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
      gap: 26px;
    }
    .gadget-card {
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      padding: 22px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all 0.3s ease;
      backdrop-filter: blur(12px);
    }
    .gadget-card:hover {
      transform: translateY(-6px);
      border-color: var(--wa-green);
      box-shadow: 0 15px 35px rgba(0,0,0,0.5), 0 0 20px rgba(37,211,102,0.25);
    }
    .gadget-badge {
      position: absolute;
      top: 16px;
      left: 16px;
      background: rgba(37, 211, 102, 0.18);
      border: 1px solid var(--wa-green);
      color: var(--wa-green);
      padding: 3px 10px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 700;
    }
    .gadget-img {
      height: 200px;
      border-radius: 14px;
      overflow: hidden;
      position: relative;
      background: #00252b;
      margin-bottom: 16px;
    }
    .gadget-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
      display: block;
    }
    .gadget-card:hover .gadget-img img { transform: scale(1.06); }
    .gadget-title {
      font-family: var(--font-heading);
      font-size: 18px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
      line-height: 1.3;
    }
    .gadget-desc {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 18px;
      flex: 1;
    }
    .gadget-bottom {
      display: flex;
      flex-direction: column;
      gap: 12px;
      margin-top: auto;
      padding-top: 14px;
      border-top: 1px solid rgba(0,255,255,0.1);
    }
    .price-row {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
    }
    .price-main {
      font-size: 22px;
      font-weight: 800;
      color: #fff;
    }
    .price-main span {
      color: var(--wa-green);
      font-size: 14px;
    }
    .price-old {
      font-size: 14px;
      color: rgba(255,255,255,0.4);
      text-decoration: line-through;
    }
    .btn-buy-wa {
      width: 100%;
      background: #25d366;
      color: #001a1a;
      border: none;
      padding: 12px;
      border-radius: 10px;
      font-weight: 800;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.25s;
    }
    .btn-buy-wa:hover {
      box-shadow: var(--wa-glow);
      transform: translateY(-2px);
    }

    /* Working Hours & Info Banner */
    .info-strip {
      background: rgba(0, 26, 32, 0.7);
      border-top: 1px solid var(--sky-border);
      border-bottom: 1px solid var(--sky-border);
      padding: 50px 24px;
      margin-bottom: 70px;
    }
    .info-container {
      max-width: 1240px;
      margin: 0 auto;
    }
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 24px;
    }
    .info-card {
      background: rgba(0, 34, 42, 0.7);
      border: 1px solid rgba(0,255,255,0.15);
      border-radius: 16px;
      padding: 24px;
    }
    .info-card h4 {
      font-family: var(--font-heading);
      font-size: 16px;
      color: var(--neon-cyan);
      margin-bottom: 8px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .info-card p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.5;
    }

    /* Testimonials WhatsApp Style */
    .reviews-section {
      max-width: 1100px;
      margin: 0 auto 80px;
      padding: 0 24px;
    }
    .reviews-header {
      text-align: center;
      margin-bottom: 40px;
    }
    .reviews-header h3 {
      font-family: var(--font-heading);
      font-size: 30px;
      color: #fff;
      margin-bottom: 6px;
    }
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 24px;
    }
    .chat-review-card {
      background: rgba(0, 32, 38, 0.7);
      border: 1px solid rgba(37,211,102,0.25);
      border-radius: 18px;
      padding: 20px;
      position: relative;
    }
    .chat-user-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 12px;
    }
    .chat-avatar-small {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #004d40;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
    }
    .chat-uname {
      font-weight: 700;
      font-size: 14px;
      color: #fff;
    }
    .chat-verified {
      color: var(--wa-green);
      font-size: 12px;
    }
    .chat-stars {
      color: #ffb703;
      font-size: 13px;
      margin-bottom: 10px;
    }
    .chat-msg-text {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.5;
      background: rgba(0, 20, 24, 0.6);
      padding: 12px;
      border-radius: 10px;
      border-left: 3px solid var(--wa-green);
    }

    /* FAQ Section */
    .faq-wrap {
      max-width: 800px;
      margin: 0 auto 80px;
      padding: 0 24px;
    }
    .faq-title {
      font-family: var(--font-heading);
      font-size: 28px;
      text-align: center;
      color: #fff;
      margin-bottom: 30px;
    }
    .faq-item {
      background: rgba(0, 32, 40, 0.6);
      border: 1px solid var(--sky-border);
      border-radius: 12px;
      margin-bottom: 14px;
      overflow: hidden;
    }
    .faq-q {
      padding: 16px 20px;
      font-weight: 700;
      font-size: 15px;
      color: #fff;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .faq-a {
      padding: 0 20px 16px;
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.6;
    }

    /* Floating WhatsApp Button */
    .float-wa-big {
      position: fixed;
      bottom: 24px;
      right: 24px;
      background: #25d366;
      color: #fff;
      padding: 12px 22px;
      border-radius: 40px;
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 800;
      font-size: 14px;
      border: none;
      box-shadow: 0 10px 30px rgba(0,0,0,0.5), var(--wa-glow);
      z-index: 1500;
      transition: all 0.3s;
    }
    .float-wa-big:hover {
      transform: scale(1.05);
      box-shadow: 0 12px 35px rgba(37,211,102,0.8);
    }

    /* Footer */
    .wa-footer {
      background: #001012;
      border-top: 1px solid var(--sky-border);
      padding: 50px 24px 30px;
      text-align: center;
    }
    .footer-wrap { max-width: 680px; margin: 0 auto; }
    .footer-title {
      font-family: var(--font-heading);
      font-size: 24px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 10px;
    }
    .badge-sky {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: rgba(0, 255, 255, 0.08);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      color: var(--neon-cyan);
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 16px;
    }

    @media (max-width: 900px) {
      .wa-hero { grid-template-columns: 1fr; text-align: center; padding-top: 40px; }
      .hero-desc { margin: 0 auto 24px; }
      .hero-btn-row { justify-content: center; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="whatsapp" data-dk-accent="#22c55e" data-dk-phone="994503936998" data-dk-sticky data-dk-sticky-label="Sifariş">
  <script src="assets/demo-kit.js"></script>


  <!-- Top Demo Banner -->
  <div class="demo-bar">
    <div class="demo-bar-left">
      <span class="demo-badge">SKYWEB DEMO</span>
      <span class="demo-text"><?= htmlspecialchars($t['demo_banner']) ?></span>
    </div>
    <div class="demo-bar-right">
      <div class="lang-pills">
        <a href="?lang=az" class="lang-pill <?= $lang === 'az' ? 'active' : '' ?>">AZ</a>
        <a href="?lang=en" class="lang-pill <?= $lang === 'en' ? 'active' : '' ?>">EN</a>
        <a href="?lang=tr" class="lang-pill <?= $lang === 'tr' ? 'active' : '' ?>">TR</a>
        <a href="?lang=ru" class="lang-pill <?= $lang === 'ru' ? 'active' : '' ?>">RU</a>
      </div>
      <a href="../../index.php?lang=<?= e($lang) ?>#contact" class="demo-btn-sky"><?= htmlspecialchars($t['order_site']) ?> →</a>
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-btn-back">← <?= htmlspecialchars($t['back_to_sky']) ?></a>
    </div>
  </div>

  <!-- Store Header -->
  <header class="wa-nav">
    <div class="nav-wrap">
      <div class="brand-group">
        <div class="brand-icon-wa">💬</div>
        <div class="brand-text">
          <?= htmlspecialchars($t['brand_name']) ?>
          <span><?= htmlspecialchars($t['brand_sub']) ?></span>
        </div>
      </div>
      <div class="operator-badge">
        <span class="pulse-dot"></span>
        <span><?= htmlspecialchars($t['op_status']) ?></span>
      </div>
      <button class="btn-top-chat" onclick="directChat()">
        <span>💬</span>
        <span><?= htmlspecialchars($t['hero_direct_chat']) ?></span>
      </button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="wa-hero" id="home">
    <div>
      <span class="hero-badge-tag"><?= htmlspecialchars($t['hero_badge']) ?></span>
      <h1 class="hero-title">
        <?= htmlspecialchars($t['hero_title_1']) ?><br>
        <span class="wa-glow-txt"><?= htmlspecialchars($t['hero_title_2']) ?></span>
      </h1>
      <p class="hero-desc"><?= htmlspecialchars($t['hero_desc']) ?></p>
      <div class="hero-btn-row">
        <a href="#catalog" class="btn-green-wa">
          <span><?= htmlspecialchars($t['hero_cta']) ?></span>
          <span>↓</span>
        </a>
      </div>
    </div>
    <div>
      <div class="hero-phone-preview">
        <div class="phone-chat-head">
          <div class="chat-avatar">💬</div>
          <div>
            <div style="font-weight:700; color:#fff; font-size:15px;"><?= htmlspecialchars($t['brand_name']) ?> Support</div>
            <div style="font-size:12px; color:var(--wa-green);">🟢 <?= htmlspecialchars($t['op_status']) ?></div>
          </div>
        </div>
        <div class="chat-bubble-user">
          Salam! Smart Saat Ultra Pro Series 9 sifariş etmək istəyirəm. Bakı daxili çatdırılma var?
          <div class="chat-time">14:20 ✓✓</div>
        </div>
        <div class="chat-bubble-admin">
          Salam! Bəli, stokda hazırdır. 2 saat ərzində birbaşa qapınıza çatdırırıq, ödənişi təhvil alanda nağd və ya kartla edə bilərsiniz. Ünvanınızı qeyd edin zəhmət olmasa! 😊
          <div class="chat-time">14:21 ✓✓</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Product Catalog -->
  <section class="catalog-wrap" id="catalog">
    <div class="catalog-top">
      <h2><?= htmlspecialchars($t['nav_catalog']) ?></h2>
      <p style="color:var(--text-muted); font-size:15px;"><?= htmlspecialchars($t['stock_ready']) ?></p>
    </div>

    <!-- Category Filter -->
    <div class="cat-tabs">
      <button class="cat-pill active" onclick="filterGadgets('all', this)"><?= htmlspecialchars($t['filter_all']) ?></button>
      <button class="cat-pill" onclick="filterGadgets('smart', this)"><?= htmlspecialchars($t['filter_smart']) ?></button>
      <button class="cat-pill" onclick="filterGadgets('auto', this)"><?= htmlspecialchars($t['filter_auto']) ?></button>
      <button class="cat-pill" onclick="filterGadgets('home', this)"><?= htmlspecialchars($t['filter_home']) ?></button>
    </div>

    <!-- Live search -->
    <div class="dk-field" style="max-width:460px; margin:0 auto 18px;">
      <input class="dk-input" id="gadgetSearch" type="search" autocomplete="off"
             placeholder="🔍 <?= htmlspecialchars($t['nav_catalog']) ?> — <?= htmlspecialchars($t['hero_cta']) ?>"
             oninput="searchGadgets(this.value)">
    </div>
    <div class="dk-ship" id="searchNote" style="text-align:center; margin-bottom:14px;"></div>

    <!-- Product Grid -->
    <div class="gadgets-grid" id="gadgetsGrid">
      <?php foreach ($gadgets as $g): ?>
        <?php
          $title = $g['title'][$lang] ?? $g['title']['az'];
          $desc = $g['desc'][$lang] ?? $g['desc']['az'];
        ?>
        <div class="gadget-card" data-cat="<?= $g['cat'] ?>">
          <span class="gadget-badge"><?= $g['badge'] ?></span>
          <div class="gadget-img">
            <img src="<?= htmlspecialchars($g['img']) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
          </div>
          <h3 class="gadget-title"><?= htmlspecialchars($title) ?></h3>
          <p class="gadget-desc"><?= htmlspecialchars($desc) ?></p>
          <div class="gadget-bottom">
            <div class="price-row">
              <div class="price-main"><?= $g['price'] ?> <span>AZN</span></div>
              <div class="price-old"><?= $g['old_price'] ?> AZN</div>
            </div>
            <div style="display:flex; gap:8px;">
              <button class="btn-buy-wa" style="flex:1;" onclick="addGadgetToCart(<?= $g['id'] ?>, '<?= htmlspecialchars(addslashes($title)) ?>', <?= $g['price'] ?>, '<?= htmlspecialchars($g['img']) ?>')">
                <span>🛒</span>
                <span><?= ['az' => 'Səbətə at', 'en' => 'Add to cart', 'ru' => 'В корзину', 'tr' => 'Sepete ekle'][$lang] ?? 'Səbətə at' ?></span>
              </button>
              <button class="btn-buy-wa" style="flex:0 0 44px; padding:0;" title="<?= htmlspecialchars($t['btn_order_wa']) ?>" onclick="orderItemWhatsApp('<?= htmlspecialchars(addslashes($title)) ?>', <?= $g['price'] ?>)">
                <span>💬</span>
              </button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Working Hours & Delivery Info Strip -->
  <section class="info-strip">
    <div class="info-container">
      <div style="text-align:center; margin-bottom:30px;">
        <h3 style="font-family:var(--font-heading); font-size:26px; color:#fff;"><?= htmlspecialchars($t['info_title']) ?></h3>
      </div>
      <div class="info-grid">
        <div class="info-card">
          <h4>⏰ <?= htmlspecialchars($t['hours_label']) ?></h4>
          <p><?= htmlspecialchars($t['hours_val']) ?></p>
        </div>
        <div class="info-card">
          <h4>🚀 <?= htmlspecialchars($t['baku_deliv']) ?></h4>
          <p><?= htmlspecialchars($t['baku_deliv_val']) ?></p>
        </div>
        <div class="info-card">
          <h4>📦 <?= htmlspecialchars($t['region_deliv']) ?></h4>
          <p><?= htmlspecialchars($t['region_deliv_val']) ?></p>
        </div>
        <div class="info-card">
          <h4>💳 <?= htmlspecialchars($t['pay_label']) ?></h4>
          <p><?= htmlspecialchars($t['pay_val']) ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials WhatsApp Style -->
  <section class="reviews-section">
    <div class="reviews-header">
      <h3><?= htmlspecialchars($t['reviews_title']) ?></h3>
      <p style="color:var(--text-muted); font-size:14px;"><?= htmlspecialchars($t['reviews_sub']) ?></p>
    </div>
    <div class="reviews-grid">
      <div class="chat-review-card">
        <div class="chat-user-row">
          <div class="chat-avatar-small">👤</div>
          <div>
            <div class="chat-uname">Kamran R. <span class="chat-verified"><?= htmlspecialchars($t['review_verified']) ?></span></div>
            <div class="chat-stars">★★★★★</div>
          </div>
        </div>
        <div class="chat-msg-text">
          <?= htmlspecialchars($t['review_1_text']) ?>
        </div>
      </div>
      <div class="chat-review-card">
        <div class="chat-user-row">
          <div class="chat-avatar-small">👩</div>
          <div>
            <div class="chat-uname">Aysel M. <span class="chat-verified"><?= htmlspecialchars($t['review_verified']) ?></span></div>
            <div class="chat-stars">★★★★★</div>
          </div>
        </div>
        <div class="chat-msg-text">
          <?= htmlspecialchars($t['review_2_text']) ?>
        </div>
      </div>
      <div class="chat-review-card">
        <div class="chat-user-row">
          <div class="chat-avatar-small">🧔</div>
          <div>
            <div class="chat-uname">Elmir Q. <span class="chat-verified"><?= htmlspecialchars($t['review_verified']) ?></span></div>
            <div class="chat-stars">★★★★★</div>
          </div>
        </div>
        <div class="chat-msg-text">
          <?= htmlspecialchars($t['review_3_text']) ?>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ Accordion -->
  <section class="faq-wrap">
    <h3 class="faq-title"><?= htmlspecialchars($t['faq_title']) ?></h3>
    <div class="faq-item">
      <div class="faq-q">
        <span><?= htmlspecialchars($t['faq_q1']) ?></span>
      </div>
      <div class="faq-a"><?= htmlspecialchars($t['faq_a1']) ?></div>
    </div>
    <div class="faq-item">
      <div class="faq-q">
        <span><?= htmlspecialchars($t['faq_q2']) ?></span>
      </div>
      <div class="faq-a"><?= htmlspecialchars($t['faq_a2']) ?></div>
    </div>
    <div class="faq-item">
      <div class="faq-q">
        <span><?= htmlspecialchars($t['faq_q3']) ?></span>
      </div>
      <div class="faq-a"><?= htmlspecialchars($t['faq_a3']) ?></div>
    </div>
  </section>

  <!-- Floating WhatsApp Action -->
  <button class="float-wa-big" onclick="directChat()">
    <span style="font-size:22px;">💬</span>
    <span><?= htmlspecialchars($t['hero_direct_chat']) ?></span>
  </button>

  <!-- Footer -->
  <footer class="wa-footer">
    <div class="footer-wrap">
      <div class="footer-title"><?= htmlspecialchars($t['brand_name']) ?></div>
      <div class="badge-sky">⚡ Engineered by Skyweb.az</div>
      <p style="color:var(--text-muted); font-size:14px; margin-bottom:16px;"><?= htmlspecialchars($t['footer_desc']) ?></p>
      <div style="font-size:13px; color:rgba(255,255,255,0.4);">
        © 2026 <?= htmlspecialchars($t['brand_name']) ?>. <?= htmlspecialchars($t['footer_rights']) ?>
      </div>
    </div>
  </footer>

  <script>
    /* ── Bazar Pro · kataloq axtarışı + davamlı səbət ── */
    const gadgetsCart = DK.cart('gadgets', function () { renderGadgetCart(); });
    const ACTIVE_CAT = { value: 'all' };

    function matches(card, q) {
      if (!q) return true;
      return (card.textContent || '').toLowerCase().indexOf(q) > -1;
    }

    function applyFilters() {
      const q = (document.getElementById('gadgetSearch') || {}).value || '';
      const needle = q.trim().toLowerCase();
      let shown = 0;
      document.querySelectorAll('.gadget-card').forEach(function (card) {
        const catOk = ACTIVE_CAT.value === 'all' || card.getAttribute('data-cat') === ACTIVE_CAT.value;
        const textOk = matches(card, needle);
        const on = catOk && textOk;
        card.style.display = on ? 'flex' : 'none';
        if (on) shown++;
      });
      const note = document.getElementById('searchNote');
      if (note) {
        note.innerHTML = needle
          ? '<b>' + shown + '</b> ' + DK.pick('nəticə tapıldı', 'results found', 'результатов найдено', 'sonuç bulundu')
          : '';
      }
    }

    function filterGadgets(cat, btn) {
      ACTIVE_CAT.value = cat;
      document.querySelectorAll('.cat-pill').forEach(function (p) { p.classList.remove('active'); });
      if (btn) btn.classList.add('active');
      applyFilters();
    }

    function searchGadgets() { applyFilters(); }

    function addGadgetToCart(id, title, price, img) {
      gadgetsCart.add({ id: id, title: title, price: price, img: img }, 1);
      DK.toast(title + ' — ' + DK.t.added);
      openGadgetCart(true);
    }

    function setGadgetQty(id, dir) {
      const item = gadgetsCart.items.find(function (i) { return String(i.id) === String(id); });
      if (!item) return;
      gadgetsCart.setQty(id, item.meta || '', item.qty + dir);
    }

    function removeGadget(id) { gadgetsCart.remove(id, ''); }

    /* ── Cart UI (built once, styled with the shared kit) ── */
    let cartBuilt = false;

    function buildCartUI() {
      if (cartBuilt) return;
      cartBuilt = true;

      const btn = document.createElement('button');
      btn.id = 'gadgetCartBtn';
      btn.className = 'dk-fab';
      btn.style.cssText = 'position:fixed;left:18px;bottom:calc(20px + env(safe-area-inset-bottom));z-index:8600;width:54px;height:54px;font-size:21px';
      btn.innerHTML = '<span class="dk-count" data-dk-count style="top:-2px;right:-2px">0</span>🛒';
      btn.setAttribute('aria-label', DK.t.order);
      btn.addEventListener('click', function () { openGadgetCart(); });
      document.body.appendChild(btn);

      const overlay = document.createElement('div');
      overlay.id = 'gadgetCartOverlay';
      overlay.style.cssText = 'position:fixed;inset:0;z-index:9050;background:rgba(2,10,14,.72);backdrop-filter:blur(5px);opacity:0;visibility:hidden;transition:.3s';

      const panel = document.createElement('aside');
      panel.id = 'gadgetCartDrawer';
      panel.style.cssText = 'position:fixed;top:0;right:0;bottom:0;z-index:9100;width:min(420px,100%);display:flex;flex-direction:column;background:#071c24;border-left:1px solid rgba(255,255,255,.1);transform:translateX(102%);transition:transform .35s cubic-bezier(.22,.61,.36,1)';
      panel.innerHTML =
        '<div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.1rem;border-bottom:1px solid rgba(255,255,255,.09)">' +
          '<strong style="font-size:16px;color:#fff">🛒 ' + DK.esc(DK.pick('Səbətim', 'My cart', 'Моя корзина', 'Sepetim')) + '</strong>' +
          '<button id="gadgetCartClose" style="width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.05);color:#cfe9e9;font-size:15px;cursor:pointer">✕</button>' +
        '</div>' +
        '<div id="gadgetCartItems" style="flex:1;overflow-y:auto;padding:1rem;display:flex;flex-direction:column;gap:.6rem"></div>' +
        '<div style="padding:1rem;border-top:1px solid rgba(255,255,255,.09);background:rgba(3,14,18,.9)">' +
          '<div style="display:flex;justify-content:space-between;color:#fff;font-weight:800;margin-bottom:.75rem">' +
            '<span>' + DK.esc(DK.t.total) + '</span><span id="gadgetCartTotal" style="color:var(--dk-accent)">0 AZN</span>' +
          '</div>' +
          '<button id="gadgetCheckout" class="dk-btn dk-btn--primary" style="width:100%">💬 ' + DK.esc(DK.pick('Sifarişi tamamla', 'Complete order', 'Оформить заказ', 'Siparişi tamamla')) + '</button>' +
        '</div>';

      overlay.appendChild(panel);
      document.body.appendChild(overlay);

      overlay.addEventListener('click', function (e) { if (e.target === overlay) closeGadgetCart(); });
      panel.querySelector('#gadgetCartClose').addEventListener('click', closeGadgetCart);
      panel.querySelector('#gadgetCheckout').addEventListener('click', checkoutGadgets);

      renderGadgetCart();
    }

    function openGadgetCart(silent) {
      buildCartUI();
      if (!silent && !gadgetsCart.items.length) {
        DK.toast(DK.t.emptyCart, 'info');
      }
      const ov = document.getElementById('gadgetCartOverlay');
      const dr = document.getElementById('gadgetCartDrawer');
      ov.style.visibility = 'visible';
      ov.style.opacity = '1';
      dr.style.transform = 'translateX(0)';
      document.body.style.overflow = 'hidden';
    }

    function closeGadgetCart() {
      const ov = document.getElementById('gadgetCartOverlay');
      const dr = document.getElementById('gadgetCartDrawer');
      if (!ov) return;
      ov.style.opacity = '0';
      ov.style.visibility = 'hidden';
      dr.style.transform = 'translateX(102%)';
      document.body.style.overflow = '';
    }

    function toggleGadgetCart() {
      const ov = document.getElementById('gadgetCartOverlay');
      if (ov && ov.style.visibility === 'visible') closeGadgetCart();
      else openGadgetCart();
    }

    function renderGadgetCart() {
      buildCartUI();
      const list = document.getElementById('gadgetCartItems');
      const totalEl = document.getElementById('gadgetCartTotal');
      if (!list) return;

      if (!gadgetsCart.items.length) {
        list.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">🛒</span>' + DK.esc(DK.t.emptyCart) + '</div>';
        totalEl.textContent = '0 AZN';
        return;
      }

      list.innerHTML = gadgetsCart.items.map(function (i) {
        return '<div style="display:flex;gap:.6rem;align-items:center;padding:.55rem;border:1px solid rgba(255,255,255,.09);border-radius:12px;background:rgba(255,255,255,.03)">' +
          (i.img ? '<img src="' + DK.esc(i.img) + '" alt="" style="width:46px;height:46px;border-radius:9px;object-fit:cover;flex:0 0 auto">' : '') +
          '<div style="flex:1;min-width:0">' +
            '<div style="color:#fff;font-weight:700;font-size:13px;line-height:1.3">' + DK.esc(i.title) + '</div>' +
            '<div style="color:var(--dk-accent);font-size:12px;font-weight:700">' + i.qty + ' × ' + i.price + ' AZN</div>' +
          '</div>' +
          '<div class="dk-qty">' +
            '<button class="dk-qty__btn" onclick="setGadgetQty(' + i.id + ',-1)">−</button>' +
            '<span class="dk-qty__val">' + i.qty + '</span>' +
            '<button class="dk-qty__btn" onclick="setGadgetQty(' + i.id + ',1)">+</button>' +
          '</div>' +
          '<button style="background:none;border:none;color:#fb7185;font-size:14px;cursor:pointer" onclick="removeGadget(' + i.id + ')">✕</button>' +
        '</div>';
      }).join('');

      totalEl.textContent = gadgetsCart.total() + ' AZN';
      DK.syncBadges(gadgetsCart.items);
    }

    function checkoutGadgets() {
      if (!gadgetsCart.items.length) return DK.toast(DK.t.emptyCart, 'err');
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: '<?= htmlspecialchars(addslashes($t['brand_name'])) ?>',
        items: gadgetsCart.items,
        addressRequired: true
      }).then(function (d) {
        if (!d) return;
        gadgetsCart.clear();
        closeGadgetCart();
      });
    }

    function orderItemWhatsApp(title, price) {
      DK.order({
        title: title,
        brand: '<?= htmlspecialchars(addslashes($t['brand_name'])) ?>',
        items: [{ title: title, price: price, qty: 1 }],
        addressRequired: true
      });
    }

    function directChat() {
      DK.wa('<?= htmlspecialchars(addslashes($t['hero_direct_chat'])) ?> — ' +
        DK.pick('məhsullarınız haqqında məlumat almaq istəyirəm.',
                'I would like details about your products.',
                'хочу узнать о ваших товарах.',
                'ürünleriniz hakkında bilgi almak istiyorum.'));
    }

    buildCartUI();
    applyFilters();
  </script>
</body>
</html>
