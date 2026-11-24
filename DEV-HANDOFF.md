# SKY — İşin davamı (HANDOFF)

> Bu fayl sessiya davamlılığı üçündür. «sky» yazanda buradan başla.

Son yenilənmə: **2026-11-24 (demo dil düymələri + HTML-i18n + SkyBot məntiqi ✅)**

## 2026-11-24 (10) — Dil auditi + SkyBot: yarımçıq qalan yekun doğrulama ✅

**Vəziyyət:** əvvəlki sessiyada başlanan audit/düzəlişlər kodda idi, amma son yoxlama və
qeyd tamamlanmamışdı (handoff 00:18-də dayanmışdı). Bu sessiyada tamamlandı.

### Əvvəlki sessiyada edilmiş dəyişikliklər (qorundu)
- `config/i18n-literals.php` (00:45): `?lang=en` ilə açılan demoların qalan **79 AZ literalı**
  üçün 4-dilli tərcümə (kafe, whatsapp, eczane, beauty, fitness, təhsil, daşınmaz əmlak).
- `assets/js/sky-i18n.js` (19:08): literal regex-ində **hərf sərhədləri** — qısa lüğət dəyərləri
  (`Ay`, `Əli`, `Seç`) xüsusi adlarda və törəmə sözlərdə yanlış dəyişməz; uzun açarlar əvvəl gəlir.
- `skybot/chat.php`, `skybot/knowledge.php`, `index.php`, `lang/*.php` (00:54–00:58): SkyBot
  salamlaşması lokal və dilə reaktiv; tez-cavab çipləri yox; S monogramı, SVG ikonlar, textarea.

### Bu sessiyada işlədilən yoxlamalar
- `node scratch/audit_untranslated.js` — 20 səhifə `?lang=en` → **TOTAL 0** (əvvəl 79).
  Analytics/pharmacy-də bir dəfə görünən `Uncaught` race idi: təkrarda 0, `cdp_errors.js` hər ikisində xəta 0.
- `node scratch/audit_switch_check.js` — 8 səhifə × az→en/ru/tr = **24 keçid → TOTAL 0**
  (klient tərəfində dərhal keçiddə qalan AZ mətn/atribut yoxdur).
- `node scratch/cdp_skybot_check.js` — **17 PASS / 0 FAIL**.
- `scratch/pages_smoke.php` → ALL PASS; `scratch/parity.php` → 0/0/0;
  `php -l` (i18n-literals, lang, config/lang) və `node --check sky-i18n.js` → təmiz.
- Nəticə faylları: `scratch/audit_switch_result.txt`, `scratch/skybot_check_result.txt`,
  `scratch/audit_untranslated_now.txt`.

## 2026-11-24 (11) — Son düzəlişlər: demo dil düymələri, HTML-i18n, SkyBot məntiqi ✅

**Vəziyyət:** (10)-dakı yoxlamalar təkrarlandı və əlavə 3 kök səbəb tapılıb düzəldildi.

### Dəyişikliklər
- `assets/js/sky-i18n.js`: demo deep-link sinxronizasiyası `.sky-demo-btn-open` və
  `a[href*="modules/web-demos/demo-"]` seçicisində **dil seçici keçidlərini** də tuturdu;
  kafe/fitness/təhsil/daşınmaz əmlak demolarında bütün `?lang=en|ru|tr` düymələri `?lang=az`
  ilə üstə yazılırdı. `.lang-btn`, `.lang-pill`, `.sky-lang-option`, `.sky-lang-mobile-item`
  istisna edildi — indi 6 demo hamısında keçid işləyir.
- `index.php`: HTML daxilində bölünmüş keyed mətnlər (`hero_slogan`, `business_modal_lead`,
  `business_modal_adv_1..5`) `data-i18n-html` ilə işarələndi; client-side az→en/ru/tr keçidində
  `<strong>`/`<span>` içində qalan AZ parçalar tərcümə olunur (əvvəl 14 tapıntı/dil var idi).
- `skybot/chat.php`: açar söz uyğunluğu `mb_strpos()` əvəzinə `(?<!\p{L})…(?!\p{L})` hərf
  sərhədləri ilə edilir (`what` → `whatsapp` yanlışlığı aradan qalxdı); `about` və
  `how_to_order` açar sözləri AZ/EN/RU/TR formaları ilə genişləndirildi. Uyğun cavabların
  sonundaki CTA/təklif cümlələri `skybot_strip_suggestions()` ilə silinir, `links: []` qaytarılır.
  Xarici biznes/iş sualı `SITE_PHONE` üzərindən tək `tel:` linklə `external_contact` cavabı alır.
- `index.php` + `skybot/knowledge.php`: salam mətni istifadəçinin istədiyi kimi
  «…Sizə necə kömək edə bilərəm? Kömək edə bilməyim üçün fikrinizi sual şəklində ifadə edin.»
  şəklində 4 dildə sinxronlandı.
- `scratch/audit_switch_check.js` / `audit_untranslated.js`: `waitReady()` və `.lang-btn`
  fallback əlavə olundu; server restartı zamanı yaranan `createTreeWalker` xətaları yox oldu.

### Yekun yoxlama (bu sessiya)
- SSR audit: **20 səhifə × en/ru/tr = 60 hal → 0 tapıntı, 0 xəta**.
- Client-switch audit: **8 səhifə × 3 dil = 24 hal → 0 tapıntı, 0 SKIP** (demos daxil).
- `cdp_skybot_check.js` **17 PASS / 0 FAIL**; `cdp_cv_folder_check.js` **21 PASS / 0 FAIL**;
  `parity.php` **0/0/0**; `php -l` (10 fayl) + `node --check` (4 JS) təmiz.
- Endpoint: `Vebsayt necə sifariş edilir?` → `how_to_order`, `links=0`, CTA yox;
  `Hansı xidmətləri...` / `What services...` → `about`; EN/RU/TR iş sualları →
  `external_contact`, `tel:994550000000`.

## 2026-11-24 (9) — CV builder: tək dil seçici, loqo sola, şəxsi qovluq i18n ✅

**Tələb:** CV bölməsində iki dil seçicisi var, sağdakı işləmir → soldakı ilə əvəz olunsun;
«skyweb» yazısı digər səhifələrdəki kimi sola küncdə olsun; JS ilə yaradılan
«Şəxsi Qovluğunuz Boşdur / Hələ heç bir CV sənədi...» bloku və kart etiketləri tərcümə olunsun.

### Dəyişikliklər
- `modules/cv-builder/index.php`: navbardakı təkrar `render_language_switcher()` silindi; sağdan
  "düşən" seçici əvəzinə yeganə seçici olaraq əvvəlki `module-lang-switch` (sol variant, dəyişməyib)
  qaldı. Loqo indi `.nav-inner`-in **ilk uşağı** — `index.php`-dəki kimi sol küncdə (x=55 @1440,
  container content-box ilə eyni). ID təkrarı (`sky-lang-selector`, `sky-lang-btn`) aradan qalxdı.
- Yeni `cvT()` helper-i JS-in yaratdığı düyümlər üçün aktiv dili `<html lang>`-dən oxuyur
  (`sky-lang-changed` event-i `applyLang`-dən sonra gəlir). `renderSavedCvsLocal()` /
  `renderSavedCvsGrid()` indi boş qovluq başlığı, izahat, CTA, status pill-ləri, kart əməliyyatları,
  tooltip-lər və «N ədəd» sayğacı üçün lüğət açarlarından istifadə edir (köhnə `btn_copy`,
  `cv_count_unit` açarları yenidən istifadə olundu — duplikat reverse-map yox).
- `lang/{az,en,ru,tr}.php`: 17 yeni `cv_folder_*` açarı (paritet 0/0/0).

### Yoxlama
`php -l` (CV index + 4 lang), `scratch/parity.php` (0/0/0), yeni
`node scratch/cdp_cv_folder_check.js` → **21 PASS / 0 FAIL**: tək seçici + kliklə EN keçidi,
loqonun sol mövqeyi, az/ru/tr ilk yüklənmədə tərcümə, saxlanmış kart düymələrinin EN tərcüməsi,
390px-da daşma yox, JS xətası 0.

## 2026-11-23 (8) — Tam dil sinxronizasiyası: AZ / EN / RU / TR ✅

**Tələb:** «Dil dəyişəndə saytda görünən hər şey dərhal yeni dilə keçsin; CV və avtobioqrafiya
generasiyası/exportları da seçilən dildə yazılsın; tam olmayan yerlər ayrıca bildirilsin.»

**Qərar:** `lang/*.php` keyed dictionary-ləri saxlanıldı, üstünə mərkəzi AZ literal qatı və reverse lookup əlavə
olundu. SSR `<html lang>` / `?lang` / cookie / session / localStorage mənbə kimi qəbul edilir; client tərəfdə
`SkyI18n` bütün keçidləri sinxronlaşdırır. Avtobioqrafiya hazır AZ mətni regex ilə tərcümə edilməyib,
`$SKY_AB_I18N` ilə 4 ayrı dildə qurulur. Saxlanılan CV HTML-i açılış anında aktiv dilə çevrilir.
SkyBot köhnə cavabları əvvəlki dildə qoymamaq üçün dil dəyişəndə əsas sualı yenidən soruyur; analitika
canvas etiketləri `sky-lang-changed` ilə yenidən qurulur; browser title də SSR dəyərindən tutulub dəyişdirilir.

### Dəyişikliklər
- `config/i18n-literals.php`: 400+ hardcoded AZ literal, ay adları, patronymic placeholder-ləri, gerb/meta/SkyBot/
  analytics/CV mesajları; `$SKY_AB_I18N` 4-dilli avtobioqrafiya şablonları (RU `born_full` double-period düzəldildi).
- `config/lang.php`: `sky_literal_translate()`, `sky_translate_html_literals()`, genişləndirilmiş client payload
  (`__SKY_I18N_DATA__`, `__SKY_REVERSE__`, `__SKY_LITERALS__`, `__SKY_AB__`).
- `assets/js/sky-i18n.js`: URL sync, SSR title capture/apply, mixed text nodes, attribute və dynamic text/
  `characterData` observer, `attrApplied` stale-source qorunması, `sky-lang-changed`.
- `index.php`: lokallaşdırılmış avtobioqrafiya generatoru, copy/download/PDF etiket və fayl adları, dil dəyişəndə
  yenidən generate, lokallaşdırılmış SkyBot JS.
- `api/cv-service.php`, `modules/cv-builder/view.php`: printable/saved CV bölmə başlıqları və `<html lang>`,
  auth/contact JSON mesajları lokallaşdırıldı.
- `modules/cv-builder`, `modules/games`, `modules/analytics`: ortaq dil seçici + CSS; qrafiklər dilə reaktiv.
- `modules/web-demos/demo-*.php` (11 fayl): ortaq i18n bootstrap; daxili dil pilləri SSR `?lang=` ilə işləyir.
- `SKY_START_HERE.md`: aktual vəziyyət qeydi yeniləndi.

### Yoxlamalar
`php -l` (113 PHP), `node --check` (`sky-i18n.js` + inline JS), `beauty_http_smoke.php`,
`beauty_design_audit.php`, `parity.php`, `cdp_errors.js`, `cdp_measure.js`, az↔en CDP
(index/games/analytics/cv/demo + title), avtobioqrafiya və CV HTML 4 dil — hamısı OK.

### Qalan məhdudiyyətlər
Admin panelinin bəzi hardcoded AZ sətrləri; `manifest.json` statik AZ name/description; demo daxili `$t`
mətnləri instant re-render əvəzinə SSR `?lang=` reload ilə dəyişir; proper names və nümunə məlumatlar dəyişməz qalır.

## 2026-11-22 (7) — Düzəliş: bron qaytarıldı, ustanın inboxuna düşür, WhatsApp işçiyə aid ✅

**Tələb (istifadəçinin korreksiyası):** «Burada WhatsApp-a yönəltmək deyil, **Növbə götür** lazım idi —
amma bir yerdə olsun. Müştəri sifariş vermək istəsə, seçdiyi **qeydiyyatlı ustanın inboxuna mesaj kimi**
düşsün. WhatsApp bölməsi isə yalnız **qəbul / administrator / salon sahibinə** məxsusdur.»
(Altındakı footer WhatsApp keçidi qalır.)

**Qərar:** (6)-dakı «bron UI-si çıxarıldı, əvəzinə WhatsApp» qərarı **ləğv olundu**. Rəylər və studiya/Əvvəl-Sonra
qərarları qüvvədə qalır.

### `modules/web-demos/demo-beauty.php`
- Header və təklif CTA linkləri silindi; yalnız hero-da tək `<button class="btn-hero-book" onclick="openBookingModal('General')">📅 Növbə götür</button>` qaldı.
- Bronze JS (`BEAUTY_SERVICES`, `BEAUTY_SLOTS`, `BEAUTY_STYLISTS`, `BEAUTY_BOOK_TOKEN`, beh ayarları,
  `openBookingModal`, `submitBooking`, `showBookingSuccess`) backup-dan qaytarıldı, lakin **yığcam** formada:
  köhnə `#bookModal`, sticky bar, üzmə düyməsi və xidmət kartı düymələri yoxdur; forma `DK.sheet()` ilə açılır.
- Yeni`təsdiq pəncərəsi `#bookingSuccess` yalnız kod / xidmət / usta / vaxt / qiymət / beh / kart / sahib göstərir.
  **Müştəriyə WhatsApp düyməsi (`bsWa`) yoxdur.** Ölü `.btn-book-top` / `.hero-offer-cta` CSS-i də silindi.
- `bb_settings($bd_over)` və `$bookToken` yenidən HTML-ə yazılır (təhlükəsiz: sessiya tokeni).

### Yeni: `config/beauty-inbox.php` + `data/beauty-inbox.json`
- `bi_add()`, `bi_list($master)`, `bi_counts()`, `bi_find()`, `bi_set_status()`, `bi_reply()`, `bi_delete()`,
  `bi_master_names()`. Mesajlar `BM-XXXX`, status `new|read|replied`, usta adı ilə açarlanır.
- `modules/web-demos/beauty-booking-api.php` uğurlu `bb_create_booking()`-dən sonra mesajı yazır və cavabda
  `inbox_id` / `inbox_ok` qaytarır. Uğursuz bron mesaj yaratmır.

### `modules/web-demos/beauty-panel.php`
- Yeni **Mesajlar** tabı: usta filtri, status sayğacları, «Oxundu», cavab formu (`inbox_reply`) və silmə
  (`inbox_delete`) əməliyyatları, CSRF ilə.
- Yeni **WhatsApp** tabı (yalnız panel girişi olan işçilər): salon nömrəsi və `wa.me` linki, müştəri tərəfdə
  WhatsApp bron CTA olmadığı qeyd olunur. Ayrı rol sistemi yoxdur — panelin özü işçi girişidir.

### Test/status
- `beauty_booking_e2e.php`: `beauty-inbox.json` snapshot-a əlavə olundu; ustaya görə mesaj, müştəri/telefon,
  status `new`, panel `read`/`replied` yoxlamaları əlavə olundu.
- `cdp_beauty_final_check.js`: tək hero CTA, müştəri `a[href*=wa.me]` = 0 (footer istisna), təsdiq modalı və
  `bsWa` yoxluğu yoxlanılır. `cdp_booking_flow.js` `.is-open` və `waButton:false` üçün yeniləndi.
- `beauty_panel_e2e.php`: təklifdə əlavə CTA olmaması yoxlanılır (köhnə `openBookingModal(403,'corporate')` gözləntisi dəyişdirildi).
- Hamısı OK: `php -l`, HTTP smoke, design audit (153/153), parity, panel/reviews/booking E2E,
  `cdp_beauty_final_check.js`, `cdp_booking_flow.js az`, `cdp_errors.js`, `cdp_measure.js`.
- Clean state: `data/beauty-inbox.json` yoxdur (E2E özü yaradıb bərpa edir).

## 2026-11-22 (6) — Saytı kompaktlaşdır: studiya, bron UI və təkrar rəylər çıxarıldı ✅

> **Qeyd (7)-dən:** bu bölmədəki «bron UI-si WhatsApp ilə əvəz olundu» qərarı sonradan ləğv edildi.
> Studiya / Əvvəl-Sonra / rəylər qərarları qüvvədədir.

**Tələb:** «virtual studio ləğv olunsun (hələ lazım deyil), reylər sözü bir yerdə olsun,
rey yaz və reylər bölməsi tək olsun, reylərə fikir bildirmek (reply) olsun, onlayn növbə paneli
götürülsün, əvvəl-sonra paneli götürülsün (ustaların əl işi kifayətdir), sayt kompakt və başa
düşülən olsun.»

**Qərar:** dəyişikliklər yalnız **ictimai demo** və rəy axınındadır; studiya kodu/konfiqi, bron API-si,
panel və məlumatlar sonrakı istifadə üçün qorundu. Backup-lar: `_backup_apps/*.before_compact_20261122.bak`.

### `modules/web-demos/demo-beauty.php`
- Studiya məlumat bloku, `ba-section` (Əvvəl/Sonra) və Virtual Stil Studiyası markapı, ölü CSS
  (`.studio*`, `.ba-*`, `.bsum*`, `.modal-*`, `.float-book-btn`, `.btn-serv-book`), studiya/üstünlük JS-i
  və `beauty-studio.js` include-u çıxarıldı (~51 KB kod).
- Onlayn bron: header/hero/təklif CTA-ları indi `https://wa.me/<phone>?text=...` linkləridir
  (`contact_wa`, `wa_general_msg`, `wa_service_msg` — 4 dil). `data-dk-sticky` və üzmə düyməsi yoxdur.
  Sessiya `beauty_book_token`-i bron API-si üçün saxlanır, amma artıq HTML/JS-ə yazılmır.
- Nav və `.section-index` indi 3 keçid: `01 Xidmətlər & Qiymətlər · 02 Qalereya · 03 Peşəkar Ustalar`.
  Rəy sloganı və hero reytinqi qaldı; ikinci «Rəy yaz» düyməsi çıxarıldı.
- Hər rəy kartına `data-review-id` və «💬 Fikir bildir» düyməsi əlavə olundu (`openReplySheet` →
  `action=comment`). Təsdiqlənmiş fikirlər `br_public_comments()` ilə rəy kartında göstərilir.
- Yeni 12 i18n açarı × 4 dil; 11px fontlar 12px-ə qaldırıldı (audit: min 12px).

### `config/beauty-reviews.php`
- `BR_MIN_COMMENT=10`, `BR_MAX_COMMENT=400`, `comments_next` sayacı.
- `br_public_comments()`, `br_pending_comments()`, `br_add_comment()`, `br_set_comment_status()`.
- Fikirlər rəyin `comments` massivində `pending` olaraq saxlanır; 4 dilə lokalizə olunmuş xəta mesajları.

### `modules/web-demos/beauty-review-api.php`
- `action=comment` (`id` = `RV-XXXX`, `text`) — eyni CSRF tokeni və 4/10 dəqiqə limiti; cavab
  `{ok:true, action:"comment", id:"CM-0001", status:"pending"}`.

### `modules/web-demos/beauty-panel.php`
- `pendingComments` sayacı, `comment_status` handler-i (approve/hide).
- «Rəylər» tabında **«Rəylərə gözləyən fikirlər»** kartı və rəy kartlarında təsdiqlənmiş fikirlər.

### Testlər və alətlər
- `scratch/beauty_reviews_e2e.php`: yeni 4b bölməsi — fikir → pending → panelə düşmə → təsdiq → saytda görünmə.
- `scratch/beauty_booking_e2e.php` və reviews E2E: token artıq HTML-də olmadığı üçün
  `scratch/_session_token.php` helper-indən oxunur (`#HttpOnly_` cookie prefixi də nəzərə alındı).
- `scratch/cdp_beauty_final_check.js`: 5 əvəzinə 3 sıralama maddəsi, WhatsApp CTA-ları, köhnə
  bölmələrin olmaması, tək «Rəy yaz», hər rəy kartında fikir düyməsi yoxlanılır.
- Hamısı OK: `php -l` (4 fayl), `beauty_http_smoke.php`, `beauty_design_audit.php` (153/153),
  `parity.php`, `beauty_reviews_e2e.php`, `beauty_booking_e2e.php`, `cdp_beauty_final_check.js`,
  `cdp_measure.js` (320–1920 px overflow yox), `cdp_errors.js`.
- Müvəqqəti patch skriptləri (`_compact_patch.php`, `_css_cleanup.php`) silindi.

## 2026-11-21 (5) — Salon demosu: təqdimat/shablon hazırlığı ✅

**Tələb:** «demo variantını test et, içerini biraz sadələşdir, yuxarıda sıralama olsun, slogan və
kompaniya xidməti yerində qalsın, xidmət qiymətini sahibkar dəyişə/add yeni xidmət edə bilsin,
ustaların əl işi foto+video bölməsini aktivləşdir, sosial iconları WhatsApp ilə müasirləşdir,
rəylərə slogan əlavə et, hamısını telefon + komputer üçün test et.»

**Qərar:** virtual studiyaya daha toxunulmadı (istifadəçi «keç sonra baxarıq» dedi). Dəyişikliklər
yalnız salon demosu və panelindədir.

### `modules/web-demos/demo-beauty.php`
- Yeni i18n açarları (4 dil): `section_index_label`, `nav_menu`, `reviews_slogan`.
- Navbarın altında `.section-index` — 01..05 nömrəli 5 keçid. `≤640px` yatay scroll, kiçik ekranda
  sıra sığmır.
- Mobil menyu: `#navToggle` + `#navLinks` (`aria-expanded`, `is-open`), açıldıqda link/outside/Escape
  ilə bağlanır. `≤900px` əvvəl `.nav-links { display:none }` idi, indi işləyir.
- Sadələşdirmə: hero/section/footer təsvirləri qısaldıldı, lakin **hero sloganı** və
  **«Kompaniya əməkdaşları üçün»** təklif nişanı dəyişmədi.
- Rəy sloganı: `Dəyərli müştərilərimiz, fikirləriniz bizim üçün vacibdir.` (az; en/tr/ru uyğun).
- Data loader: default xidmətlərə JSON-dan `cat` / `img` tətbiq olunur; `custom: true` olan yeni
  xidmətlər kataloqa əlavə edilir və `active === false` olduqda gizlənir.
- Footer: 4 text pill əvəzinə inline SVG (Instagram, TikTok, Facebook, WhatsApp / `wa.me/`).

### `modules/web-demos/beauty-panel.php`
- Yeni sabitlər: `BEAUTY_SERVICE_CATS`, `BEAUTY_CAT_LABELS`.
- `bp_state()`: `cat`, `img`, `custom` sahələrini oxuyur; JSON-dakı yeni xidmətləri də state-ə qatır.
- `save_services`: kateqoriya və şəkil URL-ni də yazır.
- `add_service`: ID `max(900, max+1)`, 4 dildə ad/təsvir, qiymət/köhnə qiymət/müddət/kateqoriya/
  şəkil; `custom: true` ilə `data/demo-beauty.json` → `services` altına yazılır.

### Qalereya
- Yeni lokal media: `uploads/beauty/work-hair.jpg`, `work-nails.jpg`, `work-style.jpg`,
  `work-demo.mp4` (5 s, H.264, 640×480). Hamısı `logo.png` ilə watermark-landı.
- `data/beauty-gallery.json`: 3 foto + 1 video. `scratch/seed_beauty_gallery.php` seed/apply edir.
- Demo `<video controls preload="metadata" playsinline>` artıq real faylı göstərir.

### Test nəticələri
`php -l` təmiz; `beauty_http_smoke.php` 4 dil + panel 200/təmiz; `beauty_design_audit.php` 141/141
dil açarı, 0 təyin olunmamış; `beauty_panel_e2e.php`, `beauty_service_add_e2e.php`,
`beauty_booking_e2e.php`, `beauty_reviews_e2e.php` hamısı OK; `cdp_measure.js` 320–1920 px
overflow yox; `cdp_wide.js 320` yalnız qalereya studio scrollerlərində kəsilmə göstərir (səhifə
scrollWidth = 320); `cdp_beauty_final_check.js` 16/16 OK; `cdp_studio_probe.js az` JS xəta 0;
`cdp_nail_style_scan.js` `spillOutsideSolid = 0`.

## 2026-11-21 (4) — «Elin üstünə ləkələr vurur»: landmark lövhələri dəriyə düşürdü ✅

**Şikayət:** «yene elin ustune lekeler vurur … virtual sutudio olan yere bir secim etmisem bax».

**Kök səbəb:** `process()` nails axarında `paintNails()` hər hansı `handsFound` olduqca çağırılırdı,
hətta `design: 'solid'` olduqda belə. MediaPipe bəzən dırnaq əvəzinə barmaq falanxının ortasına /
qonşu dəriyə landmark qoyur; gel-lak lövhəsi oraya çəkilirkən əlin üzərində ləkə görünürdü.

**Düzəliş (`modules/web-demos/assets/beauty-studio.js`):**
- `recolorOldNails()` artıq `mask` qaytarır — yalnız köhnə oje pikselləri (1 px genişlətmə ilə).
- `process()` indi `paintNails()`-u **yalnız** `french` / `chrome` / `art` dizaynları üçün çağırır;
  `solid` / `nude` / `burgundy` / `almond` stillərində heç çağırılmır.
- Detal təsviri `destination-in` ilə həmin maskaya kəsilir, sonra təmiz recolor üzərinə qoyulur.
  Beləliklə landmark yanlış olsa belə dəri rənglənmir.

**Ölçüm:**
| Şəkil | Əvvəl dəyişən px | Sonra dəyişən px | Overlap |
|---|---:|---:|---:|
| `nail-test.jpg` | 32 314 | **30 866** | 98.2% → **98.4%** |
| `nail-test.jpg 2.png` | 55 250 | **53 316** | 93.3% → **94.5%** |

Azalan piksellər məhz dəri üzərindəki artıq lövhələrdir. Yeni `scratch/cdp_nail_style_scan.js`
reqressiyası: `solid/french/chrome/art` — hamısı `spillOutsideSolid = 0`; dizayn detalları qalır
(`french` 117 px, `chrome` 894 px, `art` 25 px). `cdp_nail_alignment.js` köhnə dırnağı olmayan
barmaqları artıq skip edir. Bütün reqressiyalar keçdi: `node --check`, `cdp_user_nail_test.js`
(3 şəkil), `cdp_nail_fallback.js`, `cdp_nail_alignment.js`, `cdp_landmark_accuracy.js`
(nails 81%), `cdp_studio_probe.js az` (JS xəta 0).

## 2026-11-21 (3) — `nail-test-3.jpg.png`: parlaq narıncı-qırmızı oje görünmürdü ✅

**Şikayət:** «nail test 3 jpg yaratdim bax orda olan problem cox boyukdur onu duzet». Yeni
skrinnşot (832×787) üzərindəMediaPipe 0 əl qaytardı, `recolorOldNails()` isə heç bir lövhə tapmadı →
`diffN = 0`, aydın `no_hand` xətası. İstifadəçi isə görünən köhnə dırnaqların dəyişməsini tələb etdi.

**Kök səbəb:** şəkildəki oje `RGB ≈ (255,112,16)` idi. `isOldPolish()`-da `mx > 252` üst həddi və
`h ≤ 24°` hue həddi bu rəngi rədd edirdi (`mx = 255`, `h ≈ 24.1°`). Daha relaxed yoxlamada
`leftRed` regionunun 3836/8000 pikseli köhnə rəngə uyğun gəlirdi, lakin heç biri detektora düşmürdü.

**Düzəliş (`modules/web-demos/assets/beauty-studio.js`):**
- `isOldPolish()`: `mx` üst həddi qaldırıldı (255-ə qədər), hue diapazonu `h ≤ 32°`-yə genişləndirildi.
- Dəri/fon qorunması dəyişmədi: `d ≥ 52`, `s ≥ 0.38`, `r > 105`, `g < r*0.66`, `b < r*0.76`.
  Məsələn dəri `(208,160,128)` üçün `g=160 > 208*0.66=137` olduğu üçün rədd edilir.

**Ölçüm:** dəyişən piksel **0 → 11 138**, üst-üstə düşmə 73.7%, status «Nəticə hazırdır»,
`isSampleBadge: false`, nümunə model yox. Rəng xəritəsində sol və aşağı-sağ qırmızı zolaqlar `B`
(mavi) oldu; əl/dəri sahəsi dəyişmədi. Çıxış: `<USER_DESKTOP>\nail-test-3-after.jpg`.

**Reqressiya (hamısı keçdi):** `node --check`, `cdp_user_nail_test.js` (üç şəkil),
`cdp_nail_fallback.js`, `cdp_nail_alignment.js`, `cdp_landmark_accuracy.js`,
`cdp_studio_probe.js az` (JS xəta 0). Müvəqqəti `_debug` exportu və diaqnostika skriptləri silindi.

## 2026-11-21 (2) — İstifadəçi düzəltdi: landmark deyil, köhnə oje birbaşa rənglənməlidir ✅

**Şikayət (son mesaj):** «el paylasanda ve ya iki el paylasada sistem avtomatikk kohne
dirnalqari secim olunan stil reng nedirse ona bir basa cevirsin bele yene tam olmayib» —
yəni bir və ya iki əl şəkilində sistem köhnə dırnaqları seçilən rəngə **birbaşa** çevirməli,
heç bir boşluq qalmamalıdır. Əvvəlki lövhə genişləndirmə/alpha düzəlişi kifayət etmirdi.

**Kök səbəb:** iki problem var idi. (1) `process()` yalnız `paintNails()`-a güvənirdi — o isə
yalnız MediaPipe tapdığı əllərin landmark lövhələrini boyayır, qalan köhnə dırnaqlar rəngsiz
qalırdı. (2) Yeni əlavə edilmiş `recolorOldNails()` işləmirdi, çünki `findOldNailPixels()`-daki
flood-fill qonşu piksellərin rəngini yoxlamırdı — tək bir toxum piksel bütün şəkli bir lövhəyə
birləşdirir, `ok` guard-u isə onu rədd edirdi. Bundan əlavə boş hue diapazonları tünd saçı,
yaşıl fonu və dərini köhnə oje sanırdı.

**Yekun düzəliş (`modules/web-demos/assets/beauty-studio.js`):**
- `isOldPolish()`: parlaq, doymuş **qırmızı/bordo/narıncı-qırmızı** oje (`mx≥95`, `d≥52`,
  `s≥0.38`, `r>105`, `g<r*0.66`, `b<r*0.76`; hue `≥325°` və ya `≤32°`). Yaşıl fon, tünd saç,
  dəri istisna.
- `findOldNailPixels()`: flood-fill hər qonşuda `isOldPolish()`-u yenidən yoxlayır; lövhə
  ölçüsü şəklin 12%-nə qədər, en/hündürlük 62%-nə, nisbət 0.22–4.5, `fill≥0.12`.
- `recolorOldNails()`: üz tapıldıqda üz sahəsini istisna edir; əl tapılmadıqda yalnız dırnaq
  ölçüsündə (≥120 px, ≥9×9) lövhələri qəbul edir və **≥3 lövhə** tələb edir → üz fotoşəkili
  aydın `no_hand` xətası ilə uğursuz olur, nümunə model göstərilmir. Köhnə rəng yeni rənglə
  `f = 0.90 + 0.20*lum` ilə əvəz olunur (1 px antialias genişlətməsi ilə).
- `process()` nails: əvvəlcə `recolorOldNails(src, …)`, sonra landmark varsa `paintNails(base, …)`
  üstə stil detallarını çəkir. Landmark yoxdursa, köhnə lövhələr tapıldıqda nəticə qaytarılır.
- `scratch/cdp_landmark_accuracy.js` nails testi yeniləndi: artıq tək landmark regionu əvəzinə
  köhnə qırmızı piksellərlə üst-üstə düşmə yoxlanır (78%, OK).

**Ölçüm (hamısı keçdi):**
| Şəkil | Əvvəl dəyişən px | Sonra dəyişən px | Üst-üstə düşmə |
|---|---|---|---|
| `nail-test.jpg` | 2 684 | **32 284** | 98.2% — rəng xəritəsində `R` qalmadı, tam `B` |
| `nail-test.jpg 2.png` | 5 942 | **48 260** | 94.2% |

Reqressiya: `node --check`, `cdp_user_nail_test.js` (hər iki şəkil), `cdp_nail_fallback.js`
(üz foto → aydın xəta, nümunə yox), `cdp_nail_alignment.js`, `cdp_landmark_accuracy.js`,
`cdp_studio_probe.js az` (JS xəta 0). Sonra şəkillər: `<USER_DESKTOP>\nail-test-after.jpg`
və `nail-test-2-after.jpg`.

## 2026-11-21 — Rəng dırnağı tam örtmürdü: boşluqlar aradan qaldırıldı ✅

**Şikayət:** istifadəçi masaüstünə `nail-test.jpg 2.png` (877×712 skrinnşot) qoydu və bildirdi ki,
seçilən yeni rəng dırnağı tam tutmur, kənarlarda/orta hissədə boşluq qalır, köhnə ton görünür.

**Səbəb:** `paintNails()` lövhəni sabit kiçik ölçüdə (0.36 × DIP→TIP) çəkirdi və gel-lak qradiyenti
yarımşəffaf idi (alpha 0.86–0.90). Faktiki dırnaq landmark oxundan və ya default ölçüdən kənara
çıxdıqda rəng lövhənin hamısını örtmür, altındakı qırmızı oje görünürdü.

**Düzəliş (`modules/web-demos/assets/beauty-studio.js`):**
- `nailHint()` artıq ağırlıqlı mərkəzlə yanaşı `alongMin/alongMax` və `sideMin/sideMax` qaytarır.
- `paintNails()` lövhənin uc/kənar yayılmasını 1.18/1.20 faktorla genişləndirir; clamp
  `[0.22..0.52] × falanx` və `[0.18..0.48] × falanx`. Default ölçü 0.44/0.48, eni 0.76/0.82.
- Gel-lak qradiyenti tam opak (`alpha = 1`); kütikulada tündləşmə və uçda açılma yalnız ton
  dərinliyi üçün, şəffaflıq üçün deyil. Fransız/xrom/nail-art üst qatları opak bazanın üzərində qalır.
- `scratch/cdp_user_nail_test.js` artıq iki arqument qəbul edir: `<şəkil> <çıxış faylı>`.

**Yoxlama:** orijinal `nail-test.jpg` üzərində dəyişən piksel **1096 → 2684**, rəng xəritəsində
mavi lövhələr tam `B` blokları oldu; yeni `nail-test.jpg 2.png` skrinnşotunda deteksiya + rəng
tətbiqi uğurlu (`data:image`, "Nümunə" yox, 5942 dəyişən piksel). Reqressiya: `node --check`,
`cdp_nail_alignment.js`, `cdp_landmark_accuracy.js` (100%), `cdp_nail_fallback.js`,
`cdp_studio_probe.js az` — hamısı keçdi.

## 2026-11-20 — İstifadəçinin öz fotoşəkili real olaraq test edildi ✅

İstifadəçi masaüstünə `nail-test.jpg` (600×900) olaraq əl/dırnaq şəkli qoydu və «hazır» yazdı.
Yeni `scratch/cdp_user_nail_test.js` skripti faylı **real `#studioFile` input-u** ilə yükləyir,
`nl_nude` stilini və `nail_blue #4B6A92` rəngini seçir, nəticəni piksel-səviyyəsində ölçür.

**Nəticə:** `own: true`, `cat: nails`, `mode: Canlı nəticə`, `afterIsData: true`,
`isSampleBadge: false`, `sameAsBefore: false`, status «Nəticə hazırdır». MediaPipe birbaşa
deteksiyada **1 əl** tapdı (landmark mərkəzi 326,364); dəyişən piksellərin 99.9%-i əvvəlki qırmızı
dırnaq piksellərinin üzərinə düşdü, dəyişiklik mərkəzi dırnaq cluster-ındadır (370,290).
Nəticə faylı: `<USER_DESKTOP>\nail-test-after.jpg`. Kadrdakı qalan qırmızı formalar
MediaPipe tərəfindən əl kimi tanınmayan ikinci əl/dekorativ dırnaqlardır — mühərrik yalnız tapdığı
əlin 5 dırnağını boyayır, nümunə modelə əvəz etmir.

**Kiçik düzəliş:** `beauty-studio.js` → `detectHandRobust()` dönük/miqyaslı fallback-lərdə
`r.landmarks[0]` əvəzinə **bütün `r.landmarks`** massivini orijinal koordinatlara qaytarır;
`numHands: 2` olduqda ikinci əl itmir. `node --check` təmiz.

**Reqressiya (hamısı keçdi):** `cdp_user_nail_test.js`, `cdp_nail_fallback.js`,
`cdp_nail_alignment.js`, `cdp_studio_probe.js az`, `php -l scratch/crop_image.php`.

## 2026-11-20 — Dırnaq nəticəsi öz şəkil yerinə nümunə modeldə görünürdü ✅

**Şikayət (istifadəçi ekran şəkli ilə):** «1» yüklədiyi öz əl şəkli, «2» sistemin verdiyi
nümunə dırnaq modelidir. Seçilmiş stil/rəng 1-ə yox, 2-yə tətbiq olunurdu.

**Səbəb:** `demo-beauty.php` → `studioPreview()` öz şəkildə `BeautyStudio.process()` uğursuz
olduqda (`no_hand`) eyni stili `demoUrl` (nümunə model) üzərində yenidən işlədib nəticəni
`studioPhotoAfter`-ə yazırdı. `studioFallback()` də `pick.img` (Pexels dırnaq fotoşəkili) ilə
"sonra" panelini doldururdu. Yəni istifadəçi öz şəkilinin dəyişdiyini zənn edirdi, halbuki
dəyişən sistem modeli idi. Qeyd: bütün 6 dırnaq stilinin `mode`-u `nails`-dır; problem fallback
axarındadır, stil konfiqurasiyasında deyil.

**Düzəliş:**
- `studioPreview()`: öz foto ilə uğursuzluqda demo üzərində yenidən işlətmə tamamilə çıxarıldı.
- `studioFallback()`: `studioState.own` olduqda "sonra" panelinə **həmin öz foto** (`objectUrl`)
  qoyulur, "Nümunə" nişanı qoyulmur, açıq xəta mesajı göstərilir. Nümunə model yalnız öz foto
  yüklənməyib, demo rejimdə işlənəndə göstərilir.
- 4 dildə `nohand` / `fallback` mesajları «nümunə model göstərilmir, aydın əl/dırnaq şəkli
  yükləyin» şəklində yeniləndi.
- `beauty-studio.js` → `detectHandRobust()`: öz fotoşəkilində əl tapılmadıqda 90°/180°/270°
  dönük və 0.78 miqyaslı varyantlar da sınanır, tapılan landmark-lar orijinal ölçüyə qaytarılır.
  Yaxın dırnaq fotoşəkillərində deteksiya şansı artır; uğursuz olduqda yalançı nümunə əvəzinə
  aydın xəta verilir.
- **Yeni reqressiya:** `scratch/cdp_nail_fallback.js` — üz şəkli dırnaq rejimində yüklənəndə
  `after === before === blob:` olmalı, "Nümunə" nişanı yox, xəta mesajı var. HAMISI OK.
  `scratch/show_image.php` — ekran şəkillərini rəng xəritəsinə çevirən köməkçi (model şəkli
  birbaşa görə bilmədikdə).

**Reqressiya (hamısı keçdi):** `node --check`, `php -l`, `cdp_nail_alignment.js`,
`cdp_landmark_accuracy.js` (100%), `cdp_studio_probe.js az`, `beauty_lang_smoke.js` (4 dil),
`beauty_studio_admin_e2e.php`, `beauty_http_smoke.php`, `beauty_design_audit.php`,
`parity.php`, `cdp_errors.js`.

## 2026-11-20 — Dırnaq rejimi: lövhə yerləşməsi + real rəng ✅

**Şikayət:** dırnaq stilini seçəndə «əvvəl/sonra» müqayisəsində rəngli lövhələr dırnağın üzərinə
yox, onun yuxarı hissəsinə (dəriyə) düşür; rənglər də karikatur görünür, real oje rəngi deyil.

**Səbəb:** `paintNails()` lövhəni bütün distal falanxa yayırdı (`nailLen = 0.66 × DIP→TIP`,
mərkəz ≈0.67), halbuki fotoşəkildə lövhə falanxın ucunda (t≈0.75–0.85) və daha kiçikdir.

**Düzəliş:**
- `modules/web-demos/assets/beauty-studio.js`:
  - ölçü 0.36 (başbarmaq 0.42), mərkəz t≈0.82; `nailHint()` dəri rənginə görə faktiki lövhənin
    ağırlıqlı mərkəzini tapır, nəticə clamp ilə landmark oxuna yaxın saxlanır; uğursuz olduqda
    PIP→DIP / DIP→TIP əyriliyi ilə korreksiya;
  - qalın tünd kontur və böyük ağ ellips çıxarıldı → incə kölgə, kütikulada tündləşən qradiyent,
    nazik blur-lu işıq zolağı, yumşaq fransız ucu və çox mərhələli metal xrom.
- `config/beauty-studio.php`: 24 nail tonu real gel-lak çalarlarına dəyişdirildi (açarlar və
  adlar eyni qaldı — panel, çip və brif dəyişmədi).
- Yeni reqressiya: `scratch/cdp_nail_alignment.js` — real dırnaq pikselləri ilə dəyişən piksellərin
  mərkəzləri 5 barmaqda 2–10 px fərqlənir, HAMISI OK.

**Reqressiya (hamısı keçdi):** `node --check`, `php -l`, `cdp_landmark_accuracy.js` (100%),
`cdp_studio_probe.js az`, `beauty_lang_smoke.js` (4 dil), `beauty_studio_admin_e2e.php`,
`beauty_http_smoke.php`, `beauty_design_audit.php`, `parity.php`, `cdp_errors.js`, `cdp_measure.js`
(320–1920 daşma yox). Ehtiyat: `_backup_apps/{beauty-studio.js,beauty-studio.php}.before_nail_fix.bak`.

## 2026-11-20 — Virtual Stil Studiyası: real nəticə + panel kataloqu ✅

**Tələb:** köhnə CSS tint deyil, müştərinin öz şəklində real görünən dəyişiklik; ödənişsiz,
açarsız, qeydiyyatsız; stilist kataloqu panelden idarə olunsun; bütün salon demosu 4 dildə hazır olsun.

### Yeni qat
- `modules/web-demos/assets/ai/` — MediaPipe Tasks Vision (JS + wasm + model) lokal olaraq bundled.
  `BeautyStudio.configure()` `base`-ni `document.baseURI` ilə absolut edir → modul yolu xətası yoxdur.
- `modules/web-demos/assets/beauty-studio.js` — rejimlər: `hair`, `gloss`, `makeup`, `brow`, `nails`, `sample`;
  xəta kodları: `no_hair`, `no_face`, `no_hand`, `sample`. Nəticə həmişə `data:image/jpeg...` olur.
- `config/beauty-styles.php` — 6 kateqoriya × 30 stil, hamısı 4 dildə:
  `hair_color`, `hair_style`, `keratin`, `makeup`, `brow`, `nails`.
- `config/beauty-studio.php` — palitranın açarları, `bsx_catalog()`, `bsx_all_styles()`, `bsx_style()`,
  `bsx_save_style()`, `bsx_delete_style()`, nümunə foto yükləmə/silmə.
- Panel override-ları `data/beauty-studio.json`; default stil silinəndə `deleted: true` yazılır;
  fərdi stillər `cs_...`, fotolar `uploads/beauty/style-*`; reset hər ikisini təmizləyir.

### Real effektlər
- Saç rəngi: MediaPipe saç maskası + HSL transfer (balayage, kül, mis, şokolad və s.); rəng seçimi canlı təsir edir.
- Keratin: saç maskası daxilində parlaqlıq/hamarlıq; makiyaj: dodaq + göz + yanaq; qaş: ton/forma;
  dırnaq: əl şəklini aşkar edib lövhəyə rəng. Üz/əl tapılmasa nümunə modelə fallback.
- Saç düzümü: cari texnologiya ilə real forma dəyişikliyi yox → **«Nümunə»** badge ilə referans foto.
- Bütün hesablama brauzerdə; şəkil heç vaxt serverə göndərilmir; «Şəkli sil» + `beforeunload` təmizləyir.

### Panel
- `modules/web-demos/beauty-panel.php` → **Stil kataloqu** tabı: default stilləri redaktə et / gizlət / sil,
  yeni stil + öz nümunə fotosunu yüklə, reset ilə defolta qaytar.

### Yoxlamalar
- `php -l`: `demo-beauty.php`, `beauty-styles.php`, `beauty-studio.php`, `beauty-panel.php` — təmiz.
- `node scratch/cdp_studio_probe.js az` — 6 tab, 30 stil, demo + öz foto, bütün rejimlərdə real `data:image`, JS xəta 0.
- `node scratch/beauty_lang_smoke.js` — az/en/ru/tr: 6 tab, 30 stil, doğru tərcümə, swatch, overflow 0, JS xəta 0.
- `php scratch/beauty_studio_admin_e2e.php` — **HAMISI OK**.
- `php scratch/beauty_panel_e2e.php`, `beauty_booking_e2e.php`, `beauty_reviews_e2e.php` — reqressiya OK.
- `node scratch/cdp_errors.js` 4 dil → 0; `node scratch/cdp_measure.js` 320–1920 → daşma yox.
- `php scratch/beauty_http_smoke.php` — 4 dil + panel: HTTP 200, PHP warning/xəta yox; şəbəkə auditində 404 və JS xətası 0.
- Son cilalama: `BeautyStudio.warm()` reject-i tutulur; model yükləmə promise-ləri uğursuzluqda sıfırlanır (yenidən cəhd mümkün).
  18 kiçik font ölçüsü 12px-ə qaldırıldı → `beauty_design_audit.php`: `<12px = 0`, min 12px; `cdp_measure.js` 320–1920 → daşma yox.
- `php scratch/parity.php`, `beauty_design_audit.php` — missing/extra 0, undefined 0, hardcoded AZ 0.
- `data/beauty-studio.json` yox, `uploads/beauty/style-*` yox, `scratch/_*` / `studio_lab.html` / `cdp_lab.js` silinib.

### Son cilalama: landmark dəqiqliyi + geniş palitra + öz tonu ✅

**Problem:** qaş/göz/dırnaq rəngi landmark-ların yanına (aşağısına) çəkilirdi; eyni adlı palitra
açarları (`black`, `red`, `gold`) PHP massivində üst-üstə yazılıb tonları itirirdi; müştəri yalnız
stilistin seçdiyi bir neçə tonu görürdü.

**Həll:**
- `beauty-studio.js`:
  - `bandPath()` — göz kölgəsi kirpik xəttinin **normali boyunca** qalınlaşır (köhnə `y - hgt` düzbucaqlı əvəzinə).
  - Eyeliner qanadı **xarici küncdən** (`p[0]` = 33 / 362) çıxır, daxili küncdən deyil.
  - Qaş konturu birbaşa kanonik `BROW_L/R` nöqtələri (70→46 / 300→276) üzərində doldurulur;
    `straight`/`arch` formaları kiçik lokal ofsetlə verilir, kontur aşağı qatlanmır.
  - Dırnaq ölçüsü **DIP→TIP** (`[3,7,11,15,19]→[4,8,12,16,20]`) üzərindən hesablanır,
    lövhə barmaq ucunda mərkəzləşir, lokal +Y uc istiqamətidir (fransız ucu düzgün tərəfə), nazik kontur əlavə olundu.
- `config/beauty-studio.php`:
  - `bsx_mode_group()`, `bsx_normalize_colors()`, `bsx_effective_colors()`; `bsx_catalog()` yeni
    `$expandColors` parametri ilə müştəriyə qrupun **bütün** tonlarını verir (panel isə öz seçimini saxlayır).
  - Açarlar unikaldır: `hair_*` (18), `lip_*` (13), `brow_*` (10), `nail_*` (24).
    Köhnə `chocolate`→`brow_dark_brown`, `ash`→`brow_taupe`, `rose`→`nail_pink` alias-ları runtime-da çevrilir;
    `config/beauty-styles.php` faylı özü dəyişməyib.
- `demo-beauty.php`: `$studioRaw = bsx_catalog($studioCfg, true, true)`; `$stx.custom_color` +
  `STUDIO_I18N.customColor` (az/en/tr/ru); `<input type="color" id="studioCustomColor">`,
  `studioHexToHsl()` + `studioPickCustomColor()` — istənilən hex rəng seçilir, saç üçün HSL-ə çevrilir,
  çip və brifə yazılır; `.studio-custom` CSS-i.
- `scratch/beauty_studio_admin_e2e.php` palitra açarları `hair_gold`, `hair_caramel`, `lip_rose`, `lip_red` ilə yeniləndi.

**Yeni test:** `scratch/cdp_landmark_accuracy.js` — hər rejimə yaşıl rəng çəkilib, MediaPipe
landmark-larından hesablanan regiondakı yaşıl piksel faizi ölçülür: qaş **100%**, göz **100%**,
dırnaq **100%**, centroid hamısı daxildə → `NƏTİCƏ: HAMISI OK`.

**Reqressiya (hamısı yenidən keçdi):** `php -l` (3 fayl) + `node --check`; `beauty_http_smoke`
(4 dil + panel 200/təmiz); `beauty_studio_admin_e2e`, `beauty_panel_e2e`, `beauty_booking_e2e`,
`beauty_reviews_e2e` — HAMISI OK; `cdp_studio_probe az` (bütün rejimlər real `data:image`, 18 swatch, **CUSTOM COLOR** addımı: `#2E86AB` seçilir, şəkil dəyişir, çip və brif mətninə yazılır);
`beauty_lang_smoke` (4 dil); `parity` + `beauty_design_audit` (missing/extra 0, undefined 0,
hardcoded AZ 0, min font 12px); `cdp_errors` (4 dil, 0) + `cdp_measure` (320–1920, daşma yox).

**Təmiz vəziyyət:** `data/beauty-studio.json` / `beauty-bookings.json` yox, `uploads/beauty/style-*` yox,
`scratch/_*` yox. Müvəqqəti ölçmə skripti daimi reqressiya testinə çevrildi.

**Açıq maddə (2026-11-20, istifadəçi mesajı):** «sabah `sky` yazanda burdan başlayaq, bəzi şeyləri
düzəltməliyik». Siyahı növbəti mesajda **dırnaq lövhəsinin yerləşməsi + real rəng** olaraq
konkretləşdi və yuxarıdakı bölmədə düzəldildi. Studiya ilə əlavə maddələr varsa, əvvəl soruşulmalı.

## Layihə
- Kök: `C:\xamp\htdocs\sky` (yeganə rəsmi kök; Apache: `http://127.0.0.1/sky/`)
- PHP CLI: `& 'C:\xamp\php\php.exe'` (PATH-də `php` yoxdur)
- Demo qovluğu: `modules/web-demos/`
- Demo URL: `http://127.0.0.1/sky/modules/web-demos/demo-<ad>.php`

## STATUS: 11/11 demo tam funksionaldır ✅

### Ortaq qat
`assets/demo-kit.css` + `assets/demo-kit.js` — `window.DK`:
- `DK.toast`, `DK.sheet`, `DK.order`, `DK.cart`, `DK.syncBadges`, `DK.reveal`, `DK.wa`, `DK.pick`, `DK.money`, `DK.esc`, `DK.fmtPhone`, `DK.store`, `DK.countdowns`
- localStorage davamlı səbət, badge sinxronu, mobil sticky CTA, scroll-progress, ripple, şəkil fade-in
- `DK.order()` → bottom-sheet forma + validasiya + WhatsApp dərin linki + sifariş tarixçəsi

### Hər demonun funksionallığı
| Demo | Funksionallıq |
|---|---|
| clothing | Davamlı səbət, ölçü meta, `AURA25` kupon (−25%), 100 AZN pulsuz çatdırılma, ünvan məcburi |
| food | Səbət, zona (3/5/8 AZN, 40 AZN-dən pulsuz), min 15 AZN, rezervasiya sheet-i |
| grocery | Səbət, çatdırılma slotu, min 20 AZN, 40 AZN-dən pulsuz, flash-deal countdown |
| cafe | Səbət, loyallıq stamp kartı (0–5, 6-cı fincan pulsuz), pickup/delivery, vaxt slotları |
| whatsapp | Canlı axtarış, «Səbətə at» + birbaşa WA, sürüşən səbət paneli, badge |
| pharmacy | Axtarış, resept/OCR axını, davamlı səbət, qty stepper, `DK.order` (resept qeydi ilə) |
| beauty | `DK.sheet` bron: xidmət (qiymət/müddət ilə), usta, tarix, vaxt slotu, qiymət məlumatı |
| fitness | Cədvəl filtri, aylıq/illik tarif keçidi, dərs bronu sheet-i, pulsuz sınaq sheet-i |
| education | Kurs filtri, video/sillabus önizləmə, kurs+format seçimi ilə qeydiyyat sheet-i |
| video | Büdcə kalkulyatoru (növ × müddət + əlavələr) → `DK.order` sifarişi |
| realestate | Çoxkriteriyalı filtr + nəticə sayı/boş nəticə, ipoteka kalkulyatoru, baxış və qiymətləndirmə sheet-ləri |

### Yoxlama nəticəsi
- 11 demo: HTTP 200, PHP xətası yoxdur.
- Headless (390×844 mobil) smoke: `DK` yüklənir, JS xətası yoxdur, horizontal overflow yoxdur, sticky bar mövcuddur, sheet-lər açılır, səbət localStorage-da saxlanır, badge sinxronlaşır.
- `index.php` 200 (516 KB).

## Növbəti mümkün işlər (məcburi deyil)
1. `index.php`-dəki köhnə «WEB SERVICES SHOWCASE» modalını `$SKY_WEB_DEMOS` ilə deduplikasiya etmək.
2. Demo kartlarında real screenshot/thumbnail (hazırda placeholder).
3. `DK.order` mesajlarının tam 4 dilə çıxarılması (hazırda başlıq/sətirlər qismən AZ).
4. Lighthouse/performans: şəkillərin `loading="lazy"` + ölçü atributları.
5. Accessibility: sheet-də fokus tələsi (focus trap).

## İş üsulu (təsdiqlənmiş)
1. Demonun son `<script>` blokunu oxu, `onclick`/funksiya adlarını çıxar.
2. Element ID-lərini yoxla (səbət siyahısı, cəm, badge).
3. Yeni skripti yaz → köhnə son `<script>…</script>`-i əvəz et.
4. `php -l` → HTTP 200 → headless smoke → vizual screenshot.
5. `alert()` → `DK.toast`; birbaşa `wa.me` → `DK.order` / `DK.wa`.

## Kritik incəliklər
- Kit **`<body>` açılışından dərhal sonra sinxron** yüklənməlidir (head/`defer` işləmir).
- `e()` PHP helper-i üçün hər faylda `function_exists('e')` guard olmalıdır.
- `DK.cart()` konstruktoru `onChange` çağırmır (TDZ xətası); yalnız `syncBadges` işləyir.
- Bəzi fayllarda emoji/UTF-8 baytları zədəlidir → `edit` əvəzinə PHP `str_replace`/`preg_replace` ilə patch etmək etibarlıdır.
- Headless Chrome: unikal `--user-data-dir`; `--dump-dom` yalnız `cmd /c "... > file"` ilə.
- Backup: `<BACKUP_ROOT>\web-demos_2026-11-12_0211\`

## 2026-11-13 — «#apps» bloku silindi
- `index.php`: `<section class="apps-section" id="apps">` («Skyweb Hər Cihazda Yanınızda!», 4 platforma düyməsi) tam silindi — 6 214 B. Səbəb: eyni 4 düymə footer-də artıq var idi (təkrar).
- Footer platforma düymələri işlək edildi və `config/config.php` sabitlərinə bağlandı:
  `SKY_LINK_WAP` (skyweb.az/wap), `SKY_LINK_WEB` (skyweb.az/app),
  `SKY_LINK_PLAY` (play.google.com/store/apps), `SKY_LINK_APPLE` (apple.com/app-store/).
  Real mağaza ID-ləri çıxanda yalnız bu iki sətri dəyişmək kifayətdir.
- Saytda `href="#"` ölü link qalmadı.
- `sky.css`-də `.apps-section` / `.apps-selector-*` / `.selector-btn` qaydaları artıq istifadəsizdir (zərərsiz, silinməyib).
- Ehtiyat: `_backup_apps/index.php.before_del_apps.bak` (silinmədən əvvəlki tam `index.php`).

## 2026-11-13 — «Layihələrimiz» bölməsi silindi, demo kartları modala köçürüldü
- `<section id="projects">` («Layihələrimiz / Hazır veb sayt nümunələri») tam silindi.
- Onun 11 hardcoded demo kartı `$SKY_WEB_DEMOS` massivinə (faylın ~44-cü sətri) köçürüldü və
  **MODAL 1** (`#web-services-modal-overlay` → `✨ 11 İNTERAKTİV DEMO PORTFELİ`) içində PHP loop ilə render olunur.
  Modalın öz köhnə 11 kartı silinib — məzmun tam əvəz olunub, təkrar yoxdur.
- Filtrlər 7 `proj_filter_*` açarı ilə işləyir: Hamısı / E-Ticarət / Restoran & Kafe / Aptek & Tibb /
  Gözəllik & İdman / Təhsil & Media / Daşınmaz Əmlak. JS hook-ları dəyişməyib:
  `.sky-demo-filter-btn`, `.sky-demo-item`, `data-category`.
- Bölməyə gedən 6 link (`#mob-projects`, 2 `sky-svc-action-btn`, 2 `module-link`, footer «Layihələrimiz»)
  artıq `href="#services"` + `onclick="openWebServicesModal()"` ilə modalı açır; mobil menyu klikdən sonra bağlanır.
- `openWebServicesModal()` hər açılışda filtri «Hamısı»-ya qaytarır; bağlanmada `body.style.overflow` təmizlənir.
- Refaktor qalıqları təmizləndi: bölmənin ölü CSS-i (`.sky-proj-*` istisna olmaqla), təkrar `<div class="sky-divider">`,
  istifadəsiz `.sky-demo-feat/.sky-demo-features`.
- Ehtiyat: `_backup_apps/index.php.before_demos_refactor.bak`, `_backup_apps/sky.css.before_demos_refactor.bak`.

### Modal kartlarının 96px-ə sıxılması (kök səbəb + həll)
- Səbəb: `.sky-demos-body` `flex: 1` (definite 491px) + `align-content` → Chromium auto sətirləri konteyner
  hündürlüyünə sıxırdı və hər kart ~96px olurdu.
- Həll: `.sky-demos-body { grid-auto-rows: max-content; }` — sətirlər məzmuna görə ölçülür, body scroll edir.
- Əlavə: `.sky-demo-item` `height: 100%` → `auto` + `min-height: 0`; grid item üçün mənasız
  `flex: 0 0 50% / 100%` + `max-width` media query-ləri silindi.
- Yoxlama: 1440/1024/768/430/390/360/320 — 11 kart tam görünür, kəsilmiş kart 0, üfüqi daşma 0.
  Filtr sayları: Hamısı 11, E-Ticarət 3, Restoran 2, Aptek 1, Gözəllik 2, Təhsil 2, Daşınmaz 1.

## 2026-11-13 — Sayt üzrə layout / responsive audit
Bütün ölçmələr CDP `Emulation.setDeviceMetricsOverride` ilə (headless `--window-size` real mobil ölçü vermir).

| Düzəliş | Səbəb | Nəticə |
|---|---|---|
| Mobil header (≤600px) | Logo + Daxil ol/Qeydiyyat + dil seçici + hamburger sığmırdı, `.nav-actions` `flex-shrink:0` olduğu üçün hamburger ekrandan kənara çıxırdı (390-da [421..459]) | Auth linkləri ≤600px gizlədildi (onlar `#mobile-nav`-dadır), ≤380px logo kompaktlaşdırıldı. Hamburger: 320→[274..304], 360→[314..344], 390→[336..374], 430→[376..414], 600→[546..584], 768→[714..752] |
| `#mobile-nav` dil çipləri | `.mobile-nav a` padding-i (0.85rem 1rem) çiplərə də tətbiq olunurdu → TR kəsilirdi (`scrollW 399 > clientW 390`) | `.sky-lang-mobile-bar .sky-lang-mobile-item` (yüksək spesifiklik) kompakt padding; 390 və 320-də `scrollW == clientW` |
| Orfan `<style>` | Bölmə silinərkən `.service-cta-*` blokunun açılış `<style>` teqi getmişdi → ~1 KB xam CSS səhifədə mətn kimi görünürdü (360-da 537px ağ zolaq) və CTA kartı stil almırdı | `<style>` bərpa olundu (8/8 balans), xam CSS node = 0, `.service-cta-card` dashed cyan border alır |
| Təkrar divider | `</main>` önündə iki `.sky-divider` 1px aralıqla dururdu | Sonuncu silindi → divider sayı 2 (home→services, services→footer); `#services`→footer boşluğu 537px → 1px |
| MODAL 2 scroll | `#our-projects-modal` gövdəsi scroll olunmurdu (390-da məzmun 890px, modal 808px, `overflow:hidden`) | `#our-projects-modal > div:not(.sky-demos-header)` → `flex:1 1 auto; min-height:0; overflow-y:auto` |
| Walkthrough pleyer (≤480px) | `.video-controls` sırası video qutusundan geniş idi (320-də qutu 226px, məzmun 255px) → sağ düymələr kəsilirdi | `padding/gap` kiçildildi, `.controls-row` `flex-wrap`, `.control-btn` padding 2px; 320/360/390/480-də `scrollW == clientW` |

Yekun ölçmələr (1920, 1440, 1280, 1150, 1024, 900, 768, 600, 430, 390, 360, 320):
- `documentElement.scrollWidth == innerWidth` — üfüqi daşma **yoxdur**.
- Klipssiz kənara çıxan element **yoxdur** (`skybot-fab-ring` istisna — bu, fırlanan dairənin AABB artefaktıdır, vizual daşma deyil).
- Şaquli kəsilmiş məzmun yalnız `board-section` (fon glow, +30px) və `skybot-avatar` (loqo dairəsi) — hər ikisi dekorativ.
- Bölmə ritmi: `#services` → `footer` = 1px; divider = 2; `#home`/`#services`/`footer` eni viewport-a bərabərdir.

i18n yoxlaması (az/en/ru/tr, `SkyI18n.switchLang`):
- Modal 1: başlıq, alt mətn, 7 filtr, 11 kart adı, badge, «canlı demo», nəticə, 2 düymə — hamısı dolu və düzgün dilə keçir.
- Modal 2: başlıq + alt mətn 4 dildə dolu; modal viewport daxilindədir.
- Boş `data-i18n` elementi = 0; JS xətası = 0.

## 2026-11-13 — «// Xidmətlər / Biznesiniz üçün hazır həllər» bölməsi silindi
Tələb: 5 modul kartı (`#marketing`, `#games`, `#cv-builder`, `#web`, `#business`) + CTA kartı olan
`<section class="modules-section" id="services">` bloku əsas layihələr bölməsi ilə təkrarlandığı üçün
tamamilə silinsin; ətrafdakı layout Web/WAP üçün səliqəyə salınsın; başqa heç nə dəyişdirilməsin.

| Addım | Nəticə |
|---|---|
| Bölmə silindi | `index.php`-dən 437 sətir: `<!-- 5 MODULES / SERVICES -->` şərhi + `#services` bölməsi + daxili `<script>` (folder/tooltip məntiqi) + `.service-cta-*` `<style>` bloku (artıq istifadəsiz) |
| Təkrar divider | Bölmədən sonrakı ikinci `.sky-divider` də silindi; qalan sonuncu divider də silindi, çünki `.footer` onsuz da `border-top: 1px` ilə gəlir → iki 1px xətt üst-üstə düşürdü |
| Nəticə (ritm) | `main > section` = yalnız `home`; `.sky-divider` = 0; `#home` → `footer` boşluğu = 0 (footer öz border-top-u) |
| Yoxlama | 12 en (1920…320) CDP: `scrollWidth == innerWidth`, sections=`home`, JS xətası 0; az/en/ru/tr = HTTP 200, PHP xəbərdarlığı yoxdur |

Qalan (toxunulmadı, tələb üzrə): `#services`-ə işarə edən linklər (`#mobile-nav`, footer, `sky-svc-action-btn`)
`openWebServicesModal()` ilə tutulur (funksiya qalır, sətir 4243) — hash hədəfi artıq yoxdur, amma klik işləyir.
`assets/css/sky.css`-də `.modules-section/.module-*/.digital-service-item` qaydaları və `svc_sec_*`, `mod_cta_*`,
`mod3..mod7_*` i18n açarları indi istifadəsizdir (silinmədi).
Backup: `_backup_apps/index.php.before_services_removal.bak`; ölçmə skriptləri: `scratch/cdp_measure.js`, `scratch/cdp_shot.js`, `scratch/cdp_errors.js`.

## 2026-11-14 — «Partner Brendlər» bölməsi + Admin Panel
Tələb: footer-dəki təkrar «Xidmətlər» sütunu (Biznes Tətbiqləri, SMM & Reklam, Mini Oyunlar, Ağıllı CV,
CV Builder) silinsin; yerinə «Əməkdaşlıq Etdiyimiz Brendlər» bölməsi gəlsin; bölmə publik frontend-də
**default gizli** olsun və yalnız Admin Panel-dən idarə olunsun (ad/loqo əlavə etmək + görünürlük açarı).
Başqa heç nə dəyişdirilməsin.

### Yeni fayllar
| Fayl | Nə üçün |
|---|---|
| `config/partners.php` | Fayl əsaslı anbar + `sky_partners_load/save`, `sky_partners_is_public()`, `sky_partners_public_items()`, `sky_partner_initials()`, `sky_partner_logo_url()` |
| `config/admin.php` | Panel autentifikasiyası: default hash, `data/admin_auth.json` üzərindən şifrə, sessiya (2 saat idle timeout), 5 cəhddən sonra 10 dəq blok, CSRF |
| `admin/index.php` | Admin Panel UI (login + dashboard): görünürlük açarı, brend CRUD, loqo upload, sıralama (↑/↓), per-brend görünürlük, şifrə dəyişmə. Responsive (1440 və 390-da overflow yoxdur) |
| `data/partners.json` | Anbar: `{ visible: false, updated_at, items[] }` (atomik yazma, `LOCK_EX`) |
| `data/.htaccess` | `data/` brauzerdən bağlıdır → `data/partners.json` = **HTTP 403** |
| `uploads/partners/.htaccess` | Yüklənmiş loqolarda PHP/ CGI icrası qadağan, `Options -Indexes` |

### Publik frontend
- `index.php`-də `<section id="partners">` **yalnız** `sky_partners_public_items()` boş olmayanda render olunur →
  default vəziyyətdə HTML-ə **heç nə** düşmür (nə markup, nə `<style>`).
- Bölmə `<main>` içində, hero-dan sonra, footer-dən əvvəl. Grid: `auto-fit minmax(min(190px,100%),1fr)`
  (≤768px: 150px, ≤400px: 132px) → 4 sütun (≥900) / 3 sütun (600) / 2 sütun (≤430).
- Loqo yoxdursa baş hərflər göstərilir (tək sözlü ad → ilk 2 hərf, məs. «AZPetrol» → «AZ»).
- i18n: `partners_label`, `partners_title_1`, `partners_title_2`, `partners_desc` — az/en/ru/tr (parity 0/0/0).
- Footer: «Xidmətlər» sütunu silindi → `.footer-grid` `minmax(0,1fr) auto` (brend solda, «Haqqımızda» sağda);
  ≤900px `1fr 1fr`, ≤768px `1fr` (əvvəlki media query-lər olduğu kimi qalır).

### Admin girişi
- URL: `http://127.0.0.1/sky/admin/`
- İstifadəçi: `admin` · Şifrə: `<ADMIN_PASSWORD>`
- **İlk girişdən sonra «Şifrəni dəyiş»** — panel default şifrə aktiv olanda xəbərdarlıq göstərir.
  Yeni hash `data/admin_auth.json`-a yazılır (default şifrə UI-da göstərilmir).
- DB əsaslı admin (`users.role='admin'`) sessiyası da qəbul olunur (DB hələ qurulmayıb — `skyweb_db` yoxdur).

### Yoxlama
- `scratch/partners_e2e.php` → 24 yoxlama **PASS**: login (doğru/yanlış şifrə), CSRF rəddi, görünürlük açarı,
  brend əlavə (loqo upload + URL `https://` normalizasiyası), per-brend switch, sıralama, silmə,
  publik render (gizli bölmə = 0 markup, gizli brend = görünmür), `data/` 403, logout.
- `scratch/admin_pw_test.php` → 7 yoxlama PASS (şifrə dəyişmə, köhnə şifrənin rəddi, default xəbərdarlığı).
- CDP 12 en (1920…320): bölmə gizli → `sections=home`, overflow yoxdur; bölmə aktiv (10 brend) →
  `sections=home,partners`, 4/3/2 sütun, `scrollWidth == innerWidth`, JS xətası 0.
- Render diff (backup vs cari, i18n/CSRF normallaşdırılmış): publik səhifədə **yalnız** silinən footer sütunu fərqlənir.
- Backup: `_backup_apps/index.php.before_partners.bak`, `sky.css.before_partners.bak`, `lang_*.before_partners.bak`.

## 2026-11-14 (davam) — Partner bölməsi footer-ə köçürüldü + inline admin idarəetmə
Tələb: «Partner Brands & Collaborators» bölməsi footer/bottom layout-un içinə — `skyweb.az` brend təsviri ilə
«Haqqımızda» naviqasiya siyahısının (Əlaqə, Layihələrimiz, Gizlilik Siyasəti, İstifadə Şərtləri, FAQ, Blog)
yanına yerləşdirilsin; desktop və WAP-da sütun nisbətləri/boşluqları səliqəyə salınsın. Bölmənin içində
**yalnız administratora** görünən «+ Brend Əlavə Et» və «Saytda göstər/gizlət» düymələri olsun. Ziyarətçilər
bu düymələri heç vaxt görməməli, yalnız admin bölməni publik edəndə brendləri görməlidir. Başqa dəyişiklik yoxdur.

> Bu bölmə yuxarıdakı 2026-11-14 qeydindəki **layout və test saylarını əvəz edir** (bölmə artıq `<main>` içində deyil).

### Layout
- `index.php`: köhnə standalone `<section class="partners-section">` + daxili `<style>` tam silindi.
  Yeni `<section class="footer-partners" id="partners">` `.footer-grid`-in **ortancıl** uşağıdır:
  `brand | partner brendlər | Haqqımızda`.
- `.footer-grid` desktop: `minmax(0, .95fr) minmax(0, 1.5fr) minmax(150px, .65fr)`, `gap: clamp(1.5rem, 3vw, 3.5rem)`, `align-items: start`.
  - ≤1024px: 2 sütun; brend tam eni tutur (`grid-column: 1 / -1`), partner + «Haqqımızda» yan-yana.
  - ≤768px: tək sütun (brend → partnerlər → «Haqqımızda»).
- Bölmə publik gizli olduqda `footer-grid`-ə `no-partners` klassi verilir və footer əvvəlki kimi 2 sütuna qayıdır.
- Çiplər kompaktdır: `repeat(auto-fill, minmax(108px, 1fr))`, 24px loqo/baş hərf + ad; loqo yoxdursa baş hərflər.
- `#partners { scroll-margin-top: 96px; }` — paneldən `index.php#partners` keçidində sticky header başlığı örtmür.
- i18n: yeni `partners_footer_title` açarı — az «Partnyor brendlər», en «Partner brands»,
  ru «Бренды-партнёры», tr «Partner markalar» (parity 0/0/0).

### Admin-only idarəetmə (footer içində)
- Render şərti **server-side**: `sky_admin_is_logged_in()` (panel sessiyası və ya DB `role='admin'`).
  Ziyarətçi üçün nə düymə, nə form, nə də `partner-action.php` linki HTML-ə düşmür.
- «**+ Brend Əlavə Et**» — `<details>` popover formu: ad + loqo (PNG/JPG/WEBP/GIF, maks. 3 MB) + istəyə bağlı vebsayt.
- «**Saytda göstər / Saytda gizlət**» — düymənin yanında; POST ilə bölmənin görünürlüyünü dəyişir.
- Hər çipin altında **«Gizlət/Göstər»** və **«Sil»** — tək brendi publikdən çıxarmaq və ya tam silmək üçün.
  «Sil» brauzer `confirm()` tələb edir; silinəndə loqo faylı da `uploads/partners/`-dən təmizlənir.
- Admin bölmə gizli olanda da görür: başlıqda qeyd («Bölmə gizlidir — ziyarətçilər görmür»), gizli brendlər
  solğun + «gizli» nişanı ilə göstərilir. Ziyarətçi isə gizli bölmədə **0 markup** görür.
- `admin/partner-action.php` (yeni): yalnız `POST`; girişsiz sorğu **403**; CSRF yoxlanır;
  `action=add`, `action=toggle`, `action=toggle_item`, `action=delete`;
  nəticə sessiya flash-ı + `../index.php#partners`-ə redirect.

### Ortaq köməkçilər
- `config/partners.php`-ə köçürüldü: `sky_partners_upload_logo()`, `sky_partners_delete_logo_file()`,
  `sky_partners_clean_url()`, `sky_partners_flash()`, `sky_partners_take_flash()`.
- `admin/index.php`-dəki dublikat funksiyalar silindi, çağırışlar yeni adlara keçirildi (panel CRUD eyni işləyir).

### Yoxlama
- `scratch/partners_e2e.php` → **66/66 PASS** (test özü əvvəlcə gizli/boş vəziyyətə qaytarır): ziyarətçidə düymə yoxdur, girişsiz endpoint 403, login, CSRF,
  panel CRUD, footer `has-partners`, publik brendlər, gizli brend render olunmur, **footer endpoint add**
  (loqo + URL normalizasiyası), **footer endpoint toggle** (guest görmür / admin görür),
  **footer `toggle_item`** (tək brend gizlət/göstər), **footer `delete`** (brend + loqo silinir), gizli bölmə =
  `no-partners`, CSRF rəddi, logout, `data/` 403.
- `scratch/admin_pw_test.php` → 7/7 PASS.
- CDP 12 en (1920…320), bölmə aktiv: `footerCols=3` (≥1150), `2` (1024/900), `1` (≤768);
  bölmə gizli: `2` / `1`; hər iki halda footer səbəbli horizontal overflow yoxdur, JS xətası 0.
- Ekran görüntüləri: `scratch/guide-desktop.png`, `scratch/guide-wap.png`
  (admin görünüşü: «+ Brend Əlavə Et», «Saytda gizlət», hər çipin altında «Gizlət»/«Sil»).
- Cari vəziyyət: bölmə **görünür**, içində 4 nümunə brend (`Nümunə Brend A–D`, loqosuz).
  Real brendlər paneldən əvəz olunmalıdır: `http://localhost/sky/admin/` → `admin / <ADMIN_PASSWORD>`.

### Sessiya ömrü düzəlişi (admin düymələri «yoxa çıxırdı»)
Səbəb: PHP defolt `session.gc_maxlifetime = 1440` (24 dəqiqə) və `session.cookie_lifetime = 0`.
Admin panelə girəndən ~yarım saat sonra sessiya faylı PHP garbage collector tərəfindən silinirdi
(və brauzer bağlananda cookie yox olurdu) — nəticədə `sky_admin_is_logged_in()` false olur,
footer-dəki idarəetmə düymələri görünmürdü. Heç bir xəta mesajı çıxmırdı.

- `config/config.php`: `session.gc_maxlifetime = 86400`, `session.cookie_lifetime = 86400`,
  `session.cookie_samesite = Lax` (session_start-dan əvvəl).
- `config/admin.php`: idle timeout 2 saat → **12 saat**.
- `index.php`: admin sessiyası varsa hər səhifə baxışında `sky_admin_touch()` — vaxt yenilənir.
- Yoxlama: `PHPSESSID` cookie indi 1 günlük `Expires` ilə verilir; E2E 66/66, şifrə testi 7/7 yenidən keçdi.

## 2026-11-15 — Faza 2 i18n tamamlandı + footer «Admin» linki + demo brendlər təmizləndi

Tələb: «sıra ilə hamısını et tamamla» — yəni (1) admin girişini yoxla, (2) footer-ə həmişə görünən
«Admin» linki, (3) nümunə brendləri təmizlə, (4) qalan hardcoded AZ mətnləri i18n-ləşdir.

### 1) Admin girişi (server tərəfində yoxlama)
- `GET /sky/admin/` → login formu (200). POST `action=login`, `username=admin`, `password=<ADMIN_PASSWORD>`
  → panel açılır (`value="logout"` görünür), `data/admin_auth.json` yoxdur → **default şifrə aktivdir**.
- Girişdən sonra `index.php`-də `$skyPartnerAdmin` true olur: «+ Brend Əlavə Et» görünür,
  `partner-action.php` formaları render olunur. Çıxış (`logout`) yenidən login formuna qaytarır.
- Cookie: `PHPSESSID` 1 günlük `Expires` ilə (sessiya düzəlişi işləyir).
- **Xatırlatma:** sessiya hosta bağlıdır — saytı `localhost` ilə açırsansa, panelə də `localhost` ilə gir.

### 2) Footer alt sətri — həmişə görünən «Admin» linki
- `index.php` `.footer-bottom-links` içinə: `<a href="admin/" class="footer-admin-link" rel="nofollow">`.
- `footer_admin_link` açarı 4 dilə əlavə olundu (az/en/tr «Admin», ru «Админ»).
- `sky.css`: `.footer-bottom-links { padding-right: 96px }` — sabit SkyBot düyməsi sonuncu linki örtmürdü;
  ≤768px-də `.footer-bottom { padding-bottom: 76px }` + linklər `flex-wrap: wrap` (WAP-da link görünür qalır).
- Link kiçikdir: `font-size: .72rem; opacity: .7` (hover → 1).

### 3) Nümunə brendlər silindi
- `data/partners.json` → `visible: true`, `items: []`. Publikdə bölmə **render olunmur**
  (`$skyPartnerShow = false` → `footer-grid.no-partners`, 2 sütun), admin «Bölmə aktivdir, lakin aktiv brend yoxdur» görür.
- `uploads/partners/`-də E2E-dən qalan test loqoları təmizləndi.
- Geri qaytarmaq: `php scratch/enable_demo.php`.

### 4) Faza 2 — qalan hardcoded AZ mətnlər i18n-ləşdirildi
`index.php`-də 39 mətn node-u + 7 atribut dəyəri dəyişdirildi (hamısı `__()` + `data-i18n`):

| Qrup | Açarlar |
|---|---|
| Xidmət panelləri 1–4 | `svc_panel{1..4}_badge`, `svc_panel{1..4}_title`, `svc_panel1_desc` |
| HUD metrik pərdələri | `svc_hud{1..4}_a`, `svc_hud{1..4}_b` |
| İnfo popup (HTML saxlayır) | `svc_info_popup_text` — `e()`-siz çıxarılır |
| CV hero kartı | `cv_hero_sub`, `cv_hero_desc2`, `cv_chip_ats/templates/pdf/fast` |
| Avtobioqrafiya hero kartı | `autobio_hero_sub`, `autobio_hero_desc2`, `autobio_chip_ai/std/pdf/sign` |
| Modal kickers / arxiv | `demos_modal_kicker`, `projects_modal_kicker`, `projects_feat{1..3}_title/desc`, `projects_modal_footer_text` |
| Forma + aria | `contact_name_ph`, `aria_svc_section/info/seq`, `aria_cv_goto`, `aria_autobio_goto`, `aria_platforms` |
| Footer | `footer_admin_link` |

- Bağla düymələri (6 yer) artıq mövcud `btn_close` açarını işlədir.
- **«Platform seçenekləri» yazı xətası düzəldildi** → «Platform seçimləri».
- Lüğət: **+47 açar × 4 dil**, 724 → **771**, paritet **0/0/0** (`scratch/parity.php`).
- `data-tip` tooltip-ləri artıq mövcud deyil (əvvəlki qeyd köhnəlmişdi) — heç nə lazım olmadı.
- **Qəsdən toxunulmadı:** yalnız adminə görünən 8 footer idarəetmə sətri (admin panelinin özü tam AZ-dır).

### Yoxlama (2026-11-15)
- `php -l index.php` + `lang/{az,en,ru,tr}.php` → təmiz.
- `scratch/partners_e2e.php` → **66/66 PASS**; `scratch/admin_pw_test.php` → **7/7 PASS**
  (sonra `data/admin_auth.json` silindi → default şifrə bərpa).
- `?lang=az|en|ru|tr` → HTTP 200, PHP warning/notice **0**; hər dildə yeni mətnlər mövcuddur (yoxlanıldı).
- `scratch/cdp_errors.js` 4 dil → JS xətası **0**.
- `scratch/cdp_measure.js` 12 en (1920…320) → `scrollWidth == innerWidth` (səbəbli overflow yox),
  `footerCols=2` (≥1150, brendsiz) / `1` (≤768).
- Ekran görüntüləri ilə təsdiq: footer alt sətri desktop + WAP (Admin linki SkyBot düyməsi ilə üst-üstə düşmür),
  EN xidmət panelləri (badge/title/desc/HUD/çiplər tərcümə olunub).
- Cari vəziyyət: `data/partners.json` → `visible: true`, 0 brend; `data/admin_auth.json` yoxdur (default şifrə).

## 2026-11-16 — İkinci dərəcəli səhifələrin i18n auditi + 2 responsive bug

Tələb: «digər mərhələyə keçək — bir-iki şeyi təkmilləşdirək». Mərhələ: `blog.php`, `faq.php`,
`privacy.php`, `terms.php` səhifələrinin i18n auditi + kiçik təkmilləşdirmələr.

### Audit
- `faq.php`, `privacy.php`, `terms.php`: hardcoded AZ mətn **0** (artıq `__()` + `data-i18n` ilə işləyirdilər),
  açarların hamısı 4 dildə mövcud, `data-i18n`-siz boş element yoxdur.
- `blog.php`: 3 məqalə kartı (tarix/kateqoriya, başlıq, təsvir) hardcoded AZ idi → **11 sətir**.
- `config/lang.php` (ortaq dil seçicisi): 3 hardcoded AZ sətri (`Dil seçin`, `Dil seçimi`, `seçilib`) — hər səhifədə.

### Düzəlişlər
| # | Fayl | Nə |
|---|---|---|
| 1 | `blog.php` | 3 kart `__()` + `data-i18n`-ə keçdi; 9 yeni açar (`blog_post{1..3}_meta/title/desc`) × 4 dil |
| 2 | `blog.php` | «inkişaf tempı» → «inkişaf tempi» (yazı xətası) |
| 3 | `config/lang.php` | `lang_switch_aria`, `lang_menu_aria`, `lang_current_aria` açarları (4 dil) — `aria-label`-lər serverdə tərcümə olunur |
| 4 | `blog/faq/privacy/terms.php` | footer alt sətrinə `.footer-bottom-links` + `footer-admin-link` (index.php ilə eyni) |
| 5 | `blog.php` | `.blog-grid` `minmax(320px,1fr)` → `minmax(min(320px,100%),1fr)` |
| 6 | `assets/css/sky.css` | `@media (max-width:600px)`: `.navbar .nav-actions > a.btn-primary { display:none }` |

### Bug 1 — blog kartları 320px-də daşma
320px-də `documentElement.scrollWidth = 336`. Səbəb: `.blog-grid` `repeat(auto-fill, minmax(320px, 1fr))` —
viewport 320, konteyner daxili eni daha az olduğu üçün 320px-lik trek sığmır və 16px daşma yaranır.
Həll: `minmax(min(320px, 100%), 1fr)` (layihədə artıq istifadə olunan naxış). Nəticə: 320 → `scrollWidth = 320`.

### Bug 2 — dil seçicisi mobil-də kəsilirdi (faq/privacy/terms/blog)
≤430px-də header sığmırdı: loqo (168px) + «Ana Səhifə» `.btn-primary` (134px) + dil seçicisi (78px).
`.nav-actions` `flex-shrink: 0` olduğu üçün sıxılmır, `body { overflow-x: hidden }` isə artığı **kəsirdi**:
390px-də `#sky-lang-btn` sağ kənarı **416** → düymənin ~26px-i görünmürdü (heç bir xəta mesajı yox).
`index.php`-də bu problem yox idi, çünki orada `.nav-actions`-da `.btn-primary` yoxdur (auth linkləri ≤600px gizlədilir).
Həll: ≤600px-də həmin «Ana Səhifə» düyməsi gizlədilir — loqo onsuz da `index.php`-yə linkdir.
Nəticə: 390/360/320-də sağ kənar = viewport − 16px (tam görünür).

### Yoxlama
- `php -l`: `blog.php`, `faq.php`, `privacy.php`, `terms.php`, `config/lang.php` → təmiz.
- `scratch/pages_smoke.php` (yeni): 5 səhifə × 4 dil = **20/20 PASS** (HTTP 200, PHP warning 0, nümunə mətnlər
  hər dildə var, `footer-admin-link`=1, boş `data-i18n`=0).
- `scratch/map_keys.php`: 4 səhifədə `unmapped: 0`.
- `scratch/parity.php`: **0/0/0**, lüğət **783** açar (771 + 12).
- `scratch/cdp_errors.js` (blog 4 dil + faq/privacy/terms/index): JS xətası **0**.
- `scratch/cdp_measure.js` (blog, faq, index): 12 en — `scrollWidth == innerWidth`; blog/faq-da kənara çıxan
  element **yoxdur**; index-də yalnız əvvəldən məlum dekorativ elementlər (slider track, glow, toast).
- `scratch/cdp_header_probe.js` (yeni): 390/360/320 — dil seçicisi tam görünür.
- Ehtiyat: `_backup_apps/blog.php.before_i18n.bak`, `lang_{az,en,ru,tr}.before_blog_i18n.bak`,
  `config_lang.php.before_aria_i18n.bak`.

### Yeni scratch alətləri
`pages_i18n_audit.php`, `pages_smoke.php`, `show_keys.php`, `enc_check.php`, `find_bad_utf8.php`,
`dump_line.php`, `cdp_header_probe.js`, `add_keys_blog.php`, `add_keys_lang_aria.php`.
`cdp_errors.js` artıq URL-ləri arqument kimi qəbul edir (arqumentsiz köhnə davranış qalır).



## Bilinən açıq məsələlər

### 2026-11-15 — «giriş etmir, xəta verir» diaqnozu
- **Səbəb:** istifadəçi `admin` / `<ADMIN_PASSWORD>` məlumatlarını **saytın «Daxil ol» formasına**
  (`/sky/auth/login.php`, e-poçt/telefon) yazıb. Bu forma **istifadəçi hesabı** sistemidir və MySQL
  `skyweb_db` bazasını tələb edir. Baza qurulmadığı üçün `db()` `PDOException` atırdı və brauzerdə
  **raw JSON** görünürdü: `{"error":"Database service unavailable."}` (HTTP 503).
  Apache logu: `[Skyweb DB Error] SQLSTATE[HY000] [1049] Unknown database 'skyweb_db'`,
  referer `http://localhost/sky/auth/login.php`.
- **Admin panelinə giriş ayrıdır və işləyir:** `http://localhost/sky/admin/` → `admin` / `<ADMIN_PASSWORD>`
  (server tərəfində yoxlanıldı: login OK, footer admin düymələri render olunur, logout OK).
- **Düzəliş:** `config/database.php` — DB xətası olduqda:
  - API/AJAX (`/api/`, `X-Requested-With`, `Accept: application/json`) → əvvəlki kimi JSON 503;
  - adi brauzer səhifələri → **oxunaqlı 503 səhifəsi** («Hesab sistemi hazırda əlçatmazdır» + «Admin panelinə keç» düyməsi).
    Linklər layihə kökündən dinamik hesablanır (hardcoded `/sky` yox).
- **Qeyd:** admin paneli 5 səhv cəhddən sonra 10 dəqiqəlik **sessiya əsaslı** blok qoyur — incognito pəncərə
  və ya cookie silməklə dərhal sıfırlanır.
- **İstəsə növbəti addım:** `php database/setup_db.php` + `schema.sql` import → sayt hesabları (qeydiyyat/login)
  da işləyəcək. Hazırda sayt MySQL-siz işləyir və bu, mövcud arxitekturadır.

### 2026-11-15 (davam) — HƏLL: baza quruldu + LAN girişi ✅
- `skyweb_db` (MariaDB 10.4) yaradıldı; `database/schema.sql` import → 9 cədvəl.
  **Qeyd:** `schema.sql`-də `users` cədvəli 24-cü sətirdə yarımçıq kəsilmişdi → `avatar_url`,
  `is_verified`, `is_active`, `created_at`, `updated_at`, `idx_users_phone` bərpa olundu
  (ehtiyat: `_backup_apps/schema.sql.before_users_fix.bak`).
- Seed admin: `admin@skyweb.az` / `<ADMIN_PASSWORD>` (real bcrypt hash; placeholder hash dəyişdirildi).
- `config/config.php`: `SITE_URL` artıq **dinamik** — `HTTP_HOST` + `DOCUMENT_ROOT`-dan hesablanır.
  Bu, LAN IP ilə açanda CSS/JS/redirect-lərin `localhost`-a qaçmasının qarşısını alır.
- LAN: Apache `0.0.0.0:80`; `http://192.168.100.9/sky/` 200. Wi-Fi Private profilində
  `C:\xamp\apache\bin\httpd.exe` üçün Allow qaydası var (Private Block qaydaları `C:\xampp\...` yoluna aiddir).
- E2E (HTTP): register / login (email) / login (phone) / wrong password / duplicate email / CSRF 403 /
  admin login (localhost + LAN) / forgot-password `send_code` → hamısı PASS. Test istifadəçisi və
  `sent_emails.txt` təmizləndi; `data/partners.json` toxunulmadı.
- Sessiya hələ də **hosta bağlıdır**: `localhost`-da girib LAN IP ilə davam etmək olmaz — hər ünvanda ayrıca giriş.
- **Partner görünürlüyü (2026-11-15):** brend «Saytda göstər» edildikdə bölmə avtomatik açılır
  (`sky_partners_auto_publish()`), ona görə ziyarətçi brendi dərhal görür. Əvvəl bölmə + brend
  olmaqla iki açar tələb olunurdu və nəticədə publik heç nə görmürdü. Bölmənin «Saytda gizlət»
  açarı bütün bölməni gizlətməyə davam edir.
  Yoxlama: 4 ssenari (panel toggle, panel save, footer toggle, footer add) → hamısı publikdə görünür; master gizlət → gizlədir.

### 2026-11-13 (gec) — bağlanan məsələlər
- **`TEST_COPYRIGHT_CHANGE` silindi** (`index.php` footer). İndi: `© <?= date('Y') ?> Skyweb.az. <footer_rights>`.
- **Footer sütunları i18n-ləşdirildi**: `footer_col_services`, `footer_link_business/smm/games/cv/cv_builder/projects`
  açarları 4 dilə əlavə olundu; `nav_about`, `nav_contact`, `footer_privacy`, `footer_terms`, `nav_faq`, `nav_blog` təkrar istifadə olundu.
- **`#mobile-nav` artıq təmiz i18n-dir** (əvvəlki qeyd köhnəlmişdi — linklər `__()` ilə çıxır).
- **5 modul kartı + CTA kartı i18n-ləşdirildi**: `mod3..mod7_title/desc`, `mod_cta_title/desc/li1..li3/btn`,
  `module_back_btn`, `chip_cv_templates`, `chip_corporate_site`, `chip_seo_ready`, `chip_online_catalog`,
  `chip_cart_checkout`, `chip_payment_integration`, `chip_stock_orders`, `link_store_examples`.
  Çiplər üçün mövcud `svc_chip_*`, linklər üçün `svc_link_*` açarları təkrar istifadə edildi.
- **«Biznesinizi böyüdün» info-modalı i18n-ləşdirildi** (`business_modal_*` — HTML `<strong>` saxlayan açarlar `e()`-siz çıxarılır).
- **Avtobioqrafiya modalı tam i18n-ləşdirildi**: `autobio_*` (65+ açar) — başlıqlar, etiketlər, placeholder-lər,
  checkbox mətnləri, ton/uzunluq seçimləri, nəticə və yükləmə düymələri.
- **Hero**: `hero_slogan`, `svc_title_prefix` + `svc_title_highlight` bərpa olundu (açar mövcud idi, markup hardcoded qalmışdı).
- **Lüğət pariteti tamamlandı**: `az/en/ru/tr` = **719 açar**, fərq 0 (`autobio_*`, `business_modal_*`, `video_demo_*` üçün RU/TR tərcümələri yazıldı).
  `ru.php`-dəki köhnə `autobio_tone_modern` açarı silindi (istifadəsiz).
- Yoxlama: `php -l` təmiz; `?lang=az|en|ru|tr` → HTTP 200, PHP warning 0, yeni mətnlər 4 dildə görünür.

### Hələ hardcoded qalan (2026-11-15 vəziyyəti)
`php scratch/map_keys.php index.php` → **unmapped: 8** — hamısı yalnız adminə görünən footer idarəetmə sətirləri:
«+ Brend Əlavə Et», «Brend adı», «Vebsayt (istəyə bağlı)», «Brendi əlavə et»,
«Bölmə gizlidir — ziyarətçilər görmür.», «Bölmə aktivdir, lakin aktiv brend yoxdur.»,
«Saytda N brend görünür.», «Hələ brend yoxdur — «+ Brend Əlavə Et» ilə başlayın.»
Ziyarətçi bunları heç vaxt görmür və admin paneli də tam AZ-dır → tərcümə tələb olunmur.
Ziyarətçiyə görünən bütün mətnlər 4 dildədir (lüğət 771 açar, paritet 0/0/0).

### Köhnə qeydlər
- `.sky-divider` bölmələri ayırır, lakin `#services`-dən sonra boşluq minimuma endirilib (1px).

## 2026-11-16 (davam) — Gözəllik demosu: oxunaqlıq + tam 4 dil + meta (#7)

Fayl: `modules/web-demos/demo-beauty.php` (yalnız bu demo; digər demolar dəyişməyib).
Backup: `_backup_apps/demo-beauty.php.before_readability_i18n.bak`.

**Oxunaqlıq (tipografiya)**
- 23 yerdə 14px-dən kiçik şrift var idi → hamısı qaldırıldı. **Minimum 12px**, gövdə mətni **14–16px**.
- `.serv-desc` 13→14px + `line-height:1.65`; `.ba-info p`, `.section-head p`, `.ba-upload-sub`, `.ba-privacy-notice` üçün sətir aralığı 1.6–1.7.
- `body` sətir aralığı 1.6→1.65, `-webkit-font-smoothing: antialiased`.
- Paylaşılan `demo-kit` kiçik ölçüləri yalnız bu demo üçün artırıldı:
  `body[data-dk-demo="beauty"] .dk-label` 13px, `.dk-sheet__sub` 14px, `.dk-hint/.dk-err` 12.5px, `.dk-sheet__eyebrow` 12px.
- 320px-də üfüqi daşma düzəldildi: `.ba-grid`/`.services-grid` → `minmax(min(300px,100%),1fr)`; `.demo-bar-right` wrap; 380px altında nav padding.

**Tam dil paketi (4 dil pariteti)**
- `$demo_texts` hər dildə **76 → 92 açar** (16 yeni × 4): `hero_card_badge/rating/care/service/offer`, `upload_hint`,
  `toast_file_too_big`, `toast_compare_ready`, `toast_cleared`, `toast_booked`, `wa_*` (6), `meta_desc`, `services_desc`.
- Hardcoded AZ mətn nodları **7 → 0** (audit təsdiqi). Hero kartı, toast, fayl hinti, JS xəbərdarlıqları, WhatsApp mesajı artıq dildən asılıdır.
- `$services` müddəti ədədə çevrildi (`180`), dildə formatlanır: `180 dəq / 180 min / 180 dk / 180 мин`.
- `$stylists['exp']` ədədə çevrildi, formatlanır: `8 il təcrübə / 8 years experience / 8 yıl deneyim / 8 лет опыта`.
- Bron sheet-inin usta siyahısı artıq `$stylists`-dən generasiya olunur (əvvəl hardcoded 4 ad), xidmət siyahısı qiymət+müddətlə lokallaşır.

**Meta / SEO / sosial (eyni zamanda #6 üçün əsas)**
- Dinamik `<title>`, `meta description`, `canonical`, `hreflang` (az/en/ru/tr + x-default).
- Open Graph (11 teq) + Twitter card (4 teq) — brend adından asılı.
- `BeautySalon` JSON-LD: ünvan, telefon, iş saatları, `aggregateRating 4.9 / 128`.
- `data:` favicon əlavə edildi (əvvəl `/favicon.ico` 404 verirdi).

**Yoxlama**
- `php -l` təmiz; 4 dil HTTP **200**; JS xətası **0**; 320→1920px bütün genişliklərdə `scrollWidth == innerWidth`.
- Audit: min şrift 12px, <12px **0**, `$t[]` tanımsız açar **0**, hardcoded AZ node **0**.
- Skriptlər: `scratch/beauty_design_audit.php`, `scratch/beauty_meta_check.php`,
  `scratch/cdp_beauty_shot.js`, `scratch/cdp_booking_probe.js`, `scratch/cdp_wide.js`.
- Skrinşotlar: `scratch/beauty-az-desktop.png`, `scratch/beauty-az-mobile.png`, `scratch/booking-az.png`.

## 2026-11-16 (davam 2) — Sky Beauty: brend, təklif qiymətləri, 10 tema, panel, qalereya

**#1 — Brend bir yerdə**
- Yeni `config/demo-beauty.php`: brend adı, telefon, WhatsApp, sosiallar, ünvan/iş saatları (4 dil),
  `services`, `stylists`, `themes`. Demo yalnız buradan oxuyur.
- Canlı dəyişikliklər `data/demo-beauty.json` üzərindən (panel yazır). `$brand` tək dəyişəndir:
  `<title>`, OG/Twitter, JSON-LD, header, footer, WhatsApp və `BEAUTY_I18N.brand` hamısı ondan gəlir.
- `$demo_texts`-dən `brand_name` açarı çıxarıldı; `footer_desc` mətnləri də brendsizləşdirildi.
- 4 dildə `$demo_texts` = **81 açar**, paritet 0/0/0; `$t[]` tanımsız açar 0.

**#2 — Təklif qiymətləri**
- `services` qiymətləri ədədə çevrildi + `old_price`: 90/150, 75/120, 19/25, 25/35, 49/65, 39/55, 22/30, 35/50 AZN.
- Saytda: yeni qiymət + üstündən xətt çəkilmiş köhnə qiymət + `−N%` nişanı. Bron siyahısında da təklif görünür.
- Panel «Xidmətlər və qiymətlər»: qiymət, köhnə qiymət, müddət, aktivlik və 4 dildə ad/təsvir.

**#5-A — 10 rəng teması**
- `themes`: Rose (pink), Gold, Emerald, Aqua, Sapphire, Violet, Sunset, Crimson, Teal, Mono.
- `:root` + `body[data-theme=...]` CSS dəyişənləri; 13 `rgba(255,42,133,…)` və 22 `rgba(0,255,255,…)`
  `rgba(var(--rose-rgb),…)` / `rgba(var(--cyan-rgb),…)` ilə əvəzləndi (tema dəyişəndə parıltılar da dəyişir).
- Demo üst panelində 10 rəng nöqtəsi (canlı önizləmə, `localStorage: beauty-theme`), panel «Salon» tabında radio seçim.

**#3 — Qalereya + watermark**
- Panel «Qalereya» tabı: loqo (PNG/JPG/WEBP ≤3 MB), foto (≤10 MB), video (**MP4 ≤25 MB**), silmə.
- Şəkil watermark: GD **yalnız CLI-də** işlədiyi üçün `modules/web-demos/beauty-watermark-cli.php` alt-proseslə çağırılır
  (`config/beauty-media.php` → `beauty_watermark_image()`). Loqo sağ-aşağıda, ölçü şəklin 22%-i, ~78% opaklıq.
- Video watermark: ffmpeg (`<FFMPEG_PATH>`) overlay,
  `libx264 -crf 23` + `aac`, `+faststart`. `beauty_find_ffmpeg()` PATH fallback ilə.
- Fayllar: `uploads/beauty/` (`.htaccess` skript icrasını bağlayır), siyahı `data/beauty-gallery.json`.
- Demo: yeni «Ustaların əl işləri» bölməsi (foto/video, boş halda mesaj), navda «Qalereya».
- Default loqo `uploads/beauty/logo.png` (`scratch/make_beauty_logo.php` ilə yaradıldı).

**Panel**
- URL: `http://127.0.0.1/sky/modules/web-demos/beauty-panel.php` · şifrə **`<BEAUTY_PANEL_PASSWORD>`**.
- CSRF, `hash_equals`, yanlış şifrədə 0.4s gecikmə, `noindex`; atomik JSON yazısı (tmp + rename);
  «Sistem» tabında tam sıfırlama (JSON silinir, media qalır).

**Yoxlama**
- `php -l` təmiz (demo, panel, config, watermark CLI). 4 dil HTTP **200**, JS xətası **0**, PHP warning **0**.
- 320→1920px: `scrollWidth == innerWidth` (qalereya ilə birlikdə).
- `scratch/beauty_panel_e2e.php`: 22 yoxlama OK (login, yanlış şifrə, salon, tema, qiymət, reset).
- `scratch/beauty_media_e2e.php`: 15 yoxlama OK (loqo, şəkil, video, demo render, silmə).
- Watermark vizual təsdiq: video kadrı + şəkil çıxışı.
- Skrinşotlar: `scratch/panel-salon.png`, `scratch/panel-services.png`, `scratch/beauty-az-desktop.png`.

**Qalan (növbəti mərhələ)**
- ~~#4 onlayn rezervasiya~~ → **2026-11-17-də tamamlandı** (aşağıdaki bölmə).
- #5-B: rəylər/ulduzlar (yalnız menecer silir/cavab verir) + işçi profilləri (sahibi/sahibəsi nişanı).

## 2026-11-17 — #4 onlayn rezervasiya axını (tam) ✅

**Yeni fayllar**
- `config/beauty-bookings.php` — vahid məntiq: bron anbarı, müştəri bazası, davamiyyət, ayarlar,
  beh hesabı (`bb_deposit`), status dəyişmə (`bb_set_status`), gündəlik hesabat (`bb_report`),
  4 dildə xəta mesajları (`bb_msg`), atomik JSON (`bb_write_json`).
- `modules/web-demos/beauty-booking-api.php` — public POST endpoint. JSON və ya form qəbul edir;
  sessiya tokeni (`hash_equals`), sessiya üzrə 10 dəqiqədə maks. 6 bron, bütün sahələrin server yoxlaması.
  Cavab: `code`, `price`, `deposit`, `card_number`, `card_holder`, `visit_no`, `status`.
- `scratch/beauty_booking_e2e.php` — 46 yoxlama; başlamazdan əvvəl `data/` fayllarını snapshot edir,
  sonda bərpa edir.
- `scratch/cdp_booking_flow.js` — real Chrome (CDP): sheet doldurur, bron edir, təsdiq pəncərəsini yoxlayır.
- `scratch/cdp_panel_tabs.js` — panelə girir, 3 yeni tabı açır, JS xətası və 360px daşmanı yoxlayır.

**Dəyişən fayllar**
- `modules/web-demos/demo-beauty.php`
  - Artıq `config/config.php` + `config/beauty-bookings.php` yükləyir (sessiya tokeni üçün).
  - `$demo_texts`: **81 → 96 açar** (15 yeni × 4 dil): `booking_sub`, `booking_success_title/desc`,
    `label_code/datetime/price/deposit/card/holder`, `pay_note`, `btn_wa_pay`, `att_work/off`,
    `booking_error`, `btn_close`. Paritet 0/0/0.
  - Bron sheet-i: xidmət `<select>` artıq **service_id** göndərir; slotlar `BB_SLOTS`-dan; submit →
    `fetch('beauty-booking-api.php')`. Uğurlu bron → yeni təsdiq pəncərəsi (`#bookingSuccess`):
    bron kodu, tarix/saat, qiymət, **beh**, **kart nömrəsi/sahibi**, WhatsApp qəbz düyməsi.
  - Usta kartlarında bugünkü davamiyyət: yaşıl «İşdədir» / qırmızı «İşdə deyil» (`.stylist-att`).
  - Yeni CSS: `.bsum*` (təsdiq), `.stylist-att` (12.5px — audit limitinə uyğun).
- `modules/web-demos/beauty-panel.php`
  - `bp_state()` artıq `booking` bölməsini oxuyur (`bb_settings`); `save_salon`/`save_services`
    yazılarında booking ayarları da saxlanılır.
  - 3 yeni tab: **Rezervasiyalar** (kart/beh ayarı, filtrli bron cədvəli, status əməliyyatları,
    müştəri bazası), **Davamiyyət** (gün seçimi, usta üzrə yaşıl/qırmızı), **Hesabat**
    (stat kartları + usta üzrə cədvəl + salon cəmi).
  - Yeni POST əməliyyatları: `save_booking_settings`, `booking_status`, `delete_booking`,
    `set_attendance`. `bp_redirect_query()` filtr/tarix parametrlərini qoruyur.
  - CSS: cədvəl, badge, stat, davamiyyət, filtr, mobil sürüşən `.table-wrap`.
- `config/demo-beauty.php` — `booking` defaultları: `card_number`, `card_holder`,
  `deposit_percent = 20`, `deposit_min = 10`.

**Biznes qaydaları (yerinə yetirilən)**
- Müştəri qeydiyyatı: telefon (994XXXXXXXXX) açarı; `visits` hər bronda artır, `spent` yalnız
  «tamamlandı»da; status geri alınanda xərc geri çıxılır.
- Beh: `max(min, round(price × pct / 100))`. 90 AZN → 18; 19 AZN → 10.
- Slot toqquşması: eyni usta + gün + saat, `cancelled`/`no_show` istisna.
- Davamiyyət: «işdə deyil» → API `stylist_off` (bron yaradılmır).
- Hesabat gəliri: yalnız `confirmed` + `completed`; behlər həmin bronların `deposit` cəmi.

**Yoxlama nəticələri**
- `php -l`: `config/beauty-bookings.php`, `beauty-booking-api.php`, `demo-beauty.php`,
  `beauty-panel.php`, `config/demo-beauty.php` — təmiz.
- `beauty_booking_e2e.php`: **46/46 OK**.
- `beauty_panel_e2e.php`: 22 OK; `beauty_media_e2e.php`: 15 OK (fixtures `_wm_test.jpg`,
  `_gallery_test.jpg`, `_test_src.mp4` müvəqqəti yaradıldı və silindi → `uploads/beauty/` yalnız `logo.png`).
- `beauty_design_audit.php`: 96 açar × 4 dil, paritet 0/0/0, `$t[]` tanımsız 0, hardcoded AZ 0,
  min şrift 12px (yeni `.stylist-att` 12.5px, `.bsum-note` 13.5px).
- `cdp_booking_flow.js az`: `#bookingSuccess.active`, `SB-0001`, `18 AZN`, kart `4169 7388 0000 0000`,
  WhatsApp `wa.me/...` linki — OK.
- `cdp_panel_tabs.js`: Rezervasiyalar (2 gözləyir), Davamiyyət (3 işdədir / 1 işdə deyil),
  Hesabat (109 AZN gəlir, 28 AZN beh), JS xətası **0**, 360px `scrollWidth == innerWidth`.
- `cdp_errors.js` 4 dil + panel: JS xətası 0. `cdp_measure.js`: 12 en, daşma yox. `parity.php`: 0/0/0.
- Skrinşotlar: `scratch/booking-success-az.png`, `scratch/panel-bookings.png`,
  `scratch/panel-attendance.png`, `scratch/panel-report.png`, `scratch/panel-mobile.png`.

**Qeydlər / məhdudiyyətlər**
- Demo-kit-in telefon sahəsi 9 rəqəmli lokal format gözləyir (`551 234 567`); server tərəfi
  `+994...` formatını da qəbul edir.
- Vaxt müddəti (duration) üzrə toqquşma hesablanmır — yalnız eyni saat slotu bloklanır.
- Rezervasiya `data/` JSON-larındadır (MySQL tələb olunmur); `data/.htaccess` veb girişini bloklayır.
- Test zamanı `data/` faylları bərpa olunur; hazırda `beauty-*.json` faylları **yoxdur** (təmiz default).

---

## 2026-11-17 — #5-B: müştəri rəyləri/ulduzlar + usta profilləri ✅

**Yeni fayllar**
- `config/beauty-reviews.php` — rəy anbarı (`data/beauty-reviews.json`), `br_add()`, `br_set_status()`,
  `br_set_reply()`, `br_delete()`, `br_summary()`, `br_public()`, `br_msg()` (4 dil).
- `config/beauty-staff.php` — config + panel dəyişikliklərinin birləşməsi (`bs_list()`),
  profil yazısı (`bs_save_profile()`), foto URL/silmə (`bs_img_url()`, `bs_delete_photo_file()`).
- `modules/web-demos/beauty-review-api.php` — public rəy endpoint-i (JSON POST).
- `scratch/beauty_reviews_e2e.php` — 56 yoxlama (snapshot/restore).
- `scratch/cdp_review_flow.js` — real brauzer rəy forması axını.

**Məntiq**
- Rəy yalnız **`completed`** bron kodu ilə yazılır; hər bron üçün **bir** rəy.
- Yeni rəy `pending` → panel **Rəylər** tabı: `approved` / `hidden` / `pending` / sil.
- Orta reytinq və say yalnız `approved` rəylərdən (`br_summary()`); boş olduqda JSON-LD
  `aggregateRating` **ümumiyyətlə yazılmır**, hero nişanı boş qalır.
- Panel bron cədvəlindən tamamlanmış bron üçün WhatsApp **«Rəy dəvəti»** linki
  (`?lang=az&review=SB-XXXX#reviews` → demo forma avtomatik açılır); rəy artıq varsa status linki.
- Endpoint qoruması: `beauty_review_token` (CSRF), 10 dəqiqədə maks. **4** rəy,
  validasiya (mövcud bron, completed, təkrar, 1–5 ulduz, 10–600 simvol) → 405/403/429/422.

**Usta profilləri**
- Panel **Ustalar** tabı: vəzifə (4 dil), bio (4 dil), təcrübə, nişan, `owner`, `active`, foto.
- Ad dəyişmir — bron və davamiyyət tarixçəsi ona bağlıdır.
- `active=false` → usta demo kartlarından **və bron seçimindən** çıxır; paneldə «Saytda gizlidir».
- Foto: JPG/PNG/WEBP, maks. 3 MB, `getimagesize()` yoxlaması, `uploads/beauty/staff-*`;
  Apache PHP-də GD yoxdur → ölçü dəyişdirilmir. Köhnə foto əvəzlənəndə silinir.
- `config/demo-beauty.php`: 4 usta üçün `bio` (4 dil) + Leyla Qasımova `owner => true`.

**Demo dəyişiklikləri (`demo-beauty.php`)**
- Yeni **«Rəylər»** bölməsi (orta bal, ulduzlar, kartlar, salon cavabı, boş vəziyyət) + nav linki.
- Rəy forması `DK.sheet` ilə: bron kodu, ulduz `select` (6 opsiya: placeholder + 5), mətn.
- Usta kartında 👑 «Sahibə» nişanı + bio; hero reytinq nişanı dinamik.
- 18 yeni i18n açarı × 4 dil (paritet 116/116).

**Yoxlama nəticələri**
- `php -l`: 6 fayl təmiz.
- `beauty_reviews_e2e.php`: **56/56 OK** — validasiya, təsdiq, orta 5.0 → 4.5, cavab, gizlətmə,
  usta bio/vəzifə/foto, dəvət linki.
- `beauty_booking_e2e.php` 46/46, `beauty_panel_e2e.php` 22 OK, `beauty_media_e2e.php` 15 OK.
- `beauty_design_audit.php`: 116 açar × 4 dil, paritet 0/0/0, tanımsız 0, hardcoded AZ 0.
- `cdp_review_flow.js SB-0001`: forma açıldı (6 opsiya), kod əvvəlcədən dolduruldu, göndərildi,
  «təsdiqə göndərildi» toast, rəy `pending` kimi yazıldı, JS xətası 0.
- `cdp_panel_tabs.js`: 5 tab (Ustalar + Rəylər daxil), JS xətası 0, 360px daşma yox.
- `cdp_errors.js` demo 4 dil + panel: JS xətası 0. `cdp_measure.js`: 12 en, daşma yox.

**Qeydlər**
- E2E-də PHP curl massiv POST nested massivi `role[az]` kimi yox, mötərizəsiz göndərir —
  test açarları əl ilə `role[az]` / `bio[az]` yazır. Panel forması brauzerdə düzgün işləyir.
- Foto yükləmə formunda «Saytda göstər» işarəsi ayrıca göndərilməlidir (checkbox davranışı).
- Testdən sonra `data/beauty-*.json` və `uploads/beauty/staff-*` silinir; `uploads/beauty/` yalnız `logo.png`.

## 2026-11-17 (davam 2) - Sky Beauty: dizayn, tema, xidmət şəkilləri ✅

Dörd istifadəçi tapşırığı yerinə yetirildi:

### 1) Dizayn «AI işi» görünməsin
- `--font-display: 'Playfair Display'` (Google Fonts) əlavə olundu; hero, bölmə başlıqları, kart adları,
  footer adı serifə keçdi (`font-weight: 600`, mənfi letter-spacing).
- Bölmə başlıqları mərkəzdən sola düzləndi, altında 44px qırmızı xətt (`.section-head h2::after`).
- `.hero-tag` pill əvəzinə xətt + böyük hərf; neon/glow effektləri zəiflədildi
  (`--neon-glow`, `--rose-glow`, `box-shadow` dəyərləri azaldıldı).
- Hero-nun emoji «✨» yerinə real salon fotosu (`.hero-photo`), yanğın-düyməsi yaşıl WhatsApp
  rəngindən tema qradientinə keçdi.
- `$demo_texts` içində 44 mətn (hero, xidmətlər, komanda, footer, kart) 4 dildə sadə insan dilinə yazıldı;
  statistika real komandaya uyğunlaşdırıldı: `12+ il`, `4 usta`, `8 xidmət` (əvvəl `25,000+`, `15+`).

### 2) Onlayn bron: oxunaqlı siyahı + Skyweb loqosu
- `demo-kit.css`: `.dk-input/.dk-textarea/.dk-select` → `color-scheme: dark`;
  `.dk-select option/optgroup` fonu `#08222a`, mətni `#f2ffff` (ağ fonda ağ yazı problemi bitdi).
- `.dk-sheet` fonu `--dk-panel`, başlıq qradienti `--dk-accent-rgb`, alt mətn `--dk-muted` — tema ilə dəyişir.
- Navbar-dakı 💎 kristal əvəzinə `index.php`-dəki Skyweb SVG loqosu (gradient `neon-cyan → beauty-rose`).

### 3) 10 rəng teması bütün sayta
- `demo-beauty.php`-də palitra funksiyaları: `$hx_arr`, `$hx_hex`, `$hx_mix`, `$hx_rgbs`, `$theme_palette`.
- Hər tema üçün `--sky-bg-1..4`, `--sky-ink(-rgb)`, `--sky-surface-rgb`, `--sky-panel`, `--sky-card(-strong)`,
  `--sky-footer`, `--on-accent`, `--rose-deep/soft`, `--text-main/muted`, `--dk-panel`, `--dk-accent-rgb`
  `body[data-theme=…]` qaydalarına yazılır; hardcoded tünd firuzəyi/neon rənglər silindi.
- JS: `applyAccent()` `--dk-accent` + `--dk-accent-rgb` + `data-dk-accent` yeniləyir;
  düymələr `DOMContentLoaded`-da bağlanır (əvvəl script `<body>`-dən əvvəl işlədiyi üçün kliklər boşa düşürdü).

### 4) Xidmət adları + real şəkillər
- 8 xidmət (4 dildə) sadələşdirildi: Balayaj · Keratin düzləşdirmə · Manikür + gel-lak · Pedikür + spa ·
  Dərin təmizləmə · Axşam makiyajı · Qaş laminasiyası · Üz masajı.
- Şəkillər Pexels CDN (`images.pexels.com/photos/<id>`) ilə dəyişdirildi, hər biri vizual yoxlanıldı;
  uyğunsuz olan «Karboksi liftinq» → «Üz masajı», «Hydrafacial» → «Dərin təmizləmə» adlandı ki,
  foto ilə mətn üst-üstə düşsün.
- «Əvvəl / Sonra» kartları: saç yuma→sleek, qulluq→təzə üz, rəng seçimi→lak nəticə cütləri ilə əvəzləndi;
  başlıqlar/açıqlamalar da yeni adlara uyğunlaşdırıldı.

**Yoxlama**
- `beauty_design_audit.php`: 116 açar × 4 dil, paritet 0/0/0, tanınmayan açar 0, hardcoded AZ 0.
- `beauty_reviews_e2e.php` (56), `beauty_booking_e2e.php` (46), `beauty_panel_e2e.php` (22),
  `beauty_meta_check.php`, `parity.php` → hamısı OK.
- `cdp_errors.js` demo 4 dil → 0 xəta; `cdp_measure.js` 320–1920 → overflow yox;
  `cdp_panel_tabs.js` → 5 tab, JS 0; `cdp_booking_flow.js` → bron SB-0001, beh 18 AZN, WhatsApp linki.
- `_themecheck.js` ilə 4 tema yoxlanıldı: `--dk-accent` dəyişir, `colorScheme: dark`, sheet fonu tema uyğun.

**Qeyd:** `data/` və `uploads/beauty/` yenidən təmiz default vəziyyətə qaytarıldı
(qalereya və rəylər boşdur — panelə yükləmə/rəy yazma ilə dolur).

## 2026-11-17 (davam 3) - Sky Beauty: hero reklam / təklif bloku ✅

İstifadəçi tələbi: hero-dakı «SPA & SALON» kartındaki statik «Ən çox seçilən · Dərin təmizləmə & Balayaj ·
-20% ENDİRİM» yazısı reklam/marketinq blokuna çevrilsin; rəhbərlik hansı xidmətin günlük/həftəlik təklif
olduğunu orada paylaşsın, istəyən «Müraciət et» etsin.

### Model
- `offer: { active, service_id, price, period: daily|weekly, audience: all|corporate, note: {az,en,tr,ru} }`
- Default: `config/demo-beauty.php` → xidmət 405 (Dərin təmizləmə), 39 AZN, həftəlik, hamı üçün.
- Oxuma/sanitizasiya: `bb_offer($cfg, $bd)` + `bb_default_offer()` (`config/beauty-bookings.php`).
- `bb_effective_config()` → `_offer`; `bb_create_booking()` aktiv təklif xidmətində təklif qiymətini tətbiq edir,
  brona `list_price` və `offer` sahələri yazılır.

### Panel (`beauty-panel.php`)
- Yeni **Təkliflər** tabı: aktiv/gizli, xidmət seçimi, təklif qiyməti, günlük/həftəlik, kimə aiddir,
  4 dildə qısa reklam mətni; altında «Saytda necə görünəcək» önizləməsi.
- `save_offer` POST əməliyyatı; qiymət xidmətin qiymətindən böyük/bərabər olsa xəta.
- `bp_state()` təklifi default + JSON-dan birləşdirir; `bp_payload()` bütün bölmələri (offer daxil) yazır —
  əvvəlki 3 `bp_save` çağırışı bununla əvəzləndi (offer itməsinin qarşısı alınır).

### Sayt (`demo-beauty.php`)
- Hero kartında təklif aktivdirsə: dövr nişanı, «Kompaniya əməkdaşları üçün» nişanı, xidmətin adı,
  reklam mətni, təklif qiyməti + üstündən xətt çəkilmiş xidmət qiyməti + endirim %, «Müraciət et».
- Hero foto da təklifin xidmət şəkli ilə dəyişir (alt mətni xidmətin adıdır) — blok real reklam kimi görünür.
- `openBookingModal(id, audience)` — rəqəmli ID ilə preset; kompaniya təklifində qeyd avtomatik doldurulur.
- `BEAUTY_SERVICES` təklif xidməti üçün təklif qiyməti/beh göstərir.
- Yeni i18n açarları (4 dil): `offer_daily`, `offer_weekly`, `offer_today`, `offer_week`, `offer_apply`,
  `offer_corporate` (116 → 122).
- `demo-kit.js`: `sheet()` textarea üçün `value` dəstəyi əlavə olundu (əvvəlcədən doldurma üçün).

### Yoxlama
- `php -l` — 4 fayl təmiz.
- `beauty_design_audit.php`: 122 açar × 4 dil, paritet 0/0/0, tanımsız açar 0, hardcoded AZ 0.
- `beauty_panel_e2e.php`: 31 OK (yeni təklif addımı: aktiv → gizli).
- `beauty_booking_e2e.php`: 49 OK (təklif qiyməti brona tətbiq olundu: 39 AZN / beh 10 AZN).
- `beauty_reviews_e2e.php`, `beauty_meta_check.php`, `parity.php`: OK.
- `cdp_errors.js`: 0 xəta; `cdp_measure.js` 320–1920: overflow yox;
  `cdp_panel_tabs.js`: Təkliflər tabı daxil 6 tab, JS 0, 360px daşma yox.
- CDP probe: `.hero-offer-cta` → bron pəncərəsində xidmət 405, «39 AZN (49 AZN)», corporate-da qeyd
  «Kompaniya əməkdaşı»; EN-də «Company employee».
- `data/` təmiz default vəziyyətə qaytarıldı; müvəqqəti `scratch/_offer*` faylları silindi.

## 2026-11-17 (davam 4) - Sky Beauty: virtual stil studiyası ✅

İstifadəçi tələbi: saytdaki «Öz nümunənizi əlavə edin» (əvvəl/sonra iki şəkil yükləmə) bölməsi
**virtual stil studiyası** ilə əvəzlənsin — müştəri öz şəklini yükləyir, xidmət/stil seçir,
«bu iş görülsə belə görünəcəksən» təxmini nəticəsini görür və seçimini ustaya göndərir.
Şəkil serverdə saxlanılmır; paket satışında izah asan olsun deyə struktur sadə saxlanıldı.

### Kataloq — `config/beauty-styles.php` (yeni fayl)
- 5 kateqoriya, cəmi **27 stil**: Saç (6), Toy & ziyafət (5), Makiyaj (5), Qaş (5), Dırnaq (6).
- Hər kateqoriya: `label`/`hint`/`photo_hint` 4 dildə, `icon`, `demo` (üz/əl modeli), `service_id`.
- Hər stil: `id`, `name`/`desc` 4 dildə, referans `img`, `service_id`,
  `fx { filter, tint, blend, opacity }` — CSS ilə rəng/ton simulyasiyası (xarici AI API yoxdur).
- Demo modellər: üz — Pexels `5128274`, əl — Pexels `3997386`. Gələcəkdə real AI try-on qoşulsa,
  yalnız `fx` hissəsi dəyişəcək.

### Sayt — `demo-beauty.php`
- Köhnə `.ba-upload-panel` markup-u, `.ba-upload-*`/`.ba-comp-*` CSS-i və `handleBeforeUpload`/
  `resetBAUpload` JS-i tam silindi → yeni `.studio` bölməsi.
- Sol tərəf: şəkil stage-i (əvvəl/sonra slayderi, 0–100%), «Şəkil yükləyin» dropzone, demo model nişanı,
  «Şəkli dəyiş» / «Şəkli sil», privacy + «təxmini önizləmədir» qeydi.
- Sağ tərəf: 5 kateqoriya tabı, seçilmiş kateqoriyanın stil kartları (şəkil + ad + qısa izah),
  «Seçilmiş stillər» çipləri və «Ustaya göndər».
- Kateqoriya üzrə bir seçim; kateqoriyalar arası çoxseçim mümkündür. Stil seçimi dərhal
  `studio-fx` qatına `filter` + `tint` + `mix-blend-mode` kimi tətbiq olunur.
- Şəkil yoxdursa kateqoriyaya uyğun demo model (üz/əl) göstərilir.
- Validasiya: yalnız `image/*`, maks 10 MB; `URL.createObjectURL` + `revokeObjectURL`;
  `beforeunload`/`pagehide` ilə avtomatik təmizləmə. Şəkil heç bir endpoint-ə göndərilmir.
- `openBookingModal(serviceName, audience, brief)` — 3-cü parametr brif kimi 250 simvolla qeydə əlavə olunur;
  corporate qeydi ilə birləşir (server limiti 300 simvol).
- Mobil: tab lenti sürüşən, aktiv tab avtomatik görünənə qədər `scrollLeft` düzəldilir;
  `.studio-send` ≤1000px tam en, desktopda `max-width: 340px` — sabit «Onlayn Növbə» düyməsi ilə toqquşma yox.
- `.studio-body` `align-items: stretch` + `.studio-panel` flex column + `.studio-actions { margin-top:auto }`
  → sağ sütunun boşluğu balanslaşdırılır.
- Şəkil düzəlişləri: dırnaq kartları `3997390`/`3997381`; saç tintləri `overlay`/`multiply` və 38%-də bitən
  gradient; qaş və qrafik eyeliner tintləri radial ellips; kiçik şriftlər 11.5–12.5px-ə qaldırıldı.

### i18n
- 25 yeni `studio_*` açarı × 4 dil (122 → 138 açar). `STUDIO_I18N` JS obyekti.
- Köhnə yükləmə panelindən qalan 9 açar (`ba_upload_title`, `ba_upload_sub`, `ba_upload_lbl_before/after`,
  `ba_privacy`, `ba_btn_reset`, `upload_hint`, `toast_compare_ready`, `toast_cleared`) 4 dildən silindi;
  `BEAUTY_I18N`-dən də ölü sahələr çıxarıldı.
- Paritet: 138 × 4, missing/extra 0, tanımsız açar 0, hardcoded AZ 0.

### Testlər
- `php -l`: `config/beauty-styles.php`, `config/demo-beauty.php`, `config/beauty-bookings.php`,
  `demo-beauty.php`, `beauty-panel.php` — təmiz.
- `cdp_studio_probe.js az/en`: 5 tab, 27 stil (6 görünən), yükləmə/silmə, kateqoriya keçidi,
  stil dəyişməsi, slayder `inset(0px 0px 0px 30%)`, göndərmə → bron xidmət 401 + brif qeydi;
  mobil 390px overflow yox; JS xəta 0.
- `cdp_measure.js` 320–1920: overflow yox. Skript təkmilləşdirildi — üfüqi sürüşən lent
  (`overflow-x:auto`) içindəki elementlər artıq yalançı overflow kimi sayılmır.
- `cdp_panel_tabs.js`: 6 tab (Təkliflər daxil), JS 0, 360px daşma yox.
- `beauty_panel_e2e.php`, `beauty_booking_e2e.php`, `beauty_reviews_e2e.php` ardıcıl: hamısı OK.
- `data/` təmiz default; `uploads/beauty/` yalnız `logo.png` + `.htaccess`.

---

## 2026-11-23 — Universal AZ/EN/RU/TR keçidi + server/console xəta təhlükəsizliyi

### Mərkəzi tərcümə qatı
- `config/i18n-literals.php`: 400+ görünən AZ literal üçün 4 dillik cədvəl,
  `$SKY_AB_I18N` (avtobioqrafiya şablonları), ay adları, ambiguous qarşılıqlar üçün açıq qeydlər.
- `config/lang.php`:
  - `sky_literal_map($lang)` — açıqça verilən dil üçün uyğun lüğəti yükləyir
    (saved-CV/CLI hallarında yanlış request dili istifadə olunmur);
  - `sky_translate_html_literals()` — saxlanmış CV HTML-ni tərcümə edir;
  - `sky_translate_document_html()` — SSR output-buffer tərcüməsi; `<script>`, `<style>`,
    `<title>`, `<meta>` və şərhlər qorunur;
  - səhifəyə xas `window.__SKY_SSR_REVERSE__` target→AZ xəritəsi **son** `</body>`-dən əvvəl
    əlavə olunur (index.php-də `document.write()` içindəki `'</body></html>'` səbəbindən ilk
    `</body>` yanlış yerdir; bu, client-side `SyntaxError: Invalid or unexpected token` yaradırdı).
- `assets/js/sky-i18n.js`: `renderedLang`/`activeLang` ayrımı, canonical source restoration,
  URL (`?lang=`), cookie, localStorage və PHP session sinxronizasiyası, title-in hər keçiddə
  canonical AZ mənbədən yenidən qurulması, `sky-lang-changed` hadisəsi.
- Output-buffer bütün əsas səhifələrdə aktiv: `index.php`, CV/games/analytics, auth və 11 demo.

### Xüsusi səhifələr
- CV/avtobioqrafiya: `api/cv-service.php`, `modules/cv-builder/view.php`, 4 dillik `$SKY_AB_I18N`;
  regex əsaslı tərcümə əvəzinə hazır şablonlar. Saved CV HTML-i view zamanı tərcümə olunur.
- Analytics qrafik etiketləri `sky-lang-changed` ilə yenidən qurulur; SkyBot tarixçəsi dil dəyişdikdə
  yenidən sorğulanır.
- `lang/tr.php`: `cv_panel_title` → «CV Oluşturma Paneli».
- `assets/js/main.js`: Service Worker artıq `document.currentScript`-dən hesablanan sayt kökündən
  (`/sky/sw.js`, `scope: /sky/`) qeydiyyata alınır; alt səhifələrdə 404 yoxdur.
- Games/analytics/CV və 10 demo səhifəsinə inline favicon əlavə edildi — `favicon.ico` 404-ü yoxdur.
- Demo-food title suffixi `sky_literal_translate('Skyweb Food Demo')` ilə 4 dilə localsallaşdırıldı.

### Doğrulama
- `php -l`: 114 fayl təmiz; `node --check sky-i18n.js`, `main.js` təmiz.
- HTTP audit (`sky_full_http_audit.php`): 23 səhifə × 4 dil = 92 sorğu, **FAILURES: 0**
  (blog EN/TR marka başlığı allowlist-ə alındı).
- Full CDP (`sky_full_cdp_check.js`): 17 səhifə yüklənməsi + 4 keçid axını, **TOTAL FAILURES: 0**.
- Reverse CDP (`sky_reverse_lang_cdp.js`): index/games/analytics/cv üçün EN→AZ OK.
- `sky_lang_cdp.js`: 5 səhifə üçün az→en→az OK.
- `sky_autobio_cdp.js`: avtobioqrafiya 4 dil üçün OK.
- Saved CV HTML 4 dil üçün OK (TR «CV Dili» də düzgün).
- Apache `error.log`: müvəqqəti regex xəbərdarlıqlarından (01:43–01:44) sonra yeni PHP xətası yoxdur.

### Qalan məhdudiyyətlər
- `manifest.json` statik AZ ad/təsvir saxlayır (PWA install banneri).
- Demo daxili `$t` massivləri SSR `?lang=` ilə dəyişir; bəzi daxili demo mətnləri client-side
  instant re-render olmur.
- Şəxs adları/nümunə məlumatları və bəzi admin-only sətirlər tərcümə olunmur (qəsdən).
- `blog.php` başlığı marka adı olduğu üçün EN/TR-də AZ ilə eyni qalır (audit allowlist-ində).


