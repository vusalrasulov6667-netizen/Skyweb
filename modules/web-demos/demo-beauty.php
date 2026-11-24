<?php require_once __DIR__ . '/../../config/config.php';
ob_start(static function (string $html): string { return sky_translate_document_html($html); });
require_once __DIR__ . '/../../config/beauty-bookings.php';
require_once __DIR__ . '/../../config/beauty-reviews.php';
require_once __DIR__ . '/../../config/beauty-staff.php';
require_once __DIR__ . '/../../config/beauty-media.php';

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
    'brand_sub' => 'Gözəllik salonu · Bakı',
    'nav_home' => 'Ana Səhifə',
    'nav_services' => 'Xidmətlər & Qiymətlər',
    'nav_stylists' => 'Peşəkar Ustalar',
    'nav_before_after' => 'Əvvəl / Sonra',
    'nav_book' => 'Onlayn Növbə',
    'hero_tag' => 'Kiçik studiya, böyük diqqət',
    'hero_title_1' => 'Özünə bir saat,',
    'hero_title_2' => 'qalanı bizə qalsın.',
    'hero_desc' => 'Saç, dırnaq, qaş və dəri — bir ünvanda. İlk gəlişdə 20% endirim.',
    'hero_btn_book' => 'Növbə götür',
    'hero_btn_prices' => 'Qiymətlərə bax',
    'stat_1_n' => '12+',
    'stat_1_t' => 'İllik Təcrübə',
    'stat_2_n' => '4',
    'stat_2_t' => 'Peşəkar Usta',
    'stat_3_n' => '8',
    'stat_3_t' => 'Xidmət Növü',
    'tab_all' => 'Bütün Xidmətlər',
    'tab_hair' => 'Saç & Rəngləmə',
    'tab_nails' => 'Manikür & Pedikür',
    'tab_face' => 'Kosmetologiya & Spa',
    'tab_makeup' => 'Makiyaj & Qaş',
    'btn_book_service' => 'Növbə Yazıl',
    'before_after_title' => 'Dəyişim Nəticələri',
    'before_after_desc' => 'Əvvəl və sonra — ustalarımızın real işləri.',
    'state_before' => 'ƏVVƏL',
    'state_after' => 'SONRA',
    'stylists_title' => 'Bizim Komandamız',
    'stylists_desc' => 'Dörd usta, dörd fərqli ixtisas. Adla seçib yazıla bilərsiniz.',
    'booking_modal_title' => 'Onlayn Növbə Qeydiyyatı',
    'booking_modal_desc' => 'Tarix, saat və sevimli ustanızı seçərək növbənizi dərhal təsdiqləyin.',
    'field_service' => 'Xidmət növü',
    'field_stylist' => 'Stilist seçimi',
    'field_date' => 'Tarix',
    'field_time' => 'Saat',
    'field_name' => 'Adınız və Soyadınız',
    'field_phone' => 'Telefon nömrəniz',
    'btn_confirm_booking' => 'Rezervasiyanı Təsdiqlə',
    'ba_item1_t' => 'Balayaj',
    'ba_item1_d' => 'Tünd köklərdən açıq uclara yumşaq keçid. Saç parlaq və canlı görünür.',
    'ba_item2_t' => 'Dərin təmizləmə',
    'ba_item2_d' => 'Maskanın təsiri ilə məsamələr təmizlənir, dəri nəfəs alır və təravətlənir.',
    'ba_item3_t' => 'Manikür & gel-lak',
    'ba_item3_d' => 'Dırnaq forması düzəldilir və 3–4 həftə qalan səliqəli örtük vurulur.',
    'footer_desc' => 'Bakı mərkəzində gözəllik studiyası. Skyweb.az nümunə saytı.',
    'footer_rights' => 'Bütün hüquqlar qorunur.',
    'hero_card_badge' => 'SPA & SALON',
    'hero_card_rating' => '★ 4.9 REYTİNQ',
    'hero_card_care' => 'Ən çox seçilən',
    'hero_card_service' => 'Dərin təmizləmə & Balayaj',
    'hero_card_offer' => '-20% ENDİRİM',
    'offer_daily' => 'GÜNÜN TƏKLİFİ',
    'offer_weekly' => 'HƏFTƏNİN TƏKLİFİ',
    'offer_today' => 'Yalnız bu gün',
    'offer_week' => 'Yalnız bu həftə',
    'offer_apply' => 'Müraciət et',
    'offer_corporate' => 'Kompaniya əməkdaşları üçün',
    'toast_file_too_big' => 'Fayl çox böyükdür (maks 10 MB)',
    'toast_booked' => 'Rezervasiya qeydə alındı!',
    'wa_booking_intro' => 'Salam! Onlayn bron:',
    'wa_service' => 'Xidmət',
    'wa_stylist' => 'Usta',
    'wa_date' => 'Tarix',
    'wa_customer' => 'Müştəri',
    'wa_contact' => 'Əlaqə',
    'wa_note' => 'Qeyd',
    'meta_desc' => 'Onlayn növbə, peşəkar ustalar, şəffaf qiymətlər və real nəticələr. Müasir, sürətli və mobil üçün rahat gözəllik salonu saytı.',
    'services_desc' => 'Açıq qiymətlər, gizli əlavə yoxdur. Ustanı və vaxtı seç.',
    'nav_gallery' => 'Qalereya',
    'gallery_title' => 'Ustaların əl işləri',
    'gallery_desc' => 'Foto və videolar — ustalarımızın əl işləri.',
    'gallery_empty' => 'Ustalarımızın işlərindən nümunələr tezliklə burada görünəcək.',
    'gallery_photo' => 'FOTO',
    'gallery_video' => 'VİDEO',
    'gallery_view' => 'Böyüt',
    'booking_sub' => 'Xidmət, usta və vaxtı seçin. Bron üçün beh: qiymətin %p%-i (min %m AZN).',
    'booking_success_title' => 'Bron qeydə alındı!',
    'booking_success_desc' => 'Rezervasiyanız menecer təsdiqini gözləyir. Bron kodunu yadda saxlayın.',
    'label_code' => 'Bron kodu',
    'label_datetime' => 'Tarix və saat',
    'label_price' => 'Xidmətin qiyməti',
    'label_deposit' => 'Beh (ilkin ödəniş)',
    'label_card' => 'Kart nömrəsi',
    'label_holder' => 'Kart sahibi',
    'pay_note' => 'Behi 24 saat ərzində yuxarıdakı karta köçürün və ödəniş qəbzini WhatsApp ilə göndərin. Menecer ödənişi yoxladıqdan sonra bron təsdiqlənəcək.',
    'btn_wa_pay' => 'Ödəniş qəbzini göndər',
    'att_work' => 'İşdədir',
    'att_off' => 'İşdə deyil',
    'booking_error' => 'Bron yaradıla bilmədi. Yenidən cəhd edin.',
    'btn_close' => 'Bağla',
    'nav_reviews' => 'Rəylər',
    'nav_menu' => 'Menyu',
    'section_index_label' => 'Bölmələr',
    'reviews_slogan' => 'Dəyərli müştərilərimiz, fikirləriniz bizim üçün vacibdir.',
    'reviews_title' => 'Müştəri Rəyləri',
    'reviews_desc' => 'Rəylər real ziyarətlərdən sonra yazılır.',
    'reviews_empty' => 'Hələ rəy yoxdur. İlk rəyi siz yazın!',
    'reviews_write' => 'Rəy yaz',
    'reviews_rating_label' => 'Orta reytinq',
    'reviews_count' => '%d rəy',
    'reviews_based' => '%d təsdiqlənmiş rəy əsasında',
    'reviews_verified' => 'Təsdiqlənmiş ziyarət',
    'reviews_reply' => 'Salon cavabı',
    'reviews_form_title' => 'Rəyinizi yazın',
    'reviews_form_sub' => 'Bron kodunuzu daxil edin. Rəy menecer təsdiqindən sonra saytda görünəcək.',
    'reviews_code' => 'Bron kodu',
    'reviews_stars' => 'Ulduz sayı',
    'reviews_text' => 'Rəyiniz',
    'reviews_text_ph' => 'Ziyarətiniz necə keçdi?',
    'reviews_submit' => 'Rəyi göndər',
    'reviews_ok' => 'Təşəkkür edirik! Rəyiniz təsdiqə göndərildi.',
    'reviews_error' => 'Rəy göndərilmədi. Yenidən cəhd edin.',
    'contact_wa' => 'WhatsApp ilə yaz',
    'wa_general_msg' => 'Salam! Xidmətlərinizlə maraqlanıram.',
    'wa_service_msg' => 'Salam! %s xidməti ilə maraqlanıram.',
    'reviews_reply_btn' => 'Fikir bildir',
    'reviews_reply_title' => 'Fikrinizi bildirin',
    'reviews_reply_sub' => 'Bu rəyə qısa fikrinizi yazın. Menecer təsdiqindən sonra görünəcək.',
    'reviews_reply_text' => 'Fikriniz',
    'reviews_reply_ph' => 'Rəy haqqında nə düşünürsünüz?',
    'reviews_reply_submit' => 'Göndər',
    'reviews_reply_ok' => 'Fikriniz təsdiqə göndərildi.',
    'reviews_reply_error' => 'Fikir göndərilmədi. Yenidən cəhd edin.',
    'reviews_comment_label' => 'Ziyarətçi fikri',
    'owner_badge' => 'Sahibə',
    'studio_eyebrow' => 'Virtual stil studiyası',
    'studio_title' => 'Öz şəklinizlə «əvvəl / sonra» görün',
    'studio_sub' => 'Şəklinizi yükləyin, xidməti və stili seçin — iş görülməzdən əvvəl nəticəni təxmini görün. Şəkil serverə göndərilmir.',
    'studio_step_photo' => 'Şəkil',
    'studio_step_style' => 'Stil',
    'studio_step_result' => 'Nəticə',
    'studio_step_send' => 'Ustaya göndər',
    'studio_upload' => 'Şəkil yükləyin',
    'studio_drop' => 'Şəkli buraya sürükləyin və ya seçin · JPG, PNG, WEBP · maks 10 MB',
    'studio_change' => 'Şəkli dəyiş',
    'studio_clear' => 'Şəkli sil',
    'studio_privacy' => 'Şəkliniz heç bir serverə yüklənmir — yalnız bu brauzerdə qalır. «Şəkli sil» düyməsi ilə dərhal silinir; səhifəni bağlayanda da avtomatik silinir.',
    'studio_note' => 'Təxmini önizləmədir — dəqiq nəticə ustadla müəyyənləşir.',
    'studio_demo_badge' => 'Nümunə model',
    'studio_own_badge' => 'Sizin şəkiliniz',
    'studio_pick' => 'Stil seçin',
    'studio_none' => 'Hələ stil seçilməyib',
    'studio_selected' => 'Seçilmiş stillər',
    'studio_send' => 'Ustaya göndər',
    'studio_send_hint' => 'Seçimləriniz bron qeydinə əlavə olunur — usta hazırlıqlı qarşılayır.',
    'studio_toast_ok' => 'Şəkil yükləndi. Sağdakı stillərdən birini seçin.',
    'studio_toast_del' => 'Şəkil silindi — heç yerdə qalmadı.',
    'studio_bad_type' => 'Yalnız şəkil faylı seçin (JPG, PNG, WEBP).',
    'studio_brief_prefix' => 'Stil studiyası seçimi',
    'studio_brief_note' => 'təxmini önizləmə əsasında',
  ],
  'en' => [
    'demo_banner' => 'This is a demo website — Created by Skyweb',
    'back_to_sky' => 'Back to Skyweb',
    'order_site' => 'Order This Website',
    'brand_sub' => 'Beauty studio · Baku',
    'nav_home' => 'Home',
    'nav_services' => 'Services & Pricing',
    'nav_stylists' => 'Our Stylists',
    'nav_before_after' => 'Before / After',
    'nav_book' => 'Book Appointment',
    'hero_tag' => 'A small studio, proper attention',
    'hero_title_1' => 'An hour for yourself,',
    'hero_title_2' => 'we\'ll take care of the rest.',
    'hero_desc' => 'Hair, nails, brows and skin in one place. 20% off your first visit.',
    'hero_btn_book' => 'Book a slot',
    'hero_btn_prices' => 'See the prices',
    'stat_1_n' => '12+',
    'stat_1_t' => 'Years Expertise',
    'stat_2_n' => '4',
    'stat_2_t' => 'Stylists',
    'stat_3_n' => '8',
    'stat_3_t' => 'Services',
    'tab_all' => 'All Services',
    'tab_hair' => 'Hair & Color',
    'tab_nails' => 'Nails & Pedicure',
    'tab_face' => 'Facial & Aesthetic Spa',
    'tab_makeup' => 'Makeup & Brows',
    'btn_book_service' => 'Book Service',
    'before_after_title' => 'Transformation Gallery',
    'before_after_desc' => 'Real before-and-after work from our stylists.',
    'state_before' => 'BEFORE',
    'state_after' => 'AFTER',
    'stylists_title' => 'Master Stylists',
    'stylists_desc' => 'Four people, four specialities. You can book the one you want by name.',
    'booking_modal_title' => 'Online Appointment Booking',
    'booking_modal_desc' => 'Select your service, preferred artist, and schedule seamlessly.',
    'field_service' => 'Service Category',
    'field_stylist' => 'Select Master',
    'field_date' => 'Date',
    'field_time' => 'Time Slot',
    'field_name' => 'Your Full Name',
    'field_phone' => 'Mobile Number',
    'btn_confirm_booking' => 'Confirm Booking',
    'ba_item1_t' => 'Balayage',
    'ba_item1_d' => 'A soft step from darker roots to lighter ends. The hair looks glossy and alive.',
    'ba_item2_t' => 'Deep cleansing',
    'ba_item2_d' => 'The mask draws out impurities so the skin can breathe again.',
    'ba_item3_t' => 'Manicure & gel polish',
    'ba_item3_d' => 'We shape the nails and finish with a neat coat that lasts 3–4 weeks.',
    'footer_desc' => 'A beauty studio in central Baku. Demo site by Skyweb.az.',
    'footer_rights' => 'All rights reserved.',
    'hero_card_badge' => 'SPA & SALON',
    'hero_card_rating' => '★ 4.9 RATING',
    'hero_card_care' => 'Most booked',
    'hero_card_service' => 'Deep cleanse & Balayage',
    'hero_card_offer' => '-20% OFF',
    'offer_daily' => 'OFFER OF THE DAY',
    'offer_weekly' => 'OFFER OF THE WEEK',
    'offer_today' => 'Today only',
    'offer_week' => 'This week only',
    'offer_apply' => 'Claim this offer',
    'offer_corporate' => 'For company teams',
    'toast_file_too_big' => 'File is too large (max 10 MB)',
    'toast_booked' => 'Booking received!',
    'wa_booking_intro' => 'Hello! Online booking:',
    'wa_service' => 'Service',
    'wa_stylist' => 'Stylist',
    'wa_date' => 'Date',
    'wa_customer' => 'Client',
    'wa_contact' => 'Contact',
    'wa_note' => 'Note',
    'meta_desc' => 'Online booking, professional stylists, transparent prices and real results. A modern, fast and mobile-friendly beauty salon website.',
    'services_desc' => 'Clear prices, no extras. Pick your master and time.',
    'nav_gallery' => 'Gallery',
    'gallery_title' => 'Crafted by our masters',
    'gallery_desc' => 'Photos and videos of our masters’ work.',
    'gallery_empty' => 'Examples of our masters’ work will appear here soon.',
    'gallery_photo' => 'PHOTO',
    'gallery_video' => 'VIDEO',
    'gallery_view' => 'View',
    'booking_sub' => 'Choose a service, stylist and time. Deposit: %p% of the price (min %m AZN).',
    'booking_success_title' => 'Booking received!',
    'booking_success_desc' => 'Your reservation is awaiting manager confirmation. Please keep your booking code.',
    'label_code' => 'Booking code',
    'label_datetime' => 'Date & time',
    'label_price' => 'Service price',
    'label_deposit' => 'Deposit (prepayment)',
    'label_card' => 'Card number',
    'label_holder' => 'Card holder',
    'pay_note' => 'Transfer the deposit to the card above within 24 hours and send the receipt via WhatsApp. The manager will confirm your booking after verifying the payment.',
    'btn_wa_pay' => 'Send payment receipt',
    'att_work' => 'On duty',
    'att_off' => 'Day off',
    'booking_error' => 'The booking could not be created. Please try again.',
    'btn_close' => 'Close',
    'nav_reviews' => 'Reviews',
    'nav_menu' => 'Menu',
    'section_index_label' => 'Sections',
    'reviews_slogan' => 'Your feedback matters to us — thank you for being here.',
    'reviews_title' => 'Client Reviews',
    'reviews_desc' => 'Reviews from real visits, checked before publishing.',
    'reviews_empty' => 'No reviews yet. Be the first to write one!',
    'reviews_write' => 'Write a review',
    'reviews_rating_label' => 'Average rating',
    'reviews_count' => '%d reviews',
    'reviews_based' => 'Based on %d approved reviews',
    'reviews_verified' => 'Verified visit',
    'reviews_reply' => 'Salon reply',
    'reviews_form_title' => 'Write your review',
    'reviews_form_sub' => 'Enter your booking code. The review appears after manager approval.',
    'reviews_code' => 'Booking code',
    'reviews_stars' => 'Rating',
    'reviews_text' => 'Your review',
    'reviews_text_ph' => 'How was your visit?',
    'reviews_submit' => 'Send review',
    'reviews_ok' => 'Thank you! Your review has been sent for approval.',
    'reviews_error' => 'The review could not be sent. Please try again.',
    'contact_wa' => 'Write on WhatsApp',
    'wa_general_msg' => 'Hello! I am interested in your services.',
    'wa_service_msg' => 'Hello! I am interested in %s.',
    'reviews_reply_btn' => 'Add a comment',
    'reviews_reply_title' => 'Share your thought',
    'reviews_reply_sub' => 'Write a short comment on this review. It appears after manager approval.',
    'reviews_reply_text' => 'Your comment',
    'reviews_reply_ph' => 'What do you think about this review?',
    'reviews_reply_submit' => 'Send',
    'reviews_reply_ok' => 'Your comment was sent for review.',
    'reviews_reply_error' => 'The comment could not be sent. Please try again.',
    'reviews_comment_label' => 'Visitor comment',
    'owner_badge' => 'Owner',
    'studio_eyebrow' => 'Virtual style studio',
    'studio_title' => 'See the “before / after” on your own photo',
    'studio_sub' => 'Upload your photo, choose a service and a style — see an approximate result before the work is done. Your photo is never sent to a server.',
    'studio_step_photo' => 'Photo',
    'studio_step_style' => 'Style',
    'studio_step_result' => 'Result',
    'studio_step_send' => 'Send to stylist',
    'studio_upload' => 'Upload a photo',
    'studio_drop' => 'Drag a photo here or choose a file · JPG, PNG, WEBP · max 10 MB',
    'studio_change' => 'Change photo',
    'studio_clear' => 'Delete photo',
    'studio_privacy' => 'Your photo is not uploaded anywhere — it stays only in this browser. “Delete photo” removes it instantly, and closing the page clears it too.',
    'studio_note' => 'This is an approximate preview — the exact result is agreed with the stylist.',
    'studio_demo_badge' => 'Sample model',
    'studio_own_badge' => 'Your photo',
    'studio_pick' => 'Choose a style',
    'studio_none' => 'No style selected yet',
    'studio_selected' => 'Selected styles',
    'studio_send' => 'Send to stylist',
    'studio_send_hint' => 'Your choices are added to the booking note, so the stylist is prepared.',
    'studio_toast_ok' => 'Photo loaded. Pick a style on the right.',
    'studio_toast_del' => 'Photo deleted — nothing is stored.',
    'studio_bad_type' => 'Please choose an image file (JPG, PNG, WEBP).',
    'studio_brief_prefix' => 'Style studio selection',
    'studio_brief_note' => 'based on an approximate preview',
  ],
  'tr' => [
    'demo_banner' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
    'back_to_sky' => 'Skyweb\'e Dön',
    'order_site' => 'Bu Siteyi Sipariş Et',
    'brand_sub' => 'Güzellik stüdyosu · Bakü',
    'nav_home' => 'Ana Sayfa',
    'nav_services' => 'Hizmetler & Fiyatlar',
    'nav_stylists' => 'Uzman Kadromuz',
    'nav_before_after' => 'Öncesi / Sonrası',
    'nav_book' => 'Randevu Al',
    'hero_tag' => 'Küçük stüdyo, gerçek ilgi',
    'hero_title_1' => 'Kendine bir saat,',
    'hero_title_2' => 'gerisini bize bırak.',
    'hero_desc' => 'Saç, tırnak, kaş ve cilt tek adreste. İlk gelişte %20 indirim.',
    'hero_btn_book' => 'Randevu al',
    'hero_btn_prices' => 'Fiyatlara bak',
    'stat_1_n' => '12+',
    'stat_1_t' => 'Yıllık Deneyim',
    'stat_2_n' => '4',
    'stat_2_t' => 'Uzman',
    'stat_3_n' => '8',
    'stat_3_t' => 'Hizmet',
    'tab_all' => 'Tüm Hizmetler',
    'tab_hair' => 'Saç & Renklendirme',
    'tab_nails' => 'Manikür & Pedikür',
    'tab_face' => 'Cilt Bakımı & Spa',
    'tab_makeup' => 'Makyaj & Kaş',
    'btn_book_service' => 'Randevu Ayır',
    'before_after_title' => 'Büyüleyici Değişimler',
    'before_after_desc' => 'Ustalarımızın gerçek öncesi-sonrası çalışmaları.',
    'state_before' => 'ÖNCE',
    'state_after' => 'SONRA',
    'stylists_title' => 'Stilistlerimiz',
    'stylists_desc' => 'Dört usta, dört ayrı uzmanlık. İstediğiniz uzmanı adıyla seçebilirsiniz.',
    'booking_modal_title' => 'Online Randevu Sistemi',
    'booking_modal_desc' => 'Hizmeti, stilisti ve uygun saat dilimini seçerek saniyeler içinde randevu oluşturun.',
    'field_service' => 'Hizmet Türü',
    'field_stylist' => 'Stilist Seçimi',
    'field_date' => 'Tarih',
    'field_time' => 'Saat',
    'field_name' => 'Adınız Soyadınız',
    'field_phone' => 'Telefon Numaranız',
    'btn_confirm_booking' => 'Randevuyu Onayla',
    'ba_item1_t' => 'Balayaj',
    'ba_item1_d' => 'Koyu köklerden açık uçlara yumuşak geçiş. Saç parlak ve canlı görünüyor.',
    'ba_item2_t' => 'Derin temizlik',
    'ba_item2_d' => 'Maskanın etkisiyle gözenekler temizlenir, cilt nefes alır ve tazelenir.',
    'ba_item3_t' => 'Manikür & kalıcı oje',
    'ba_item3_d' => 'Tırnak formu düzəldilir ve 3–4 hafta dayanan düzgün bir örtü uygulanır.',
    'footer_desc' => 'Bakü merkezinde güzellik stüdyosu. Skyweb.az demo sitesi.',
    'footer_rights' => 'Tüm hakları saklıdır.',
    'hero_card_badge' => 'SPA & SALON',
    'hero_card_rating' => '★ 4.9 PUAN',
    'hero_card_care' => 'En çok seçilen',
    'hero_card_service' => 'Derin temizlik & Balyaj',
    'hero_card_offer' => '%20 İNDİRİM',
    'offer_daily' => 'GÜNÜN TEKLİFİ',
    'offer_weekly' => 'HAFTANIN TEKLİFİ',
    'offer_today' => 'Sadece bugün',
    'offer_week' => 'Sadece bu hafta',
    'offer_apply' => 'Başvur',
    'offer_corporate' => 'Kurum çalışanları için',
    'toast_file_too_big' => 'Dosya çok büyük (en fazla 10 MB)',
    'toast_booked' => 'Randevu alındı!',
    'wa_booking_intro' => 'Merhaba! Online randevu:',
    'wa_service' => 'Hizmet',
    'wa_stylist' => 'Uzman',
    'wa_date' => 'Tarih',
    'wa_customer' => 'Müşteri',
    'wa_contact' => 'İletişim',
    'wa_note' => 'Not',
    'meta_desc' => 'Online randevu, uzman stilistler, şeffaf fiyatlar ve gerçek sonuçlar. Modern, hızlı ve mobil uyumlu güzellik salonu sitesi.',
    'services_desc' => 'Açık fiyatlar, ek ücret yok. Ustayı ve saati seçin.',
    'nav_gallery' => 'Galeri',
    'gallery_title' => 'Ustaların el işleri',
    'gallery_desc' => 'Ustalarımızın fotoğraf ve videoları.',
    'gallery_empty' => 'Ustalarımızın çalışmalarından örnekler yakında burada görünecek.',
    'gallery_photo' => 'FOTO',
    'gallery_video' => 'VİDEO',
    'gallery_view' => 'Büyüt',
    'booking_sub' => "Hizmet, uzman ve saat seçin. Kapora: fiyatın %p%'i (min %m AZN).",
    'booking_success_title' => 'Randevu alındı!',
    'booking_success_desc' => 'Rezervasyonunuz yönetici onayını bekliyor. Randevu kodunu saklayın.',
    'label_code' => 'Randevu kodu',
    'label_datetime' => 'Tarih ve saat',
    'label_price' => 'Hizmet fiyatı',
    'label_deposit' => 'Kapora (ön ödeme)',
    'label_card' => 'Kart numarası',
    'label_holder' => 'Kart sahibi',
    'pay_note' => 'Kaporayı 24 saat içinde yukarıdaki karta aktarın ve ödeme dekontunu WhatsApp ile gönderin. Yönetici ödemeyi kontrol ettikten sonra randevu onaylanacak.',
    'btn_wa_pay' => 'Ödeme dekontunu gönder',
    'att_work' => 'Çalışıyor',
    'att_off' => 'İzinde',
    'booking_error' => 'Randevu oluşturulamadı. Lütfen tekrar deneyin.',
    'btn_close' => 'Kapat',
    'nav_reviews' => 'Yorumlar',
    'nav_menu' => 'Menü',
    'section_index_label' => 'Bölümler',
    'reviews_slogan' => 'Değerli müşterilerimiz, fikirleriniz bizim için önemlidir.',
    'reviews_title' => 'Müşteri Yorumları',
    'reviews_desc' => 'Yorumlar gerçek ziyaretlerden sonra yazılır.',
    'reviews_empty' => 'Henüz yorum yok. İlk yorumu siz yazın!',
    'reviews_write' => 'Yorum yaz',
    'reviews_rating_label' => 'Ortalama puan',
    'reviews_count' => '%d yorum',
    'reviews_based' => '%d onaylı yoruma göre',
    'reviews_verified' => 'Doğrulanmış ziyaret',
    'reviews_reply' => 'Salon yanıtı',
    'reviews_form_title' => 'Yorumunuzu yazın',
    'reviews_form_sub' => 'Randevu kodunuzu girin. Yorum yönetici onayından sonra görünür.',
    'reviews_code' => 'Randevu kodu',
    'reviews_stars' => 'Yıldız sayısı',
    'reviews_text' => 'Yorumunuz',
    'reviews_text_ph' => 'Ziyaretiniz nasıldı?',
    'reviews_submit' => 'Yorumu gönder',
    'reviews_ok' => 'Teşekkürler! Yorumunuz onaya gönderildi.',
    'reviews_error' => 'Yorum gönderilemedi. Lütfen tekrar deneyin.',
    'contact_wa' => 'WhatsApp ile yaz',
    'wa_general_msg' => 'Merhaba! Hizmetlerinizle ilgileniyorum.',
    'wa_service_msg' => 'Merhaba! %s hizmetiyle ilgileniyorum.',
    'reviews_reply_btn' => 'Fikir bildir',
    'reviews_reply_title' => 'Fikrinizi paylaşın',
    'reviews_reply_sub' => 'Bu yoruma kısa görüşünüzü yazın. Yönetici onayından sonra görünecek.',
    'reviews_reply_text' => 'Görüşünüz',
    'reviews_reply_ph' => 'Bu yorum hakkında ne düşünüyorsunuz?',
    'reviews_reply_submit' => 'Gönder',
    'reviews_reply_ok' => 'Görüşünüz onaya gönderildi.',
    'reviews_reply_error' => 'Görüş gönderilemedi. Lütfen tekrar deneyin.',
    'reviews_comment_label' => 'Ziyaretçi görüşü',
    'owner_badge' => 'Kurucu',
    'studio_eyebrow' => 'Sanal stil stüdyosu',
    'studio_title' => 'Kendi fotoğrafınızla “öncesi / sonrası” görün',
    'studio_sub' => 'Fotoğrafınızı yükleyin, hizmeti ve stili seçin — işlem yapılmadan önce yaklaşık sonucu görün. Fotoğrafınız sunucuya gönderilmez.',
    'studio_step_photo' => 'Fotoğraf',
    'studio_step_style' => 'Stil',
    'studio_step_result' => 'Sonuç',
    'studio_step_send' => 'Uzmana gönder',
    'studio_upload' => 'Fotoğraf yükleyin',
    'studio_drop' => 'Fotoğrafı buraya sürükleyin veya seçin · JPG, PNG, WEBP · en fazla 10 MB',
    'studio_change' => 'Fotoğrafı değiştir',
    'studio_clear' => 'Fotoğrafı sil',
    'studio_privacy' => 'Fotoğrafınız hiçbir sunucuya yüklenmez — yalnızca bu tarayıcıda kalır. “Fotoğrafı sil” ile hemen silinir; sayfayı kapattığınızda da otomatik silinir.',
    'studio_note' => 'Yaklaşık önizlemedir — kesin sonuç uzmanla belirlenir.',
    'studio_demo_badge' => 'Örnek model',
    'studio_own_badge' => 'Sizin fotoğrafınız',
    'studio_pick' => 'Stil seçin',
    'studio_none' => 'Henüz stil seçilmedi',
    'studio_selected' => 'Seçilen stiller',
    'studio_send' => 'Uzmana gönder',
    'studio_send_hint' => 'Seçimleriniz randevu notuna eklenir — uzman hazırlıklı karşılar.',
    'studio_toast_ok' => 'Fotoğraf yüklendi. Sağdaki stillerden birini seçin.',
    'studio_toast_del' => 'Fotoğraf silindi — hiçbir yerde kalmadı.',
    'studio_bad_type' => 'Lütfen bir görsel dosyası seçin (JPG, PNG, WEBP).',
    'studio_brief_prefix' => 'Stil stüdyosu seçimi',
    'studio_brief_note' => 'yaklaşık önizlemeye göre',
  ],
  'ru' => [
    'demo_banner' => 'Это демонстрационный сайт — Создано Skyweb',
    'back_to_sky' => 'Вернуться в Skyweb',
    'order_site' => 'Заказать такой сайт',
    'brand_sub' => 'Салон красоты · Баку',
    'nav_home' => 'Главная',
    'nav_services' => 'Услуги и цены',
    'nav_stylists' => 'Наши мастера',
    'nav_before_after' => 'До / После',
    'nav_book' => 'Онлайн-запись',
    'hero_tag' => 'Небольшая студия, много внимания',
    'hero_title_1' => 'Час для себя,',
    'hero_title_2' => 'об остальном позаботимся мы.',
    'hero_desc' => 'Волосы, ногти, брови и кожа — в одном месте. Скидка 20% на первый визит.',
    'hero_btn_book' => 'Записаться',
    'hero_btn_prices' => 'Смотреть цены',
    'stat_1_n' => '12+',
    'stat_1_t' => 'Лет опыта',
    'stat_2_n' => '4',
    'stat_2_t' => 'Мастера',
    'stat_3_n' => '8',
    'stat_3_t' => 'Услуги',
    'tab_all' => 'Все услуги',
    'tab_hair' => 'Волосы и окрашивание',
    'tab_nails' => 'Маникюр и педикюр',
    'tab_face' => 'Косметология и СПА',
    'tab_makeup' => 'Макияж и брови',
    'btn_book_service' => 'Записаться',
    'before_after_title' => 'Преображения До и После',
    'before_after_desc' => 'Реальные работы мастеров «до и после».',
    'state_before' => 'ДО',
    'state_after' => 'ПОСЛЕ',
    'stylists_title' => 'Наша команда',
    'stylists_desc' => 'Четыре мастера, четыре специализации. Можно записаться к конкретному мастеру.',
    'booking_modal_title' => 'Онлайн запись на визит',
    'booking_modal_desc' => 'Выберите процедуру, любимого мастера и удобное время за пару кликов.',
    'field_service' => 'Услуга',
    'field_stylist' => 'Мастер',
    'field_date' => 'Дата',
    'field_time' => 'Время',
    'field_name' => 'Ваше имя',
    'field_phone' => 'Номер телефона',
    'btn_confirm_booking' => 'Подтвердить запись',
    'ba_item1_t' => 'Балаяж',
    'ba_item1_d' => 'Мягкий переход от тёмных корней к светлым кончикам. Волосы выглядят живыми и блестящими.',
    'ba_item2_t' => 'Глубокое очищение',
    'ba_item2_d' => 'Маска очищает поры, кожа снова дышит и выглядит свежей.',
    'ba_item3_t' => 'Маникюр и гель-лак',
    'ba_item3_d' => 'Придаём форму и наносим аккуратное покрытие, которое держится 3–4 недели.',
    'footer_desc' => 'Студия красоты в центре Баку. Демо-сайт от Skyweb.az.',
    'footer_rights' => 'Все права защищены.',
    'hero_card_badge' => 'SPA & SALON',
    'hero_card_rating' => '★ 4.9 РЕЙТИНГ',
    'hero_card_care' => 'Выбирают чаще всего',
    'hero_card_service' => 'Глубокое очищение и балаяж',
    'hero_card_offer' => '-20% СКИДКА',
    'offer_daily' => 'ПРЕДЛОЖЕНИЕ ДНЯ',
    'offer_weekly' => 'ПРЕДЛОЖЕНИЕ НЕДЕЛИ',
    'offer_today' => 'Только сегодня',
    'offer_week' => 'Только на этой неделе',
    'offer_apply' => 'Записаться',
    'offer_corporate' => 'Для сотрудников компаний',
    'toast_file_too_big' => 'Файл слишком большой (до 10 МБ)',
    'toast_booked' => 'Запись принята!',
    'wa_booking_intro' => 'Здравствуйте! Онлайн-запись:',
    'wa_service' => 'Услуга',
    'wa_stylist' => 'Мастер',
    'wa_date' => 'Дата',
    'wa_customer' => 'Клиент',
    'wa_contact' => 'Контакт',
    'wa_note' => 'Примечание',
    'meta_desc' => 'Онлайн-запись, профессиональные мастера, прозрачные цены и реальные результаты. Современный, быстрый и удобный сайт салона красоты.',
    'services_desc' => 'Честные цены, без доплат. Выберите мастера и время.',
    'nav_gallery' => 'Галерея',
    'gallery_title' => 'Работы наших мастеров',
    'gallery_desc' => 'Фото и видео работ наших мастеров.',
    'gallery_empty' => 'Примеры работ наших мастеров скоро появятся здесь.',
    'gallery_photo' => 'ФОТО',
    'gallery_video' => 'ВИДЕО',
    'gallery_view' => 'Открыть',
    'booking_sub' => 'Выберите услугу, мастера и время. Депозит: %p% от цены (мин. %m AZN).',
    'booking_success_title' => 'Запись оформлена!',
    'booking_success_desc' => 'Ваша запись ожидает подтверждения менеджера. Сохраните код брони.',
    'label_code' => 'Код брони',
    'label_datetime' => 'Дата и время',
    'label_price' => 'Стоимость услуги',
    'label_deposit' => 'Депозит (предоплата)',
    'label_card' => 'Номер карты',
    'label_holder' => 'Держатель карты',
    'pay_note' => 'Переведите депозит на карту выше в течение 24 часов и отправьте чек в WhatsApp. Менеджер подтвердит запись после проверки оплаты.',
    'btn_wa_pay' => 'Отправить чек',
    'att_work' => 'На работе',
    'att_off' => 'Не работает',
    'booking_error' => 'Не удалось создать запись. Попробуйте ещё раз.',
    'btn_close' => 'Закрыть',
    'nav_reviews' => 'Отзывы',
    'nav_menu' => 'Меню',
    'section_index_label' => 'Разделы',
    'reviews_slogan' => 'Дорогие клиенты, ваше мнение важно для нас.',
    'reviews_title' => 'Отзывы клиентов',
    'reviews_desc' => 'Отзывы после реальных визитов, с проверкой перед публикацией.',
    'reviews_empty' => 'Отзывов пока нет. Оставьте первый!',
    'reviews_write' => 'Оставить отзыв',
    'reviews_rating_label' => 'Средний рейтинг',
    'reviews_count' => '%d отзывов',
    'reviews_based' => 'На основе %d подтверждённых отзывов',
    'reviews_verified' => 'Подтверждённый визит',
    'reviews_reply' => 'Ответ салона',
    'reviews_form_title' => 'Оставьте отзыв',
    'reviews_form_sub' => 'Введите код записи. Отзыв появится после подтверждения менеджером.',
    'reviews_code' => 'Код записи',
    'reviews_stars' => 'Оценка',
    'reviews_text' => 'Ваш отзыв',
    'reviews_text_ph' => 'Как прошёл ваш визит?',
    'reviews_submit' => 'Отправить отзыв',
    'reviews_ok' => 'Спасибо! Ваш отзыв отправлен на проверку.',
    'reviews_error' => 'Не удалось отправить отзыв. Попробуйте ещё раз.',
    'contact_wa' => 'Написать в WhatsApp',
    'wa_general_msg' => 'Здравствуйте! Меня интересуют ваши услуги.',
    'wa_service_msg' => 'Здравствуйте! Меня интересует услуга «%s».',
    'reviews_reply_btn' => 'Оставить комментарий',
    'reviews_reply_title' => 'Поделитесь мнением',
    'reviews_reply_sub' => 'Напишите короткий комментарий к отзыву. Появится после одобрения администратором.',
    'reviews_reply_text' => 'Ваш комментарий',
    'reviews_reply_ph' => 'Что вы думаете об этом отзыве?',
    'reviews_reply_submit' => 'Отправить',
    'reviews_reply_ok' => 'Ваш комментарий отправлен на модерацию.',
    'reviews_reply_error' => 'Не удалось отправить комментарий. Попробуйте снова.',
    'reviews_comment_label' => 'Комментарий посетителя',
    'owner_badge' => 'Основатель',
    'studio_eyebrow' => 'Виртуальная студия стиля',
    'studio_title' => 'Посмотрите «до / после» на своём фото',
    'studio_sub' => 'Загрузите фото, выберите услугу и стиль — увидите примерный результат до процедуры. Фото не отправляется на сервер.',
    'studio_step_photo' => 'Фото',
    'studio_step_style' => 'Стиль',
    'studio_step_result' => 'Результат',
    'studio_step_send' => 'Отправить мастеру',
    'studio_upload' => 'Загрузить фото',
    'studio_drop' => 'Перетащите фото сюда или выберите файл · JPG, PNG, WEBP · до 10 МБ',
    'studio_change' => 'Заменить фото',
    'studio_clear' => 'Удалить фото',
    'studio_privacy' => 'Ваше фото никуда не загружается — оно остаётся только в этом браузере. Кнопка «Удалить фото» стирает его сразу, при закрытии страницы оно тоже исчезает.',
    'studio_note' => 'Это примерный предпросмотр — точный результат обсуждается с мастером.',
    'studio_demo_badge' => 'Демо-модель',
    'studio_own_badge' => 'Ваше фото',
    'studio_pick' => 'Выберите стиль',
    'studio_none' => 'Стиль пока не выбран',
    'studio_selected' => 'Выбранные стили',
    'studio_send' => 'Отправить мастеру',
    'studio_send_hint' => 'Ваш выбор добавится в комментарий к записи — мастер будет готов.',
    'studio_toast_ok' => 'Фото загружено. Выберите стиль справа.',
    'studio_toast_del' => 'Фото удалено — нигде не сохранилось.',
    'studio_bad_type' => 'Выберите файл изображения (JPG, PNG, WEBP).',
    'studio_brief_prefix' => 'Выбор в студии стиля',
    'studio_brief_note' => 'по примерному предпросмотру',
  ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

// ——— Dilə görə vahid formatlaşdırma (müddət / təcrübə) ———
$dur_units = ['az' => 'dəq', 'en' => 'min', 'tr' => 'dk', 'ru' => 'мин'];
$exp_fmt   = [
    'az' => '%s il təcrübə',
    'en' => '%s years experience',
    'tr' => '%s yıl deneyim',
    'ru' => '%s лет опыта',
];
$fmt_dur = function ($minutes) use ($lang, $dur_units): string {
    return $minutes . ' ' . ($dur_units[$lang] ?? 'dəq');
};
$fmt_exp = function ($years) use ($lang, $exp_fmt): string {
    return sprintf($exp_fmt[$lang] ?? '%s il təcrübə', $years);
};
$money = function ($amount): string {
    return number_format((float)$amount, 0, '', ' ') . ' AZN';
};

$BD = require __DIR__ . '/../../config/demo-beauty.php';

// ——— Panel dəyişiklikləri: data/demo-beauty.json (yoxdursa default qalır) ———
$bd_over = [];
$bd_json = __DIR__ . '/../../data/demo-beauty.json';
if (is_file($bd_json)) {
    $decoded = json_decode((string)file_get_contents($bd_json), true);
    if (is_array($decoded)) $bd_over = $decoded;
}
if (!empty($bd_over['brand']) && is_array($bd_over['brand'])) {
    $BD['brand'] = array_merge($BD['brand'], array_filter($bd_over['brand'], fn($v) => $v !== null && $v !== ''));
}
if (!empty($bd_over['theme']) && isset($BD['themes'][$bd_over['theme']])) {
    $BD['theme'] = (string)$bd_over['theme'];
}
$bdCats = ['hair', 'nails', 'face', 'makeup'];
if (!empty($bd_over['services']) && is_array($bd_over['services'])) {
    $defaultIds = array_map(fn($s) => (string)$s['id'], $BD['services']);
    foreach ($BD['services'] as $i => $s) {
        $ov = $bd_over['services'][(string)$s['id']] ?? $bd_over['services'][$i] ?? null;
        if (!is_array($ov)) continue;
        foreach (['price', 'old_price', 'duration'] as $k) {
            if (array_key_exists($k, $ov) && $ov[$k] !== '' && $ov[$k] !== null) {
                $BD['services'][$i][$k] = (int)$ov[$k];
            }
        }
        foreach (['title', 'desc'] as $k) {
            if (!empty($ov[$k]) && is_array($ov[$k])) {
                $BD['services'][$i][$k] = array_merge($s[$k], array_filter($ov[$k], fn($v) => $v !== null && $v !== ''));
            }
        }
        if (array_key_exists('cat', $ov) && in_array((string)$ov['cat'], $bdCats, true)) {
            $BD['services'][$i]['cat'] = (string)$ov['cat'];
        }
        if (!empty($ov['img']) && is_string($ov['img'])) {
            $BD['services'][$i]['img'] = (string)$ov['img'];
        }
        if (array_key_exists('active', $ov)) $BD['services'][$i]['active'] = (bool)$ov['active'];
    }
    // Panelden əlavə edilmiş xidmətlər default kataloqda yoxdur — JSON-dan oxunur.
    foreach ($bd_over['services'] as $key => $ov) {
        if (!is_array($ov) || empty($ov['custom'])) continue;
        $id = (string)$key;
        if (in_array($id, $defaultIds, true)) continue;
        $title = isset($ov['title']) && is_array($ov['title']) ? $ov['title'] : [];
        $desc  = isset($ov['desc']) && is_array($ov['desc']) ? $ov['desc'] : [];
        if (trim((string)($title['az'] ?? '')) === '') continue;
        $BD['services'][] = [
            'id' => (int)$id,
            'cat' => in_array((string)($ov['cat'] ?? ''), $bdCats, true) ? (string)$ov['cat'] : 'hair',
            'price' => max(0, (int)($ov['price'] ?? 0)),
            'old_price' => max(0, (int)($ov['old_price'] ?? 0)),
            'duration' => max(0, (int)($ov['duration'] ?? 30)),
            'img' => (string)($ov['img'] ?? ($BD['services'][0]['img'] ?? '')),
            'title' => $title,
            'desc' => $desc,
            'active' => (bool)($ov['active'] ?? true),
        ];
    }
}
$services = array_values(array_filter($BD['services'], fn($s) => ($s['active'] ?? true) !== false));
$stylists = bs_list($BD, true);

// ——— Günün / həftənin təklifi (panel → Təkliflər) ———
$offer     = bb_offer($BD, $bd_over);
$offerSvc  = null;
foreach ($services as $s) {
    if ((int)$s['id'] === (int)$offer['service_id']) { $offerSvc = $s; break; }
}
$offerOn   = $offer['active'] && $offerSvc !== null;
$offerBase = $offerSvc ? (int)$offerSvc['price'] : 0;
$offerPrice = ($offerSvc && $offer['price'] > 0 && $offer['price'] < $offerBase) ? (int)$offer['price'] : $offerBase;
$offerOff  = $offerOn && $offerBase > 0 && $offerPrice < $offerBase
    ? (int)round((1 - $offerPrice / $offerBase) * 100) : 0;
$offerBadge = $offer['period'] === 'weekly' ? $t['offer_weekly'] : $t['offer_daily'];
$offerWhen  = $offer['period'] === 'weekly' ? $t['offer_week'] : $t['offer_today'];
$offerNote  = $offerOn ? trim((string)($offer['note'][$lang] ?? '')) : '';
$offerCorp  = $offerOn && ($offer['audience'] ?? 'all') === 'corporate';

// ——— Bron API-si üçün beh ayarları, sessiya tokeni və davamiyyət ———
$bookSettings = bb_settings($bd_over);
if (empty($_SESSION['beauty_book_token'])) {
    $_SESSION['beauty_book_token'] = bin2hex(random_bytes(16));
}
$bookToken = (string)$_SESSION['beauty_book_token'];
$attAll    = bb_attendance();
$todayKey  = date('Y-m-d');

// ——— Rəylər: təsdiqlənmiş rəylər + orta reytinq ———
$rSum          = br_summary();
$reviewsPublic = br_public(6);
if (empty($_SESSION['beauty_review_token'])) {
    $_SESSION['beauty_review_token'] = bin2hex(random_bytes(16));
}
$reviewToken = (string)$_SESSION['beauty_review_token'];
$reviewCode  = preg_match('/^SB-\d{4}$/', strtoupper((string)($_GET['review'] ?? '')))
    ? strtoupper((string)$_GET['review']) : '';

// ——— Qalereya: panelden yüklənmiş real işlər (watermark artıq fayldadır) ———
$gallery_items = [];
$gallery_json  = __DIR__ . '/../../data/beauty-gallery.json';
if (is_file($gallery_json)) {
    $gj = json_decode((string)file_get_contents($gallery_json), true);
    foreach (($gj['items'] ?? []) as $it) {
        if (!is_array($it)) continue;
        $file = basename((string)($it['file'] ?? ''));
        if ($file === '' || !is_file(__DIR__ . '/../../uploads/beauty/' . $file)) continue;
        $poster = basename((string)($it['poster'] ?? ''));
        if ($poster !== '' && !is_file(__DIR__ . '/../../uploads/beauty/' . $poster)) $poster = '';
        $gallery_items[] = [
            'file'     => $file,
            'type'     => (($it['type'] ?? '') === 'video') ? 'video' : 'photo',
            'poster'   => $poster,
            'title'    => trim((string)($it['title'] ?? '')),
            'duration' => isset($it['duration']) && is_numeric($it['duration']) ? (float)$it['duration'] : null,
        ];
    }
    $gallery_items = array_reverse($gallery_items);
}
$mediaBase = '../../uploads/beauty/';

// Yükləmə bölməsi yalnız panelə giriş etmiş salon sahibinə görünür.
$galleryAdmin = !empty($_SESSION['bp_ok']);
$galleryLimits = beauty_media_limits();
$galleryFlash = [];
if ($galleryAdmin && !empty($_SESSION['bp_flash']) && is_array($_SESSION['bp_flash'])) {
    $galleryFlash = $_SESSION['bp_flash'];
    unset($_SESSION['bp_flash']);
}

$brandConf = $BD['brand'];
$themes    = $BD['themes'];
$themeKey  = $BD['theme'] ?? 'rose';
$theme     = $themes[$themeKey] ?? reset($themes);

// HEX → "r, g, b" (temalar üçün rgba dəyişənləri)
$hex_rgb = function (string $hex): string {
    $hex = ltrim(trim($hex), '#');
    if (strlen($hex) === 3) $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) return '255, 42, 133';
    return hexdec(substr($hex, 0, 2)) . ', ' . hexdec(substr($hex, 2, 2)) . ', ' . hexdec(substr($hex, 4, 2));
};

// ——— Tema palitrası: hər rəng üçün fon, kart, mətn çalarları hesablanır ———
$hx_arr = function (string $hex): array {
    $hex = ltrim(trim($hex), '#');
    if (strlen($hex) === 3) $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    if (!preg_match('/^[0-9a-fA-F]{6}$/', $hex)) return [255, 42, 133];
    return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
};
$hx_hex = function (array $c): string {
    return sprintf('#%02x%02x%02x',
        max(0, min(255, (int)round($c[0]))),
        max(0, min(255, (int)round($c[1]))),
        max(0, min(255, (int)round($c[2])))
    );
};
$hx_mix = function (array $a, array $b, float $t): array {
    $t = max(0.0, min(1.0, $t));
    return [$a[0] + ($b[0] - $a[0]) * $t, $a[1] + ($b[1] - $a[1]) * $t, $a[2] + ($b[2] - $a[2]) * $t];
};
$hx_rgbs = function (array $c): string {
    return max(0, min(255, (int)round($c[0]))) . ', ' . max(0, min(255, (int)round($c[1]))) . ', ' . max(0, min(255, (int)round($c[2])));
};
$theme_palette = function (array $th) use ($hx_arr, $hx_hex, $hx_mix, $hx_rgbs): array {
    $p    = $hx_arr((string)($th['primary'] ?? '#ff2a85'));
    $s    = $hx_arr((string)($th['secondary'] ?? '#00ffff'));
    $deep = [5, 13, 15];
    $ink    = $hx_mix($deep, $p, 0.07);
    $surf   = $hx_mix($deep, $p, 0.13);
    $surfHi = $hx_mix($deep, $p, 0.19);
    return [
        'bg1'          => $hx_hex($hx_mix($deep, $p, 0.04)),
        'bg2'          => $hx_hex($hx_mix($deep, $p, 0.10)),
        'bg3'          => $hx_hex($hx_mix($deep, $p, 0.16)),
        'bg4'          => $hx_hex($hx_mix($deep, $p, 0.05)),
        'ink'          => $hx_hex($ink),
        'ink_rgb'      => $hx_rgbs($ink),
        'surface_rgb'  => $hx_rgbs($surf),
        'panel'        => $hx_hex($hx_mix($deep, $p, 0.16)),
        'card'         => 'rgba(' . $hx_rgbs($surf) . ', 0.85)',
        'card_strong'  => $hx_hex($hx_mix($deep, $p, 0.21)),
        'footer'       => $hx_hex($hx_mix($deep, $p, 0.02)),
        'on_accent'    => $hx_hex($hx_mix($deep, $p, 0.09)),
        'rose_deep'    => $hx_hex($hx_mix($p, [0, 0, 0], 0.26)),
        'rose_soft'    => $hx_hex($hx_mix($p, [255, 255, 255], 0.30)),
        'text_main'    => $hx_hex($hx_mix([255, 255, 255], $s, 0.05)),
        'text_muted'   => $hx_hex($hx_mix($s, [228, 241, 241], 0.58)),
    ];
};
$palette = $theme_palette($theme);

// ——— SEO / sosial meta üçün brend mərkəzli dəyərlər ———
$brand      = trim((string)($brandConf['name'] ?? '')) ?: 'Sky Beauty';
$waPhone    = preg_replace('/\D+/', '', (string)($brandConf['whatsapp'] ?? '994503936998'));
$page_title = $brand . ' — ' . $t['brand_sub'];
$page_desc  = $brand . ' — ' . $t['meta_desc'];
$base_url   = ((($_SERVER['HTTPS'] ?? '') === 'on') ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
$page_path  = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
$page_url   = $base_url . $page_path;
$page_img   = 'https://images.pexels.com/photos/3993443/pexels-photo-3993443.jpeg?auto=compress&cs=tinysrgb&w=1200';
$lang_url   = function (string $l) use ($base_url, $page_path): string {
    return $base_url . $page_path . '?lang=' . $l;
};
$og_locales = ['az' => 'az_AZ', 'en' => 'en_US', 'ru' => 'ru_RU', 'tr' => 'tr_TR'];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='88'%3E%F0%9F%92%8E%3C/text%3E%3C/svg%3E">
  <meta name="description" content="<?= htmlspecialchars($page_desc) ?>">
  <link rel="canonical" href="<?= htmlspecialchars($page_url) ?>">
  <?php foreach (['az', 'en', 'ru', 'tr'] as $hl): ?>
  <link rel="alternate" hreflang="<?= $hl ?>" href="<?= htmlspecialchars($lang_url($hl)) ?>">
  <?php endforeach; ?>
  <link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($lang_url('az')) ?>">

  <!-- Open Graph (WhatsApp / Facebook / Instagram paylaşımı) -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= htmlspecialchars($brand) ?>">
  <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($page_desc) ?>">
  <meta property="og:url" content="<?= htmlspecialchars($page_url) ?>">
  <meta property="og:image" content="<?= htmlspecialchars($page_img) ?>">
  <meta property="og:image:alt" content="<?= htmlspecialchars($page_title) ?>">
  <meta property="og:locale" content="<?= $og_locales[$lang] ?? 'az_AZ' ?>">
  <?php foreach ($og_locales as $hl => $loc): if ($hl === $lang) continue; ?>
  <meta property="og:locale:alternate" content="<?= $loc ?>">
  <?php endforeach; ?>

  <!-- Twitter / X kartı -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?= htmlspecialchars($page_title) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($page_desc) ?>">
  <meta name="twitter:image" content="<?= htmlspecialchars($page_img) ?>">

  <!-- Schema.org: gözəllik salonu (reklam / axtarış üçün) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BeautySalon",
    "name": <?= json_encode($brand, JSON_UNESCAPED_UNICODE) ?>,
    "description": <?= json_encode($page_desc, JSON_UNESCAPED_UNICODE) ?>,
    "url": <?= json_encode($page_url, JSON_UNESCAPED_UNICODE) ?>,
    "image": <?= json_encode($page_img, JSON_UNESCAPED_UNICODE) ?>,
    "telephone": <?= json_encode($brandConf['phone'] ?? '+994 50 393 69 98', JSON_UNESCAPED_UNICODE) ?>,
    "priceRange": <?= json_encode(min(array_column($services, 'price')) . '–' . max(array_column($services, 'old_price') ?: array_column($services, 'price')) . ' AZN', JSON_UNESCAPED_UNICODE) ?>,
    "currenciesAccepted": "AZN",
    "sameAs": <?= json_encode(array_values(array_filter([
        $brandConf['instagram'] ?? '',
        $brandConf['tiktok'] ?? '',
        $brandConf['facebook'] ?? '',
    ])), JSON_UNESCAPED_UNICODE) ?>,
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Bakı",
      "addressCountry": "AZ"
    },
    "openingHoursSpecification": [{
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
      "opens": "10:00",
      "closes": "20:00"
    }]<?php if ($rSum['count'] > 0): ?>,
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": <?= json_encode(number_format((float)$rSum['avg'], 1, '.', ''), JSON_UNESCAPED_UNICODE) ?>,
      "reviewCount": <?= (int)$rSum['count'] ?>,
      "bestRating": "5"
    }<?php endif; ?>
  }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg-1: <?= $palette['bg1'] ?>;
      --sky-bg-2: <?= $palette['bg2'] ?>;
      --sky-bg-3: <?= $palette['bg3'] ?>;
      --sky-bg-4: <?= $palette['bg4'] ?>;
      --sky-ink: <?= $palette['ink'] ?>;
      --sky-ink-rgb: <?= $palette['ink_rgb'] ?>;
      --sky-surface-rgb: <?= $palette['surface_rgb'] ?>;
      --sky-panel: <?= $palette['panel'] ?>;
      --sky-card: <?= $palette['card'] ?>;
      --sky-card-strong: <?= $palette['card_strong'] ?>;
      --sky-footer: <?= $palette['footer'] ?>;
      --on-accent: <?= $palette['on_accent'] ?>;
      --sky-border: rgba(var(--cyan-rgb), 0.18);
      --neon-cyan: <?= htmlspecialchars($theme['secondary']) ?>;
      --cyan-rgb: <?= $hex_rgb($theme['secondary']) ?>;
      --beauty-rose: <?= htmlspecialchars($theme['primary']) ?>;
      --rose-rgb: <?= $hex_rgb($theme['primary']) ?>;
      --rose-deep: <?= $palette['rose_deep'] ?>;
      --rose-soft: <?= $palette['rose_soft'] ?>;
      --beauty-gold: <?= htmlspecialchars($theme['secondary']) ?>;
      --neon-glow: 0 0 18px rgba(var(--cyan-rgb), 0.20);
      --rose-glow: 0 0 18px rgba(var(--rose-rgb), 0.24);
      --text-main: <?= $palette['text_main'] ?>;
      --text-muted: <?= $palette['text_muted'] ?>;
      --dk-panel: <?= $palette['panel'] ?>;
      --dk-accent-rgb: <?= $hex_rgb($theme['primary']) ?>;
      --dk-muted: <?= $palette['text_muted'] ?>;
      --font-body: 'Inter', sans-serif;
      --font-heading: 'Outfit', sans-serif;
      --font-display: 'Playfair Display', Georgia, serif;
    }
<?php foreach ($themes as $tk => $th): $tp = $theme_palette($th); ?>
    body[data-theme="<?= htmlspecialchars($tk) ?>"] {
      --beauty-rose: <?= htmlspecialchars($th['primary']) ?>;
      --rose-rgb: <?= $hex_rgb($th['primary']) ?>;
      --rose-deep: <?= $tp['rose_deep'] ?>;
      --rose-soft: <?= $tp['rose_soft'] ?>;
      --neon-cyan: <?= htmlspecialchars($th['secondary']) ?>;
      --cyan-rgb: <?= $hex_rgb($th['secondary']) ?>;
      --beauty-gold: <?= htmlspecialchars($th['secondary']) ?>;
      --sky-bg-1: <?= $tp['bg1'] ?>;
      --sky-bg-2: <?= $tp['bg2'] ?>;
      --sky-bg-3: <?= $tp['bg3'] ?>;
      --sky-bg-4: <?= $tp['bg4'] ?>;
      --sky-ink: <?= $tp['ink'] ?>;
      --sky-ink-rgb: <?= $tp['ink_rgb'] ?>;
      --sky-surface-rgb: <?= $tp['surface_rgb'] ?>;
      --sky-panel: <?= $tp['panel'] ?>;
      --sky-card: <?= $tp['card'] ?>;
      --sky-card-strong: <?= $tp['card_strong'] ?>;
      --sky-footer: <?= $tp['footer'] ?>;
      --on-accent: <?= $tp['on_accent'] ?>;
      --text-main: <?= $tp['text_main'] ?>;
      --text-muted: <?= $tp['text_muted'] ?>;
      --dk-panel: <?= $tp['panel'] ?>;
      --dk-accent-rgb: <?= $hex_rgb($th['primary']) ?>;
      --dk-muted: <?= $tp['text_muted'] ?>;
    }
<?php endforeach; ?>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      background: linear-gradient(180deg, var(--sky-bg-1) 0%, var(--sky-bg-2) 30%, var(--sky-bg-3) 70%, var(--sky-bg-4) 100%);
      color: var(--text-main);
      font-family: var(--font-body);
      min-height: 100vh;
      line-height: 1.65;
      overflow-x: hidden;
      -webkit-font-smoothing: antialiased;
      transition: background 0.5s ease, color 0.3s ease;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; }

    /* Top Skyweb Demo Banner */
    .demo-bar {
      background: rgba(var(--sky-ink-rgb), 0.95);
      border-bottom: 1px solid var(--sky-border);
      padding: 8px 16px;
      font-size: 14px;
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
      background: rgba(var(--cyan-rgb), 0.15);
      color: var(--neon-cyan);
      border: 1px solid var(--neon-cyan);
      border-radius: 20px;
      padding: 2px 10px;
      font-weight: 700;
      font-size: 12px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      box-shadow: var(--neon-glow);
    }
    .demo-text { color: var(--text-muted); font-weight: 500; }
    .demo-bar-right { display: flex; flex-wrap: wrap; align-items: center; justify-content: flex-end; gap: 8px 12px; min-width: 0; }
    .theme-dots { display: flex; gap: 5px; padding: 3px 6px; background: rgba(0,0,0,0.35); border-radius: 20px; }
    .theme-dot {
      width: 14px;
      height: 14px;
      padding: 0;
      border-radius: 50%;
      border: 1.5px solid rgba(255,255,255,0.35);
      background: var(--dot);
      cursor: pointer;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    .theme-dot:hover { transform: scale(1.18); }
    .theme-dot.active { box-shadow: 0 0 0 2px var(--sky-bg-1), 0 0 0 4px var(--dot); }
    .demo-btn-sky {
      background: var(--neon-cyan);
      color: var(--on-accent);
      padding: 4px 12px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 13px;
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }
    .demo-btn-sky:hover { box-shadow: var(--neon-glow); transform: translateY(-1px); }
    .demo-btn-back {
      color: var(--text-muted);
      font-size: 13px;
      font-weight: 600;
      padding: 4px 8px;
      border-radius: 6px;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .demo-btn-back:hover { color: #fff; border-color: var(--neon-cyan); }

    /* Salon Navbar */
    .beauty-nav {
      background: rgba(var(--sky-ink-rgb), 0.88);
      border-bottom: 1px solid rgba(var(--cyan-rgb), 0.12);
      backdrop-filter: blur(16px);
      padding: 16px 24px;
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
    .brand-gem {
      width: 58px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex: 0 0 auto;
      filter: drop-shadow(0 3px 10px rgba(var(--rose-rgb), 0.28));
    }
    .brand-gem svg { width: 100%; height: auto; display: block; }
    .brand-text {
      font-family: var(--font-display);
      font-size: 23px;
      font-weight: 600;
      letter-spacing: 0.2px;
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      line-height: 1.1;
    }
    .brand-text span {
      font-size: 12px;
      letter-spacing: 2px;
      color: var(--neon-cyan);
      font-weight: 600;
      text-transform: uppercase;
    }
    .nav-links {
      display: flex;
      gap: 24px;
    }
    .nav-link {
      font-size: 14px;
      font-weight: 500;
      color: var(--text-muted);
      transition: color 0.2s;
    }
    .nav-link:hover { color: var(--neon-cyan); }
    .nav-toggle {
      display: none;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 4px;
      width: 40px;
      height: 38px;
      border-radius: 10px;
      border: 1px solid var(--sky-border);
      background: rgba(255, 255, 255, 0.04);
      cursor: pointer;
    }
    .nav-toggle span {
      display: block;
      width: 18px;
      height: 2px;
      border-radius: 2px;
      background: var(--neon-cyan);
      transition: transform .2s, opacity .2s;
    }
    .nav-toggle[aria-expanded="true"] span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
    .nav-toggle[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
    .nav-toggle[aria-expanded="true"] span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

    /* Yuxarıdakı qısa bölmə sıralaması — uzun səhifəni yormadan gezinir. */
    .section-index {
      max-width: 1240px;
      margin: 0 auto;
      padding: 0 24px 16px;
      display: flex;
      align-items: center;
      gap: 8px;
      flex-wrap: wrap;
    }
    .section-label {
      font-size: 12px;
      letter-spacing: 1.4px;
      text-transform: uppercase;
      color: var(--neon-cyan);
      font-weight: 700;
      margin-right: 4px;
    }
    .section-index a {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--text-muted);
      text-decoration: none;
      padding: 7px 12px;
      border-radius: 999px;
      border: 1px solid var(--sky-border);
      background: rgba(255, 255, 255, 0.03);
      transition: color .2s, border-color .2s, background .2s;
    }
    .section-index a b { font-size: 12px; color: var(--beauty-rose); }
    .section-index a:hover {
      color: #fff;
      border-color: rgba(var(--cyan-rgb), .45);
      background: rgba(var(--cyan-rgb), .08);
    }
    .reviews-slogan {
      font-size: 15px;
      font-weight: 600;
      color: var(--neon-cyan);
      margin: -6px 0 16px;
    }

    /* Hero Section */
    .beauty-hero {
      max-width: 1240px;
      margin: 0 auto;
      padding: 70px 24px 50px;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 40px;
      align-items: center;
    }
    .hero-tag {
      display: inline-flex;
      align-items: center;
      gap: 9px;
      font-size: 12.5px;
      font-weight: 600;
      letter-spacing: 0.14em;
      color: var(--text-muted);
      padding: 0;
      margin-bottom: 18px;
      text-transform: uppercase;
    }
    .hero-tag::before {
      content: "";
      width: 26px;
      height: 1px;
      background: var(--beauty-rose);
      display: inline-block;
      flex: 0 0 auto;
    }
    .hero-h1 {
      font-family: var(--font-display);
      font-size: clamp(34px, 4.6vw, 56px);
      line-height: 1.14;
      font-weight: 600;
      letter-spacing: -0.012em;
      color: var(--text-main);
      margin-bottom: 18px;
      text-wrap: balance;
    }
    .hero-h1 .glow-cyan {
      color: var(--beauty-rose);
      font-style: italic;
      text-shadow: none;
    }
    .hero-desc {
      color: var(--text-muted);
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 28px;
      max-width: 520px;
    }
    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 16px;
      align-items: center;
      margin-bottom: 36px;
    }
    .btn-hero-book {
      background: linear-gradient(135deg, var(--beauty-rose) 0%, var(--rose-deep) 100%);
      color: #fff;
      font-weight: 700;
      font-size: 15px;
      padding: 14px 28px;
      border-radius: 10px;
      border: none;
      box-shadow: var(--rose-glow);
      transition: all 0.25s;
      cursor: pointer;
      font-family: var(--font-body);
    }
    .btn-hero-book:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 30px rgba(var(--rose-rgb), 0.42);
    }
    .btn-hero-prices {
      background: rgba(var(--cyan-rgb), 0.08);
      border: 1px solid var(--sky-border);
      color: var(--neon-cyan);
      font-weight: 700;
      font-size: 15px;
      padding: 14px 24px;
      border-radius: 10px;
      transition: all 0.25s;
    }
    .btn-hero-prices:hover {
      background: rgba(var(--cyan-rgb), 0.15);
      border-color: var(--neon-cyan);
    }
    .stats-row {
      display: flex;
      gap: 32px;
    }
    .stat-item {
      display: flex;
      flex-direction: column;
    }
    .stat-num {
      font-family: var(--font-display);
      font-size: 27px;
      font-weight: 600;
      color: var(--neon-cyan);
      line-height: 1.1;
    }
    .stat-label {
      font-size: 13px;
      color: var(--text-muted);
    }

    /* Hero Visual Card */
    .hero-visual-card {
      background: linear-gradient(145deg, rgba(var(--sky-surface-rgb), 0.85), rgba(var(--sky-ink-rgb), 0.95));
      border: 1px solid var(--sky-border);
      border-radius: 24px;
      padding: 30px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.6), inset 0 0 25px rgba(var(--rose-rgb),0.1);
      position: relative;
    }
    .hero-photo {
      height: 290px;
      border-radius: 16px;
      overflow: hidden;
      margin: 4px 0 18px;
      position: relative;
      background: rgba(var(--sky-surface-rgb), 0.5);
    }
    .hero-photo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .hero-badge-card {
      background: rgba(var(--sky-ink-rgb), 0.9);
      border: 1px solid rgba(var(--cyan-rgb),0.15);
      border-radius: 14px;
      padding: 16px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    /* Hero: günün / həftənin təklifi (panel idarə edir) */
    .hero-badge-card.is-offer {
      flex-direction: column;
      align-items: stretch;
      gap: 14px;
      padding: 18px 20px;
      border-color: rgba(var(--rose-rgb), 0.35);
      background: linear-gradient(135deg, rgba(var(--rose-rgb), 0.12), rgba(var(--sky-ink-rgb), 0.95));
    }
    .hero-offer-main {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .hero-offer-flag {
      font-size: 12px;
      font-weight: 800;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--beauty-rose);
    }
    .hero-offer-tags {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 6px 10px;
    }
    .hero-offer-aud {
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.04em;
      color: var(--neon-cyan);
      border: 1px solid rgba(var(--cyan-rgb), 0.35);
      background: rgba(var(--cyan-rgb), 0.1);
      border-radius: 999px;
      padding: 2px 8px;
    }
    .hero-offer-note {
      font-size: 13px;
      line-height: 1.5;
      color: var(--text-muted);
    }
    .hero-offer-name {
      font-family: var(--font-display);
      font-size: 21px;
      font-weight: 600;
      line-height: 1.25;
      color: var(--text-main);
    }
    .hero-offer-meta {
      font-size: 12.5px;
      color: var(--text-muted);
    }
    .hero-offer-price-row {
      display: flex;
      align-items: baseline;
      flex-wrap: wrap;
      gap: 9px;
      margin-top: 4px;
    }
    .hero-offer-price {
      font-size: 25px;
      font-weight: 800;
      line-height: 1;
      color: var(--beauty-rose);
    }
    .hero-offer-old {
      font-size: 14px;
      color: var(--text-muted);
      text-decoration: line-through;
    }
    .hero-offer-save {
      font-size: 12px;
      font-weight: 800;
      color: #fff;
      background: var(--beauty-rose);
      border-radius: 999px;
      padding: 2px 8px;
    }
    /* Services Section */
    .services-section {
      max-width: 1240px;
      margin: 30px auto 80px;
      padding: 0 24px;
    }
    .section-head {
      text-align: left;
      margin-bottom: 34px;
      max-width: 660px;
    }
    .section-head h2 {
      font-family: var(--font-display);
      font-size: clamp(26px, 3vw, 34px);
      font-weight: 600;
      letter-spacing: -0.01em;
      color: var(--text-main);
      margin-bottom: 10px;
      text-wrap: balance;
    }
    .section-head h2::after {
      content: "";
      display: block;
      width: 44px;
      height: 2px;
      margin-top: 13px;
      border-radius: 2px;
      background: var(--beauty-rose);
    }
    .section-head p {
      color: var(--text-muted);
      font-size: 15.5px;
      line-height: 1.72;
      max-width: 580px;
      text-wrap: pretty;
    }

    /* Tabs */
    .service-tabs {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      gap: 10px;
      margin-bottom: 34px;
    }
    .tab-btn {
      background: rgba(var(--sky-surface-rgb), 0.7);
      border: 1px solid rgba(var(--cyan-rgb), 0.15);
      color: var(--text-muted);
      padding: 9px 20px;
      border-radius: 30px;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.25s ease;
    }
    .tab-btn:hover, .tab-btn.active {
      background: var(--neon-cyan);
      color: var(--on-accent);
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(var(--cyan-rgb), 0.4);
    }

    /* Services Grid */
    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(min(280px, 100%), 1fr));
      gap: 26px;
    }
    .service-card {
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      padding: 16px;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .service-card:hover {
      transform: translateY(-6px);
      border-color: var(--beauty-rose);
      box-shadow: 0 15px 35px rgba(0,0,0,0.5), 0 0 20px rgba(var(--rose-rgb),0.25);
    }
    .serv-img-box {
      height: 180px;
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 14px;
      position: relative;
      background: rgba(var(--sky-surface-rgb), 0.6);
    }
    .serv-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
      display: block;
    }
    .service-card:hover .serv-img-box img { transform: scale(1.06); }
    .serv-off {
      position: absolute;
      top: 10px;
      right: 10px;
      background: var(--beauty-rose);
      color: #fff;
      font-size: 12px;
      font-weight: 800;
      padding: 4px 9px;
      border-radius: 20px;
      letter-spacing: .02em;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .35);
    }
    .serv-price-wrap { display: flex; align-items: baseline; gap: 7px; flex-wrap: wrap; justify-content: flex-end; }
    .serv-old {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-muted);
      text-decoration: line-through;
      text-decoration-thickness: 1.5px;
    }
    .service-top-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 12px;
    }
    .serv-dur {
      font-size: 13px;
      color: var(--neon-cyan);
      background: rgba(var(--cyan-rgb),0.1);
      padding: 3px 10px;
      border-radius: 20px;
      font-weight: 600;
    }
    .serv-title {
      font-family: var(--font-display);
      font-size: 20px;
      font-weight: 600;
      letter-spacing: -0.005em;
      color: var(--text-main);
      text-wrap: balance;
      margin-bottom: 8px;
      line-height: 1.3;
    }
    .serv-desc {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.65;
      margin-bottom: 16px;
      flex: 1;
    }
    .serv-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
      padding-top: 14px;
      border-top: 1px solid rgba(var(--cyan-rgb),0.1);
    }
    .serv-price {
      font-size: 17px;
      font-weight: 800;
      color: var(--beauty-rose);
    }
    /* Gallery — redaksiya üslubunda, cansız şablon görünüşü yox */
    .gallery-section { max-width: 1240px; margin: 0 auto 88px; padding: 0 24px; }
    .gallery-section .section-head { margin-bottom: 28px; }
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(4, minmax(0, 1fr));
      grid-auto-flow: dense;
      gap: 16px;
    }
    .gallery-card {
      position: relative;
      margin: 0;
      min-height: 220px;
      overflow: hidden;
      border-radius: 16px;
      background: var(--sky-card);
      border: 1px solid rgba(var(--rose-rgb), .14);
      box-shadow: 0 16px 38px rgba(0, 0, 0, .14);
    }
    .gallery-card:nth-child(1) { grid-column: span 2; grid-row: span 2; }
    .gallery-card:nth-child(4n+4),
    .gallery-card.is-video { grid-column: span 2; }
    .gallery-trigger {
      position: absolute; inset: 0; display: block; width: 100%; height: 100%;
      padding: 0; border: 0; background: none; cursor: zoom-in; color: inherit;
    }
    .gallery-card img,
    .gallery-card video {
      width: 100%; height: 100%; object-fit: cover; display: block;
      transition: transform .7s cubic-bezier(.2, .7, .2, 1);
    }
    .gallery-card:hover img,
    .gallery-card:hover video { transform: scale(1.05); }
    .gallery-card::after {
      content: ""; position: absolute; inset: 0; pointer-events: none;
      background: linear-gradient(180deg, rgba(8, 7, 12, .06) 38%, rgba(8, 7, 12, .72) 100%);
    }
    .gallery-tag,
    .gallery-duration {
      position: absolute; top: 14px; z-index: 2; pointer-events: none;
      display: inline-flex; align-items: center; gap: 7px;
      border-radius: 999px; padding: 6px 11px;
      font-size: 10px; font-weight: 800; letter-spacing: .14em;
      color: #fff; background: rgba(12, 11, 16, .58);
      border: 1px solid rgba(255, 255, 255, .2);
      -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);
    }
    .gallery-tag { left: 14px; }
    .gallery-duration { right: 14px; letter-spacing: .06em; font-size: 11px; }
    .gallery-play {
      position: absolute; z-index: 2; left: 50%; top: 50%;
      width: 54px; height: 54px; border-radius: 50%;
      display: grid; place-items: center; pointer-events: none;
      background: rgba(255, 255, 255, .94); color: #17131a;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
      transform: translate(-50%, -50%);
      transition: transform .35s ease, background .35s ease, color .35s ease;
    }
    .gallery-play svg { width: 18px; height: 18px; fill: currentColor; margin-left: 3px; }
    .gallery-card:hover .gallery-play {
      transform: translate(-50%, -50%) scale(1.09);
      background: var(--beauty-rose); color: #fff;
    }
    .gallery-caption {
      position: absolute; z-index: 2; left: 0; right: 0; bottom: 0;
      display: flex; align-items: flex-end; justify-content: space-between; gap: 16px;
      padding: 20px 18px 16px; pointer-events: none;
    }
    .gallery-caption strong {
      font-family: var(--font-heading); font-size: 15px; font-weight: 600;
      line-height: 1.3; color: #fff; text-shadow: 0 2px 12px rgba(0, 0, 0, .45);
      text-wrap: pretty;
    }
    .gallery-card:nth-child(1) .gallery-caption strong { font-size: 20px; }
    .gallery-view {
      margin-left: auto; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;
      font-size: 10.5px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase;
      color: rgba(255, 255, 255, .9);
    }
    .gallery-view svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 1.8; }
    .gallery-empty {
      text-align: center;
      color: var(--text-muted);
      font-size: 15px;
      border: 1px dashed var(--sky-border);
      border-radius: 14px;
      padding: 34px 20px;
      background: rgba(0, 0, 0, .18);
    }
    /* Yalnız sahibə görünən yükləmə bölməsi */
    .gallery-admin {
      margin: 0 0 24px;
      padding: 18px 20px 20px;
      border-radius: 16px;
      border: 1px solid rgba(var(--rose-rgb), .28);
      background: linear-gradient(135deg, rgba(var(--rose-rgb), .09), rgba(var(--cyan-rgb), .05));
    }
    .ga-head { display: flex; align-items: center; flex-wrap: wrap; gap: 10px 14px; margin-bottom: 16px; }
    .ga-badge {
      font-size: 10px; font-weight: 800; letter-spacing: .14em;
      padding: 5px 10px; border-radius: 999px;
      color: var(--beauty-rose); border: 1px solid rgba(var(--rose-rgb), .45);
      background: rgba(var(--rose-rgb), .1);
    }
    .ga-head h3 { margin: 0; font-family: var(--font-heading); font-size: 17px; font-weight: 600; color: var(--text-main); }
    .ga-head p { margin: 0; flex: 1 1 320px; font-size: 12.5px; line-height: 1.6; color: var(--text-muted); }
    .ga-panel-link { margin-left: auto; font-size: 12px; font-weight: 700; color: var(--beauty-rose); white-space: nowrap; }
    .ga-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
    .ga-form {
      display: flex; flex-direction: column; gap: 9px;
      padding: 14px; border-radius: 12px;
      border: 1px solid var(--sky-border); background: rgba(var(--sky-surface-rgb), .55);
    }
    .ga-form label { font-size: 12.5px; font-weight: 700; color: var(--text-main); }
    .ga-form input[type=text] {
      width: 100%; padding: 9px 11px; border-radius: 9px;
      border: 1px solid var(--sky-border); background: var(--sky-card); color: var(--text-main); font-size: 13px;
    }
    .ga-form input[type=file] { width: 100%; font-size: 12px; color: var(--text-muted); }
    .ga-hint { font-size: 11.5px; color: var(--text-muted); min-height: 16px; }
    .ga-hint.is-error { color: #f87171; }
    .ga-submit {
      align-self: flex-start; padding: 9px 16px; border: 0; border-radius: 9px;
      background: var(--beauty-rose); color: #fff; font-size: 12.5px; font-weight: 700; cursor: pointer;
    }
    .gallery-flash {
      margin-bottom: 14px; padding: 11px 14px; border-radius: 11px; font-size: 13px;
      border: 1px solid rgba(var(--rose-rgb), .35); background: rgba(var(--rose-rgb), .1); color: var(--text-main);
    }
    .gallery-flash.ok { border-color: rgba(34, 197, 94, .42); background: rgba(34, 197, 94, .12); }
    .gallery-flash.err { border-color: rgba(248, 113, 113, .45); background: rgba(248, 113, 113, .12); }
    @media (max-width: 620px) {
      .ga-grid { grid-template-columns: 1fr; }
      .ga-head p { flex-basis: 100%; }
      .ga-panel-link { margin-left: 0; }
    }
    /* Qalereya üçün yüngül lightbox */
    .gallery-lightbox {
      position: fixed; inset: 0; z-index: 4000; display: none;
      align-items: center; justify-content: center; padding: 24px;
      background: rgba(8, 7, 12, .94);
      -webkit-backdrop-filter: blur(12px); backdrop-filter: blur(12px);
    }
    .gallery-lightbox.is-open { display: flex; }
    body.gl-locked { overflow: hidden; }
    .gl-stage { display: flex; align-items: center; justify-content: center; width: min(1120px, 100%); }
    .gl-stage img,
    .gl-stage video {
      max-width: 100%; max-height: 82vh; width: auto; height: auto;
      border-radius: 12px; box-shadow: 0 24px 80px rgba(0, 0, 0, .6); background: #000;
    }
    .gl-btn {
      position: absolute; z-index: 2; display: grid; place-items: center;
      width: 44px; height: 44px; border-radius: 50%; cursor: pointer;
      border: 1px solid rgba(255, 255, 255, .22); background: rgba(255, 255, 255, .08);
      color: #fff; font-size: 24px; line-height: 1;
      transition: background .25s ease, border-color .25s ease;
    }
    .gl-btn:hover { background: var(--beauty-rose); border-color: var(--beauty-rose); }
    .gl-close { top: 20px; right: 24px; font-size: 21px; }
    .gl-prev { left: 24px; top: 50%; transform: translateY(-50%); }
    .gl-next { right: 24px; top: 50%; transform: translateY(-50%); }
    .gl-foot {
      position: absolute; left: 0; right: 0; bottom: 18px; z-index: 2;
      display: flex; justify-content: center; align-items: center; gap: 14px;
      color: rgba(255, 255, 255, .78); font-size: 12px; letter-spacing: .06em;
      padding: 0 80px; text-align: center;
    }
    .gl-count { font-variant-numeric: tabular-nums; color: var(--beauty-rose); font-weight: 800; }
    @media (max-width: 960px) {
      .gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
      .gallery-card:nth-child(1) { grid-column: span 2; grid-row: auto; min-height: 260px; }
      .gallery-card:nth-child(4n+4) { grid-column: span 1; }
    }
    @media (max-width: 560px) {
      .gallery-section { padding: 0 16px; }
      .gallery-grid { grid-template-columns: 1fr; gap: 13px; }
      .gallery-card,
      .gallery-card:nth-child(1),
      .gallery-card:nth-child(4n+4),
      .gallery-card.is-video { grid-column: span 1; grid-row: auto; min-height: 230px; }
      .gallery-caption strong,
      .gallery-card:nth-child(1) .gallery-caption strong { font-size: 15px; }
    }
    @media (max-width: 620px) {
      .gallery-lightbox { padding: 14px; }
      .gl-prev { left: 10px; } .gl-next { right: 10px; }
      .gl-stage img, .gl-stage video { max-height: 76vh; }
      .gl-foot { bottom: 10px; padding: 0 56px; }
    }

    /* Stylists Section */
    .stylists-section {
      max-width: 1240px;
      margin: 0 auto 80px;
      padding: 0 24px;
    }
    .stylists-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 24px;
    }
    .stylist-card {
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      padding: 24px;
      text-align: center;
      transition: all 0.3s;
    }
    .stylist-card:hover {
      border-color: var(--beauty-rose);
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    }
    .stylist-avatar-round {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      border: 2px solid var(--beauty-rose);
      margin: 0 auto 16px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(var(--rose-rgb),0.3);
    }
    .stylist-avatar-round img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }
    .stylist-name {
      font-family: var(--font-display);
      font-size: 19px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 4px;
    }
    .stylist-spec {
      font-size: 13px;
      color: var(--neon-cyan);
      font-weight: 600;
      margin-bottom: 12px;
    }
    .stylist-exp {
      font-size: 13px;
      color: var(--text-muted);
      background: rgba(0,0,0,0.3);
      padding: 4px 12px;
      border-radius: 20px;
      display: inline-block;
    }
    .stylist-att {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 10px;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 12.5px;
      font-weight: 700;
      letter-spacing: .02em;
    }
    .stylist-att i {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: currentColor;
      display: inline-block;
    }
    .stylist-att.is-work {
      color: #22c55e;
      background: rgba(34,197,94,.12);
      border: 1px solid rgba(34,197,94,.35);
    }
    .stylist-att.is-off {
      color: #f87171;
      background: rgba(248,113,113,.12);
      border: 1px solid rgba(248,113,113,.35);
    }
    .stylist-owner {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      margin: 0 0 10px;
      padding: 3px 11px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 800;
      letter-spacing: .05em;
      color: #12261b;
      background: linear-gradient(135deg, var(--beauty-gold), #fff6cf);
    }
    .stylist-bio {
      font-size: 13.5px;
      line-height: 1.6;
      color: var(--text-muted);
      margin-top: 10px;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* Reviews Section */
    .reviews-section {
      max-width: 1240px;
      margin: 0 auto 80px;
      padding: 0 24px;
    }
    .reviews-top {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      gap: 18px;
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      padding: 22px 24px;
      margin-bottom: 24px;
    }
    .rev-score { display: flex; align-items: center; gap: 18px; }
    .rev-avg {
      font-family: var(--font-display);
      font-size: 46px;
      font-weight: 600;
      line-height: 1;
      color: var(--text-main);
    }
    .rev-stars {
      color: #fbbf24;
      font-size: 17px;
      letter-spacing: 2px;
      line-height: 1.35;
    }
    .rev-meta { font-size: 13px; color: var(--text-muted); margin-top: 3px; }
    .rev-write {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--beauty-rose), var(--rose-soft));
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 12px 22px;
      font-weight: 800;
      font-size: 14px;
      box-shadow: var(--rose-glow);
      transition: transform .25s;
    }
    .rev-write:hover { transform: translateY(-2px); }
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(min(280px, 100%), 1fr));
      gap: 20px;
    }
    .rev-card {
      background: var(--sky-card);
      border: 1px solid var(--sky-border);
      border-radius: 18px;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .rev-head { display: flex; align-items: center; gap: 12px; }
    .rev-ava {
      width: 42px;
      height: 42px;
      flex: 0 0 42px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      font-weight: 800;
      font-size: 16px;
      color: var(--beauty-rose);
      background: rgba(var(--rose-rgb), .16);
      border: 1px solid rgba(var(--rose-rgb), .35);
    }
    .rev-name { font-weight: 700; font-size: 14.5px; color: #fff; }
    .rev-date { font-size: 12px; color: var(--text-muted); }
    .rev-stars-sm { color: #fbbf24; font-size: 14px; letter-spacing: 1px; }
    .rev-text { font-size: 14px; line-height: 1.65; color: var(--text-main); opacity: .92; }
    .rev-svc { font-size: 12.5px; color: var(--text-muted); }
    .rev-verified {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 12px;
      font-weight: 700;
      color: #22c55e;
    }
    .rev-reply {
      background: rgba(0, 0, 0, .25);
      border-left: 2px solid var(--beauty-rose);
      border-radius: 10px;
      padding: 9px 12px;
      font-size: 13px;
      line-height: 1.6;
      color: var(--text-muted);
    }
    .rev-reply b {
      display: block;
      font-size: 12px;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: .06em;
      margin-bottom: 2px;
    }
    .rev-comment { border-left-color: var(--neon-cyan); }
    .rev-comment-btn {
      align-self: flex-start;
      margin-top: 2px;
      background: rgba(var(--cyan-rgb), .10);
      border: 1px solid rgba(var(--cyan-rgb), .35);
      color: var(--neon-cyan);
      border-radius: 10px;
      padding: 8px 12px;
      font-size: 12.5px;
      font-weight: 700;
      cursor: pointer;
    }
    .rev-comment-btn:hover { background: rgba(var(--cyan-rgb), .18); }
    .reviews-empty {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 14px;
      background: var(--sky-card);
      border: 1px dashed var(--sky-border);
      border-radius: 18px;
      padding: 26px;
      text-align: center;
      color: var(--text-muted);
      font-size: 14px;
    }
    @media (max-width: 600px) {
      .reviews-top { flex-direction: column; align-items: flex-start; }
      .rev-avg { font-size: 38px; }
      .rev-write { width: 100%; justify-content: center; }
    }

    /* Toast */
    .toast-box {
      position: fixed;
      bottom: 90px;
      left: 50%;
      transform: translateX(-50%) translateY(50px);
      background: rgba(var(--sky-surface-rgb), 0.95);
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
    .toast-box.show { transform: translateX(-50%) translateY(0); opacity: 1; visibility: visible; }

    /* Footer */
    .beauty-footer {
      background: var(--sky-footer);
      border-top: 1px solid var(--sky-border);
      padding: 50px 24px 30px;
      text-align: center;
    }
    .footer-wrap { max-width: 680px; margin: 0 auto; }
    .footer-contact {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px 20px;
      font-size: 14px;
      color: var(--text-muted);
      margin-bottom: 14px;
    }
    .footer-contact a { color: var(--text-muted); }
    .footer-contact a:hover { color: var(--beauty-rose); }
    .footer-socials {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin-bottom: 18px;
    }
    .footer-socials a {
      width: 42px;
      height: 42px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      border: 1px solid var(--sky-border);
      background: rgba(255, 255, 255, 0.03);
      color: var(--text-muted);
      transition: transform .2s ease, color .2s ease, border-color .2s ease, background .2s ease;
    }
    .footer-socials a svg { width: 19px; height: 19px; display: block; }
    .footer-socials a:hover {
      color: #fff;
      border-color: var(--beauty-rose);
      background: rgba(var(--rose-rgb), 0.14);
      transform: translateY(-2px);
    }
    .footer-socials .wa-link { color: #25d366; border-color: rgba(37, 211, 102, 0.45); }
    .footer-socials .wa-link:hover { background: rgba(37, 211, 102, 0.16); border-color: #25d366; color: #25d366; }
    .footer-title {
      font-family: var(--font-display);
      font-size: 26px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 10px;
    }
    .badge-sky {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 6px 14px;
      background: rgba(var(--cyan-rgb), 0.08);
      border: 1px solid var(--sky-border);
      border-radius: 20px;
      color: var(--neon-cyan);
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 16px;
    }

    /* Paylaşılan demo-kit komponentləri — yalnız bu demo üçün oxunaqlı ölçülər */
    body[data-dk-demo="beauty"] .dk-sheet__eyebrow { font-size: 12px; }
    body[data-dk-demo="beauty"] .dk-sheet__sub { font-size: 14px; line-height: 1.6; }
    body[data-dk-demo="beauty"] .dk-label { font-size: 13px; letter-spacing: .03em; }
    body[data-dk-demo="beauty"] .dk-hint,
    body[data-dk-demo="beauty"] .dk-err { font-size: 12.5px; line-height: 1.5; }
    @media (max-width: 420px) {
      .demo-bar { padding: 8px 12px; }
    }

    @media (max-width: 900px) {
      .beauty-hero { grid-template-columns: 1fr; text-align: center; padding-top: 40px; }
      .hero-desc { margin: 0 auto 24px; }
      .hero-actions { justify-content: center; }
      .stats-row { justify-content: center; }
      .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 16px;
        right: 16px;
        flex-direction: column;
        gap: 0;
        padding: 8px;
        border-radius: 14px;
        border: 1px solid var(--sky-border);
        background: rgba(var(--sky-ink-rgb), 0.98);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.35);
      }
      .nav-links.is-open { display: flex; }
      .nav-links .nav-link { padding: 11px 12px; border-radius: 8px; }
      .nav-links .nav-link:hover { background: rgba(var(--cyan-rgb), 0.08); }
      .nav-toggle { display: inline-flex; }
    }
    @media (max-width: 640px) {
      .section-index { flex-wrap: nowrap; overflow-x: auto; padding-bottom: 12px; scrollbar-width: none; }
      .section-index::-webkit-scrollbar { display: none; }
      .section-index a { white-space: nowrap; }
      .section-label { display: none; }
    }
    @media (max-width: 380px) {
      .beauty-nav { padding: 14px 16px; }
      .nav-wrap { gap: 8px; }
      .brand-text { font-size: 20px; }
      .brand-gem { width: 46px; height: 36px; }
    }

    /* Bron təsdiqi — yığcam xülasə (müştəriyə WhatsApp düyməsi yoxdur) */
    .bs-backdrop {
      position: fixed; inset: 0; z-index: 3000; display: none;
      align-items: center; justify-content: center; padding: 20px;
      background: rgba(0, 0, 0, .7); backdrop-filter: blur(6px);
    }
    .bs-backdrop.is-open { display: flex; }
    .bs-card {
      width: min(460px, 100%); max-height: 90vh; overflow-y: auto;
      border: 1px solid rgba(var(--rose-rgb), .35); border-radius: 18px;
      background: var(--dk-panel); color: var(--text-main);
      padding: 24px; box-shadow: 0 24px 70px rgba(0, 0, 0, .5);
    }
    .bs-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
    .bs-title { font-family: var(--font-display); font-size: 23px; font-weight: 600; margin: 0 0 6px; }
    .bs-sub { color: var(--text-muted); font-size: 13.5px; line-height: 1.6; margin: 0 0 16px; }
    .bs-x { flex: 0 0 auto; border: 0; background: transparent; color: var(--text-muted); font-size: 18px; cursor: pointer; }
    .bs-code { text-align: center; font-size: 30px; font-weight: 800; letter-spacing: .08em; color: var(--neon-cyan); }
    .bs-code-lbl { text-align: center; font-size: 12px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 14px; }
    .bs-row { display: flex; justify-content: space-between; gap: 12px; padding: 9px 0; border-top: 1px solid rgba(255, 255, 255, .08); font-size: 13.5px; }
    .bs-row span:first-child { color: var(--text-muted); }
    .bs-row span:last-child { text-align: right; font-weight: 700; }
    .bs-row.is-deposit span:last-child { color: var(--beauty-rose); }
    .bs-note { font-size: 12.5px; line-height: 1.6; color: var(--text-muted); margin: 14px 0 0; }
    .bs-actions { display: flex; justify-content: flex-end; margin-top: 18px; }
    .bs-close {
      border: 1px solid rgba(var(--rose-rgb), .5); background: rgba(var(--rose-rgb), .18);
      color: var(--text-main); font-size: 13px; font-weight: 700;
      padding: 10px 20px; border-radius: 10px; cursor: pointer;
    }
    .bs-close:hover { background: rgba(var(--rose-rgb), .3); }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
</head>
<body data-dk-demo="beauty" data-theme="<?= htmlspecialchars($themeKey) ?>" data-dk-accent="<?= htmlspecialchars($theme['primary']) ?>" data-dk-phone="<?= htmlspecialchars($waPhone) ?>">
  <script src="assets/demo-kit.js"></script>
  <script>
    (function () {
      var accents = <?= json_encode(array_map(fn($th) => $th['primary'], $themes)) ?>;
      function hexRgb(hex) {
        hex = String(hex || '').replace('#', '');
        if (hex.length === 3) hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        var n = parseInt(hex, 16);
        if (isNaN(n) || hex.length !== 6) return '255, 42, 133';
        return [(n >> 16) & 255, (n >> 8) & 255, n & 255].join(', ');
      }
      function applyAccent(key) {
        var root = document.documentElement;
        if (accents[key]) {
          root.style.setProperty('--dk-accent', accents[key]);
          root.style.setProperty('--dk-accent-rgb', hexRgb(accents[key]));
          document.body.setAttribute('data-dk-accent', accents[key]);
        }
      }
      try {
        var saved = localStorage.getItem('beauty-theme');
        var allowed = <?= json_encode(array_keys($themes)) ?>;
        if (saved && allowed.indexOf(saved) > -1) {
          document.body.dataset.theme = saved;
        }
      } catch (e) {}
      applyAccent(document.body.dataset.theme);

      function bindThemeDots() {
        document.querySelectorAll('.theme-dot').forEach(function (dot) {
          if (dot.dataset.themeKey === document.body.dataset.theme) dot.classList.add('active');
          dot.addEventListener('click', function () {
            var key = dot.dataset.themeKey;
            document.body.dataset.theme = key;
            applyAccent(key);
            document.querySelectorAll('.theme-dot').forEach(function (d) { d.classList.toggle('active', d === dot); });
            try { localStorage.setItem('beauty-theme', key); } catch (e) {}
          });
        });
      }
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', bindThemeDots);
      } else {
        bindThemeDots();
      }
    })();
  </script>


  <!-- Top Demo Banner -->
  <div class="demo-bar">
    <div class="demo-bar-left">
      <span class="demo-badge">SKYWEB DEMO</span>
      <span class="demo-text"><?= htmlspecialchars($t['demo_banner']) ?></span>
    </div>
    <div class="demo-bar-right">
      <div class="theme-dots" role="group" aria-label="Theme">
        <?php foreach ($themes as $tk => $th): ?>
          <button type="button" class="theme-dot<?= $tk === $themeKey ? ' active' : '' ?>"
                  style="--dot:<?= htmlspecialchars($th['primary']) ?>"
                  data-theme-key="<?= htmlspecialchars($tk) ?>"
                  title="<?= htmlspecialchars($th['label']) ?>"
                  aria-label="<?= htmlspecialchars($th['label']) ?>"></button>
        <?php endforeach; ?>
      </div>
      <a href="../../index.php?lang=<?= e($lang) ?>#contact" class="demo-btn-sky"><?= htmlspecialchars($t['order_site']) ?> →</a>
      <a href="../../index.php?lang=<?= e($lang) ?>" class="demo-btn-back">← <?= htmlspecialchars($t['back_to_sky']) ?></a>
    </div>
  </div>

  <!-- Salon Navbar -->
  <header class="beauty-nav">
    <div class="nav-wrap">
      <div class="brand-box">
        <div class="brand-gem" aria-hidden="true">
          <svg viewBox="0 0 142 96" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Skyweb">
            <defs>
              <linearGradient id="skyBeautyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" stop-color="var(--neon-cyan)" />
                <stop offset="100%" stop-color="var(--beauty-rose)" />
              </linearGradient>
              <filter id="skyBeautyGlow" x="-20%" y="-20%" width="140%" height="140%">
                <feGaussianBlur stdDeviation="3" result="blur" />
                <feMerge>
                  <feMergeNode in="blur" />
                  <feMergeNode in="SourceGraphic" />
                </feMerge>
              </filter>
            </defs>
            <path d="M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z" fill="url(#skyBeautyGrad)" />
            <g filter="url(#skyBeautyGlow)">
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
        <div class="brand-text">
          <?= htmlspecialchars($brand) ?>
          <span><?= htmlspecialchars($t['brand_sub']) ?></span>
        </div>
      </div>
      <nav class="nav-links" id="navLinks">
        <a href="#services" class="nav-link"><?= htmlspecialchars($t['nav_services']) ?></a>
        <a href="#gallery" class="nav-link"><?= htmlspecialchars($t['nav_gallery']) ?></a>
        <a href="#stylists" class="nav-link"><?= htmlspecialchars($t['nav_stylists']) ?></a>
      </nav>
      <button class="nav-toggle" id="navToggle" type="button" aria-label="<?= htmlspecialchars($t['nav_menu'] ?? 'Menu') ?>" aria-expanded="false" aria-controls="navLinks">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>

  <!-- Qısa bölmə sıralaması: uzun səhifəni yormadan gezinir -->
  <nav class="section-index" aria-label="<?= htmlspecialchars($t['section_index_label']) ?>">
    <span class="section-label"><?= htmlspecialchars($t['section_index_label']) ?></span>
    <a href="#services"><b>01</b> <?= htmlspecialchars($t['nav_services']) ?></a>
    <a href="#gallery"><b>02</b> <?= htmlspecialchars($t['nav_gallery']) ?></a>
    <a href="#stylists"><b>03</b> <?= htmlspecialchars($t['nav_stylists']) ?></a>
  </nav>

  <!-- Hero Section -->
  <section class="beauty-hero" id="home">
    <div>
      <span class="hero-tag"><?= htmlspecialchars($t['hero_tag']) ?></span>
      <h1 class="hero-h1">
        <?= htmlspecialchars($t['hero_title_1']) ?><br>
        <span class="glow-cyan"><?= htmlspecialchars($t['hero_title_2']) ?></span>
      </h1>
      <p class="hero-desc"><?= htmlspecialchars($t['hero_desc']) ?></p>
      <div class="hero-actions">
        <button class="btn-hero-book" type="button" onclick="openBookingModal('General')">
          📅 <?= htmlspecialchars($t['hero_btn_book']) ?> →
        </button>
        <a href="#services" class="btn-hero-prices">
          <?= htmlspecialchars($t['hero_btn_prices']) ?> ↓
        </a>
      </div>
      <div class="stats-row">
        <div class="stat-item">
          <span class="stat-num"><?= htmlspecialchars($t['stat_1_n']) ?></span>
          <span class="stat-label"><?= htmlspecialchars($t['stat_1_t']) ?></span>
        </div>
        <div class="stat-item">
          <span class="stat-num"><?= htmlspecialchars($t['stat_2_n']) ?></span>
          <span class="stat-label"><?= htmlspecialchars($t['stat_2_t']) ?></span>
        </div>
        <div class="stat-item">
          <span class="stat-num"><?= htmlspecialchars($t['stat_3_n']) ?></span>
          <span class="stat-label"><?= htmlspecialchars($t['stat_3_t']) ?></span>
        </div>
      </div>
    </div>
    <div>
      <div class="hero-visual-card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:10px;">
          <span style="background:rgba(var(--rose-rgb),0.18); border:1px solid var(--beauty-rose); color:var(--beauty-rose); font-size:12px; font-weight:700; padding:4px 12px; border-radius:20px;"><?= htmlspecialchars($t['hero_card_badge']) ?></span>
          <span style="color:var(--neon-cyan); font-weight:700; font-size:13px; white-space:nowrap;"><?= $rSum['count'] > 0 ? '★ ' . number_format((float)$rSum['avg'], 1, '.', '') . ' · ' . htmlspecialchars(sprintf($t['reviews_count'], (int)$rSum['count'])) : '' ?></span>
        </div>
        <div class="hero-photo">
          <?php
            $heroImg = $offerOn && !empty($offerSvc['img'])
                ? (string)$offerSvc['img']
                : 'https://images.pexels.com/photos/3993443/pexels-photo-3993443.jpeg?auto=compress&cs=tinysrgb&w=900';
            $heroAlt = $offerOn
                ? (string)($offerSvc['title'][$lang] ?? $offerSvc['title']['az'])
                : 'Sky Beauty';
          ?>
          <img src="<?= htmlspecialchars($heroImg) ?>"
               alt="<?= htmlspecialchars($heroAlt) ?>" loading="eager" fetchpriority="high">
        </div>
        <?php if ($offerOn): ?>
        <div class="hero-badge-card is-offer">
          <div class="hero-offer-main">
            <div class="hero-offer-tags">
              <span class="hero-offer-flag"><?= htmlspecialchars($offerBadge) ?></span>
              <?php if ($offerCorp): ?>
                <span class="hero-offer-aud"><?= htmlspecialchars($t['offer_corporate']) ?></span>
              <?php endif; ?>
            </div>
            <div class="hero-offer-name"><?= htmlspecialchars($offerSvc['title'][$lang] ?? $offerSvc['title']['az']) ?></div>
            <?php if ($offerNote !== ''): ?>
              <p class="hero-offer-note"><?= htmlspecialchars($offerNote) ?></p>
            <?php endif; ?>
            <div class="hero-offer-price-row">
              <span class="hero-offer-price"><?= htmlspecialchars($money($offerPrice)) ?></span>
              <?php if ($offerOff > 0): ?>
                <span class="hero-offer-old"><?= htmlspecialchars($money($offerBase)) ?></span>
                <span class="hero-offer-save">−<?= (int)$offerOff ?>%</span>
              <?php endif; ?>
            </div>
            <div class="hero-offer-meta"><?= htmlspecialchars($offerWhen) ?> · <?= htmlspecialchars($fmt_dur($offerSvc['duration'])) ?></div>
          </div>
        </div>
        <?php else: ?>
        <div class="hero-badge-card">
          <div>
            <div style="font-size:13px; color:var(--text-muted);"><?= htmlspecialchars($t['hero_card_care']) ?></div>
            <div style="font-weight:700; color:#fff; font-size:16px;"><?= htmlspecialchars($t['hero_card_service']) ?></div>
          </div>
          <div style="font-size:14px; font-weight:800; color:var(--beauty-rose); white-space:nowrap;"><?= htmlspecialchars($t['hero_card_offer']) ?></div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Services & Pricing Menu -->
  <section class="services-section" id="services">
    <div class="section-head">
      <h2><?= htmlspecialchars($t['nav_services']) ?></h2>
      <p><?= htmlspecialchars($t['services_desc']) ?></p>
    </div>

    <!-- Filter Tabs -->
    <div class="service-tabs">
      <button class="tab-btn active" onclick="filterServices('all', this)"><?= htmlspecialchars($t['tab_all']) ?></button>
      <button class="tab-btn" onclick="filterServices('hair', this)"><?= htmlspecialchars($t['tab_hair']) ?></button>
      <button class="tab-btn" onclick="filterServices('nails', this)"><?= htmlspecialchars($t['tab_nails']) ?></button>
      <button class="tab-btn" onclick="filterServices('face', this)"><?= htmlspecialchars($t['tab_face']) ?></button>
      <button class="tab-btn" onclick="filterServices('makeup', this)"><?= htmlspecialchars($t['tab_makeup']) ?></button>
    </div>

    <!-- Services Grid -->
    <div class="services-grid" id="servicesGrid">
      <?php foreach ($services as $s): ?>
        <?php
          $title = $s['title'][$lang] ?? $s['title']['az'];
          $desc = $s['desc'][$lang] ?? $s['desc']['az'];
        ?>
        <div class="service-card" data-cat="<?= $s['cat'] ?>">
          <div class="serv-img-box">
            <img src="<?= htmlspecialchars($s['img']) ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
            <?php if (!empty($s['old_price']) && $s['old_price'] > $s['price']): ?>
              <span class="serv-off">−<?= (int)round((1 - $s['price'] / $s['old_price']) * 100) ?>%</span>
            <?php endif; ?>
          </div>
          <div class="service-top-row">
            <span class="serv-dur">⏱️ <?= htmlspecialchars($fmt_dur($s['duration'])) ?></span>
            <span class="serv-price-wrap">
              <span class="serv-price"><?= htmlspecialchars($money($s['price'])) ?></span>
              <?php if (!empty($s['old_price']) && $s['old_price'] > $s['price']): ?>
                <span class="serv-old"><?= htmlspecialchars($money($s['old_price'])) ?></span>
              <?php endif; ?>
            </span>
          </div>
          <h3 class="serv-title"><?= htmlspecialchars($title) ?></h3>
          <p class="serv-desc"><?= htmlspecialchars($desc) ?></p>

        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Gallery: masters' real work -->
  <section class="gallery-section" id="gallery">
    <div class="section-head">
      <h2><?= htmlspecialchars($t['gallery_title']) ?></h2>
      <p><?= htmlspecialchars($t['gallery_desc']) ?></p>
    </div>

    <?php foreach ($galleryFlash as $gf): ?>
      <div class="gallery-flash <?= ($gf['type'] ?? '') === 'ok' ? 'ok' : 'err' ?>"><?= htmlspecialchars((string)($gf['msg'] ?? '')) ?></div>
    <?php endforeach; ?>

    <?php if ($galleryAdmin): ?>
      <div class="gallery-admin" id="galleryUpload">
        <div class="ga-head">
          <span class="ga-badge">YALNIZ SAHİBƏ</span>
          <h3>Qalereyaya iş yüklə</h3>
          <p>Foto — JPG/PNG/WEBP, max <?= (int)$galleryLimits['photo_mb'] ?> MB. Video — MP4, max <?= (int)$galleryLimits['video_mb'] ?> MB və <?= (int)$galleryLimits['video_sec'] ?> saniyə. Hər fayla loqo watermark-ı vurulur.</p>
          <a class="ga-panel-link" href="beauty-panel.php?tab=gallery">Paneldə idarə et ↗</a>
        </div>
        <div class="ga-grid">
          <form class="ga-form" method="post" enctype="multipart/form-data" action="beauty-panel.php" data-demo-media="photo">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="upload_media">
            <input type="hidden" name="media_type" value="photo">
            <input type="hidden" name="return_to" value="gallery">
            <input type="hidden" name="return_lang" value="<?= htmlspecialchars($lang) ?>">
            <label for="gaPhoto">Şəkil seç</label>
            <input type="file" id="gaPhoto" name="media" accept="image/jpeg,image/png,image/webp" required>
            <input type="text" name="media_title" maxlength="80" placeholder="İşin adı (isteğe bağlı)">
            <span class="ga-hint">Max <?= (int)$galleryLimits['photo_mb'] ?> MB</span>
            <button class="ga-submit" type="submit">Şəkli əlavə et</button>
          </form>
          <form class="ga-form" method="post" enctype="multipart/form-data" action="beauty-panel.php" data-demo-media="video">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">
            <input type="hidden" name="action" value="upload_media">
            <input type="hidden" name="media_type" value="video">
            <input type="hidden" name="return_to" value="gallery">
            <input type="hidden" name="return_lang" value="<?= htmlspecialchars($lang) ?>">
            <label for="gaVideo">Video seç (MP4, max <?= (int)$galleryLimits['video_sec'] ?> s)</label>
            <input type="file" id="gaVideo" name="media" accept="video/mp4" required>
            <input type="text" name="media_title" maxlength="80" placeholder="Çəkilişin adı (isteğe bağlı)">
            <span class="ga-hint">Max <?= (int)$galleryLimits['video_mb'] ?> MB · <?= (int)$galleryLimits['video_sec'] ?> saniyə</span>
            <button class="ga-submit" type="submit">Videonu əlavə et</button>
          </form>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!$gallery_items): ?>
      <div class="gallery-empty">✨ <?= htmlspecialchars($t['gallery_empty']) ?></div>
    <?php else: ?>
      <div class="gallery-grid">
        <?php foreach ($gallery_items as $galleryIdx => $it): ?>
          <?php
            $isVideo  = $it['type'] === 'video';
            $src      = htmlspecialchars($mediaBase . $it['file'], ENT_QUOTES, 'UTF-8');
            $poster   = htmlspecialchars((string)$it['poster'], ENT_QUOTES, 'UTF-8');
            $label    = (string)$it['title'];
            $labelEsc = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
            $durText  = $it['duration'] !== null ? gmdate('i:s', (int)round($it['duration'])) : '';
          ?>
          <figure class="gallery-card<?= $isVideo ? ' is-video' : '' ?>">
            <button class="gallery-trigger" type="button"
                    data-gl-index="<?= (int)$galleryIdx ?>"
                    data-gl-src="<?= $src ?>"
                    data-gl-type="<?= $isVideo ? 'video' : 'photo' ?>"
                    data-gl-poster="<?= $isVideo ? $poster : '' ?>"
                    data-gl-title="<?= $labelEsc ?>"
                    aria-label="<?= $labelEsc ?> — <?= htmlspecialchars($t['gallery_view'], ENT_QUOTES, 'UTF-8') ?>">
              <?php if ($isVideo): ?>
                <?php if ($it['poster'] !== ''): ?>
                  <img src="<?= htmlspecialchars($mediaBase . $it['poster'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= $labelEsc ?>" loading="lazy">
                <?php else: ?>
                  <video src="<?= $src ?>" preload="metadata" playsinline muted></video>
                <?php endif; ?>
                <span class="gallery-play" aria-hidden="true">
                  <svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </span>
                <?php if ($durText !== ''): ?><span class="gallery-duration"><?= htmlspecialchars($durText) ?></span><?php endif; ?>
              <?php else: ?>
                <img src="<?= $src ?>" alt="<?= $labelEsc ?>" loading="lazy">
              <?php endif; ?>
              <span class="gallery-tag"><?= htmlspecialchars($isVideo ? $t['gallery_video'] : $t['gallery_photo']) ?></span>
              <span class="gallery-caption">
                <?php if ($label !== ''): ?><strong><?= $labelEsc ?></strong><?php endif; ?>
                <span class="gallery-view"><?= htmlspecialchars($t['gallery_view']) ?>
                  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M9 7h8v8"/></svg>
                </span>
              </span>
            </button>
          </figure>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <div class="gallery-lightbox" id="galleryLightbox" role="dialog" aria-modal="true"
       aria-label="<?= htmlspecialchars($t['gallery_title'], ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true">
    <button class="gl-btn gl-close" type="button" data-gl-close aria-label="Close">×</button>
    <button class="gl-btn gl-prev" type="button" data-gl-prev aria-label="Previous">‹</button>
    <div class="gl-stage">
      <img data-gl-image alt="" hidden>
      <video data-gl-video controls playsinline preload="metadata" hidden></video>
    </div>
    <button class="gl-btn gl-next" type="button" data-gl-next aria-label="Next">›</button>
    <div class="gl-foot">
      <span class="gl-count" data-gl-count></span>
      <span data-gl-caption></span>
    </div>
  </div>

  <!-- Stylists Team Section -->
  <section class="stylists-section" id="stylists">
    <div class="section-head">
      <h2><?= htmlspecialchars($t['stylists_title']) ?></h2>
      <p><?= htmlspecialchars($t['stylists_desc']) ?></p>
    </div>
    <div class="stylists-grid">
      <?php foreach ($stylists as $st): ?>
        <?php
          $role = $st['role'][$lang] ?? ($st['role']['az'] ?? '');
          $stState = bb_attendance_state($attAll, $todayKey, (string)$st['name']);
          $bio = $st['bio'][$lang] ?? ($st['bio']['az'] ?? '');
        ?>
        <div class="stylist-card">
          <div class="stylist-avatar-round">
            <img src="<?= htmlspecialchars($st['img']) ?>" alt="<?= htmlspecialchars($st['name']) ?>" loading="lazy">
          </div>
          <?php if (!empty($st['owner'])): ?>
            <div class="stylist-owner">👑 <?= htmlspecialchars($t['owner_badge']) ?></div>
          <?php endif; ?>
          <h3 class="stylist-name"><?= htmlspecialchars($st['name']) ?></h3>
          <div class="stylist-spec"><?= htmlspecialchars($role) ?></div>
          <div class="stylist-exp">🏆 <?= htmlspecialchars($fmt_exp($st['exp'])) ?></div>
          <?php if ($bio !== ''): ?>
            <p class="stylist-bio"><?= htmlspecialchars($bio) ?></p>
          <?php endif; ?>
          <div class="stylist-att <?= $stState === 'off' ? 'is-off' : 'is-work' ?>">
            <i></i><?= htmlspecialchars($stState === 'off' ? $t['att_off'] : $t['att_work']) ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Reviews: approved client reviews + average rating -->
  <section class="reviews-section" id="reviews">
    <p class="reviews-slogan"><?= htmlspecialchars($t['reviews_slogan']) ?></p>
    <div class="section-head">
      <h2><?= htmlspecialchars($t['reviews_title']) ?></h2>
      <p><?= htmlspecialchars($t['reviews_desc']) ?></p>
    </div>

    <div class="reviews-top">
      <div class="rev-score">
        <div class="rev-avg"><?= $rSum['count'] > 0 ? number_format((float)$rSum['avg'], 1, '.', '') : '—' ?></div>
        <div>
          <div class="rev-stars" aria-hidden="true"><?= $rSum['count'] > 0 ? str_repeat('★', (int)round((float)$rSum['avg'])) . str_repeat('☆', 5 - (int)round((float)$rSum['avg'])) : '☆☆☆☆☆' ?></div>
          <div class="rev-meta"><?= htmlspecialchars(sprintf($t['reviews_based'], (int)$rSum['count'])) ?></div>
        </div>
      </div>
      <button class="rev-write" type="button" onclick="openReviewSheet()">✍️ <?= htmlspecialchars($t['reviews_write']) ?></button>
    </div>

    <?php if (!$reviewsPublic): ?>
      <div class="reviews-empty">
        <span>💬 <?= htmlspecialchars($t['reviews_empty']) ?></span>

      </div>
    <?php else: ?>
      <div class="reviews-grid">
        <?php foreach ($reviewsPublic as $rv): ?>
          <?php
            $rating = (int)($rv['rating'] ?? 0);
            $stars  = str_repeat('★', max(0, $rating)) . str_repeat('☆', max(0, 5 - $rating));
            $initial = mb_strtoupper(mb_substr((string)($rv['name'] ?? ''), 0, 1));
            $rvDate = (string)($rv['date'] ?? '');
            $rvDate = $rvDate !== '' ? date('d.m.Y', strtotime($rvDate)) : '';
          ?>
          <article class="rev-card" data-review-id="<?= htmlspecialchars((string)($rv['id'] ?? '')) ?>">
            <div class="rev-head">
              <div class="rev-ava" aria-hidden="true"><?= htmlspecialchars($initial) ?></div>
              <div style="flex:1;min-width:0">
                <div class="rev-name"><?= htmlspecialchars((string)($rv['name'] ?? '')) ?></div>
                <div class="rev-date"><?= htmlspecialchars($rvDate) ?></div>
              </div>
              <div class="rev-stars-sm" aria-label="<?= $rating ?>/5"><?= $stars ?></div>
            </div>
            <p class="rev-text"><?= nl2br(htmlspecialchars((string)($rv['text'] ?? ''))) ?></p>
            <div class="rev-svc"><?= htmlspecialchars((string)($rv['service'] ?? '')) ?> · <?= htmlspecialchars((string)($rv['stylist'] ?? '')) ?></div>
            <span class="rev-verified">✔ <?= htmlspecialchars($t['reviews_verified']) ?></span>
            <?php if (!empty($rv['reply'])): ?>
              <div class="rev-reply">
                <b><?= htmlspecialchars($t['reviews_reply']) ?></b>
                <?= nl2br(htmlspecialchars((string)$rv['reply'])) ?>
              </div>
            <?php endif; ?>
            <?php foreach (br_public_comments($rv) as $cm): ?>
              <div class="rev-reply rev-comment">
                <b><?= htmlspecialchars($t['reviews_comment_label']) ?></b>
                <?= nl2br(htmlspecialchars((string)$cm['text'])) ?>
              </div>
            <?php endforeach; ?>
            <button type="button" class="rev-comment-btn" onclick="openReplySheet(this)">💬 <?= htmlspecialchars($t['reviews_reply_btn']) ?></button>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>

  <!-- Toast -->
  <div class="toast-box" id="beautyToast"></div>

  <!-- Footer -->
  <footer class="beauty-footer">
    <div class="footer-wrap">
      <div class="footer-title"><?= htmlspecialchars($brand) ?></div>
      <div class="badge-sky">⚡ Engineered by Skyweb.az</div>
      <p style="color:var(--text-muted); font-size:14px; margin-bottom:16px;"><?= htmlspecialchars($t['footer_desc']) ?></p>
      <div class="footer-contact">
        <a href="tel:<?= htmlspecialchars(preg_replace('/[^\d+]/', '', (string)($brandConf['phone'] ?? ''))) ?>">📞 <?= htmlspecialchars($brandConf['phone'] ?? '') ?></a>
        <span>📍 <?= htmlspecialchars($brandConf['address'][$lang] ?? $brandConf['address']['az'] ?? '') ?></span>
        <span>🕒 <?= htmlspecialchars($brandConf['hours'][$lang] ?? $brandConf['hours']['az'] ?? '') ?></span>
      </div>
      <div class="footer-socials">
        <a href="<?= htmlspecialchars($brandConf['instagram'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Instagram" title="Instagram">
          <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="1.8">
            <rect x="3" y="3" width="18" height="18" rx="5"></rect>
            <circle cx="12" cy="12" r="4"></circle>
            <circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none"></circle>
          </svg>
        </a>
        <a href="<?= htmlspecialchars($brandConf['tiktok'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="TikTok" title="TikTok">
          <svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
            <path d="M16.5 3c.3 2.2 1.5 3.6 3.8 3.9v2.6c-1.4.1-2.7-.3-3.9-1.1v6.3c0 3.6-2.7 6.3-6.2 6.3S4 18.7 4 15.2s2.8-6.2 6.3-6.2c.4 0 .8 0 1.2.1v2.8c-.4-.1-.7-.2-1.1-.2-2 0-3.5 1.6-3.5 3.6s1.5 3.6 3.5 3.6 3.5-1.6 3.5-3.6V3h2.6z"></path>
          </svg>
        </a>
        <a href="<?= htmlspecialchars($brandConf['facebook'] ?? '#') ?>" target="_blank" rel="noopener" aria-label="Facebook" title="Facebook">
          <svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
            <path d="M13.5 21v-8h2.7l.4-3.1h-3.1V7.9c0-.9.3-1.5 1.6-1.5h1.6V3.6c-.3 0-1.3-.1-2.4-.1-2.4 0-4.1 1.5-4.1 4.2v2.2H7.5V13h2.7v8h3.3z"></path>
          </svg>
        </a>
        <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/\D+/', '', (string)($brandConf['whatsapp'] ?? ''))) ?>" target="_blank" rel="noopener" class="wa-link" aria-label="WhatsApp" title="WhatsApp">
          <svg viewBox="0 0 24 24" aria-hidden="true" fill="currentColor">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.86 9.86 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm0 18.12a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.18 8.18 0 0 1-1.26-4.36c0-4.53 3.69-8.21 8.23-8.21a8.22 8.22 0 0 1 8.21 8.21c0 4.53-3.69 8.22-8.21 8.22Zm4.52-6.16c-.25-.13-1.46-.72-1.69-.8-.23-.08-.39-.13-.56.13-.16.25-.64.8-.78.96-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2.01-1.24-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.39.11-.51.11-.11.25-.29.37-.43.13-.14.17-.25.25-.42.08-.16.04-.3-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.48c-.16 0-.43.06-.65.3-.23.25-.87.85-.87 2.07s.89 2.4 1.01 2.57c.13.16 1.75 2.67 4.23 3.75.59.26 1.05.41 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.46-.6 1.67-1.17.2-.58.2-1.07.14-1.17-.06-.11-.23-.17-.48-.29Z"></path>
          </svg>
        </a>
      </div>
      <div style="font-size:13px; color:rgba(255,255,255,0.4);">
        © 2026 <?= htmlspecialchars($brand) ?>. <?= htmlspecialchars($t['footer_rights']) ?>
      </div>
    </div>
  </footer>

  <!-- Bron təsdiqi xülasəsi -->
  <div class="bs-backdrop" id="bookingSuccess" role="dialog" aria-modal="true" aria-labelledby="bsTitle">
    <div class="bs-card">
      <div class="bs-head">
        <h3 class="bs-title" id="bsTitle"><?= htmlspecialchars($t['booking_success_title']) ?></h3>
        <button class="bs-x" type="button" onclick="closeBookingSuccess()" aria-label="<?= htmlspecialchars($t['btn_close']) ?>">✕</button>
      </div>
      <p class="bs-sub"><?= htmlspecialchars($t['booking_success_desc']) ?></p>
      <div class="bs-code" id="bsCode">—</div>
      <div class="bs-code-lbl"><?= htmlspecialchars($t['label_code']) ?></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['field_service']) ?></span><span id="bsService"></span></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['field_stylist']) ?></span><span id="bsStylist"></span></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['label_datetime']) ?></span><span id="bsWhen"></span></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['label_price']) ?></span><span id="bsPrice"></span></div>
      <div class="bs-row is-deposit"><span><?= htmlspecialchars($t['label_deposit']) ?></span><span id="bsDeposit"></span></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['label_card']) ?></span><span id="bsCard"></span></div>
      <div class="bs-row"><span><?= htmlspecialchars($t['label_holder']) ?></span><span id="bsHolder"></span></div>
      <p class="bs-note"><?= htmlspecialchars($t['pay_note']) ?></p>
      <div class="bs-actions">
        <button class="bs-close" type="button" onclick="closeBookingSuccess()"><?= htmlspecialchars($t['btn_close']) ?></button>
      </div>
    </div>
  </div>

  <script>
    (function () {
      const btn = document.getElementById('navToggle');
      const menu = document.getElementById('navLinks');
      if (!btn || !menu) return;
      function closeMenu() {
        menu.classList.remove('is-open');
        btn.setAttribute('aria-expanded', 'false');
      }
      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const open = menu.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      menu.addEventListener('click', function (e) { if (e.target.closest('a')) closeMenu(); });
      document.addEventListener('click', function (e) {
        if (!menu.contains(e.target) && !btn.contains(e.target)) closeMenu();
      });
      document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });
    })();

    function filterServices(cat, btn) {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const cards = document.querySelectorAll('.service-card');
      cards.forEach(card => {
        if (cat === 'all' || card.getAttribute('data-cat') === cat) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }

    const BEAUTY_I18N = <?= json_encode([
      'bookingSub' => $t['booking_sub'],
      'bookingError' => $t['booking_error'],
      'revTitle' => $t['reviews_form_title'],
      'revSub' => $t['reviews_form_sub'],
      'revCode' => $t['reviews_code'],
      'revStars' => $t['reviews_stars'],
      'revText' => $t['reviews_text'],
      'revTextPh' => $t['reviews_text_ph'],
      'revSubmit' => $t['reviews_submit'],
      'revOk' => $t['reviews_ok'],
      'revError' => $t['reviews_error'],
      'revReplyTitle' => $t['reviews_reply_title'],
      'revReplySub' => $t['reviews_reply_sub'],
      'revReplyText' => $t['reviews_reply_text'],
      'revReplyPh' => $t['reviews_reply_ph'],
      'revReplySubmit' => $t['reviews_reply_submit'],
      'revReplyOk' => $t['reviews_reply_ok'],
      'revReplyError' => $t['reviews_reply_error'],
    ], JSON_UNESCAPED_UNICODE) ?>;
    const BEAUTY_LANG = <?= json_encode($lang) ?>;
    const BEAUTY_REVIEW_TOKEN = <?= json_encode($reviewToken) ?>;
    const BEAUTY_REVIEW_CODE = <?= json_encode($reviewCode) ?>;

    const BEAUTY_SERVICES = <?= json_encode(array_map(function ($s) use ($lang, $fmt_dur, $money, $bookSettings, $offerOn, $offer, $offerPrice, $offerOff) {
      $isOfferSvc = $offerOn && (int)$s['id'] === (int)$offer['service_id'];
      $svcPrice   = $isOfferSvc ? (int)$offerPrice : (int)$s['price'];
      return [
        'id' => (int)$s['id'],
        'title' => $s['title'][$lang] ?? $s['title']['az'],
        'price_raw' => $svcPrice,
        'price' => $money($svcPrice),
        'old_price' => $isOfferSvc && $offerOff > 0
          ? $money((int)$s['price'])
          : (!empty($s['old_price']) && $s['old_price'] > $s['price'] ? $money($s['old_price']) : ''),
        'duration' => $fmt_dur($s['duration']),
        'deposit' => bb_deposit($svcPrice, $bookSettings),
      ];
    }, $services), JSON_UNESCAPED_UNICODE) ?>;
    const BEAUTY_SLOTS = <?= json_encode(BB_SLOTS) ?>;
    const BEAUTY_STYLISTS = <?= json_encode(array_map(function ($s) use ($lang) {
      return [
        'value' => $s['name'],
        'label' => $s['name'] . ' — ' . ($s['role'][$lang] ?? ($s['role']['az'] ?? '')),
      ];
    }, $stylists), JSON_UNESCAPED_UNICODE) ?>;
    const BEAUTY_BOOK_TOKEN = <?= json_encode($bookToken) ?>;
    const BEAUTY_DEPOSIT_PCT = <?= (int)$bookSettings['deposit_percent'] ?>;
    const BEAUTY_DEPOSIT_MIN = <?= (int)$bookSettings['deposit_min'] ?>;

    /* ── Onlayn bron: tək tetikleyici hero düyməsidir ─── */
    function openBookingModal(serviceName) {
      const opts = BEAUTY_SERVICES.map(function (s) {
        const priceLabel = s.old_price ? s.price + ' (' + s.old_price + ')' : s.price;
        return { value: String(s.id), label: s.title + ' — ' + priceLabel + ' · ' + s.duration };
      });
      let preset = '';
      if (serviceName && serviceName !== 'General') {
        const hit = BEAUTY_SERVICES.find(function (s) {
          return String(s.id) === String(serviceName) || s.title === serviceName;
        });
        if (hit) preset = String(hit.id);
      }
      const sub = BEAUTY_I18N.bookingSub
        .replace('%p', String(BEAUTY_DEPOSIT_PCT))
        .replace('%m', String(BEAUTY_DEPOSIT_MIN));

      DK.sheet({
        eyebrow: DK.pick('ONLAYN BRON', 'ONLINE BOOKING', 'ОНЛАЙН-ЗАПИСЬ', 'ONLINE RANDEVU'),
        title: DK.pick('Növbə götür', 'Book an appointment', 'Записаться', 'Randevu al'),
        sub: sub,
        submitText: DK.pick('Bronu təsdiqlə', 'Confirm booking', 'Подтвердить запись', 'Randevuyu onayla'),
        submitIcon: '📅',
        fields: [
          { name: 'service_id', label: DK.pick('Xidmət', 'Service', 'Услуга', 'Hizmet'), type: 'select', required: true, options: opts, value: preset },
          { name: 'stylist', label: DK.pick('Qeydiyyatlı usta', 'Registered master', 'Зарегистрированный мастер', 'Kayıtlı uzman'), type: 'select', required: true, options: BEAUTY_STYLISTS },
          { name: 'date', label: DK.t.date, type: 'date', min: new Date().toISOString().slice(0, 10), required: true },
          { name: 'time', label: DK.t.time, type: 'select', required: true, options: BEAUTY_SLOTS },
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'note', label: DK.t.note, type: 'textarea', rows: 2, placeholder: DK.t.notePh }
        ]
      }).then(function (d) {
        if (!d) return;
        submitBooking(d);
      });
    }

    function submitBooking(d) {
      fetch('beauty-booking-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          token: BEAUTY_BOOK_TOKEN,
          lang: BEAUTY_LANG,
          service_id: d.service_id,
          stylist: d.stylist,
          date: d.date,
          time: d.time,
          name: d.name,
          phone: d.phone,
          note: d.note || ''
        })
      }).then(function (r) { return r.json(); }).then(function (data) {
        if (!data || !data.ok) {
          DK.toast((data && data.error) || BEAUTY_I18N.bookingError, 'err');
          return;
        }
        showBookingSuccess(data);
      }).catch(function () {
        DK.toast(BEAUTY_I18N.bookingError, 'err');
      });
    }

    function showBookingSuccess(data) {
      const svc = BEAUTY_SERVICES.find(function (s) { return String(s.id) === String(data.service_id); });
      const set = function (id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val;
      };
      set('bsCode', data.code);
      set('bsService', svc ? svc.title : data.service);
      set('bsStylist', data.stylist);
      set('bsWhen', data.date + ' · ' + data.time);
      set('bsPrice', data.price + ' AZN');
      set('bsDeposit', data.deposit + ' AZN');
      set('bsCard', data.card_number || '—');
      set('bsHolder', data.card_holder || '—');

      const modal = document.getElementById('bookingSuccess');
      if (modal) {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
      }
    }

    function closeBookingSuccess() {
      const modal = document.getElementById('bookingSuccess');
      if (modal) modal.classList.remove('is-open');
      document.body.style.overflow = '';
    }

    /* ── Rəy formu ─────────────────────────────────────── */
    function openReviewSheet() {
      const stars = [
        { value: '5', label: '★★★★★' },
        { value: '4', label: '★★★★☆' },
        { value: '3', label: '★★★☆☆' },
        { value: '2', label: '★★☆☆☆' },
        { value: '1', label: '★☆☆☆☆' }
      ];
      DK.sheet({
        eyebrow: DK.pick('RƏY', 'REVIEW', 'ОТЗЫВ', 'YORUM'),
        title: BEAUTY_I18N.revTitle,
        sub: BEAUTY_I18N.revSub,
        submitText: BEAUTY_I18N.revSubmit,
        submitIcon: '⭐',
        fields: [
          { name: 'code', label: BEAUTY_I18N.revCode, required: true, value: BEAUTY_REVIEW_CODE, placeholder: 'SB-0001' },
          { name: 'rating', label: BEAUTY_I18N.revStars, type: 'select', required: true, options: stars },
          { name: 'text', label: BEAUTY_I18N.revText, type: 'textarea', rows: 4, required: true, placeholder: BEAUTY_I18N.revTextPh }
        ]
      }).then(function (d) {
        if (!d) return;
        submitReview(d);
      });
    }

    function submitReview(d) {
      fetch('beauty-review-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          token: BEAUTY_REVIEW_TOKEN,
          lang: BEAUTY_LANG,
          code: d.code,
          rating: parseInt(d.rating, 10),
          text: d.text
        })
      }).then(function (r) { return r.json(); }).then(function (data) {
        if (!data || !data.ok) {
          DK.toast((data && data.error) || BEAUTY_I18N.revError, 'err');
          return;
        }
        DK.toast(BEAUTY_I18N.revOk);
      }).catch(function () {
        DK.toast(BEAUTY_I18N.revError, 'err');
      });
    }

    function openReplySheet(btn) {
      const card = btn ? btn.closest('.rev-card') : null;
      const id = card ? (card.getAttribute('data-review-id') || '') : '';
      if (!id) return;
      DK.sheet({
        eyebrow: DK.pick('FİKİR', 'COMMENT', 'КОММЕНТАРИЙ', 'GÖRÜŞ'),
        title: BEAUTY_I18N.revReplyTitle,
        sub: BEAUTY_I18N.revReplySub,
        submitText: BEAUTY_I18N.revReplySubmit,
        submitIcon: '💬',
        fields: [
          { name: 'text', label: BEAUTY_I18N.revReplyText, type: 'textarea', rows: 4,
            required: true, placeholder: BEAUTY_I18N.revReplyPh }
        ]
      }).then(function (d) {
        if (!d) return;
        submitReply(id, d.text);
      });
    }

    function submitReply(id, text) {
      fetch('beauty-review-api.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          token: BEAUTY_REVIEW_TOKEN,
          lang: BEAUTY_LANG,
          action: 'comment',
          id: id,
          text: text
        })
      }).then(function (r) { return r.json(); }).then(function (data) {
        if (!data || !data.ok) {
          DK.toast((data && data.error) || BEAUTY_I18N.revReplyError, 'err');
          return;
        }
        DK.toast(BEAUTY_I18N.revReplyOk);
      }).catch(function () {
        DK.toast(BEAUTY_I18N.revReplyError, 'err');
      });
    }

    if (BEAUTY_REVIEW_CODE) {
      setTimeout(openReviewSheet, 800);
    }

    function showToast(text, type) { DK.toast(text, type); }

    /* Sahib yükləmə formaları: MB və video uzunluğu əvvəlcə brauzerdə yoxlanır */
    (function () {
      var limits = <?= json_encode($galleryLimits) ?>;
      document.querySelectorAll('[data-demo-media]').forEach(function (form) {
        var input = form.querySelector('input[type=file]');
        var hint = form.querySelector('.ga-hint');
        if (!input || !hint) return;
        var kind = form.dataset.demoMedia;
        var maxMb = kind === 'photo' ? limits.photo_mb : limits.video_mb;
        var base = 'Max ' + maxMb + ' MB' + (kind === 'video' ? ' · ' + limits.video_sec + ' saniyə' : '');
        input.addEventListener('change', function () {
          hint.classList.remove('is-error');
          var f = input.files && input.files[0];
          hint.textContent = f ? (f.size / 1048576).toFixed(1) + ' MB' : base;
        });
        form.addEventListener('submit', function (e) {
          var f = input.files && input.files[0];
          if (!f) return;
          if (f.size > maxMb * 1048576) {
            e.preventDefault();
            hint.classList.add('is-error');
            hint.textContent = 'Fayl çox böyük — max ' + maxMb + ' MB.';
            return;
          }
          if (kind !== 'video') return;
          e.preventDefault();
          var url = URL.createObjectURL(f);
          var probe = document.createElement('video');
          probe.preload = 'metadata';
          probe.onloadedmetadata = function () {
            URL.revokeObjectURL(url);
            if (isFinite(probe.duration) && probe.duration > limits.video_sec + 0.2) {
              hint.classList.add('is-error');
              hint.textContent = 'Video ' + limits.video_sec + ' saniyədən uzundur (' + Math.round(probe.duration) + ' s).';
            } else {
              form.submit();
            }
          };
          probe.onerror = function () { URL.revokeObjectURL(url); form.submit(); };
          probe.src = url;
        });
      });
    })();

    /* Qalereya lightbox: foto + video, klaviatura və mobil dəstəyi */
    (function () {
      var box = document.getElementById('galleryLightbox');
      if (!box) return;
      var cards = Array.prototype.slice.call(document.querySelectorAll('.gallery-trigger[data-gl-index]'));
      if (!cards.length) return;
      var image = box.querySelector('[data-gl-image]');
      var video = box.querySelector('[data-gl-video]');
      var count = box.querySelector('[data-gl-count]');
      var caption = box.querySelector('[data-gl-caption]');
      var closeBtn = box.querySelector('[data-gl-close]');
      var current = -1;
      var lastFocus = null;

      function clear() {
        try { video.pause(); video.removeAttribute('src'); video.removeAttribute('poster'); video.load(); } catch (e) {}
        image.removeAttribute('src');
        image.hidden = true;
        video.hidden = true;
      }
      function show(i) {
        current = (i + cards.length) % cards.length;
        var data = cards[current].dataset;
        var isVideo = data.glType === 'video';
        clear();
        caption.textContent = data.glTitle || '';
        count.textContent = (current + 1) + ' / ' + cards.length;
        if (isVideo) {
          if (data.glPoster) video.poster = data.glPoster;
          video.src = data.glSrc;
          video.hidden = false;
          var play = video.play();
          if (play && typeof play.catch === 'function') play.catch(function () {});
        } else {
          image.src = data.glSrc;
          image.alt = data.glTitle || '';
          image.hidden = false;
        }
      }
      function openGallery(i) {
        lastFocus = document.activeElement;
        box.classList.add('is-open');
        box.setAttribute('aria-hidden', 'false');
        document.body.classList.add('gl-locked');
        show(i);
        if (closeBtn) closeBtn.focus();
      }
      function closeGallery() {
        box.classList.remove('is-open');
        box.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('gl-locked');
        clear();
        if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
      }
      cards.forEach(function (btn, i) {
        btn.addEventListener('click', function () { openGallery(i); });
      });
      box.addEventListener('click', function (e) { if (e.target === box) closeGallery(); });
      if (closeBtn) closeBtn.addEventListener('click', closeGallery);
      var prev = box.querySelector('[data-gl-prev]');
      var next = box.querySelector('[data-gl-next]');
      if (prev) prev.addEventListener('click', function () { show(current - 1); });
      if (next) next.addEventListener('click', function () { show(current + 1); });
      document.addEventListener('keydown', function (e) {
        if (!box.classList.contains('is-open')) return;
        if (e.key === 'Escape') { e.preventDefault(); closeGallery(); }
        else if (e.key === 'ArrowLeft') { e.preventDefault(); show(current - 1); }
        else if (e.key === 'ArrowRight') { e.preventDefault(); show(current + 1); }
      });
    })();

  </script>
</body>
</html>
