<?php
/**
 * Sky Beauty — işçi (usta) profilləri.
 * ------------------------------------------------------------------
 * Default məlumat `config/demo-beauty.php` → `stylists` bölməsindədir.
 * Paneldə edilən dəyişikliklər `data/beauty-staff.json` faylında saxlanılır:
 *   • vəzifə (4 dil), təcrübə, nişan
 *   • bio (4 dil)
 *   • «sahibi/sahibəsi» nişanı
 *   • aktivlik (saytda və bron seçimində görünmə)
 *   • foto (uploads/beauty/staff-*.jpg|png|webp)
 *
 * Ustanın adı açar olduğu üçün dəyişdirilmir (bron və davamiyyət tarixçəsi ona bağlıdır).
 */
declare(strict_types=1);

require_once __DIR__ . '/beauty-bookings.php';

const BS_LANGS = ['az', 'en', 'tr', 'ru'];

function bs_store(): array {
    $d = bb_read_json('beauty-staff.json', ['items' => []]);
    if (!is_array($d['items'])) $d['items'] = [];
    return $d;
}

function bs_save_store(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-staff.json', $d);
}

function bs_upload_dir(): string {
    return dirname(__DIR__) . '/uploads/beauty';
}

/** Saxlanmış `uploads/beauty/staff-*` yolunu demo/panel üçün işlək URL-ə çevirir. */
function bs_img_url(string $img): string {
    $img = trim($img);
    if ($img === '') return '';
    if (preg_match('#^https?://#i', $img)) return $img;
    if (str_starts_with($img, 'uploads/')) return '../../' . $img;
    return $img;
}

/**
 * Effektiv usta siyahısı: config defaultları + panel dəyişiklikləri.
 *
 * @param array $cfg         config/demo-beauty.php
 * @param bool  $onlyActive  yalnız aktiv ustalar (sayt/bron üçün)
 * @return array<int,array>
 */
function bs_list(array $cfg, bool $onlyActive = false): array {
    $over = bs_store()['items'];
    $out = [];
    foreach (($cfg['stylists'] ?? []) as $st) {
        $name = (string)($st['name'] ?? '');
        if ($name === '') continue;
        $ov = is_array($over[$name] ?? null) ? $over[$name] : [];

        $role = $st['role'] ?? [];
        if (!empty($ov['role']) && is_array($ov['role'])) {
            foreach (BS_LANGS as $l) {
                if (!empty($ov['role'][$l])) $role[$l] = (string)$ov['role'][$l];
            }
        }

        $bio = $st['bio'] ?? [];
        if (!is_array($bio)) $bio = [];
        if (!empty($ov['bio']) && is_array($ov['bio'])) {
            foreach (BS_LANGS as $l) {
                if (!empty($ov['bio'][$l])) $bio[$l] = (string)$ov['bio'][$l];
            }
        }

        $img = (string)($ov['img'] ?? '');
        if ($img === '') $img = (string)($st['img'] ?? '');

        $one = [
            'name'   => $name,
            'role'   => $role,
            'bio'    => $bio,
            'exp'    => (string)($ov['exp'] ?? ($st['exp'] ?? '')),
            'badge'  => (string)($ov['badge'] ?? ($st['badge'] ?? '')),
            'img'    => bs_img_url($img),
            'avatar' => (string)($st['avatar'] ?? ''),
            'owner'  => (bool)($ov['owner'] ?? ($st['owner'] ?? false)),
            'active' => (bool)($ov['active'] ?? true),
        ];
        if ($onlyActive && !$one['active']) continue;
        $out[] = $one;
    }
    return $out;
}

/**
 * Panel formundan usta profilini yazır.
 *
 * @param array $post  name, active, owner, exp, badge, role[lang], bio[lang], remove_photo
 * @param array $file  $_FILES['photo'] (istəyə bağlı)
 * @return array{ok:bool,error?:string}
 */
function bs_save_profile(array $post, array $file, array $cfg): array {
    $name = (string)($post['name'] ?? '');
    $names = array_map(fn($s) => (string)($s['name'] ?? ''), $cfg['stylists'] ?? []);
    if ($name === '' || !in_array($name, $names, true)) {
        return ['ok' => false, 'error' => 'Usta tapılmadı.'];
    }

    $store = bs_store();
    $cur = is_array($store['items'][$name] ?? null) ? $store['items'][$name] : [];

    $exp = trim((string)($post['exp'] ?? ''));
    $exp = mb_substr($exp, 0, 10);
    $badge = trim((string)($post['badge'] ?? ''));
    $badge = mb_substr($badge, 0, 24);

    $role = [];
    $bio  = [];
    foreach (BS_LANGS as $l) {
        $r = trim((string)($post['role'][$l] ?? ''));
        if ($r !== '') $role[$l] = mb_substr($r, 0, 80);
        $b = trim((string)($post['bio'][$l] ?? ''));
        if ($b !== '') $bio[$l] = mb_substr($b, 0, 400);
    }

    $img = (string)($cur['img'] ?? '');

    if (!empty($post['remove_photo'])) {
        bs_delete_photo_file($img);
        $img = '';
    }

    if (is_array($file) && (int)($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
        $tmp = (string)($file['tmp_name'] ?? '');
        if ((int)($file['size'] ?? 0) > 3 * 1024 * 1024) {
            return ['ok' => false, 'error' => 'Foto 3 MB-dan böyükdür.'];
        }
        $info = @getimagesize($tmp);
        $mime = is_array($info) ? (string)($info['mime'] ?? '') : '';
        $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? '';
        if ($ext === '') {
            return ['ok' => false, 'error' => 'Foto yalnız JPG, PNG və ya WEBP ola bilər.'];
        }
        $dir = bs_upload_dir();
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            return ['ok' => false, 'error' => 'uploads/beauty qovluğu yaradılmadı.'];
        }
        $newName = 'staff-' . bin2hex(random_bytes(5)) . '.' . $ext;
        if (!move_uploaded_file($tmp, $dir . '/' . $newName)) {
            return ['ok' => false, 'error' => 'Foto yüklənmədi.'];
        }
        bs_delete_photo_file($img);
        $img = 'uploads/beauty/' . $newName;
    }

    $store['items'][$name] = [
        'role'   => $role,
        'bio'    => $bio,
        'exp'    => $exp,
        'badge'  => $badge,
        'img'    => $img,
        'owner'  => !empty($post['owner']),
        'active' => !empty($post['active']),
    ];

    return bs_save_store($store) ? ['ok' => true] : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

/** Yalnız panelin yüklədiyi `uploads/beauty/staff-*` faylını silir. */
function bs_delete_photo_file(string $img): void {
    if (!str_starts_with($img, 'uploads/beauty/staff-')) return;
    $p = dirname(__DIR__) . '/' . $img;
    if (is_file($p)) @unlink($p);
}
