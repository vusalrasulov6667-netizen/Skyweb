# SKY — BAŞLANĞIC QEYDİ (START HERE)

> **İstifadəçi «sky» yazanda ilk olaraq bu faylı oxu.**
> Sonra dəyişiklik tarixçəsi üçün `DEV-HANDOFF.md`-yə bax və işə buradan davam et.
>
> Son yenilənmə: **2026-11-27 (Brend Tapmacaları: 2 ipucu / 3 keç günlük limit, qeydiyyat gate, canlı reytinq cədvəli, Səviyyə 1–5 ✅)**
>
> Aşağıdakı studiya və təqdimat bölmələri **tarixi qeyd** olaraq qalır; aktual vəziyyət bu bölmədədir.

### 2026-11-27 qeydi — Brend Tapmacaları: günlük limitlər və reytinq cədvəli

- Gündə **2 ipucu**, **3 keç**; hər ikisi bitdikdən sonra yanlış cavab oyunu
  **yerli vaxta görə** ertəsi günə qədər dayandırır (`blockedDate`, geri sayım).
- Qeydiyyat olmayanlar yalnız **bir dəfə** oynayır; ikinci açılışda qeydiyyat/giriş
  ekranı. Qeydiyyatdan sonra `skyweb_riddles_v1_u<userId>` və günlük limitlər işləyir.
- `api/riddles-scores.php` ilə canlı **Reytinq cədvəli** (ilk 5 + `Sənin sıran`).
  Giriş + CSRF ilə POST, `LOCK_EX` JSON, yalnız maksimal bal saxlanılır.
- Rütbələr: `Səviyyə 1 · Yeni başlayan → 2 · Maraqlı → 3 · Tapmaca ustası →
  4 · Reytinq lideri → 5 · Tapmaca əfsanəsi`. `Meraklı` → `Maraqlı`.
- `Qaldığın yerdən davam et` tostu normal axışda, brand blokundan sonra;
  heç bir mətnin üstünə düşmür.
- 127 unikal mətn AZ/EN/RU/TR; yoxlamalar: riddle i18n 15/127/4 dil OK,
  riddle CDP **89 OK / 0 FAIL**, board check OK, viktorina CDP **36 OK / 0 FAIL**,
  `parity.php` 0/0/0.

### 2026-11-27 qeydi — Brend Tapmacaları: sonsuz gündəlik oyun

- İkinci kartın `Demo / Yeni Ön Baxış` düyməsi indi **oynanılır tapmaca modalı** açır:
  15 tanış xalq tapmacası qarışdırılır, bitdikdə `round` artır və sonsuz davam edir.
- Reytinq `localStorage.skyweb_riddles_v1`-də saxlanılır: düzgün cavab **+10**,
  günə bir dəfə giriş **+25**, gündə 5 düzgün cavab **+50**; yanlış/keç cəzasız.
  Rütbələr: `Yeni başlayan → Meraklı → Tapmaca ustası → Reytinq lideri`.
- Gündəlik `streak`, bir kliklik ipucu və çıxıb qayıdanda qaldığı yerdən davam var;
  taymer yox. İkon viktorinadan fərqli, gradientli lampochka SVG-dir.
- 109 unikal mətn AZ/EN/RU/TR-də. Yoxlama: `games_riddles_i18n_check.php` 15 tapmaca /
  109 literal / 4 dil OK; `cdp_games_riddles_check.js` **70 OK / 0 FAIL**.
- Viktorina (25 sual), digər 3 statik kart, navbar logosu və əvvəlki təmizlik qorunur;
  `parity.php` 0/0/0, viktorina CDP check **36 OK / 0 FAIL**.

### 2026-11-27 qeydi — Brend Viktorinası 25 suallıq + yeni loqo

- Demo artıq **25 Azərbaycan sualı** oynayır: 5 mövzu × 5 sual
  (coğrafiya, tarix, idman, incəsənət, təbiət); cavablar mənbələrdən yoxlanılıb.
- Hər sualın 4 variantı var; düzgün variant `index % 4` ilə fırladılır,
  **4 bal/sual** və 25 sual = **100 bal**; 80/40 astanaları qalır.
- Modalda mövzu etiketi və gradient SVG sual nişanı var; kart önizləməsi də
  yenilənib. **Navbar logosu dəyişməyib** — ana səhifə ilə eyni tam SVG-dir.
- 101 unikal mətn AZ/EN/RU/TR-də; `games_quiz_i18n_check.php` → 25 sual,
  101 literal, 4 dil OK; `cdp_games_quiz_check.js` → **36 OK / 0 FAIL**.
- Qiymət/qeydiyyat/kateqoriya/şans elementləri yoxdur; digər 3 kart statikdir.

### 2026-11-27 qeydi — Brend Viktorinası oynanabilir demo

- Birinci kartın `Demo / Yeni Ön Baxış` düyməsi indi səhifədə 5 suallıq viktorina açır
  (4 variant, doğru/yanlış geribildirim, bal, nəticə, yenidən oyna).
- Qeydiyyat/forma yox; bağlanma `✕`, fon klikləməsi və `Escape` ilə.
- Bütün mətnlər `i18n-literals.php` vasitəsilə AZ/EN/RU/TR-dədir.
- Yoxlama: `cdp_games_quiz_check.js` 22 OK / 0 FAIL; `games_quiz_i18n_check.php` 4 dil OK.

### 2026-11-27 qeydi — kateqoriya tabları silindi, logo tamamlandı

- `// Oyun Kateqoriyaları` və `Hamısı / Viktorina / Tapmacalar / Digər` tabları
  CSS və `filterGames()` JS-i ilə birlikdə silindi; «Oyunlara Bax» indi `#gamesGrid`-ə gedir.
- Navbar logosu ana səhifə ilə **eyni tam SVG** oldu (`skyLogoGlow`, bütün ikonlar).
- `games_cat_*` açarları 4 dildən və `i18n-literals.php`-dən çıkarıldı.
- Yoxlama: `parity.php` 0/0/0; `games_bottom_check.php` → tablar `GONE`, logo `KEEP`;
  `games_logo_parity_check.php` → **LOGO PARITY OK**; demo etiketi 4 dildə OK.

### 2026-11-27 qeydi — qeydiyyat modalı silindi, demo etiketi əlavə olundu

- `Sifariş Et` düyməsinin açdığı qeydiyyat/ödəniş modalı (`#payModal`, formalar,
  CSS və bütün JS funksiyaları) tamamilə çıkarıldı.
- Kart düymələrinin mətni **`Demo / Yeni Ön Baxış`** oldu; `onclick` yoxdur,
  sinif `game-demo-btn`, görünüş eyni tam enli vahid düymədir.
- `config/i18n-literals.php` → yeni tam ifadə üçün 4 dillik tərcümə əlavə olundu.
- Yoxlama: `parity.php` 0/0/0; `games_bottom_check.php` → modal və `Sifariş Et`
  `GONE`, demo etiketi `KEEP`; `games_demo_label_i18n_check.php` → AZ/EN/RU/TR OK.

### 2026-11-27 qeydi — qiymətlər və AzurMart tarixçəsi silindi

- Oyun kartlarındakı `Başlayan qiymət` və `220 / 340 / 160 / 320 ₼` qiymətləri silindi.
  `Sifariş Et` düymələri vahid, tam enli və kart altında sabit görünüşlüdür.
- Ödəniş modalından `Bir dəfəlik ödəniş`, `Cəmi: — AZN`, `psum-total`, `_payPrice`
  çıkarıldı; modal yalnız seçilmiş oyunu göstərir.
- Aşağıdakı `AzurMart` sifariş tarixçəsi bölməsi və onun CSS-i tamamilə silindi.
- `config/i18n-literals.php` → istifadə olunmayan 10 literal açar silindi;
  `Cəmi:` analitika modulu üçün qorundu.
- Yoxlama: `parity.php` 0/0/0; `games_bottom_check.php` → qiymətlər/AzurMart `GONE`,
  oyun kartları və modal `KEEP`.

### 2026-11-27 qeydi — qumar/kazino tipli şans oyunları silindi

- Oyunlar panelindən `Fırlanan Çarx` (🎡), `3D Şans Çarxı` (🎪),
  `Uğur Kartı Oyunu` (🃏), çarx kateqoriya tabı və TechStore tarixçə qeydi çıkarıldı.
- `lang/{az,en,ru,tr}.php` → `games_cat_wheel`, `games_item1_*` açarları silindi;
  `games_panel_desc` indi `Viktorina, Tapmaca, İdman` haqqındadır.
- `config/i18n-literals.php` → çarx/karta aid 10 literal açar silindi.
- Yoxlama: `parity.php` 0/0/0; `games_bottom_check.php` → şans oyunları `GONE`,
  qorunan elementlər `KEEP`. Ana səhifə/chatbot istinadları bu tapşırığa daxil deyil.

### 2026-11-27 qeydi — oyunlar paneli təmizləndi

- `modules/games/index.php` → aşağıdakı «Qiymət Cədvəli» və «Oyun Sifariş Formu»
  bölmələri CSS/JS ilə birlikdə silindi; oyun kartları, ödəniş modalı və sifariş
  tarixçəsi qaldı.
- Slot oyunu tamamilə çıkarıldı: kateqoriya tabı, kart, tarixçə qeydi, 4 dildə
  `games_cat_slot` / `games_item3_*` açarları və literal lüğətdəki slot açarları.
- Yoxlama: `parity.php` 0/0/0, `games_bottom_check.php` → silinənlər `GONE`, qorunanlar `KEEP`.

### 2026-11-26 qeydi — avtobioqrafiya: son 2 etiket 4 dildə ✅

- Skrinşotda işarələnən «sertifikatlar qazanmaq» (RU-da yalnız "Yeni" → "Новое" olmuşdu) və
  «Kollec / Subbakalavr» etiketləri `config/i18n-literals.php`-ə tam açarlarla əlavə olundu.
  `lang/tr.php`-də `autobio_rewrite` → «Yeniden Yaz» düzəldildi.
- Həm `?lang=` ilə birbaşa yükləmə, həm də dil düyməsi ilə **reload olmadan** keçid işləyir.
- Yoxlama: `goal_cert_i18n_check.php` 44/44, `cdp_goal_cert_switch.js` 8/8,
  `cdp_autobio_dom_scan.js` 0 AZ izi, `parity.php` 0/0/0.

### 2026-11-25 son əlavə — «Ustaların əl işləri» qalereyası ✅

- **Limitlər mərkəzdə:** `config/beauty-media.php` → `beauty_media_limits()`: foto **10 MB**,
  video **40 MB** və **30 saniyə**. Panel və demo eyni massivdən oxuyur; brauzer tez xəbərdarlıq verir,
  server (`ffprobe` ilə real uzunluq) yenidən yoxlayır. 30 s-dan uzun MP4 rədd olunur;
  `ffmpeg -t 30` ilə əlavə qoruma var.
- **Video emalı:** hər yüklənən videoya watermark + avtomatik poster kadrı (`poster-*.jpg`) və
  `duration` metadatası yazılır; isteğe bağlı iş/çəkiliş başlığı saxlanılır. Silmə posteri də silir.
- **Demo qalereyası:** bərabər bənzər grid əvəzinə **4 sütunlu redaksiya grid** — ilk kart 2×2,
  hər 4-cü və bütün video kartları geniş; video poster + play ikonu + `00:30` nişanı, başlıq,
  yumşaq hover overlay. Mobil 390 px-də tək sütun. Klikləyəndə yüngül **lightbox** açılır:
  foto/video, ox düymələri (dövr edir), Esc, fon kliklə bağlanma, scroll kilidi, ARIA.
- Yeni `gallery_view` açarı 4 dildə: **Böyüt / View / Büyüt / Открыть**. Dil seçicisi qaydası dəyişməyib.
- Yoxlama: `beauty_media_limits_check.php` **24/24 OK** (5 s video qəbul, 35 s rədd, 16.5 MB foto rədd,
  poster/duration/başlıq, demo render, 4 dil); `cdp_gallery_lightbox.js` **13/13 OK**;
  `lang_scope_check.php` ALL PASS; `cdp_errors.js` demo 4 dil + panel → 0; `php -l` təmiz.
- Test skriptləri mövcud `data/beauty-gallery.json` və `uploads/beauty/` fayllarını **snapshot/restore**
  edir — istifadəçinin real qalereyası zədələnmir. Ekran şəkilləri: `scratch/gallery-final-{desktop,mobile}.png`.
- **Demo üzərindən yükləmə (istifadəçi tələbi):** yükləmə bölməsi indi birbaşa saytın
  «Ustaların əl işləri» hissəsində də var, lakin **yalnız panelə giriş etmiş salon sahibinə** görünür
  (`id="galleryUpload"`; ziyarətçiyə heç bir forma/HTML düşmür). Foto + video formaları CSRF ilə
  `beauty-panel.php`-ə post edir, limitlər brauzerdə və serverdə yoxlanır, uğur/xəta bildirişi
  demo səhifəsində `#gallery` üzərində göstərilir. Open-redirect yoxdur (`return_to=gallery` tokeni,
  `return_lang` yalnız az/en/tr/ru). Yoxlama: `beauty_demo_upload_e2e.php` **18/18 OK**.

### 2026-11-24 son əlavə — dil seçicisi yalnız ana səhifədə ✅

- **Qayda:** dil düyməsi/menyusu yalnız `index.php`-də (desktop + mobil bar) görünür.
  `blog/faq/privacy/terms`, `auth/*`, `modules/games|analytics|cv-builder` və **11 demo**
  üzərində heç bir dil seçici yoxdur.
- `config/lang.php`: yeni `sky_is_homepage()` (SCRIPT_NAME + SITE_URL; `basename()` deyil —
  modulların `index.php`-si yanlış ana səhifə sayılmasın). Hər iki render funksiyası
  (`render_language_switcher()`, `render_mobile_language_selector()`) digər səhifələrdə `''` qaytarır.
- Demo pill-ləri və onların CSS-i 11 `demo-*.php` faylından silindi; `$lang`, `lang_url()`,
  `?lang=` deep-linkləri və hreflang saxlanıldı.
- **Dil davamlılığı dəyişmədi:** ana səhifədə seçim cookie/session + `api/set-lang.php` ilə
  bütün səhifələrə keçir; demo linklərinə `sky-i18n.js` aktiv dili əlavə edir. `?lang=` hər yerdə işləyir.
- **Sərt qoruma (cached HTML üçün):** `assets/js/sky-i18n.js` hər səhifədə köhnə
  `.lang-pills/.lang-pill/.lang-btn/.lang-switcher` düyünlərini DOM-dan silir (MutationObserver
  ilə dinamik əlavə olunanları da). Ana səhifənin `.sky-lang-*` seçicisinə toxunmur.
  `sw.js` artıq HTML-i keşləmir və köhnə keşi silir.
- Yoxlama: `scratch/lang_scope_check.php` **22 səhifə + 5 davamlılıq halı ALL PASS**;
  `scratch/cdp_lang_scope_check.js` **13/13 PASS**; `audit_switch_check.js` **24 hal → 0**;
  `cdp_cv_folder_check.js` 19/19, `cdp_skybot_check.js` 17/17, `parity.php` 0/0/0,
  `pages_smoke.php` 20/20, `cdp_errors.js` 0, `cdp_measure.js` daşma yox, `php -l` + `node --check` təmiz.
- Test yenilənmələri: `cdp_cv_folder_check.js` artıq 0 seçici gözləyir; `audit_switch_check.js`
  demoları `?lang=` ilə, digər səhifələri `SkyI18n.switchLang()` ilə yoxlayır; `cdp_header_probe.js`
  defolt olaraq `index.php`-ni ölçür.

## ✅ AKTUAL VƏZİYYƏT — dil dəyişdirmə (2026-11-23)

- `config/i18n-literals.php`: 400+ hardcoded AZ literal + `$SKY_AB_I18N` 4-dilli avtobioqrafiya şablonları; ay adları və patronymic placeholder-ləri də əlavə olundu.
- `config/lang.php` + `assets/js/sky-i18n.js`: SSR `?lang`, cookie, session, localStorage sinxron; URL yenilənir; keyed/literal/attribute/dynamic text translation; `sky-lang-changed`; browser **title** də dəyişir; MutationObserver placeholder/title/aria-label/alt/value dəyişikliklərini tutur.
- `index.php`: avtobioqrafiya tam lokallaşdırıldı, görünən mətn dil dəyişəndə yenidən qurulur; SkyBot history yenidən sorulur.
- `api/cv-service.php` + `modules/cv-builder/view.php`: saxlanılan/print CV HTML-i aktiv dildə tərcümə olunur; auth/JSON mesajları lokallaşdırıldı.
- `modules/games`, `modules/analytics`, `modules/cv-builder`: dil seçici + CSS; analitika canvas qrafikləri `sky-lang-changed` ilə yenidən qurulur.
- Bütün 11 demo shared i18n bootstrap yükləyir; demoların daxili dil pilləri SSR `?lang=` ilə işləyir (instant client re-render yox).
- Yoxlamalar OK: `php -l` (113 PHP), `node --check` (sky-i18n + inline JS), `beauty_http_smoke.php`, `beauty_design_audit.php`, `parity.php`, `cdp_errors.js`, `cdp_measure.js`, az↔en CDP (index/games/analytics/cv/demo), avtobioqrafiya və CV HTML 4 dil.
- Qalan məhdudiyyətlər: admin panelinin bir hissəsi, `manifest.json` statik AZ mətnləri, demo daxili `$t` mətnləri reload ilə dəyişir, proper names/sample data.

### 2026-11-24 əlavəsi — CV builder düzəlişi ✅
- navbar-da təkrar dil seçicisi silindi; yalnız `module-lang-switch` (sol variant) qalır, işləyir.
- «skyweb» loqosu `index.php`-dəki kimi navbar-ın sol küncündə (ilk element).
- JS ilə yaradılan «Şəxsi Qovluğunuz Boşdur...» bloku, saxlanmış CV kartları və sayğac 4 dildə (`cvT()` + 17 yeni `cv_folder_*` açarı).
- Yoxlama: `parity.php` 0/0/0, `cdp_cv_folder_check.js` 21/21 PASS, JS xəta 0, 390px-da daşma yox.

### 2026-11-24 əlavəsi — dil auditi + SkyBot yekun ✅
- `?lang=en` birbaşa yükləmə: 20 səhifə → qalan AZ literal **0** (audit əvvəl 79 tapmışdı;
  `config/i18n-literals.php`-ə 4-dilli tərcümələr əlavə olunub).
- `sky-i18n.js`: literal uyğunluğunda hərf sərhədləri — qısa açarlar xüsusi adları/törəmə sözləri pozmur.
- Klient keçidi: 8 səhifə × az→en/ru/tr = **24 keçid → 0** qalan AZ mətn/atribut
  (`scratch/audit_switch_check.js`); `cdp_skybot_check.js` **17/17 PASS**.
- `pages_smoke.php` ALL PASS, `parity.php` 0/0/0, `php -l` + `node --check` təmiz.

### 2026-11-24 son əlavə — demo keçidləri + SkyBot məntiqi ✅
- `sky-i18n.js` demo link yeniləməsi dil düymələrini (`?lang=en/ru/tr`) artıq `?lang=az` ilə üstə yazmır; 6 demo hamısında keçid işləyir.
- `index.php`-də HTML tərkibli keyed mətnlər `data-i18n-html` ilə işarələndi — client keçidində `<strong>`/`<span>` içində AZ qalmayıb.
- SkyBot: açar söz uyğunluğu hərf sərhədləri ilə (`what` ≠ `whatsapp`), cavabdan CTA/linklər silinib, xarici biznes/iş sualı `SITE_PHONE` ilə tək `tel:` linkə yönlənir; salam mətni istəyə uyğun yeniləndi.
- Yoxlama: SSR **60 hal → 0**, client-switch **24 hal → 0 / 0 SKIP**, `cdp_skybot_check.js` **17/17**, `cdp_cv_folder_check.js` **21/21**, `parity.php` **0/0/0**.

---

## ✅ AKTUAL VƏZİYYƏT — kompakt salon demosu (2026-11-22, yekun)

İstifadəçinin düzəlişi ilə **bron yenidən qaytarıldı, amma vahid yerdə**:

- **Virtual Stil Studiyası** və **Əvvəl/Sonra** saytdan çıxarılıb. `config/beauty-styles.php`,
  `beauty-studio.js`, `assets/ai/`, panelin **Stil kataloqu** tabı saxlanılır (sonrakı mərhələ üçün).
- **Tək bron tetikleyicisi:** yalnız hero-da `📅 Növbə götür` düyməsi. Header CTA, təklif CTA, sticky bar,
  üzmə düyməsi və xidmət kartı düymələri **yoxdur**; köhnə `#bookModal` markup-u qaytarılmadı.
  Forma `DK.sheet()` ilə açılır: xidmət → **qeydiyyatlı usta** → tarix/saat → ad/telefon/qeyd.
  Təsdiq pəncərəsində kod, beh və kart məlumatları göstərilir; **müştəriyə WhatsApp düyməsi yoxdur**.
- **Usta inbox-u (yeni):** uğurlu bron `beauty-booking-api.php` tərəfindən seçilmiş ustanın inboxuna mesaj
  kimi yazılır (`config/beauty-inbox.php`, `data/beauty-inbox.json`). Panelin **Mesajlar** tabında usta üzrə
  filtr, yeni/oxundu/cavablandı statusları, cavab yazma və silmə var. API cavabında `inbox_id` qaytarılır.
- **WhatsApp yalnız işçi tərəfdə:** panelə ayrı **WhatsApp** tabı əlavə olundu (qəbul / administrator /
  salon sahibi üçün). Müştəri tərəfində WhatsApp ilə bron CTA yoxdur; **footer-dəki mövcud wa.me keçidi qalır**.
- **Rəylər tək yerdə:** hero reytinqi və slogan saxlanıldı; sıralama `01 Xidmətlər · 02 Qalereya · 03 Ustalar`.
  Tək «Rəy yaz» düyməsi. Ziyarətçi fikri `action=comment` → panel **Rəylər** moderasiyası → saytda görünür.
- Ölü CSS təmizləndi, 11px fontlar 12px-ə qaldırıldı (min **12px**).

**Testlər (2026-11-22, hamısı OK):** `php -l` (demo, panel, booking API, inbox, reviews, review API, E2E),
`beauty_http_smoke.php`, `beauty_design_audit.php` (153/153 açar, undefined 0, hardcoded AZ 0), `parity.php`,
`beauty_reviews_e2e.php` (fikir axını daxil), `beauty_booking_e2e.php` (**inbox yazısı + panel status/cavab daxil**),
`beauty_panel_e2e.php`, `cdp_beauty_final_check.js` (**tək hero CTA, müştəri WhatsApp CTA 0**),
`cdp_booking_flow.js` (təsdiq pəncərəsi, `bsWa` yox), `cdp_errors.js`, `cdp_measure.js`.
Bron tokeni `scratch/_session_token.php` helper-i ilə oxunur. E2E testləri `beauty-inbox.json` daxil bütün
data fayllarını snapshot/restore edir. Köhnə nüsxələr: `_backup_apps/*.before_compact_20261122.bak`.

---

## ✅ YEKUN: Virtual Stil Studiyası tam hazırdır (tarixi — kod qorunur)

Köhnə CSS tint simulyasiyası tamamilə əvəzləndi. İndi **brauzerdə işləyən real MediaPipe Tasks Vision**
(model və wasm faylları layihə daxilindədir) müştərinin öz şəklini dəyişir. Foto serverə getmir,
ödəniş, API açarı və qeydiyyat yoxdur.

| | |
|---|---|
| Demo | `http://127.0.0.1/sky/modules/web-demos/demo-beauty.php?lang=az` |
| Panel | `http://127.0.0.1/sky/modules/web-demos/beauty-panel.php` · şifrə **`<BEAUTY_PANEL_PASSWORD>`** |
| Kataloq | `config/beauty-styles.php` — 6 kateqoriya × **30 stil**, 4 dildə |
| Kateqoriyalar | Saç rəngi · Saç düzümü · Keratin · Makiyaj · Qaş · Dırnaq |
| Mühərrik | `modules/web-demos/assets/beauty-studio.js` + `assets/ai/` (lokal wasm/model) |
| Panel | **Stil kataloqu** tabı: default stilləri redaktə/sil, öz nümunə foto yüklə, reset |
| Brif | «Ustaya göndər» → bron pəncərəsi, xidmət + seçilmiş stil/rəng qeydə yazılır |

**Real effektlər:** saç rəngi (HSL transfer + saç maskası), keratin parlaqlığı, makiyaj, qaş və dırnaq —
haması öz foto üzərində hesablanır. Saç düzümündə forma dəyişikliyi mümkün olmadığı üçün
**«Nümunə»** foto göstərilir və nişanla izah olunur.

**Landmark dəqiqliyi + geniş palitra (son düzəliş):**
- Qaş, göz kölgəsi/ayna və dırnaq çəkilişi MediaPipe landmark-larının **üstünə** düşür:
  qaş konturu birbaşa 70→46 / 300→276 nöqtələri, göz kölgəsi kirpik xətti boyunca normal ofsetlə,
  dırnaq isə **DIP→TIP** falanxı üzərində mərkəzləşir; fransız ucu düzgün istiqamətə çevrilir.
- Palitra açarları qrup üzrə unikaldır (`hair_*`, `lip_*`, `brow_*`, `nail_*`); köhnə sadə açarlar
  (`gold`, `rose`, `ash`, `chocolate`) runtime-da normalize olunur. Müştəri kataloqu hər stildə
  qrupun **bütün** tonlarını görür: saç **18**, dodaq/makiyaj **13**, qaş **10**, dırnaq **24**.
- **«Öz tonunuzu seçin»** rəng seçici (4 dildə): istənilən hex rəng çəkilir, saç üçün HSL-ə çevrilir,
  seçim çipə və ustaya göndərilən brifə yazılır.

**Yoxlamalar (2026-11-20):**
- `php -l`: `demo-beauty.php`, `beauty-styles.php`, `beauty-studio.php`, `beauty-panel.php` — təmiz.
- `node scratch/cdp_studio_probe.js az` — 6 tab, 30 stil, demo/öz foto, bütün rejimlərdə real `data:image` nəticə, JS xəta 0; swatch 18, aktiv `hair_gold`; **CUSTOM COLOR**: `#2E86AB` seçiləndə şəkil dəyişir, çipə və brifə yazılır.
- `node scratch/beauty_lang_smoke.js` — az/en/ru/tr: 6 tab, 30 stil, tərcümə, rəng seçimi (18 swatch), overflow 0, JS xəta 0.
- **`node scratch/cdp_landmark_accuracy.js`** — yeni reqressiya: qaş / göz / dırnaq rəng piksellərinin **100%-i** landmarkregionunun içində, centroid daxildə → HAMISI OK.
- `php scratch/beauty_studio_admin_e2e.php` — **HAMISI OK** (əlavə / redaktə / sil / reset; yeni unikal palitra açarları ilə).
- `php scratch/beauty_panel_e2e.php`, `beauty_booking_e2e.php`, `beauty_reviews_e2e.php` — hamısı OK.
- `node scratch/cdp_errors.js` 4 dil → 0; `node scratch/cdp_measure.js` 320–1920 → yatay daşma yox.
- `php scratch/beauty_http_smoke.php` — 4 dil + panel: HTTP 200, PHP warning/xəta yox.
- Oxunaqlıq: 18 kiçik font ölçüsü 12px-ə qaldırıldı; auditdə `<12px = 0`, min 12px.
- `php scratch/parity.php` və `beauty_design_audit.php` — missing/extra 0, undefined 0, hardcoded AZ 0.

**Təmiz vəziyyət:** `data/beauty-studio.json` yoxdur, `uploads/beauty/style-*` yoxdur; müvəqqəti
`scratch/_*`, `studio_lab.html`, `cdp_lab.js` silinib. Defolt kataloq bərpa olunub.

> **Açıq maddə (2026-11-20):** istifadəçi «bəzi şeyləri düzəltməliyik» demişdi; siyahı bu mesajda
> **dırnaq rejimi** ilə konkretləşdi və düzəldildi (aşağıya bax). Studiya ilə bağlı qalan başqa
> maddələr varsa, əvvəl istifadəçidən soruş, sonra təsdiqlənmiş vəziyyətdən davam et.

**Öz şəkilə tətbiq xətası (2026-11-20, ekran şəkli ilə ✅)**

İstifadəçi yüklədiyi şəklin («1») dəyişmədiyini, dəyişikliyin sistemin nümunə modelinə («2»)
getdiyini bildirdi. Səbəb `studioPreview()`-dakı fallback idi: öz şəkildə deteksiya uğursuz
olduqda stil nümunə model üzərində işlədilib "sonra" panelinə qoyulurdu. İndi öz foto varsa
**heç vaxt nümunə model göstərilmir** — "sonra" panelində həmin öz şəkil qalır və aydın xəta
yazılır; `detectHandRobust()` dönük/miqyaslı varyantlarla deteksiyanı gücləndirir. Test:
`node scratch/cdp_nail_fallback.js` (HAMISI OK). Ekran şəklini oxumaq üçün
`php scratch/show_image.php <fayl> [cols]`.

**Real istifadəçi fotoşəkili ilə yoxlama (2026-11-20 ✅):** istifadəçi
`<USER_DESKTOP>\nail-test.jpg` (600×900) faylını real `#studioFile` input-u ilə yükləyib,
`nl_nude` + `nail_blue #4B6A92` seçildi. Nəticə: `own: true`, `data:image`, "Nümunə" nişanı yox,
status `Nəticə hazırdır`; dəyişən piksellərin **99.9%-i** əvvəlki dırnaq rənginin üzərində, mərkəz
dırnaq cluster-ındadır. MediaPipe birbaşa **1 əl** tapdı (mərkəz 326,364) → həmin əlin 5 dırnağı
mavi oldu. Sonra şəkil: `<USER_DESKTOP>\nail-test-after.jpg`, test:
`node scratch/cdp_user_nail_test.js <şəkil> <çıxış>`.
`detectHandRobust()` artıq dönük/miqyaslı fallback-də **bütün** tapılan əlləri geri qaytarır
(əvvəl yalnız birinci əl qalırdı).

**Tam örtücü gel-lak (2026-11-21 ✅):** istifadəçi `nail-test.jpg 2.png` skrinnşotunda rəngin
dırnağı tam tutmadığını, boşluq qaldığını bildirdi. `paintNails()` indi lövhənin **faktiki uc və
kənar yayılmasını** (`nailHint()` → `alongMin/Max`, `sideMin/Max`) ölçüb ölçünü ona görə 1.18/1.20
faktorla artırır; default lövhə də 0.36→0.44 (başbarmaq 0.42→0.48), eni 0.68→0.76 (0.78→0.82)
genişləndirildi. Gel-lak qradiyenti **tam örtücü alpha=1** oldu (əvvəl 0.86–0.90 idi) — köhnə qırmızı
ton və boşluqlar görünmür, yalnız kütikula/uc ton dərinliyi və nazik işıq zolağı qalır. Test:
`node scratch/cdp_user_nail_test.js <şəkil> <çıxış>`; dəyişən piksel 1096→2684, mavi lövhələr
rəng xəritəsində tam B blokları kimi görünür.

**Birbaşa köhnə oje → seçilən rəng (2026-11-21, YEKUN ✅):** istifadəçi düzəltdi ki, məsələ
landmark ölçüsü deyil — **bir və ya iki əl şəkilində sistem köhnə dırnaqları avtomatik olaraq
seçilən stil rənginə birbaşa çevirməli, heç bir boşluq qalmamalıdır**. `process()` nails axarında
indi əvvəlcə `recolorOldNails()` orijinal şəkildəki qırmızı/bordo oje piksellərini tapıb seçilən
rənglə əvəz edir (`isOldPolish()` + flood-fill blob-lar; dəri, tünd saç və yaşıl fon istisna),
sonra landmark varsa `paintNails()` stil detallarını üstə çəkir. Beləliklə MediaPipe əli tapsa da,
tapmasa da — bütün köhnə dırnaqlar rənglənir, nümunə modelə heç vaxt keçilmir. Üz fotoşəkilində
üçdən az dırnaq lövhəsi tapıldıqda aydın `no_hand` xətası verilir.

Ölçüm: `nail-test.jpg` dəyişən piksel **2 684 → 32 284**, rəng xəritəsində heç bir `R` qalmadı
(tam `B`); `nail-test.jpg 2.png` **5 942 → 48 260**, üst-üstə düşmə 94%. `cdp_landmark_accuracy.js`
nails testi köhnə qırmızı piksellərlə üst-üstə düşməyə görə yeniləndi (78%, OK). Bütün
reqressiyalar keçdi: `cdp_user_nail_test.js`, `cdp_nail_fallback.js`, `cdp_nail_alignment.js`,
`cdp_landmark_accuracy.js`, `cdp_studio_probe.js az`.

**`nail-test-3.jpg.png` — parlaq narıncı-qırmızı oje (2026-11-21, YEKUN ✅):** yeni skrinnşotda
MediaPipe 0 əl tapdı, köhnə detektor isə `R=255` (üst hədd 252) və `h≈24°` (hədd 24°) olduğu üçün
qırmızı lövhələri görmürdü → dəyişiklik 0 piksel idi. `isOldPolish()` artıq `mx=255`-ə qədər
rəngləri və narıncı-qırmızı tonları (`h ≤ 32°`) qəbul edir; dəri qorunması üçün `g < r*0.66`,
`b < r*0.76` və doymuşluq şərtləri qalır. Nəticə: dəyişən piksel **0 → 11 138**, üst-üstə düşmə
73.7%, status `Nəticə hazırdır`, nümunə model yox. Çıxış:
`<USER_DESKTOP>\nail-test-3-after.jpg`. Bütün əvvəlki reqressiyalar yenidən keçdi.

**Dəri üzərində ləkələr (2026-11-21, YEKUN ✅):** istifadəçi bildirdi ki, studiyada stil seçdikdə
rəng yenə dırnağın əvəzinə əlin üzərində ləkə kimi görünür. Səbəb: `process()` solid stillərdə də
`paintNails()`-u çağırır, MediaPipe landmarkları səhv düşdükdə isə lövhələr dəriyə çəkilirdi.
İndi **solid stillərdə `paintNails()` ümumiyyətlə çağırılmır**; yalnız `french` / `chrome` / `art`
detalları çəkilir və onlar da `recolorOldNails()`-un qaytardığı köhnə-oje maskası ilə kəsilir
(`destination-in`). Ölçüm: `nail-test.jpg` dəyişən piksel **32 314 → 30 866** (azalan 1 448 px
məhz dəri üzərindəki artıq lövhələr idi), üst-üstə düşmə 98.2% → **98.4%**;
`nail-test.jpg 2.png` **55 250 → 53 316**, overlap 93.3% → **94.5%**. Yeni reqressiya
`node scratch/cdp_nail_style_scan.js <şəkil>` bütün 4 stil üçün `spillOutsideSolid = 0` və detalların
(`french` 117 px, `chrome` 894 px, `art` 25 px) qorunduğunu təsdiqləyir.
`cdp_nail_alignment.js` artıq köhnə dırnağı olmayan barmaqları «skip» edir (rəng tətbiq olunmur).

## Salon demosu — təqdimata hazır (2026-11-21 ✅)

Virtual studio saxlanıldı (daha toxunulmadı); salon demosu müştəriyə göstərilməyə hazırlanıb:

- **Yuxarı sıralama (2026-11-21, indi köhnə):** navbarın altında `01 Xidmətlər → 02 Əvvəl/Sonra → 03 Qalereya → 04 Ustalar → 05 Rəylər`
  pilləri əlavə edildi (`.section-index`). **2026-11-22-dən etibarən sıralama `01 Xidmətlər → 02 Qalereya → 03 Ustalar` şəklindədir.**
- **Mobil menyu:** `≤900px` düyməsi ilə açılan/bağlanan menyu (`#navToggle` / `#navLinks`, ARIA ilə).
  Bütün enlərdə (320–1920 px) üfüqi overflow **yoxdur**.
- **Mətnlər sadələşdirildi:** hero slogonu və «Kompaniya əməkdaşları üçün» təklif nişanı **yerində qaldı**;
  bölmə təsvirləri qısa, insan dili ilə yazıldı (4 dil).
- **Xidmətlər:** panel `beauty-panel.php` → «Xidmətlər və qiymətlər» artıq qiyməti, köhnə qiyməti,
  müddəti, **kateqoriyanı**, **şəkil URL**-ni və aktivliyi dəyişir, həmçinin **yeni xidmət əlavə edir**
  (ID 900+). Demo `data/demo-beauty.json`-dakı `custom: true` xidmətləri default kataloqa əlavə edir;
  sahibkarın dəyişiklikləri JSON-da qorunur.
- **Qalereya aktivdir:** `data/beauty-gallery.json` 3 foto + 1 local MP4 (hər biri salon loqosu ilə
  watermark-lanıb) ilə dolduruldu. Video artıq kart üzərində `controls` ilə deyil, **lightbox** içində
  oynayır (poster + play ikonu; 5 s, H.264). Limitlər: foto 10 MB, video 40 MB / 30 saniyə.
- **Sosiallar:** footer-dəki yazı pilləkləri müasir inline SVG iconlarla (Instagram, TikTok,
  Facebook, **WhatsApp** daxil) əvəz olundu.
- **Rəy sloganı:** «Dəyərli müştərilərimiz, fikirləriniz bizim üçün vacibdir.» (4 dildə) rəylər
  bölməsinin üstündə.

**Testlər (hamısı OK):** `php -l` (demo + panel), `beauty_http_smoke.php` (4 dil + panel),
`beauty_design_audit.php` (dil pariteti 141/141, təyin olunmamış açar 0),
`beauty_panel_e2e.php`, `beauty_service_add_e2e.php`, `beauty_booking_e2e.php`,
`beauty_reviews_e2e.php`, `cdp_measure.js` (320–1920 px overflow yox),
`cdp_beauty_final_check.js` (16 funksional yoxlama), `cdp_studio_probe.js az` (JS xəta 0).
Ekran şəkilləri: `scratch/beauty-final-desktop.png`, `scratch/beauty-final-mobile.png`.

**Dırnaq rejimi düzəlişi (2026-11-20, istifadəçi şikayəti ✅)**

1. **Yerləşmə:** lövhə bütün distal falanxı əhatə edirdi (0.66 × DIP→TIP, mərkəz ≈0.67) → rəng
   dırnağın özünə yox, onun üstündəki dəriyə düşürdü. İndi lövhə falanxın **ucunda**, kiçik ölçüdə
   (0.36 / başbarmaq 0.42), mərkəzi t≈0.82; əlavə olaraq şəkildəki faktiki rəngli lövhənin
   ağırlıqlı mərkəzinə yaxınlaşdırılır (fotoşəkildə barmaq əyrisi landmark oxundan kənara düşəndə).
2. **Rəng:** 24 nail tonu "karikatur" parlaqlıqdan real gel-lak çalarlarına dəyişdirildi; qalın tünd
   kontur və böyük ağ ellips əvəzinə incə kölgə, kütikulada tündləşən keçid, nazik işıq zolağı,
   yumşaq fransız ucu və metal xrom istifadə olunur.
3. **Yeni test:** `node scratch/cdp_nail_alignment.js` — "əvvəl" şəkildəki real dırnaq piksellərinin
   mərkəzi ilə "sonra" şəklində dəyişən piksellərin mərkəzi müqayisə olunur: 5 barmaq, mərkəzlər
   arası **2–10 px**, hamısı OK. `cdp_landmark_accuracy.js` (qaş/göz/dırnaq 100%) də keçdi.

**Ötən sessiyada bitən iş — Sky Beauty dizayn + tema + xidmət şəkilləri ✅**

Dörd düzəliş edildi və test olundu:

1. **Dizayn «insan işi» kimi** — başlıqlar Playfair Display serif, bölmə başlıqları sola düzlənmiş (qırmızı xətt),
   neon/glow effektləri zəiflədildi, mətnlər sadə dildə yenidən yazıldı.
2. **Onlayn bron forması** — açılan siyahıda ağ fonda ağ yazı problemi həll olundu (`color-scheme: dark` +
   `option` fonu, `demo-kit.css`), kristal loqo yerinə **Skyweb loqosu** qoyuldu.
3. **10 rəng teması** — hər tema üçün fon/kart/mətn çalarları PHP-də hesablanır (`$theme_palette`),
   tema düymələri JS ilə işləyir (`--dk-accent` də yenilənir).
4. **Xidmət adları + şəkillər** — 8 xidmət sadə adlarla (Balayaj, Keratin düzləşdirmə, Manikür + gel-lak,
   Pedikür + spa, Dərin təmizləmə, Axşam makiyajı, Qaş laminasiyası, Üz masajı) və uyğun real fotolarla;
   «Əvvəl / Sonra» kartlarının şəkilləri də düzgün cütlərlə əvəzləndi.

**Son əlavə — hero «SPA & SALON» kartı reklam/təklif blokudur ✅**

Hero-nun sağ kartındaki köhnə «Ən çox seçilən · Dərin təmizləmə & Balayaj · -20% ENDİRİM» yazısı
indi **paneldən idarə olunan reklam blokudur**:

- Panel → **Təkliflər** tabı: xidmət, xüsusi qiymət, **günlük/həftəlik**, **kimə aiddir (hamı / yalnız kompaniya
  əməkdaşları)**, 4 dildə qısa reklam mətni, aktiv/gizli.
- Saytda kart: dövr nişanı (GÜNÜN/HƏFTƏNİN TƏKLİFİ), kompaniya nişanı, xidmətin adı, reklam mətni,
  təklif qiyməti + üstündən xətt çəkilmiş köhnə qiymət + endirim %, **«Müraciət et»**.
- «Müraciət et» bron pəncərəsini həmin xidmət və təklif qiyməti ilə açır; kompaniya təklifində qeyd
  «Kompaniya əməkdaşı» kimi əvvəlcədən doldurulur. Bron serverdə də təklif qiyməti ilə hesablanır.
- Təklif gizlədilsə, kart əvvəlki standart görünüşünə qayıdır.

**Yoxlama:** `beauty_design_audit.php` → 122/122 parity, 0 missing, 0 undefined; `beauty_panel_e2e` (31),
`beauty_booking_e2e` (49), `beauty_reviews_e2e`, `beauty_meta_check`, `parity` → hamısı OK;
`cdp_errors` 4 dil → 0 xəta; `cdp_measure` 320–1920 → overflow yox; `cdp_panel_tabs` → 6 tab, 0 JS xəta;
CDP ilə təklif CTA → bron pəncərəsi preset 405/39 AZN yoxlanıldı.

**Ötən sessiyada bitən iş — #5-B müştəri rəyləri + işçi profilləri ✅**

Tamamlanmış ziyarətdən sonra müştəri bron kodu ilə **ulduz (1–5) + rəy** yazır → panel → **Rəylər**
tabında təsdiqlənir → saytda görünür, orta reytinq (JSON-LD də) real rəylərdən hesablanır.

| | |
|---|---|
| Demo | `http://127.0.0.1/sky/modules/web-demos/demo-beauty.php?lang=az` |
| Panel | `http://127.0.0.1/sky/modules/web-demos/beauty-panel.php` · şifrə **`<BEAUTY_PANEL_PASSWORD>`** |
| Panel tabları | Rezervasiyalar · Davamiyyət · **Ustalar** · **Rəylər** · Hesabat |
| Rəy dataları | `data/beauty-reviews.json` · usta profilləri: `data/beauty-staff.json` |
| Məntiq | `config/beauty-reviews.php` · `config/beauty-staff.php` · endpoint: `modules/web-demos/beauty-review-api.php` |
| Test | `php scratch/beauty_reviews_e2e.php` (56 yoxlama) · `node scratch/cdp_review_flow.js SB-0001` |

**Hazırda işləyir:** sayt girişi + qeydiyyat · admin paneli · şifrə bərpa
(kod `sent_emails.txt`-ə yazılır) · LAN çıxışı · **blog/faq/privacy/terms 4 dildə** ·
**Sky Beauty şablonu + paneli + onlayn rezervasiya (beh, təsdiq, davamiyyət, hesabat)** ·
**rəylər/ulduz reytinqi + usta profilləri (bio, foto, «sahibə» nişanı)**.

**Partnyor brendlər — cari vəziyyət:** `data/partners.json` → bölmə **gizli** (`visible: false`),
içində 1 brend «Baku Coffee Co.» (o da `visible: false`, URL `https://example.com`). Ona görə footer indi
2 sütunludur və ziyarətçi brend görmür. Brend «Saytda göstər» edilsə, bölmə avtomatik açılır.

**Admin şifrəsi:** `data/admin_auth.json` **mövcuddur** → default `<ADMIN_PASSWORD>` artıq **keçmir** (yoxlanıldı).
Şifrə 2026-11-15 01:42-də dəyişdirilib; yeni şifrə istifadəçidədir. İtibsə fayl silinərsə default bərpa olunur.

**Növbəti digər addımlar (prioritet sırası ilə)**

1. «Baku Coffee Co.» test brenddirsə → paneldən sil və ya «Gizlət» et, sonra real brendləri əlavə et.
2. Real istifadəçi qeydiyyatını yoxla; profil/sessiya davranışını təsdiqlə.
3. İstəyə bağlı: DB dayandıqda «Şəbəkə xətası» yerinə düzgün «Hesab sistemi əlçatmazdır» mesajı.
4. İstəyə bağlı: blog kartlarındaki «Məqaləni Oxu →» linkləri hələ `href="#"`-dir (məqalə səhifələri yoxdur).

**Sessiya başında yoxla**

- `Test-Path "C:\xamp\htdocs\sky\index.php"` → `True`
- MariaDB işləyir? `SHOW DATABASES;` → `skyweb_db` görünməlidir
- `http://localhost/sky/admin/` → HTTP 200
- `http://127.0.0.1/sky/modules/web-demos/beauty-panel.php` → HTTP 200

---

## 1. Layihə

| | |
|---|---|
| Sayt | **Skyweb.az** — rəqəmsal xidmətlər, CV builder, biznes həlləri |
| Texnologiya | PHP 8.2 + Apache (XAMPP), MariaDB 10.4 — `skyweb_db` (istifadəçi hesabları üçün) |
| Layihə kökü | `C:\xamp\htdocs\sky` (yeganə rəsmi kök) |
| Sayt ünvanı | `http://localhost/sky/index.php` |
| LAN ünvanı | `http://192.168.100.9/sky/` (Wi-Fi DHCP — IP dəyişə bilər) |
| Admin panel | `http://localhost/sky/admin/` |
| Admin girişi | istifadəçi: `admin` / şifrə: `<ADMIN_PASSWORD>` (dəyişdirilməyibsə) |
| Dil sistemi | `config/lang.php` — az / en / ru / tr |

**Hər tapşırıqdan əvvəl yoxla:** `Test-Path "C:\xamp\htdocs\sky\index.php"` → `True` olmalıdır.

---

## 2. Cari vəziyyət (2026-11-15)

### «Partnyor brendlər» bölməsi — footer-in içindədir

Footer 3 sütunludur:

```
skyweb.az brend təsviri  |  PARTNYOR BRENDLƏR  |  HAQQIMIZDA
```

- Bölmə: `<section class="footer-partners" id="partners">` — `.footer-grid`-in ortancıl uşağı.
- Responsive: ≥1150px 3 sütun · ≤1024px 2 sütun (brend tam en) · ≤768px 1 sütun.
- Bölmə publik gizli olanda footer avtomatik `no-partners` (2 sütun) görünüşünə qayıdır.
- Çiplər: loqo və ya baş hərflər + ad; ünvan varsa kliklənən link, yoxsa sadə yazı.

### İdarəetmə — yalnız adminə görünür (server tərəfində)

Render şərti: `sky_admin_is_logged_in()`. Ziyarətçinin HTML-inə heç bir düymə düşmür.

Admin görür:
- **«+ Brend Əlavə Et»** — açılan form: ad + loqo (PNG/JPG/WEBP/GIF, maks. 3 MB) + istəyə bağlı vebsayt.
- **«Saytda göstər / Saytda gizlət»** — bütün bölmənin publik görünürlüyü.
- Hər brendin altında **«Gizlət / Göstər»** və **«Sil»** (Sil `confirm()` soruşur, loqo faylını da silir).
- Bölmə gizli olsa da admin görür: qeyd + solğun «gizli» nişanları.

Endpoint: `admin/partner-action.php` — yalnız POST, girişsiz sorğu 403, CSRF yoxlanır.
Dəstəklənən: `action=add`, `toggle`, `toggle_item`, `delete` → `../index.php#partners`-ə redirect.

### Cari data (2026-11-16)

`data/partners.json` → `visible: false`, 1 brend: «Baku Coffee Co.» (özü də `visible: false`, `url: https://example.com`).
Bölmə gizli olduğu üçün publikdə render olunmur (footer `no-partners`, 2 sütun), admin isə «Bölmə gizlidir —
ziyarətçilər görmür» qeydini görür. Brend «Saytda göstər» edilsə bölmə avtomatik publik olur.
Nümunə brendlər (`Nümunə Brend A–D`) 2026-11-15-də silinmişdi; demo brendləri geri qaytarmaq lazım olsa:
`php scratch/enable_demo.php`.

---

## 3. 2026-11-14-da edilənlər

1. Köhnə ayrıca `<section class="partners-section">` + daxili `<style>` `index.php`-dən silindi.
2. Bölmə footer-in ortasına köçürüldü; `sky.css`-də 3 sütunlu grid + kompakt çiplər yazıldı.
3. Yalnız adminə görünən inline idarəetmə quruldu (`admin/partner-action.php`).
4. Hər brend üçün **«Gizlət/Göstər»** və **«Sil»** əlavə olundu.
5. `partners_footer_title` açarı 4 dilə əlavə edildi (paritet 0/0/0).
6. Ortaq funksiyalar `config/partners.php`-ə köçürüldü (panel + footer eyni kodu işlədir).
7. **Sessiya ömrü düzəldildi:** PHP defolt olaraq sessiya faylını **24 dəqiqə** sonra silirdi
   (`session.gc_maxlifetime=1440`) və cookie brauzer bağlananda yox olurdu
   (`session.cookie_lifetime=0`). Nəticədə admin yarım saat sonra «gizlicə» çıxış etmiş olurdu
   və footer-dəki düymələr yoxa çıxırdı. İndi: sessiya **1 gün**, idle timeout **12 saat**,
   hər səhifə baxışında vaxt yenilənir (`sky_admin_touch()`).

Test nəticələri: `scratch/partners_e2e.php` → **66/66 PASS**, `scratch/admin_pw_test.php` → **7/7 PASS**,
4 dildə JS xətası 0, 12 ekran enində horizontal overflow yoxdur.

### Bələdçi şəkilləri (layihə kökündə, veb-dən açılır)

| Şəkil | Nə göstərir |
|---|---|
| `admin-giris.png` → `http://localhost/sky/admin-giris.png` | Admin giriş forması: `admin` / `<ADMIN_PASSWORD>` / «Daxil ol» |
| `sil-hardadir.png` → `http://localhost/sky/sil-hardadir.png` | Footer: «+ Brend Əlavə Et» və hər brendin altındaki «Gizlət / Sil» |

---

## 3.1. 2026-11-15-də edilənlər (Faza 2 tamamlandı)

1. **Faza 2 i18n bitdi** — `index.php`-də qalan hardcoded AZ mətnləri açarlarla əvəz olundu
   (xidmət showcase panelləri 1–4, HUD metrik pərdələri, CV/Avtobioqrafiya hero kartları,
   demo/arxiv modalları, kontakt placeholder, aria-label-lər). **+47 açar × 4 dil**, paritet 0/0/0,
   lüğət 724 → **771** açar.
2. **Footer-in alt sətrinə həmişə görünən «Admin» linki** əlavə olundu
   (`<a class="footer-admin-link" href="admin/">`, `rel="nofollow"`). `footer_admin_link` açarı 4 dildə.
   `.footer-bottom-links`-ə `padding-right: 96px` (mobil: `padding-bottom: 76px`) verildi ki,
   SkyBot düyməsi sonuncu linki örtməsin.
3. **Nümunə brendlər silindi** — `data/partners.json` indi `visible: true`, `items: []`.
4. Yoxlama: `partners_e2e.php` **66/66 PASS**, `admin_pw_test.php` **7/7 PASS** (sonra
   `data/admin_auth.json` silindi → default şifrə bərpa olundu), `parity.php` 0/0/0,
   4 dil HTTP 200 + PHP xətası 0, `cdp_errors.js` 4 dil → JS xətası 0,
   `cdp_measure.js` 12 en → `scrollWidth == innerWidth` (horizontal overflow yox).

### Qalan yeganə AZ mətnlər

Yalnız **adminə görünən** footer idarəetmə sətirləri (8 sətir: «+ Brend Əlavə Et», «Brend adı»,
«Vebsayt (istəyə bağlı)», «Brendi əlavə et», «Bölmə gizlidir…», «Bölmə aktivdir…», «Saytda N brend görünür.»,
«Hələ brend yoxdur…»). Bunlar ziyarətçiyə heç vaxt render olunmur və tam admin paneli də AZ-dır —
ona görə tərcümə edilmədi. Lazım olsa ayrıca tapşırıq kimi edilməlidir.

---

## 3.2. 2026-11-15 — baza + LAN girişi

1. **`skyweb_db` quruldu** (MariaDB 10.4): `database/schema.sql` import edildi → 9 cədvəl
   (`users`, `password_resets`, `business_orders`, `cv_templates`, `cv_orders`, `mini_game_orders`,
   `payments`, `messages`, `reviews`).
2. `database/schema.sql` bərpa edildi: `users` cədvəlinin tərifi yarımçıq idi (24-cü sətirdə kəsilmişdi) →
   `avatar_url`, `is_verified`, `is_active`, `created_at`, `updated_at` + `idx_users_phone` əlavə olundu.
   Ehtiyat: `_backup_apps/schema.sql.before_users_fix.bak`.
3. DB seed admin: `admin@skyweb.az` / `<ADMIN_PASSWORD>` (rol: admin, real bcrypt hash).
4. **`config/config.php` — `SITE_URL` artıq dinamikdir**: `HTTP_HOST` + `DOCUMENT_ROOT`-dan hesablanır.
   Sayt `localhost`, `127.0.0.1` və LAN IP ilə açılanda linklər, CSS/JS və redirect-lər həmin ünvana uyğun olur.
5. LAN: Apache `0.0.0.0:80` dinləyir; `http://192.168.100.9/sky/` açılır. Wi-Fi (Private) profilində
   `C:\xamp\apache\bin\httpd.exe` üçün Allow firewall qaydası mövcuddur.
6. **Yoxlama (HTTP, hamısı keçdi):** qeydiyyat → `success=true` + DB-də sətir və UUID; e-poçtla giriş;
   telefonla giriş; yanlış şifrə → «E-poçt/telefon və ya şifrə yanlışdır»; dublikat e-poçt xəbərdarlığı;
   CSRF-siz sorğu → `403`; admin panel girişi (localhost və LAN); şifrə bərpa `send_code` → kod DB-də.
7. **Partner bölməsi publik görünürlüyü düzəldildi:** brend səviyyəsində «Saytda göstər» seçildikdə
   bölmə artıq **avtomatik** açılır (`sky_partners_auto_publish()` — `config/partners.php`).
   Əvvəl iki ayrı açar tələb olunurdu (bölmə + brend) və adi ziyarətçi heç nə görmürdü.
   Bölmənin əsas «Saytda gizlət» açarı qüvvədə qalır (hər şeyi gizlədir).

---

## 3.3. 2026-11-16 — blog/faq/privacy/terms i18n auditi ✅ + header/footer düzəlişləri

**Audit nəticəsi (əvvəl):** `faq.php`, `privacy.php`, `terms.php` artıq tam i18n idi (hardcoded AZ mətn 0).
Yeganə boşluq `blog.php`-də idi: 3 məqalə kartı (tarix/kateqoriya, başlıq, təsvir) hardcoded AZ.

**Edilənlər**

1. `blog.php` — 3 kart i18n-ləşdirildi: 9 yeni açar (`blog_post{1..3}_meta/title/desc`) × 4 dil,
   `__()` + `data-i18n` ilə. Tarix formatı dilə uyğun (az «02 İyun 2026», en «02 June 2026», ru «2 июня 2026»).
2. Yazı xətası: «inkişaf tempı» → «inkişaf **tempi**».
3. `config/lang.php` — dil seçicisində 3 hardcoded AZ sətir i18n-ləşdirildi:
   `lang_switch_aria` (Dil seçin), `lang_menu_aria` (Dil seçimi), `lang_current_aria` (seçilib).
   Artıq `aria-label`-lər 4 dildə server tərəfində çıxır.
4. **Footer «Admin» linki** `blog.php`, `faq.php`, `privacy.php`, `terms.php`-ə də əlavə olundu
   (`footer-admin-link`, `index.php`-dəki ilə eyni) → link artıq həqiqətən «hər səhifədə».
5. **Bug: blog kartları 320px-də üfüqi daşma** (scrollWidth 336 > 320). Səbəb:
   `.blog-grid { minmax(320px, 1fr) }` — viewport-dan enli minimum. Həll: `minmax(min(320px, 100%), 1fr)`.
6. **Bug: ikinci dərəcəli səhifələrdə dil seçicisi kəsilirdi** (≤430px). Səbəb: header-dəki «Ana Səhifə»
   `.btn-primary` düyməsi + loqo + dil seçicisi sığmırdı; `.nav-actions` `flex-shrink: 0` olduğu üçün düymə
   `body{overflow-x:hidden}` tərəfindən kəsilirdi (390-da sağ kənar 416). Həll: `sky.css`-də
   `@media (max-width: 600px) { .navbar .nav-actions > a.btn-primary { display: none; } }` —
   loqo onsuz da ana səhifəyə linkdir. İndi 390/360/320-də sağ kənar = viewport − 16px.

**Yoxlama**

| Test | Nəticə |
|---|---|
| `php -l` (4 səhifə + `config/lang.php`) | təmiz |
| `scratch/pages_smoke.php` (5 səhifə × 4 dil) | **20/20 PASS** — HTTP 200, PHP warning 0, nümunə mətnlər 4 dildə, `footer-admin-link`=1, boş `data-i18n`=0 |
| `scratch/parity.php` | **0/0/0** — lüğət **783** açar (771 + 12) |
| `scratch/map_keys.php` (4 səhifə) | `unmapped: 0` |
| `scratch/cdp_errors.js` (blog 4 dil + faq/privacy/terms/index) | JS xətası **0** |
| `scratch/cdp_measure.js` (blog, faq + index) | 12 en: `scrollWidth == innerWidth`, daşma **yox** |

**Yeni scratch alətləri:** `pages_i18n_audit.php` (səhifə üzrə açar auditi), `pages_smoke.php` (HTTP i18n smoke),
`enc_check.php`, `find_bad_utf8.php`, `show_keys.php`, `dump_line.php`, `cdp_header_probe.js` (header həndəsəsi),
`add_keys_blog.php`, `add_keys_lang_aria.php`. `cdp_errors.js` artıq URL-ləri arqument kimi qəbul edir.

**Ehtiyat nüsxələr:** `_backup_apps/{blog.php.before_i18n.bak, lang_{az,en,ru,tr}.before_blog_i18n.bak,
config_lang.php.before_aria_i18n.bak}`. `sky.css` dəyişikliyi yalnız 1 sətri əlavə edir (media query içində).

---

## 3.4. 2026-11-16 — Gözəllik demosu: oxunaqlıq + 4 dil + meta (#7)

Fayl: `modules/web-demos/demo-beauty.php` — yalnız bu demo. Backup:
`_backup_apps/demo-beauty.php.before_readability_i18n.bak`.

- **Şriftlər:** 14px-dən kiçik 23 ölçü düzəldildi → minimum **12px**, gövdə mətni **14–16px**; paraqraflara 1.6–1.7 sətir aralığı.
  Bron pəncərəsinin (demo-kit) kiçik etiketləri də yalnız bu demo üçün böyüdüldü.
- **4 dil pariteti:** `$demo_texts` hər dildə **81 açar** (brend adı çıxarıldıqdan və qalereya açarları əlavə olunduqdan sonra); hardcoded AZ mətn **0**.
  Xidmət müddəti və usta təcrübəsi artıq dildə formatlanır (`180 dəq / 180 min / 180 dk / 180 мин`).
  Bron sheet-inin usta siyahısı `$stylists`-dən generasiya olunur.
- **Meta:** dinamik `title`, `description`, `canonical`, `hreflang`, Open Graph, Twitter card və
  `BeautySalon` JSON-LD (4.9 / 128). Bu, #6 (reklam/sosial) üçün də əsasdır.
- **Yoxlama:** 4 dil HTTP 200 · JS xətası 0 · 320–1920px daşma yox · `php -l` təmiz.
- **Alətlər:** `scratch/beauty_design_audit.php`, `scratch/beauty_meta_check.php`,
  `scratch/cdp_beauty_shot.js`, `scratch/cdp_booking_probe.js`, `scratch/cdp_wide.js`.
  Skrinşotlar: `scratch/beauty-az-desktop.png`, `scratch/beauty-az-mobile.png`, `scratch/booking-az.png`.

---

## 3.5. 2026-11-16 (davam) — «Sky Beauty» şablonu + idarəetmə paneli

Fayllar: `config/demo-beauty.php`, `data/demo-beauty.json` (runtime), `modules/web-demos/beauty-panel.php`,
`config/beauty-media.php`, `modules/web-demos/beauty-watermark-cli.php`, `uploads/beauty/`.

- **#1 Brend bir yerdə:** salon adı yalnız `config/demo-beauty.php` → `brand.name` (panel dəyişir).
  Başlıq, header, footer, WhatsApp, OG/Twitter, JSON-LD avtomatik yenilənir.
- **#2 Təklif qiymətləri:** 90/150, 75/120, 19/25, 25/35, 49/65, 39/55, 22/30, 35/50 AZN;
  köhnə qiymət üstündən xəttli + `−N%` nişanı; panelden redaktə.
- **#3 Qalereya:** «Ustaların əl işləri» bölməsi (foto + video). Panelden loqo/foto/MP4 yüklənir;
  şəkilə GD (CLI alt-proses), videoya ffmpeg ilə **avtomatik loqo watermark** vurulur. Limitlər:
  foto **10 MB**, video **40 MB / 30 saniyə** (2026-11-25; əvvəl 25 MB idi).
- **#5-A 10 tema:** Rose (pink), Gold, Emerald, Aqua, Sapphire, Violet, Sunset, Crimson, Teal, Mono —
  həm panelden, həm demo üstündəki rəng nöqtələrindən.
- **#6 Sosial/WhatsApp:** footer-də Instagram/TikTok/Facebook + `wa.me` düyməsi; telefon/WhatsApp panelden.
- **Panel:** `http://127.0.0.1/sky/modules/web-demos/beauty-panel.php` · şifrə **`<BEAUTY_PANEL_PASSWORD>`**.
- **Testlər:** `scratch/beauty_panel_e2e.php` (22 OK), `scratch/beauty_media_e2e.php` (15 OK),
  `scratch/beauty_design_audit.php` (81×4 açar, 0 tanımsız), `scratch/cdp_errors.js`, `scratch/cdp_measure.js`.

**Hələ qalan:** #4 ✅ (2026-11-17-də bitdi — bax § 3.7) və #5-B (rəylər/ulduzlar + işçi profilləri).

---

## 3.7. 2026-11-17 — #4 onlayn rezervasiya axını ✅ (tam)

Fayllar: `config/beauty-bookings.php` (yeni), `modules/web-demos/beauty-booking-api.php` (yeni),
`modules/web-demos/demo-beauty.php`, `modules/web-demos/beauty-panel.php`, `config/demo-beauty.php`.

- **Müştəri qeydiyyatı:** bron edən hər müştəri telefon nömrəsi açarı ilə baza düşür
  (`data/beauty-customers.json`). Təkrar bronlar bir sətirdə toplanır: **ziyarət sayı**, **xərc** (yalnız
  «tamamlandı» bronlar), son bron tarixi. Panelin Rezervasiyalar tabında görünür.
- **Bron axını:** xidmət → usta → tarix/saat → ad/telefon/qeyd. Server bütün sahələri yenidən yoxlayır;
  keçmiş tarix, 90 gündən uzaq tarix, yanlış saat/telefon, tutulmuş vaxt rədd olunur. Slotlar:
  `10:00 11:30 13:00 14:30 16:00 17:30 19:00` (`BB_SLOTS`).
- **Beh:** `beh = max(minimum, round(qiymət × faiz/100))` — default **20%, min 10 AZN**.
  Nümunə: 90 AZN → 18 AZN; 19 AZN → 10 AZN. Formul `bb_deposit()`-də.
- **Kart nömrəsi:** panel → Rezervasiyalar → «Beh və kart nömrəsi». Dəyər `data/demo-beauty.json` →
  `booking` bölməsində saxlanılır. Müştəri bron edəndən sonra **bron kodu + beh + kart nömrəsi/sahibi**
  göstərilən təsdiq pəncərəsi açılır; «Ödəniş qəbzini göndər» düyməsi WhatsApp-a hazır mesajla keçir.
- **Əl ilə təsdiq:** statuslar `pending → confirmed → completed` (+ `no_show`, `cancelled`, geri qaytarma).
  Təsdiqdə `paid_at` yazılır; tamamlananda müştərinin xərcinə əlavə olunur (geri alınanda çıxılır).
- **Davamiyyət:** panel → Davamiyyət → gün seç → usta üzrə **yaşıl «İşdədir» / qırmızı «İşdə deyil»**.
  «İşdə deyil» olan ustaya həmin günə **bron qəbul edilmir** (API `stylist_off` xətası qaytarır).
  Demo saytda usta kartlarında bugünkü vəziyyət nişanı görünür.
- **Gündəlik hesabat:** panel → Hesabat → gün seç. Cəmi bron, təsdiqlənmiş, **gəlir** (yalnız təsdiq/tamam),
  **behlər**, gözləyən/gəlmədi/ləğv, **usta üzrə** cədvəl və **salon cəmi**.
- **Endpoint qoruması:** sessiya tokeni (`beauty_book_token`, CSRF), sessiya üzrə 10 dəqiqədə maks. 6 bron,
  telefon normalizasiyası (`994XXXXXXXXX`), `data/` qovluğu veb-dən 403.

**Yoxlama**

| Test | Nəticə |
|---|---|
| `php -l` (5 fayl) | təmiz |
| `scratch/beauty_booking_e2e.php` | **46/46 OK** — bron, beh 18/10, təkrar vaxt, telefon, davamiyyət, panel təsdiqi, hesabat 109/28 AZN, müştəri xərci |
| `scratch/beauty_panel_e2e.php` | 22 OK (köhnə funksiyalar pozulmayıb) |
| `scratch/beauty_media_e2e.php` | 15 OK (fixtures yenidən yaradıldı, sonda silindi) |
| `scratch/beauty_design_audit.php` | **96 açar × 4 dil**, paritet 0/0/0, tanımsız açar 0, hardcoded AZ 0, min şrift 12px |
| `node scratch/cdp_booking_flow.js az` | real brauzer: sheet → bron → təsdiq pəncərəsi (SB-0001, 18 AZN) |
| `node scratch/cdp_panel_tabs.js` | 3 tab işləyir, JS xətası 0, 360px-də daşma yox |
| `node scratch/cdp_errors.js` (4 dil + panel) | JS xətası 0 |
| `node scratch/cdp_measure.js` (demo) | 12 en: `scrollWidth == innerWidth` |
| `scratch/parity.php` | 0/0/0 |

**Yeni alətlər/skrinşotlar:** `scratch/beauty_booking_e2e.php`, `scratch/cdp_booking_flow.js`,
`scratch/cdp_panel_tabs.js`; `scratch/booking-success-az.png`, `scratch/panel-bookings.png`,
`scratch/panel-attendance.png`, `scratch/panel-report.png`, `scratch/panel-mobile.png`.

**Qeyd:** demo səhifəsi artıq `config/config.php`-i yükləyir (sessiya tokeni üçün) — başqa demolar dəyişməyib.
Panelin `booking` ayarları `save_salon` / `save_services` yazılarında da qorunur.

---

## 3.8. 2026-11-17 — #5-B rəylər/ulduzlar + usta profilləri ✅

Fayllar: `config/beauty-reviews.php` (yeni), `config/beauty-staff.php` (yeni),
`modules/web-demos/beauty-review-api.php` (yeni), `modules/web-demos/demo-beauty.php`,
`modules/web-demos/beauty-panel.php`, `config/demo-beauty.php` (usta `bio` + `owner` + defaultlar).

- **Rəy yazma:** demo saytda **«Rəylər»** bölməsi → «Rəy yaz» → bron kodu + ulduz (1–5) + mətn.
  Rəy **yalnız `completed` bron** üçün qəbul olunur, hər bron üçün bir dəfə. Panel bron cədvəlindən
  WhatsApp **«Rəy dəvəti»** linki göndərilir (`?review=SB-0001#reviews` açanda forma avtomatik açılır).
- **Moderasiya:** yeni rəy `pending` → panel **Rəylər** tabı → «Təsdiqlə və dərc et» / «Gizlət» /
  «Gözləməyə qaytar» / «Sil». Hər rəyə **salon cavabı** yazılır. Saytda yalnız `approved` görünür.
- **Reytinq:** orta bal və say **yalnız təsdiqlənmiş** rəylərdən hesablanır (`br_summary()`);
  hero-daki reytinq nişanı və **JSON-LD `aggregateRating`** dinamikdir — rəy yoxdursa ümumiyyətlə yazılmır.
- **Usta profilləri:** panel → **Ustalar** — vəzifə (4 dil), bio (4 dil), təcrübə, nişan,
  **«sahibə/sahibi»**, **foto** (JPG/PNG/WEBP ≤ 3 MB; `uploads/beauty/staff-*`) və **«Saytda göstər»**.
  Ad dəyişmir (bron və davamiyyət tarixçəsi ada bağlıdır). Gizlədilən usta saytdan və bron seçimindən çıxır,
  paneldə «Saytda gizlidir» kimi qalır.
- **Yeni demo məzmunu:** hər usta kartında bio + 👑 «Sahibə» nişanı (Leyla Qasımova), rəy kartlarında
  ulduzlar, xidmət/usta, «Təsdiqlənmiş ziyarət», salon cavabı və boş vəziyyət mesajı.
- **Endpoint qoruması:** sessiya tokeni (`beauty_review_token`, CSRF), 10 dəqiqədə maks. **4 rəy**,
  validasiya (mövcud bron, `completed`, təkrar rəy, 1–5 ulduz, 10–600 simvol) — HTTP 405/403/429/422.

**Yoxlama**

| Test | Nəticə |
|---|---|
| `php -l` (6 fayl) | təmiz |
| `scratch/beauty_reviews_e2e.php` | **56/56 OK** — validasiya, təsdiq, orta 5.0→4.5, cavab, gizlətmə, usta bio/vəzifə/foto, dəvət linki |
| `scratch/beauty_booking_e2e.php` | 46/46 OK (reqressiya) |
| `scratch/beauty_panel_e2e.php` | 22 OK (reqressiya) |
| `scratch/beauty_media_e2e.php` | 15 OK (fixtures yenidən yaradıldı, sonda silindi) |
| `scratch/beauty_design_audit.php` | **116 açar × 4 dil**, paritet 0/0/0, tanımsız açar 0, hardcoded AZ 0 |
| `node scratch/cdp_review_flow.js SB-0001` | real brauzer: forma açıldı, 5 ulduz seçildi, göndərildi, «təsdiqə göndərildi» toast |
| `node scratch/cdp_panel_tabs.js` | **5 tab** (Ustalar + Rəylər daxil) işləyir, JS xətası 0, 360px-də daşma yox |
| `node scratch/cdp_errors.js` (demo 4 dil + panel) | JS xətası 0 |
| `node scratch/cdp_measure.js` (demo) | 12 en: `scrollWidth == innerWidth` |

**Yeni alətlər:** `scratch/beauty_reviews_e2e.php`, `scratch/cdp_review_flow.js`;
skrinşotlar: `scratch/panel-staff.png`, `scratch/panel-reviews.png`.

**Test qeydi:** `cdp_panel_tabs.js` artıq `staff` və `reviews` panellərini də yoxlayır.
PHP curl massiv POST-da nested massivi (`role[az]`) mötərizəsiz göndərir — E2E-də açarlar əl ilə yazılır.

---

## 3.6. NÖVBƏTİ ADDIMLAR

1. ~~**#4 rezervasiya axını**~~ → **2026-11-17-də bitdi** (bax § 3.7).
2. ~~**#5-B rəylər + usta profilləri**~~ → **2026-11-17-də bitdi** (bax § 3.8).
3. **Real brendlər əlavə et:** `http://localhost/sky/admin/` (şifrə dəyişdirilib — default keçmir) →
   «Brendlər» bölməsi və ya saytdaki footer → «+ Brend Əlavə Et». İlk brend «Saytda göstər» edilən kimi
   bölmə publikdə görünəcək.
4. **Admin-only footer sətirlərini** (8 sətir) istəyə bağlı i18n-ləşdirmək — ziyarətçiyə görünmür.
5. ~~`blog.php`, `faq.php`, `privacy.php`, `terms.php` i18n auditi~~ → **2026-11-16-da bitdi** (bax § 3.3).

---


## 4. Vacib texniki qeydlər

- **Sessiya hosta bağlıdır.** `localhost`-da giriş `127.0.0.1`-də keçmir (və telefonun LAN IP-sində də).
  Sayta hansı ünvanla baxırsansa, admin panelinə də **eyni ünvanla** gir.
- **İKİ AYRI GİRİŞ VAR — qarışdırma:**
  - **Admin panel** → `http://localhost/sky/admin/` · `admin` / `<ADMIN_PASSWORD>`. **MySQL lazım deyil**, işləyir.
  - **Saytın «Daxil ol» düyməsi** → `auth/login.php` · e-poçt/telefon ilə. Bu, **istifadəçi hesabı** sistemidir.
    **2026-11-15-dən baza qurulub** (`skyweb_db`, MariaDB) → qeydiyyat və giriş işləyir.
    Baza dayandırılsa/silin sə `503` «Hesab sistemi hazırda əlçatmazdır» səhifəsi çıxır.
  - Sayt girişində istifadəçi adı (`admin`) yox, **e-poçt və ya telefon** yazılır. DB-dəki admin hesabı:
    `admin@skyweb.az` / `<ADMIN_PASSWORD>` (rol: admin).
- **5 səhv cəhddən sonra** admin paneli həmin brauzer sessiyasında 10 dəqiqə bloklanır
  («Çox sayda uğursuz cəhd»). Blok **sessiya əsaslıdır**: gizli pəncərə (incognito) açmaq və ya
  saytın cookie-lərini silmək bloku dərhal sıfırlayır.
- Admin panelində **«Saytda bölmə ↗»** linki var — footer-i açıb düymələri göstərir.
- Dəyişiklikdən sonra brauzerdə **Ctrl+F5** lazımdır.
- CSS/JS `?v=<?= time() ?>` ilə yüklənir — köhnə fayl keşdə qalmır.
- `sw.js` (PWA) yalnız **statik faylları** (`manifest.json`, `sky.css`, `main.js`) keşə yazır;
  **HTML/PHP sənədləri heç vaxt keşlənmir** — köhnə demo pill-ləri cached HTML-dən qayıda bilməz.
  Keş adı `skyweb-shell-v2`; köhnə `skyweb-az-cache-v1` aktivasiyada avtomatik silinir.
- `data/` qovluğu veb-dən əlçatmazdır (403). Loqolar: `uploads/partners/`.
- Ehtiyat nüsxələr: `_backup_apps/` və `_backup_how/`.

---

## 5. Test əmrləri

```powershell
# PHP sintaksis
& 'C:\xamp\php\php.exe' -l 'C:\xamp\htdocs\sky\index.php'

# Brendlər + admin E2E (özü əvvəlcə gizli/boş vəziyyətə qaytarır)
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\make_png.php'
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\partners_e2e.php'

# Şifrə dəyişmə testi (SONRA `data/admin_auth.json`-u silmək lazımdır!)
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\admin_pw_test.php'
Remove-Item 'C:\xamp\htdocs\sky\data\admin_auth.json' -ErrorAction SilentlyContinue

# Demo brendləri geri qaytar (4 nümunə, görünür)
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\enable_demo.php'

# Layout / overflow ölçmə (12 en) + JS xətaları
node 'C:\xamp\htdocs\sky\scratch\cdp_measure.js'
node 'C:\xamp\htdocs\sky\scratch\cdp_errors.js'
# istənilən səhifə üçün: node scratch/cdp_measure.js "http://127.0.0.1/sky/blog.php"
# JS xətaları üçün URL vermək olar: node scratch/cdp_errors.js "http://127.0.0.1/sky/blog.php?lang=en"

# Sky Beauty rezervasiya (#4): API + panel + hesabat (özü data fayllarını snapshot/restore edir)
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\beauty_booking_e2e.php'

# Real brauzer: bron sheet → təsdiq pəncərəsi (data faylları yaranır — sonra sil)
node 'C:\xamp\htdocs\sky\scratch\cdp_booking_flow.js' az
Remove-Item 'C:\xamp\htdocs\sky\data\beauty-bookings.json','C:\xamp\htdocs\sky\data\beauty-customers.json','C:\xamp\htdocs\sky\data\beauty-attendance.json','C:\xamp\htdocs\sky\data\beauty-inbox.json' -ErrorAction SilentlyContinue

# Paneldə 5 tab (Rezervasiyalar/Davamiyyət/Ustalar/Rəylər/Hesabat) + mobil daşma + JS xətaları
node 'C:\xamp\htdocs\sky\scratch\cdp_panel_tabs.js'

# Sky Beauty rəylər + usta profilləri (#5-B): API, moderasiya, reytinq, foto (snapshot/restore edir)
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\beauty_reviews_e2e.php'

# Real brauzer: rəy forması (əvvəlcə bir «tamamlandı» bron lazımdır — data faylları sonra silinir)
node 'C:\xamp\htdocs\sky\scratch\cdp_review_flow.js' SB-0001

# i18n: səhifə smoke (5 səhifə × 4 dil) + lüğət pariteti + hardcoded mətn auditı
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\pages_smoke.php'
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\parity.php'
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\pages_i18n_audit.php'
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\map_keys.php' blog.php

# Bir açarın 4 dildə dəyərini göstər
& 'C:\xamp\php\php.exe' 'C:\xamp\htdocs\sky\scratch\show_keys.php' blog_post1_title
```

---

## 6. Fayl xəritəsi (bu işə aid)

| Fayl | Nə üçün |
|---|---|
| `index.php` | footer markup + admin gate (`$skyPartnerAdmin`, `$skyPartnerShow`) + footer «Admin» linki |
| `assets/css/sky.css` | `.footer-grid`, `.footer-partners*`, `.fp-chip-btn*`, `.footer-admin-link` |
| `admin/partner-action.php` | footer inline əməliyyatlar (add / toggle / toggle_item / delete) |
| `admin/index.php` | tam admin panel (CRUD, sıralama, şifrə) |
| `config/partners.php` | anbar + upload/sil/URL/flash köməkçiləri |
| `config/admin.php` | giriş, sessiya, CSRF, brute-force qoruması |
| `config/config.php` | sessiya ömrü ayarları (1 gün) |
| `data/partners.json` | brendlər + bölmənin görünürlüyü |
| `lang/{az,en,ru,tr}.php` | `partners_*`, `partners_footer_title` |
| `scratch/partners_e2e.php` | 66 yoxlama |
| `admin-giris.png`, `sil-hardadir.png` | bələdçi şəkilləri (layihə kökündə, veb-dən açılır) |
| `scratch/cdp_login_guide.js`, `cdp_guide_annotated.js` | həmin şəkilləri yaradan skriptlər |
| `DEV-HANDOFF.md` | tam tarixçə və texniki qeydlər |

### Rezervasiya (#4) faylları

| Fayl | Nə üçün |
|---|---|
| `config/beauty-bookings.php` | bronlar, müştəri bazası, davamiyyət, beh hesabı, statuslar, gündəlik hesabat |
| `modules/web-demos/beauty-booking-api.php` | public bron endpoint-i (token, limit, validasiya) |
| `modules/web-demos/demo-beauty.php` | bron sheet-i, təsdiq pəncərəsi (beh/kart/kod), usta davamiyyət nişanı |
| `modules/web-demos/beauty-panel.php` | Rezervasiyalar / Davamiyyət / Hesabat tabları + kart/beh ayarı |
| `config/demo-beauty.php` | `booking` defaultları (kart nömrəsi, 20%, min 10 AZN) |
| `data/beauty-bookings.json` | bronlar (kod, status, beh, ödəniş vaxtı) |
| `data/beauty-customers.json` | müştəri bazası (telefon açarı, ziyarət, xərc) |
| `data/beauty-attendance.json` | usta davamiyyəti (gün → usta → `off`) |
| `config/beauty-inbox.php`, `data/beauty-inbox.json` | usta inbox-u: bron mesajları, status/cavab (yeni) |
| `scratch/beauty_booking_e2e.php` | bron + inbox + panel yoxlamaları (snapshot/restore ilə) |
| `scratch/cdp_booking_flow.js` | brauzerdə tam bron axını |
| `scratch/cdp_panel_tabs.js` | panel tabları, JS xətası, mobil daşma |

### Rəylər + usta profilləri (#5-B) faylları

| Fayl | Nə üçün |
|---|---|
| `config/beauty-reviews.php` | rəy anbarı, validasiya, orta reytinq, moderasiya, lokalizə olunmuş mesajlar |
| `config/beauty-staff.php` | usta profilləri: config + panel dəyişikliklərinin birləşməsi, foto yükləmə/silmə |
| `modules/web-demos/beauty-review-api.php` | public rəy endpoint-i (token, 4 rəy/10 dəq, validasiya) |
| `modules/web-demos/demo-beauty.php` | «Rəylər» bölməsi, rəy forması, usta bio/«Sahibə» nişanı, dinamik JSON-LD |
| `modules/web-demos/beauty-panel.php` | **Ustalar** və **Rəylər** tabları, moderasiya, rəy dəvəti linki |
| `data/beauty-reviews.json` | rəylər (kod, ulduz, mətn, status, salon cavabı) |
| `data/beauty-staff.json` | usta profili dəyişiklikləri (ad açarı ilə) |
| `scratch/beauty_reviews_e2e.php` | 56 yoxlama (snapshot/restore ilə) |
| `scratch/cdp_review_flow.js` | brauzerdə rəy forması axını |

### Virtual Stil Studiyası faylları

| Fayl | Nə üçün |
|---|---|
| `config/beauty-studio.php` | unikal palitra açarları, `bsx_mode_group()`, `bsx_normalize_colors()`, `bsx_effective_colors()`, `bsx_catalog(..., expandColors)` |
| `config/beauty-styles.php` | 6 kateqoriya × 30 stil (köhnə rəng açarları runtime-da normalize olunur) |
| `modules/web-demos/assets/beauty-studio.js` | landmark üzrə qaş/göz/dırnaq çəkilişi, HSL saç boyama, model yükləmənin bərpası |
| `modules/web-demos/demo-beauty.php` | 4 dildə kataloq + «Öz tonunuzu seçin» rəng seçici, brif və çiplər |
| `modules/web-demos/beauty-panel.php` | **Stil kataloqu** tabı (palitra çekbox-ları unikal açarlarla) |
| `scratch/cdp_landmark_accuracy.js` | qaş/göz/dırnaq rənginin landmark regionuna düşməsini ölçən reqressiya testi |
| `scratch/cdp_studio_probe.js` | real brauzerdə bütün rejimlərin `data:image` nəticəsi |
| `scratch/beauty_lang_smoke.js` | 4 dil üçün studiya interfeysi smoke testi |
| `scratch/beauty_studio_admin_e2e.php` | panel kataloqu → demo görünüşü → sil / reset E2E |
| `scratch/cdp_nail_alignment.js` | dırnaq rənginin real lövhəyə düşməsini ölçən reqressiya |
| `scratch/cdp_nail_style_scan.js` | 4 dırnaq stilinin dəri üzərində ləkə qoymadığını yoxlayır (`spillOutsideSolid = 0`) |
| `scratch/cdp_beauty_final_check.js` | salon demosunun son funksional CDP yoxlaması (sıralama, qalereya/video, SVG, mobil menyu) |
| `scratch/beauty_service_add_e2e.php` | panel → yeni xidmət + kateqoriya/qiymət → demo → reset E2E |
| `scratch/seed_beauty_gallery.php` | qalereya üçün lokal foto/video watermark + JSON seed |
| `scratch/cdp_nail_fallback.js` | öz foto uğursuz olduqda nümunə modelin göstərilməməsini yoxlayır |
| `scratch/show_image.php` | ekran şəkilini rəng xəritəsinə çevirir (şəkil görə bilmədikdə) |

---

## 7. İş qaydaları

1. Fayl əməliyyatından əvvəl layihə kökünü yoxla (`index.php` mövcuddurmu).
2. Yalnız tələb olunanı dəyiş; ətrafdakı kodu «təmizləmə».
3. Dəyişiklikdən sonra: PHP lint → E2E → 4 dil → responsive/overflow.
4. Testdən sonra `data/partners.json`-u nümunə vəziyyətə qaytar və müvəqqəti faylları sil.
5. **Təkrar əmr qaydası:** istifadəçi eyni əmri ikinci dəfə veribsə, bunu ona bildir və
   təkrarı **icra etmə, ləğv et** (əvvəlki nəticə artıq mövcuddursa yenidən işləmə).

---

## 8. Dil dəyişdirmə + server xəta təhlükəsizliyi (23.11.2026)

- Mərkəzi literal qatı: `config/i18n-literals.php` (400+ literal, `$SKY_AB_I18N`, ay adları).
  `config/lang.php` içində `sky_literal_map()`, `sky_translate_html_literals()`,
  `sky_translate_document_html()` köməkçiləri.
- SSR output-buffer tərcüməsi `index.php`, CV/games/analytics, auth və bütün 11 demo səhifəsində
  aktivdir. `<script>/<style>/<title>/<meta>` və şərhlər qorunur; yalnız görünən markup dəyişir.
- Səhifəyə xas target→AZ xəritəsi (`window.__SKY_SSR_REVERSE__`) output-buffer tərəfindən son
  `</body>`-dən əvvəl əlavə olunur. Bu, «Order» kimi eyni tərcüməyə malik bir neçə AZ ifadəsinin
  geri dəyişmədə yanlış bərpa olunmasının qarşısını alır.
- `assets/js/sky-i18n.js`: SSR dili əsas götürülür; keçid URL/cookie/localStorage/PHP session-a
  yazılır. EN/RU/TR→AZ və EN→RU geri qayıtmaq üçün canonical source map əlavə edildi;
  title hər keçiddə canonical AZ mənbədən yenidən qurulur.
- `assets/js/main.js`: Service Worker artıq səhifəyə görə相对 `sw.js` deyil, sayt kökündən
  (`/sky/sw.js`, scope `/sky/`) qeydiyyata alınır — alt səhifələrdə 404 yoxdur.
- Games/analytics/CV/demo səhifələrinə inline favicon əlavə edildi — browser `favicon.ico` 404-ü yoxdur.
- TR `cv_panel_title` → «CV Oluşturma Paneli», demo-food title suffixi 4 dilə localsallaşdırıldı.
- `sky_literal_map($lang)` artıq açıqca verilən dil üçün uyğun lüğəti yükləyir; saved-CV testlərində
  yanlış dil lüğəti istifadə olunmur.

### Doğrulama (son hal)
- HTTP audit: 23 səhifə × 4 dil = 92 sorğu, **0 xəta**.
- Full CDP: 17 səhifə yüklənməsi + 4 keçid axını, **0 console/network/state xətası**.
- Az↔EN reverse CDP, 4 dillik avtobioqrafiya, 4 dillik CV HTML, az→en switch testləri: hamısı OK.
- `php -l`: 114 fayl təmiz; `sky-i18n.js` və `main.js` üçün `node --check` təmiz.
- Apache `error.log`: yeni PHP xətası yoxdur (01:43–01:44-dəki müvəqqəti regex xəbərdarlıqları
  kod düzəldildikdən sonra dayandı).

### Qalan məhdudiyyətlər
- `manifest.json` statik AZ ad/təsvir saxlayır (PWA install banneri üçün).
- Demo daxili `$t` massivləri SSR `?lang=` ilə dəyişir; demək olar ki, bütün demo interfeysi
  SSR üzərindən lokal olsa da, bəzi daxili demo mətnləri client-side instant re-render olmur.
- Şəxs adları/nümunə məlumatları və bəzi admin-only sətirlər tərcümə olunmur (qəsdən).
- `blog.php` başlığı marka adı olduğu üçün EN/TR-də AZ ilə eyni qalır (audit allowlist-ində).
