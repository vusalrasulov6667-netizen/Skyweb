<?php
/**
 * Sky Beauty — rezervasiya, müştəri qeydiyyatı, davamiyyət və gündəlik hesabat.
 * ------------------------------------------------------------------
 * Bütün məlumat `data/` qovluğunda JSON kimi saxlanılır (veb-dən əlçatmaz):
 *   • data/beauty-bookings.json   — bronlar (kod, status, beh, ödəniş)
 *   • data/beauty-customers.json  — müştəri bazası (telefon açarı ilə)
 *   • data/beauty-attendance.json — usta davamiyyəti (gün → usta → work/off)
 *   • data/demo-beauty.json       — salon ayarları (kart nömrəsi, beh faizi)
 *
 * Qaydalar:
 *   • Beh = xidmət qiymətinin `deposit_percent`%-i, amma ən azı `deposit_min` AZN.
 *   • Menecer ödənişi əl ilə təsdiqləyir (status: pending → confirmed).
 *   • Usta «işdə deyil»dirsə, həmin günə bron qəbul olunmur.
 */
declare(strict_types=1);

const BB_SLOTS    = ['10:00', '11:30', '13:00', '14:30', '16:00', '17:30', '19:00'];
const BB_STATUSES = ['pending', 'confirmed', 'completed', 'no_show', 'cancelled'];

/* ───────────────────────── Fayl köməkçiləri ───────────────────────── */

function bb_data_dir(): string {
    return dirname(__DIR__) . '/data';
}

function bb_json_path(string $name): string {
    return bb_data_dir() . '/' . $name;
}

function bb_read_json(string $file, array $default = []): array {
    $path = bb_json_path($file);
    $data = is_file($path) ? json_decode((string)file_get_contents($path), true) : null;
    if (!is_array($data)) return $default;
    return array_replace($default, $data) + $default;
}

/** Atomik JSON yazısı (tmp + rename). */
function bb_write_json(string $file, array $data): bool {
    $path = bb_json_path($file);
    $dir  = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) return false;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    $tmp = $path . '.tmp' . bin2hex(random_bytes(4));
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    if (!rename($tmp, $path)) {
        @unlink($tmp);
        return false;
    }
    return true;
}

/* ───────────────────────── Bron anbarı ───────────────────────── */

function bb_bookings(): array {
    $d = bb_read_json('beauty-bookings.json', ['next' => 1, 'items' => []]);
    if (!is_array($d['items'])) $d['items'] = [];
    $d['next'] = max(1, (int)$d['next']);
    return $d;
}

function bb_save_bookings(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-bookings.json', $d);
}

function bb_find_booking(array $d, string $code): ?int {
    foreach ($d['items'] as $i => $b) {
        if (($b['code'] ?? '') === $code) return $i;
    }
    return null;
}

/* ───────────────────────── Müştəri bazası ───────────────────────── */

function bb_customers(): array {
    $d = bb_read_json('beauty-customers.json', ['customers' => []]);
    if (!is_array($d['customers'])) $d['customers'] = [];
    return $d;
}

function bb_save_customers(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-customers.json', $d);
}

/** Telefonu 994XXXXXXXXX (12 rəqəm) formatına salır; yanlışdırsa '' qaytarır. */
function bb_normalize_phone(string $phone): string {
    $d = preg_replace('/\D+/', '', $phone) ?? '';
    if (str_starts_with($d, '00')) $d = substr($d, 2);
    if (str_starts_with($d, '994')) $d = substr($d, 3);
    if (str_starts_with($d, '0')) $d = substr($d, 1);
    if (strlen($d) !== 9) return '';
    if (!preg_match('/^[4-7]\d{8}$/', $d)) return '';
    return '994' . $d;
}

/** 994XXXXXXXXX → +994 XX XXX XX XX */
function bb_format_phone(string $phone): string {
    $d = preg_replace('/\D+/', '', $phone) ?? '';
    if (strlen($d) === 12 && str_starts_with($d, '994')) {
        $l = substr($d, 3);
        return '+994 ' . substr($l, 0, 2) . ' ' . substr($l, 2, 3) . ' ' . substr($l, 5, 2) . ' ' . substr($l, 7, 2);
    }
    return $phone;
}

/* ───────────────────────── Davamiyyət ───────────────────────── */

function bb_attendance(): array {
    $d = bb_read_json('beauty-attendance.json', ['days' => []]);
    if (!is_array($d['days'])) $d['days'] = [];
    return $d;
}

function bb_save_attendance(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-attendance.json', $d);
}

/** @return 'work'|'off' */
function bb_attendance_state(array $att, string $date, string $stylist): string {
    $v = $att['days'][$date][$stylist] ?? 'work';
    return $v === 'off' ? 'off' : 'work';
}

function bb_set_attendance(string $date, string $stylist, string $state): bool {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return false;
    $att = bb_attendance();
    if ($state === 'off') {
        $att['days'][$date][$stylist] = 'off';
    } else {
        unset($att['days'][$date][$stylist]);
        if (empty($att['days'][$date])) unset($att['days'][$date]);
    }
    return bb_save_attendance($att);
}

/* ───────────────────────── Ayarlar (kart + beh) ───────────────────────── */

function bb_default_settings(): array {
    return [
        'card_number'     => '4169 7388 0000 0000',
        'card_holder'     => 'Sky Beauty MMC',
        'deposit_percent' => 20,
        'deposit_min'     => 10,
    ];
}

/** `data/demo-beauty.json` → booking bölməsi (yoxdursa default). */
function bb_settings(?array $bd = null): array {
    $s = bb_default_settings();
    if ($bd === null) {
        $path = bb_json_path('demo-beauty.json');
        $bd = is_file($path) ? json_decode((string)file_get_contents($path), true) : null;
    }
    if (is_array($bd) && !empty($bd['booking']) && is_array($bd['booking'])) {
        foreach (['card_number', 'card_holder'] as $k) {
            if (array_key_exists($k, $bd['booking'])) $s[$k] = (string)$bd['booking'][$k];
        }
        foreach (['deposit_percent', 'deposit_min'] as $k) {
            if (array_key_exists($k, $bd['booking'])) $s[$k] = (int)$bd['booking'][$k];
        }
    }
    $s['deposit_percent'] = min(100, max(1, (int)$s['deposit_percent']));
    $s['deposit_min']     = min(1000, max(0, (int)$s['deposit_min']));
    return $s;
}

/** Beh məbləği: faiz, amma minimumdan az deyil. */
function bb_deposit(int $price, array $settings): int {
    $pct = (int)($settings['deposit_percent'] ?? 20);
    $min = (int)($settings['deposit_min'] ?? 10);
    return max($min, (int)round($price * $pct / 100));
}

/* ───────────────────────── Günün / həftənin təklifi ───────────────────────── */

function bb_default_offer(): array {
    return [
        'active'     => false,
        'service_id' => 0,
        'price'      => 0,
        'period'     => 'daily',     // daily | weekly
        'audience'   => 'all',       // all | corporate
        'note'       => ['az' => '', 'en' => '', 'tr' => '', 'ru' => ''],
    ];
}

/**
 * Effektiv təklif: config defaultu + `data/demo-beauty.json` → offer.
 * `$bd` verilməzsə JSON faylı özü oxunur. `$cfg` default üçün lazımdır.
 */
function bb_offer(array $cfg, ?array $bd = null): array {
    $o = bb_default_offer();
    if (!empty($cfg['offer']) && is_array($cfg['offer'])) {
        $o = array_merge($o, array_intersect_key($cfg['offer'], $o));
    }
    if ($bd === null) {
        $path = bb_json_path('demo-beauty.json');
        $bd = is_file($path) ? json_decode((string)file_get_contents($path), true) : null;
    }
    if (is_array($bd) && !empty($bd['offer']) && is_array($bd['offer'])) {
        $o = array_merge($o, array_intersect_key($bd['offer'], $o));
    }
    $o['active']     = (bool)$o['active'];
    $o['service_id'] = (int)$o['service_id'];
    $o['price']      = max(0, (int)$o['price']);
    $o['period']     = (($o['period'] ?? 'daily') === 'weekly') ? 'weekly' : 'daily';
    $o['audience']   = (($o['audience'] ?? 'all') === 'corporate') ? 'corporate' : 'all';
    $note = is_array($o['note'] ?? null) ? $o['note'] : [];
    $o['note'] = [];
    foreach (['az', 'en', 'tr', 'ru'] as $l) {
        $o['note'][$l] = mb_substr(trim((string)($note[$l] ?? '')), 0, 140);
    }
    return $o;
}

/**
 * Effektiv demo konfiqurasiyası: `config/demo-beauty.php` + `data/demo-beauty.json`.
 * Demo səhifəsi öz inline merge-ini saxlayır; API və panel eyni nəticəni buradan alır.
 */
function bb_effective_config(): array {
    $cfg  = require dirname(__DIR__) . '/config/demo-beauty.php';
    $over = [];
    $path = bb_json_path('demo-beauty.json');
    if (is_file($path)) {
        $d = json_decode((string)file_get_contents($path), true);
        if (is_array($d)) $over = $d;
    }
    if (!empty($over['brand']) && is_array($over['brand'])) {
        $cfg['brand'] = array_merge($cfg['brand'], array_filter($over['brand'], fn($v) => $v !== null && $v !== ''));
    }
    if (!empty($over['theme']) && isset($cfg['themes'][$over['theme']])) {
        $cfg['theme'] = (string)$over['theme'];
    }
    if (!empty($over['services']) && is_array($over['services'])) {
        foreach ($cfg['services'] as $i => $s) {
            $ov = $over['services'][(string)$s['id']] ?? $over['services'][$i] ?? null;
            if (!is_array($ov)) continue;
            foreach (['price', 'old_price', 'duration'] as $k) {
                if (array_key_exists($k, $ov) && $ov[$k] !== '' && $ov[$k] !== null) {
                    $cfg['services'][$i][$k] = (int)$ov[$k];
                }
            }
            foreach (['title', 'desc'] as $k) {
                if (!empty($ov[$k]) && is_array($ov[$k])) {
                    $cfg['services'][$i][$k] = array_merge($s[$k], array_filter($ov[$k], fn($v) => $v !== null && $v !== ''));
                }
            }
            if (array_key_exists('active', $ov)) $cfg['services'][$i]['active'] = (bool)$ov['active'];
        }
    }
    $cfg['_over']    = $over;
    $cfg['_booking'] = bb_settings($over);
    $cfg['_offer']   = bb_offer($cfg, $over);
    return $cfg;
}

/* ───────────────────────── Lokallaşdırılmış mesajlar ───────────────────────── */

function bb_msg(string $key, string $lang): string {
    $m = [
        'az' => [
            'invalid_service' => 'Seçilmiş xidmət tapılmadı.',
            'invalid_stylist' => 'Usta seçilmədi.',
            'stylist_off'     => 'Bu usta seçilmiş gündə işdə deyil. Başqa usta və ya tarix seçin.',
            'bad_date'        => 'Tarix bu gündən əvvəl ola bilməz.',
            'far_date'        => 'Bron yalnız 90 gün ərzində edilə bilər.',
            'bad_time'        => 'Seçilmiş saat mövcud deyil.',
            'bad_name'        => 'Ad və soyadınızı yazın.',
            'bad_phone'       => 'Telefon nömrəsi düzgün deyil.',
            'slot_taken'      => 'Bu usta üçün seçilmiş vaxt artıq tutulub.',
            'rate'            => 'Çox sayda cəhd. Bir neçə dəqiqə sonra yenidən yoxlayın.',
            'save_failed'     => 'Rezervasiya saxlanmadı. Yenidən cəhd edin.',
            'archived'        => 'Bu bron artıq bağlanıb.',
        ],
        'en' => [
            'invalid_service' => 'The selected service was not found.',
            'invalid_stylist' => 'Please choose a stylist.',
            'stylist_off'     => 'This stylist is not working on the selected date. Choose another stylist or date.',
            'bad_date'        => 'The date cannot be in the past.',
            'far_date'        => 'Bookings are available up to 90 days ahead.',
            'bad_time'        => 'The selected time is not available.',
            'bad_name'        => 'Please enter your full name.',
            'bad_phone'       => 'The phone number is not valid.',
            'slot_taken'      => 'This time slot is already booked for the selected stylist.',
            'rate'            => 'Too many attempts. Please try again in a few minutes.',
            'save_failed'     => 'The booking could not be saved. Please try again.',
            'archived'        => 'This booking is already closed.',
        ],
        'tr' => [
            'invalid_service' => 'Seçilen hizmet bulunamadı.',
            'invalid_stylist' => 'Lütfen bir uzman seçin.',
            'stylist_off'     => 'Bu uzman seçilen günde çalışmıyor. Başka bir uzman veya tarih seçin.',
            'bad_date'        => 'Tarih bugünden önce olamaz.',
            'far_date'        => 'Randevu en fazla 90 gün sonrası için alınabilir.',
            'bad_time'        => 'Seçilen saat uygun değil.',
            'bad_name'        => 'Lütfen ad ve soyadınızı yazın.',
            'bad_phone'       => 'Telefon numarası geçerli değil.',
            'slot_taken'      => 'Seçilen saat bu uzman için zaten dolu.',
            'rate'            => 'Çok fazla deneme. Birkaç dakika sonra tekrar deneyin.',
            'save_failed'     => 'Randevu kaydedilemedi. Lütfen tekrar deneyin.',
            'archived'        => 'Bu randevu zaten kapatılmış.',
        ],
        'ru' => [
            'invalid_service' => 'Выбранная услуга не найдена.',
            'invalid_stylist' => 'Пожалуйста, выберите мастера.',
            'stylist_off'     => 'Мастер не работает в выбранный день. Выберите другого мастера или дату.',
            'bad_date'        => 'Дата не может быть в прошлом.',
            'far_date'        => 'Запись доступна не более чем на 90 дней вперёд.',
            'bad_time'        => 'Выбранное время недоступно.',
            'bad_name'        => 'Пожалуйста, укажите имя и фамилию.',
            'bad_phone'       => 'Номер телефона указан неверно.',
            'slot_taken'      => 'Это время у выбранного мастера уже занято.',
            'rate'            => 'Слишком много попыток. Попробуйте снова через несколько минут.',
            'save_failed'     => 'Не удалось сохранить запись. Попробуйте ещё раз.',
            'archived'        => 'Эта запись уже закрыта.',
        ],
    ];
    return $m[$lang][$key] ?? $m['az'][$key] ?? $key;
}

/* ───────────────────────── Bron yaratma ───────────────────────── */

/**
 * @param array $input  service_id, stylist, date, time, name, phone, note, lang
 * @param array $cfg    config/demo-beauty.php (services, stylists)
 * @return array{ok:bool,error?:string,booking?:array,settings?:array}
 */
function bb_create_booking(array $input, array $cfg, ?array $settings = null): array {
    $lang = (string)($input['lang'] ?? 'az');
    if (!in_array($lang, ['az', 'en', 'tr', 'ru'], true)) $lang = 'az';
    $settings = $settings ?? bb_settings($cfg['_bd_over'] ?? null);

    $serviceId = (int)($input['service_id'] ?? 0);
    $service = null;
    foreach (($cfg['services'] ?? []) as $s) {
        if ((int)($s['id'] ?? 0) === $serviceId) { $service = $s; break; }
    }
    if (!$service || ($service['active'] ?? true) === false) {
        return ['ok' => false, 'error' => bb_msg('invalid_service', $lang)];
    }

    $stylist = trim((string)($input['stylist'] ?? ''));
    $stylistNames = array_map(fn($s) => (string)($s['name'] ?? ''), $cfg['stylists'] ?? []);
    if ($stylist === '' || !in_array($stylist, $stylistNames, true)) {
        return ['ok' => false, 'error' => bb_msg('invalid_stylist', $lang)];
    }

    $date = trim((string)($input['date'] ?? ''));
    $today = date('Y-m-d');
    $maxDate = date('Y-m-d', strtotime('+90 days'));
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        return ['ok' => false, 'error' => bb_msg('bad_date', $lang)];
    }
    if ($date < $today) return ['ok' => false, 'error' => bb_msg('bad_date', $lang)];
    if ($date > $maxDate) return ['ok' => false, 'error' => bb_msg('far_date', $lang)];

    $time = trim((string)($input['time'] ?? ''));
    if (!in_array($time, BB_SLOTS, true)) {
        return ['ok' => false, 'error' => bb_msg('bad_time', $lang)];
    }

    $name = trim((string)($input['name'] ?? ''));
    $name = preg_replace('/\s+/u', ' ', $name) ?? '';
    if (mb_strlen($name) < 2 || mb_strlen($name) > 60) {
        return ['ok' => false, 'error' => bb_msg('bad_name', $lang)];
    }

    $phone = bb_normalize_phone((string)($input['phone'] ?? ''));
    if ($phone === '') return ['ok' => false, 'error' => bb_msg('bad_phone', $lang)];

    $note = trim((string)($input['note'] ?? ''));
    $note = mb_substr($note, 0, 300);

    // Davamiyyət: usta həmin gün işdədir?
    $att = bb_attendance();
    if (bb_attendance_state($att, $date, $stylist) === 'off') {
        return ['ok' => false, 'error' => bb_msg('stylist_off', $lang)];
    }

    // Eyni usta + gün + saat artıq tutulub?
    $store = bb_bookings();
    foreach ($store['items'] as $b) {
        if (in_array(($b['status'] ?? ''), ['cancelled', 'no_show'], true)) continue;
        if (($b['date'] ?? '') === $date && ($b['time'] ?? '') === $time && ($b['stylist'] ?? '') === $stylist) {
            return ['ok' => false, 'error' => bb_msg('slot_taken', $lang)];
        }
    }

    $price   = (int)($service['price'] ?? 0);
    $listPrice = $price;
    // Aktiv təklif varsa, həmin xidmət üçün təklif qiyməti tətbiq olunur.
    $offerCfg = is_array($cfg['_offer'] ?? null) ? $cfg['_offer'] : null;
    if ($offerCfg && !empty($offerCfg['active'])
        && (int)($offerCfg['service_id'] ?? 0) === $serviceId) {
        $offerPrice = (int)($offerCfg['price'] ?? 0);
        if ($offerPrice > 0 && $offerPrice < $listPrice) $price = $offerPrice;
    }
    $deposit = bb_deposit($price, $settings);
    $n       = max(1, (int)$store['next']);
    $code    = 'SB-' . str_pad((string)$n, 4, '0', STR_PAD_LEFT);

    // Müştəri qeydiyyatı (telefon açarı ilə)
    $custStore = bb_customers();
    $prev = $custStore['customers'][$phone] ?? null;
    $visitNo = 1;
    if (is_array($prev)) {
        $visitNo = (int)($prev['visits'] ?? 0) + 1;
        $prev['name'] = $name;
        $prev['visits'] = $visitNo;
        $prev['last'] = $date;
        $custStore['customers'][$phone] = $prev;
    } else {
        $custStore['customers'][$phone] = [
            'name'    => $name,
            'phone'   => $phone,
            'created' => date('c'),
            'visits'  => 1,
            'spent'   => 0,
            'last'    => $date,
        ];
    }

    $booking = [
        'code'         => $code,
        'created'      => date('c'),
        'date'         => $date,
        'time'         => $time,
        'service_id'   => $serviceId,
        'service'      => (string)($service['title']['az'] ?? ('#' . $serviceId)),
        'price'        => $price,
        'list_price'   => $listPrice,
        'offer'        => $price < $listPrice,
        'deposit'      => $deposit,
        'stylist'      => $stylist,
        'customer'     => $name,
        'phone'        => $phone,
        'note'         => $note,
        'lang'         => $lang,
        'status'       => 'pending',
        'visit_no'     => $visitNo,
        'settled'      => false,
        'paid_at'      => '',
        'confirmed_at' => '',
        'updated'      => date('c'),
    ];

    $store['next'] = $n + 1;
    $store['items'][] = $booking;

    if (!bb_save_bookings($store)) {
        return ['ok' => false, 'error' => bb_msg('save_failed', $lang)];
    }
    bb_save_customers($custStore);

    return ['ok' => true, 'booking' => $booking, 'settings' => $settings];
}

/* ───────────────────────── Status dəyişmə ───────────────────────── */

/**
 * Menecer əməliyyatı: pending / confirmed / completed / no_show / cancelled.
 * @return array{ok:bool,error?:string,booking?:array}
 */
function bb_set_status(string $code, string $status): array {
    if (!in_array($status, BB_STATUSES, true)) return ['ok' => false, 'error' => 'Yanlış status.'];
    $store = bb_bookings();
    $i = bb_find_booking($store, $code);
    if ($i === null) return ['ok' => false, 'error' => 'Bron tapılmadı.'];

    $b = $store['items'][$i];
    $old = (string)($b['status'] ?? 'pending');

    if ($status === 'confirmed' && empty($b['paid_at'])) {
        $b['paid_at'] = date('c');
    }
    if ($status === 'confirmed' && empty($b['confirmed_at'])) {
        $b['confirmed_at'] = date('c');
    }

    // Müştərinin xərci yalnız «tamamlandı» statusunda hesablanır.
    $custStore = bb_customers();
    $phone = (string)($b['phone'] ?? '');
    $settled = !empty($b['settled']);
    if ($status === 'completed' && !$settled) {
        if ($phone !== '' && isset($custStore['customers'][$phone])) {
            $custStore['customers'][$phone]['spent'] = (int)($custStore['customers'][$phone]['spent'] ?? 0) + (int)($b['price'] ?? 0);
            bb_save_customers($custStore);
        }
        $b['settled'] = true;
    } elseif ($old === 'completed' && $status !== 'completed' && $settled) {
        if ($phone !== '' && isset($custStore['customers'][$phone])) {
            $custStore['customers'][$phone]['spent'] = max(0, (int)($custStore['customers'][$phone]['spent'] ?? 0) - (int)($b['price'] ?? 0));
            bb_save_customers($custStore);
        }
        $b['settled'] = false;
    }

    $b['status']  = $status;
    $b['updated'] = date('c');
    if ($status !== 'confirmed' && $status !== 'completed') {
        $b['paid_at'] = '';
    }
    $store['items'][$i] = $b;

    return bb_save_bookings($store)
        ? ['ok' => true, 'booking' => $b]
        : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

function bb_delete_booking(string $code): bool {
    $store = bb_bookings();
    $i = bb_find_booking($store, $code);
    if ($i === null) return false;
    array_splice($store['items'], $i, 1);
    return bb_save_bookings($store);
}

/* ───────────────────────── Gündəlik hesabat ───────────────────────── */

/**
 * @return array{
 *   date:string, total:int, by_status:array<string,int>, revenue:int, deposits:int,
 *   by_stylist:array<string,array{count:int,revenue:int,deposits:int,statuses:array<string,int>}>
 * }
 */
function bb_report(string $date, array $cfg): array {
    $store = bb_bookings();
    $byStatus = array_fill_keys(BB_STATUSES, 0);
    $revenue = 0;
    $deposits = 0;
    $total = 0;
    $byStylist = [];
    foreach (($cfg['stylists'] ?? []) as $st) {
        $byStylist[(string)$st['name']] = ['count' => 0, 'revenue' => 0, 'deposits' => 0, 'statuses' => []];
    }

    foreach ($store['items'] as $b) {
        if (($b['date'] ?? '') !== $date) continue;
        $total++;
        $st = (string)($b['status'] ?? 'pending');
        if (isset($byStatus[$st])) $byStatus[$st]++;
        $name = (string)($b['stylist'] ?? '');
        if (!isset($byStylist[$name])) $byStylist[$name] = ['count' => 0, 'revenue' => 0, 'deposits' => 0, 'statuses' => []];
        $byStylist[$name]['count']++;
        $byStylist[$name]['statuses'][$st] = ($byStylist[$name]['statuses'][$st] ?? 0) + 1;

        if (in_array($st, ['confirmed', 'completed'], true)) {
            $revenue += (int)($b['price'] ?? 0);
            $deposits += (int)($b['deposit'] ?? 0);
            $byStylist[$name]['revenue'] += (int)($b['price'] ?? 0);
            $byStylist[$name]['deposits'] += (int)($b['deposit'] ?? 0);
        }
    }

    return [
        'date'       => $date,
        'total'      => $total,
        'by_status'  => $byStatus,
        'revenue'    => $revenue,
        'deposits'   => $deposits,
        'by_stylist' => $byStylist,
    ];
}
