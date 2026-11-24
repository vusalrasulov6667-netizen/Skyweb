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
        'brand_name' => 'APEXFIT',
        'brand_sub' => 'Premium Fitness & Performans Klubu',
        'nav_schedule' => 'Dərs Cədvəli',
        'nav_plans' => 'Abunəliklər',
        'nav_trainers' => 'Məşqçilər',
        'nav_gallery' => 'Qalereya',
        'nav_join' => 'Sınaq Dərsi',
        'hero_badge' => 'BAKININ NÖMRƏ 1 İDMAN KOMPLEKSİ',
        'hero_title_1' => 'Məqsədlərinə Çat.',
        'hero_title_2' => 'Gücünü Kəşf Et.',
        'hero_desc' => 'Ən son nəsil avadanlıqlar, beynəlxalq dərəcəli məşqçilər, sauna və spa zonası ilə fiziki formanı zirvəyə qaldır.',
        'hero_cta' => 'Ödənişsiz Sınaq Dərsi',
        'hero_watch' => 'Klubu Kəşf Et',
        'stat_members' => '2,400+ Fəal Üzv',
        'stat_trainers' => '35+ Sertifikatlı Məşqçi',
        'stat_classes' => '120+ Həftəlik Qrup Dərsi',
        'schedule_title' => 'Həftəlik Dərs Cədvəli',
        'schedule_sub' => 'Sevdiyiniz dərsi seçin və yerinizi əvvəlcədən bron edin.',
        'day_mon' => 'Bazar ertəsi',
        'day_tue' => 'Çərşənbə axşamı',
        'day_wed' => 'Çərşənbə',
        'day_thu' => 'Cümə axşamı',
        'day_fri' => 'Cümə',
        'day_sat' => 'Şənbə',
        'book_class' => 'Yer Bron Et',
        'booked_success' => 'Dərsə yeriniz qeydə alındı!',
        'plans_title' => 'Üzvlük Paketləri',
        'plans_sub' => 'Büdcənizə və hədəflərinizə uyğun ən ideal planı seçin.',
        'billing_monthly' => 'Aylıq',
        'billing_annual' => 'İllik (25% Qənaət)',
        'plan_popular' => 'ƏN ÇOX SEÇİLƏN',
        'choose_plan' => 'Paketi Seç',
        'plan_bronze' => 'Bronze',
        'plan_silver' => 'Silver Pro',
        'plan_gold' => 'VIP Gold',
        'per_month' => '/ ay',
        'feat_gym_access' => 'Gym və kardioməşq zonasına giriş',
        'feat_locker' => 'Şkaf və duş otaqları',
        'feat_all_classes' => 'Bütün qrup dərsləri (Yoga, Boxing, CrossFit)',
        'feat_sauna' => 'Fin saunası və istirahət zonası',
        'feat_inbody' => 'Aylıq InBody bədən analizi',
        'feat_pt' => 'Hər ay 4 fərdi məşqçi dərsi',
        'feat_nutrition' => 'Fərdi qidalanma planı və dietoloq dəstəyi',
        'feat_vip_lounge' => 'VIP Lounge & Pulsuz protein kokteylləri',
        'trainers_title' => 'Peşəkar Məşqçilərimiz',
        'trainers_sub' => 'Sizi hədəflərinizə çatdıracaq çempion komandamız.',
        'gallery_title' => 'Zalımızdan Görüntülər',
        'gallery_sub' => '1500 m² geniş məkanda komfortlu və təmiz mühit.',
        'form_title' => 'Ödənişsiz Sınaq Dərsinə Yazıl',
        'form_sub' => 'Məlumatlarınızı qeyd edin, menecerimiz 10 dəqiqə ərzində sizinlə əlaqə saxlasın.',
        'form_name' => 'Adınız və Soyadınız',
        'form_phone' => 'Əlaqə Nömrəsi',
        'form_goal' => 'Əsas İdman Məqsədiniz',
        'goal_weight' => 'Çəki atmaq & Yağ yandırmaq',
        'goal_muscle' => 'Əzələ kütləsi artırmaq',
        'goal_stamina' => 'Dözümlülük və sağlamlıq',
        'form_time' => 'Əlverişli Vaxt',
        'time_morning' => 'Səhər (07:00 - 12:00)',
        'time_afternoon' => 'Günorta (12:00 - 17:00)',
        'time_evening' => 'Axşam (17:00 - 22:00)',
        'form_submit' => 'Sınaq Dərsinə Qeydiyyatdan Keç',
        'form_success' => 'Təbriklər! Müraciətiniz qəbul olundu. Tezliklə əlaqə saxlayacağıq.',
        'wa_chat' => 'WhatsApp Məsləhət',
        'video_modal_title' => 'Məşq Video İcmalı',
        'video_title_suffix' => ' — Canlı Məşq Hərəkətləri',
        'footer_desc' => 'Bu demo idman zalları, fitness klubları və crossfit mərkəzləri üçün Skyweb tərəfindən hazırlanmışdır.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'banner_text' => 'This is a demo website — Created by Skyweb',
        'back_to_sky' => 'Back to Skyweb',
        'brand_name' => 'APEXFIT',
        'brand_sub' => 'Elite Fitness & Performance Club',
        'nav_schedule' => 'Class Schedule',
        'nav_plans' => 'Memberships',
        'nav_trainers' => 'Coaches',
        'nav_gallery' => 'Facility',
        'nav_join' => 'Free Trial',
        'hero_badge' => 'BAKU\'S PREMIER FITNESS CLUB',
        'hero_title_1' => 'Crush Your Goals.',
        'hero_title_2' => 'Unleash Power.',
        'hero_desc' => 'State-of-the-art equipment, world-class certified coaches, luxury sauna and spa zone to sculpt your peak physical form.',
        'hero_cta' => 'Claim Free Trial Day',
        'hero_watch' => 'Take Virtual Tour',
        'stat_members' => '2,400+ Active Members',
        'stat_trainers' => '35+ Certified Coaches',
        'stat_classes' => '120+ Weekly Classes',
        'schedule_title' => 'Weekly Class Timetable',
        'schedule_sub' => 'Choose your favorite session and book your spot ahead of time.',
        'day_mon' => 'Monday',
        'day_tue' => 'Tuesday',
        'day_wed' => 'Wednesday',
        'day_thu' => 'Thursday',
        'day_fri' => 'Friday',
        'day_sat' => 'Saturday',
        'book_class' => 'Book Spot',
        'booked_success' => 'Class spot successfully reserved!',
        'plans_title' => 'Membership Plans',
        'plans_sub' => 'Flexible membership packages designed around your lifestyle and goals.',
        'billing_monthly' => 'Monthly',
        'billing_annual' => 'Annual (Save 25%)',
        'plan_popular' => 'MOST POPULAR',
        'choose_plan' => 'Select Plan',
        'plan_bronze' => 'Bronze Basic',
        'plan_silver' => 'Silver Pro',
        'plan_gold' => 'VIP Gold',
        'per_month' => '/ mo',
        'feat_gym_access' => 'Full access to gym & cardio zones',
        'feat_locker' => 'Lockers, showers & towel service',
        'feat_all_classes' => 'All group classes (Yoga, Boxing, CrossFit)',
        'feat_sauna' => 'Finnish sauna & recovery lounge',
        'feat_inbody' => 'Monthly InBody body composition scan',
        'feat_pt' => '4 Personal Training sessions every month',
        'feat_nutrition' => 'Customized nutrition meal plan',
        'feat_vip_lounge' => 'VIP Lounge & free protein shakes',
        'trainers_title' => 'Meet Our Elite Coaches',
        'trainers_sub' => 'Certified champions dedicated to guiding your transformation.',
        'gallery_title' => 'Facility & Atmosphere',
        'gallery_sub' => '1500 m² of clean, high-performance training grounds.',
        'form_title' => 'Get Your Free Trial Pass',
        'form_sub' => 'Fill out the form below and our manager will contact you within 10 minutes.',
        'form_name' => 'Full Name',
        'form_phone' => 'Phone Number',
        'form_goal' => 'Your Primary Fitness Goal',
        'goal_weight' => 'Weight Loss & Fat Burn',
        'goal_muscle' => 'Muscle Gain & Hypertrophy',
        'goal_stamina' => 'Endurance & Athletic Performance',
        'form_time' => 'Preferred Time',
        'time_morning' => 'Morning (07:00 - 12:00)',
        'time_afternoon' => 'Afternoon (12:00 - 17:00)',
        'time_evening' => 'Evening (17:00 - 22:00)',
        'form_submit' => 'Confirm Free Trial Pass',
        'form_success' => 'Congratulations! Your trial pass is confirmed. We will reach out shortly.',
        'wa_chat' => 'WhatsApp Advice',
        'video_modal_title' => 'Workout Video Preview',
        'video_title_suffix' => ' — Live Workout Routine',
        'footer_desc' => 'This demo was created by Skyweb for gyms, fitness clubs, and crossfit studios.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'banner_text' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'brand_name' => 'APEXFIT',
        'brand_sub' => 'Elit Fitness & Performans Kulübü',
        'nav_schedule' => 'Ders Programı',
        'nav_plans' => 'Üyelikler',
        'nav_trainers' => 'Eğitmenler',
        'nav_gallery' => 'Tesis',
        'nav_join' => 'Ücretsiz Deneme',
        'hero_badge' => 'BAKÜ\'NÜN EN İYİ SPOR MERKEZİ',
        'hero_title_1' => 'Hedeflerini Yakala.',
        'hero_title_2' => 'Gücünü Keşfet.',
        'hero_desc' => 'Son teknoloji ekipmanlar, uluslararası sertifikalı antrenörler, sauna ve spa alanıyla formunun zirvesine ulaş.',
        'hero_cta' => 'Ücretsiz Deneme Dersi Al',
        'hero_watch' => 'Salonu İncele',
        'stat_members' => '2,400+ Aktif Üye',
        'stat_trainers' => '35+ Sertifikalı Eğitmen',
        'stat_classes' => 'Haftada 120+ Grup Dersi',
        'schedule_title' => 'Haftalık Ders Takvimi',
        'schedule_sub' => 'Favori seansınızı seçin ve yerinizi önceden ayırtın.',
        'day_mon' => 'Pazartesi',
        'day_tue' => 'Salı',
        'day_wed' => 'Çarşamba',
        'day_thu' => 'Perşembe',
        'day_fri' => 'Cuma',
        'day_sat' => 'Cumartesi',
        'book_class' => 'Yer Ayırt',
        'booked_success' => 'Ders rezervasyonunuz başarıyla tamamlandı!',
        'plans_title' => 'Üyelik Paketleri',
        'plans_sub' => 'Hedeflerinize en uygun avantajlı üyelik planını seçin.',
        'billing_monthly' => 'Aylık',
        'billing_annual' => 'Yıllık (%25 İndirim)',
        'plan_popular' => 'EN ÇOK TERCİH EDİLEN',
        'choose_plan' => 'Planı Seç',
        'plan_bronze' => 'Bronze',
        'plan_silver' => 'Silver Pro',
        'plan_gold' => 'VIP Gold',
        'per_month' => '/ ay',
        'feat_gym_access' => 'Gym ve kardiyo alanına tam erişim',
        'feat_locker' => 'Dolap, duş ve havlu hizmeti',
        'feat_all_classes' => 'Tüm grup dersleri (Yoga, Boks, CrossFit)',
        'feat_sauna' => 'Fin saunası ve dinlenme alanı',
        'feat_inbody' => 'Aylık InBody vücut analizi',
        'feat_pt' => 'Her ay 4 bireysel antrenör dersi',
        'feat_nutrition' => 'Kişiye özel beslenme programı',
        'feat_vip_lounge' => 'VIP Dinlenme Salonu & Ücretsiz shake',
        'trainers_title' => 'Uzman Eğitmenlerimiz',
        'trainers_sub' => 'Sizi hedefinize ulaştıracak şampiyon kadromuz.',
        'gallery_title' => 'Tesisimizden Kareler',
        'gallery_sub' => '1500 m² hijyenik ve modern spor ortamı.',
        'form_title' => 'Ücretsiz Deneme Dersi Alın',
        'form_sub' => 'Bilgilerinizi bırakın, 10 dakika içinde sizi arayalım.',
        'form_name' => 'Adınız Soyadınız',
        'form_phone' => 'Telefon Numaranız',
        'form_goal' => 'Ana Fitness Hedefiniz',
        'goal_weight' => 'Kilo Verme & Yağ Yakımı',
        'goal_muscle' => 'Kas Kazanımı & Hacim',
        'goal_stamina' => 'Kondisyon & Güçlenme',
        'form_time' => 'Uygun Saat Dilimi',
        'time_morning' => 'Sabah (07:00 - 12:00)',
        'time_afternoon' => 'Öğleden Sonra (12:00 - 17:00)',
        'time_evening' => 'Akşam (17:00 - 22:00)',
        'form_submit' => 'Deneme Randevusu Oluştur',
        'form_success' => 'Tebrikler! Deneme dersi randevunuz alındı.',
        'wa_chat' => 'WhatsApp Danışma',
        'video_modal_title' => 'Antrenman Video Önizleme',
        'video_title_suffix' => ' — Canlı Egzersiz Rutini',
        'footer_desc' => 'Bu demo spor salonları ve fitness kulüpleri için Skyweb tarafından geliştirilmiştir.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'banner_text' => 'Это демонстрационный сайт — Создан в Skyweb',
        'back_to_sky' => 'Назад в Skyweb',
        'brand_name' => 'APEXFIT',
        'brand_sub' => 'Элитный фитнес & спортивный клуб',
        'nav_schedule' => 'Расписание',
        'nav_plans' => 'Абонементы',
        'nav_trainers' => 'Тренеры',
        'nav_gallery' => 'Клуб',
        'nav_join' => 'Пробная тренировка',
        'hero_badge' => 'ФИТНЕС-КЛУБ ПРЕМИУМ КЛАССА В БАКУ',
        'hero_title_1' => 'Достигай Целей.',
        'hero_title_2' => 'Становись Сильнее.',
        'hero_desc' => 'Передовые тренажеры, сертифицированные тренеры международного класса, сауна и спа-зона для вашей лучшей формы.',
        'hero_cta' => 'Бесплатное пробное занятие',
        'hero_watch' => '3D Экскурсия',
        'stat_members' => '2,400+ Членов клуба',
        'stat_trainers' => '35+ Топ-тренеров',
        'stat_classes' => '120+ Групповых занятий в неделю',
        'schedule_title' => 'Расписание групповых программ',
        'schedule_sub' => 'Выберите направление и забронируйте место в зале.',
        'day_mon' => 'Понедельник',
        'day_tue' => 'Вторник',
        'day_wed' => 'Среда',
        'day_thu' => 'Четверг',
        'day_fri' => 'Пятница',
        'day_sat' => 'Суббота',
        'book_class' => 'Записаться',
        'booked_success' => 'Вы успешно записаны на занятие!',
        'plans_title' => 'Клубные карты',
        'plans_sub' => 'Выберите выгодный тариф для достижения ваших спортивных целей.',
        'billing_monthly' => 'Ежемесячно',
        'billing_annual' => 'Годовой (скидка 25%)',
        'plan_popular' => 'ХИТ ПРОДАЖ',
        'choose_plan' => 'Выбрать карту',
        'plan_bronze' => 'Bronze Basic',
        'plan_silver' => 'Silver Pro',
        'plan_gold' => 'VIP Gold',
        'per_month' => '/ мес',
        'feat_gym_access' => 'Доступ в тренажерный зал и кардиозону',
        'feat_locker' => 'Шкафчики, душевые и банные полотенца',
        'feat_all_classes' => 'Все групповые занятия (Yoga, Бокс, CrossFit)',
        'feat_sauna' => 'Финская сауна и зона релакса',
        'feat_inbody' => 'Ежемесячный анализ состава тела InBody',
        'feat_pt' => '4 персональные тренировки каждый месяц',
        'feat_nutrition' => 'Индивидуальный рацион питания от нутрициолога',
        'feat_vip_lounge' => 'VIP лаунж и бесплатные протеиновые коктейли',
        'trainers_title' => 'Тренерский состав',
        'trainers_sub' => 'Профессиональные атлеты и наставники с многолетним опытом.',
        'gallery_title' => 'Атмосфера нашего клуба',
        'gallery_sub' => '1500 м² ультрасовременного тренировочного пространства.',
        'form_title' => 'Запишитесь на бесплатную тренировку',
        'form_sub' => 'Оставьте заявку, и наш менеджер перезвонит вам в течение 10 минут.',
        'form_name' => 'Ваше имя и фамилия',
        'form_phone' => 'Номер телефона',
        'form_goal' => 'Основная цель тренировок',
        'goal_weight' => 'Похудение и сжигание жира',
        'goal_muscle' => 'Набор мышечной массы',
        'goal_stamina' => 'Выносливость и общее здоровье',
        'form_time' => 'Удобное время',
        'time_morning' => 'Утро (07:00 - 12:00)',
        'time_afternoon' => 'День (12:00 - 17:00)',
        'time_evening' => 'Вечер (17:00 - 22:00)',
        'form_submit' => 'Получить бесплатный абонемент',
        'form_success' => 'Поздравляем! Ваша заявка принята. Скоро свяжемся с вами.',
        'wa_chat' => 'Консультация в WhatsApp',
        'video_modal_title' => 'Видеообзор тренировки',
        'video_title_suffix' => ' — Упражнения онлайн',
        'footer_desc' => 'Данный демонстрационный сайт разработан веб-студией Skyweb для фитнес-центров и тренажерных залов.',
        'all_rights' => 'Все права защищены.',
    ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$trainers = [
    [
        'name' => 'Kamran Məmmədov',
        'role' => [
            'az' => 'CrossFit & Güc Məşqçisi',
            'en' => 'CrossFit & Strength Head Coach',
            'tr' => 'CrossFit & Güç Baş Antrenörü',
            'ru' => 'Главный тренер CrossFit и силовых программ'
        ],
        'exp' => '8 il təcrübə',
        'img' => 'https://images.unsplash.com/photo-1567013127542-490d757e51fc?w=400&q=80',
        'cert' => 'CrossFit L-2, NSCA-CPT',
    ],
    [
        'name' => 'Aysel Əliyeva',
        'role' => [
            'az' => 'Yoga & Pilates Master',
            'en' => 'Yoga & Functional Mobility Lead',
            'tr' => 'Yoga & Pilates Uzmanı',
            'ru' => 'Мастер йоги и пилатеса'
        ],
        'exp' => '6 il təcrübə',
        'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=400&q=80',
        'cert' => 'RYT-500 Yoga Alliance',
    ],
    [
        'name' => 'Teymur Rəhimov',
        'role' => [
            'az' => 'Boks & Kikboks Məşqçisi',
            'en' => 'Boxing & Combat Conditioning Coach',
            'tr' => 'Boks & Dövüş Sanatları Antrenörü',
            'ru' => 'Тренер по боксу и единоборствам'
        ],
        'exp' => '10 il təcrübə',
        'img' => 'https://images.unsplash.com/photo-1583473848882-f9a5bc7fd2ee?w=400&q=80',
        'cert' => 'Milli Yığma Məşqçisi',
    ],
    [
        'name' => 'Leyla Qasımova',
        'role' => [
            'az' => 'Kardio & Fərdi Dietoloq',
            'en' => 'HIIT & Sports Nutrition Specialist',
            'tr' => 'HIIT & Spor Diyetisyeni',
            'ru' => 'Специалист по HIIT и спортивному питанию'
        ],
        'exp' => '5 il təcrübə',
        'img' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400&q=80',
        'cert' => 'ISSA Fitness Nutrition',
    ],
];

$classes = [
    ['day' => 'mon', 'time' => '08:00 - 09:00', 'title' => 'Morning Power Yoga', 'coach' => 'Aysel Ə.', 'room' => 'Studio 1', 'burn' => '420 kcal', 'diff' => 'Orta'],
    ['day' => 'mon', 'time' => '18:30 - 19:30', 'title' => 'CrossFit WOD & Beast', 'coach' => 'Kamran M.', 'room' => 'Box Arena', 'burn' => '750 kcal', 'diff' => 'Yüksək'],
    ['day' => 'mon', 'time' => '20:00 - 21:00', 'title' => 'Fight Club Boxing', 'coach' => 'Teymur R.', 'room' => 'Ring Zone', 'burn' => '680 kcal', 'diff' => 'İntensiv'],
    ['day' => 'tue', 'time' => '09:00 - 10:00', 'title' => 'Core & Pilates Flow', 'coach' => 'Aysel Ə.', 'room' => 'Studio 2', 'burn' => '380 kcal', 'diff' => 'Başlanğıc'],
    ['day' => 'tue', 'time' => '19:00 - 20:00', 'title' => 'HIIT Metabolic Burn', 'coach' => 'Leyla Q.', 'room' => 'Cardio Deck', 'burn' => '620 kcal', 'diff' => 'Yüksək'],
    ['day' => 'wed', 'time' => '08:30 - 09:30', 'title' => 'Olympic Weightlifting', 'coach' => 'Kamran M.', 'room' => 'Iron Pit', 'burn' => '550 kcal', 'diff' => 'Yüksək'],
    ['day' => 'wed', 'time' => '19:00 - 20:00', 'title' => 'Kickboxing Combos', 'coach' => 'Teymur R.', 'room' => 'Ring Zone', 'burn' => '700 kcal', 'diff' => 'İntensiv'],
    ['day' => 'thu', 'time' => '18:30 - 19:30', 'title' => 'Spinning & Rhythm Cycle', 'coach' => 'Leyla Q.', 'room' => 'Cycle Cave', 'burn' => '640 kcal', 'diff' => 'Orta'],
    ['day' => 'fri', 'time' => '19:00 - 20:30', 'title' => 'Weekend Warrior CrossFit', 'coach' => 'Kamran M.', 'room' => 'Box Arena', 'burn' => '820 kcal', 'diff' => 'Maksimum'],
    ['day' => 'sat', 'time' => '11:00 - 12:30', 'title' => 'Sound Bath & Deep Stretch', 'coach' => 'Aysel Ə.', 'room' => 'Zen Spa', 'burn' => '250 kcal', 'diff' => 'Bərpa'],
];

$programs = [
    [
        'id' => 'crossfit',
        'title' => [
            'az' => 'CrossFit & Beast Güc Proqramı',
            'en' => 'CrossFit & Athletic Conditioning',
            'tr' => 'CrossFit & Güç Kondisyon Programı',
            'ru' => 'Программа CrossFit и силовая кондиция'
        ],
        'desc' => [
            'az' => 'Olimpiya ağırlıqqaldırma, dözümlülük və bədən çevikliyi. Həftədə 4 intensiv məşq.',
            'en' => 'Olympic lifting, functional endurance, and high-intensity interval conditioning.',
            'tr' => 'Olimpik halter, fonksiyonel dayanıklılık ve yüksek yoğunluklu kondisyon.',
            'ru' => 'Олимпийская тяжелая атлетика, функциональная выносливость и интервальные нагрузки.'
        ],
        'price' => '120 AZN',
        'coach' => 'Kamran M.',
        'badge' => '🔥 YÜKSƏK İNTENSİV',
        'duration' => '8 Həftə • 32 Sessiya',
        'img' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?w=700&q=80',
    ],
    [
        'id' => 'hiit_fatburn',
        'title' => [
            'az' => 'HIIT Yağ Yandırma & Formada Qal',
            'en' => 'HIIT Metabolic Fat Burn & Sculpt',
            'tr' => 'HIIT Yağ Yakımı & Sıkılaşma',
            'ru' => 'HIIT Жиросжигание и тонус тела'
        ],
        'desc' => [
            'az' => 'Fərdi kardio monitorinqi, metabolik sürətləndirmə və fərdi qidalanma menyusu.',
            'en' => 'Heart-rate tracked intervals, metabolic boost, and curated nutrition meal plan.',
            'tr' => 'Nabız kontrollü kardiyo, metabolizma hızlandırma ve özel diyet programı.',
            'ru' => 'Интервалы с контролем пульса, разгон метаболизма и план питания от нутрициолога.'
        ],
        'price' => '110 AZN',
        'coach' => 'Leyla Q.',
        'badge' => '⚡ ARIQLAMA & TONUS',
        'duration' => '6 Həftə • 24 Sessiya',
        'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=700&q=80',
    ],
    [
        'id' => 'boxing_pro',
        'title' => [
            'az' => 'Boks & Döyüş Sənəti Təlimi',
            'en' => 'Boxing & Combat Conditioning Pro',
            'tr' => 'Boks & Dövüş Sanatları Eğitimi',
            'ru' => 'Бокс и бойцовская подготовка'
        ],
        'desc' => [
            'az' => 'Zərbə texnikası, ayaq hərəkətləri, reaksiya və ring dözümlülüyünün inkişafı.',
            'en' => 'Punch mechanics, agility footwork, defensive reflexes, and ring endurance.',
            'tr' => 'Vuruş tekniği, ayak oyunları, savunma refleksleri ve ring dayanıklılığı.',
            'ru' => 'Техника ударов, работа ног, защитные рефлексы и выносливость на ринге.'
        ],
        'price' => '130 AZN',
        'coach' => 'Teymur R.',
        'badge' => '🥊 DÖYÜŞ & KONDİSİYA',
        'duration' => '12 Həftə • 36 Sessiya',
        'img' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?w=700&q=80',
    ],
    [
        'id' => 'vip_pt',
        'title' => [
            'az' => 'VIP 1-ə 1 Fərdi Şəxsi Məşqçi (PT)',
            'en' => 'VIP 1-on-1 Personal Trainer Coaching',
            'tr' => 'VIP Bire Bir Özel Antrenörlük',
            'ru' => 'VIP персональные тренировки 1-на-1'
        ],
        'desc' => [
            'az' => 'Tam fərdi proqram, InBody analizləri, 24/7 konsultasiya və VIP sauna/duş zonası.',
            'en' => 'Fully tailored biomechanics, bi-weekly InBody scans, 24/7 coach messaging.',
            'tr' => 'Tamamen kişiye özel program, haftalık InBody ölçümleri ve 7/24 antrenör takibi.',
            'ru' => 'Полностью индивидуальная программа, биоимпеданс InBody и поддержка тренера 24/7.'
        ],
        'price' => '240 AZN',
        'coach' => 'Seçiminizə görə',
        'badge' => '👑 MAKSİMAL NƏTİCƏ',
        'duration' => '12 Fərdi Sessiya',
        'img' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=700&q=80',
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
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-surface: #002525;
      --sky-card: #002d2d;
      --neon-cyan: #00FFFF;
      --neon-glow: rgba(0, 255, 255, 0.4);
      --electric-lime: #10b981;
      --amber: #f59e0b;
      --text-main: #f1f5f9;
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
        radial-gradient(circle at 10% 15%, rgba(0, 255, 255, 0.08) 0%, transparent 45%),
        radial-gradient(circle at 90% 60%, rgba(16, 185, 129, 0.07) 0%, transparent 45%);
      color: var(--text-main);
      font-family: var(--font-body);
      line-height: 1.6;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; }

    /* Top Skyweb Banner */
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
      letter-spacing: 1px;
      color: #fff;
    }
    .brand svg { color: var(--neon-cyan); filter: drop-shadow(0 0 8px var(--neon-cyan)); }
    .nav-links { display: flex; gap: 28px; list-style: none; font-size: 15px; font-weight: 600; }
    .nav-links a { color: var(--text-muted); transition: color 0.2s; }
    .nav-links a:hover { color: var(--neon-cyan); }
    .btn-nav {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 800;
      padding: 10px 24px;
      border-radius: 999px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-nav:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }

    /* Hero */
    .hero {
      position: relative;
      border-radius: 28px;
      margin: 20px auto 70px;
      padding: 90px 48px;
      background: linear-gradient(135deg, rgba(0, 36, 36, 0.9) 0%, rgba(0, 16, 16, 0.95) 100%),
                  url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1600&q=80') center/cover;
      border: 1px solid var(--border-glass);
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0,0,0,0.6);
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
      margin-bottom: 24px;
    }
    .hero h1 {
      font-family: var(--font-heading);
      font-size: clamp(38px, 6vw, 68px);
      line-height: 1.08;
      font-weight: 900;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    .hero h1 .highlight {
      background: linear-gradient(90deg, #fff, var(--neon-cyan));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 0 0 30px rgba(0, 255, 255, 0.3);
    }
    .hero p {
      font-size: 18px;
      color: #cbd5e1;
      max-width: 620px;
      margin-bottom: 36px;
    }
    .hero-btns { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 48px; }
    .btn-primary {
      background: linear-gradient(135deg, var(--neon-cyan), #00e5ff);
      color: #000;
      font-weight: 900;
      font-size: 16px;
      padding: 16px 36px;
      border-radius: 999px;
      box-shadow: 0 0 25px var(--neon-glow);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
    }
    .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 0 40px var(--neon-cyan); }
    .btn-outline {
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-weight: 700;
      font-size: 16px;
      padding: 16px 32px;
      border-radius: 999px;
      backdrop-filter: blur(8px);
      transition: all 0.3s;
    }
    .btn-outline:hover { background: rgba(0, 255, 255, 0.15); border-color: var(--neon-cyan); }

    .hero-stats {
      display: grid;
      grid-template-columns: repeat(3, auto);
      gap: 36px;
      padding-top: 32px;
      border-top: 1px solid rgba(255,255,255,0.1);
      width: fit-content;
    }
    .hero-stat strong { display: block; font-size: 24px; font-weight: 900; color: var(--neon-cyan); font-family: var(--font-heading); }
    .hero-stat span { font-size: 13px; color: var(--text-muted); }

    /* Section Headers */
    .section-head { text-align: center; margin-bottom: 44px; }
    .section-head h2 { font-family: var(--font-heading); font-size: 34px; font-weight: 800; color: #fff; }
    .section-head p { color: var(--text-muted); font-size: 15px; margin-top: 6px; }

    /* Class Schedule */
    .schedule-tabs {
      display: flex;
      justify-content: center;
      gap: 8px;
      margin-bottom: 30px;
      overflow-x: auto;
      padding-bottom: 8px;
    }
    .tab-btn {
      background: var(--sky-surface);
      border: 1px solid var(--border-glass);
      color: var(--text-muted);
      font-weight: 700;
      padding: 10px 20px;
      border-radius: 999px;
      font-size: 14px;
      transition: all 0.2s;
    }
    .tab-btn.active, .tab-btn:hover {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px var(--neon-glow);
    }
    .schedule-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 20px;
      margin-bottom: 80px;
    }
    .class-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 18px;
      padding: 24px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: all 0.3s;
    }
    .class-card:hover {
      border-color: var(--neon-cyan);
      transform: translateY(-4px);
      box-shadow: 0 10px 30px rgba(0, 255, 255, 0.15);
    }
    .class-time {
      color: var(--neon-cyan);
      font-weight: 800;
      font-size: 14px;
      margin-bottom: 8px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .class-card h3 { font-family: var(--font-heading); font-size: 19px; color: #fff; margin-bottom: 12px; }
    .class-meta {
      display: flex;
      gap: 14px;
      font-size: 13px;
      color: var(--text-muted);
      margin-bottom: 20px;
    }
    .btn-book {
      background: rgba(0, 255, 255, 0.12);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      font-weight: 700;
      padding: 10px;
      border-radius: 10px;
      text-align: center;
      transition: all 0.2s;
    }
    .btn-book:hover { background: var(--neon-cyan); color: #000; box-shadow: 0 0 15px var(--neon-glow); }

    /* Programs Section */
    .programs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 24px;
      margin-bottom: 70px;
    }
    .program-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s ease;
      position: relative;
    }
    .program-card:hover {
      transform: translateY(-5px);
      border-color: var(--neon-cyan);
      box-shadow: 0 15px 35px rgba(0,0,0,0.5), 0 0 20px var(--neon-glow);
    }
    .program-img-box {
      height: 200px;
      position: relative;
      overflow: hidden;
      background: #002222;
    }
    .program-img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
      display: block;
    }
    .program-card:hover .program-img-box img { transform: scale(1.06); }
    .program-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: rgba(0, 20, 20, 0.85);
      border: 1px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 3px 10px;
      border-radius: 12px;
      font-size: 11px;
      font-weight: 700;
      z-index: 2;
      backdrop-filter: blur(4px);
    }
    .program-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .program-body h3 {
      font-family: var(--font-heading);
      font-size: 19px;
      color: #fff;
      margin-bottom: 8px;
    }
    .program-body p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.5;
      margin-bottom: 16px;
      flex: 1;
    }
    .program-meta {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      color: var(--electric-lime);
      font-weight: 600;
      margin-bottom: 14px;
      padding-bottom: 12px;
      border-bottom: 1px solid rgba(0,255,255,0.1);
    }
    .program-bottom {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
    }
    .program-price {
      font-size: 20px;
      font-weight: 800;
      color: #fff;
    }
    .program-price span {
      font-size: 13px;
      color: var(--neon-cyan);
    }
    .btn-program-join {
      background: linear-gradient(135deg, var(--neon-cyan) 0%, #00b4d8 100%);
      color: #001a1a;
      font-weight: 800;
      font-size: 13px;
      padding: 9px 18px;
      border-radius: 8px;
      transition: all 0.2s;
    }
    .btn-program-join:hover {
      box-shadow: 0 0 15px var(--neon-glow);
      transform: translateY(-2px);
    }

    /* Membership Plans */
    .billing-toggle-wrap {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 12px;
      margin-bottom: 40px;
    }
    .toggle-label { font-size: 15px; font-weight: 700; color: var(--text-muted); cursor: pointer; }
    .toggle-label.active { color: var(--neon-cyan); }
    .switch {
      position: relative;
      display: inline-block;
      width: 52px;
      height: 28px;
    }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider {
      position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
      background: #003636;
      border: 1px solid var(--border-glass);
      transition: .3s;
      border-radius: 34px;
    }
    .slider:before {
      position: absolute; content: ""; height: 20px; width: 20px; left: 4px; bottom: 3px;
      background: var(--neon-cyan);
      transition: .3s;
      border-radius: 50%;
      box-shadow: 0 0 10px var(--neon-cyan);
    }
    input:checked + .slider { background: #004d4d; }
    input:checked + .slider:before { transform: translateX(24px); }

    .plans-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
      align-items: stretch;
      margin-bottom: 80px;
    }
    .plan-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 36px 28px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all 0.3s;
    }
    .plan-card.featured {
      background: linear-gradient(180deg, #003b3b 0%, #002222 100%);
      border-color: var(--neon-cyan);
      transform: scale(1.04);
      box-shadow: 0 15px 40px rgba(0, 255, 255, 0.2);
    }
    .plan-tag {
      position: absolute;
      top: -14px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--neon-cyan);
      color: #000;
      font-weight: 900;
      font-size: 11px;
      letter-spacing: 1px;
      padding: 4px 14px;
      border-radius: 999px;
      box-shadow: 0 0 15px var(--neon-glow);
    }
    .plan-name { font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .plan-price-wrap { margin: 16px 0 24px; display: flex; align-items: baseline; gap: 4px; }
    .plan-price { font-size: 44px; font-weight: 900; color: #fff; font-family: var(--font-heading); }
    .plan-period { color: var(--text-muted); font-size: 14px; }
    .plan-features { list-style: none; margin-bottom: 32px; flex: 1; display: flex; flex-direction: column; gap: 12px; }
    .plan-features li { display: flex; align-items: center; gap: 10px; font-size: 14px; color: #cbd5e1; }
    .plan-features svg { color: var(--electric-lime); flex-shrink: 0; }
    .btn-plan {
      background: rgba(255,255,255,0.08);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-weight: 800;
      padding: 14px;
      border-radius: 12px;
      text-align: center;
      transition: all 0.2s;
    }
    .plan-card.featured .btn-plan, .btn-plan:hover {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 20px var(--neon-glow);
    }

    /* Trainers */
    .trainers-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 24px;
      margin-bottom: 80px;
    }
    .trainer-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.3s;
    }
    .trainer-card:hover {
      transform: translateY(-6px);
      border-color: var(--neon-cyan);
      box-shadow: 0 12px 30px rgba(0, 255, 255, 0.15);
    }
    .trainer-img { width: 100%; height: 290px; object-fit: cover; }
    .trainer-info { padding: 20px; }
    .trainer-name { font-family: var(--font-heading); font-size: 18px; font-weight: 800; color: #fff; }
    .trainer-role { font-size: 13px; color: var(--neon-cyan); font-weight: 600; margin-top: 4px; }
    .trainer-cert { font-size: 12px; color: var(--text-muted); margin-top: 6px; }

    /* Gallery */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 80px;
    }
    .gallery-item {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      height: 220px;
      border: 1px solid var(--border-glass);
    }
    .gallery-item:first-child { grid-column: span 2; }
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s;
    }
    .gallery-item:hover img { transform: scale(1.08); }

    /* Form Section */
    .join-section {
      background: linear-gradient(135deg, #002b2b 0%, #001919 100%);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 48px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
      margin-bottom: 80px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .join-form { display: flex; flex-direction: column; gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 13px; font-weight: 700; color: #cbd5e1; }
    .form-group input, .form-group select {
      background: rgba(0, 18, 18, 0.7);
      border: 1px solid var(--border-glass);
      padding: 12px 16px;
      border-radius: 10px;
      color: #fff;
      font-family: inherit;
      outline: none;
      transition: all 0.2s;
    }
    .form-group input:focus, .form-group select:focus {
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
    }
    .btn-submit {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 900;
      padding: 14px;
      border-radius: 12px;
      margin-top: 10px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

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
      background: #001212;
      border-top: 1px solid var(--border-glass);
      padding: 40px 24px 24px;
      text-align: center;
    }
    footer p { color: var(--text-muted); font-size: 13px; margin-bottom: 6px; }

    @media (max-width: 900px) {
      .nav-links { display: none; }
      .hero { padding: 48px 24px; }
      .hero-stats { grid-template-columns: 1fr; gap: 16px; }
      .plans-grid { grid-template-columns: 1fr; }
      .plan-card.featured { transform: none; }
      .join-section { grid-template-columns: 1fr; padding: 28px 20px; }
      .gallery-grid { grid-template-columns: 1fr 1fr; }
      .gallery-item:first-child { grid-column: span 1; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="fitness" data-dk-accent="#c084fc" data-dk-phone="994503936998" data-dk-sticky data-dk-action="submitTrial" data-dk-sticky-label="Üzvlük">
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
        <path d="M6 5v14M18 5v14M2 9h4M18 9h4M2 15h4M18 15h4M6 12h12"/>
      </svg>
      <?= e($t['brand_name']) ?>
    </a>
    <ul class="nav-links">
      <li><a href="#schedule"><?= e($t['nav_schedule']) ?></a></li>
      <li><a href="#programs"><?= e($lang === 'az' ? 'Proqramlar' : ($lang === 'ru' ? 'Программы' : ($lang === 'tr' ? 'Programlar' : 'Programs'))) ?></a></li>
      <li><a href="#plans"><?= e($t['nav_plans']) ?></a></li>
      <li><a href="#trainers"><?= e($t['nav_trainers']) ?></a></li>
      <li><a href="#gallery"><?= e($t['nav_gallery']) ?></a></li>
    </ul>
    <a href="#join" class="btn-nav"><?= e($t['nav_join']) ?></a>
  </header>

  <main class="container">
    <!-- Hero -->
    <section class="hero">
      <span class="hero-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <?= e($t['hero_badge']) ?>
      </span>
      <h1><?= e($t['hero_title_1']) ?><br><span class="highlight"><?= e($t['hero_title_2']) ?></span></h1>
      <p><?= e($t['hero_desc']) ?></p>

      <div class="hero-btns">
        <a href="#join" class="btn-primary">
          <?= e($t['hero_cta']) ?>
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
        <a href="#gallery" class="btn-outline"><?= e($t['hero_watch']) ?></a>
      </div>

      <div class="hero-stats">
        <div class="hero-stat">
          <strong><?= e($t['stat_members']) ?></strong>
          <span>Baku Club Members</span>
        </div>
        <div class="hero-stat">
          <strong><?= e($t['stat_trainers']) ?></strong>
          <span>International Pros</span>
        </div>
        <div class="hero-stat">
          <strong><?= e($t['stat_classes']) ?></strong>
          <span>Every Single Week</span>
        </div>
      </div>
    </section>

    <!-- Schedule Section -->
    <section id="schedule">
      <div class="section-head">
        <h2><?= e($t['schedule_title']) ?></h2>
        <p><?= e($t['schedule_sub']) ?></p>
      </div>

      <div class="schedule-tabs">
        <button class="tab-btn active" data-day="all"><?= e($t['day_mon']) ?> - <?= e($t['day_sat']) ?></button>
        <button class="tab-btn" data-day="mon"><?= e($t['day_mon']) ?></button>
        <button class="tab-btn" data-day="tue"><?= e($t['day_tue']) ?></button>
        <button class="tab-btn" data-day="wed"><?= e($t['day_wed']) ?></button>
        <button class="tab-btn" data-day="thu"><?= e($t['day_thu']) ?></button>
        <button class="tab-btn" data-day="fri"><?= e($t['day_fri']) ?></button>
      </div>

      <div class="schedule-grid" id="scheduleGrid">
        <?php foreach ($classes as $c): ?>
          <div class="class-card" data-day="<?= e($c['day']) ?>">
            <div>
              <div class="class-time">
                <span><?= e($c['time']) ?></span>
                <span style="font-size:12px; background:rgba(0,255,255,0.1); padding:2px 8px; border-radius:6px;"><?= e($c['diff']) ?></span>
              </div>
              <h3><?= e($c['title']) ?></h3>
              <div class="class-meta">
                <span>🥋 <?= e($c['coach']) ?></span>
                <span>📍 <?= e($c['room']) ?></span>
                <span>🔥 <?= e($c['burn']) ?></span>
              </div>
            </div>
            <button class="btn-book" onclick="bookClass('<?= e(addslashes($c['title'])) ?>')"><?= e($t['book_class']) ?></button>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Training Programs Section -->
    <section id="programs">
      <div class="section-head">
        <h2><?= e($lang === 'az' ? 'İxtisaslaşmış Məşq Proqramları' : ($lang === 'ru' ? 'Специализированные тренировочные программы' : ($lang === 'tr' ? 'Özel Antrenman Programları' : 'Signature Training Programs'))) ?></h2>
        <p><?= e($lang === 'az' ? 'Peşəkar baş məşqçilərimizlə hədəfinizə uyğun intensiv transformasiya kursları' : ($lang === 'ru' ? 'Интенсивные курсы трансформации тела с нашими лучшими тренерами' : ($lang === 'tr' ? 'Şampiyon eğitmenlerimizle hedefinize uygun yoğun dönüşüm kursları' : 'Intensive body-transformation courses designed by our elite coaching team'))) ?></p>
      </div>

      <div class="programs-grid">
        <?php foreach ($programs as $p): ?>
          <?php
            $pTitle = $p['title'][$lang] ?? $p['title']['az'];
            $pDesc = $p['desc'][$lang] ?? $p['desc']['az'];
          ?>
          <div class="program-card">
            <div class="program-img-box">
              <span class="program-badge"><?= e($p['badge']) ?></span>
              <img src="<?= e($p['img']) ?>" alt="<?= e($pTitle) ?>" loading="lazy">
            </div>
            <div class="program-body">
              <h3><?= e($pTitle) ?></h3>
              <p><?= e($pDesc) ?></p>
              <div class="program-meta">
                <span>⏱️ <?= e($p['duration']) ?></span>
                <span>🥋 <?= e($p['coach']) ?></span>
              </div>
              <div class="program-bottom">
                <div class="program-price"><?= e($p['price']) ?> <span><?= e($p['period'] ?? '') ?></span></div>
                <div style="display:flex; gap:8px;">
                  <button type="button" class="btn-program-video" style="background:rgba(0,255,255,0.08); border:1px solid var(--neon-cyan); color:var(--neon-cyan); border-radius:8px; padding:6px 12px; font-weight:700; font-size:12px; display:inline-flex; align-items:center; gap:4px; cursor:pointer;" onclick="openFitnessVideo('<?= e(addslashes($pTitle)) ?>', '../../assets/videos/demo3.mp4')">
                    ▶ Video
                  </button>
                  <button class="btn-program-join" onclick="bookClass('<?= e(addslashes($pTitle)) ?>')">
                    <?= e($lang === 'az' ? 'Proqrama Qoşul' : ($lang === 'ru' ? 'Записаться на курс' : ($lang === 'tr' ? 'Programa Katıl' : 'Join Program'))) ?>
                  </button>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Plans Section -->
    <section id="plans">
      <div class="section-head">
        <h2><?= e($t['plans_title']) ?></h2>
        <p><?= e($t['plans_sub']) ?></p>
      </div>

      <div class="billing-toggle-wrap">
        <span class="toggle-label active" id="labelMonthly"><?= e($t['billing_monthly']) ?></span>
        <label class="switch">
          <input type="checkbox" id="billingToggle">
          <span class="slider"></span>
        </label>
        <span class="toggle-label" id="labelAnnual"><?= e($t['billing_annual']) ?></span>
      </div>

      <div class="plans-grid">
        <!-- Bronze -->
        <div class="plan-card">
          <div class="plan-name"><?= e($t['plan_bronze']) ?></div>
          <div class="plan-price-wrap">
            <span class="plan-price" data-monthly="49" data-annual="39">49</span> ₼
            <span class="plan-period"><?= e($t['per_month']) ?></span>
          </div>
          <ul class="plan-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_gym_access']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_locker']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_sauna']) ?></li>
          </ul>
          <a href="#join" class="btn-plan"><?= e($t['choose_plan']) ?></a>
        </div>

        <!-- Silver (Featured) -->
        <div class="plan-card featured">
          <span class="plan-tag"><?= e($t['plan_popular']) ?></span>
          <div class="plan-name"><?= e($t['plan_silver']) ?></div>
          <div class="plan-price-wrap">
            <span class="plan-price" data-monthly="89" data-annual="69" style="color:var(--neon-cyan);">89</span> ₼
            <span class="plan-period"><?= e($t['per_month']) ?></span>
          </div>
          <ul class="plan-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_gym_access']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_all_classes']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_sauna']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_inbody']) ?></li>
          </ul>
          <a href="#join" class="btn-plan"><?= e($t['choose_plan']) ?></a>
        </div>

        <!-- Gold VIP -->
        <div class="plan-card">
          <div class="plan-name"><?= e($t['plan_gold']) ?></div>
          <div class="plan-price-wrap">
            <span class="plan-price" data-monthly="159" data-annual="119">159</span> ₼
            <span class="plan-period"><?= e($t['per_month']) ?></span>
          </div>
          <ul class="plan-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_all_classes']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_pt']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_nutrition']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['feat_vip_lounge']) ?></li>
          </ul>
          <a href="#join" class="btn-plan"><?= e($t['choose_plan']) ?></a>
        </div>
      </div>
    </section>

    <!-- Trainers -->
    <section id="trainers">
      <div class="section-head">
        <h2><?= e($t['trainers_title']) ?></h2>
        <p><?= e($t['trainers_sub']) ?></p>
      </div>
      <div class="trainers-grid">
        <?php foreach ($trainers as $tr): ?>
          <div class="trainer-card">
            <img src="<?= e($tr['img']) ?>" class="trainer-img" alt="<?= e($tr['name']) ?>">
            <div class="trainer-info">
              <h3 class="trainer-name"><?= e($tr['name']) ?></h3>
              <div class="trainer-role"><?= e($tr['role'][$lang] ?? $tr['role']['az']) ?></div>
              <div class="trainer-cert"><?= e($tr['cert']) ?> &bull; <?= e($tr['exp']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Gallery -->
    <section id="gallery">
      <div class="section-head">
        <h2><?= e($t['gallery_title']) ?></h2>
        <p><?= e($t['gallery_sub']) ?></p>
      </div>
      <div class="gallery-grid">
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1540497077202-7c8a3999166f?w=800&q=80" alt="Gym Arena">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=600&q=80" alt="Weights Zone">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?w=600&q=80" alt="CrossFit">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&q=80" alt="Yoga Studio">
        </div>
        <div class="gallery-item">
          <img src="https://images.unsplash.com/photo-1599447421416-3414500d18a5?w=600&q=80" alt="Sauna">
        </div>
      </div>
    </section>

    <!-- Join Form -->
    <section id="join" class="join-section">
      <div>
        <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:900; margin-bottom:12px;"><?= e($t['form_title']) ?></h2>
        <p style="color:var(--text-muted); font-size:15px; margin-bottom:28px;"><?= e($t['form_sub']) ?></p>
        <div style="display:flex; flex-direction:column; gap:14px; font-size:14px; color:#cbd5e1;">
          <div style="display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Heç bir öhdəlik yoxdur — ilk gün tamamilə pulsuzdur</span>
          </div>
          <div style="display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Peşəkar məşqçi ilə 30 dəqiqə bədən analizi və konsultasiya</span>
          </div>
        </div>
      </div>

      <form class="join-form" onsubmit="event.preventDefault(); submitTrial();">
        <div class="form-group">
          <label><?= e($t['form_name']) ?></label>
          <input type="text" required placeholder="Məsələn: Orxan Quliyev">
        </div>
        <div class="form-group">
          <label><?= e($t['form_phone']) ?></label>
          <input type="tel" required placeholder="+994 50 123 45 67">
        </div>
        <div class="form-group">
          <label><?= e($t['form_goal']) ?></label>
          <select>
            <option><?= e($t['goal_weight']) ?></option>
            <option><?= e($t['goal_muscle']) ?></option>
            <option><?= e($t['goal_stamina']) ?></option>
          </select>
        </div>
        <div class="form-group">
          <label><?= e($t['form_time']) ?></label>
          <select>
            <option><?= e($t['time_morning']) ?></option>
            <option><?= e($t['time_afternoon']) ?></option>
            <option><?= e($t['time_evening']) ?></option>
          </select>
        </div>
        <button type="submit" class="btn-submit"><?= e($t['form_submit']) ?></button>
      </form>
    </section>
  </main>

  <!-- Fitness Video Preview Modal -->
  <div class="modal-overlay" id="fitnessVideoModal" style="position:fixed; inset:0; background:rgba(0,0,0,0.85); backdrop-filter:blur(10px); z-index:99999; display:none; align-items:center; justify-content:center; padding:20px;" onclick="if(event.target===this)closeFitnessVideo()">
    <div style="background:linear-gradient(160deg, #002828 0%, #001818 100%); border:1px solid rgba(0,255,255,0.3); border-radius:18px; width:100%; max-width:700px; overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,0.8);">
      <div style="padding:14px 20px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid rgba(0,255,255,0.15);">
        <h3 id="fitVideoTitle" style="font-size:16px; color:#fff; font-family:var(--font-heading);"><?= e($t['video_modal_title']) ?></h3>
        <button style="background:none; border:none; color:#fff; font-size:24px; cursor:pointer;" onclick="closeFitnessVideo()">&times;</button>
      </div>
      <div style="width:100%; height:360px; background:#000;">
        <video id="fitVideoPlayer" controls playsinline style="width:100%; height:100%; object-fit:cover; display:block;">
          <source src="" type="video/mp4">
        </video>
      </div>
    </div>
  </div>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/994503936998?text=Salam,%20ApexFit%20abunəliyi%20haqqında%20məlumat%20almaq%20istəyirəm" target="_blank" class="float-wa" title="WhatsApp">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/>
    </svg>
  </a>

  <!-- Footer -->
  <footer>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Created with passion by <span style="color:var(--neon-cyan); font-weight:700;">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    // Tab filtering for classes
    document.querySelectorAll('.tab-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const day = btn.dataset.day;
        document.querySelectorAll('.class-card').forEach(card => {
          if (day === 'all' || card.dataset.day === day) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });

    // Billing toggle
    const toggle = document.getElementById('billingToggle');
    const labelMonthly = document.getElementById('labelMonthly');
    const labelAnnual = document.getElementById('labelAnnual');
    toggle.addEventListener('change', () => {
      const isAnnual = toggle.checked;
      labelMonthly.classList.toggle('active', !isAnnual);
      labelAnnual.classList.toggle('active', isAnnual);
      document.querySelectorAll('.plan-price').forEach(el => {
        el.textContent = isAnnual ? el.dataset.annual : el.dataset.monthly;
      });
    });

    const FIT_SLOTS = ['07:00', '09:00', '11:00', '17:00', '19:00', '21:00'];

    function bookClass(name) {
      DK.sheet({
        eyebrow: DK.pick('QRUP DƏRSİ', 'GROUP CLASS', 'ГРУППОВОЕ ЗАНЯТИЕ', 'GRUP DERSİ'),
        title: DK.pick('Dərsə yazıl', 'Book a class', 'Записаться на занятие', 'Derse kaydol'),
        sub: DK.pick('Yerini indi ayır — hər qrupda maksimum 12 nəfər.',
                    'Reserve your spot — max 12 people per group.',
                    'Забронируйте место — максимум 12 человек в группе.',
                    'Yerini hemen ayır — grupta en fazla 12 kişi.'),
        submitText: DK.pick('Yerini tut', 'Reserve my spot', 'Забронировать место', 'Yerimi ayır'),
        submitIcon: '💬',
        fields: [
          { name: 'klass', label: DK.pick('Dərs / proqram', 'Class / program', 'Занятие / программа', 'Ders / program'), required: true, value: name || '' },
          { name: 'date', label: DK.t.date, type: 'date', min: new Date().toISOString().slice(0, 10), required: true },
          { name: 'time', label: DK.t.time, type: 'select', required: true, options: FIT_SLOTS },
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast(DK.pick('Yerin ayrıldı — WhatsApp açılır', 'Spot reserved — opening WhatsApp',
          'Место забронировано — открываем WhatsApp', 'Yerin ayrıldı — WhatsApp açılıyor'));
        DK.wa('Salam! FitZone dərs qeydiyyatı:\nDərs: ' + d.klass +
          '\nTarix: ' + d.date + ' ' + d.time +
          '\nAd: ' + d.name + '\nTel: +994 ' + DK.fmtPhone(d.phone));
      });
    }

    function openFitnessVideo(title, src) {
      document.getElementById('fitVideoTitle').innerText = title + '<?= e(addslashes($t['video_title_suffix'])) ?>';
      const vid = document.getElementById('fitVideoPlayer');
      vid.src = src;
      const modal = document.getElementById('fitnessVideoModal');
      modal.style.display = 'flex';
      vid.play().catch(e => {});
    }

    function closeFitnessVideo() {
      const vid = document.getElementById('fitVideoPlayer');
      if (vid) vid.pause();
      document.getElementById('fitnessVideoModal').style.display = 'none';
    }

    function submitTrial() {
      DK.sheet({
        eyebrow: DK.pick('PULSUZ SINAQ GÜNÜ', 'FREE TRIAL DAY', 'БЕСПЛАТНЫЙ ПРОБНЫЙ ДЕНЬ', 'ÜCRETSİZ DENEME GÜNÜ'),
        title: DK.pick('Pulsuz sınaq keçidi', 'Get your free trial pass', 'Получить бесплатный пропуск', 'Ücretsiz deneme pası al'),
        sub: DK.pick('İlk gün tamamilə pulsuzdur — heç bir öhdəlik yoxdur.',
                    'Your first day is free — no commitment at all.',
                    'Первый день полностью бесплатен — без обязательств.',
                    'İlk gün tamamen ücretsiz — hiçbir taahhüt yok.'),
        submitText: DK.pick('Keçidi təsdiqlə', 'Confirm my pass', 'Подтвердить пропуск', 'Pasımı onayla'),
        submitIcon: '💬',
        fields: [
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'goal', label: DK.pick('Məqsəd', 'Goal', 'Цель', 'Hedef'), type: 'select', required: true,
            options: [DK.pick('Arıqlama', 'Weight loss', 'Похудение', 'Kilo verme'),
                      DK.pick('Əzələ yığımı', 'Muscle gain', 'Набор массы', 'Kas kazanımı'),
                      DK.pick('Dözümlülük', 'Stamina', 'Выносливость', 'Dayanıklılık')] },
          { name: 'time', label: DK.pick('Vaxt', 'Preferred time', 'Удобное время', 'Tercih edilen saat'), type: 'select', required: true,
            options: [DK.pick('Səhər', 'Morning', 'Утро', 'Sabah'),
                      DK.pick('Günorta', 'Afternoon', 'День', 'Öğlen'),
                      DK.pick('Axşam', 'Evening', 'Вечер', 'Akşam')] }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast(DK.pick('Sınaq keçidin hazırdır!', 'Your trial pass is ready!',
          'Ваш пропуск готов!', 'Deneme pasınız hazırdır!'));
        DK.wa('Salam! FitZone pulsuz sınaq günü:\nAd: ' + d.name +
          '\nTel: +994 ' + DK.fmtPhone(d.phone) + '\nMəqsəd: ' + d.goal + '\nVaxt: ' + d.time);
      });
    }
  </script>
</body>
</html>
