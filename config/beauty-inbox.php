<?php
/**
 * Sky Beauty — usta inbox-u (mesaj qutusu).
 * ------------------------------------------------------------------
 * Onlayn bron yaradıldıqda seçilmiş qeydiyyatlı ustanın inboxuna
 * avtomatik mesaj düşür. Mesajlar `data/beauty-inbox.json` faylında
 * saxlanılır; panel üzərindən oxundu/cavablandı/status dəyişdirildi.
 *
 * Bu fayl yalnız daxili istifadə üçündür — ictimai WhatsApp ünsiyyəti
 * yoxdur. WhatsApp bölməsi panelin işçi (qəbul/admin/sahib) hissəsindədir.
 */
declare(strict_types=1);

require_once __DIR__ . '/beauty-bookings.php';

const BI_STATUSES = ['new', 'read', 'replied'];

function bi_store(): array {
    $d = bb_read_json('beauty-inbox.json', ['next' => 1, 'items' => []]);
    if (!is_array($d['items'] ?? null)) $d['items'] = [];
    if (empty($d['next']) || !is_numeric($d['next'])) $d['next'] = 1;
    return $d;
}

function bi_save_store(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-inbox.json', $d);
}

/**
 * Yeni mesaj əlavə edir.
 *
 * @return array{ok:bool,id?:string,error?:string}
 */
function bi_add(array $msg): array {
    $d = bi_store();
    $n = max(1, (int)$d['next']);
    $id = 'BM-' . str_pad((string)$n, 4, '0', STR_PAD_LEFT);

    $d['items'][] = [
        'id'           => $id,
        'created'      => date('c'),
        'master'       => trim((string)($msg['master'] ?? '')),
        'booking_code' => trim((string)($msg['booking_code'] ?? '')),
        'customer'     => trim((string)($msg['customer'] ?? '')),
        'phone'        => trim((string)($msg['phone'] ?? '')),
        'service'      => trim((string)($msg['service'] ?? '')),
        'date'         => trim((string)($msg['date'] ?? '')),
        'time'         => trim((string)($msg['time'] ?? '')),
        'note'         => trim((string)($msg['note'] ?? '')),
        'price'        => (int)($msg['price'] ?? 0),
        'deposit'      => (int)($msg['deposit'] ?? 0),
        'status'       => 'new',
        'reply'        => '',
        'replied_at'   => '',
    ];
    $d['next'] = $n + 1;

    if (!bi_save_store($d)) {
        return ['ok' => false, 'error' => 'Mesaj yazılmadı.'];
    }
    return ['ok' => true, 'id' => $id];
}

/** Mesajları ən yenisi əvvələ olmaqla qaytarır. */
function bi_list(?string $master = null): array {
    $items = array_values(bi_store()['items']);
    if ($master !== null && $master !== '') {
        $items = array_values(array_filter($items, fn($m) => ($m['master'] ?? '') === $master));
    }
    usort($items, function ($a, $b) {
        $ka = (string)($a['created'] ?? '') . ' ' . (string)($a['id'] ?? '');
        $kb = (string)($b['created'] ?? '') . ' ' . (string)($b['id'] ?? '');
        return strcmp($kb, $ka);
    });
    return $items;
}

function bi_find(string $id): ?array {
    foreach (bi_store()['items'] as $m) {
        if (($m['id'] ?? '') === $id) return $m;
    }
    return null;
}

function bi_counts(?string $master = null): array {
    $c = ['all' => 0, 'new' => 0, 'read' => 0, 'replied' => 0];
    foreach (bi_list($master) as $m) {
        $c['all']++;
        $st = (string)($m['status'] ?? 'new');
        if (isset($c[$st])) $c[$st]++;
    }
    return $c;
}

function bi_set_status(string $id, string $status): bool {
    if (!in_array($status, BI_STATUSES, true)) return false;
    $d = bi_store();
    $found = false;
    foreach ($d['items'] as $i => $m) {
        if (($m['id'] ?? '') === $id) {
            $d['items'][$i]['status'] = $status;
            $found = true;
            break;
        }
    }
    return $found && bi_save_store($d);
}

function bi_reply(string $id, string $text): bool {
    $text = trim($text);
    if ($text === '') return false;
    $d = bi_store();
    $found = false;
    foreach ($d['items'] as $i => $m) {
        if (($m['id'] ?? '') === $id) {
            $d['items'][$i]['reply'] = mb_substr($text, 0, 500);
            $d['items'][$i]['status'] = 'replied';
            $d['items'][$i]['replied_at'] = date('c');
            $found = true;
            break;
        }
    }
    return $found && bi_save_store($d);
}

function bi_delete(string $id): bool {
    $d = bi_store();
    $before = count($d['items']);
    $d['items'] = array_values(array_filter($d['items'], fn($m) => ($m['id'] ?? '') !== $id));
    if (count($d['items']) === $before) return false;
    return bi_save_store($d);
}

/** Qeydiyyatlı (panel default + əlavə edilmiş) ustaların adları. */
function bi_master_names(array $cfg): array {
    $names = [];
    foreach (($cfg['stylists'] ?? []) as $s) {
        $name = trim((string)($s['name'] ?? ''));
        if ($name !== '') $names[$name] = $name;
    }
    return array_values($names);
}
