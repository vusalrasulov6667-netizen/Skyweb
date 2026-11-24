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
        'brand_name' => 'SkyVilla Realty',
        'brand_sub' => 'Lüks Daşınmaz Əmlak Agentliyi',
        'nav_properties' => 'Əmlaklar',
        'nav_buy' => 'Satış',
        'nav_rent' => 'Kirayə',
        'nav_agents' => 'Rieltorlar',
        'nav_contact' => 'Əlaqə',
        'nav_list_prop' => 'Elan Yerləşdir',
        'hero_badge' => 'BAKININ ƏN PRESTİJLİ ƏMLAK PORTALI',
        'hero_title_1' => 'Xəyallarınızdakı',
        'hero_title_2' => 'Lüks Məkanı Tapın',
        'hero_desc' => 'Sea Breeze, Ağ Şəhər və şəhər mərkəzində eksklüziv villalar, penthauslar və premium mənzillər.',
        'filter_sale' => 'Almaq (Satış)',
        'filter_rent' => 'Kirayələmək',
        'filter_type' => 'Əmlak Növü',
        'filter_all_types' => 'Bütün Növlər',
        'type_villa' => 'Villa & Bağ Evi',
        'type_penthouse' => 'Lüks Penthaus',
        'type_apartment' => 'Premium Mənzil',
        'filter_location' => 'Ərazi / Rayon',
        'filter_all_loc' => 'Bütün Ərazilər',
        'loc_seabreeze' => 'Sea Breeze Resort',
        'loc_whitecity' => 'Bakı Ağ Şəhər',
        'loc_center' => 'Nəsimi (Mərkəz)',
        'loc_bilgah' => 'Bilgəh & Mərdəkan',
        'filter_rooms' => 'Otaq Sayı',
        'filter_any_rooms' => 'İstənilən',
        'filter_price' => 'Maksimum Qiymət',
        'filter_btn' => 'Əmlakları Axtar',
        'results_found' => 'elan tapıldı',
        'featured_title' => 'Eksklüziv Təkliflərimiz',
        'featured_sub' => 'Yalnız yoxlanılmış, tam kupçalı və xüsusi dizaynlı mülklər.',
        'badge_sale' => 'SATIŞ',
        'badge_rent' => 'KİRAYƏ',
        'badge_exclusive' => 'EKSKLÜZİV',
        'specs_beds' => 'otaq',
        'specs_baths' => 'sanitar',
        'specs_area' => 'm²',
        'btn_virtual_tour' => '3D Virtual Tur',
        'btn_contact_agent' => 'Rieltorla Əlaqə',
        'map_title' => 'İnteraktiv Əmlak Xəritəsi',
        'map_sub' => 'Bakı və Abşeronun ən prestijli nöqtələrində yerləşən mülklər.',
        'agents_title' => 'Ekspert Rieltorlarımız',
        'agents_sub' => 'Alqı-satqı prosesini etibarlı və sürətli idarə edən mütəxəssislər.',
        'form_title' => 'Əmlakınızı Pulsuz Qiymətləndirin',
        'form_sub' => 'Evinizi satmaq və ya kirayə vermək istəyirsiniz? Məlumatları göndərin, ən doğru bazar qiymətini təyin edək.',
        'form_name' => 'Adınız və Soyadınız',
        'form_phone' => 'Telefon Nömrəniz',
        'form_prop_type' => 'Əmlakın Növü',
        'form_submit' => 'Qiymətləndirmə Tələb Et',
        'form_success' => 'Müraciətiniz qeydə alındı! Ekspert rieltorumuz tezliklə əlaqə saxlayacaq.',
        'tour_modal_title' => '360° Virtual Tur Təcrübəsi',
        'tour_room_1' => 'Geniş Qonaq Otağı',
        'tour_room_2' => 'Master Yataq Otağı',
        'tour_room_3' => 'Hovuz & Həyət',
        'tour_room_4' => 'Dənizə Panoramik Terras',
        'wa_button' => 'WhatsApp Əlaqə',
        'footer_desc' => 'Bu demo veb-sayt daşınmaz əmlak şirkətləri və rieltor agentlikləri üçün Skyweb tərəfindən hazırlanmışdır.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'banner_text' => 'This is a demo website — Created by Skyweb',
        'back_to_sky' => 'Back to Skyweb',
        'brand_name' => 'SkyVilla Realty',
        'brand_sub' => 'Luxury Real Estate Agency',
        'nav_properties' => 'Properties',
        'nav_buy' => 'Buy',
        'nav_rent' => 'Rent',
        'nav_agents' => 'Brokers',
        'nav_contact' => 'Contact',
        'nav_list_prop' => 'List Property',
        'hero_badge' => 'BAKU\'S PREMIER LUXURY PROPERTY PORTAL',
        'hero_title_1' => 'Discover Your',
        'hero_title_2' => 'Dream Sanctuary',
        'hero_desc' => 'Curated collection of ultra-luxury villas, penthouses, and waterfront estates across Baku and the Caspian coastline.',
        'filter_sale' => 'Buy (For Sale)',
        'filter_rent' => 'Rent (Lease)',
        'filter_type' => 'Property Type',
        'filter_all_types' => 'All Types',
        'type_villa' => 'Villa & Mansions',
        'type_penthouse' => 'Luxury Penthouse',
        'type_apartment' => 'Modern Apartment',
        'filter_location' => 'Location / District',
        'filter_all_loc' => 'All Locations',
        'loc_seabreeze' => 'Sea Breeze Resort',
        'loc_whitecity' => 'Baku White City',
        'loc_center' => 'Nasimi Downtown',
        'loc_bilgah' => 'Bilgah & Mardakan',
        'filter_rooms' => 'Bedrooms',
        'filter_any_rooms' => 'Any',
        'filter_price' => 'Max Budget',
        'filter_btn' => 'Search Properties',
        'results_found' => 'properties found',
        'featured_title' => 'Featured Luxury Listings',
        'featured_sub' => 'Vetted architectural masterpieces with clean title deeds.',
        'badge_sale' => 'FOR SALE',
        'badge_rent' => 'FOR RENT',
        'badge_exclusive' => 'EXCLUSIVE',
        'specs_beds' => 'beds',
        'specs_baths' => 'baths',
        'specs_area' => 'sqm',
        'btn_virtual_tour' => '3D Virtual Tour',
        'btn_contact_agent' => 'Contact Broker',
        'map_title' => 'Interactive Location Map',
        'map_sub' => 'Explore premier prime residences across Absheron peninsula.',
        'agents_title' => 'Meet Our Top Advisors',
        'agents_sub' => 'Decades of combined expertise delivering discreet real estate transactions.',
        'form_title' => 'Request Free Property Valuation',
        'form_sub' => 'Looking to sell or lease your prime estate? Submit details for a market appraisal.',
        'form_name' => 'Full Name',
        'form_phone' => 'Phone Number',
        'form_prop_type' => 'Property Classification',
        'form_submit' => 'Request Valuation Report',
        'form_success' => 'Thank you! A senior broker will review your asset and reach out shortly.',
        'tour_modal_title' => '360° Interactive Virtual Walkthrough',
        'tour_room_1' => 'Grand Living Area',
        'tour_room_2' => 'Master Bedroom Suite',
        'tour_room_3' => 'Infinity Pool & Garden',
        'tour_room_4' => 'Panoramic Ocean Terrace',
        'wa_button' => 'WhatsApp Broker',
        'footer_desc' => 'This demo was created by Skyweb to showcase high-end real estate portals and agency websites.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'banner_text' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'brand_name' => 'SkyVilla Realty',
        'brand_sub' => 'Lüks Gayrimenkul Acentesi',
        'nav_properties' => 'Portföy',
        'nav_buy' => 'Satılık',
        'nav_rent' => 'Kiralık',
        'nav_agents' => 'Danışmanlar',
        'nav_contact' => 'İletişim',
        'nav_list_prop' => 'İlan Ver',
        'hero_badge' => 'BAKÜ\'NÜN EN PRESTİJLİ EMLAK PLATFORMU',
        'hero_title_1' => 'Hayalinizdeki',
        'hero_title_2' => 'Lüks Yaşamı Bulun',
        'hero_desc' => 'Sea Breeze, Beyaz Şehir ve şehir merkezinde özel havuzlu villalar, rezidanslar ve penthouse daireler.',
        'filter_sale' => 'Satılık',
        'filter_rent' => 'Kiralık',
        'filter_type' => 'Emlak Türü',
        'filter_all_types' => 'Tüm Türler',
        'type_villa' => 'Müstakil Villa',
        'type_penthouse' => 'Lüks Penthouse',
        'type_apartment' => 'Rezidans Daire',
        'filter_location' => 'Bölge',
        'filter_all_loc' => 'Tüm Bölgeler',
        'loc_seabreeze' => 'Sea Breeze Resort',
        'loc_whitecity' => 'Bakü Beyaz Şehir',
        'loc_center' => 'Nesimi Merkez',
        'loc_bilgah' => 'Bilgeh Sahil',
        'filter_rooms' => 'Oda Sayısı',
        'filter_any_rooms' => 'Farketmez',
        'filter_price' => 'Maksimum Bütçe',
        'filter_btn' => 'İlanları Listele',
        'results_found' => 'ilan listelendi',
        'featured_title' => 'Öne Çıkan Gayrimenkuller',
        'featured_sub' => 'Kusursuz mimari ve tapu garantili seçkin yaşam alanları.',
        'badge_sale' => 'SATILIK',
        'badge_rent' => 'KİRALIK',
        'badge_exclusive' => 'ÖZEL PORTFÖY',
        'specs_beds' => 'oda',
        'specs_baths' => 'banyo',
        'specs_area' => 'm²',
        'btn_virtual_tour' => '3D Sanal Tur',
        'btn_contact_agent' => 'Danışmanı Ara',
        'map_title' => 'Harita Üzerinde Konumlar',
        'map_sub' => 'Bakü ve Hazar kıyısının en değerli lokasyonları.',
        'agents_title' => 'Uzman Gayrimenkul Danışmanları',
        'agents_sub' => 'Alım ve satım sürecinizi güvenle yöneten profesyonel ekip.',
        'form_title' => 'Ücretsiz Emlak Değerleme',
        'form_sub' => 'Mülkünüzün gerçek piyasa değerini öğrenmek için formu doldurun.',
        'form_name' => 'Adınız Soyadınız',
        'form_phone' => 'Telefon Numaranız',
        'form_prop_type' => 'Mülk Tipi',
        'form_submit' => 'Değerleme Talebi Gönder',
        'form_success' => 'Talebiniz alındı! Gayrimenkul uzmanımız kısa sürede sizinle iletişime geçecektir.',
        'tour_modal_title' => '360° Sanal Tur Deneyimi',
        'tour_room_1' => 'Geniş Salon & Şömine',
        'tour_room_2' => 'Ebeveyn Yatak Odası',
        'tour_room_3' => 'Bahçe ve Sonsuzluk Havuzu',
        'tour_room_4' => 'Panoramik Deniz Terası',
        'wa_button' => 'WhatsApp İletişim',
        'footer_desc' => 'Bu web sitesi, gayrimenkul şirketleri ve emlak ofisleri için Skyweb tarafından tasarlanmıştır.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'banner_text' => 'Это демонстрационный сайт — Создан в Skyweb',
        'back_to_sky' => 'Назад в Skyweb',
        'brand_name' => 'SkyVilla Realty',
        'brand_sub' => 'Агентство элитной недвижимости',
        'nav_properties' => 'Объекты',
        'nav_buy' => 'Купить',
        'nav_rent' => 'Аренда',
        'nav_agents' => 'Брокеры',
        'nav_contact' => 'Контакты',
        'nav_list_prop' => 'Разместить объект',
        'hero_badge' => 'ПРЕМИУМ ПОРТАЛ НЕДВИЖИМОСТИ В БАКУ',
        'hero_title_1' => 'Найдите дом',
        'hero_title_2' => 'вашей мечты',
        'hero_desc' => 'Эксклюзивные виллы в Sea Breeze, пентхаусы в Белом Городе и резиденции в центре Баку.',
        'filter_sale' => 'Покупка (Продажа)',
        'filter_rent' => 'Аренда',
        'filter_type' => 'Тип объекта',
        'filter_all_types' => 'Все типы',
        'type_villa' => 'Вилла / Особняк',
        'type_penthouse' => 'Пентхаус',
        'type_apartment' => 'Апартаменты',
        'filter_location' => 'Локация / Район',
        'filter_all_loc' => 'Все районы',
        'loc_seabreeze' => 'Sea Breeze Resort',
        'loc_whitecity' => 'Baku White City',
        'loc_center' => 'Насиминский (Центр)',
        'loc_bilgah' => 'Бильгя и Мардакян',
        'filter_rooms' => 'Комнат',
        'filter_any_rooms' => 'Любое',
        'filter_price' => 'Макс. бюджет',
        'filter_btn' => 'Найти недвижимость',
        'results_found' => 'объектов найдено',
        'featured_title' => 'Избранные объекты',
        'featured_sub' => 'Проверенные объекты с безупречными юридическими документами.',
        'badge_sale' => 'ПРОДАЖА',
        'badge_rent' => 'АРЕНДА',
        'badge_exclusive' => 'ЭКСКЛЮЗИВ',
        'specs_beds' => 'спальни',
        'specs_baths' => 'санузла',
        'specs_area' => 'м²',
        'btn_virtual_tour' => '3D Виртуальный тур',
        'btn_contact_agent' => 'Связаться с агентом',
        'map_title' => 'Интерактивная карта объектов',
        'map_sub' => 'Престижные резиденции на побережье Каспийского моря.',
        'agents_title' => 'Наши ведущие брокеры',
        'agents_sub' => 'Профессионалы, сопровождающие сделки любой сложности.',
        'form_title' => 'Бесплатная оценка недвижимости',
        'form_sub' => 'Хотите выгодно продать или сдать объект? Получите профессиональный расчет стоимости.',
        'form_name' => 'Ваше имя',
        'form_phone' => 'Номер телефона',
        'form_prop_type' => 'Тип недвижимости',
        'form_submit' => 'Заказать оценку',
        'form_success' => 'Заявка принята! Эксперт свяжется с вами в течение короткого времени.',
        'tour_modal_title' => '360° Виртуальный 3D-тур',
        'tour_room_1' => 'Просторная гостиная',
        'tour_room_2' => 'Мастер-спальня',
        'tour_room_3' => 'Бассейн и сад',
        'tour_room_4' => 'Терраса с видом на море',
        'wa_button' => 'WhatsApp брокер',
        'footer_desc' => 'Данный демонстрационный сайт разработан веб-студией Skyweb для риелторских компаний и агентств недвижимости.',
        'all_rights' => 'Все права защищены.',
    ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$properties = [
    [
        'id' => 1,
        'deal' => 'sale',
        'type' => 'villa',
        'loc' => 'seabreeze',
        'title' => [
            'az' => 'Sea Breeze Palms — Dəniz Mənzərəli Lüks Villa',
            'en' => 'Sea Breeze Palms — Waterfront Luxury Villa',
            'tr' => 'Sea Breeze Palms — Deniz Manzaralı Villa',
            'ru' => 'Sea Breeze Palms — Роскошная вилла у моря'
        ],
        'price' => '850,000 ₼',
        'price_num' => 850000,
        'rooms' => 5,
        'baths' => 4,
        'area' => 450,
        'img' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&q=80',
        'badge' => 'EKSKLÜZİV',
        'loc_text' => 'Nardaran, Sea Breeze Resort',
    ],
    [
        'id' => 2,
        'deal' => 'sale',
        'type' => 'penthouse',
        'loc' => 'whitecity',
        'title' => [
            'az' => 'Ağ Şəhər Knightsbridge — Panoramik Penthaus',
            'en' => 'Knightsbridge Residence — Panoramic Penthouse',
            'tr' => 'Knightsbridge Residence — Panoramik Penthouse',
            'ru' => 'Knightsbridge Residence — Видовой пентхаус'
        ],
        'price' => '620,000 ₼',
        'price_num' => 620000,
        'rooms' => 4,
        'baths' => 3,
        'area' => 280,
        'img' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
        'badge' => 'SATIŞ',
        'loc_text' => 'Xətai r-nu, Bakı Ağ Şəhər',
    ],
    [
        'id' => 3,
        'deal' => 'rent',
        'type' => 'apartment',
        'loc' => 'center',
        'title' => [
            'az' => 'Port Baku Residence — Dizayn Təmirli Mənzil',
            'en' => 'Port Baku Residence — Designer 3-Bed Suite',
            'tr' => 'Port Baku Residence — Özel Tasarım Daire',
            'ru' => 'Port Baku Residence — Дизайнерские апартаменты'
        ],
        'price' => '3,500 ₼ / ay',
        'price_num' => 3500,
        'rooms' => 3,
        'baths' => 2,
        'area' => 175,
        'img' => 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=800&q=80',
        'badge' => 'KİRAYƏ',
        'loc_text' => 'Səbail, Neftçilər prospekti',
    ],
    [
        'id' => 4,
        'deal' => 'sale',
        'type' => 'villa',
        'loc' => 'bilgah',
        'title' => [
            'az' => 'Bilgəh Sunset Estate — Qapalı Hovuzlu Bağ Evi',
            'en' => 'Bilgah Sunset Estate — Private Pool Mansion',
            'tr' => 'Bilgeh Sunset Estate — Havuzlu Lüks Malikane',
            'ru' => 'Bilgah Sunset Estate — Особняк с бассейном'
        ],
        'price' => '1,200,000 ₼',
        'price_num' => 1200000,
        'rooms' => 6,
        'baths' => 5,
        'area' => 600,
        'img' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80',
        'badge' => 'EKSKLÜZİV',
        'loc_text' => 'Sabunçu r-nu, Bilgəh qəsəbəsi',
    ],
    [
        'id' => 5,
        'deal' => 'rent',
        'type' => 'penthouse',
        'loc' => 'whitecity',
        'title' => [
            'az' => 'Boulevard Sky Penthouse — Açıq Terraslı',
            'en' => 'Boulevard Sky Penthouse — Open Sun Deck',
            'tr' => 'Boulevard Sky Penthouse — Teraslı Daire',
            'ru' => 'Boulevard Sky Penthouse — С открытой террасой'
        ],
        'price' => '4,800 ₼ / ay',
        'price_num' => 4800,
        'rooms' => 4,
        'baths' => 3,
        'area' => 240,
        'img' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80',
        'badge' => 'KİRAYƏ',
        'loc_text' => 'Bakı Ağ Şəhər, Fəvvarələr Meydanı',
    ],
    [
        'id' => 6,
        'deal' => 'sale',
        'type' => 'apartment',
        'loc' => 'center',
        'title' => [
            'az' => 'Nizami Mall Yanı — Smart Home 3 Otaqlı',
            'en' => 'Nizami Center — Smart Home High-Rise',
            'tr' => 'Nizami Caddesi — Akıllı Rezidans',
            'ru' => 'Улица Низами — Квартира Smart Home'
        ],
        'price' => '410,000 ₼',
        'price_num' => 410000,
        'rooms' => 3,
        'baths' => 2,
        'area' => 140,
        'img' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
        'badge' => 'SATIŞ',
        'loc_text' => 'Nəsimi r-nu, Nizami metrosu',
    ],
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
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: #002626;
      --sky-card-hover: #003333;
      --neon-cyan: #00FFFF;
      --neon-glow: rgba(0, 255, 255, 0.4);
      --gold: #f59e0b;
      --emerald: #10b981;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --border-glass: rgba(0, 255, 255, 0.16);
      --font-heading: 'Outfit', sans-serif;
      --font-body: 'Inter', sans-serif;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      background-color: var(--sky-bg);
      background-image: 
        radial-gradient(circle at 15% 20%, rgba(0, 255, 255, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 85% 80%, rgba(245, 158, 11, 0.06) 0%, transparent 45%);
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
    .btn-nav-list {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 800;
      padding: 10px 22px;
      border-radius: 999px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-nav-list:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }

    /* Hero */
    .hero {
      position: relative;
      border-radius: 28px;
      margin: 20px auto 40px;
      padding: 70px 48px;
      background: linear-gradient(135deg, rgba(0, 36, 36, 0.9) 0%, rgba(0, 16, 16, 0.94) 100%),
                  url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1600&q=80') center/cover;
      border: 1px solid var(--border-glass);
      overflow: hidden;
      box-shadow: 0 20px 50px rgba(0,0,0,0.6);
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 6px 16px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 1px;
      margin-bottom: 20px;
    }
    .hero h1 {
      font-family: var(--font-heading);
      font-size: clamp(36px, 5.5vw, 62px);
      line-height: 1.1;
      font-weight: 900;
      margin-bottom: 16px;
    }
    .hero h1 span {
      background: linear-gradient(90deg, #fff, var(--neon-cyan));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero p { color: #cbd5e1; font-size: 17px; max-width: 600px; margin-bottom: 36px; }

    /* Filter Box */
    .filter-card {
      background: rgba(0, 26, 26, 0.88);
      backdrop-filter: blur(16px);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 24px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }
    .deal-tabs { display: flex; gap: 8px; margin-bottom: 18px; }
    .deal-btn {
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--border-glass);
      color: var(--text-muted);
      padding: 8px 20px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 13px;
      transition: all 0.2s;
    }
    .deal-btn.active, .deal-btn:hover {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
    }
    .filter-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr) auto;
      gap: 14px;
      align-items: flex-end;
    }
    .filter-field { display: flex; flex-direction: column; gap: 6px; }
    .filter-field label { font-size: 12px; font-weight: 700; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; }
    .filter-field select {
      background: #001e1e;
      border: 1px solid var(--border-glass);
      color: #fff;
      padding: 12px 14px;
      border-radius: 10px;
      font-family: inherit;
      font-size: 14px;
      outline: none;
    }
    .filter-field select:focus { border-color: var(--neon-cyan); }
    .btn-search {
      background: linear-gradient(135deg, var(--neon-cyan), #00e5ff);
      color: #000;
      font-weight: 900;
      padding: 13px 28px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
      white-space: nowrap;
    }
    .btn-search:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    /* Section Head */
    .section-head { text-align: center; margin: 60px 0 36px; }
    .section-head h2 { font-family: var(--font-heading); font-size: 32px; font-weight: 800; color: #fff; }
    .section-head p { color: var(--text-muted); font-size: 15px; margin-top: 4px; }

    /* Listings Grid */
    .listings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
      gap: 28px;
      margin-bottom: 70px;
    }
    .prop-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 22px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s;
    }
    .prop-card:hover {
      transform: translateY(-6px);
      border-color: var(--neon-cyan);
      box-shadow: 0 15px 35px rgba(0, 255, 255, 0.16);
    }
    .prop-img-box {
      height: 230px;
      position: relative;
      overflow: hidden;
    }
    .prop-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s;
    }
    .prop-card:hover .prop-img-box img { transform: scale(1.08); }
    .prop-badge {
      position: absolute;
      top: 14px;
      left: 14px;
      background: rgba(0, 26, 26, 0.85);
      border: 1px solid var(--border-glass);
      color: var(--neon-cyan);
      font-weight: 800;
      font-size: 11px;
      padding: 4px 10px;
      border-radius: 6px;
      letter-spacing: 0.5px;
    }
    .prop-price-tag {
      position: absolute;
      bottom: 14px;
      left: 14px;
      background: rgba(0, 18, 18, 0.9);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-family: var(--font-heading);
      font-size: 18px;
      font-weight: 900;
      padding: 6px 14px;
      border-radius: 8px;
    }
    .prop-body { padding: 22px; display: flex; flex-direction: column; flex: 1; }
    .prop-loc { font-size: 13px; color: var(--text-muted); display: flex; align-items: center; gap: 6px; margin-bottom: 8px; }
    .prop-title { font-family: var(--font-heading); font-size: 18px; font-weight: 800; color: #fff; line-height: 1.35; margin-bottom: 18px; }
    .prop-specs {
      display: flex;
      justify-content: space-between;
      padding: 12px 0;
      border-top: 1px solid rgba(255,255,255,0.06);
      border-bottom: 1px solid rgba(255,255,255,0.06);
      margin-bottom: 18px;
      font-size: 13px;
      color: #cbd5e1;
    }
    .spec-item { display: flex; align-items: center; gap: 5px; }
    .spec-item svg { color: var(--neon-cyan); }
    .prop-actions { display: flex; gap: 10px; margin-top: auto; }
    .btn-tour {
      flex: 1;
      background: rgba(0, 255, 255, 0.1);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      font-weight: 700;
      font-size: 13px;
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      transition: all 0.2s;
    }
    .btn-tour:hover { background: var(--neon-cyan); color: #000; box-shadow: 0 0 15px var(--neon-glow); }
    .btn-agent {
      background: rgba(255,255,255,0.08);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-weight: 700;
      font-size: 13px;
      padding: 10px 14px;
      border-radius: 10px;
      transition: all 0.2s;
    }
    .btn-agent:hover { border-color: var(--neon-cyan); color: var(--neon-cyan); }

    /* Map Placeholder */
    .map-section {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 36px;
      margin-bottom: 70px;
      position: relative;
      overflow: hidden;
    }
    .map-mockup {
      height: 340px;
      background: #001a1a url('https://images.unsplash.com/photo-1524661135-423995f22d0b?w=1200&q=80') center/cover;
      border-radius: 16px;
      position: relative;
      border: 1px solid var(--border-glass);
      filter: saturate(0.4) brightness(0.7);
    }
    .map-pin {
      position: absolute;
      background: var(--neon-cyan);
      color: #000;
      padding: 6px 12px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 800;
      box-shadow: 0 0 20px var(--neon-cyan);
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 4px;
      transition: transform 0.2s;
    }
    .map-pin:hover { transform: scale(1.15); }
    .pin-1 { top: 25%; left: 65%; }
    .pin-2 { top: 55%; left: 45%; }
    .pin-3 { top: 70%; left: 30%; }

    /* Agents */
    .agents-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-bottom: 70px;
    }
    .agent-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 24px;
      display: flex;
      align-items: center;
      gap: 16px;
    }
    .agent-avatar { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid var(--neon-cyan); }
    .agent-info h4 { font-size: 16px; color: #fff; }
    .agent-info p { font-size: 13px; color: var(--neon-cyan); }
    .agent-info span { font-size: 12px; color: var(--text-muted); display: block; margin-top: 2px; }

    /* Valuation Form */
    .val-section {
      background: linear-gradient(135deg, #002e2e 0%, #001818 100%);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 48px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
      margin-bottom: 80px;
    }
    .val-form { display: flex; flex-direction: column; gap: 14px; }
    .val-form input, .val-form select {
      background: rgba(0, 18, 18, 0.7);
      border: 1px solid var(--border-glass);
      padding: 12px 16px;
      border-radius: 10px;
      color: #fff;
      font-family: inherit;
      outline: none;
    }
    .val-form input:focus, .val-form select:focus {
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
    }
    .btn-submit-val {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 900;
      padding: 14px;
      border-radius: 12px;
      margin-top: 8px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-submit-val:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    /* Virtual Tour Modal */
    .tour-modal {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.85);
      backdrop-filter: blur(8px);
      z-index: 2000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .tour-modal.active { display: flex; }
    .tour-box {
      background: #002222;
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      max-width: 800px;
      width: 100%;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0,0,0,0.8);
    }
    .tour-header {
      padding: 18px 24px;
      border-bottom: 1px solid var(--border-glass);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .tour-close { background: none; color: #fff; font-size: 24px; }
    .tour-viewport {
      height: 400px;
      position: relative;
      background: #000;
    }
    .tour-viewport img { width: 100%; height: 100%; object-fit: cover; }
    .tour-nav-tabs {
      position: absolute;
      bottom: 16px;
      left: 16px;
      right: 16px;
      display: flex;
      gap: 8px;
      background: rgba(0, 20, 20, 0.85);
      backdrop-filter: blur(8px);
      padding: 8px;
      border-radius: 12px;
      border: 1px solid var(--border-glass);
      overflow-x: auto;
    }
    .room-tab {
      background: rgba(255,255,255,0.06);
      color: #cbd5e1;
      padding: 6px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      white-space: nowrap;
      transition: all 0.2s;
    }
    .room-tab.active, .room-tab:hover {
      background: var(--neon-cyan);
      color: #000;
    }

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

    /* Footer */
    footer {
      background: #001212;
      border-top: 1px solid var(--border-glass);
      padding: 40px 24px 24px;
      text-align: center;
    }
    footer p { color: var(--text-muted); font-size: 13px; margin-bottom: 6px; }

    @media (max-width: 900px) {
      .nav-links { display: none; }
      .hero { padding: 40px 20px; }
      .filter-grid { grid-template-columns: 1fr; }
      .agents-grid, .val-section { grid-template-columns: 1fr; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="realestate" data-dk-accent="#06b6d4" data-dk-phone="994503936998" data-dk-sticky data-dk-action="openViewingSheet" data-dk-sticky-label="Baxış">
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
    </div>
  </div>

  <!-- Navbar -->
  <header class="navbar">
    <a href="#" class="brand">
      <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
      <?= e($t['brand_name']) ?>
    </a>
    <ul class="nav-links">
      <li><a href="#featured"><?= e($t['nav_properties']) ?></a></li>
      <li><a href="#map"><?= e($t['map_title']) ?></a></li>
      <li><a href="#agents"><?= e($t['nav_agents']) ?></a></li>
      <li><a href="#valuation"><?= e($t['nav_contact']) ?></a></li>
    </ul>
    <a href="#valuation" class="btn-nav-list"><?= e($t['nav_list_prop']) ?></a>
  </header>

  <main class="container">
    <!-- Hero with Property Filter -->
    <section class="hero">
      <span class="hero-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <?= e($t['hero_badge']) ?>
      </span>
      <h1><?= e($t['hero_title_1']) ?><br><span><?= e($t['hero_title_2']) ?></span></h1>
      <p><?= e($t['hero_desc']) ?></p>

      <!-- Advanced Filter -->
      <div class="filter-card">
        <div class="deal-tabs">
          <button class="deal-btn active" data-deal="all"><?= e($t['filter_all_types']) ?></button>
          <button class="deal-btn" data-deal="sale"><?= e($t['filter_sale']) ?></button>
          <button class="deal-btn" data-deal="rent"><?= e($t['filter_rent']) ?></button>
        </div>

        <div class="filter-grid">
          <div class="filter-field">
            <label><?= e($t['filter_type']) ?></label>
            <select id="filterType">
              <option value="all"><?= e($t['filter_all_types']) ?></option>
              <option value="villa"><?= e($t['type_villa']) ?></option>
              <option value="penthouse"><?= e($t['type_penthouse']) ?></option>
              <option value="apartment"><?= e($t['type_apartment']) ?></option>
            </select>
          </div>

          <div class="filter-field">
            <label><?= e($t['filter_location']) ?></label>
            <select id="filterLoc">
              <option value="all"><?= e($t['filter_all_loc']) ?></option>
              <option value="seabreeze"><?= e($t['loc_seabreeze']) ?></option>
              <option value="whitecity"><?= e($t['loc_whitecity']) ?></option>
              <option value="center"><?= e($t['loc_center']) ?></option>
              <option value="bilgah"><?= e($t['loc_bilgah']) ?></option>
            </select>
          </div>

          <div class="filter-field">
            <label><?= e($t['filter_rooms']) ?></label>
            <select id="filterRooms">
              <option value="all"><?= e($t['filter_any_rooms']) ?></option>
              <option value="3">3+ <?= e($t['specs_beds']) ?></option>
              <option value="4">4+ <?= e($t['specs_beds']) ?></option>
              <option value="5">5+ <?= e($t['specs_beds']) ?></option>
            </select>
          </div>

          <div class="filter-field">
            <label><?= e($t['filter_price']) ?></label>
            <select id="filterPrice">
              <option value="all"><?= e($t['filter_any_rooms']) ?></option>
              <option value="500000">≤ 500,000 ₼</option>
              <option value="1000000">≤ 1,000,000 ₼</option>
            </select>
          </div>

          <button class="btn-search" onclick="applyFilters()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <?= e($t['filter_btn']) ?>
          </button>
        </div>
      </div>
    </section>

    <!-- Featured Properties Grid -->
    <section id="featured">
      <div class="section-head">
        <h2><?= e($t['featured_title']) ?></h2>
        <p><?= e($t['featured_sub']) ?></p>
      </div>

      <div class="listings-grid" id="listingsGrid">
        <?php foreach ($properties as $p): ?>
          <?php $ptitle = $p['title'][$lang] ?? $p['title']['az']; ?>
          <div class="prop-card" data-deal="<?= e($p['deal']) ?>" data-type="<?= e($p['type']) ?>" data-loc="<?= e($p['loc']) ?>" data-rooms="<?= e($p['rooms']) ?>" data-price="<?= e($p['price_num']) ?>">
            <div class="prop-img-box">
              <img src="<?= e($p['img']) ?>" alt="<?= e($ptitle) ?>" loading="lazy">
              <span class="prop-badge"><?= e($p['badge']) ?></span>
              <span class="prop-price-tag"><?= e($p['price']) ?></span>
            </div>
            <div class="prop-body">
              <div class="prop-loc">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span><?= e($p['loc_text']) ?></span>
              </div>
              <h3 class="prop-title"><?= e($ptitle) ?></h3>
              <div class="prop-specs">
                <div class="spec-item">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                  <span><?= e($p['rooms']) ?> <?= e($t['specs_beds']) ?></span>
                </div>
                <div class="spec-item">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.5L19 7.5V19a2 2 0 0 1-2 2z"/></svg>
                  <span><?= e($p['baths']) ?> <?= e($t['specs_baths']) ?></span>
                </div>
                <div class="spec-item">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/></svg>
                  <span><?= e($p['area']) ?> <?= e($t['specs_area']) ?></span>
                </div>
              </div>
              <div class="prop-actions">
                <button class="btn-tour" onclick="openTourModal('<?= e(addslashes($ptitle)) ?>')"><?= e($t['btn_virtual_tour']) ?></button>
                <a href="https://wa.me/994503936998?text=Salam,%20bu%20əmlakla%20bağlı%20əlaqə%20saxlayıram:%20<?= urlencode($ptitle) ?>" target="_blank" class="btn-agent"><?= e($t['btn_contact_agent']) ?></a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Map Section -->
    <section id="map" class="map-section">
      <div style="margin-bottom:20px;">
        <h3 style="font-family:var(--font-heading); font-size:24px; color:#fff;"><?= e($t['map_title']) ?></h3>
        <p style="color:var(--text-muted); font-size:14px;"><?= e($t['map_sub']) ?></p>
      </div>

      <div class="map-mockup">
        <div class="map-pin pin-1" onclick="alert('Sea Breeze Resort — 12 Lüks Mülk Mövcuddur')">📍 Sea Breeze (12)</div>
        <div class="map-pin pin-2" onclick="alert('Ağ Şəhər — 8 Penthaus və Mənzil')">📍 Ağ Şəhər (8)</div>
        <div class="map-pin pin-3" onclick="alert('Port Baku & Nəsimi Mərkəz — 15 Mülk')">📍 Mərkəz (15)</div>
      </div>
    </section>

    <!-- Agents Section -->
    <section id="agents">
      <div class="section-head">
        <h2><?= e($t['agents_title']) ?></h2>
        <p><?= e($t['agents_sub']) ?></p>
      </div>
      <div class="agents-grid">
        <div class="agent-card">
          <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=200&q=80" class="agent-avatar" alt="Rauf Məlikov">
          <div class="agent-info">
            <h4>Rauf Məlikov</h4>
            <p>Baş Broker (Sea Breeze)</p>
            <span>+994 50 711 22 33</span>
          </div>
        </div>
        <div class="agent-card">
          <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&q=80" class="agent-avatar" alt="Səbinə Əhmədova">
          <div class="agent-info">
            <h4>Səbinə Əhmədova</h4>
            <p>Lüks Mənzillər Direktoru</p>
            <span>+994 55 822 44 55</span>
          </div>
        </div>
        <div class="agent-card">
          <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&q=80" class="agent-avatar" alt="Cavid Babayev">
          <div class="agent-info">
            <h4>Cavid Babayev</h4>
            <p>İnvestisiya Məsləhətçisi</p>
            <span>+994 70 333 66 77</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Valuation Request Form -->
    <section id="valuation" class="val-section">
      <div>
        <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:900; margin-bottom:12px;"><?= e($t['form_title']) ?></h2>
        <p style="color:var(--text-muted); font-size:15px; margin-bottom:24px;"><?= e($t['form_sub']) ?></p>
        <div style="display:flex; flex-direction:column; gap:12px; font-size:14px; color:#cbd5e1;">
          <div style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Bazar analizi əsasında dəqiq qiymət təyini</span>
          </div>
          <div style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Peşəkar fotoçəkiliş və 3D skanlama xidməti</span>
          </div>
        </div>
      </div>

      <form class="val-form" onsubmit="event.preventDefault(); submitValuation();">
        <input type="text" required placeholder="<?= e($t['form_name']) ?>">
        <input type="tel" required placeholder="<?= e($t['form_phone']) ?>">
        <select>
          <option><?= e($t['type_villa']) ?></option>
          <option><?= e($t['type_penthouse']) ?></option>
          <option><?= e($t['type_apartment']) ?></option>
        </select>
        <button type="submit" class="btn-submit-val"><?= e($t['form_submit']) ?></button>
      </form>
    </section>
  </main>

  <!-- Virtual Tour Modal -->
  <div class="tour-modal" id="tourModal">
    <div class="tour-box">
      <div class="tour-header">
        <h3 style="font-family:var(--font-heading); font-size:18px;" id="tourTitle"><?= e($t['tour_modal_title']) ?></h3>
        <button class="tour-close" onclick="closeTourModal()">&times;</button>
      </div>
      <div class="tour-viewport">
        <img id="tourImg" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=80" alt="Virtual 360 Tour">
        <div class="tour-nav-tabs">
          <button class="room-tab active" onclick="switchRoom(0)"><?= e($t['tour_room_1']) ?></button>
          <button class="room-tab" onclick="switchRoom(1)"><?= e($t['tour_room_2']) ?></button>
          <button class="room-tab" onclick="switchRoom(2)"><?= e($t['tour_room_3']) ?></button>
          <button class="room-tab" onclick="switchRoom(3)"><?= e($t['tour_room_4']) ?></button>
        </div>
      </div>
    </div>
  </div>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/994503936998?text=Salam,%20SkyVilla%20əmlak%20elanları%20haqqında%20məlumat%20almaq%20istəyirəm" target="_blank" class="float-wa" title="<?= e($t['wa_button']) ?>">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/>
    </svg>
  </a>

  <!-- Footer -->
  <footer>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Crafted by <span style="color:var(--neon-cyan); font-weight:700;">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    let activeDeal = 'all';

    // Deal buttons
    document.querySelectorAll('.deal-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.deal-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        activeDeal = btn.dataset.deal;
        applyFilters();
      });
    });

    function applyFilters() {
      const type = document.getElementById('filterType').value;
      const loc = document.getElementById('filterLoc').value;
      const rooms = document.getElementById('filterRooms').value;
      const price = document.getElementById('filterPrice').value;

      let shown = 0;
      document.querySelectorAll('.prop-card').forEach(card => {
        const cDeal = card.dataset.deal;
        const cType = card.dataset.type;
        const cLoc = card.dataset.loc;
        const cRooms = parseInt(card.dataset.rooms, 10);
        const cPrice = parseInt(card.dataset.price, 10);

        let match = true;
        if (activeDeal !== 'all' && cDeal !== activeDeal) match = false;
        if (type !== 'all' && cType !== type) match = false;
        if (loc !== 'all' && cLoc !== loc) match = false;
        if (rooms !== 'all' && cRooms < parseInt(rooms, 10)) match = false;
        if (price !== 'all' && cPrice > parseInt(price, 10)) match = false;

        card.style.display = match ? 'flex' : 'none';
        if (match) shown++;
      });

      const note = document.getElementById('reCount');
      if (note) {
        note.innerHTML = DK.pick('<b>' + shown + '</b> elan tapıldı', '<b>' + shown + '</b> listings found',
          'найдено <b>' + shown + '</b> объявлений', '<b>' + shown + '</b> ilan bulundu');
      }
      const empty = document.getElementById('reEmpty');
      if (empty) empty.style.display = shown ? 'none' : 'block';
    }

    // Virtual Tour Mockup
    const roomImages = [
      'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=80',
      'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?w=1200&q=80',
      'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1200&q=80',
      'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80'
    ];

    function openTourModal(title) {
      document.getElementById('tourTitle').textContent = '360° Tour: ' + title;
      document.getElementById('tourModal').classList.add('active');
    }

    function closeTourModal() {
      document.getElementById('tourModal').classList.remove('active');
    }

    function switchRoom(idx) {
      document.querySelectorAll('.room-tab').forEach((tab, i) => {
        tab.classList.toggle('active', i === idx);
      });
      document.getElementById('tourImg').src = roomImages[idx] || roomImages[0];
    }

    function submitValuation() {
      DK.sheet({
        eyebrow: DK.pick('PULSUZ QİYMƏTLƏNDİRMƏ', 'FREE VALUATION', 'БЕСПЛАТНАЯ ОЦЕНКА', 'ÜCRETSİZ DEĞERLEME'),
        title: DK.pick('Əmlakın qiymətləndirilməsi', 'Property valuation', 'Оценка недвижимости', 'Emlak değerlemesi'),
        sub: DK.pick('Peşəkar foto, 3D skan və bazar analizi — 24 saat ərzində hesabat.',
                    'Pro photos, 3D scan and market analysis — report within 24 hours.',
                    'Проф. фото, 3D-скан и анализ рынка — отчёт за 24 часа.',
                    'Profesyonel foto, 3D tarama ve pazar analizi — 24 saatte rapor.'),
        submitText: DK.pick('Hesabat sifariş et', 'Request report', 'Заказать отчёт', 'Rapor iste'),
        submitIcon: '📄',
        fields: [
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'type', label: DK.pick('Əmlak növü', 'Property type', 'Тип недвижимости', 'Emlak tipi'), type: 'select', required: true,
            options: [DK.pick('Villa', 'Villa', 'Вилла', 'Villa'),
                      DK.pick('Penthouse', 'Penthouse', 'Пентхаус', 'Penthouse'),
                      DK.pick('Mənzil', 'Apartment', 'Квартира', 'Daire')] },
          { name: 'address', label: DK.pick('Ünvan / rayon', 'Address / district', 'Адрес / район', 'Adres / bölge'), required: true, placeholder: DK.pick('Bakı, Nizami küç. 25', 'Baku, 25 Nizami st.', 'Баку, ул. Низами 25', 'Bakü, Nizami cad. 25') },
          { name: 'note', label: DK.t.note, type: 'textarea', rows: 2, placeholder: DK.t.notePh }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast(DK.pick('Sorğu qəbul edildi — 24 saat ərzində əlaqə saxlayacağıq',
          'Request received — we will contact you within 24 hours',
          'Заявка принята — свяжемся в течение 24 часов',
          'Talep alındı — 24 saat içinde iletişime geçeceğiz'));
        DK.wa('Salam! SkyVilla qiymətləndirmə sorğusu:\nAd: ' + d.name +
          '\nTel: +994 ' + DK.fmtPhone(d.phone) + '\nNöv: ' + d.type +
          '\nÜnvan: ' + d.address + (d.note ? '\nQeyd: ' + d.note : ''));
      });
    }

    function openViewingSheet() {
      DK.sheet({
        eyebrow: DK.pick('CANLI BAXIŞ', 'PRIVATE VIEWING', 'ЛИЧНЫЙ ОСМОТР', 'ÖZEL GEZİNTİ'),
        title: DK.pick('Baxış üçün vaxt seçin', 'Schedule a viewing', 'Записаться на просмотр', 'Gezinti planla'),
        sub: DK.pick('Əmlak mütəxəssisi sizi müşayiət edəcək — ödənişsiz.',
                    'A property specialist will accompany you — free of charge.',
                    'Специалист по недвижимости сопроводит вас — бесплатно.',
                    'Emlak uzmanı size eşlik edecek — ücretsiz.'),
        submitText: DK.pick('Baxışı təsdiqlə', 'Confirm viewing', 'Подтвердить просмотр', 'Gezintiyi onayla'),
        submitIcon: '💬',
        fields: [
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'date', label: DK.t.date, type: 'date', min: new Date().toISOString().slice(0, 10), required: true },
          { name: 'time', label: DK.t.time, type: 'select', required: true,
            options: ['10:00', '12:00', '14:00', '16:00', '18:00', '20:00'] },
          { name: 'note', label: DK.t.note, type: 'textarea', rows: 2, placeholder: DK.t.notePh }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast(DK.pick('Baxış planlandı!', 'Viewing scheduled!', 'Просмотр назначен!', 'Gezinti planlandı!'));
        DK.wa('Salam! SkyVilla baxış sorğusu:\nAd: ' + d.name + '\nTel: +994 ' + DK.fmtPhone(d.phone) +
          '\nTarix: ' + d.date + ' ' + d.time + (d.note ? '\nQeyd: ' + d.note : ''));
      });
    }

    /* ── Mortgage calculator + results count (injected) ── */
    (function initExtras() {
      const card = document.querySelector('.filter-card');
      if (card && !document.getElementById('reCount')) {
        const note = document.createElement('div');
        note.id = 'reCount';
        note.className = 'dk-ship';
        note.style.cssText = 'text-align:center;margin-top:14px';
        card.appendChild(note);
      }
      const grid = document.getElementById('listingsGrid');
      if (grid && !document.getElementById('reEmpty')) {
        const empty = document.createElement('div');
        empty.id = 'reEmpty';
        empty.className = 'dk-empty';
        empty.style.display = 'none';
        empty.style.gridColumn = '1/-1';
        empty.innerHTML = '<span class="dk-empty__ic">🏠</span>' +
          DK.esc(DK.pick('Bu filtrə uyğun elan yoxdur — filtri yumşaltmağı yoxlayın.',
            'No listings match these filters — try relaxing them.',
            'Нет объявлений по этим фильтрам — попробуйте их ослабить.',
            'Bu filtreye uygun ilan yok — filtreyi gevşetmeyi deneyin.'));
        grid.appendChild(empty);
      }

      const val = document.getElementById('valuation');
      if (!val || document.getElementById('mortgageCalc')) return;

      const sec = document.createElement('section');
      sec.id = 'mortgageCalc';
      sec.style.cssText = 'padding:56px 0';
      sec.innerHTML =
        '<div style="max-width:1100px;margin:0 auto;padding:0 24px">' +
          '<div style="border:1px solid rgba(6,182,212,.28);border-radius:22px;padding:28px;background:linear-gradient(160deg,rgba(6,182,212,.09),rgba(6,182,212,.02))">' +
            '<span class="dk-sheet__eyebrow">' + DK.esc(DK.pick('İPOTEKA KALKULYATORU', 'MORTGAGE CALCULATOR', 'ИПОТЕЧНЫЙ КАЛЬКУЛЯТОР', 'İPOTEKA HESAPLAYICI')) + '</span>' +
            '<h2 style="font-family:var(--font-heading);font-size:26px;color:#fff;margin:6px 0 6px">' +
              DK.esc(DK.pick('Aylıq ödənişi indi hesablayın', 'Calculate your monthly payment', 'Рассчитайте платёж', 'Aylık ödemeyi hesaplayın')) + '</h2>' +
            '<p style="color:var(--text-muted);font-size:14px;margin-bottom:20px">' +
              DK.esc(DK.pick('Əmlakın qiymətini və şərtləri dəyişin — nəticə anında yenilənir.', 'Change price and terms — the result updates instantly.', 'Измените цену и условия — результат обновится сразу.', 'Fiyatı ve koşulları değiştirin — sonuç anında güncellenir.')) + '</p>' +
            '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:14px">' +
              '<div class="dk-field"><label class="dk-label">' + DK.esc(DK.pick('Əmlakın qiyməti (AZN)', 'Property price (AZN)', 'Цена (AZN)', 'Fiyat (AZN)')) + '</label><input class="dk-input" id="mcPrice" type="number" value="250000" min="20000" step="5000"></div>' +
              '<div class="dk-field"><label class="dk-label">' + DK.esc(DK.pick('İlkin ödəniş', 'Down payment', 'Первый взнос', 'Peşinat')) + '</label><select class="dk-select" id="mcDown"><option value="10">10%</option><option value="20" selected>20%</option><option value="30">30%</option><option value="50">50%</option></select></div>' +
              '<div class="dk-field"><label class="dk-label">' + DK.esc(DK.pick('Müddət', 'Term', 'Срок', 'Vade')) + '</label><select class="dk-select" id="mcYears"><option value="5">5</option><option value="10">10</option><option value="15" selected>15</option><option value="20">20</option><option value="25">25</option></select></div>' +
              '<div class="dk-field"><label class="dk-label">' + DK.esc(DK.pick('İllik faiz (%)', 'Annual rate (%)', 'Годовая ставка (%)', 'Yıllık faiz (%)')) + '</label><input class="dk-input" id="mcRate" type="number" value="12" min="1" max="40" step="0.5"></div>' +
            '</div>' +
            '<div style="display:flex;flex-wrap:wrap;gap:26px;margin-top:22px;align-items:flex-end">' +
              '<div><div style="font-size:11px;color:#8fb8b8;letter-spacing:.1em;text-transform:uppercase">' + DK.esc(DK.pick('Aylıq ödəniş', 'Monthly payment', 'Платёж в месяц', 'Aylık ödeme')) + '</div><div id="mcMonthly" style="font-family:var(--font-heading);font-size:34px;font-weight:800;color:#06b6d4">—</div></div>' +
              '<div><div style="font-size:11px;color:#8fb8b8;letter-spacing:.1em;text-transform:uppercase">' + DK.esc(DK.pick('Kredit məbləği', 'Loan amount', 'Сумма кредита', 'Kredi tutarı')) + '</div><div id="mcLoan" style="font-size:18px;font-weight:700;color:#fff">—</div></div>' +
              '<div><div style="font-size:11px;color:#8fb8b8;letter-spacing:.1em;text-transform:uppercase">' + DK.esc(DK.pick('Ümumi faiz', 'Total interest', 'Всего процентов', 'Toplam faiz')) + '</div><div id="mcInterest" style="font-size:18px;font-weight:700;color:#fff">—</div></div>' +
              '<button class="dk-btn dk-btn--primary" id="mcApply" style="margin-left:auto">' + DK.esc(DK.pick('Bu şərtlərlə məsləhət al', 'Get advice on these terms', 'Получить консультацию', 'Bu koşullarla danış')) + '</button>' +
            '</div>' +
          '</div>' +
        '</div>';
      val.parentNode.insertBefore(sec, val);

      function calc() {
        const price = Number(document.getElementById('mcPrice').value) || 0;
        const downPct = Number(document.getElementById('mcDown').value) || 0;
        const years = Number(document.getElementById('mcYears').value) || 1;
        const rate = Number(document.getElementById('mcRate').value) || 0;

        const down = price * downPct / 100;
        const loan = Math.max(0, price - down);
        const r = rate / 100 / 12;
        const n = years * 12;
        const monthly = r > 0 ? loan * r / (1 - Math.pow(1 + r, -n)) : loan / n;
        const totalPaid = monthly * n;
        const interest = Math.max(0, totalPaid - loan);

        const fmt = function (v) { return DK.money(Math.round(v)); };
        document.getElementById('mcMonthly').textContent = fmt(monthly);
        document.getElementById('mcLoan').textContent = fmt(loan);
        document.getElementById('mcInterest').textContent = fmt(interest);
        return { price: price, down: down, loan: loan, years: years, rate: rate, monthly: monthly, interest: interest };
      }

      ['mcPrice', 'mcDown', 'mcYears', 'mcRate'].forEach(function (id) {
        const el = document.getElementById(id);
        el.addEventListener('input', calc);
        el.addEventListener('change', calc);
      });
      calc();

      document.getElementById('mcApply').addEventListener('click', function () {
        const m = calc();
        DK.order({
          eyebrow: DK.pick('İPOTEKA MƏSLƏHƏTİ', 'MORTGAGE ADVICE', 'ИПОТЕЧНАЯ КОНСУЛЬТАЦИЯ', 'İPOTEKA DANIŞMANLIĞI'),
          title: DK.pick('İpoteka üzrə müraciət', 'Mortgage application', 'Заявка на ипотеку', 'İpoteka başvurusu'),
          brand: 'SkyVilla',
          addressRequired: false,
          summary: DK.pick('Əmlak: ' + DK.money(m.price) + ' · İlkin: ' + DK.money(m.down) +
                          ' · Kredit: ' + DK.money(m.loan) + ' · ' + m.years + ' il · ' + m.rate + '%',
                          'Property: ' + DK.money(m.price) + ' · Down: ' + DK.money(m.down) +
                          ' · Loan: ' + DK.money(m.loan) + ' · ' + m.years + ' yrs · ' + m.rate + '%',
                          'Объект: ' + DK.money(m.price) + ' · Взнос: ' + DK.money(m.down) +
                          ' · Кредит: ' + DK.money(m.loan) + ' · ' + m.years + ' лет · ' + m.rate + '%',
                          'Emlak: ' + DK.money(m.price) + ' · Peşinat: ' + DK.money(m.down) +
                          ' · Kredi: ' + DK.money(m.loan) + ' · ' + m.years + ' yıl · ' + m.rate + '%'),
          lines: [
            DK.pick('Aylıq ödəniş: ' + DK.money(m.monthly), 'Monthly payment: ' + DK.money(m.monthly),
                    'Платёж в месяц: ' + DK.money(m.monthly), 'Aylık ödeme: ' + DK.money(m.monthly))
          ]
        });
      });
    })();
  </script>
</body>
</html>
