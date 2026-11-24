<?php
/**
 * Sky Beauty — müştəri rəyləri və ulduz reytinqi.
 * ------------------------------------------------------------------
 * Data: `data/beauty-reviews.json` (veb-dən əlçatmaz).
 *
 * Qaydalar:
 *   • Rəy yalnız «tamamlandı» statuslu bron kodu ilə yazılır (real ziyarət).
 *   • Hər bron üçün bir rəy — təkrar göndəriş rədd olunur.
 *   • Yeni rəy `pending` gəlir; saytda yalnız menecer təsdiqlədikdən (`approved`) sonra görünür.
 *   • Menecer cavab yaza bilər (`reply`), rəyi gizlədə (`hidden`) və ya silə bilər.
 *   • Ziyarətçilər dərc olunmuş rəyə qısa fikir (comment) yazır; o da moderasiyadan keçir.
 *   • Salon reytinqi yalnız `approved` rəylərdən hesablanır.
 */
declare(strict_types=1);

require_once __DIR__ . '/beauty-bookings.php';

const BR_STATUSES = ['pending', 'approved', 'hidden'];
const BR_MIN_TEXT = 10;
const BR_MAX_TEXT = 600;
const BR_MIN_COMMENT = 10;
const BR_MAX_COMMENT = 400;

/* ───────────────────────── Anbar ───────────────────────── */

function br_store(): array {
    $d = bb_read_json('beauty-reviews.json', ['next' => 1, 'items' => []]);
    if (!is_array($d['items'])) $d['items'] = [];
    $d['next'] = max(1, (int)$d['next']);
    $d['comments_next'] = max(1, (int)($d['comments_next'] ?? 1));
    return $d;
}

function br_save_store(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-reviews.json', $d);
}

/** @return array<int,array>  Ən yenilər əvvəldə. */
function br_list(?string $status = null): array {
    $items = br_store()['items'];
    if ($status !== null && in_array($status, BR_STATUSES, true)) {
        $items = array_values(array_filter($items, fn($r) => ($r['status'] ?? '') === $status));
    }
    usort($items, fn($a, $b) => strcmp((string)($b['created'] ?? ''), (string)($a['created'] ?? '')));
    return $items;
}

function br_find(array $store, string $id): ?int {
    foreach ($store['items'] as $i => $r) {
        if ((string)($r['id'] ?? '') === $id) return $i;
    }
    return null;
}

function br_by_code(array $store, string $code): ?array {
    foreach ($store['items'] as $r) {
        if ((string)($r['code'] ?? '') === $code) return $r;
    }
    return null;
}

/* ───────────────────────── Reytinq ───────────────────────── */

/** @return array{avg:float,count:int,dist:array<int,int>} */
function br_summary(): array {
    $dist = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    $sum = 0;
    $count = 0;
    foreach (br_store()['items'] as $r) {
        if (($r['status'] ?? '') !== 'approved') continue;
        $v = (int)($r['rating'] ?? 0);
        if ($v < 1 || $v > 5) continue;
        $dist[$v]++;
        $sum += $v;
        $count++;
    }
    return [
        'avg'   => $count > 0 ? round($sum / $count, 1) : 0.0,
        'count' => $count,
        'dist'  => $dist,
    ];
}

/** Saytda göstərilən təsdiqlənmiş rəylər (ən yenilər əvvəldə). */
function br_public(int $limit = 6): array {
    $items = array_values(array_filter(br_store()['items'], fn($r) => ($r['status'] ?? '') === 'approved'));
    usort($items, fn($a, $b) => strcmp((string)($b['approved_at'] ?? $b['created'] ?? ''), (string)($a['approved_at'] ?? $a['created'] ?? '')));
    return array_slice($items, 0, max(1, $limit));
}

/* ───────────────────────── Rəyə fikirlər (reply) ───────────────────────── */

/** Dərc olunmuş rəyin təsdiqlənmiş ziyarətçi fikirləri (köhnədən yeniye). */
function br_public_comments(array $rv): array {
    $cs = $rv['comments'] ?? [];
    if (!is_array($cs)) return [];
    $cs = array_values(array_filter($cs, fn($c) => is_array($c) && ($c['status'] ?? '') === 'approved'));
    usort($cs, fn($a, $b) => strcmp((string)($a['created'] ?? ''), (string)($b['created'] ?? '')));
    return $cs;
}

/** Panel üçün: bütün gözləyən fikirlər rəy məlumatı ilə birlikdə. */
function br_pending_comments(): array {
    $out = [];
    foreach (br_store()['items'] as $rv) {
        foreach ((array)($rv['comments'] ?? []) as $c) {
            if (!is_array($c) || ($c['status'] ?? '') !== 'pending') continue;
            $out[] = [
                'review_id'   => (string)($rv['id'] ?? ''),
                'review_name' => (string)($rv['name'] ?? ''),
                'id'          => (string)($c['id'] ?? ''),
                'text'        => (string)($c['text'] ?? ''),
                'created'     => (string)($c['created'] ?? ''),
            ];
        }
    }
    usort($out, fn($a, $b) => strcmp((string)$b['created'], (string)$a['created']));
    return $out;
}

/**
 * @return array{ok:bool,error?:string,comment?:array}
 */
function br_add_comment(string $reviewId, string $text, string $lang): array {
    if (!in_array($lang, ['az', 'en', 'tr', 'ru'], true)) $lang = 'az';
    $store = br_store();
    $i = br_find($store, $reviewId);
    if ($i === null || ($store['items'][$i]['status'] ?? '') !== 'approved') {
        return ['ok' => false, 'error' => br_msg('comment_no_review', $lang)];
    }

    $text = trim($text);
    $text = preg_replace('/\s+/u', ' ', $text) ?? '';
    if (mb_strlen($text) < BR_MIN_COMMENT) {
        return ['ok' => false, 'error' => br_msg('comment_bad_text', $lang)];
    }
    $text = mb_substr($text, 0, BR_MAX_COMMENT);

    $n  = max(1, (int)($store['comments_next'] ?? 1));
    $cm = [
        'id'          => 'CM-' . str_pad((string)$n, 4, '0', STR_PAD_LEFT),
        'text'        => $text,
        'lang'        => $lang,
        'status'      => 'pending',
        'created'     => date('c'),
        'approved_at' => '',
    ];
    if (!is_array($store['items'][$i]['comments'] ?? null)) {
        $store['items'][$i]['comments'] = [];
    }
    $store['items'][$i]['comments'][] = $cm;
    $store['comments_next'] = $n + 1;

    return br_save_store($store)
        ? ['ok' => true, 'comment' => $cm]
        : ['ok' => false, 'error' => br_msg('save_failed', $lang)];
}

function br_set_comment_status(string $reviewId, string $commentId, string $status): array {
    if (!in_array($status, ['approved', 'hidden'], true)) {
        return ['ok' => false, 'error' => 'Yanlış status.'];
    }
    $store = br_store();
    $i = br_find($store, $reviewId);
    if ($i === null || !is_array($store['items'][$i]['comments'] ?? null)) {
        return ['ok' => false, 'error' => 'Rəy tapılmadı.'];
    }
    foreach ($store['items'][$i]['comments'] as $j => $c) {
        if ((string)($c['id'] ?? '') !== $commentId) continue;
        $store['items'][$i]['comments'][$j]['status'] = $status;
        if ($status === 'approved' && empty($store['items'][$i]['comments'][$j]['approved_at'])) {
            $store['items'][$i]['comments'][$j]['approved_at'] = date('c');
        }
        $store['items'][$i]['updated'] = date('c');
        return br_save_store($store)
            ? ['ok' => true, 'comment' => $store['items'][$i]['comments'][$j]]
            : ['ok' => false, 'error' => 'Yazma alınmadı.'];
    }
    return ['ok' => false, 'error' => 'Fikir tapılmadı.'];
}

/* ───────────────────────── Lokallaşdırılmış mesajlar ───────────────────────── */

function br_msg(string $key, string $lang): string {
    $m = [
        'az' => [
            'no_booking'    => 'Bu kodla bron tapılmadı. Bron kodunu yoxlayın.',
            'not_completed' => 'Rəy yalnız tamamlanmış ziyarətdən sonra yazıla bilər.',
            'already'       => 'Bu bron üçün artıq rəy göndərilmişdir.',
            'bad_rating'    => 'Ulduz sayı 1–5 arasında olmalıdır.',
            'bad_text'      => 'Rəy mətni ən azı 10 simvol olmalıdır.',
            'rate'          => 'Çox sayda cəhd. Bir neçə dəqiqə sonra yenidən yoxlayın.',
            'save_failed'   => 'Rəy saxlanmadı. Yenidən cəhd edin.',
            'comment_no_review' => 'Bu rəy tapılmadı və ya hələ dərc olunmayıb.',
            'comment_bad_text'  => 'Fikir ən azı 10 simvol olmalıdır.',
        ],
        'en' => [
            'no_booking'    => 'No booking found with this code. Please check the code.',
            'not_completed' => 'A review can be written only after a completed visit.',
            'already'       => 'A review has already been submitted for this booking.',
            'bad_rating'    => 'The rating must be between 1 and 5 stars.',
            'bad_text'      => 'The review must be at least 10 characters long.',
            'rate'          => 'Too many attempts. Please try again in a few minutes.',
            'save_failed'   => 'The review could not be saved. Please try again.',
            'comment_no_review' => 'This review was not found or is not published yet.',
            'comment_bad_text'  => 'The comment must be at least 10 characters long.',
        ],
        'tr' => [
            'no_booking'    => 'Bu kodla randevu bulunamadı. Kodu kontrol edin.',
            'not_completed' => 'Yorum yalnızca tamamlanmış bir ziyaretten sonra yazılabilir.',
            'already'       => 'Bu randevu için zaten yorum gönderilmiş.',
            'bad_rating'    => 'Yıldız sayısı 1–5 arasında olmalıdır.',
            'bad_text'      => 'Yorum en az 10 karakter olmalıdır.',
            'rate'          => 'Çok fazla deneme. Birkaç dakika sonra tekrar deneyin.',
            'save_failed'   => 'Yorum kaydedilemedi. Lütfen tekrar deneyin.',
            'comment_no_review' => 'Bu yorum bulunamadı veya henüz yayında değil.',
            'comment_bad_text'  => 'Görüş en az 10 karakter olmalıdır.',
        ],
        'ru' => [
            'no_booking'    => 'Запись с таким кодом не найдена. Проверьте код.',
            'not_completed' => 'Отзыв можно оставить только после завершённого визита.',
            'already'       => 'По этой записи отзыв уже отправлен.',
            'bad_rating'    => 'Оценка должна быть от 1 до 5 звёзд.',
            'bad_text'      => 'Текст отзыва должен содержать минимум 10 символов.',
            'rate'          => 'Слишком много попыток. Попробуйте снова через несколько минут.',
            'save_failed'   => 'Не удалось сохранить отзыв. Попробуйте ещё раз.',
            'comment_no_review' => 'Отзыв не найден или ещё не опубликован.',
            'comment_bad_text'  => 'Комментарий должен содержать минимум 10 символов.',
        ],
    ];
    return $m[$lang][$key] ?? $m['az'][$key] ?? $key;
}

/* ───────────────────────── Rəy yaratma ───────────────────────── */

/**
 * @param array $in  code, rating, text, lang
 * @return array{ok:bool,error?:string,review?:array}
 */
function br_add(array $in): array {
    $lang = (string)($in['lang'] ?? 'az');
    if (!in_array($lang, ['az', 'en', 'tr', 'ru'], true)) $lang = 'az';

    $code = strtoupper(trim((string)($in['code'] ?? '')));
    if (!preg_match('/^SB-\d{4}$/', $code)) {
        return ['ok' => false, 'error' => br_msg('no_booking', $lang)];
    }

    $bookStore = bb_bookings();
    $bi = bb_find_booking($bookStore, $code);
    if ($bi === null) return ['ok' => false, 'error' => br_msg('no_booking', $lang)];
    $b = $bookStore['items'][$bi];
    if (($b['status'] ?? '') !== 'completed') {
        return ['ok' => false, 'error' => br_msg('not_completed', $lang)];
    }

    $store = br_store();
    if (br_by_code($store, $code) !== null) {
        return ['ok' => false, 'error' => br_msg('already', $lang)];
    }

    $rating = (int)($in['rating'] ?? 0);
    if ($rating < 1 || $rating > 5) {
        return ['ok' => false, 'error' => br_msg('bad_rating', $lang)];
    }

    $text = trim((string)($in['text'] ?? ''));
    $text = preg_replace('/\s+/u', ' ', $text) ?? '';
    if (mb_strlen($text) < BR_MIN_TEXT) {
        return ['ok' => false, 'error' => br_msg('bad_text', $lang)];
    }
    $text = mb_substr($text, 0, BR_MAX_TEXT);

    $n  = max(1, (int)$store['next']);
    $id = 'RV-' . str_pad((string)$n, 4, '0', STR_PAD_LEFT);

    $review = [
        'id'          => $id,
        'code'        => $code,
        'name'        => (string)($b['customer'] ?? ''),
        'phone'       => (string)($b['phone'] ?? ''),
        'service'     => (string)($b['service'] ?? ''),
        'stylist'     => (string)($b['stylist'] ?? ''),
        'date'        => (string)($b['date'] ?? ''),
        'rating'      => $rating,
        'text'        => $text,
        'lang'        => $lang,
        'status'      => 'pending',
        'reply'       => '',
        'reply_at'    => '',
        'created'     => date('c'),
        'approved_at' => '',
        'updated'     => date('c'),
    ];

    $store['next'] = $n + 1;
    $store['items'][] = $review;

    return br_save_store($store)
        ? ['ok' => true, 'review' => $review]
        : ['ok' => false, 'error' => br_msg('save_failed', $lang)];
}

/* ───────────────────────── Menecer əməliyyatları ───────────────────────── */

function br_set_status(string $id, string $status): array {
    if (!in_array($status, BR_STATUSES, true)) return ['ok' => false, 'error' => 'Yanlış status.'];
    $store = br_store();
    $i = br_find($store, $id);
    if ($i === null) return ['ok' => false, 'error' => 'Rəy tapılmadı.'];

    $store['items'][$i]['status']  = $status;
    $store['items'][$i]['updated'] = date('c');
    if ($status === 'approved' && empty($store['items'][$i]['approved_at'])) {
        $store['items'][$i]['approved_at'] = date('c');
    }
    return br_save_store($store)
        ? ['ok' => true, 'review' => $store['items'][$i]]
        : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

function br_set_reply(string $id, string $text): array {
    $store = br_store();
    $i = br_find($store, $id);
    if ($i === null) return ['ok' => false, 'error' => 'Rəy tapılmadı.'];
    $text = trim($text);
    $text = preg_replace('/\s+/u', ' ', $text) ?? '';
    $store['items'][$i]['reply']    = mb_substr($text, 0, 400);
    $store['items'][$i]['reply_at'] = $text !== '' ? date('c') : '';
    $store['items'][$i]['updated']  = date('c');
    return br_save_store($store)
        ? ['ok' => true, 'review' => $store['items'][$i]]
        : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

function br_delete(string $id): bool {
    $store = br_store();
    $i = br_find($store, $id);
    if ($i === null) return false;
    array_splice($store['items'], $i, 1);
    return br_save_store($store);
}
