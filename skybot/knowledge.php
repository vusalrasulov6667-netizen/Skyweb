<?php
/**
 * SkyBot Knowledge Base
 * Structured verified knowledge for SkyWeb.az multilingual assistant
 * Supports: AZ (Azərbaycanca), EN (English), RU (Русский), TR (Türkçe)
 */

$skybot_knowledge = [

    // ─────────────────────────────────────────────
    // 1. ABOUT SKYWEB
    // ─────────────────────────────────────────────
    [
        'id'       => 'about',
        'topic'    => 'about',
        'keywords' => ['skyweb','skyweb.az','haqqında','about','kim','what is','о нас','hakkında','platform','ekosistem','ecosystem','nədir','biz kimik','agentlik','şirkət','agency','компания','ajans','xidmət','xidmətlər','xidmətləri','xidmətlərimizi','xidmətlər haqqında','hansı xidmətlər','service','services','услуга','услуги','hizmet','hizmetler','hizmetleri','hangi hizmetler'],
        'langs'    => [
            'az' => "🌐 **Skyweb.az** — Müasir bizneslər üçün tam rəqəmsal ekosistem və agentlikdir!\n\nBiznesinizi rəqəmsal zirvəyə daşıyırıq:\n• 💻 Müasir Vebsaytlar və Mobil Tətbiqlər (Web, iOS, Android, WAP, PWA)\n• 📣 SMM, Rəqəmsal Marketinq & Hədəfli Reklam (Google, Meta, TikTok)\n• 📊 Real-vaxt Analitika Paneli və ROI İzləmə\n• 🎮 Müştəri Loyallığı üçün İnteraktiv Mini Oyunlar\n• 📄 HR və ATS Standartlarına Uyğun Ağıllı CV Builder\n• 📝 Rəsmi Dövlət Standartlı Avtobioqrafiya Xidməti\n• ✨ 11 Canlı İnteraktiv Demo Sayt Portfeli\n\nSualınızı verin, sizə uyğun xidməti məmnuniyyətlə təqdim edim! 🤖",
            'en' => "🌐 **Skyweb.az** is a next-generation digital agency and software ecosystem!\n\nWe elevate your business digitally:\n• 💻 Modern Websites & Mobile Apps (Web, iOS, Android, WAP, PWA)\n• 📣 SMM, Digital Marketing & Targeted Advertising (Google, Meta, TikTok)\n• 📊 Real-Time Analytics Dashboard & ROI Tracking\n• 🎮 Interactive Branded Mini Games for Customer Loyalty\n• 📄 Smart ATS-Ready CV Builder\n• 📝 Official Government Standard Autobiography Service\n• ✨ 11 Live Interactive Demo Portfolios\n\nAsk me anything, I'm here to recommend the best solution for your business! 🤖",
            'ru' => "🌐 **Skyweb.az** — цифровая экосистема нового поколения и агентство веб-разработки в Азербайджане!\n\nМы развиваем ваш бизнес:\n• 💻 Современные веб-сайты и мобильные приложения (Web, iOS, Android, WAP, PWA)\n• 📣 SMM, цифровой маркетинг и таргетированная реклама (Google, Meta, TikTok)\n• 📊 Панель аналитики в реальном времени и отслеживание ROI\n• 🎮 Интерактивные мини-игры для повышения лояльности клиентов\n• 📄 Умный конструктор резюме по стандартам HR и ATS\n• 📝 Официальная автобиография государственного стандарта\n• ✨ 11 интерактивных живых демо-проектов\n\nЗадайте вопрос, и я помогу подобрать лучшее решение! 🤖",
            'tr' => "🌐 **Skyweb.az** — İşletmeler için yeni nesil dijital ajans ve yazılım ekosistemi!\n\nİşletmenizi dijitale taşıyoruz:\n• 💻 Modern Web Siteleri ve Mobil Uygulamalar (Web, iOS, Android, WAP, PWA)\n• 📣 SMM, Dijital Pazarlama ve Hedefli Reklam (Google, Meta, TikTok)\n• 📊 Gerçek Zamanlı Analitik Paneli ve ROI Takibi\n• 🎮 Müşteri Sadakati için İnteraktif Mini Oyunlar\n• 📄 ATS Uyumlu Akıllı CV Oluşturucu\n• 📝 Resmi Devlet Standardında Otobiyografi Hizmeti\n• ✨ 11 Canlı İnteraktif Demo Portföyü\n\nSorunuzu iletin, işletmeniz için en uygun çözümü sunayım! 🤖",
        ],
        'links' => [
            ['label' => '✨ 11 Demo Portfel', 'url' => '#services-modal'],
            ['label' => '📬 Bizimlə Əlaqə', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 2. WEBSITE & MOBILE APP DEVELOPMENT
    // ─────────────────────────────────────────────
    [
        'id'       => 'web_development',
        'topic'    => 'web_development',
        'keywords' => ['vebsayt','sayt','sayt sifarişi','sayt hazirlanmasi','website','web development','sayt düzəltmək','app','mobil tətbiq','ios','android','wap','pwa','mobil sayt','responsive','veb dizayn','frontend','backend','web proqramlaşdırma','создание сайтов','разработка сайтов','мобильное приложение','web tasarım','site yaptırmak','uygulama'],
        'langs'    => [
            'az' => "💻 **Vebsayt və Mobil Tətbiq Hazırlanması**\n\nSkyWeb bütün biznes növləri üçün yüksək performanslı rəqəmsal həllər təqdim edir:\n\n⚡ **Texniki Üstünlüklər:**\n• 100/100 Google PageSpeed sürəti və sıfır donma\n• iOS, Android, Web və WAP tam uyğunluğu\n• Quraşdırıla bilən PWA texnologiyası\n• Bütün ekranlara (mobil 320px-dən 4K-ya qədər) mükəmməl uyğunlaşan dizayn\n• Rahat idarəetmə və admin paneli\n• SSL təhlükəsizlik və 24/7 texniki dəstək\n\n📋 **Hansı saytları hazırlayırıq:**\nKorporativ vebsaytlar, onlayn mağazalar (e-ticarət), restoran/kafe sifariş saytları, daşınmaz əmlak, tibb/aptek, təhsil portalları və fərdi startaplar.\n\nSifariş üçün texniki tələblərinizi bizə göndərin!",
            'en' => "💻 **Website & Mobile App Development**\n\nSkyWeb builds high-performance digital solutions for modern businesses:\n\n⚡ **Technical Advantages:**\n• 100/100 Google PageSpeed and zero lag\n• Native compatibility across iOS, Android, Web, and WAP\n• Installable PWA (Progressive Web App) technology\n• Flawless responsive layout (from 320px mobile to 4K displays)\n• Intuitive business management & admin panel\n• Included SSL encryption and 24/7 technical support\n\n📋 **What we build:**\nCorporate portals, e-commerce stores, restaurant/cafe online ordering systems, real estate portals, medical/pharmacy platforms, and custom SaaS web applications.\n\nContact us to discuss your project requirements!",
            'ru' => "💻 **Разработка веб-сайтов и мобильных приложений**\n\nSkyWeb создает высокопроизводительные цифровые решения для бизнеса любого масштаба:\n\n⚡ **Технические преимущества:**\n• Скорость загрузки 100/100 Google PageSpeed без задержек\n• Полная совместимость с iOS, Android, Web и WAP\n• Устанавливаемые PWA технологии\n• Адаптивная верстка под все экраны (от 320px до 4K)\n• Удобная панель управления (Admin Panel)\n• SSL-сертификат безопасности и поддержка 24/7\n\n📋 **Что мы разрабатываем:**\nКорпоративные сайты, интернет-магазины, сервисы доставки для ресторанов, порталы недвижимости, медицинские платформы и индивидуальные веб-сервисы.\n\nСвяжитесь с нами для консультации и расчета проекта!",
            'tr' => "💻 **Web Sitesi ve Mobil Uygulama Geliştirme**\n\nSkyWeb, işletmeler için yüksek performanslı dijital çözümler üretir:\n\n⚡ **Teknik Avantajlar:**\n• 100/100 Google PageSpeed hızı ve sıfır gecikme\n• iOS, Android, Web ve WAP tam uyumluluğu\n• Yüklenebilir PWA teknolojisi\n• Tüm ekranlara (320px mobilden 4K'ya) kusursuz responsive uyum\n• Kolay kullanımlı yönetim paneli\n• SSL güvenlik sertifikası ve 7/24 teknik destek\n\n📋 **Geliştirdiğimiz çözümler:**\nKurumsal siteler, e-ticaret mağazaları, restoran sipariş sistemleri, emlak portalları, klinik/eczane sistemleri ve özel web projeleri.\n\nProjenizi hayata geçirmek için hemen bizimle iletişime geçin!",
        ],
        'links' => [
            ['label' => '✨ 11 Demo Sayta Bax', 'url' => '#services-modal'],
            ['label' => '📞 Layihə Sifariş Et', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 3. SMM & DIGITAL MARKETING
    // ─────────────────────────────────────────────
    [
        'id'       => 'smm_marketing',
        'topic'    => 'smm_marketing',
        'keywords' => ['smm','sosial media','social media','marketinq','marketing','rəqəmsal marketinq','digital marketing','kontent','content','post','reels','hekayə','story','brending','branding','smm xidməti','смм','маркетинг','соцсети','dijital pazarlama'],
        'langs'    => [
            'az' => "📣 **SMM və Rəqəmsal Marketinq Xidməti**\n\nSosial şəbəkələrdə brendinizi tanıdır, izləyiciləri real alıcılara çeviririk:\n\n🎯 **Xidmət Paketinə Daxildir:**\n• Fərdi SMM və kontent strategiyasının hazırlanması\n• Peşəkar qrafik dizayn, fotolar və viral Reels videoları\n• Satış yönümlü kopiraytinq (mətn yazımı)\n• Səhifənin 24/7 aktiv idarə olunması və rəylərə nəzarət\n• İnteraktiv loyallıq yarışmaları və viktorinalar\n• Həftəlik və aylıq şəffaf hesabatlılıq\n• Real-Time Data Analitika Paneli ilə ROI izləmə\n\n📊 Biznesinizi sosial şəbəkələrdə böyütmək üçün əlaqə saxlayın!",
            'en' => "📣 **SMM & Digital Marketing Services**\n\nWe build powerful social media presence and turn audiences into paying customers:\n\n🎯 **Included Services:**\n• Custom social media and content strategy\n• Professional graphic design, visuals, and viral Reels\n• High-converting copywriting and storytelling\n• Full account management and community moderation\n• Interactive gamified loyalty giveaways\n• Transparent monthly performance reporting\n• Real-time data analytics dashboard with ROI tracking\n\n📊 Get in touch to elevate your brand on social media!",
            'ru' => "📣 **SMM и Цифровой Маркетинг**\n\nМы продвигаем ваш бренд в социальных сетях и превращаем подписчиков в реальных клиентов:\n\n🎯 **В услуги входит:**\n• Индивидуальная контент-стратегия\n• Профессиональный графический дизайн и трендовые Reels\n• Продающий копирайтинг\n• Комплексное ведение страниц и модерация комментариев\n• Интерактивные конкурсы и геймификация для аудитории\n• Прозрачная отчетность по ключевым метрикам\n• Аналитический дашборд с отслеживанием ROI в реальном времени\n\n📊 Свяжитесь с нами для продвижения вашего бизнеса!",
            'tr' => "📣 **SMM ve Dijital Pazarlama Hizmetleri**\n\nMarkanızı sosyal medyada güçlendiriyor, takipçilerinizi sadık müşterilere dönüştürüyoruz:\n\n🎯 **Hizmet Kapsamı:**\n• İşletmenize özel SMM ve içerik stratejisi\n• Profesyonel grafik tasarım ve viral Reels videoları\n• Satış odaklı metin yazarlığı (copywriting)\n• Sayfa yönetimi ve müşteri etkileşimi\n• Müşteri bağlılığını artıran interaktif yarışmalar\n• Şeffaf haftalık/aylık performans raporları\n• Gerçek zamanlı analitik paneli ve ROI takibi\n\n📊 Sosyal medyada büyümek için hemen bizimle görüşün!",
        ],
        'links' => [
            ['label' => '📊 Analitika Paneli', 'url' => '/sky/modules/analytics/'],
            ['label' => '💬 SMM Sifarişi', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 4. ONLINE ADVERTISING: GOOGLE, INSTAGRAM, TIKTOK
    // ─────────────────────────────────────────────
    [
        'id'       => 'advertising_ads',
        'topic'    => 'advertising_ads',
        'keywords' => ['reklam','reklamlar','ads','advertising','google ads','meta ads','instagram reklam','facebook reklam','tiktok ads','tiktok reklam','hədəfli reklam','targeting','таргетинг','контекстная реклама','гугл реклама','инстаграм реклама','reklam vermek','target','cpc','roi','büdcə','budget'],
        'langs'    => [
            'az' => "🎯 **Hədəfli Reklam Xidmətləri: Google, Instagram, Meta & TikTok**\n\nReklam büdcənizi ən yüksək gəlirliliklə (ROI) idarə edirik:\n\n🔹 **Google Ads:**\n• Axtarış şəbəkəsi reklamları (müştəri Google-da axtaranda ilk sırada çıxın)\n• Display (banner) və YouTube video reklamları\n• Remarketing (saytınızı tərk edən müştəriləri geri qaytarmaq)\n\n🔹 **Instagram & Meta Ads:**\n• Dəqiq demoqrafik, maraq və davranış hədəfləməsi\n• Satış və lead (müraciət) toplama kampaniyaları\n• WhatsApp və Direct-ə yönələn reklamlar\n\n🔹 **TikTok Ads:**\n• Gənc və dinamik auditoriyaya birbaşa çıxış\n• Trend və viral video formatlı reklam kampaniyaları\n\n📊 Bütün nəticələr SkyWeb Analitika Panelində canlı əks olunur!",
            'en' => "🎯 **Online Advertising: Google, Instagram, Meta & TikTok Ads**\n\nWe optimize your advertising budget for maximum return on investment (ROI):\n\n🔹 **Google Ads:**\n• Google Search Ads (appear #1 when customers search for your services)\n• Display Banner & YouTube Video campaigns\n• Smart Retargeting to re-engage website visitors\n\n🔹 **Instagram & Meta Ads:**\n• Precision targeting by demographics, interests, and behavior\n• Direct Lead Generation and e-commerce purchase campaigns\n• High-converting Click-to-WhatsApp and Instagram Direct ads\n\n🔹 **TikTok Ads:**\n• Direct access to young, highly engaged audiences\n• Native video creatives aligned with modern viral trends\n\n📊 Monitor live metrics anytime via the SkyWeb Analytics Dashboard!",
            'ru' => "🎯 **Таргетированная и контекстная реклама: Google, Instagram, Meta, TikTok**\n\nМы настраиваем рекламу с максимальной окупаемостью инвестиций (ROI):\n\n🔹 **Google Ads:**\n• Поисковая реклама (первые строчки в поиске Google по горячим запросам)\n• Баннерная реклама (КМС) и видеореклама на YouTube\n• Ремаркетинг (возврат посетителей на ваш сайт)\n\n🔹 **Instagram & Meta Ads:**\n• Точный таргетинг по возрасту, интересам, геопозиции и поведению\n• Кампании по сбору лидов и прямым онлайн-продажам\n• Перевод трафика прямо в WhatsApp и Instagram Direct\n\n🔹 **TikTok Ads:**\n• Охват молодой и активной аудитории через трендовые видеокреативы\n\n📊 Все клики, конверсии и расходы отображаются в реальном времени в Панели Аналитики!",
            'tr' => "🎯 **Hedefli Reklam Hizmetleri: Google, Instagram, Meta & TikTok**\n\nReklam bütçenizi en yüksek yatırım getirisiyle (ROI) yönetiyoruz:\n\n🔹 **Google Ads:**\n• Arama ağı reklamları (müşteriler aradığında ilk sırada yer alın)\n• Görüntülü reklam ağı ve YouTube video kampanyaları\n• Ziyaretçileri geri kazandıran Yeniden Pazarlama (Remarketing)\n\n🔹 **Instagram & Meta Ads:**\n• Demografik, ilgi alanı ve davranışa göre nokta atışı hedefleme\n• Satış ve potansiyel müşteri (Lead) toplama kampanyaları\n• Doğrudan WhatsApp ve Instagram DM'ye yönlendiren reklamlar\n\n🔹 **TikTok Ads:**\n• Genç ve dinamik kitleye viral video formatlarıyla ulaşım\n\n📊 Tüm performans verilerini SkyWeb Analitik Panelinde canlı takip edin!",
        ],
        'links' => [
            ['label' => '📈 Analitika Paneli', 'url' => '/sky/modules/analytics/'],
            ['label' => '🎯 Reklam Kampaniyası Başlat', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 5. SEO, HOSTING & TECHNICAL SERVICES
    // ─────────────────────────────────────────────
    [
        'id'       => 'seo_hosting',
        'topic'    => 'seo_hosting',
        'keywords' => ['seo','axtarış optimizasiyası','google axtarış','hostinq','hosting','server','domen','domain','ssl','təhlükəsizlik','security','sürət','pagespeed','texniki dəstək','support','bakup','yedəkləmə','хостинг','сео','оптимизация','техническая поддержка'],
        'langs'    => [
            'az' => "⚙️ **SEO, Hostinq və Texniki Xidmətlər**\n\nVebsaytınızın fasiləsiz, təhlükəsiz və axtarış sistemlərində ən öndə işləməsini təmin edirik:\n\n🔍 **SEO (Axtarış Optimizasiyası):**\n• On-page SEO və açar söz optimizasiyası\n• Google Search Console və axtarış sistemlərində tam indekslənmə\n• Schema.org rəqəmsal işarələmə və semantik struktur\n• Core Web Vitals tələblərinə tam uyğunluq\n\n⚡ **Premium Hostinq & Texniki Dəstək:**\n• 99.9% fasiləsiz işləmə (uptime) zəmanəti\n• Pulsuz SSL təhlükəsizlik sertifikatı (HTTPS)\n• Gündəlik avtomatik ehtiyat nüsxələnmə (backup)\n• DDoS və kibertəhlükələrdən qorunma\n• 24/7 texniki monitorinq və profilaktika",
            'en' => "⚙️ **SEO, Hosting & Technical Support Services**\n\nWe ensure your digital platforms run fast, secure, and top-ranked on search engines:\n\n🔍 **SEO (Search Engine Optimization):**\n• On-page SEO and target keyword optimization\n• Full Google indexing and Search Console configuration\n• Structured Schema markup and semantic HTML architecture\n• Full compliance with Google Core Web Vitals speed benchmarks\n\n⚡ **High-Speed Hosting & Infrastructure:**\n• 99.9% guaranteed server uptime\n• Free SSL security certificate (HTTPS)\n• Automated daily cloud backups\n• Advanced anti-DDoS protection\n• 24/7 technical monitoring and maintenance",
            'ru' => "⚙️ **SEO, Хостинг и Техническая Поддержка**\n\nОбеспечиваем высокую скорость, безопасность и лидирующие позиции вашего сайта в поисковых системах:\n\n🔍 **SEO-оптимизация:**\n• Внутренняя оптимизация сайта и семантическое ядро\n• Быстрая индексация в Google и настройка Google Search Console\n• Микроразметка Schema.org\n• Соответствие стандартам Google Core Web Vitals\n\n⚡ **Надежный хостинг и безопасность:**\n• 99.9% аптайм серверов\n• Бесплатный SSL-сертификат безопасности (HTTPS)\n• Ежедневное резервное копирование (бэкапы)\n• Защита от DDoS-атак и вредоносного ПО\n• Круглосуточный мониторинг 24/7",
            'tr' => "⚙️ **SEO, Hosting ve Teknik Destek Hizmetleri**\n\nWeb sitenizin kesintisiz, güvenli ve arama motorlarında üst sıralarda çalışmasını sağlıyoruz:\n\n🔍 **SEO (Arama Motoru Optimizasyonu):**\n• Site içi SEO ve anahtar kelime uyarlaması\n• Google dizinine tam kayıt ve Search Console optimizasyonu\n• Schema.org yapısal veri işaretlemesi\n• Google Core Web Vitals hız kriterlerine tam uyum\n\n⚡ **Hızlı Hosting ve Güvenlik:**\n• %99.9 kesintisiz çalışma (uptime) garantisi\n• Ücretsiz SSL güvenlik sertifikası (HTTPS)\n• Otomatik günlük bulut yedekleme\n• DDoS ve siber tehdit koruması\n• 7/24 teknik izleme ve bakım desteği",
        ],
        'links' => [
            ['label' => '💬 Texniki Məsləhət', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 6. CV BUILDER SERVICE
    // ─────────────────────────────────────────────
    [
        'id'       => 'cv_builder',
        'topic'    => 'cv_builder',
        'keywords' => ['cv','cv builder','rezüme','resume','cv hazirlamaq','cv yaratmaq','cv şablonu','template','ats','ats ready','pdf cv','cv qiyməti','pulsuz cv','резюме','создать резюме','cv oluşturucu','cv hazırla'],
        'langs'    => [
            'az' => "📄 **Ağıllı CV Builder Xidməti**\n\nBeynəlxalq HR və ATS standartlarına uyğun peşəkar CV-nizi bir neçə dəqiqəyə hazırlayın!\n\n🎨 **Xüsusiyyətlər:**\n• 6+ Müasir Dizayn Şablonu (Sky Modern, Cloud Classic, Cyber ATS, Creative Wave, Executive Pro)\n• ATS-Ready: Şirkətlərin avtomatik filter sistemlərindən 100% keçir\n• Çoxdilli dəstək: Məlumatları istənilən dildə doldurma imkanı\n• Yüksək keyfiyyətli vektor PDF formatında ani yükləmə\n\n💰 **Qiymət:**\n• Əsas şablonlar: **PULSUZ (0 AZN)**\n• Premium şablonlar: **2.99 AZN – 4.99 AZN**\n\n👉 İndi online keçid edərək CV-nizi hazırlaya bilərsiniz!",
            'en' => "📄 **Smart CV Builder Service**\n\nBuild a professional resume tailored to global HR and ATS recruitment standards in minutes!\n\n🎨 **Key Features:**\n• 6+ Modern templates (Sky Modern, Cloud Classic, Cyber ATS, Creative Wave, Executive Pro)\n• ATS-Ready: Successfully passes corporate applicant tracking screening algorithms\n• Multilingual resume generation\n• Instant download in high-resolution vector PDF\n\n💰 **Pricing:**\n• Basic templates: **FREE (0 AZN)**\n• Premium designer templates: **2.99 AZN – 4.99 AZN**\n\n👉 Start creating your CV online right now!",
            'ru' => "📄 **Умный Конструктор Резюме (CV Builder)**\n\nСоздайте профессиональное резюме по мировым стандартам HR и ATS всего за несколько минут!\n\n🎨 **Возможности:**\n• 6+ современных шаблонов (Sky Modern, Cloud Classic, Cyber ATS, Creative Wave, Executive Pro)\n• ATS-Ready: проходит автоматический отбор рекрутинговых систем\n• Поддержка нескольких языков\n• Мгновенное скачивание в высоком качестве (векторный PDF)\n\n💰 **Стоимость:**\n• Базовые шаблоны: **БЕСПЛАТНО (0 AZN)**\n• Премиум шаблоны: **от 2.99 до 4.99 AZN**\n\n👉 Создайте резюме прямо сейчас на сайте!",
            'tr' => "📄 **Akıllı CV Oluşturucu (CV Builder)**\n\nUluslararası İK ve ATS standartlarına uygun profesyonel özgeçmişinizi dakikalar içinde hazırlayın!\n\n🎨 **Özellikler:**\n• 6+ Profesyonel Şablon (Sky Modern, Cloud Classic, Cyber ATS, Creative Wave, Executive Pro)\n• ATS Uyumlu: Kurumsal filtreleme sistemlerinden sorunsuz geçer\n• Çok dilli CV oluşturma desteği\n• Yüksek kaliteli vektörel PDF olarak anında indirme\n\n💰 **Fiyatlandırma:**\n• Temel şablonlar: **ÜCRETSİZ (0 AZN)**\n• Premium şablonlar: **2.99 AZN – 4.99 AZN**\n\n👉 Hemen CV'nizi oluşturmaya başlayın!",
        ],
        'links' => [
            ['label' => '📄 CV Builder-ə Keçid', 'url' => '/sky/modules/cv-builder/'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 7. AUTOBIOGRAPHY SERVICE
    // ─────────────────────────────────────────────
    [
        'id'       => 'autobiography',
        'topic'    => 'autobiography',
        'keywords' => ['avtobioqrafiya','tərcümeyi-hal','tercumeyi hal','autobiography','dövlət qulluğu','rəsmi sənəd','imza','rəqəmsal imza','avtobioqrafiya nümunəsi','автобиография','otobiyografi'],
        'langs'    => [
            'az' => "📝 **Avtobioqrafiya (Tərcümeyi-hal) Xidməti**\n\nDövlət qulluğu, hüquq-mühafizə orqanları və rəsmi müəssisələr üçün standartlaşdırılmış avtobioqrafiya generatoru:\n\n✅ Azərbaycan Respublikasının rəsmi dövlət sənədləşmə standartlarına tam uyğundur\n✅ AI asistent köməyi ilə məlumatların qüsursuz redaktəsi\n✅ Rəqəmsal imza əlavə etmək imkanı\n✅ Yüksək dəqiqlikli çap və PDF ixracı\n\n📋 Dövlət qulluğuna qəbul və rəsmi iş müraciətləri üçün idealdır!",
            'en' => "📝 **Autobiography Preparation Service**\n\nStandardized official autobiography generator for public service, governmental bodies, and corporate institutions:\n\n✅ Fully compliant with official state documentation standards\n✅ AI-assisted text structuring and error correction\n✅ Digital signature support\n✅ High-resolution print-ready PDF export\n\n📋 Perfect for public sector applications and official submissions!",
            'ru' => "📝 **Сервис Официальной Автобиографии**\n\nГенератор автобиографий по государственным стандартам для поступления на госслужбу, в органы и официальные учреждения:\n\n✅ Полное соответствие официальным стандартам делопроизводства\n✅ ИИ-помощник для грамотного составления текста\n✅ Поддержка добавления цифровой подписи\n✅ Экспорт в высококачественный PDF для печати\n\n📋 Идеально подходит для официального трудоустройства!",
            'tr' => "📝 **Resmi Otobiyografi Hizmeti**\n\nKamu personeli alımları, devlet kurumları ve kurumsal şirketler için resmi otobiyografi oluşturucu:\n\n✅ Resmi devlet dokümantasyon standartlarına tam uyumlu\n✅ Yapay zeka asistanı ile hatasız metin düzenleme\n✅ Dijital imza ekleme imkanı\n✅ Baskıya hazır yüksek kaliteli PDF çıktısı\n\n📋 Resmi iş başvuruları ve kamu sınavları için ideal çözüm!",
        ],
        'links' => [
            ['label' => '📝 Avtobioqrafiya Modalı', 'url' => '#card-autobio-service'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 8. MINI GAMES & GAMIFICATION
    // ─────────────────────────────────────────────
    [
        'id'       => 'mini_games',
        'topic'    => 'mini_games',
        'keywords' => ['oyun','mini oyun','games','gamification','çarx','fırlanan çarx','spin wheel','viktorina','quiz','slot','tapmaca','puzzle','loyallıq','loyalty','hədiyyə','kampaniya','игры','мини-игры','oyunlaştırma'],
        'langs'    => [
            'az' => "🎮 **Biznesə Özəl Mini Oyunlar & Gamification**\n\nMüştəri cəlbini və təkrar satışları artıran brendləşdirilmiş interaktiv oyunlar:\n\n🎡 **Təklif etdiyimiz oyun növləri:**\n• Fırlanan Çarx (Spin the Wheel) — endirim və hədiyyə çarxı\n• İnteraktiv Viktorina (Quiz & Trivia) — brend bilikləri və mükafatlar\n• Mini Slot & Şans Oyunları — promo kod paylama\n• Tapmaca (Puzzle) & Yaddaş Oyunları (Memory Game)\n• Qazı-Qazan (Scratch Card)\n\n⚡ 60 FPS axıcı sürət, sıfır gecikmə, iOS, Android, Web və WAP tam uyğunluğu ilə hazırlanır.\n\nSatışlarınızı oyunlaşdırma ilə artırın!",
            'en' => "🎮 **Custom Mini Games & Gamification**\n\nEngage customers, increase conversion rates, and build brand loyalty with interactive branded games:\n\n🎡 **Available Game Types:**\n• Spin the Wheel — coupon and prize giveaway wheel\n• Interactive Quiz & Trivia — branded knowledge tests with rewards\n• Mini Slots & Lucky Draw games\n• Branded Puzzles & Memory Match games\n• Scratch & Win digital cards\n\n⚡ Engineered for 60 FPS performance, zero lag, across iOS, Android, Web & WAP.\n\nBoost your sales with modern gamification!",
            'ru' => "🎮 **Интерактивные Мини-игры и Геймификация для Бизнеса**\n\nПовышайте лояльность клиентов и вовлеченность с помощью брендированных игр:\n\n🎡 **Доступные форматы:**\n• Колесо Фортуны (Spin the Wheel) — розыгрыш скидок и призов\n• Тематические викторины (Quiz) — проверка знаний о бренде с призами\n• Мини-слоты и лотереи — выдача промокодов\n• Головоломки (Puzzle) и игры на память (Memory Game)\n• Цифровые скретч-карты (Сотри и выиграй)\n\n⚡ Скорость 60 FPS без лагов на iOS, Android, Web и WAP.\n\nЗакажите уникальную игру для вашего бренда!",
            'tr' => "🎮 **İşletmelere Özel Mini Oyunlar ve Oyunlaştırma (Gamification)**\n\nMüşteri bağlılığını ve satışları artıran markalı interaktif oyun çözümleri:\n\n🎡 **Oyun Çeşitlerimiz:**\n• Çarkıfelek (Spin the Wheel) — indirim ve hediye çarkı\n• İnteraktif Bilgi Yarışması (Quiz) — ödüllü testler\n• Mini Slot ve Şans Oyunları — kupon dağıtımı\n• Bulmaca (Puzzle) ve Hafıza Oyunları (Memory Game)\n• Kazı Kazan (Scratch Card) dijital kartlar\n\n⚡ 60 FPS akıcı performans, iOS, Android, Web ve WAP tam uyumu.\n\nOyunlaştırma ile satışlarınızı katlayın!",
        ],
        'links' => [
            ['label' => '🎮 Oyun Sifariş Paneli', 'url' => '/sky/modules/games/'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 9. ALL 11 DEMO PROJECTS OVERVIEW
    // ─────────────────────────────────────────────
    [
        'id'       => 'demos_all',
        'topic'    => 'demos_all',
        'keywords' => ['demo','demolar','nümunələr','demo saytlar','hansı demolar','portfel','keyslər','portfolio','canlı demo','nümunə sayt','демо','примеры сайтов','demo siteler','örnek siteler'],
        'langs'    => [
            'az' => "✨ **SkyWeb 11 Canlı İnteraktiv Demo Portfeli**\n\nFərqli biznes sahələri üçün sıfırdan hazırlanmış, dərhal tətbiq oluna bilən 11 hazır demo saytımız mövcuddur:\n\n1. 👗 **Aura Moda** — Geyim butikləri üçün səbət, ölçü seçimi (S/M/L) və WhatsApp sifarişi\n2. 🍔 **LəzzətExpress** — Restoran menyusu, zonalar üzrə çatdırılma kalkulyatoru\n3. 💬 **ChatSatış Pro** — WhatsApp kataloqu və 1-klik sifariş sistemi\n4. 💊 **Şəfa Aptek** — Onlayn aptek, AI əl xətti resept skaneri (OCR) və anbar yoxlanışı\n5. ✂️ **Élégance Beauty** — Gözəllik salonu, usta növbəsi, Əvvəl/Sonra slayderi\n6. 🏋️ **APEXFIT** — Fitnes klubu, dərs cədvəli və endirimli abunəlik kalkulyatoru\n7. 🎓 **EduVerse** — Təhsil akademiyası, video dərs pleyeri və mentor qeydiyyatı\n8. 🎬 **CineSky Media** — Video prodakşn, şouril pleyeri və çəkiliş büdcəsi kalkulyatoru\n9. ☕ **Velvet Brew** — Kafe, fincan ölçüləri və rəqəmsal ştamp loyallıq kartı\n10. 🏡 **SkyVilla Realty** — Daşınmaz əmlak axtarışı, Bakı xəritəsi və 360° virtual tur\n11. 🍏 **Yaşıl Bazar** — Onlayn supermarket, geri sayım taymeri və GreenClub kartı\n\nSaytın 'Veb Sayt & Xidmətlər' bölməsindən hamısını canlı sınaqdan keçirə bilərsiniz!",
            'en' => "✨ **SkyWeb Portfolio of 11 Interactive Live Demos**\n\nExplore our 11 turn-key demo platforms built for various business sectors:\n\n1. 👗 **Aura Fashion** — Boutique e-commerce with cart drawer, sizing, and WhatsApp checkout\n2. 🍔 **LezzetExpress** — Restaurant food delivery, digital menu, zone fee calculator\n3. 💬 **ChatSales Pro** — WhatsApp catalog for social media and retail sellers\n4. 💊 **Shefa Pharmacy** — Online pharmacy with AI handwriting OCR prescription scanner\n5. ✂️ **Élégance Beauty** — Salon booking with interactive Before/After photo comparison\n6. 🏋️ **APEXFIT** — Gym & fitness club with timetable and annual discount calculator\n7. 🎓 **EduVerse** — Course academy with built-in video player and syllabus\n8. 🎬 **CineSky Media** — Video production studio with showreel and budget estimator\n9. ☕ **Velvet Brew** — Coffee shop with cup sizing and digital stamp loyalty card\n10. 🏡 **SkyVilla Realty** — Real estate search with interactive map and 360° virtual tours\n11. 🍏 **Green Market** — Grocery supermarket with flash sales timer and loyalty club\n\nClick the demo link to experience them live!",
            'ru' => "✨ **11 Интерактивных Демо-сайтов SkyWeb**\n\nГотовые к запуску демо-платформы для самых популярных сфер бизнеса:\n\n1. 👗 **Aura Moda** — Бутик одежды с корзиной, выбором размеров и заказом в WhatsApp\n2. 🍔 **LezzetExpress** — Доставка еды из ресторана с калькулятором зон\n3. 💬 **ChatSatış Pro** — Каталог для продаж в Instagram и WhatsApp в 1 клик\n4. 💊 **Şəfa Aptek** — Онлайн-аптека с ИИ-сканером рукописных рецептов (OCR)\n5. ✂️ **Élégance Beauty** — Салон красоты с онлайн-записью и слайдером До/После\n6. 🏋️ **APEXFIT** — Фитнес-клуб с расписанием тренировок и калькулятором абонементов\n7. 🎓 **EduVerse** — Образовательная академия с видеоплеером уроков\n8. 🎬 **CineSky Media** — Видеостудия с шоурилом и расчетом стоимости съемок\n9. ☕ **Velvet Brew** — Кофейня с выбором объема чашек и картой лояльности\n10. 🏡 **SkyVilla Realty** — Агентство недвижимости с картой Баку и 360° туром\n11. 🍏 **Yaşıl Bazar** — Супермаркет с таймером скидок и дисконтной картой\n\nВсе демо доступны для живого тестирования в нашем модальном окне!",
            'tr' => "✨ **SkyWeb 11 Canlı İnteraktif Demo Portföyü**\n\nFarklı sektörler için sıfırdan geliştirilmiş, hemen kullanıma hazır 11 demo web sitemiz:\n\n1. 👗 **Aura Butik** — Giyim mağazası, beden seçimi ve WhatsApp siparişi\n2. 🍔 **LezzetExpress** — Restoran menüsü ve teslimat bölgesi hesaplayıcı\n3. 💬 **ChatSatış Pro** — WhatsApp üzerinden tek tıkla ürün satış kataloğu\n4. 💊 **Şifa Eczanesi** — Yapay zeka el yazısı reçete tarayıcısı (OCR) ve stok kontrolü\n5. ✂️ **Élégance** — Kuaför/Güzellik salonu randevusu ve Öncesi/Sonrası kaydırıcı\n6. 🏋️ **APEXFIT** — Spor salonu ders takvimi ve indirimli üyelik hesaplayıcı\n7. 🎓 **EduVerse** — Eğitim akademisi, video ders oynatıcı ve kayıt akışı\n8. 🎬 **CineSky Media** — Video prodüksiyon stüdyosu, showreel ve bütçe hesaplayıcı\n9. ☕ **Velvet Brew** — Kafe, fincan boyutları ve dijital sadakat damga kartı\n10. 🏡 **SkyVilla** — Emlak filtreleme, Bakü haritası ve 360° sanal tur\n11. 🍏 **Yeşil Pazar** — Online market, indirim geri sayım sayacı ve sadakat kartı\n\nTüm demoları sitemizdeki vitrinden canlı deneyebilirsiniz!",
        ],
        'links' => [
            ['label' => '✨ 11 Demo Sayta Bax', 'url' => '#services-modal'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 10. DEMO: RESTAURANT & FOOD (LezzətExpress)
    // ─────────────────────────────────────────────
    [
        'id'       => 'demo_food',
        'topic'    => 'demo_food',
        'keywords' => ['restoran','yemek','food','çatdırılma','delivery','restoran saytı','menyu','lezzət','lezzətexpress','gusto','masa rezervi','ресторан','доставка еды','restoran sitesi'],
        'langs'    => [
            'az' => "🍔 **LəzzətExpress — Restoran & Çatdırılma Vebsaytı**\n\nRestoranlar, qastropablar və çatdırılma xidmətləri üçün canlı demo:\n• Kateqoriyalar üzrə interaktiv yemək menyusu\n• Çatdırılma zonası və məsafə kalkulyatoru\n• Səbət sistemi və avtomatik WhatsApp sifariş mesajı\n• Masa rezervasiyası formu\n• 4 dildə (AZ, EN, TR, RU) tam dəstək\n\nÖz restoranınız üçün belə bir sayt istəyirsinizsə, dərhal əlaqə saxlayın!",
            'en' => "🍔 **LezzetExpress — Restaurant & Food Delivery Demo**\n\nHigh-converting ordering website designed for restaurants, cafes, and ghost kitchens:\n• Interactive menu categories with chef recommendations\n• Live delivery zone and distance fee calculator\n• Food bag with automatic WhatsApp order generation\n• Online table reservation booking form\n• Full multilingual support in AZ, EN, TR, RU",
            'ru' => "🍔 **LezzetExpress — Сайт для ресторана и службы доставки**\n\nИдеальное решение для кафе, ресторанов и служб доставки:\n• Интерактивное меню блюд по категориям\n• Калькулятор стоимости доставки по зонам Баку\n• Корзина заказа и отправка заявки шефу в WhatsApp\n• Форма бронирования столика\n• Полная поддержка 4 языков (AZ, EN, TR, RU)",
            'tr' => "🍔 **LezzetExpress — Restoran ve Paket Servis Demosu**\n\nRestoranlar ve kafeler için online sipariş web sitesi çözümü:\n• Kategorilere ayrılmış interaktif yemek menüsü\n• Canlı teslimat bölgesi ve ücret hesaplayıcısı\n• WhatsApp ile tek tıkla sipariş iletimi\n• Online masa rezervasyon formu\n• AZ, EN, TR, RU 4 dilde tam destek",
        ],
        'links' => [
            ['label' => '🍔 Canlı Restoran Demosu', 'url' => '/sky/modules/web-demos/demo-food.php'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 11. DEMO: PHARMACY & MEDICAL (Şəfa Aptek)
    // ─────────────────────────────────────────────
    [
        'id'       => 'demo_pharmacy',
        'topic'    => 'demo_pharmacy',
        'keywords' => ['aptek','pharmacy','şəfa aptek','dərman','resept','ocr','resept skaneri','tibbi','apteka','həkim','клиника','аптека','eczane','ilaç','reçete'],
        'langs'    => [
            'az' => "💊 **Şəfa Aptek — Onlayn Aptek və AI Resept Skaneri**\n\nApteklər və tibb mərkəzləri üçün qabaqcıl rəqəmsal platforma:\n• Süni intellekt əsaslı əl xətti resept tanıyan OCR skaneri\n• Canlı aptek anbarı ilə dərman mövcudluğu yoxlanışı\n• Reseptli və reseptsiz preparatların filtrasiyası\n• Əczaçı ilə onlayn WhatsApp məsləhəti və sifariş təsdiqi\n• Təcili çatdırılma xidməti inteqrasiyası",
            'en' => "💊 **Shefa Pharmacy — Online Pharmacy & AI OCR Scanner**\n\nAdvanced pharmaceutical e-commerce platform for clinics and pharmacy chains:\n• AI-powered handwriting OCR prescription scanner\n• Real-time pharmacy inventory stock checking\n• Filter OTC vs. prescription-only medications\n• WhatsApp pharmacist consultation and order dispatch\n• 45-minute cold-chain delivery workflow",
            'ru' => "💊 **Şəfa Aptek — Онлайн-аптека с ИИ-сканером рецептов**\n\nПередовая фармацевтическая платформа для аптек и медицинских центров:\n• ИИ-сканер (OCR) для распознавания рукописных рецептов врачей\n• Проверка наличия лекарств на складе аптеки в реальном времени\n• Разделение на рецептурные и безрецептурные препараты\n• Онлайн-консультация провизора и заказ через WhatsApp",
            'tr' => "💊 **Şifa Eczanesi — Online Eczane ve Yapay Zeka Reçete Tarayıcısı**\n\nEczaneler ve medikal merkezler için yeni nesil sağlık platformu:\n• Hekimlerin el yazısıyla yazdığı reçeteleri tanıyan AI OCR tarayıcısı\n• Eczane stoğu ile canlı ilaç kontrolü\n• Reçeteli ve reçetesiz ürün ayrımı\n• Eczacı ile doğrudan WhatsApp danışma hattı",
        ],
        'links' => [
            ['label' => '💊 Canlı Aptek Demosu', 'url' => '/sky/modules/web-demos/demo-pharmacy.php'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 12. DEMO: REAL ESTATE (SkyVilla)
    // ─────────────────────────────────────────────
    [
        'id'       => 'demo_realestate',
        'topic'    => 'demo_realestate',
        'keywords' => ['əmlak','daşınmaz əmlak','ev','mənzil','villa','realty','real estate','kirayə','alğı-satqı','skyvilla','360 tur','virtual tur','недвижимость','квартира','аренда','emlak','gayrimenkul'],
        'langs'    => [
            'az' => "🏡 **SkyVilla Realty — Lüks Daşınmaz Əmlak Agentliyi Demosu**\n\nTikinti şirkətləri, rieltorlar və əmlak agentlikləri üçün platforma:\n• Çoxparametrlik axtarış (otaq sayı, rayon, qiymət, təmir statusu)\n• Bakı və Abşeron üzrə interaktiv xəritə inteqrasiyası\n• 360° dərəcəlik interaktiv virtual tur önbaxışı\n• Əmlak qiymətləndirmə və agentlə görüş təyini sorğusu",
            'en' => "🏡 **SkyVilla Realty — Luxury Real Estate Agency Demo**\n\nPremier platform for property agencies, developers, and brokers:\n• Multi-criteria search filter (rooms, area, district, price, renovation)\n• Interactive Baku & Absheron location map integration\n• 360° virtual property walk-through tour\n• Property appraisal and agent consultation booking flow",
            'ru' => "🏡 **SkyVilla Realty — Агентство элитной недвижимости**\n\nСовременная платформа для застройщиков, риелторов и агентств недвижимости:\n• Многопараметрический фильтр жилья (комнаты, цена, район Баку)\n• Интерактивная карта объектов недвижимости\n• Виртуальный 360° тур по квартирам и виллам\n• Форма заявки на оценку недвижимости и просмотр",
            'tr' => "🏡 **SkyVilla Realty — Lüks Gayrimenkul Acentesi Demosu**\n\nEmlak ofisleri ve inşaat firmaları için özel geliştirilmiş emlak platformu:\n• Kapsamlı arama filtreleri (oda sayısı, fiyat, bölge, tadilat)\n• İnteraktif Bakü ve çevre bölge harita entegrasyonu\n• 360 derece sanal tur önizlemesi\n• Ücretsiz ekspertiz ve danışman randevu formu",
        ],
        'links' => [
            ['label' => '🏡 Canlı Əmlak Demosu', 'url' => '/sky/modules/web-demos/demo-realestate.php'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 13. DEMO: WHATSAPP STORE (ChatSatış Pro)
    // ─────────────────────────────────────────────
    [
        'id'       => 'demo_whatsapp',
        'topic'    => 'demo_whatsapp',
        'keywords' => ['whatsapp ticarət','chatsatış','whatsapp satış','instagram mağaza','whatsapp shopping','kataloq','whatsapp store','вотсап магазин','чат продажи','whatsapp sipariş'],
        'langs'    => [
            'az' => "💬 **ChatSatış Pro — WhatsApp Biznes Satış Kataloqu**\n\nInstagram, TikTok və pərakəndə satıcılar üçün ən sürətli satış platforması:\n• Müştəri saytda məhsulları seçir və səbətə yığır\n• 'WhatsApp ilə Sifariş Ver' düyməsinə 1 klik edir\n• Sistem seçilən məhsulların adını, qiymətini və cəmini avtomatik mesaj hazırlayıb satıcının WhatsApp nömrəsinə göndərir\n• Heç bir qeydiyyat və ya mürəkkəb ödəniş tələb etmir — 100% konversiya artımı!",
            'en' => "💬 **ChatSales Pro — WhatsApp E-Commerce Catalog**\n\nThe fastest order-taking platform for Instagram, TikTok, and retail merchants:\n• Shoppers select products and add them to the quick drawer bag\n• Clicking 'Order via WhatsApp' generates a formatted order message\n• Itemized summary with prices is instantly sent to the merchant's WhatsApp\n• Zero complex checkout friction — dramatically boosts mobile sales!",
            'ru' => "💬 **ChatSatış Pro — Продажи через каталог WhatsApp**\n\nБыстрая торговая витрина для продавцов в Instagram, TikTok и розничных магазинов:\n• Покупатель выбирает товары в удобную корзину\n• В 1 клик нажимает 'Заказать через WhatsApp'\n• Формируется готовое сообщение со списком товаров, ценами и суммой\n• Заказ отправляется напрямую в чат продавца — максимальная конверсия без лишних регистраций!",
            'tr' => "💬 **ChatSatış Pro — WhatsApp Satış Kataloğu**\n\nInstagram, TikTok ve butik satıcılar için en hızlı sipariş platformu:\n• Müşteri ürünleri seçip sepete ekler\n• 'WhatsApp ile Sipariş Ver' butonuna tıklar\n• Sipariş detayları otomatik mesaj olarak satıcının WhatsApp'ına iletilir\n• Üyelik gerektirmeden en pratik mobil satış yöntemi!",
        ],
        'links' => [
            ['label' => '💬 Canlı WhatsApp Demosu', 'url' => '/sky/modules/web-demos/demo-whatsapp.php'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 14. PRICING & SERVICE RATES
    // ─────────────────────────────────────────────
    [
        'id'       => 'pricing',
        'topic'    => 'pricing',
        'keywords' => ['qiymət','qiymətlər','neçəyədir','nə qədərdir','xidmət haqqı','tarif','paketlər','ödəniş','pulsuz','endirim','manat','azn','price','pricing','cost','how much','rates','цена','стоимость','тарифы','сколько стоит','fiyat','ücret'],
        'langs'    => [
            'az' => "💰 **SkyWeb Qiymət Siyasəti və Xidmət Haqqı**\n\nBiz hər bir layihəyə fərdi və şəffaf qiymətləndirmə ilə yanaşırıq:\n\n🆓 **Pulsuz Xidmətlərimiz:**\n• İlkin texniki məsləhət və layihə auditi\n• 11 canlı interaktiv demo layihəyə baxış\n• CV Builder əsas şablonları (0 AZN)\n\n💎 **Dəqiq Qiyməti Olan Xidmətlər:**\n• **CV Builder Premium Şablonlar:** 2.99 AZN – 4.99 AZN\n\n💼 **Fərdi Qiymətləndirilən Xidmətlər:**\n• **Vebsayt və Tətbiqlər:** Layihənin mürəkkəbliyi, dizayn tələbi və funksionallığa uyğun smeta tərtib edilir\n• **SMM və Reklam Kampaniyaları:** Aylıq idarəetmə paketi və reklam büdcəsinə əsasən müəyyən olunur\n• **Mini Oyunlar:** Seçilən oyun mexanikasına və inteqrasiyaya görə fərdi hesablanır\n\nDəqiq qiymət təklifi almaq üçün bizə müraciət edin!",
            'en' => "💰 **SkyWeb Pricing & Service Rates**\n\nWe provide transparent, tailored quotes based on exact client requirements:\n\n🆓 **Free Services:**\n• Initial technical consultation & digital audit\n• Unlimited exploration of all 11 live demo platforms\n• CV Builder basic templates (0 AZN)\n\n💎 **Fixed-Price Services:**\n• **CV Builder Premium Templates:** 2.99 AZN – 4.99 AZN\n\n💼 **Custom-Quoted Services:**\n• **Web & Mobile Apps:** Calculated based on scope, feature set, and timeline\n• **SMM & Online Ads:** Tailored monthly retainers based on channels and ad spend\n• **Branded Mini Games:** Estimated by game mechanics and gamification depth\n\nContact us for an instant, customized quote!",
            'ru' => "💰 **Цены и тарифы SkyWeb**\n\nМы предлагаем прозрачный и честный расчет стоимости под ваши задачи:\n\n🆓 **Бесплатно:**\n• Первичная консультация и технический аудит\n• Доступ ко всем 11 интерактивным демо-сайтам\n• Базовые шаблоны в Конструкторе Резюме (0 AZN)\n\n💎 **Фиксированные тарифы:**\n• **Премиум шаблоны резюме:** от 2.99 до 4.99 AZN\n\n💼 **Индивидуальный расчет:**\n• **Веб-сайты и приложения:** Стоимость формируется исходя из технического задания и функционала\n• **SMM и реклама:** Пакеты рассчитываются на основе задач и рекламного бюджета\n• **Мини-игры:** В зависимости от сложности механики игры\n\nСвяжитесь с нами для получения индивидуального коммерческого предложения!",
            'tr' => "💰 **SkyWeb Fiyatlandırma Politikası**\n\nTüm projelerimizde şeffaf ve bütçenize uygun teklifler sunuyoruz:\n\n🆓 **Ücretsiz Hizmetlerimiz:**\n• İlk teknik danışmanlık ve proje analizi\n• 11 canlı demo web sitesini inceleme\n• CV Builder temel şablonları (0 AZN)\n\n💎 **Sabit Fiyatlı Hizmetler:**\n• **CV Builder Premium Şablonlar:** 2.99 AZN – 4.99 AZN\n\n💼 **Projeye Özel Fiyatlandırma:**\n• **Web Sitesi & Uygulamalar:** İhtiyaçlarınıza, tasarıma ve özelliklere göre hesaplanır\n• **SMM & Reklam:** Aylık yönetim kapsamına ve reklam bütçesine göre belirlenir\n• **Mini Oyunlar:** Seçilen oyun mekaniğine göre fiyatlandırılır\n\nSize özel teklif almak için hemen bizimle iletişime geçin!",
        ],
        'links' => [
            ['label' => '📞 Qiymət Təklifi Al', 'url' => '#contact'],
            ['label' => '📄 CV Şablonları', 'url' => '/sky/modules/cv-builder/'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 15. HOW TO ORDER / ORDERING PROCEDURE
    // ─────────────────────────────────────────────
    [
        'id'       => 'how_to_order',
        'topic'    => 'how_to_order',
        'keywords' => ['necə sifariş edim','necə sifariş edilir','sifariş edilir','sifariş qaydası','sifariş etmək','iş prosesi','mərhələlər','how to order','ordering procedure','process','как заказать','порядок заказа','этапы работы','nasıl sipariş verilir','nasıl sipariş edilir','sipariş süreci'],
        'langs'    => [
            'az' => "🚀 **SkyWeb ilə Sifariş və Əməkdaşlıq Mərhələləri**\n\nLayihənizi sıfırdan uğurla təhvil vermək üçün 5 sadə addım:\n\n1️⃣ **Müraciət & Məsləhət:** Saytdakı əlaqə formu, telefon (+994 55 000 00 00) və ya WhatsApp vasitəsilə bizə yazırsınız.\n2️⃣ **Tələblərin Müəyyənləşdirilməsi:** Biznesinizin ehtiyaclarını dinləyir, optimal texniki həll və smeta hazırlayırıq.\n3️⃣ **Dizayn & Prototip:** Brendinizə uyğun premium UI/UX dizayn hazırlanıb təsdiqinizə verilir.\n4️⃣ **Proqramlaşdırma:** Sürətli, təhlükəsiz və təmiz kodlaşdırma icra edilir.\n5️⃣ **Test & Təhvil:** Sayt test edilir, domen və hostinqə qoşulub tam işlək vəziyyətdə təhvil verilir.\n\nLayihənizi başlamaq üçün bizimlə əlaqə saxlayın!",
            'en' => "🚀 **How to Order & Project Workflow at SkyWeb**\n\n5 seamless steps from concept to successful launch:\n\n1️⃣ **Inquiry & Consultation:** Reach out via contact form, phone (+994 55 000 00 00), or WhatsApp.\n2️⃣ **Requirements & Scoping:** We analyze your business goals and propose the ideal scope and transparent quote.\n3️⃣ **UI/UX Prototyping:** A custom, high-converting visual design is crafted for your review.\n4️⃣ **Engineering:** Modern, secure, high-performance coding across all target platforms.\n5️⃣ **Testing & Launch:** Quality assurance testing, server deployment, and handoff with 24/7 support.\n\nLet's build your next digital success story together!",
            'ru' => "🚀 **Порядок оформления заказа и этапы работы в SkyWeb**\n\n5 простых шагов от вашей идеи до готового проекта:\n\n1️⃣ **Заявка и консультация:** Напишите через форму на сайте, позвоните (+994 55 000 00 00) или напишите в WhatsApp.\n2️⃣ **Согласование ТЗ:** Обсуждаем ваши задачи, подбираем стек технологий и составляем смету.\n3️⃣ **Дизайн и прототипирование:** Разрабатываем современный UI/UX дизайн в стиле вашего бренда.\n4️⃣ **Разработка:** Программируем быстрый и безопасный функционал.\n5️⃣ **Тестирование и запуск:** Проверяем сайт, подключаем к домену/хостингу и сдаем проект под ключ.\n\nОставьте заявку сегодня, чтобы начать разработку!",
            'tr' => "🚀 **Sipariş ve Proje Süreci Nasıl İşler?**\n\nFikrinizden başarıya ulaşan 5 kolay aşama:\n\n1️⃣ **İletişim & Danışmanlık:** Sitedeki form, telefon (+994 55 000 00 00) veya WhatsApp ile bize ulaşın.\n2️⃣ **İhtiyaç Analizi:** Hedeflerinizi dinliyor, en uygun teknik planı ve şeffaf teklifi hazırlıyoruz.\n3️⃣ **UI/UX Tasarım:** Markanıza yakışan modern, kullanıcı dostu arayüz tasarımı yapıyoruz.\n4️⃣ **Kodlama & Geliştirme:** Yüksek hızlı, güvenli yazılım geliştirmesi gerçekleştiriyoruz.\n5️⃣ **Test & Canlıya Alma:** Kapsamlı testlerin ardından sitenizi anahtar teslim yayına alıyoruz.\n\nHemen projenizi başlatmak için bizimle iletişime geçin!",
        ],
        'links' => [
            ['label' => '📬 Sifariş Formu', 'url' => '#contact'],
            ['label' => '💬 WhatsApp ilə Əlaqə', 'url' => 'https://wa.me/994550000000'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 16. CONTACT & LOCATION
    // ─────────────────────────────────────────────
    [
        'id'       => 'contact',
        'topic'    => 'contact',
        'keywords' => ['əlaqə','əlaqə nömrəsi','telefon','nömrə','email','ünvan','haradasınız','ofis','saat','iş saatları','whatsapp','contact','phone','address','location','hours','baku','bakı','контакты','телефон','адрес','офис','часы работы','iletişim','telefon','adres'],
        'langs'    => [
            'az' => "📬 **SkyWeb Əlaqə Məlumatları**\n\nSualınız və ya layihəniz varsa, bizimlə əlaqə saxlamaqdan məmnun olarıq:\n\n📞 **Telefon:** +994 55 000 00 00\n💬 **WhatsApp:** +994 55 000 00 00\n📧 **E-poçt:** info@skyweb.az\n📍 **Ünvan:** Bakı, Azərbaycan\n🕐 **İş Saatları:** Bazar ertəsi – Şənbə: 09:00 – 20:00 (Bazar: İstirahət günü)\n\nSaytımızdakı əlaqə formasını dolduraraq da birbaşa müraciət edə bilərsiniz!",
            'en' => "📬 **SkyWeb Contact Details**\n\nWe'd love to hear from you regarding any inquiry or digital project:\n\n📞 **Phone:** +994 55 000 00 00\n💬 **WhatsApp:** +994 55 000 00 00\n📧 **Email:** info@skyweb.az\n📍 **Location:** Baku, Azerbaijan\n🕐 **Working Hours:** Monday – Saturday: 09:00 – 20:00 (Sunday: Closed)\n\nYou can also submit the quick contact form on our website!",
            'ru' => "📬 **Контакты SkyWeb**\n\nМы всегда рады ответить на любые вопросы и обсудить ваш проект:\n\n📞 **Телефон:** +994 55 000 00 00\n💬 **WhatsApp:** +994 55 000 00 00\n📧 **Email:** info@skyweb.az\n📍 **Адрес:** Баку, Азербайджан\n🕐 **Часы работы:** Понедельник – Суббота: 09:00 – 20:00 (Воскресенье: Выходной)\n\nТакже вы можете отправить заявку через форму связи на главной странице!",
            'tr' => "📬 **SkyWeb İletişim Bilgileri**\n\nSorularınız ve proje talepleriniz için bize her zaman ulaşabilirsiniz:\n\n📞 **Telefon:** +994 55 000 00 00\n💬 **WhatsApp:** +994 55 000 00 00\n📧 **E-posta:** info@skyweb.az\n📍 **Adres:** Bakü, Azerbaycan\n🕐 **Çalışma Saatleri:** Pazartesi – Cumartesi: 09:00 – 20:00 (Pazar: Kapalı)\n\nSitemizdeki iletişim formunu doldurarak da mesaj gönderebilirsiniz!",
        ],
        'links' => [
            ['label' => '💬 WhatsApp Çat', 'url' => 'https://wa.me/994550000000'],
            ['label' => '✉️ Əlaqə Formu', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 17. RECOMMEND SERVICE FOR BUSINESS
    // ─────────────────────────────────────────────
    [
        'id'       => 'recommend_service',
        'topic'    => 'recommend_service',
        'keywords' => ['məsləhət','nə seçməliyəm','tövsiyə','hansı sayt','biznesim var','mənə nə lazımdır','kafe üçün','restoran üçün','mağaza üçün','recommend','which service','advice','посоветуйте','что выбрать','tavsiye','hangi hizmet'],
        'langs'    => [
            'az' => "💡 **Biznesiniz üçün SkyWeb Məsləhəti:**\n\nSahənizə uyğun ən optimal həllər:\n\n• **Geyim və Butiklər:** Aura Moda demo e-ticarət + Instagram/TikTok reklamları\n• **Kafe və Restoranlar:** LəzzətExpress və ya Velvet Brew rəqəmsal menyu + WhatsApp sifarişi\n• **Aptek və Klinikalar:** Şəfa Aptek AI OCR resept sistemi + 24/7 axtarış\n• **Fitnes və İdman:** APEXFIT cədvəl və abunəlik sistemi + Meta Ads kampaniyası\n• **Kurs və Təlimlər:** EduVerse video kurs portalı + Google Search Ads\n• **Daşınmaz Əmlak:** SkyVilla interaktiv əmlak kataloqu və 360° virtual tur\n\nBiznes növünüzü mənə bildirin, sizə ən dəqiq planı təklif edim!",
            'en' => "💡 **SkyWeb Service Recommendations for Your Business:**\n\nTailored solutions based on your industry:\n\n• **Fashion & Boutiques:** Aura Fashion e-commerce + Instagram/TikTok Ads\n• **Cafes & Restaurants:** LezzetExpress / Velvet Brew online menu + WhatsApp order dispatch\n• **Pharmacies & Clinics:** Shefa Pharmacy AI OCR scanner + live stock inventory\n• **Fitness & Gyms:** APEXFIT timetable + automated membership subscription\n• **Academies & Tutors:** EduVerse course portal with video lesson player\n• **Real Estate:** SkyVilla property catalog with 360° virtual tours\n\nTell me your business type, and I'll suggest the best package!",
            'ru' => "💡 **Рекомендация SkyWeb для вашего бизнеса:**\n\nОптимальные решения под вашу сферу:\n\n• **Бутики и одежда:** Aura Moda e-commerce + реклама в Instagram и TikTok\n• **Кафе и рестораны:** Цифровое меню LezzetExpress / Velvet Brew + заказы в WhatsApp\n• **Аптеки и медицина:** Şəfa Aptek с ИИ-сканером рецептов и проверкой склада\n• **Фитнес-клубы:** APEXFIT расписание занятий + абонементы онлайн\n• **Курсы и обучение:** Платформа EduVerse с видеоуроками и личным кабинетом\n• **Недвижимость:** Каталог SkyVilla с картой и виртуальными турами 360°\n\nНапишите сферу вашего бизнеса, и я подберу готовое решение!",
            'tr' => "💡 **İşletmeniz için SkyWeb Tavsiyesi:**\n\nSektörünüze özel en doğru dijital çözümler:\n\n• **Giyim ve Butik:** Aura Butik e-ticaret + Instagram/TikTok reklamları\n• **Kafe ve Restoran:** LezzetExpress / Velvet Brew dijital menü + WhatsApp sipariş\n• **Eczane ve Sağlık:** Şifa Eczanesi yapay zeka reçete tarayıcısı + stok sistemi\n• **Fitness ve Spor:** APEXFIT ders takvimi ve online üyelik satış sistemi\n• **Eğitim ve Kurslar:** EduVerse video ders oynatıcılı akademi platformu\n• **Gayrimenkul:** SkyVilla 360° sanal turlu interaktif emlak kataloğu\n\nİşletmenizin türünü yazın, en uygun çözümü hemen önereyim!",
        ],
        'links' => [
            ['label' => '✨ 11 Demo Sayt', 'url' => '#services-modal'],
            ['label' => '💬 Fərdi Məsləhət', 'url' => '#contact'],
        ],
    ],

    // ─────────────────────────────────────────────
    // 18. GREETING
    // ─────────────────────────────────────────────
    [
        'id'       => 'greeting',
        'topic'    => 'greeting',
        'keywords' => ['salam','hər vaxtınız xeyir','sabahınız xeyir','axşamınız xeyir','hello','hi','hey','good day','привет','здравствуйте','добрый день','добрый вечер','merhaba','selam','günaydın','iyi günler'],
        'langs'    => [
            'az' => 'Salam, mən Sky botam. Sizə necə kömək edə bilərəm? Kömək edə bilməyim üçün fikrinizi sual şəklində ifadə edin.',
            'en' => "Hello, I'm Sky bot. How can I help you? Write your question so I can help you.",
            'ru' => 'Здравствуйте, я Sky bot. Чем могу помочь? Напишите ваш вопрос, чтобы я мог помочь.',
            'tr' => 'Merhaba, ben Sky bot. Size nasıl yardımcı olabilirim? Yardımcı olabilmem için sorunuzu yazın.',
        ],
        'links' => [],
    ],

    // ─────────────────────────────────────────────
    // 19. THANKS & COURTESY
    // ─────────────────────────────────────────────
    [
        'id'       => 'thanks',
        'topic'    => 'thanks',
        'keywords' => ['təşəkkür','çox sağ ol','minnətdaram','sağ olun','thank you','thanks','thx','спасибо','благодарю','teşekkür','teşekkürler','sağol'],
        'langs'    => [
            'az' => "Xoşdur! Məmnuniyyətlə kömək etdim. 😊\n\nƏlavə sualınız olarsa və ya layihənizə başlamaq istəsəniz, hər zaman buradayam. Uğurlar! 🚀",
            'en' => "You're very welcome! Glad I could help. 😊\n\nIf you have more questions or want to launch your project, I'm always here. Best of luck! 🚀",
            'ru' => "Всегда пожалуйста! Был рад помочь. 😊\n\nЕсли у вас появятся новые вопросы или вы захотите запустить проект — я всегда на связи. Успехов! 🚀",
            'tr' => "Rica ederim, yardımcı olmaktan mutluluk duydum! 😊\n\nBaşka bir sorunuz olursa veya projenizi başlatmak isterseniz her zaman buradayım. Başarılar! 🚀",
        ],
        'links' => [],
    ],

];
