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
    'brand_name' => 'VITA APTEK 24/7',
    'brand_sub' => 'Onlayn Əczaçılıq & Sağlamlıq',
    'rx_notice' => '⚠️ DİQQƏT: Reseptli preparatlar yalnız həkim tərəfindən yazılmış təyinat təqdim edildikdən sonra buraxılır.',
    'nav_catalog' => 'Dərmanlar & Vitaminlər',
    'nav_rx' => 'Resept Göndər',
    'nav_tips' => 'Sağlamlıq Məsləhətləri',
    'nav_delivery' => '24/7 Çatdırılma',
    'hero_tag' => '24/7 ONLAYN APTEK VƏ ÇATDIRILMA',
    'hero_title_1' => 'Sağlamlığınız Bizim,',
    'hero_title_2' => 'Ən Böyük Prioritetimizdir.',
    'hero_desc' => '100% orijinal lisenziyalı dərmanlar, vitaminlər və tibbi avadanlıqlar. Xüsusi termo-qablaşdırma ilə Bakı daxili 45 dəqiqəyə çatdırılma.',
    'search_ph' => 'Dərman adı, tərkib və ya vitamin axtarın...',
    'btn_upload_rx' => 'Reseptini Yüklə',
    'btn_ask_pharma' => 'Əczaçı ilə Məsləhət',
    'filter_all' => 'Bütün Məhsullar',
    'filter_vitamins' => 'Vitaminlər & İmmunitet',
    'filter_pain' => 'Soyuqdəymə & Ağrıkəsici',
    'filter_derma' => 'Dəri & Kosmetika',
    'filter_baby' => 'Körpə & Ana',
    'filter_devices' => 'Tibbi Cihazlar',
    'btn_add_med' => 'Səbətə At',
    'tag_otc' => 'Reseptsiz',
    'tag_rx' => 'Reseptlə',
    'cart_title' => 'Dərman Səbəti',
    'cart_empty' => 'Səbətinizdə hələ dərman yoxdur',
    'cart_total' => 'Cəmi:',
    'btn_checkout_wa' => 'Sifarişi WhatsApp-la Tamamla',
    'tips_title' => 'Həkim & Əczaçı Məsləhətləri',
    'tips_desc' => 'Sağlam həyat tərzi və dərmanların düzgün qəbulu üçün faydalı tövsiyələr',
    'tip_1_t' => 'D Vitamini və İmmunitet',
    'tip_1_d' => 'D vitaminini yağlı yeməklərlə qəbul etmək sorulmanı 50% artırır.',
    'tip_2_t' => 'Antibiotik və Probiotiklər',
    'tip_2_d' => 'Bağırsaq mikroflorasını qorumaq üçün antibiotikdən 2 saat sonra probiotik için.',
    'tip_3_t' => 'Dərmanların Saxlanma Qaydası',
    'tip_3_d' => 'Dərmanları rütubətli vanna otağında yox, qaranlıq və quru yerdə saxlayın.',
    'rx_modal_title' => 'Reseptinizi Yükləyin — AI Resept Skaneri (OCR)',
    'rx_modal_desc' => 'Həkimin əl xətti ilə yazdığı resepti yükləyin və ya hazır nümunə seçin. Sistem resepti oxuyur, aptek anbarında mövcudluğu yoxlayır və alternativ məlumat təqdim edir.',
    'btn_send_rx' => 'Resepti WhatsApp-la Göndər',
    'rx_samples_title' => '⚡ Hazır Əl Xətti Resept Nümunələri (Sınaq üçün klikləyin):',
    'rx_sample_1' => '🧪 Nümunə #1: Qrip & İnfeksiya (Parasetamol, Amoksisillin, C Vitamini)',
    'rx_sample_2' => '❤️ Nümunə #2: Hipertoniya & Kardio (Kardiomaqnil, Magne B6, Amlodipin)',
    'rx_sample_3' => '🩺 Nümunə #3: Mədə & Ağrı (Omez, Nurofen Forte, Azitromisin)',
    'rx_ocr_title' => '📝 Tanınmış Mətn (Düzəliş edə bilərsiniz):',
    'rx_btn_recheck' => '🔄 Düzəlişdən Sonra Anbarı Yenidən Yoxla',
    'rx_stock_title' => '📦 Aptek Anbarı ilə Canlı Yoxlanış Nəticəsi:',
    'rx_disclaimer_title' => '⚠️ QANUNİ VƏ TİBBİ XƏBƏRDARLIQ:',
    'rx_disclaimer_text' => 'Təqdim olunan alternativlər yalnız məlumat xarakterlidir. Süni intellekt və ya aptek heç bir halda resepti dəyişdirə və ya yeni dərman təyin edə bilməz. Hər hansı dərman və ya analoq yalnız lisenziyalı həkim və ya əczaçı rəsmi təsdiqindən sonra qəbul edilməlidir.',
    'rx_confirm_text' => 'Təsdiq edirəm ki, təqdim etdiyim resept lisenziyalı həkim tərəfindən yazılmışdır və dərmanlar əczaçı tərəfindən yoxlanıldıqdan sonra təhvil veriləcəkdir.',
    'rx_btn_add_avail' => '🛒 Bütün Mövcud Dərmanları Səbətə Yığ',
    'rx_btn_wa_order' => '💬 Resepti və Dərmanları Əczaçıya Göndər',
    'footer_desc' => 'Vita Aptek — müasir rəqəmsal əczaçılıq sistemi. Skyweb.az tərəfindən apteklər və tibbi mərkəzlər üçün hazırlanmışdır.',
    'footer_rights' => 'Bütün hüquqlar qorunur.',
  ],
  'en' => [
    'demo_banner' => 'This is a demo website — Created by Skyweb',
    'back_to_sky' => 'Back to Skyweb',
    'order_site' => 'Order This Website',
    'brand_name' => 'VITA PHARMACY 24/7',
    'brand_sub' => 'Digital Pharmacy & Health Depot',
    'rx_notice' => '⚠️ NOTICE: Prescription medications require a validated physician prescription upon delivery.',
    'nav_catalog' => 'Medicines & Vitamins',
    'nav_rx' => 'Upload Prescription',
    'nav_tips' => 'Health Advice',
    'nav_delivery' => '24/7 Delivery',
    'hero_tag' => '24/7 LICENSED ONLINE PHARMACY',
    'hero_title_1' => 'Your Health and Wellness,',
    'hero_title_2' => 'Delivered in 45 Minutes.',
    'hero_desc' => '100% genuine certified pharmaceutical supplies, immunity vitamins, and home diagnostics. Cold-chain guaranteed delivery across Baku.',
    'search_ph' => 'Search medicine, active ingredient or supplement...',
    'btn_upload_rx' => 'Upload Prescription',
    'btn_ask_pharma' => 'Consult Pharmacist',
    'filter_all' => 'All Products',
    'filter_vitamins' => 'Vitamins & Immunity',
    'filter_pain' => 'Cold & Pain Relief',
    'filter_derma' => 'Derma & Skincare',
    'filter_baby' => 'Baby & Mother',
    'filter_devices' => 'Medical Diagnostics',
    'btn_add_med' => 'Add to Bag',
    'tag_otc' => 'OTC',
    'tag_rx' => 'Prescription Only',
    'cart_title' => 'Pharmacy Bag',
    'cart_empty' => 'Your pharmacy bag is empty',
    'cart_total' => 'Total:',
    'btn_checkout_wa' => 'Complete Order via WhatsApp',
    'tips_title' => 'Health & Wellness Insights',
    'tips_desc' => 'Practical medical advice curated by registered pharmacists',
    'tip_1_t' => 'Vitamin D & Immunity',
    'tip_1_d' => 'Take fat-soluble Vitamin D with healthy fats for 50% higher absorption.',
    'tip_2_t' => 'Antibiotics & Probiotics',
    'tip_2_d' => 'Separate probiotic intake by at least 2 hours from your antibiotic dosage.',
    'tip_3_t' => 'Safe Medicine Storage',
    'tip_3_d' => 'Never store medications in humid bathrooms; use dry, dark cupboards.',
    'rx_modal_title' => 'Prescription Scanner — AI Handwriting OCR',
    'rx_modal_desc' => 'Upload handwritten prescription or select a sample. The system transcribes items, checks live pharmacy inventory, and suggests informational alternatives.',
    'btn_send_rx' => 'Send Prescription via WhatsApp',
    'rx_samples_title' => '⚡ Handwritten Prescription Samples (Click to test):',
    'rx_sample_1' => '🧪 Sample #1: Flu & Infection (Paracetamol, Amoxicillin, Vitamin C)',
    'rx_sample_2' => '❤️ Sample #2: Hypertension & Cardio (Cardiomagnyl, Magne B6, Amlodipine)',
    'rx_sample_3' => '🩺 Sample #3: Gastro & Pain (Omez, Nurofen Forte, Azithromycin)',
    'rx_ocr_title' => '📝 Recognized Prescription Text (Editable):',
    'rx_btn_recheck' => '🔄 Re-check Inventory with Updated Text',
    'rx_stock_title' => '📦 Live Pharmacy Stock Check Results:',
    'rx_disclaimer_title' => '⚠️ LEGAL & MEDICAL DISCLAIMER:',
    'rx_disclaimer_text' => 'Suggested alternatives are for informational guidance only. The AI and pharmacy system never prescribe medications or alter prescriptions. Any substitution must be confirmed by a licensed doctor or pharmacist.',
    'rx_confirm_text' => 'I certify that this prescription is issued by a licensed physician and will be inspected and dispensed by a certified pharmacist.',
    'rx_btn_add_avail' => '🛒 Add In-Stock Items to Bag',
    'rx_btn_wa_order' => '💬 Forward Prescription to Pharmacist via WhatsApp',
    'footer_desc' => 'Vita Pharmacy — seamless online pharmacy platform. Engineered by Skyweb.az for pharmaceutical businesses.',
    'footer_rights' => 'All rights reserved.',
  ],
  'tr' => [
    'demo_banner' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
    'back_to_sky' => 'Skyweb\'e Dön',
    'order_site' => 'Bu Siteyi Sipariş Et',
    'brand_name' => 'VİTA ECZANE 24/7',
    'brand_sub' => 'Online Eczane & Sağlık Deposu',
    'rx_notice' => '⚠️ DİKKAT: Reçeteli ilaçlar sadece hekim reçetesi ibraz edildikten sonra temin edilmektedir.',
    'nav_catalog' => 'İlaçlar & Vitaminler',
    'nav_rx' => 'Reçete Gönder',
    'nav_tips' => 'Sağlık İpuçları',
    'nav_delivery' => '7/24 Teslimat',
    'hero_tag' => '7/24 NÖBETÇİ ONLİNE ECZANE',
    'hero_title_1' => 'Sağlığınız ve Konforunuz,',
    'hero_title_2' => '45 Dakikada Kapınızda.',
    'hero_desc' => '%100 orijinal ve ruhsatlı ilaçlar, bağışıklık vitaminleri ve medikal cihazlar. Soğuk zincir güvencesiyle 45 dakikada hızlı teslimat.',
    'search_ph' => 'İlaç adı, etken madde veya vitamin arayın...',
    'btn_upload_rx' => 'Reçeteni Yükle',
    'btn_ask_pharma' => 'Eczacıya Danış',
    'filter_all' => 'Tüm Ürünler',
    'filter_vitamins' => 'Vitaminler & Bağışıklık',
    'filter_pain' => 'Ağrı Kesici & Soğuk Algınlığı',
    'filter_derma' => 'Dermokozmetik',
    'filter_baby' => 'Anne & Bebek',
    'filter_devices' => 'Medikal Cihazlar',
    'btn_add_med' => 'Sepete Ekle',
    'tag_otc' => 'Reçetesiz',
    'tag_rx' => 'Reçeteli',
    'cart_title' => 'İlaç Sepetiniz',
    'cart_empty' => 'Sepetinizde ürün bulunmamaktadır',
    'cart_total' => 'Toplam:',
    'btn_checkout_wa' => 'WhatsApp ile Siparişi Tamamla',
    'tips_title' => 'Eczacı & Sağlık Rehberi',
    'tips_desc' => 'Uzman eczacılarımızdan sağlıklı ve zinde bir yaşam için altın tavsiyeler',
    'tip_1_t' => 'D Vitamini Kullanımı',
    'tip_1_d' => 'D vitamini yağda çözündüğü için yemeklerle birlikte emilimi maksimuma çıkar.',
    'tip_2_t' => 'Probiyotik Desteği',
    'tip_2_d' => 'Antibiyotik tedavisinde bağırsak florasını korumak için 2 saat arayla probiyotik alın.',
    'tip_3_t' => 'İlaç Saklama Koşulları',
    'tip_3_d' => 'İlaçlarınızı nemli banyolarda değil, serin ve güneş görmeyen yerlerde saklayın.',
    'rx_modal_title' => 'Yapay Zeka El Yazısı Reçete Tarayıcısı (OCR)',
    'rx_modal_desc' => 'Hekiminizin el yazısıyla yazdığı reçeteyi yükleyin veya hazır örnekleri test edin.',
    'btn_send_rx' => 'Reçeteyi WhatsApp ile Gönder',
    'rx_samples_title' => '⚡ Hazır El Yazısı Reçete Örnekleri (Test için tıklayın):',
    'rx_sample_1' => '🧪 Örnek #1: Grip & Enfeksiyon (Parasetamol, Amoksisilin, C Vitamini)',
    'rx_sample_2' => '❤️ Örnek #2: Hipertansiyon & Kardiyo (Kardiomagnil, Magne B6, Amlodipin)',
    'rx_sample_3' => '🩺 Örnek #3: Mide & Ağrı (Omez, Nurofen Forte, Azitromisin)',
    'rx_ocr_title' => '📝 Tanınan Metin (Düzenlenebilir):',
    'rx_btn_recheck' => '🔄 Düzenlemeyi Onayla ve Stoğu Yeniden Sorgula',
    'rx_stock_title' => '📦 Eczane Stoğu ile Eşleşme:',
    'rx_disclaimer_title' => '⚠️ YASAL VE TIBBİ UYARI:',
    'rx_disclaimer_text' => 'Sunulan muadil bilgileri yalnızca bilgilendirme amaçlıdır. Yapay zeka ve sistem asla reçete değiştiremez veya ilaç yazamaz. Değişim yalnızca uzman hekim veya eczacı onayı ile mümkündür.',
    'rx_confirm_text' => 'Bu reçetenin yetkili bir doktor tarafından yazıldığını ve eczacı kontrolü sonrası temin edileceğini onaylıyorum.',
    'rx_btn_add_avail' => '🛒 Mevcut İlaçları Sepete Ekle',
    'rx_btn_wa_order' => '💬 Reçeteyi WhatsApp ile Eczacıya İlet',
    'footer_desc' => 'Vita Eczane — modern dijital eczane çözümü. Skyweb.az tarafından sağlık sektörü için geliştirildi.',
    'footer_rights' => 'Tüm hakları saklıdır.',
  ],
  'ru' => [
    'demo_banner' => 'Это демонстрационный сайт — Создано Skyweb',
    'back_to_sky' => 'Вернуться в Skyweb',
    'order_site' => 'Заказать такой сайт',
    'brand_name' => 'VITA АПТЕКА 24/7',
    'brand_sub' => 'Онлайн-аптека и здоровье',
    'rx_notice' => '⚠️ ВНИМАНИЕ: Рецептурные препараты отпускаются строго при наличии рецепта врача.',
    'nav_catalog' => 'Препараты и витамины',
    'nav_rx' => 'Отправить рецепт',
    'nav_tips' => 'Советы фармацевта',
    'nav_delivery' => 'Доставка 24/7',
    'hero_tag' => 'КРУГЛОСУТОЧНАЯ ОНЛАЙН-АПТЕКА',
    'hero_title_1' => 'Забота о здоровье,',
    'hero_title_2' => 'С доставкой за 45 минут.',
    'hero_desc' => '100% оригинальные сертифицированные препараты, витаминные комплексы и домашняя медтехника. Соблюдение температурного режима при доставке.',
    'search_ph' => 'Поиск лекарств, действующих веществ или витаминов...',
    'btn_upload_rx' => 'Загрузить рецепт',
    'btn_ask_pharma' => 'Консультация провизора',
    'filter_all' => 'Все препараты',
    'filter_vitamins' => 'Витамины и иммунитет',
    'filter_pain' => 'От простуды и боли',
    'filter_derma' => 'Дермокосметика',
    'filter_baby' => 'Мама и малыш',
    'filter_devices' => 'Медицинские приборы',
    'btn_add_med' => 'В корзину',
    'tag_otc' => 'Без рецепта',
    'tag_rx' => 'По рецепту',
    'cart_title' => 'Корзина препаратов',
    'cart_empty' => 'В корзине пока нет товаров',
    'cart_total' => 'Итого:',
    'btn_checkout_wa' => 'Оформить через WhatsApp',
    'tips_title' => 'Советы фармацевтов',
    'tips_desc' => 'Полезные рекомендации врачей для поддержания здоровья',
    'tip_1_t' => 'Прием витамина D',
    'tip_1_d' => 'Витамин D лучше усваивается во время приема жиросодержащей пищи.',
    'tip_2_t' => 'Антибиотики и пробиотики',
    'tip_2_d' => 'Принимайте пробиотик через 2 часа после приема антибиотика для защиты кишечника.',
    'tip_3_t' => 'Правильное хранение',
    'tip_3_d' => 'Не храните лекарства в ванной комнате; выбирайте сухое и темное место.',
    'rx_modal_title' => 'Сканер рецептов — AI распознавание почерка (OCR)',
    'rx_modal_desc' => 'Загрузите фото рукописного рецепта врача или выберите тестовый образец.',
    'btn_send_rx' => 'Отправить рецепт в WhatsApp',
    'rx_samples_title' => '⚡ Образцы рукописных рецептов (Нажмите для теста):',
    'rx_sample_1' => '🧪 Образец #1: Простуда и инфекция (Парацетамол, Амоксициллин, Витамин C)',
    'rx_sample_2' => '❤️ Образец #2: Кардиология (Кардиомагнил, Магне B6, Амлодипин)',
    'rx_sample_3' => '🩺 Образец #3: ЖКТ и боль (Омез, Нурофен Форте, Азитромицин)',
    'rx_ocr_title' => '📝 Распознанный текст рецепта (с возможностью правки):',
    'rx_btn_recheck' => '🔄 Перепроверить наличие по обновленному тексту',
    'rx_stock_title' => '📦 Проверка наличия на складе аптеки:',
    'rx_disclaimer_title' => '⚠️ ПРЕДУПРЕЖДЕНИЕ О БЕЗОПАСНОСТИ:',
    'rx_disclaimer_text' => 'Информация об аналогах носит исключительно справочный характер. ИИ и аптека не назначают лекарства и не изменяют рецепт. Замена препарата возможна строго после согласования с лицензированным врачом или провизором.',
    'rx_confirm_text' => 'Подтверждаю, что данный рецепт выписан врачом и препарат будет проверен лицензированным фармацевтом.',
    'rx_btn_add_avail' => '🛒 Добавить препараты в наличии в корзину',
    'rx_btn_wa_order' => '💬 Отправить рецепт провизору в WhatsApp',
    'footer_desc' => 'Vita Аптека — цифровая экосистема для фармацевтики. Разработано веб-студией Skyweb.az.',
    'footer_rights' => 'Все права защищены.',
  ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$medicines = [
  [
    'id' => 301,
    'cat' => 'vitamins',
    'price' => 18.50,
    'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Supradyn Daily Multivitamin + CoQ10',
      'en' => 'Supradyn Daily Multivitamin + CoQ10',
      'tr' => 'Supradyn Günlük Multivitamin + Koenzim',
      'ru' => 'Супрадин Дейли Мультивитамин + CoQ10',
    ],
    'desc' => [
      'az' => '13 vitamin və 9 mineral kompleksi, gündəlik enerji səviyyəsini yüksəldir.',
      'en' => 'Comprehensive blend of 13 vitamins and 9 minerals to support vitality and focus.',
      'tr' => '13 vitamin ve 9 mineral içeren zengin formül, günlük enerjiyi artırır.',
      'ru' => 'Комплекс из 13 витаминов и 9 минералов для поддержания бодрости и тонуса.',
    ],
  ],
  [
    'id' => 302,
    'cat' => 'vitamins',
    'price' => 28.00,
    'image' => 'https://images.unsplash.com/photo-1550572017-edd951aa8f72?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Möller\'s Omega-3 Balıq Yağı Limonlu 250ml',
      'en' => 'Möller\'s Pure Arctic Cod Liver Oil 250ml',
      'tr' => 'Möller\'s Saf Morina Balık Yağı 250ml',
      'ru' => 'Möller\'s Рыбий жир с лимонным вкусом 250мл',
    ],
    'desc' => [
      'az' => 'Təbii Norveç treska qaraciyəri yağı, EPA & DHA, ürək və beyin fəaliyyətini gücləndirir.',
      'en' => 'Pure Norwegian wild cod liver oil enriched with natural EPA, DHA and Vitamin D.',
      'tr' => 'Doğal Norveç morina balığı yağı, EPA & DHA ile beyin ve kalp sağlığını destekler.',
      'ru' => 'Натуральный норвежский рыбий жир с омега-3 и витамином D3 для сосудов и мозга.',
    ],
  ],
  [
    'id' => 303,
    'cat' => 'pain',
    'price' => 6.80,
    'image' => 'https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Nurofen Express Forte 400mg Kapsul',
      'en' => 'Nurofen Express Forte 400mg Fast Acting',
      'tr' => 'Nurofen Hızlı Etkili 400mg Ağrı Kesici',
      'ru' => 'Нурофен Экспресс Форте 400мг',
    ],
    'desc' => [
      'az' => 'Maye kapsul forması sayəsində 10 dəqiqəyə baş, diş və əzələ ağrılarını kəsir.',
      'en' => 'Liquid capsule format absorbed twice as fast for rapid headache and fever relief.',
      'tr' => 'Sıvı jel kapsül teknolojisiyle baş, diş ve kas ağrılarına dakikalar içinde son verir.',
      'ru' => 'Быстродействующие жидкие капсулы против головной боли, жара и воспаления.',
    ],
  ],
  [
    'id' => 304,
    'cat' => 'pain',
    'price' => 3.50,
    'image' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Paracetamol Extra 500mg Qızdırmasalıcı',
      'en' => 'Paracetamol Extra 500mg Antipyretic',
      'tr' => 'Parasetamol Ekstra 500mg Ateş Düşürücü',
      'ru' => 'Парацетамол Экстра 500мг жаропонижающее',
    ],
    'desc' => [
      'az' => 'Yüksək temperatur, qrip və kəskin soyuqdəymə simptomlarına qarşı sürətli təsir.',
      'en' => 'Rapid relief from high fever, cold, and flu symptoms for adults and children over 12.',
      'tr' => 'Yüksek ateş, grip ve soğuk algınlığı semptomlarında hızlı ve güvenilir etki.',
      'ru' => 'Быстрое снижение температуры и купирование болевого синдрома при простуде.',
    ],
  ],
  [
    'id' => 305,
    'cat' => 'pain',
    'price' => 14.20,
    'image' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=600&auto=format&fit=crop&q=80',
    'rx' => true,
    'in_stock' => true,
    'title' => [
      'az' => 'Amoxicillin Forte 500mg (Reseptli)',
      'en' => 'Amoxicillin Forte 500mg (Rx Only)',
      'tr' => 'Amoksisilin 500mg Kapsül (Reçeteli)',
      'ru' => 'Амоксициллин Форте 500мг (По рецепту)',
    ],
    'desc' => [
      'az' => 'Geniş spektrli antibakterial preparat. Yalnız həkim resepti ilə buraxılır.',
      'en' => 'Broad-spectrum antibacterial therapy. Strictly dispensed upon physician prescription.',
      'tr' => 'Geniş spektrumlu antibakteriyel ilaç. Yalnızca doktor reçetesi ile verilir.',
      'ru' => 'Антибактериальный препарат широкого спектра. Отпускается строго по рецепту врача.',
    ],
  ],
  [
    'id' => 306,
    'cat' => 'vitamins',
    'price' => 16.80,
    'image' => 'https://images.unsplash.com/photo-1576073719676-aa955fc6b549?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Magne B6 Forte Stress & Əsəb Dəstəyi',
      'en' => 'Magne B6 Forte Stress Relief Formula',
      'tr' => 'Magne B6 Forte Stres & Sinir Desteği',
      'ru' => 'Магне B6 Форте поддержка нервной системы',
    ],
    'desc' => [
      'az' => 'Maqnezium və vitamin B6 kompleksi yuxunu tənzimləyir, əzələ qıcolmalarını azaldır.',
      'en' => 'Synergistic magnesium and B6 formula supports deep sleep and prevents muscle cramps.',
      'tr' => 'Magnezyum ve B6 kompleksi uyku kalitesini artırır ve kramp oluşumunu engeller.',
      'ru' => 'Органический магний и витамин B6 для борьбы со стрессом, судорогами и бессонницей.',
    ],
  ],
  [
    'id' => 307,
    'cat' => 'pain',
    'price' => 8.50,
    'image' => 'https://images.unsplash.com/photo-1550572017-edd951aa8f72?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Omez 20mg Mədə Qoruyucu (Omeprazol)',
      'en' => 'Omez 20mg Gastro-Resistant (Omeprazole)',
      'tr' => 'Omez 20mg Mide Koruyucu (Omeprazol)',
      'ru' => 'Омез 20мг гастропротектор (Омепразол)',
    ],
    'desc' => [
      'az' => 'Qastrit, qıcqırma və mədə turşuluğuna qarşı effektiv proton nasosu inhibitoru.',
      'en' => 'Proton pump inhibitor effectively treating heartburn, acid reflux and gastritis.',
      'tr' => 'Mide ekşimesi, reflü ve gastrit tedavisinde yüksek etkili proton pompa inhibitörü.',
      'ru' => 'Эффективная защита слизистой оболочки желудка и снижение кислотности.',
    ],
  ],
  [
    'id' => 308,
    'cat' => 'vitamins',
    'price' => 12.00,
    'image' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Vitamin C 1000mg + Sink Şirəli Tablet',
      'en' => 'Vitamin C 1000mg + Zinc Effervescent',
      'tr' => 'C Vitamini 1000mg + Çinko Efervesan',
      'ru' => 'Витамин C 1000мг + Цинк шипучие таблетки',
    ],
    'desc' => [
      'az' => 'Maksimum immunitet kalkanı, portağal dadlı suda həll olan 20 ədəd efervesan tablet.',
      'en' => 'Triple defense immunity boost, 20 high-potency orange-flavored effervescent tablets.',
      'tr' => 'Güçlü bağışıklık desteği sunan portakal aromalı 20 adet suda çözünen tablet.',
      'ru' => 'Мощный антиоксидант и стимулятор иммунитета с приятным вкусом апельсина.',
    ],
  ],
  [
    'id' => 309,
    'cat' => 'pain',
    'price' => 7.20,
    'image' => 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=600&auto=format&fit=crop&q=80',
    'rx' => true,
    'in_stock' => true,
    'title' => [
      'az' => 'Amlodipin 5mg Hipertoniya Əleyhinə',
      'en' => 'Amlodipine 5mg Blood Pressure Control',
      'tr' => 'Amlodipin 5mg Tansiyon Düzenleyici',
      'ru' => 'Амлодипин 5мг гипотензивный препарат',
    ],
    'desc' => [
      'az' => 'Arterial təzyiqi stabilləşdirən kalsium kanalları blokatoru. Yalnız həkim nəzarəti ilə.',
      'en' => 'Calcium channel blocker for precise blood pressure stabilization and cardio health.',
      'tr' => 'Yüksek tansiyonu dengede tutan kalsiyum kanal blokeri. Hekim kontrolü ile.',
      'ru' => 'Антигипертензивный препарат для нормализации артериального давления.',
    ],
  ],
  [
    'id' => 310,
    'cat' => 'derma',
    'price' => 26.50,
    'image' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'La Roche-Posay Anthelios SPF 50+ Krem',
      'en' => 'La Roche-Posay Anthelios Invisible Fluid SPF 50+',
      'tr' => 'La Roche-Posay Görünmez Güneş Kremi SPF 50+',
      'ru' => 'Солнцезащитный флюид La Roche-Posay SPF 50+',
    ],
    'desc' => [
      'az' => 'Ultra yüngül tekstura, ləkə qoymur, həssas dərilər üçün maksimal UVA/UVB qorunması.',
      'en' => 'Ultra-light invisible fluid, non-greasy, maximum broad-spectrum sun shield.',
      'tr' => 'Ağırlık yapmayan görünmez doku, hassas ciltler için maksimum UVA/UVB kalkanı.',
      'ru' => 'Ультралегкая текстура без белых следов, защита от пигментации и ожогов.',
    ],
  ],
  [
    'id' => 311,
    'cat' => 'baby',
    'price' => 22.00,
    'image' => 'https://images.unsplash.com/photo-1608248597359-58683526012c?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Bioderma Atoderm Körpə Bədən Kremi 500ml',
      'en' => 'Bioderma Atoderm Nourishing Baby Cream 500ml',
      'tr' => 'Bioderma Atoderm Bebek Nemlendirici Krem 500ml',
      'ru' => 'Увлажняющий крем для младенцев Bioderma 500мл',
    ],
    'desc' => [
      'az' => 'Körpələrin həssas dərisini 24 saat intensiv nəmləndirir, qızartı və qaşınmanı aradan qaldırır.',
      'en' => '24h intense dermal hydration, soothes dry sensitive baby skin with hypoallergenic lipids.',
      'tr' => 'Bebeklerin hassas cildi için 24 saat yatıştırıcı nem bariyeri, parfümsüz.',
      'ru' => 'Гипоаллергенный защитный крем для сухой и чувствительной кожи малышей.',
    ],
  ],
  [
    'id' => 312,
    'cat' => 'devices',
    'price' => 64.00,
    'image' => 'https://images.unsplash.com/photo-1631815588090-d4bfec5b1ccb?w=600&auto=format&fit=crop&q=80',
    'rx' => false,
    'in_stock' => true,
    'title' => [
      'az' => 'Microlife Avtomatik Qol Təzyiqölçən Aparat',
      'en' => 'Microlife Upper Arm Blood Pressure Monitor',
      'tr' => 'Microlife Otomatik Koldan Tansiyon Aleti',
      'ru' => 'Автоматический тонометр на плечо Microlife',
    ],
    'desc' => [
      'az' => 'İsveçrə dəqiqliyi, aritmiya aşkarlama sensoru və 30 ölçümlük yaddaş bloku.',
      'en' => 'Swiss precision clinical sensor with arrhythmia detection and 30-reading memory.',
      'tr' => 'İsviçre hassasiyetli klinik onaylı sensör, ritim bozukluğu uyarısı ve geniş hafıza.',
      'ru' => 'Швейцарская точность, датчик аритмии и память на 30 измерений с датой и временем.',
    ],
  ],
];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($t['brand_name']) ?> — Skyweb Pharmacy Demo</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: rgba(0, 32, 38, 0.85);
      --sky-border: rgba(0, 255, 255, 0.18);
      --neon-cyan: #00FFFF;
      --med-emerald: #10b981;
      --med-amber: #f59e0b;
      --neon-glow: 0 0 20px rgba(0, 255, 255, 0.35);
      --text-main: #f0fefe;
      --text-muted: #8ec5c5;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: linear-gradient(180deg, #001416 0%, #001e22 30%, #002830 70%, #001214 100%);
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
      background: rgba(0, 24, 26, 0.95);
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

    /* Prescription Notice Ribbon */
    .rx-ribbon {
      background: rgba(245, 158, 11, 0.15);
      border-bottom: 1px solid rgba(245, 158, 11, 0.3);
      color: #fbbf24;
      padding: 8px 16px;
      font-size: 12px;
      font-weight: 600;
      text-align: center;
    }

    /* Pharmacy Navbar */
    .pharma-nav {
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
    .brand-box {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .brand-cross-icon {
      width: 44px;
      height: 44px;
      background: radial-gradient(circle, rgba(16,185,129,0.3) 0%, rgba(0,34,40,0.9) 100%);
      border: 1.5px solid var(--med-emerald);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      box-shadow: 0 0 15px rgba(16,185,129,0.3);
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
      color: var(--med-emerald);
      font-weight: 600;
      text-transform: uppercase;
    }
    .hotline-pill {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(0, 255, 255, 0.08);
      border: 1px solid var(--sky-border);
      border-radius: 30px;
      padding: 6px 14px;
      font-size: 13px;
      font-weight: 700;
      color: var(--neon-cyan);
    }
    .cart-pharma-btn {
      background: rgba(0, 255, 255, 0.1);
      border: 1px solid var(--sky-border);
      color: var(--neon-cyan);
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.2s;
    }
    .cart-pharma-btn:hover {
      background: rgba(0, 255, 255, 0.2);
      box-shadow: var(--neon-glow);
    }
    .badge-count {
      background: var(--neon-cyan);
      color: #001a1a;
      font-size: 11px;
      font-weight: 800;
      padding: 1px 7px;
      border-radius: 12px;
    }

    /* Hero Section */
    .pharma-hero {
      max-width: 1240px;
      margin: 0 auto;
      padding: 60px 24px 40px;
      text-align: center;
    }
    .hero-tag {
      display: inline-block;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 2px;
      color: var(--med-emerald);
      background: rgba(16, 185, 129, 0.12);
      border: 1px solid rgba(16, 185, 129, 0.3);
      padding: 6px 16px;
      border-radius: 30px;
      margin-bottom: 20px;
      text-transform: uppercase;
    }
    .hero-h1 {
      font-family: var(--font-heading);
      font-size: clamp(32px, 5vw, 54px);
      line-height: 1.15;
      font-weight: 900;
      color: #fff;
      margin-bottom: 16px;
    }
    .hero-h1 .glow-cyan {
      color: var(--neon-cyan);
      text-shadow: 0 0 25px rgba(0,255,255,0.4);
    }
    .hero-sub {
      color: var(--text-muted);
      font-size: 16px;
      max-width: 620px;
      margin: 0 auto 30px;
      line-height: 1.6;
    }

    /* Live Search Bar */
    .search-box-wrap {
      max-width: 650px;
      margin: 0 auto 30px;
      position: relative;
    }
    .search-input {
      width: 100%;
      background: rgba(0, 32, 40, 0.85);
      border: 1.5px solid var(--sky-border);
      border-radius: 40px;
      padding: 16px 26px 16px 54px;
      color: #fff;
      font-size: 15px;
      font-family: inherit;
      outline: none;
      box-shadow: 0 10px 30px rgba(0,0,0,0.4);
      transition: all 0.25s;
    }
    .search-input:focus {
      border-color: var(--neon-cyan);
      box-shadow: var(--neon-glow);
    }
    .search-icon-fixed {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      color: var(--neon-cyan);
    }

    /* Quick Hero Action Buttons */
    .quick-actions {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 14px;
      margin-bottom: 50px;
    }
    .btn-action-rx {
      background: linear-gradient(135deg, var(--neon-cyan) 0%, #00b4d8 100%);
      color: #001a1a;
      font-weight: 700;
      font-size: 14px;
      padding: 12px 22px;
      border-radius: 10px;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      box-shadow: 0 0 20px rgba(0,255,255,0.3);
      transition: all 0.25s;
    }
    .btn-action-rx:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(0,255,255,0.5);
    }
    .btn-action-pharma {
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid var(--med-emerald);
      color: var(--med-emerald);
      font-weight: 700;
      font-size: 14px;
      padding: 12px 22px;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.25s;
    }
    .btn-action-pharma:hover {
      background: var(--med-emerald);
      color: #001a1a;
      box-shadow: 0 0 20px rgba(16,185,129,0.5);
    }

    /* Catalog Section */
    .catalog-wrap {
      max-width: 1240px;
      margin: 0 auto 70px;
      padding: 0 24px;
    }
    .filter-tabs {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 36px;
    }
    .tab-item {
      background: rgba(0, 32, 40, 0.7);
      border: 1px solid rgba(0, 255, 255, 0.15);
      color: var(--text-muted);
      padding: 9px 18px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 600;
      transition: all 0.25s ease;
    }
    .tab-item:hover, .tab-item.active {
      background: var(--neon-cyan);
      color: #001a1a;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.4);
    }

    /* Product Grid */
    .med-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 26px;
    }
    .med-card {
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
    .med-card:hover {
      transform: translateY(-6px);
      border-color: var(--med-emerald);
      box-shadow: 0 15px 35px rgba(0,0,0,0.5), 0 0 20px rgba(16,185,129,0.25);
    }
    .badge-status {
      position: absolute;
      top: 16px;
      left: 16px;
      font-size: 11px;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
    }
    .badge-otc {
      background: rgba(16, 185, 129, 0.18);
      border: 1px solid var(--med-emerald);
      color: var(--med-emerald);
    }
    .badge-rx {
      background: rgba(245, 158, 11, 0.18);
      border: 1px solid var(--med-amber);
      color: var(--med-amber);
    }
    .med-img-box {
      height: 180px;
      background: rgba(0, 20, 24, 0.6);
      border-radius: 14px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 16px;
      position: relative;
    }
    .med-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }
    .med-card:hover .med-img { transform: scale(1.08); }
    .cart-item-thumb {
      width: 44px;
      height: 44px;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid var(--sky-border);
      flex-shrink: 0;
    }
    .med-title {
      font-family: var(--font-heading);
      font-size: 17px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
      line-height: 1.3;
    }
    .med-desc {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 18px;
      flex: 1;
    }
    .med-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
      padding-top: 14px;
      border-top: 1px solid rgba(0,255,255,0.1);
    }
    .med-price {
      font-size: 20px;
      font-weight: 800;
      color: #fff;
    }
    .med-price span {
      color: var(--neon-cyan);
      font-size: 13px;
    }
    .btn-buy-pill {
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 9px 16px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: all 0.2s;
    }
    .btn-buy-pill:hover {
      background: var(--neon-cyan);
      color: #001a1a;
      box-shadow: var(--neon-glow);
    }

    /* Health Tips Section */
    .tips-section {
      background: rgba(0, 26, 32, 0.65);
      border-top: 1px solid var(--sky-border);
      border-bottom: 1px solid var(--sky-border);
      padding: 60px 24px;
      margin-bottom: 70px;
    }
    .tips-wrap { max-width: 1240px; margin: 0 auto; }
    .tips-header { text-align: center; margin-bottom: 40px; }
    .tips-header h3 {
      font-family: var(--font-heading);
      font-size: 30px;
      color: #fff;
      margin-bottom: 8px;
    }
    .tips-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
    }
    .tip-card {
      background: rgba(0, 32, 40, 0.7);
      border: 1px solid rgba(16,185,129,0.25);
      border-radius: 18px;
      padding: 24px;
    }
    .tip-num {
      font-size: 12px;
      font-weight: 800;
      color: var(--med-emerald);
      letter-spacing: 1px;
      margin-bottom: 8px;
      text-transform: uppercase;
    }
    .tip-h4 {
      font-family: var(--font-heading);
      font-size: 18px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
    }
    .tip-p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.5;
    }

    /* Cart Drawer */
    .cart-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.7);
      backdrop-filter: blur(8px);
      z-index: 2000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .cart-overlay.active { opacity: 1; visibility: visible; }
    .cart-drawer-box {
      position: fixed;
      top: 0;
      right: -420px;
      width: 100%;
      max-width: 400px;
      height: 100%;
      background: #001a1a;
      border-left: 1px solid var(--sky-border);
      z-index: 2001;
      display: flex;
      flex-direction: column;
      transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: -10px 0 40px rgba(0,0,0,0.7);
    }
    .cart-drawer-box.active { right: 0; }
    .cart-header {
      padding: 20px;
      border-bottom: 1px solid rgba(0,255,255,0.15);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-header h3 { font-family: var(--font-heading); font-size: 18px; color: #fff; }
    .cart-close-btn { background: transparent; border: none; color: var(--text-muted); font-size: 22px; }
    .cart-items-body { flex: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; }
    .cart-item {
      display: flex;
      align-items: center;
      gap: 12px;
      background: rgba(0, 32, 40, 0.5);
      border: 1px solid rgba(0,255,255,0.1);
      border-radius: 12px;
      padding: 10px;
    }
    .cart-item-icon { font-size: 28px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; }
    .cart-item-info { flex: 1; }
    .cart-item-name { font-size: 13px; font-weight: 600; color: #fff; }
    .cart-item-sub { font-size: 12px; color: var(--neon-cyan); margin-top: 2px; }
    .cart-item-del { background: transparent; border: none; color: #ff4d6d; font-size: 16px; padding: 4px; }
    .cart-footer { padding: 20px; border-top: 1px solid rgba(0,255,255,0.15); background: rgba(0, 20, 25, 0.95); }
    .cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 17px; font-weight: 700; color: #fff; }
    .cart-total-num { font-size: 22px; color: var(--neon-cyan); }
    .btn-wa-checkout {
      width: 100%;
      background: #25d366;
      color: #001a1a;
      border: none;
      padding: 14px;
      border-radius: 10px;
      font-weight: 800;
      font-size: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 0 20px rgba(37, 211, 102, 0.4);
      transition: all 0.25s;
    }
    .btn-wa-checkout:hover { transform: translateY(-2px); box-shadow: 0 0 30px rgba(37, 211, 102, 0.6); }

    /* Prescription Upload Modal */
    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.75);
      backdrop-filter: blur(8px);
      z-index: 2500;
      opacity: 0;
      visibility: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      transition: all 0.3s;
    }
    .modal-overlay.active { opacity: 1; visibility: visible; }
    .modal-card {
      background: linear-gradient(180deg, #001e24 0%, #001418 100%);
      border: 1.5px solid var(--neon-cyan);
      border-radius: 24px;
      max-width: 720px;
      width: 100%;
      max-height: 90vh;
      overflow-y: auto;
      padding: 28px;
      box-shadow: 0 25px 70px rgba(0,0,0,0.9), var(--neon-glow);
      position: relative;
    }
    .modal-close {
      position: absolute;
      top: 18px;
      right: 20px;
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.15);
      color: var(--text-muted);
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      transition: all 0.2s;
      cursor: pointer;
    }
    .modal-close:hover { color:#fff; border-color:var(--neon-cyan); }
    
    .rx-samples-box {
      margin: 18px 0 14px;
      background: rgba(0, 36, 44, 0.5);
      border: 1px solid var(--sky-border);
      border-radius: 14px;
      padding: 14px 16px;
    }
    .rx-samples-title {
      font-size: 12px;
      font-weight: 700;
      color: var(--neon-cyan);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 6px;
    }
    .rx-samples-grid {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    .rx-sample-btn {
      background: rgba(0, 48, 58, 0.7);
      border: 1px solid rgba(0, 255, 255, 0.2);
      border-radius: 10px;
      padding: 10px 14px;
      color: #fff;
      font-size: 13px;
      text-align: left;
      font-family: inherit;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      transition: all 0.2s;
    }
    .rx-sample-btn:hover, .rx-sample-btn.active {
      background: rgba(0, 255, 255, 0.15);
      border-color: var(--neon-cyan);
      transform: translateX(4px);
      box-shadow: 0 0 15px rgba(0,255,255,0.25);
    }
    .rx-sample-btn-badge {
      font-size: 11px;
      padding: 3px 8px;
      background: rgba(0, 255, 255, 0.15);
      border-radius: 6px;
      color: var(--neon-cyan);
      font-weight: 700;
    }

    .upload-zone {
      border: 2px dashed rgba(0,255,255,0.3);
      border-radius: 14px;
      padding: 22px 20px;
      text-align: center;
      margin: 14px 0;
      cursor: pointer;
      background: rgba(0, 32, 40, 0.5);
      transition: all 0.2s;
    }
    .upload-zone:hover {
      border-color: var(--neon-cyan);
      background: rgba(0, 255, 255, 0.08);
    }

    /* Scanning laser animation container */
    .rx-scan-display {
      display: none;
      margin: 16px 0;
      background: rgba(0, 20, 26, 0.9);
      border: 1px solid var(--sky-border);
      border-radius: 14px;
      overflow: hidden;
      position: relative;
    }
    .rx-scan-img-box {
      width: 100%;
      height: 220px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #000;
    }
    .rx-scan-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.85;
      filter: contrast(1.1);
    }
    .rx-scan-laser {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(90deg, transparent, #00FFFF, #fff, #00FFFF, transparent);
      box-shadow: 0 0 20px #00FFFF, 0 0 35px #00FFFF;
      animation: scanLaser 1.8s infinite ease-in-out;
      z-index: 10;
    }
    @keyframes scanLaser {
      0% { top: 0%; opacity: 0.8; }
      50% { top: 96%; opacity: 1; }
      100% { top: 0%; opacity: 0.8; }
    }
    .rx-scan-status-bar {
      padding: 10px 16px;
      font-size: 13px;
      font-weight: 600;
      color: var(--neon-cyan);
      background: rgba(0, 40, 50, 0.8);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .rx-scan-spinner {
      width: 14px;
      height: 14px;
      border: 2px solid var(--neon-cyan);
      border-top-color: transparent;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* OCR Result Section */
    .rx-results-stage {
      display: none;
      margin-top: 18px;
    }
    .rx-section-h4 {
      font-size: 13px;
      font-weight: 800;
      color: #fff;
      margin-bottom: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .rx-textarea {
      width: 100%;
      height: 85px;
      background: rgba(0, 24, 30, 0.85);
      border: 1px solid var(--sky-border);
      border-radius: 10px;
      padding: 10px 14px;
      color: #fff;
      font-family: inherit;
      font-size: 13px;
      line-height: 1.5;
      resize: vertical;
      outline: none;
      margin-bottom: 10px;
    }
    .rx-textarea:focus { border-color: var(--neon-cyan); box-shadow: 0 0 10px rgba(0,255,255,0.25); }
    .rx-btn-recheck {
      background: rgba(0, 255, 255, 0.1);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 7px 14px;
      border-radius: 8px;
      font-size: 12px;
      font-weight: 700;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 16px;
      transition: all 0.2s;
    }
    .rx-btn-recheck:hover { background: var(--neon-cyan); color: #001a1a; }

    /* Inventory Cards */
    .stock-card {
      background: rgba(0, 28, 35, 0.7);
      border: 1px solid rgba(0, 255, 255, 0.15);
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 10px;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .stock-card.in-stock { border-left: 4px solid var(--med-emerald); }
    .stock-card.out-of-stock { border-left: 4px solid #ef4444; }
    .stock-row-top {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }
    .stock-med-name { font-weight: 700; color: #fff; font-size: 14px; }
    .stock-pill-badge {
      font-size: 11px;
      font-weight: 800;
      padding: 3px 9px;
      border-radius: 12px;
    }
    .stock-badge-avail {
      background: rgba(16, 185, 129, 0.2);
      border: 1px solid var(--med-emerald);
      color: var(--med-emerald);
    }
    .stock-badge-unavail {
      background: rgba(239, 68, 68, 0.2);
      border: 1px solid #ef4444;
      color: #fca5a5;
    }
    .stock-row-bottom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      font-size: 13px;
    }
    .stock-price { color: var(--neon-cyan); font-weight: 700; font-size: 15px; }

    /* Alternative Suggestions Box */
    .alt-suggestion-box {
      background: rgba(245, 158, 11, 0.1);
      border: 1px dashed rgba(245, 158, 11, 0.4);
      border-radius: 8px;
      padding: 8px 12px;
      margin-top: 6px;
      font-size: 12px;
      color: #fbbf24;
      line-height: 1.45;
    }

    /* Legal & Medical Disclaimer Box */
    .rx-disclaimer-box {
      background: rgba(220, 38, 38, 0.12);
      border: 1px solid rgba(220, 38, 38, 0.35);
      border-radius: 12px;
      padding: 12px 16px;
      margin: 16px 0;
      color: #fca5a5;
      font-size: 12px;
      line-height: 1.5;
    }
    .rx-disclaimer-box strong { color: #fee2e2; }

    /* Mandatory Confirmation Checkbox */
    .rx-confirm-label {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      font-size: 13px;
      color: #e2e8f0;
      cursor: pointer;
      margin-bottom: 16px;
      user-select: none;
    }
    .rx-confirm-label input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-top: 2px;
      accent-color: var(--neon-cyan);
      cursor: pointer;
    }

    .rx-modal-actions {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .btn-add-all-avail {
      width: 100%;
      background: rgba(0, 255, 255, 0.15);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 12px;
      border-radius: 10px;
      font-weight: 700;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      transition: all 0.2s;
      cursor: pointer;
    }
    .btn-add-all-avail:hover { background: var(--neon-cyan); color: #001a1a; }
    .btn-action-rx:disabled, .btn-action-rx[disabled] {
      opacity: 0.45;
      cursor: not-allowed;
      box-shadow: none;
      transform: none !important;
    }

    /* Floating Buttons */
    .floating-box {
      position: fixed;
      bottom: 24px;
      right: 24px;
      display: flex;
      flex-direction: column;
      gap: 12px;
      z-index: 1500;
    }
    .float-btn {
      width: 52px;
      height: 52px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      border: none;
      box-shadow: 0 8px 24px rgba(0,0,0,0.5);
      transition: all 0.3s;
    }
    .float-wa { background: #25d366; color: #fff; }
    .float-wa:hover { transform: scale(1.1); box-shadow: 0 0 25px rgba(37, 211, 102, 0.7); }
    .float-cart { background: var(--neon-cyan); color: #001a1a; position: relative; }
    .float-cart:hover { transform: scale(1.1); box-shadow: var(--neon-glow); }
    .float-badge {
      position: absolute;
      top: -4px;
      right: -4px;
      background: #ff3366;
      color: #fff;
      font-size: 11px;
      font-weight: 800;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Toast Notification */
    .toast-msg {
      position: fixed;
      bottom: 90px;
      left: 50%;
      transform: translateX(-50%) translateY(50px);
      background: rgba(0, 32, 40, 0.95);
      border: 1px solid var(--neon-cyan);
      color: #fff;
      padding: 12px 24px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      box-shadow: var(--neon-glow);
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s;
      z-index: 3000;
    }
    .toast-msg.show { transform: translateX(-50%) translateY(0); opacity: 1; visibility: visible; }

    /* Footer */
    .pharma-footer {
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
      .pharma-hero { padding-top: 30px; }
      .hotline-pill { display: none; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="pharmacy" data-dk-accent="#38bdf8" data-dk-phone="994503936998" data-dk-sticky data-dk-action="openRxModal" data-dk-sticky-label="Resept">
  <script src="assets/demo-kit.js"></script>


  <!-- Top Demo Banner -->
  <div class="demo-bar">
    <div class="demo-bar-left">
      <span class="demo-badge">SKYWEB DEMO</span>
      <span class="demo-text"><?= htmlspecialchars($t['demo_banner']) ?></span>
    </div>
    <div class="demo-bar-right">
      <a href="../../index.php?lang=<?= htmlspecialchars($lang) ?>#contact" class="demo-btn-sky"><?= htmlspecialchars($t['order_site']) ?> →</a>
      <a href="../../index.php?lang=<?= htmlspecialchars($lang) ?>" class="demo-btn-back">← <?= htmlspecialchars($t['back_to_sky']) ?></a>
    </div>
  </div>

  <!-- Prescription Notice Ribbon -->
  <div class="rx-ribbon"><?= htmlspecialchars($t['rx_notice']) ?></div>

  <!-- Store Navbar -->
  <nav class="pharma-nav">
    <div class="nav-wrap">
      <div class="brand-box">
        <div class="brand-cross-icon">⚕️</div>
        <div class="brand-text">
          <?= htmlspecialchars($t['brand_name']) ?>
          <span><?= htmlspecialchars($t['brand_sub']) ?></span>
        </div>
      </div>
      <div class="hotline-pill">
        <span>📞</span>
        <span>24/7 Qaynar Xətt: *0101</span>
      </div>
      <button class="cart-pharma-btn" onclick="toggleCartDrawer()">
        <span>💊</span>
        <span><?= htmlspecialchars($t['cart_title']) ?></span>
        <span class="badge-count" id="cartTopCount">0</span>
      </button>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="pharma-hero" id="home">
    <span class="hero-tag"><?= htmlspecialchars($t['hero_tag']) ?></span>
    <h1 class="hero-h1">
      <?= htmlspecialchars($t['hero_title_1']) ?><br>
      <span class="glow-cyan"><?= htmlspecialchars($t['hero_title_2']) ?></span>
    </h1>
    <p class="hero-sub"><?= htmlspecialchars($t['hero_desc']) ?></p>

    <!-- Search input -->
    <div class="search-box-wrap">
      <span class="search-icon-fixed">🔍</span>
      <input type="text" class="search-input" id="medSearchInput" placeholder="<?= htmlspecialchars($t['search_ph']) ?>" oninput="searchMedicines(this.value)">
    </div>
    <div class="dk-ship" id="medSearchNote" style="text-align:center; margin:-4px 0 14px;"></div>

    <!-- Quick action buttons -->
    <div class="quick-actions">
      <button class="btn-action-rx" onclick="openRxModal()">
        <span>📄</span>
        <span><?= htmlspecialchars($t['btn_upload_rx']) ?></span>
      </button>
      <button class="btn-action-pharma" onclick="askPharmacist()">
        <span>💬</span>
        <span><?= htmlspecialchars($t['btn_ask_pharma']) ?></span>
      </button>
    </div>
  </section>

  <!-- Catalog Section -->
  <section class="catalog-wrap" id="catalog">
    <!-- Category Tabs -->
    <div class="filter-tabs">
      <button class="tab-item active" onclick="filterMeds('all', this)"><?= htmlspecialchars($t['filter_all']) ?></button>
      <button class="tab-item" onclick="filterMeds('vitamins', this)"><?= htmlspecialchars($t['filter_vitamins']) ?></button>
      <button class="tab-item" onclick="filterMeds('pain', this)"><?= htmlspecialchars($t['filter_pain']) ?></button>
      <button class="tab-item" onclick="filterMeds('derma', this)"><?= htmlspecialchars($t['filter_derma']) ?></button>
      <button class="tab-item" onclick="filterMeds('baby', this)"><?= htmlspecialchars($t['filter_baby']) ?></button>
      <button class="tab-item" onclick="filterMeds('devices', this)"><?= htmlspecialchars($t['filter_devices']) ?></button>
    </div>

    <!-- Medicines Grid -->
    <div class="med-grid" id="medGrid">
      <?php foreach ($medicines as $m): ?>
        <?php
          $title = $m['title'][$lang] ?? $m['title']['az'];
          $desc = $m['desc'][$lang] ?? $m['desc']['az'];
        ?>
        <div class="med-card" data-cat="<?= $m['cat'] ?>" data-title="<?= htmlspecialchars(mb_strtolower($title)) ?>">
          <span class="badge-status <?= $m['rx'] ? 'badge-rx' : 'badge-otc' ?>">
            <?= $m['rx'] ? $t['tag_rx'] : $t['tag_otc'] ?>
          </span>
          <div class="med-img-box">
            <img src="<?= htmlspecialchars($m['image']) ?>" alt="<?= htmlspecialchars($title) ?>" class="med-img" loading="lazy">
          </div>
          <h3 class="med-title"><?= htmlspecialchars($title) ?></h3>
          <p class="med-desc"><?= htmlspecialchars($desc) ?></p>
          <div class="med-footer">
            <div class="med-price"><?= number_format($m['price'], 2) ?> <span>AZN</span></div>
            <button class="btn-buy-pill" onclick="addMedToCart(<?= $m['id'] ?>, '<?= htmlspecialchars(addslashes($title)) ?>', <?= $m['price'] ?>, '<?= htmlspecialchars(addslashes($m['image'])) ?>')">
              <span>+</span>
              <span><?= htmlspecialchars($t['btn_add_med']) ?></span>
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Health Tips Section -->
  <section class="tips-section" id="tips">
    <div class="tips-wrap">
      <div class="tips-header">
        <h3><?= htmlspecialchars($t['tips_title']) ?></h3>
        <p style="color:var(--text-muted); font-size:14px;"><?= htmlspecialchars($t['tips_desc']) ?></p>
      </div>
      <div class="tips-grid">
        <div class="tip-card">
          <div class="tip-num">MƏSLƏHƏT #01</div>
          <h4 class="tip-h4"><?= htmlspecialchars($t['tip_1_t']) ?></h4>
          <p class="tip-p"><?= htmlspecialchars($t['tip_1_d']) ?></p>
        </div>
        <div class="tip-card">
          <div class="tip-num">MƏSLƏHƏT #02</div>
          <h4 class="tip-h4"><?= htmlspecialchars($t['tip_2_t']) ?></h4>
          <p class="tip-p"><?= htmlspecialchars($t['tip_2_d']) ?></p>
        </div>
        <div class="tip-card">
          <div class="tip-num">MƏSLƏHƏT #03</div>
          <h4 class="tip-h4"><?= htmlspecialchars($t['tip_3_t']) ?></h4>
          <p class="tip-p"><?= htmlspecialchars($t['tip_3_d']) ?></p>
        </div>
      </div>
    </div>
  </section>

  <!-- Cart Drawer -->
  <div class="cart-overlay" id="cartOverlay" onclick="toggleCartDrawer()"></div>
  <aside class="cart-drawer-box" id="cartDrawer">
    <div class="cart-header">
      <h3><?= htmlspecialchars($t['cart_title']) ?></h3>
      <button class="cart-close-btn" onclick="toggleCartDrawer()">✕</button>
    </div>
    <div class="cart-items-body" id="cartItemsList">
      <div style="text-align:center; padding: 40px 10px; color:var(--text-muted);" id="emptyCartNotice">
        <div style="font-size:42px; margin-bottom:10px;">💊</div>
        <?= htmlspecialchars($t['cart_empty']) ?>
      </div>
    </div>
    <div class="cart-footer">
      <div class="cart-total-row">
        <span><?= htmlspecialchars($t['cart_total']) ?></span>
        <span class="cart-total-num" id="cartTotalVal">0.00 AZN</span>
      </div>
      <button class="btn-wa-checkout" onclick="checkoutPharmacyWhatsApp()">
        <span>💬</span>
        <span><?= htmlspecialchars($t['btn_checkout_wa']) ?></span>
      </button>
    </div>
  </aside>

  <!-- Prescription AI OCR Scanner Modal -->
  <div class="modal-overlay" id="rxModal">
    <div class="modal-card">
      <button class="modal-close" onclick="closeRxModal()" aria-label="Bağla">✕</button>
      <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
        <span style="font-size:24px;">🤖</span>
        <h3 style="font-family:var(--font-heading); font-size:21px; color:#fff; font-weight:800;"><?= htmlspecialchars($t['rx_modal_title']) ?></h3>
      </div>
      <p style="color:var(--text-muted); font-size:13px; line-height:1.5;"><?= htmlspecialchars($t['rx_modal_desc']) ?></p>

      <!-- Instant test samples -->
      <div class="rx-samples-box">
        <div class="rx-samples-title"><?= htmlspecialchars($t['rx_samples_title']) ?></div>
        <div class="rx-samples-grid">
          <button type="button" class="rx-sample-btn" onclick="selectRxSample(1)">
            <span><?= htmlspecialchars($t['rx_sample_1']) ?></span>
            <span class="rx-sample-btn-badge">TEST ET ⚡</span>
          </button>
          <button type="button" class="rx-sample-btn" onclick="selectRxSample(2)">
            <span><?= htmlspecialchars($t['rx_sample_2']) ?></span>
            <span class="rx-sample-btn-badge">TEST ET ⚡</span>
          </button>
          <button type="button" class="rx-sample-btn" onclick="selectRxSample(3)">
            <span><?= htmlspecialchars($t['rx_sample_3']) ?></span>
            <span class="rx-sample-btn-badge">TEST ET ⚡</span>
          </button>
        </div>
      </div>

      <!-- Upload custom image dropzone -->
      <div class="upload-zone" onclick="document.getElementById('rxFileInput').click()">
        <div style="font-size:32px; margin-bottom:6px;">📸</div>
        <div style="font-weight:700; color:#fff; font-size:14px;">Şəxsi reseptinizin fotosunu seçin və ya çəkin</div>
        <div style="font-size:12px; color:var(--text-muted); margin-top:3px;">JPG, PNG, HEIC (maksimum 10MB) — Əl xətti avtomatik tanınacaq</div>
        <input type="file" id="rxFileInput" accept="image/*" style="display:none;" onchange="handleRxFileSelect(this)">
      </div>

      <!-- Scanner preview with animated laser line -->
      <div class="rx-scan-display" id="rxScanDisplay">
        <div class="rx-scan-img-box">
          <img id="rxPreviewImg" src="" alt="Resept">
          <div class="rx-scan-laser" id="rxScanLaser"></div>
        </div>
        <div class="rx-scan-status-bar" id="rxScanStatusBar">
          <div class="rx-scan-spinner" id="rxScanSpinner"></div>
          <span id="rxScanStatusText">Əl xətti neyron şəbəkə ilə skan edilir... Tərkib analiz olunur (OCR v4.2)...</span>
        </div>
      </div>

      <!-- OCR Recognized Text and Inventory Check Stage -->
      <div class="rx-results-stage" id="rxResultsStage">
        <!-- 1. Editable OCR text -->
        <div class="rx-section-h4">
          <span>📝</span>
          <span><?= htmlspecialchars($t['rx_ocr_title']) ?></span>
        </div>
        <textarea id="rxOcrEditableText" class="rx-textarea" spellcheck="false" placeholder="Tanınan dərman adları..."></textarea>
        <div>
          <button type="button" class="rx-btn-recheck" onclick="recheckFromEditedText()">
            <?= htmlspecialchars($t['rx_btn_recheck']) ?>
          </button>
        </div>

        <!-- 2. Inventory matching results -->
        <div class="rx-section-h4" style="margin-top:10px;">
          <span>📦</span>
          <span><?= htmlspecialchars($t['rx_stock_title']) ?></span>
        </div>
        <div id="rxStockResultsList"></div>

        <!-- 3. Legal and medical disclaimer -->
        <div class="rx-disclaimer-box">
          <strong><?= htmlspecialchars($t['rx_disclaimer_title']) ?></strong><br>
          <?= htmlspecialchars($t['rx_disclaimer_text']) ?>
        </div>

        <!-- 4. Mandatory Doctor/Pharmacist confirmation checkbox -->
        <label class="rx-confirm-label">
          <input type="checkbox" id="rxDoctorConfirmCheck" onchange="toggleRxConfirm(this.checked)">
          <span><?= htmlspecialchars($t['rx_confirm_text']) ?></span>
        </label>

        <!-- 5. Actions -->
        <div class="rx-modal-actions">
          <button type="button" class="btn-add-all-avail" id="btnAddAllAvail" onclick="addAllAvailRxToCart()">
            <?= htmlspecialchars($t['rx_btn_add_avail']) ?>
          </button>
          <button type="button" class="btn-action-rx" id="btnSendRxWhatsApp" style="width:100%; justify-content:center;" onclick="sendRxWhatsApp()" disabled>
            <span>💬</span>
            <span><?= htmlspecialchars($t['rx_btn_wa_order']) ?></span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Floating Buttons -->
  <div class="floating-box">
    <button class="float-btn float-cart" onclick="toggleCartDrawer()" title="Səbət">
      💊
      <span class="float-badge" id="cartFloatCount">0</span>
    </button>
    <button class="float-btn float-wa" onclick="askPharmacist()" title="WhatsApp Əczaçı">
      💬
    </button>
  </div>

  <!-- Toast -->
  <div class="toast-msg" id="pharmaToast">Dərman əlavə olundu!</div>

  <!-- Footer -->
  <footer class="pharma-footer">
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
    const pharmaCartApi = DK.cart('pharma-cart', function () { renderPharmaCart(); });
    let pharmaCart = pharmaCartApi.items;
    let currentRecognizedMeds = [];

    // Pharmacy catalog inventory mapping for live OCR availability check
    const pharmacyInventory = [
      {
        keys: ['parasetamol', 'paracetamol', 'panadol', 'efferalgan'],
        id: 304,
        name: 'Paracetamol Extra 500mg Qızdırmasalıcı',
        inStock: true,
        stockCount: 120,
        price: 3.50,
        image: 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=600&auto=format&fit=crop&q=80',
        rx: false
      },
      {
        keys: ['amoksisillin', 'amoxicillin', 'amoxil', 'augmentin'],
        id: 305,
        name: 'Amoxicillin Forte 500mg (Reseptli)',
        inStock: true,
        stockCount: 35,
        price: 14.20,
        image: 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=600&auto=format&fit=crop&q=80',
        rx: true
      },
      {
        keys: ['vitamin c', 'c vitamini', 'ascorbic', 'askorbin'],
        id: 308,
        name: 'Vitamin C 1000mg + Sink Şirəli Tablet',
        inStock: true,
        stockCount: 80,
        price: 12.00,
        image: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=600&auto=format&fit=crop&q=80',
        rx: false
      },
      {
        keys: ['nurofen', 'ibuprofen', 'ibufen'],
        id: 303,
        name: 'Nurofen Express Forte 400mg Kapsul',
        inStock: true,
        stockCount: 60,
        price: 6.80,
        image: 'https://images.unsplash.com/photo-1584017911766-d451b3d0e843?w=600&auto=format&fit=crop&q=80',
        rx: false
      },
      {
        keys: ['magne b6', 'maqnezium', 'magnesium', 'magne-b6'],
        id: 306,
        name: 'Magne B6 Forte Stress & Əsəb Dəstəyi',
        inStock: true,
        stockCount: 40,
        price: 16.80,
        image: 'https://images.unsplash.com/photo-1576073719676-aa955fc6b549?w=600&auto=format&fit=crop&q=80',
        rx: false
      },
      {
        keys: ['omez', 'omeprazol', 'omeprazole'],
        id: 307,
        name: 'Omez 20mg Mədə Qoruyucu (Omeprazol)',
        inStock: true,
        stockCount: 50,
        price: 8.50,
        image: 'https://images.unsplash.com/photo-1550572017-edd951aa8f72?w=600&auto=format&fit=crop&q=80',
        rx: false
      },
      {
        keys: ['amlodipin', 'amlodipine', 'norvasc'],
        id: 309,
        name: 'Amlodipin 5mg Hipertoniya Əleyhinə',
        inStock: true,
        stockCount: 28,
        price: 7.20,
        image: 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=600&auto=format&fit=crop&q=80',
        rx: true
      },
      {
        keys: ['kardiomaqnil', 'cardiomagnyl', 'aspirin kardio', 'trombo ass'],
        id: 991,
        name: 'Kardiomaqnil 75mg Ürək Qoruyucu',
        inStock: false,
        stockCount: 0,
        price: 6.20,
        rx: true,
        alternative: {
          name: 'Aspirin Kardio 100mg və ya Trombo ASS 75mg',
          activeSubstance: 'Asetilsalisil turşusu (Antiagreqant)',
          note: 'Məlumat üçün: Eyni antiagreqant təsir spektrinə malik molekuldur. Yalnız pasiyent maarifləndirilməsi üçündür; preparat əvəzlənməsi yalnız müalicə həkimi və ya əczaçı təsdiqi ilə mümkündür.'
        }
      },
      {
        keys: ['azitromisin', 'azithromycin', 'sumamed', 'azitro'],
        id: 992,
        name: 'Azitromisin 500mg Antibiotik',
        inStock: false,
        stockCount: 0,
        price: 18.00,
        rx: true,
        alternative: {
          name: 'Sumamed 500mg və ya Azitro 500mg Kapsul',
          activeSubstance: 'Azitromisin dihidrat (Makrolid antibiotik)',
          note: 'Məlumat üçün: Ekvivalent makrolid qrupudur. Reseptli preparatdır; resept dəyişdirilə bilməz, yalnız həkim/əczaçı razılığı ilə buraxılır.'
        }
      }
    ];

    // Preset test handwriting prescription data
    const rxSamples = {
      1: {
        img: 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?w=700&auto=format&fit=crop&q=80',
        text: "Rp:\n1. Paracetamol 500mg tab. #10\n   D.S. 1 tab x 3 dəfə gündə qızdırmada\n2. Amoxicillin 500mg caps. #20\n   D.S. 1 kapsul x 2 dəfə yeməkdən sonra\n3. Vitamin C 1000mg efervesan #20\n   D.S. 1 tab 200ml suda səhərlər"
      },
      2: {
        img: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=700&auto=format&fit=crop&q=80',
        text: "Rp:\n1. Cardiomagnyl 75mg tab. #30\n   D.S. 1 tab axşam yeməkdən sonra\n2. Magne B6 Forte tab. #60\n   D.S. 1 tab x 2 dəfə gündə\n3. Amlodipin 5mg tab. #30\n   D.S. 1 tab səhər acqarına (Təzyiq üçün)"
      },
      3: {
        img: 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=700&auto=format&fit=crop&q=80',
        text: "Rp:\n1. Omez 20mg caps. #30\n   D.S. 1 kapsul səhər yeməkdən 30 dəq əvvəl\n2. Nurofen Forte 400mg #12\n   D.S. 1 kapsul kəskin ağrı olduqda\n3. Azithromycin 500mg tab. #3\n   D.S. 1 tab gündə 1 dəfə (3 gün kurs)"
      }
    };

    function selectRxSample(id) {
      document.querySelectorAll('.rx-sample-btn').forEach((b, i) => {
        b.classList.toggle('active', (i + 1) === id);
      });
      const sample = rxSamples[id];
      if (sample) {
        startRxScan(sample.img, sample.text);
      }
    }

    function handleRxFileSelect(input) {
      if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = function(e) {
          const autoText = "Rp:\n1. Paracetamol 500mg tab.\n2. Nurofen 400mg caps.\n3. Magne B6 Forte #60";
          startRxScan(e.target.result, autoText);
        };
        reader.readAsDataURL(file);
      }
    }

    function startRxScan(imgSrc, ocrText) {
      const scanDisplay = document.getElementById('rxScanDisplay');
      const previewImg = document.getElementById('rxPreviewImg');
      const statusBar = document.getElementById('rxScanStatusBar');
      const statusText = document.getElementById('rxScanStatusText');
      const spinner = document.getElementById('rxScanSpinner');
      const laser = document.getElementById('rxScanLaser');
      const resultsStage = document.getElementById('rxResultsStage');

      scanDisplay.style.display = 'block';
      previewImg.src = imgSrc;
      laser.style.display = 'block';
      spinner.style.display = 'block';
      statusText.innerText = "🔍 Əl xətti neyron şəbəkə ilə skan edilir... Həkim təyinatı oxunur (OCR)...";
      resultsStage.style.display = 'none';

      setTimeout(() => {
        laser.style.display = 'none';
        spinner.style.display = 'none';
        statusText.innerText = "✅ Resept mətni uğurla tanındı! Aptek anbarı ilə yoxlanış tamamlandı.";
        document.getElementById('rxOcrEditableText').value = ocrText;
        resultsStage.style.display = 'block';
        processOcrText(ocrText);
      }, 1300);
    }

    function recheckFromEditedText() {
      const text = document.getElementById('rxOcrEditableText').value;
      processOcrText(text);
      showToast('✓ Anbar yoxlanışı yeniləndi');
    }

    function processOcrText(text) {
      const lower = text.toLowerCase();
      const resultsContainer = document.getElementById('rxStockResultsList');
      currentRecognizedMeds = [];

      pharmacyInventory.forEach(item => {
        const matched = item.keys.some(k => lower.includes(k));
        if (matched) {
          currentRecognizedMeds.push(item);
        }
      });

      if (currentRecognizedMeds.length === 0) {
        resultsContainer.innerHTML = `
          <div style="background:rgba(0,32,40,0.5); padding:16px; border-radius:10px; color:var(--text-muted); font-size:13px; text-align:center;">
            Resept mətnində dərman adı aşkar edilmədi. Zəhmət olmasa yuxarıdakı mətni düzəldin və ya hazır nümunələrdən birini seçin.
          </div>
        `;
        return;
      }

      let html = '';
      currentRecognizedMeds.forEach(item => {
        if (item.inStock) {
          html += `
            <div class="stock-card in-stock">
              <div class="stock-row-top">
                <span class="stock-med-name">✅ ${item.name}</span>
                <span class="stock-pill-badge stock-badge-avail">MÖVCUDDUR (${item.stockCount} ədəd)</span>
              </div>
              <div class="stock-row-bottom">
                <span class="stock-price">${item.price.toFixed(2)} AZN</span>
                <button type="button" class="btn-buy-pill" onclick="addMedToCart(${item.id}, '${escapeJs(item.name)}', ${item.price}, '${escapeJs(item.image)}')">
                  <span>+</span>
                  <span>Səbətə At</span>
                </button>
              </div>
            </div>
          `;
        } else {
          html += `
            <div class="stock-card out-of-stock">
              <div class="stock-row-top">
                <span class="stock-med-name">❌ ${item.name}</span>
                <span class="stock-pill-badge stock-badge-unavail">STOKDA YOXDUR</span>
              </div>
              ${item.alternative ? `
                <div class="alt-suggestion-box">
                  <strong>💡 Məlumat üçün ekvivalent alternativ:</strong> ${item.alternative.name}<br>
                  <span style="opacity:0.9;">Təsiredici maddə: ${item.alternative.activeSubstance}</span><br>
                  <span style="font-size:11px; opacity:0.8; display:block; margin-top:2px;">${item.alternative.note}</span>
                </div>
              ` : ''}
            </div>
          `;
        }
      });

      resultsContainer.innerHTML = html;
    }

    function toggleRxConfirm(checked) {
      const waBtn = document.getElementById('btnSendRxWhatsApp');
      waBtn.disabled = !checked;
    }

    function addAllAvailRxToCart() {
      let count = 0;
      currentRecognizedMeds.forEach(item => {
        if (item.inStock) {
          addMedToCart(item.id, item.name, item.price, item.image);
          count++;
        }
      });
      if (count > 0) {
        showToast('✓ ' + count + ' ədəd mövcud dərman səbətə əlavə edildi');
      } else {
        showToast('Əlavə ediləcək mövcud dərman tapılmadı');
      }
    }

    function sendRxWhatsApp() {
      const isConfirmed = document.getElementById('rxDoctorConfirmCheck').checked;
      if (!isConfirmed) {
        showToast('Zəhmət olmasa həkim təyinatı təsdiq qutusunu işarələyin');
        return;
      }

      closeRxModal();
      const ocrText = document.getElementById('rxOcrEditableText').value;
      let msg = "Salam, Vita Aptek! AI Skaner ilə oxunmuş həkim reseptini təqdim edirəm:\n\n";
      msg += "📋 RESEPT MƏTNİ:\n" + ocrText + "\n\n";

      const avail = currentRecognizedMeds.filter(i => i.inStock);
      if (avail.length > 0) {
        msg += "✅ MÖVCUD DƏRMANLAR:\n";
        avail.forEach(i => {
          msg += `- ${i.name} (${i.price.toFixed(2)} AZN)\n`;
        });
      }

      const unavail = currentRecognizedMeds.filter(i => !i.inStock);
      if (unavail.length > 0) {
        msg += "\n❌ STOKDA OLMAYANLAR (Əczaçı ilə dəqiqləşdirmək üçün):\n";
        unavail.forEach(i => {
          msg += `- ${i.name}\n`;
        });
      }

      msg += "\n⚠️ Qeyd: Resept lisenziyalı həkim tərəfindən yazılmışdır. Çatdırılma üçün təsdiqinizi gözləyirəm.";
      window.open('https://wa.me/994503936998?text=' + encodeURIComponent(msg), '_blank');
    }

    function escapeJs(str) {
      return (str || '').replace(/'/g, "\\'");
    }

    function toggleCartDrawer() {
      document.getElementById('cartOverlay').classList.toggle('active');
      document.getElementById('cartDrawer').classList.toggle('active');
    }

    function showToast(text, type) { DK.toast(text, type); }

    function addMedToCart(id, title, price, image) {
      pharmaCartApi.add({ id: id, title: title, price: price, img: image }, 1);
      DK.toast(title + ' — ' + DK.t.added);
    }

    function setMedQty(id, dir) {
      const item = pharmaCartApi.items.find(function (i) { return String(i.id) === String(id); });
      if (!item) return;
      pharmaCartApi.setQty(id, item.meta || '', item.qty + dir);
    }

    function removeMedFromCart(id) {
      pharmaCartApi.remove(id, '');
      DK.toast(DK.t.removed, 'info');
    }

    function renderPharmaCart() {
      const container = document.getElementById('cartItemsList');
      const topBadge = document.getElementById('cartTopCount');
      const floatBadge = document.getElementById('cartFloatCount');
      const totalEl = document.getElementById('cartTotalVal');
      if (!container || !totalEl) return;

      const totalQty = pharmaCartApi.count();
      if (topBadge) topBadge.innerText = totalQty;
      if (floatBadge) floatBadge.innerText = totalQty;

      if (!pharmaCartApi.items.length) {
        container.innerHTML = '<div class="dk-empty"><span class="dk-empty__ic">💊</span>' +
          DK.esc(DK.t.emptyCart) + '</div>';
        totalEl.innerText = '0.00 AZN';
        return;
      }

      const subtotal = pharmaCartApi.total();
      container.innerHTML = pharmaCartApi.items.map(function (item) {
        return '<div class="cart-item" style="display:flex;gap:.6rem;align-items:center">' +
          (item.img ? '<img src="' + DK.esc(item.img) + '" alt="" class="cart-item-thumb">' : '') +
          '<div class="cart-item-info" style="flex:1;min-width:0">' +
            '<div class="cart-item-name">' + DK.esc(item.title) + '</div>' +
            '<div class="cart-item-sub">' + item.price.toFixed(2) + ' AZN</div>' +
          '</div>' +
          '<div class="dk-qty">' +
            '<button class="dk-qty__btn" onclick="setMedQty(' + item.id + ',-1)">−</button>' +
            '<span class="dk-qty__val">' + item.qty + '</span>' +
            '<button class="dk-qty__btn" onclick="setMedQty(' + item.id + ',1)">+</button>' +
          '</div>' +
          '<button class="cart-item-del" onclick="removeMedFromCart(' + item.id + ')">✕</button>' +
        '</div>';
      }).join('');
      totalEl.innerText = subtotal.toFixed(2) + ' AZN';
    }

    function filterMeds(cat, btn) {
      document.querySelectorAll('.tab-item').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      document.querySelectorAll('.med-card').forEach(function (card) {
        card.style.display = (cat === 'all' || card.getAttribute('data-cat') === cat) ? 'flex' : 'none';
      });
    }

    function searchMedicines(query) {
      const q = (query || '').toLowerCase().trim();
      let shown = 0;
      document.querySelectorAll('.med-card').forEach(function (card) {
        const title = (card.getAttribute('data-title') || '').toLowerCase();
        const on = !q || title.indexOf(q) > -1;
        card.style.display = on ? 'flex' : 'none';
        if (on) shown++;
      });
      const note = document.getElementById('medSearchNote');
      if (note) {
        note.innerHTML = q ? '<b>' + shown + '</b> ' + DK.pick('preparat tapıldı', 'products found',
          'препаратов найдено', 'ürün bulundu') : '';
      }
    }

    function openRxModal() {
      document.getElementById('rxModal').classList.add('active');
    }
    function closeRxModal() {
      document.getElementById('rxModal').classList.remove('active');
    }

    function askPharmacist() {
      DK.wa('Salam, Vita Aptek! ' + DK.pick(
        'Növbətçi əczaçı ilə dərman təyinatı üzrə məsləhətləşmək istəyirəm.',
        'I would like to consult the on-duty pharmacist about my prescription.',
        'Хочу проконсультироваться с дежурным фармацевтом по рецепту.',
        'Nöbetçi eczacı ile reçete hakkında görüşmek istiyorum.'));
    }

    function checkoutPharmacyWhatsApp() {
      if (!pharmaCartApi.items.length) return DK.toast(DK.t.emptyCart, 'err');
      DK.order({
        title: DK.pick('Sifarişi tamamla', 'Complete your order', 'Оформить заказ', 'Siparişi tamamla'),
        brand: 'Vita Aptek',
        items: pharmaCartApi.items,
        addressRequired: true,
        summary: DK.pick('Çatdırılma: 45 dəqiqə ekspres · Resept tələb olunarsa əczaçı yoxlayacaq',
                        'Delivery: 45 min express · Pharmacist will verify prescription if required',
                        'Доставка: экспресс 45 минут · Фармацевт проверит рецепт при необходимости',
                        'Teslimat: 45 dakika ekspres · Gerekirse eczacı reçeteyi kontrol eder')
      }).then(function (d) {
        if (!d) return;
        pharmaCartApi.clear();
        toggleCartDrawer();
      });
    }

    function escapeJs(str) {
      return (str || '').replace(/'/g, "\\'");
    }

    renderPharmaCart();
  </script>
</body>
</html>
