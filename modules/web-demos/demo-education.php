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
        'brand_name' => 'EduVerse',
        'brand_tag' => 'Müasir Texnologiya & Karyera Akademiyası',
        'nav_courses' => 'Kurslar',
        'nav_mentors' => 'Təlimçilər',
        'nav_pricing' => 'Qiymətlər',
        'nav_reviews' => 'Rəylər',
        'nav_enroll' => 'Dərsə Başla',
        'hero_badge' => '2026-CI İLİN ƏN ÇOX TƏLƏB OLUNAN İT İXTİSASLARI',
        'hero_title_1' => 'Gələcəyin Bacarıqlarını',
        'hero_title_2' => 'Bu Gün Mənimsəyin',
        'hero_desc' => 'Təcrübəli sənaye mütəxəssislərindən real layihələr üzərində öyrənin. Beynəlxalq sertifikat və karyera zəmanəti.',
        'hero_cta' => 'Bütün Kursları Kəşf Et',
        'hero_trial' => 'Ödənişsiz Sınaq Dərsi',
        'stat_students' => '4,500+ Məzun',
        'stat_rating' => '4.9/5 Tələbə Reytinqi',
        'stat_hired' => '88% Karyera Uğuru',
        'cat_all' => 'Hamısı',
        'cat_dev' => 'Proqramlaşdırma',
        'cat_design' => 'UI/UX Dizayn',
        'cat_data' => 'Süni İntellekt & Data',
        'cat_marketing' => 'Rəqəmsal Marketinq',
        'courses_title' => 'Populyar Tədris Proqramları',
        'courses_sub' => 'Sıfırdan junior və middle səviyyəsinə qədər praktiki dərslər.',
        'lessons_count' => 'Dərs',
        'hours_count' => 'Saat',
        'level_all' => 'Sıfırdan Başlayanlar',
        'btn_preview' => 'Video İcmal',
        'btn_enroll' => 'Qeydiyyatdan Keç',
        'mentors_title' => 'Təcrübəli Təlimçilərimiz',
        'mentors_sub' => 'Aparıcı texnologiya şirkətlərində çalışan aparıcı mentorlar.',
        'pricing_title' => 'Tədris Paketləri',
        'pricing_sub' => 'Hədəflərinizə uyğun təhsil formatını seçin.',
        'plan_standard' => 'Standart Kurs',
        'plan_bootcamp' => 'Karyera Bootcamp',
        'plan_vip' => '1-on-1 Mentorluq',
        'plan_best' => 'ƏN POPULYAR',
        'plan_choose' => 'Müraciət Et',
        'reviews_title' => 'Tələbələrimizin Uğur Hekayələri',
        'reviews_sub' => 'Məzunlarımız hazırda harada çalışırlar?',
        'form_title' => 'Təhsil Məsləhətçisi ilə Əlaqə',
        'form_sub' => 'Hansı sahənin sizə uyğun olduğunu bilmirsiniz? Məlumatlarınızı yazın, pulsuz istiqamətləndirək.',
        'form_name' => 'Adınız və Soyadınız',
        'form_phone' => 'Telefon Nömrəniz',
        'form_course' => 'Maraqlandığınız Sahə',
        'form_submit' => 'Pulsuz Konsultasiya Al',
        'form_success' => 'Müraciətiniz qəbul olundu! Təhsil koordinatorumuz 15 dəqiqəyə zəng edəcək.',
        'modal_title' => 'Kursun Video İcmalı',
        'modal_syllabus' => 'Proqram Silabusu:',
        'modal_close' => 'Bağla',
        'modal_join' => 'Bu Kursa Qeydiyyat',
        'wa_consult' => 'WhatsApp Məsləhət',
        'plan_feat_mentor' => 'Canlı mentor sessiyaları və tapşırıq analizi',
        'plan_feat_portfolio' => 'Portfelio üçün 4 real kommersiya layihəsi',
        'plan_feat_intern' => 'Aparıcı İT şirkətlərində təcrübə zəmanəti',
        'plan_feat_cv' => 'CV və LinkedIn profil optimizasiyası',
        'plan_feat_vip_hours' => 'Fərdi təlimçi ilə 24 saat canlı dərs',
        'plan_feat_vip_feedback' => 'Sürətli kod yoxlanışı və gündəlik feedback',
        'plan_feat_vip_rec' => 'Xarici şirkətlərə birbaşa tövsiyə məktubu',
        'rev_1_text' => '"React və Node.js kursundan sonra 3 ay ərzində junior developer olaraq bank sektorunda ilk işimi tapdım. Mentorların dəstəyi inanılmaz idi!"',
        'rev_2_text' => '"UI/UX kursu təkcə dizayn alətlərini deyil, həm də biznes düşüncəsini və istifadəçi psixologiyasını öyrətdi. Hazırda Upwork-də uğurla fəaliyyət göstərirəm."',
        'rev_3_text' => '"Python və Data Science proqramı sayəsində sıfırdan maşın öyrənməsi modelləri qurmağı öyrəndim. Müasir AI kitabxanaları ilə işləmək böyük üstünlükdür."',
        'stat_lbl_graduates' => 'Məzunlar',
        'stat_lbl_satisfaction' => 'Məmnuniyyət',
        'stat_lbl_employed' => 'İşə Qəbul',
        'footer_desc' => 'Bu veb-sayt onlayn təhsil platformaları, kurslar və təlim mərkəzləri üçün Skyweb tərəfindən hazırlanmış nümunədir.',
        'all_rights' => 'Bütün hüquqlar qorunur.',
    ],
    'en' => [
        'banner_text' => 'This is a demo website — Created by Skyweb',
        'back_to_sky' => 'Back to Skyweb',
        'brand_name' => 'EduVerse',
        'brand_tag' => 'Next-Gen Tech & Career Academy',
        'nav_courses' => 'Courses',
        'nav_mentors' => 'Mentors',
        'nav_pricing' => 'Pricing',
        'nav_reviews' => 'Stories',
        'nav_enroll' => 'Get Started',
        'hero_badge' => 'MOST IN-DEMAND TECH SKILLS OF 2026',
        'hero_title_1' => 'Master Future Skills.',
        'hero_title_2' => 'Accelerate Career.',
        'hero_desc' => 'Learn from leading industry practitioners through real-world hands-on projects. Recognized certificates & career support.',
        'hero_cta' => 'Explore All Courses',
        'hero_trial' => 'Free Trial Lesson',
        'stat_students' => '4,500+ Graduates',
        'stat_rating' => '4.9/5 Student Rating',
        'stat_hired' => '88% Hiring Rate',
        'cat_all' => 'All Programs',
        'cat_dev' => 'Development',
        'cat_design' => 'UI/UX Design',
        'cat_data' => 'AI & Data Science',
        'cat_marketing' => 'Digital Marketing',
        'courses_title' => 'Top Career Programs',
        'courses_sub' => 'Hands-on curriculum engineered from novice to industry-ready pro.',
        'lessons_count' => 'Lessons',
        'hours_count' => 'Hours',
        'level_all' => 'Beginner to Advanced',
        'btn_preview' => 'Video Preview',
        'btn_enroll' => 'Enroll Now',
        'mentors_title' => 'Learn From Top Practitioners',
        'mentors_sub' => 'Senior engineers & product designers from global tech hubs.',
        'pricing_title' => 'Tuition Plans',
        'pricing_sub' => 'Pick the optimal plan suited to your learning goals.',
        'plan_standard' => 'Single Course',
        'plan_bootcamp' => 'Career Bootcamp',
        'plan_vip' => '1-on-1 Mentorship',
        'plan_best' => 'MOST POPULAR',
        'plan_choose' => 'Enroll in Plan',
        'reviews_title' => 'Graduate Success Stories',
        'reviews_sub' => 'See where our alumni work after graduation.',
        'form_title' => 'Talk to an Academic Advisor',
        'form_sub' => 'Unsure which tech path fits your goals? Request a free consultation.',
        'form_name' => 'Full Name',
        'form_phone' => 'Phone Number',
        'form_course' => 'Interested Program',
        'form_submit' => 'Request Free Advice',
        'form_success' => 'Thank you! An academic coordinator will contact you in 15 minutes.',
        'modal_title' => 'Course Syllabus & Video Preview',
        'modal_syllabus' => 'Curriculum Breakdown:',
        'modal_close' => 'Close',
        'modal_join' => 'Enroll in this Program',
        'wa_consult' => 'WhatsApp Advice',
        'plan_feat_mentor' => 'Live mentor sessions & homework code review',
        'plan_feat_portfolio' => '4 commercial projects for your portfolio',
        'plan_feat_intern' => 'Internship guarantee at leading tech companies',
        'plan_feat_cv' => 'Career coaching & LinkedIn profile optimization',
        'plan_feat_vip_hours' => '24 hours of 1-on-1 private instruction',
        'plan_feat_vip_feedback' => 'Instant code reviews & daily feedback',
        'plan_feat_vip_rec' => 'Direct recommendation letter to global firms',
        'rev_1_text' => '"After the React and Node.js course, I landed my first junior developer role in the banking sector within 3 months. Incredible mentor support!"',
        'rev_2_text' => '"The UI/UX course taught not only design tools, but also business acumen and user psychology. Currently thriving on Upwork!"',
        'rev_3_text' => '"Thanks to Python and Data Science, I learned how to build machine learning models from scratch. Hands-on AI skills are a huge advantage."',
        'stat_lbl_graduates' => 'Graduates',
        'stat_lbl_satisfaction' => 'Satisfaction',
        'stat_lbl_employed' => 'Employed',
        'footer_desc' => 'This demo was created by Skyweb to demonstrate high-converting online academies & course portals.',
        'all_rights' => 'All rights reserved.',
    ],
    'tr' => [
        'banner_text' => 'Bu bir örnek sitedir — Skyweb tarafından hazırlanmıştır',
        'back_to_sky' => 'Skyweb\'e Dön',
        'brand_name' => 'EduVerse',
        'brand_tag' => 'Geleceğin Teknoloji & Kariyer Akademisi',
        'nav_courses' => 'Kurslar',
        'nav_mentors' => 'Eğitmenler',
        'nav_pricing' => 'Fiyatlar',
        'nav_reviews' => 'Yorumlar',
        'nav_enroll' => 'Hemen Başla',
        'hero_badge' => '2026\'NIN EN ÇOK ARANAN TEKNOLOJİ YETENEKLERİ',
        'hero_title_1' => 'Geleceğin Becerilerini',
        'hero_title_2' => 'Bugün Kazanın',
        'hero_desc' => 'Sektörün uzmanlarından canlı projeler üzerinde öğrenin. Uluslararası sertifika ve kariyer mentörlüğü desteği.',
        'hero_cta' => 'Kursları Keşfet',
        'hero_trial' => 'Ücretsiz Deneme Dersi',
        'stat_students' => '4,500+ Mezun',
        'stat_rating' => '4.9/5 Memnuniyet',
        'stat_hired' => '%88 İşe Yerleşme',
        'cat_all' => 'Tümü',
        'cat_dev' => 'Yazılım',
        'cat_design' => 'UI/UX Tasarım',
        'cat_data' => 'Yapay Zeka & Veri',
        'cat_marketing' => 'Dijital Pazarlama',
        'courses_title' => 'Popüler Eğitim Programları',
        'courses_sub' => 'Sıfırdan profesyonel seviyeye uygulamalı eğitim içeriği.',
        'lessons_count' => 'Ders',
        'hours_count' => 'Saat',
        'level_all' => 'Başlangıçtan İleriye',
        'btn_preview' => 'Video Önizleme',
        'btn_enroll' => 'Kursa Katıl',
        'mentors_title' => 'Alanında Uzman Eğitmenler',
        'mentors_sub' => 'Önde gelen teknoloji firmalarında aktif çalışan tecrübeli mentörler.',
        'pricing_title' => 'Eğitim Paketleri',
        'pricing_sub' => 'Kariyer hedeflerinize uygun eğitim planını belirleyin.',
        'plan_standard' => 'Tek Kurs',
        'plan_bootcamp' => 'Kariyer Kampı',
        'plan_vip' => 'Birebir Mentörlük',
        'plan_best' => 'EN ÇOK SEÇİLEN',
        'plan_choose' => 'Paketi Seç',
        'reviews_title' => 'Öğrenci Başarı Hikayeleri',
        'reviews_sub' => 'Mezunlarımız prestijli firmalarda kariyerlerine başladı.',
        'form_title' => 'Eğitim Danışmanımızla Görüşün',
        'form_sub' => 'Hangi alanın size uygun olduğunu birlikte belirleyelim.',
        'form_name' => 'Adınız Soyadınız',
        'form_phone' => 'Telefon Numaranız',
        'form_course' => 'İlgilendiğiniz Alan',
        'form_submit' => 'Ücretsiz Danışmanlık Al',
        'form_success' => 'Talebiniz alındı! Eğitim danışmanımız 15 dakika içinde arayacaktır.',
        'modal_title' => 'Kurs Tanıtımı ve Video İnceleme',
        'modal_syllabus' => 'Müfredat Başlıkları:',
        'modal_close' => 'Kapat',
        'modal_join' => 'Bu Kursa Kaydol',
        'wa_consult' => 'WhatsApp Danışman',
        'plan_feat_mentor' => 'Canlı mentör oturumları ve ödev analizi',
        'plan_feat_portfolio' => 'Portföyünüz için 4 gerçek ticari proje',
        'plan_feat_intern' => 'Önde gelen teknoloji firmalarında staj garantisi',
        'plan_feat_cv' => 'CV ve LinkedIn profil optimizasyonu',
        'plan_feat_vip_hours' => 'Birebir eğitmenle 24 saat canlı özel ders',
        'plan_feat_vip_feedback' => 'Hızlı kod inceleme ve günlük geri bildirim',
        'plan_feat_vip_rec' => 'Küresel şirketlere doğrudan referans mektubu',
        'rev_1_text' => '"React ve Node.js kursundan sonra 3 ay içinde bankacılık sektöründe junior yazılımcı olarak işe başladım. Mentör desteği harikaydı!"',
        'rev_2_text' => '"UI/UX kursu sadece araçları değil, iş mantığını ve kullanıcı psikolojisini de öğretti. Şu an Upwork\'te serbest tasarımcıyım."',
        'rev_3_text' => '"Python ve Veri Bilimi programı sayesinde sıfırdan makine öğrenimi modelleri kurmayı öğrendim. Modern AI kütüphaneleriyle çalışmak büyük avantaj."',
        'stat_lbl_graduates' => 'Mezun',
        'stat_lbl_satisfaction' => 'Memnuniyet',
        'stat_lbl_employed' => 'İstihdam',
        'footer_desc' => 'Bu demo, eğitim kurumları ve online akademi projeleri için Skyweb tarafından hazırlanmıştır.',
        'all_rights' => 'Tüm hakları saklıdır.',
    ],
    'ru' => [
        'banner_text' => 'Это демонстрационный сайт — Создан в Skyweb',
        'back_to_sky' => 'Назад в Skyweb',
        'brand_name' => 'EduVerse',
        'brand_tag' => 'Академия современных IT-профессий',
        'nav_courses' => 'Курсы',
        'nav_mentors' => 'Преподаватели',
        'nav_pricing' => 'Тарифы',
        'nav_reviews' => 'Отзывы',
        'nav_enroll' => 'Начать обучение',
        'hero_badge' => 'САМЫЕ ВОСТРЕБОВАННЫЕ НАВЫКИ 2026 ГОДА',
        'hero_title_1' => 'Освойте профессию',
        'hero_title_2' => 'будущего уже сегодня',
        'hero_desc' => 'Обучение на реальных проектах под руководством сеньор-разработчиков. Международный диплом и помощь в трудоустройстве.',
        'hero_cta' => 'Выбрать программу',
        'hero_trial' => 'Бесплатный урок',
        'stat_students' => '4,500+ Выпускников',
        'stat_rating' => '4.9/5 Оценка студентов',
        'stat_hired' => '88% Трудоустроены',
        'cat_all' => 'Все курсы',
        'cat_dev' => 'Программирование',
        'cat_design' => 'UI/UX Дизайн',
        'cat_data' => 'ИИ и Data Science',
        'cat_marketing' => 'Digital Маркетинг',
        'courses_title' => 'Популярные образовательные программы',
        'courses_sub' => 'От базовых основ до уверенного уровня Middle специалиста.',
        'lessons_count' => 'Уроков',
        'hours_count' => 'Часов практики',
        'level_all' => 'С нуля до профи',
        'btn_preview' => 'Превью курса',
        'btn_enroll' => 'Записаться на курс',
        'mentors_title' => 'Наши наставники',
        'mentors_sub' => 'Практикующие эксперты из крупнейших международных IT-компаний.',
        'pricing_title' => 'Тарифы на обучение',
        'pricing_sub' => 'Выберите подходящий формат обучения под ваш график.',
        'plan_standard' => 'Один курс',
        'plan_bootcamp' => 'Карьерный Буткемп',
        'plan_vip' => '1-на-1 с Ментором',
        'plan_best' => 'ПОПУЛЯРНЫЙ',
        'plan_choose' => 'Поступить на курс',
        'reviews_title' => 'Истории успеха студентов',
        'reviews_sub' => 'Где сегодня работают наши выпускники?',
        'form_title' => 'Консультация с куратором',
        'form_sub' => 'Не знаете, какое направление выбрать? Оставьте заявку, поможем определиться.',
        'form_name' => 'Ваше имя',
        'form_phone' => 'Номер телефона',
        'form_course' => 'Желаемый курс',
        'form_submit' => 'Получить консультацию',
        'form_success' => 'Заявка принята! Куратор свяжется с вами в течение 15 минут.',
        'modal_title' => 'Программа и видео-превью курса',
        'modal_syllabus' => 'Краткая программа модулей:',
        'modal_close' => 'Закрыть',
        'modal_join' => 'Забронировать место',
        'wa_consult' => 'Консультация в WhatsApp',
        'plan_feat_mentor' => 'Живые менторские сессии и ревью кода',
        'plan_feat_portfolio' => '4 реальных коммерческих проекта в портфолио',
        'plan_feat_intern' => 'Гарантия стажировки в ведущих IT-компаниях',
        'plan_feat_cv' => 'Оптимизация резюме и профиля в LinkedIn',
        'plan_feat_vip_hours' => '24 часа индивидуальных занятий с ментором',
        'plan_feat_vip_feedback' => 'Быстрое ревью кода и ежедневная обратная связь',
        'plan_feat_vip_rec' => 'Прямое рекомендательное письмо в международные компании',
        'rev_1_text' => '"После курса React и Node.js я за 3 месяца нашел свою первую работу junior разработчиком в банке. Поддержка менторов была невероятной!"',
        'rev_2_text' => '"Курс UI/UX научил не просто инструментам дизайна, а бизнес-мышлению и психологии пользователей. Сейчас успешно работаю на Upwork."',
        'rev_3_text' => '"Благодаря программе по Python и Data Science я с нуля научился строить модели машинного обучения. Работа с современными AI библиотеками — огромное преимущество."',
        'stat_lbl_graduates' => 'Выпускников',
        'stat_lbl_satisfaction' => 'Удовлетворенность',
        'stat_lbl_employed' => 'Трудоустроено',
        'footer_desc' => 'Данный демонстрационный сайт разработан Skyweb для онлайн-школ, учебных центров и академий.',
        'all_rights' => 'Все права защищены.',
    ],
];

$lang = current_lang();
$t = $demo_texts[$lang] ?? $demo_texts['az'];

$courses = [
    [
        'id' => 1,
        'cat' => 'dev',
        'title' => [
            'az' => 'Fullstack JavaScript & React/Node.js',
            'en' => 'Fullstack JavaScript: React & Node.js',
            'tr' => 'Fullstack JavaScript & Node.js Kampı',
            'ru' => 'Fullstack JavaScript: React и Node.js'
        ],
        'desc' => 'HTML, CSS, Modern JS, React 19, TypeScript, Node.js, Express, PostgreSQL & Docker.',
        'lessons' => 64,
        'hours' => 120,
        'price' => 380,
        'rating' => '4.95',
        'mentor' => 'Elmir Həsənov (Senior Lead)',
        'img' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=80',
        'video' => '../../assets/videos/demo2.mp4',
        'syllabus' => ['Modern JavaScript & ESNext', 'React & State Management (Zustand)', 'Backend APIs with Node & Express', 'Full Cloud Deployment & CI/CD']
    ],
    [
        'id' => 2,
        'cat' => 'design',
        'title' => [
            'az' => 'UI/UX & Məhsul Dizaynı (Figma to Web)',
            'en' => 'UI/UX & Digital Product Design',
            'tr' => 'UI/UX & Ürün Tasarımı (Figma)',
            'ru' => 'UI/UX и продуктовый дизайн в Figma'
        ],
        'desc' => 'İstifadəçi araşdırması, wireframing, prototipləmə, Figma Design System və mobil tətbiq dizaynı.',
        'lessons' => 48,
        'hours' => 90,
        'price' => 320,
        'rating' => '4.92',
        'mentor' => 'Nigar Qasımova (Product Designer)',
        'img' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=600&q=80',
        'video' => '../../assets/videos/demo1.mp4',
        'syllabus' => ['Design Thinking & User Research', 'Figma Mastery & Component Architecture', 'Interactive Prototyping & Micro-interactions', 'Design Systems for Scale']
    ],
    [
        'id' => 3,
        'cat' => 'data',
        'title' => [
            'az' => 'Süni İntellekt & Python Data Science',
            'en' => 'AI Engineering & Python Data Science',
            'tr' => 'Yapay Zeka & Python Veri Bilimi',
            'ru' => 'Инженерия ИИ и Data Science на Python'
        ],
        'desc' => 'Python, Pandas, Machine Learning, Deep Learning, LLM inteqrasiyaları və OpenAI API.',
        'lessons' => 56,
        'hours' => 110,
        'price' => 420,
        'rating' => '4.98',
        'mentor' => 'Fərid Rüstəmov (AI Researcher)',
        'img' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=600&q=80',
        'video' => '../../assets/videos/demo3.mp4',
        'syllabus' => ['Python Data Foundations', 'Statistical Modeling & Scikit-Learn', 'Neural Networks & PyTorch', 'Building LLM Apps with LangChain']
    ],
    [
        'id' => 4,
        'cat' => 'dev',
        'title' => [
            'az' => 'Mobil Tətbiq Hazırlanması (Flutter & Dart)',
            'en' => 'Mobile App Development with Flutter',
            'tr' => 'Flutter & Dart ile Mobil Uygulama',
            'ru' => 'Разработка мобильных приложений на Flutter'
        ],
        'desc' => 'iOS və Android üçün eyni kod bazası ilə müasir, yüksək performanslı mobil tətbiqlər yaradın.',
        'lessons' => 52,
        'hours' => 95,
        'price' => 350,
        'rating' => '4.89',
        'mentor' => 'Rəşad Nəsirov (Mobile Architect)',
        'img' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=600&q=80',
        'video' => '../../assets/videos/demo2.mp4',
        'syllabus' => ['Dart Programming & Flutter Widgets', 'State Management (Bloc & Riverpod)', 'Firebase Backend & Push Notifications', 'App Store & Google Play Publishing']
    ],
    [
        'id' => 5,
        'cat' => 'marketing',
        'title' => [
            'az' => 'Praktiki Rəqəmsal Marketinq & SMM Pro',
            'en' => 'Growth & Performance Marketing Pro',
            'tr' => 'Dijital Pazarlama & Performans Reklamcılığı',
            'ru' => 'Digital-маркетинг и Таргетированная реклама'
        ],
        'desc' => 'Meta Ads, Google Ads, TikTok Business, SEO optimizasiyası və qabaqcıl analitika sistemləri.',
        'lessons' => 40,
        'hours' => 75,
        'price' => 260,
        'rating' => '4.88',
        'mentor' => 'Günel İbrahimova (CMO)',
        'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&q=80',
        'video' => '../../assets/videos/demo3.mp4',
        'syllabus' => ['Meta Ads Architectures', 'Google Search & YouTube Campaigns', 'Conversion Rate Optimization (CRO)', 'Advanced Google Analytics 4']
    ],
    [
        'id' => 6,
        'cat' => 'data',
        'title' => [
            'az' => 'Kibertəhlükəsizlik & Ethical Hacking',
            'en' => 'Cybersecurity & Ethical Hacking',
            'tr' => 'Siber Güvenlik & Beyaz Şapkalı Hacker',
            'ru' => 'Кибербезопасность и этичный хакинг'
        ],
        'desc' => 'Şəbəkə təhlükəsizliyi, zəifliklərin aşkarlanması, penetrasiya testləri və təhlükəsizlik auditi.',
        'lessons' => 50,
        'hours' => 100,
        'price' => 390,
        'rating' => '4.94',
        'mentor' => 'Tural Vəliyev (Security Engineer)',
        'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=600&q=80',
        'video' => '../../assets/videos/demo4.mp4',
        'syllabus' => ['Linux & Network Fundamentals', 'Web Vulnerability Assessment (OWASP)', 'Penetration Testing with Kali Linux', 'Incident Response & Hardening']
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($t['brand_name']) ?> — <?= e($t['brand_tag']) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --sky-bg: #001a1a;
      --sky-card: #002727;
      --sky-card-hover: #003636;
      --neon-cyan: #00FFFF;
      --neon-glow: rgba(0, 255, 255, 0.35);
      --purple-accent: #8b5cf6;
      --amber: #f59e0b;
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
        radial-gradient(circle at 10% 20%, rgba(0, 255, 255, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 85% 70%, rgba(139, 92, 246, 0.08) 0%, transparent 45%);
      color: var(--text-main);
      font-family: var(--font-body);
      line-height: 1.6;
      overflow-x: hidden;
    }
    a { color: inherit; text-decoration: none; }
    button { font-family: inherit; cursor: pointer; border: none; }

    /* Top Skyweb Demo Bar */
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
      font-weight: 800;
      font-size: 26px;
      color: #fff;
    }
    .brand svg { color: var(--neon-cyan); filter: drop-shadow(0 0 8px var(--neon-cyan)); }
    .nav-menu { display: flex; gap: 28px; list-style: none; font-size: 15px; font-weight: 600; }
    .nav-menu a { color: var(--text-muted); transition: color 0.2s; }
    .nav-menu a:hover { color: var(--neon-cyan); }
    .btn-nav-enroll {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 800;
      padding: 10px 24px;
      border-radius: 999px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-nav-enroll:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    .container { max-width: 1240px; margin: 0 auto; padding: 0 24px; }

    /* Hero */
    .hero {
      margin: 20px auto 60px;
      background: linear-gradient(135deg, rgba(0, 36, 36, 0.85) 0%, rgba(0, 18, 18, 0.95) 100%);
      border: 1px solid var(--border-glass);
      border-radius: 28px;
      padding: 60px 48px;
      display: grid;
      grid-template-columns: 1.2fr 0.8fr;
      gap: 40px;
      align-items: center;
      box-shadow: 0 20px 50px rgba(0,0,0,0.5);
    }
    .hero-tag {
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
      font-size: clamp(34px, 5vw, 54px);
      line-height: 1.15;
      font-weight: 900;
      margin-bottom: 16px;
    }
    .hero h1 span {
      background: linear-gradient(90deg, #fff 0%, var(--neon-cyan) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .hero p { color: var(--text-muted); font-size: 16px; margin-bottom: 32px; max-width: 520px; }
    .hero-actions { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 40px; }
    .btn-hero-primary {
      background: linear-gradient(135deg, var(--neon-cyan), #00e5ff);
      color: #000;
      font-weight: 800;
      font-size: 15px;
      padding: 14px 32px;
      border-radius: 999px;
      box-shadow: 0 0 25px var(--neon-glow);
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s;
    }
    .btn-hero-primary:hover { transform: translateY(-3px); box-shadow: 0 0 35px var(--neon-cyan); }
    .btn-hero-outline {
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-weight: 700;
      padding: 14px 28px;
      border-radius: 999px;
      transition: all 0.3s;
    }
    .btn-hero-outline:hover { background: rgba(0,255,255,0.15); border-color: var(--neon-cyan); }

    .hero-stats {
      display: flex;
      gap: 28px;
      padding-top: 28px;
      border-top: 1px solid rgba(255,255,255,0.08);
    }
    .hero-stat-num { font-size: 22px; font-weight: 800; color: var(--neon-cyan); font-family: var(--font-heading); }
    .hero-stat-label { font-size: 13px; color: var(--text-muted); }

    .hero-video-card {
      position: relative;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid var(--border-glass);
      box-shadow: 0 15px 35px rgba(0,0,0,0.6);
      cursor: pointer;
    }
    .hero-video-card img { width: 100%; height: 320px; object-fit: cover; display: block; filter: brightness(0.85); transition: transform 0.4s; }
    .hero-video-card:hover img { transform: scale(1.05); }
    .play-btn-circle {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 68px;
      height: 68px;
      background: rgba(0, 255, 255, 0.9);
      color: #000;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 0 30px var(--neon-cyan);
      transition: all 0.3s;
    }
    .hero-video-card:hover .play-btn-circle { transform: translate(-50%, -50%) scale(1.15); }

    /* Section Head */
    .section-head { text-align: center; margin-bottom: 36px; }
    .section-head h2 { font-family: var(--font-heading); font-size: 32px; font-weight: 800; color: #fff; }
    .section-head p { color: var(--text-muted); font-size: 15px; margin-top: 4px; }

    /* Category Filter Tabs */
    .filter-tabs {
      display: flex;
      justify-content: center;
      gap: 10px;
      overflow-x: auto;
      padding-bottom: 10px;
      margin-bottom: 36px;
    }
    .tab-pill {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      color: var(--text-muted);
      padding: 10px 22px;
      border-radius: 999px;
      font-weight: 700;
      font-size: 14px;
      white-space: nowrap;
      transition: all 0.2s;
    }
    .tab-pill.active, .tab-pill:hover {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px var(--neon-glow);
    }

    /* Course Cards Grid */
    .courses-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 28px;
      margin-bottom: 80px;
    }
    .course-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 22px;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      transition: all 0.3s;
    }
    .course-card:hover {
      transform: translateY(-6px);
      border-color: var(--neon-cyan);
      box-shadow: 0 15px 35px rgba(0, 255, 255, 0.15);
    }
    .course-thumb {
      height: 190px;
      position: relative;
      overflow: hidden;
    }
    .course-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s;
    }
    .course-card:hover .course-thumb img { transform: scale(1.08); }
    .course-rating {
      position: absolute;
      bottom: 12px;
      left: 12px;
      background: rgba(0, 20, 20, 0.85);
      backdrop-filter: blur(8px);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-size: 13px;
      font-weight: 700;
      padding: 4px 10px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .course-rating svg { color: var(--amber); }

    .course-body { padding: 22px; display: flex; flex-direction: column; flex: 1; }
    .course-meta {
      display: flex;
      gap: 12px;
      font-size: 12px;
      color: var(--neon-cyan);
      font-weight: 700;
      margin-bottom: 10px;
    }
    .course-title {
      font-family: var(--font-heading);
      font-size: 18px;
      font-weight: 800;
      color: #fff;
      line-height: 1.35;
      margin-bottom: 10px;
    }
    .course-desc { font-size: 13px; color: var(--text-muted); margin-bottom: 16px; flex: 1; }
    .course-mentor {
      font-size: 13px;
      color: #cbd5e1;
      display: flex;
      align-items: center;
      gap: 6px;
      margin-bottom: 16px;
      padding-bottom: 14px;
      border-bottom: 1px solid rgba(255,255,255,0.06);
    }

    .course-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .course-price { font-size: 22px; font-weight: 800; color: #fff; font-family: var(--font-heading); }
    .course-btns { display: flex; gap: 8px; }
    .btn-preview-sm {
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-size: 13px;
      font-weight: 700;
      padding: 8px 14px;
      border-radius: 10px;
      transition: all 0.2s;
    }
    .btn-preview-sm:hover { border-color: var(--neon-cyan); color: var(--neon-cyan); }
    .btn-enroll-sm {
      background: var(--neon-cyan);
      color: #000;
      font-size: 13px;
      font-weight: 800;
      padding: 8px 16px;
      border-radius: 10px;
      box-shadow: 0 0 15px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-enroll-sm:hover { transform: translateY(-2px); box-shadow: 0 0 25px var(--neon-cyan); }

    /* Pricing Plans */
    .pricing-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
      margin-bottom: 80px;
    }
    .pricing-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 22px;
      padding: 36px 28px;
      display: flex;
      flex-direction: column;
      position: relative;
      transition: all 0.3s;
    }
    .pricing-card.featured {
      background: linear-gradient(180deg, #003636 0%, #002222 100%);
      border-color: var(--neon-cyan);
      box-shadow: 0 15px 40px rgba(0, 255, 255, 0.18);
    }
    .pricing-badge {
      position: absolute;
      top: -12px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--neon-cyan);
      color: #000;
      font-weight: 900;
      font-size: 11px;
      padding: 3px 12px;
      border-radius: 999px;
    }
    .pricing-card h3 { font-family: var(--font-heading); font-size: 22px; font-weight: 800; color: #fff; margin-bottom: 12px; }
    .price-num { font-size: 42px; font-weight: 900; color: #fff; font-family: var(--font-heading); margin-bottom: 24px; }
    .price-features { list-style: none; margin-bottom: 32px; flex: 1; display: flex; flex-direction: column; gap: 12px; }
    .price-features li { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #cbd5e1; }
    .price-features svg { color: var(--emerald); flex-shrink: 0; }
    .btn-plan {
      background: rgba(255,255,255,0.08);
      border: 1px solid var(--border-glass);
      color: #fff;
      font-weight: 800;
      padding: 12px;
      border-radius: 12px;
      text-align: center;
      transition: all 0.2s;
    }
    .pricing-card.featured .btn-plan, .btn-plan:hover {
      background: var(--neon-cyan);
      color: #000;
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px var(--neon-glow);
    }

    /* Reviews Section */
    .reviews-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-bottom: 80px;
    }
    .review-card {
      background: var(--sky-card);
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      padding: 28px;
    }
    .review-stars { color: var(--amber); margin-bottom: 12px; font-size: 14px; }
    .review-text { font-size: 14px; color: #cbd5e1; margin-bottom: 20px; font-style: italic; }
    .review-user { display: flex; align-items: center; gap: 12px; }
    .review-avatar { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
    .review-name { font-weight: 700; color: #fff; font-size: 14px; }
    .review-role { font-size: 12px; color: var(--neon-cyan); }

    /* Form Section */
    .enroll-section {
      background: linear-gradient(135deg, #002d2d 0%, #001919 100%);
      border: 1px solid var(--border-glass);
      border-radius: 24px;
      padding: 48px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
      margin-bottom: 80px;
    }
    .enroll-form { display: flex; flex-direction: column; gap: 16px; }
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
    }
    .form-group input:focus, .form-group select:focus {
      border-color: var(--neon-cyan);
      box-shadow: 0 0 15px rgba(0, 255, 255, 0.25);
    }
    .btn-submit-enroll {
      background: var(--neon-cyan);
      color: #000;
      font-weight: 900;
      padding: 14px;
      border-radius: 12px;
      margin-top: 10px;
      box-shadow: 0 0 20px var(--neon-glow);
      transition: all 0.2s;
    }
    .btn-submit-enroll:hover { transform: translateY(-2px); box-shadow: 0 0 30px var(--neon-cyan); }

    /* Video Preview Modal */
    .modal-overlay {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.8);
      backdrop-filter: blur(6px);
      z-index: 2000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .modal-overlay.active { display: flex; }
    .modal-box {
      background: #002424;
      border: 1px solid var(--border-glass);
      border-radius: 20px;
      max-width: 650px;
      width: 100%;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(0,0,0,0.8);
      position: relative;
    }
    .modal-header {
      padding: 20px 24px;
      border-bottom: 1px solid var(--border-glass);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .modal-close { background: none; color: #fff; font-size: 24px; }
    .modal-player-mockup {
      height: 260px;
      background: #001212;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .modal-player-mockup img { width: 100%; height: 100%; object-fit: cover; opacity: 0.6; }
    .modal-body { padding: 24px; }
    .modal-syllabus-list { margin: 12px 0 20px 18px; color: #cbd5e1; font-size: 14px; }
    .modal-syllabus-list li { margin-bottom: 6px; }

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
      background: #001111;
      border-top: 1px solid var(--border-glass);
      padding: 40px 24px 24px;
      text-align: center;
    }
    footer p { color: var(--text-muted); font-size: 13px; margin-bottom: 6px; }

    @media (max-width: 900px) {
      .nav-menu { display: none; }
      .hero { grid-template-columns: 1fr; padding: 32px 20px; }
      .hero-video-card { display: none; }
      .pricing-grid, .reviews-grid { grid-template-columns: 1fr; }
      .enroll-section { grid-template-columns: 1fr; padding: 28px 20px; }
    }
  </style>
  <link rel="stylesheet" href="assets/demo-kit.css">
  <?= render_i18n_script() ?>
  <script src="../../assets/js/sky-i18n.js?v=<?= time() ?>"></script>
  <!-- Favicon (inline SVG) -->
  <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='6 10 62 76'%3E%3Cdefs%3E%3ClinearGradient id='skySGradFav' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' stop-color='%2338bdf8'/%3E%3Cstop offset='100%25' stop-color='%230284c7'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cpath d='M12,74 L42,74 C50,74 54,70 54,64 C54,58 48,54 40,52 L26,48 C16,45 10,39 10,30 C10,20 18,14 30,14 L56,14 L52,22 L30,22 C26,22 22,25 22,30 C22,35 26,37 30,39 L44,43 C54,46 64,51 64,64 C64,75 56,82 43,82 L12,82 Z' fill='url(%23skySGradFav)'/%3E%3C/svg%3E">
</head>
<body data-dk-demo="education" data-dk-accent="#818cf8" data-dk-phone="994503936998" data-dk-sticky data-dk-action="submitEnroll" data-dk-sticky-label="Qeydiyyat">
  <script src="assets/demo-kit.js"></script>


  <!-- Skyweb Demo Top Bar -->
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
        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
      </svg>
      <?= e($t['brand_name']) ?>
    </a>
    <ul class="nav-menu">
      <li><a href="#courses"><?= e($t['nav_courses']) ?></a></li>
      <li><a href="#pricing"><?= e($t['nav_pricing']) ?></a></li>
      <li><a href="#reviews"><?= e($t['nav_reviews']) ?></a></li>
    </ul>
    <a href="#enroll" class="btn-nav-enroll"><?= e($t['nav_enroll']) ?></a>
  </header>

  <main class="container">
    <!-- Hero Section -->
    <section class="hero">
      <div>
        <span class="hero-tag">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
          <?= e($t['hero_badge']) ?>
        </span>
        <h1><?= e($t['hero_title_1']) ?><br><span><?= e($t['hero_title_2']) ?></span></h1>
        <p><?= e($t['hero_desc']) ?></p>

        <div class="hero-actions">
          <a href="#courses" class="btn-hero-primary">
            <?= e($t['hero_cta']) ?>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
          </a>
          <a href="#enroll" class="btn-hero-outline"><?= e($t['hero_trial']) ?></a>
        </div>

        <div class="hero-stats">
          <div>
            <div class="hero-stat-num"><?= e($t['stat_students']) ?></div>
            <div class="hero-stat-label"><?= e($t['stat_lbl_graduates']) ?></div>
          </div>
          <div>
            <div class="hero-stat-num"><?= e($t['stat_rating']) ?></div>
            <div class="hero-stat-label"><?= e($t['stat_lbl_satisfaction']) ?></div>
          </div>
          <div>
            <div class="hero-stat-num"><?= e($t['stat_hired']) ?></div>
            <div class="hero-stat-label"><?= e($t['stat_lbl_employed']) ?></div>
          </div>
        </div>
      </div>

      <div class="hero-video-card" onclick="openPreviewModal(1)">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800&q=80" alt="Online Learning">
        <div class="play-btn-circle">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
        </div>
      </div>
    </section>

    <!-- Course Catalog -->
    <section id="courses">
      <div class="section-head">
        <h2><?= e($t['courses_title']) ?></h2>
        <p><?= e($t['courses_sub']) ?></p>
      </div>

      <!-- Filter Tabs -->
      <div class="filter-tabs">
        <button class="tab-pill active" data-filter="all"><?= e($t['cat_all']) ?></button>
        <button class="tab-pill" data-filter="dev"><?= e($t['cat_dev']) ?></button>
        <button class="tab-pill" data-filter="design"><?= e($t['cat_design']) ?></button>
        <button class="tab-pill" data-filter="data"><?= e($t['cat_data']) ?></button>
        <button class="tab-pill" data-filter="marketing"><?= e($t['cat_marketing']) ?></button>
      </div>

      <!-- Course Cards -->
      <div class="courses-grid" id="coursesGrid">
        <?php foreach ($courses as $c): ?>
          <?php $ctitle = $c['title'][$lang] ?? $c['title']['az']; ?>
          <div class="course-card" data-cat="<?= e($c['cat']) ?>">
            <div class="course-thumb">
              <img src="<?= e($c['img']) ?>" alt="<?= e($ctitle) ?>" loading="lazy">
              <div class="course-rating">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span><?= e($c['rating']) ?></span>
              </div>
            </div>
            <div class="course-body">
              <div class="course-meta">
                <span>📚 <?= e($c['lessons']) ?> <?= e($t['lessons_count']) ?></span>
                <span>⏱ <?= e($c['hours']) ?> <?= e($t['hours_count']) ?></span>
              </div>
              <h3 class="course-title"><?= e($ctitle) ?></h3>
              <p class="course-desc"><?= e($c['desc']) ?></p>
              <div class="course-mentor">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span><?= e($c['mentor']) ?></span>
              </div>
              <div class="course-footer">
                <div class="course-price"><?= e($c['price']) ?> ₼</div>
                <div class="course-btns">
                  <button class="btn-preview-sm" onclick="openPreviewModal(<?= $c['id'] ?>)"><?= e($t['btn_preview']) ?></button>
                  <a href="#enroll" class="btn-enroll-sm"><?= e($t['btn_enroll']) ?></a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing">
      <div class="section-head">
        <h2><?= e($t['pricing_title']) ?></h2>
        <p><?= e($t['pricing_sub']) ?></p>
      </div>

      <div class="pricing-grid">
        <!-- Single Course -->
        <div class="pricing-card">
          <h3><?= e($t['plan_standard']) ?></h3>
          <div class="price-num">290 ₼</div>
          <ul class="price-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Seçilmiş 1 kursa ömürlük giriş</li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Bütün video dərslər və kod nümunələri</li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>Bitirmə sertifikatı</li>
          </ul>
          <a href="#enroll" class="btn-plan"><?= e($t['plan_choose']) ?></a>
        </div>

        <!-- Career Bootcamp (Featured) -->
        <div class="pricing-card featured">
          <span class="pricing-badge"><?= e($t['plan_best']) ?></span>
          <h3><?= e($t['plan_bootcamp']) ?></h3>
          <div class="price-num" style="color:var(--neon-cyan);">690 ₼</div>
          <ul class="price-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_mentor']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_portfolio']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_intern']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_cv']) ?></li>
          </ul>
          <a href="#enroll" class="btn-plan"><?= e($t['plan_choose']) ?></a>
        </div>

        <!-- VIP 1-on-1 -->
        <div class="pricing-card">
          <h3><?= e($t['plan_vip']) ?></h3>
          <div class="price-num">1,200 ₼</div>
          <ul class="price-features">
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_vip_hours']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_vip_feedback']) ?></li>
            <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><?= e($t['plan_feat_vip_rec']) ?></li>
          </ul>
          <a href="#enroll" class="btn-plan"><?= e($t['plan_choose']) ?></a>
        </div>
      </div>
    </section>

    <!-- Testimonials -->
    <section id="reviews">
      <div class="section-head">
        <h2><?= e($t['reviews_title']) ?></h2>
        <p><?= e($t['reviews_sub']) ?></p>
      </div>

      <div class="reviews-grid">
        <div class="review-card">
          <div class="review-stars">★★★★★</div>
          <p class="review-text"><?= e($t['rev_1_text']) ?></p>
          <div class="review-user">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&q=80" class="review-avatar" alt="Aynur M.">
            <div>
              <div class="review-name">Aynur Məmmədova</div>
              <div class="review-role">Frontend Engineer @ PASHA Bank</div>
            </div>
          </div>
        </div>

        <div class="review-card">
          <div class="review-stars">★★★★★</div>
          <p class="review-text"><?= e($t['rev_2_text']) ?></p>
          <div class="review-user">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80" class="review-avatar" alt="Murad K.">
            <div>
              <div class="review-name">Murad Kazımzadə</div>
              <div class="review-role">Product Designer @ Freelance Pro</div>
            </div>
          </div>
        </div>

        <div class="review-card">
          <div class="review-stars">★★★★★</div>
          <p class="review-text"><?= e($t['rev_3_text']) ?></p>
          <div class="review-user">
            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&q=80" class="review-avatar" alt="Tural R.">
            <div>
              <div class="review-name">Tural Rzayev</div>
              <div class="review-role">Data Analyst @ Azercell</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Enrollment Consultation Form -->
    <section id="enroll" class="enroll-section">
      <div>
        <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:900; margin-bottom:12px;"><?= e($t['form_title']) ?></h2>
        <p style="color:var(--text-muted); font-size:15px; margin-bottom:24px;"><?= e($t['form_sub']) ?></p>
        <div style="display:flex; flex-direction:column; gap:12px; font-size:14px; color:#cbd5e1;">
          <div style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Qeydiyyatdan keçən ilk 20 tələbəyə 15% endirim</span>
          </div>
          <div style="display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>Dərsləri hissə-hissə faizsiz ödəmə imkanı (Birkart / Tamkart)</span>
          </div>
        </div>
      </div>

      <form class="enroll-form" onsubmit="event.preventDefault(); submitEnroll();">
        <div class="form-group">
          <label><?= e($t['form_name']) ?></label>
          <input type="text" required placeholder="Məsələn: Rəşad Əliyev">
        </div>
        <div class="form-group">
          <label><?= e($t['form_phone']) ?></label>
          <input type="tel" required placeholder="+994 50 234 56 78">
        </div>
        <div class="form-group">
          <label><?= e($t['form_course']) ?></label>
          <select>
            <option>Fullstack JavaScript (React & Node.js)</option>
            <option>UI/UX & Product Design (Figma)</option>
            <option>Python AI & Data Science</option>
            <option>Flutter Mobile App Development</option>
            <option>Digital Marketing & SMM Pro</option>
            <option>Cybersecurity & Ethical Hacking</option>
          </select>
        </div>
        <button type="submit" class="btn-submit-enroll"><?= e($t['form_submit']) ?></button>
      </form>
    </section>
  </main>

  <!-- Video Preview Modal -->
  <div class="modal-overlay" id="previewModal">
    <div class="modal-box">
      <div class="modal-header">
        <h3 style="font-family:var(--font-heading); font-size:18px;" id="modalCourseTitle"><?= e($t['modal_title']) ?></h3>
        <button class="modal-close" onclick="closePreviewModal()">&times;</button>
      </div>
      <div class="modal-player-mockup" style="position:relative; width:100%; height:260px; background:#000; border-radius:12px; overflow:hidden;">
        <video id="modalVideo" controls playsinline preload="metadata" style="width:100%; height:100%; object-fit:cover; display:block;">
          <source src="" type="video/mp4">
          Brauzeriniz video dəstəkləmir.
        </video>
      </div>
      <div class="modal-body">
        <h4 style="font-size:15px; color:var(--neon-cyan);"><?= e($t['modal_syllabus']) ?></h4>
        <ul class="modal-syllabus-list" id="modalSyllabusList">
          <li>Modul 1: Giriş və baza prinsipləri</li>
          <li>Modul 2: Praktiki nümunələr və alətlər</li>
          <li>Modul 3: Layihənin kodlaşdırılması</li>
          <li>Modul 4: Test və istehsalata buraxılış</li>
        </ul>
        <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
          <button class="btn-hero-outline" style="padding:10px 20px; font-size:14px;" onclick="closePreviewModal()"><?= e($t['modal_close']) ?></button>
          <a href="#enroll" class="btn-hero-primary" style="padding:10px 24px; font-size:14px;" onclick="closePreviewModal()"><?= e($t['modal_join']) ?></a>
        </div>
      </div>
    </div>
  </div>

  <!-- WhatsApp Float Button -->
  <a href="https://wa.me/994503936998?text=Salam,%20EduVerse%20kursları%20haqqında%20məlumat%20almaq%20istəyirəm" target="_blank" class="float-wa" title="<?= e($t['wa_consult']) ?>">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 6.46 17.5 2 12.04 2M12.05 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 14.99 3.81 13.47 3.81 11.91C3.81 7.37 7.5 3.69 12.05 3.69C14.25 3.69 16.32 4.55 17.88 6.11C19.44 7.67 20.3 9.74 20.3 11.92C20.28 16.46 16.59 20.15 12.05 20.15Z"/>
    </svg>
  </a>

  <!-- Footer -->
  <footer>
    <p><?= e($t['footer_desc']) ?></p>
    <p>&copy; <?= date('Y') ?> <?= e($t['brand_name']) ?> &bull; Powered by <span style="color:var(--neon-cyan); font-weight:700;">Skyweb.az</span> &bull; <?= e($t['all_rights']) ?></p>
  </footer>

  <script>
    // Tab filtering
    document.querySelectorAll('.tab-pill').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        document.querySelectorAll('.course-card').forEach(card => {
          if (filter === 'all' || card.dataset.cat === filter) {
            card.style.display = 'flex';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });

    const coursesData = <?= json_encode($courses, JSON_UNESCAPED_UNICODE) ?>;
    const currentLang = '<?= e($lang) ?>';

    function openPreviewModal(courseId) {
      const course = coursesData.find(c => c.id === courseId) || coursesData[0];
      const title = course.title[currentLang] || course.title['az'];
      document.getElementById('modalCourseTitle').textContent = title + " — Video Dərs";
      const vid = document.getElementById('modalVideo');
      vid.src = course.video || '../../assets/videos/demo2.mp4';
      vid.poster = course.img;
      const list = document.getElementById('modalSyllabusList');
      list.innerHTML = (course.syllabus || []).map(s => `<li>${s}</li>`).join('');
      document.getElementById('previewModal').classList.add('active');
      vid.play().catch(e => {});
    }

    function closePreviewModal() {
      const vid = document.getElementById('modalVideo');
      if (vid) vid.pause();
      document.getElementById('previewModal').classList.remove('active');
    }

    function submitEnroll() {
      const courseOpts = (coursesData || []).map(function (c) {
        const t = c.title[currentLang] || c.title.az;
        return { value: t, label: t + ' — ' + c.price + ' AZN' };
      });
      DK.sheet({
        eyebrow: DK.pick('QEYDİYYAT', 'ENROLLMENT', 'ЗАПИСЬ НА КУРС', 'KAYIT'),
        title: DK.pick('Kursa qeydiyyat', 'Enroll in a course', 'Записаться на курс', 'Kursa kaydol'),
        sub: DK.pick('Yerinizi ayırın — menecer 1 iş günü ərzində sizinlə əlaqə saxlayacaq.',
                    'Reserve your seat — a manager will contact you within 1 business day.',
                    'Забронируйте место — менеджер свяжется с вами в течение 1 рабочего дня.',
                    'Yerinizi ayırın — yönetici 1 iş günü içinde sizinle iletişime geçecek.'),
        submitText: DK.pick('Qeydiyyatı tamamla', 'Complete enrollment', 'Завершить запись', 'Kaydı tamamla'),
        submitIcon: '💬',
        fields: [
          { name: 'course', label: DK.pick('Kurs', 'Course', 'Курс', 'Kurs'), type: 'select', required: true, options: courseOpts },
          { name: 'plan', label: DK.pick('Format', 'Format', 'Формат', 'Format'), type: 'select', required: true,
            options: [DK.pick('Canlı onlayn', 'Live online', 'Онлайн вживую', 'Canlı online'),
                      DK.pick('Ofisdə (Bakı)', 'On-campus (Baku)', 'В офисе (Баку)', 'Ofiste (Bakü)'),
                      DK.pick('Hibrid', 'Hybrid', 'Гибрид', 'Hibrit')] },
          { name: 'name', label: DK.t.name, placeholder: DK.t.namePh, required: true },
          { name: 'phone', label: DK.t.phone, type: 'tel', placeholder: DK.t.phonePh, required: true },
          { name: 'note', label: DK.t.note, type: 'textarea', rows: 2, placeholder: DK.t.notePh }
        ]
      }).then(function (d) {
        if (!d) return;
        DK.toast(DK.pick('Qeydiyyat qəbul edildi!', 'Enrollment received!',
          'Заявка принята!', 'Kayıt alındı!'));
        DK.wa('Salam! Sky Academy kursa qeydiyyat:\nKurs: ' + d.course +
          '\nFormat: ' + d.plan + '\nAd: ' + d.name + '\nTel: +994 ' + DK.fmtPhone(d.phone) +
          (d.note ? '\nQeyd: ' + d.note : ''));
      });
    }
  </script>
</body>
</html>
