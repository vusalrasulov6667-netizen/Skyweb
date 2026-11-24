<?php
/**
 * Sky Beauty — Virtual Stil Studiyası: rəng palitrası + panel kataloqu.
 * ------------------------------------------------------------------
 * Default stillər `config/beauty-styles.php` faylındadır.
 * Paneldə (Ustalar → Stil kataloqu) edilən dəyişikliklər `data/beauty-studio.json`:
 *   items[<id>] = {
 *      active: bool, deleted?: bool, custom?: bool, cat?: string,
 *      name?: {az,en,tr,ru}, desc?: {...}, colors?: string[], img?: string,
 *      service_id?: int, mode?: string
 *   }
 *
 * Qayda: default stil silinəndə `deleted: true` yazılır (config toxunulmur).
 */
declare(strict_types=1);

require_once __DIR__ . '/beauty-bookings.php';

const BSX_LANGS = ['az', 'en', 'tr', 'ru'];

/** Rəng palitrası — 4 dildə ad + hex (+ saç üçün HSL). Açarlar qrup üzrə unikaldır. */
function bsx_palette(): array {
    return [
        /* saç — HSL dəyərləri real boyama üçün istifadə olunur */
        'hair_gold'          => ['group' => 'hair', 'hex' => '#C79A5B', 'h' => 38,  's' => 0.55, 'l' => 0.55, 'name' => ['az' => 'Qızılı', 'en' => 'Golden', 'tr' => 'Altın', 'ru' => 'Золотистый']],
        'hair_ash'           => ['group' => 'hair', 'hex' => '#C6C0B4', 'h' => 40,  's' => 0.12, 'l' => 0.52, 'name' => ['az' => 'Kül tonu', 'en' => 'Ash', 'tr' => 'Küllü', 'ru' => 'Пепельный']],
        'hair_platinum'      => ['group' => 'hair', 'hex' => '#E4DED3', 'h' => 42,  's' => 0.10, 'l' => 0.74, 'name' => ['az' => 'Platin', 'en' => 'Platinum', 'tr' => 'Platin', 'ru' => 'Платина']],
        'hair_caramel'       => ['group' => 'hair', 'hex' => '#B07A44', 'h' => 30,  's' => 0.45, 'l' => 0.45, 'name' => ['az' => 'Karamel', 'en' => 'Caramel', 'tr' => 'Karamel', 'ru' => 'Карамель']],
        'hair_copper'        => ['group' => 'hair', 'hex' => '#B4552D', 'h' => 18,  's' => 0.62, 'l' => 0.42, 'name' => ['az' => 'Mis', 'en' => 'Copper', 'tr' => 'Bakır', 'ru' => 'Медный']],
        'hair_chocolate'     => ['group' => 'hair', 'hex' => '#4B2E20', 'h' => 22,  's' => 0.42, 'l' => 0.20, 'name' => ['az' => 'Şokolad', 'en' => 'Chocolate', 'tr' => 'Çikolata', 'ru' => 'Шоколад']],
        'hair_black'         => ['group' => 'hair', 'hex' => '#221D1A', 'h' => 20,  's' => 0.08, 'l' => 0.10, 'name' => ['az' => 'Qara', 'en' => 'Black', 'tr' => 'Siyah', 'ru' => 'Чёрный']],
        'hair_burgundy'      => ['group' => 'hair', 'hex' => '#5E1F2E', 'h' => 345, 's' => 0.50, 'l' => 0.24, 'name' => ['az' => 'Bordo', 'en' => 'Burgundy', 'tr' => 'Bordo', 'ru' => 'Бордо']],
        'hair_red'           => ['group' => 'hair', 'hex' => '#8E2B22', 'h' => 8,   's' => 0.60, 'l' => 0.31, 'name' => ['az' => 'Qırmızı', 'en' => 'Red', 'tr' => 'Kızıl', 'ru' => 'Красный']],
        'hair_honey'         => ['group' => 'hair', 'hex' => '#D9A441', 'h' => 36,  's' => 0.62, 'l' => 0.55, 'name' => ['az' => 'Bal rəngi', 'en' => 'Honey', 'tr' => 'Bal', 'ru' => 'Медовый']],
        'hair_chestnut'      => ['group' => 'hair', 'hex' => '#6E3B24', 'h' => 20,  's' => 0.50, 'l' => 0.28, 'name' => ['az' => 'Şabalıd', 'en' => 'Chestnut', 'tr' => 'Kestane', 'ru' => 'Каштановый']],
        'hair_mahogany'      => ['group' => 'hair', 'hex' => '#5A2418', 'h' => 12,  's' => 0.60, 'l' => 0.22, 'name' => ['az' => 'Qırmızı-ağac', 'en' => 'Mahogany', 'tr' => 'Maun', 'ru' => 'Красное дерево']],
        'hair_sand'          => ['group' => 'hair', 'hex' => '#C9A87C', 'h' => 35,  's' => 0.35, 'l' => 0.63, 'name' => ['az' => 'Qum rəngi', 'en' => 'Sand', 'tr' => 'Kum', 'ru' => 'Песочный']],
        'hair_smoky_ash'     => ['group' => 'hair', 'hex' => '#8E8B86', 'h' => 40,  's' => 0.08, 'l' => 0.50, 'name' => ['az' => 'Tüstülü kül', 'en' => 'Smoky ash', 'tr' => 'Dumanlı kül', 'ru' => 'Дымчатый пепельный']],
        'hair_lilac'         => ['group' => 'hair', 'hex' => '#A98BB5', 'h' => 285, 's' => 0.22, 'l' => 0.63, 'name' => ['az' => 'Lafanda', 'en' => 'Lilac', 'tr' => 'Lila', 'ru' => 'Лиловый']],
        'hair_pastel_pink'   => ['group' => 'hair', 'hex' => '#E0A7B6', 'h' => 345, 's' => 0.45, 'l' => 0.77, 'name' => ['az' => 'Pastel çəhrayı', 'en' => 'Pastel pink', 'tr' => 'Pastel pembe', 'ru' => 'Пастельно-розовый']],
        'hair_mint'          => ['group' => 'hair', 'hex' => '#8FC7B4', 'h' => 160, 's' => 0.25, 'l' => 0.66, 'name' => ['az' => 'Nanə', 'en' => 'Mint', 'tr' => 'Nane', 'ru' => 'Мятный']],
        'hair_ocean_blue'    => ['group' => 'hair', 'hex' => '#4E7FB8', 'h' => 210, 's' => 0.42, 'l' => 0.51, 'name' => ['az' => 'Okean mavisi', 'en' => 'Ocean blue', 'tr' => 'Okyanus mavisi', 'ru' => 'Океанский синий']],

        /* dodaq */
        'lip_nude'          => ['group' => 'lips', 'hex' => '#C98F82', 'name' => ['az' => 'Nude', 'en' => 'Nude', 'tr' => 'Nude', 'ru' => 'Нюд']],
        'lip_rose'          => ['group' => 'lips', 'hex' => '#C4586B', 'name' => ['az' => 'Çəhrayı', 'en' => 'Rose', 'tr' => 'Gül', 'ru' => 'Розовый']],
        'lip_coral'         => ['group' => 'lips', 'hex' => '#D9664F', 'name' => ['az' => 'Mərcan', 'en' => 'Coral', 'tr' => 'Mercan', 'ru' => 'Коралловый']],
        'lip_berry'         => ['group' => 'lips', 'hex' => '#8E2E4E', 'name' => ['az' => 'Giləmeyvə', 'en' => 'Berry', 'tr' => 'Böğürtlen', 'ru' => 'Ягодный']],
        'lip_plum'          => ['group' => 'lips', 'hex' => '#6E2547', 'name' => ['az' => 'Gavalı', 'en' => 'Plum', 'tr' => 'Erik', 'ru' => 'Сливовый']],
        'lip_red'           => ['group' => 'lips', 'hex' => '#C8323C', 'name' => ['az' => 'Qırmızı', 'en' => 'Red', 'tr' => 'Kırmızı', 'ru' => 'Красный']],
        'lip_pink'          => ['group' => 'lips', 'hex' => '#E08CA4', 'name' => ['az' => 'Açıq çəhrayı', 'en' => 'Light pink', 'tr' => 'Açık pembe', 'ru' => 'Светло-розовый']],
        'lip_peach'         => ['group' => 'lips', 'hex' => '#E79B7A', 'name' => ['az' => 'Şaftalı', 'en' => 'Peach', 'tr' => 'Şeftali', 'ru' => 'Персиковый']],
        'lip_mauve'         => ['group' => 'lips', 'hex' => '#A96B76', 'name' => ['az' => 'Tünd çəhrayı', 'en' => 'Mauve', 'tr' => 'Eflatun pembe', 'ru' => 'Мауве']],
        'lip_brown'         => ['group' => 'lips', 'hex' => '#8C5A4A', 'name' => ['az' => 'Qəhvəyi', 'en' => 'Brown', 'tr' => 'Kahve', 'ru' => 'Коричневый']],
        'lip_fuchsia'       => ['group' => 'lips', 'hex' => '#C8408E', 'name' => ['az' => 'Fuşya', 'en' => 'Fuchsia', 'tr' => 'Fuşya', 'ru' => 'Фуксия']],
        'lip_wine'          => ['group' => 'lips', 'hex' => '#7C2538', 'name' => ['az' => 'Şərab', 'en' => 'Wine', 'tr' => 'Şarap', 'ru' => 'Винный']],
        'lip_orange'        => ['group' => 'lips', 'hex' => '#E2703A', 'name' => ['az' => 'Narıncı', 'en' => 'Orange', 'tr' => 'Turuncu', 'ru' => 'Оранжевый']],

        /* qaş */
        'brow_soft_brown'   => ['group' => 'brow', 'hex' => '#6B4A34', 'name' => ['az' => 'Yumşaq qəhvəyi', 'en' => 'Soft brown', 'tr' => 'Yumuşak kahve', 'ru' => 'Мягкий коричневый']],
        'brow_black_brown'  => ['group' => 'brow', 'hex' => '#2B2320', 'name' => ['az' => 'Qara-qəhvəyi', 'en' => 'Black-brown', 'tr' => 'Siyah-kahve', 'ru' => 'Чёрно-коричневый']],
        'brow_blonde'       => ['group' => 'brow', 'hex' => '#B79A72', 'name' => ['az' => 'Sarışın', 'en' => 'Blonde', 'tr' => 'Sarı', 'ru' => 'Светлый блонд']],
        'brow_light_brown'  => ['group' => 'brow', 'hex' => '#A57A54', 'name' => ['az' => 'Açıq qəhvəyi', 'en' => 'Light brown', 'tr' => 'Açık kahve', 'ru' => 'Светло-коричневый']],
        'brow_medium_brown' => ['group' => 'brow', 'hex' => '#7A543A', 'name' => ['az' => 'Orta qəhvəyi', 'en' => 'Medium brown', 'tr' => 'Orta kahve', 'ru' => 'Средне-коричневый']],
        'brow_dark_brown'   => ['group' => 'brow', 'hex' => '#4A3326', 'name' => ['az' => 'Tünd qəhvəyi', 'en' => 'Dark brown', 'tr' => 'Koyu kahve', 'ru' => 'Тёмно-коричневый']],
        'brow_auburn'       => ['group' => 'brow', 'hex' => '#7A3B28', 'name' => ['az' => 'Qırmızı-qəhvəyi', 'en' => 'Auburn', 'tr' => 'Kızıl kahve', 'ru' => 'Рыже-коричневый']],
        'brow_gray'         => ['group' => 'brow', 'hex' => '#7C7C7C', 'name' => ['az' => 'Boz', 'en' => 'Gray', 'tr' => 'Gri', 'ru' => 'Серый']],
        'brow_black'        => ['group' => 'brow', 'hex' => '#211C1A', 'name' => ['az' => 'Qara', 'en' => 'Black', 'tr' => 'Siyah', 'ru' => 'Чёрный']],
        'brow_taupe'        => ['group' => 'brow', 'hex' => '#8C7A6B', 'name' => ['az' => 'Boz-qəhvəyi', 'en' => 'Taupe', 'tr' => 'Gri-kahve', 'ru' => 'Таупе']],

        /* dırnaq — 24 ton (real gel-lak çalarları: yumşaq, dərin, təbii) */
        'nail_white'        => ['group' => 'nails', 'hex' => '#EDE7E0', 'name' => ['az' => 'Ağ', 'en' => 'White', 'tr' => 'Beyaz', 'ru' => 'Белый']],
        'nail_silver'       => ['group' => 'nails', 'hex' => '#C2C6CB', 'name' => ['az' => 'Gümüşü', 'en' => 'Silver', 'tr' => 'Gümüş', 'ru' => 'Серебро']],
        'nail_nude'         => ['group' => 'nails', 'hex' => '#D0A88F', 'name' => ['az' => 'Nude', 'en' => 'Nude', 'tr' => 'Nude', 'ru' => 'Нюд']],
        'nail_baby_pink'    => ['group' => 'nails', 'hex' => '#E7C0C5', 'name' => ['az' => 'Açıq çəhrayı', 'en' => 'Baby pink', 'tr' => 'Açık pembe', 'ru' => 'Нежно-розовый']],
        'nail_pink'         => ['group' => 'nails', 'hex' => '#D58AA0', 'name' => ['az' => 'Çəhrayı', 'en' => 'Pink', 'tr' => 'Pembe', 'ru' => 'Розовый']],
        'nail_red'          => ['group' => 'nails', 'hex' => '#A82739', 'name' => ['az' => 'Qırmızı', 'en' => 'Red', 'tr' => 'Kırmızı', 'ru' => 'Красный']],
        'nail_cherry'       => ['group' => 'nails', 'hex' => '#8C2133', 'name' => ['az' => 'Albalı', 'en' => 'Cherry', 'tr' => 'Kiraz', 'ru' => 'Вишнёвый']],
        'nail_burgundy'     => ['group' => 'nails', 'hex' => '#5E2134', 'name' => ['az' => 'Bordo', 'en' => 'Burgundy', 'tr' => 'Bordo', 'ru' => 'Бордо']],
        'nail_coral'        => ['group' => 'nails', 'hex' => '#D2796A', 'name' => ['az' => 'Mərcan', 'en' => 'Coral', 'tr' => 'Mercan', 'ru' => 'Коралловый']],
        'nail_peach'        => ['group' => 'nails', 'hex' => '#DEA28D', 'name' => ['az' => 'Şaftalı', 'en' => 'Peach', 'tr' => 'Şeftali', 'ru' => 'Персиковый']],
        'nail_plum'         => ['group' => 'nails', 'hex' => '#643751', 'name' => ['az' => 'Gavalı', 'en' => 'Plum', 'tr' => 'Erik', 'ru' => 'Сливовый']],
        'nail_purple'       => ['group' => 'nails', 'hex' => '#79538D', 'name' => ['az' => 'Bənövşəyi', 'en' => 'Purple', 'tr' => 'Mor', 'ru' => 'Фиолетовый']],
        'nail_blue'         => ['group' => 'nails', 'hex' => '#4B6A92', 'name' => ['az' => 'Mavi', 'en' => 'Blue', 'tr' => 'Mavi', 'ru' => 'Синий']],
        'nail_navy'         => ['group' => 'nails', 'hex' => '#26345A', 'name' => ['az' => 'Tünd mavi', 'en' => 'Navy', 'tr' => 'Lacivert', 'ru' => 'Тёмно-синий']],
        'nail_teal'         => ['group' => 'nails', 'hex' => '#3E7C78', 'name' => ['az' => 'Firuzəyi', 'en' => 'Teal', 'tr' => 'Turkuaz', 'ru' => 'Бирюзовый']],
        'nail_green'        => ['group' => 'nails', 'hex' => '#587E63', 'name' => ['az' => 'Yaşıl', 'en' => 'Green', 'tr' => 'Yeşil', 'ru' => 'Зелёный']],
        'nail_mint'         => ['group' => 'nails', 'hex' => '#A8CDB9', 'name' => ['az' => 'Nanə', 'en' => 'Mint', 'tr' => 'Nane', 'ru' => 'Мятный']],
        'nail_yellow'       => ['group' => 'nails', 'hex' => '#D8BD70', 'name' => ['az' => 'Sarı', 'en' => 'Yellow', 'tr' => 'Sarı', 'ru' => 'Жёлтый']],
        'nail_orange'       => ['group' => 'nails', 'hex' => '#CE7E4F', 'name' => ['az' => 'Narıncı', 'en' => 'Orange', 'tr' => 'Turuncu', 'ru' => 'Оранжевый']],
        'nail_black'        => ['group' => 'nails', 'hex' => '#252327', 'name' => ['az' => 'Qara', 'en' => 'Black', 'tr' => 'Siyah', 'ru' => 'Чёрный']],
        'nail_gray'         => ['group' => 'nails', 'hex' => '#8E9298', 'name' => ['az' => 'Boz', 'en' => 'Gray', 'tr' => 'Gri', 'ru' => 'Серый']],
        'nail_gold'         => ['group' => 'nails', 'hex' => '#B99A56', 'name' => ['az' => 'Qızıl', 'en' => 'Gold', 'tr' => 'Altın', 'ru' => 'Золотой']],
        'nail_rose_gold'    => ['group' => 'nails', 'hex' => '#BE8C82', 'name' => ['az' => 'Qızılgül qızılı', 'en' => 'Rose gold', 'tr' => 'Gül altını', 'ru' => 'Розовое золото']],
        'nail_glitter'      => ['group' => 'nails', 'hex' => '#B5A9C4', 'name' => ['az' => 'Parıldayan', 'en' => 'Glitter', 'tr' => 'Parıltılı', 'ru' => 'Блёстки']],
    ];
}

function bsx_palette_group(string $group): array {
    $out = [];
    foreach (bsx_palette() as $k => $c) {
        if (($c['group'] ?? '') === $group) $out[$k] = $c;
    }
    return $out;
}

/* ───────────────────────────── anbar ───────────────────────────── */

function bsx_store(): array {
    $d = bb_read_json('beauty-studio.json', ['items' => []]);
    if (!is_array($d['items'] ?? null)) $d['items'] = [];
    return $d;
}

function bsx_save_store(array $d): bool {
    $d['updated'] = date('c');
    return bb_write_json('beauty-studio.json', $d);
}

function bsx_upload_dir(): string {
    return dirname(__DIR__) . '/uploads/beauty';
}

/** `uploads/beauty/...` yolunu demo/panel üçün işlək URL-ə çevirir. */
function bsx_img_url(string $img): string {
    $img = trim($img);
    if ($img === '') return '';
    if (preg_match('#^https?://#i', $img)) return $img;
    if (str_starts_with($img, 'uploads/')) return '../../' . $img;
    return $img;
}

/** Panel formundan gələn id-ni təhlükəsiz formaya salır. */
function bsx_clean_id(string $id): string {
    $id = strtolower(trim($id));
    $id = preg_replace('/[^a-z0-9_\-]/', '', $id) ?? '';
    return mb_substr($id, 0, 40);
}

/* ───────────────────────────── kataloq ─────────────────────────── */

/** Stil rejimindən palitra qrupuna keçid. */
function bsx_mode_group(string $mode): string {
    if ($mode === 'hair') return 'hair';
    if ($mode === 'makeup') return 'lips';
    if ($mode === 'brow') return 'brow';
    if ($mode === 'nails') return 'nails';
    return '';
}

/** Köhnə sadə açarları (gold, rose, ash …) qrupa görə unikal açarlara çevirir. */
function bsx_normalize_colors(array $colors, string $group): array {
    if (!in_array($group, ['hair', 'lips', 'brow', 'nails'], true)) return [];
    $prefix = ['hair' => 'hair_', 'lips' => 'lip_', 'brow' => 'brow_', 'nails' => 'nail_'][$group];
    $alias  = [
        'brow'  => ['chocolate' => 'brow_dark_brown', 'ash' => 'brow_taupe'],
        'nails' => ['rose' => 'nail_pink'],
    ][$group] ?? [];
    $palette = bsx_palette();
    $out = [];
    foreach ($colors as $c) {
        $c = (string)$c;
        if (isset($palette[$c])) { $out[] = $c; continue; }
        if (isset($alias[$c])) { $out[] = $alias[$c]; continue; }
        $cand = $prefix . $c;
        if (isset($palette[$cand])) $out[] = $cand;
    }
    return array_values(array_unique($out));
}

/**
 * Müştəriyə göstərilən rənglər: normalize edilmiş seçim + (istənilsə)
 * qrupun bütün tonları. Beləliklə hər stildə geniş, panelsə idarəolunan palitra var.
 */
function bsx_effective_colors(array $colors, string $mode, bool $expand): array {
    $group = bsx_mode_group($mode);
    $norm  = bsx_normalize_colors($colors, $group);
    if (!$expand) return $norm;
    if ($group === '') return [];
    return array_values(array_unique(array_merge($norm, array_keys(bsx_palette_group($group)))));
}

/**
 * Effektiv kataloq: config defaultları + panel dəyişiklikləri.
 *
 * @param array $cfg          config/beauty-styles.php
 * @param bool  $onlyActive   sayt üçün yalnız aktiv stillər
 * @param bool  $expandColors müştəri tərəfi: qrupun bütün rənglərini əlavə et
 * @return array<string,array>
 */
function bsx_catalog(array $cfg, bool $onlyActive = false, bool $expandColors = false): array {
    $items = bsx_store()['items'];
    $out = [];

    foreach (($cfg['categories'] ?? []) as $catKey => $cat) {
        $catOut = $cat;
        $catOut['key'] = (string)$catKey;
        $catOut['styles'] = [];

        foreach (($cat['styles'] ?? []) as $st) {
            $id = (string)($st['id'] ?? '');
            if ($id === '') continue;
            $ov = is_array($items[$id] ?? null) ? $items[$id] : [];
            if (!empty($ov['deleted'])) continue;

            $one = $st;
            $one['cat'] = (string)$catKey;
            $one['active'] = (bool)($ov['active'] ?? true);
            $one['custom'] = false;
            if (!empty($ov['name']) && is_array($ov['name'])) {
                foreach (BSX_LANGS as $l) {
                    if (!empty($ov['name'][$l])) $one['name'][$l] = (string)$ov['name'][$l];
                }
            }
            if (!empty($ov['desc']) && is_array($ov['desc'])) {
                foreach (BSX_LANGS as $l) {
                    if (!empty($ov['desc'][$l])) $one['desc'][$l] = (string)$ov['desc'][$l];
                }
            }
            if (!empty($ov['colors']) && is_array($ov['colors'])) $one['colors'] = array_values($ov['colors']);
            if (!empty($ov['img'])) $one['img'] = (string)$ov['img'];
            $one['img_url'] = bsx_img_url((string)($one['img'] ?? ''));
            $one['colors'] = bsx_effective_colors((array)($one['colors'] ?? []), (string)($one['mode'] ?? ''), $expandColors);
            if ($onlyActive && !$one['active']) continue;
            $catOut['styles'][] = $one;
        }

        // panelden əlavə edilən stillər
        foreach ($items as $id => $ov) {
            if (empty($ov['custom']) || !empty($ov['deleted'])) continue;
            if ((string)($ov['cat'] ?? '') !== (string)$catKey) continue;
            $one = [
                'id'         => (string)$id,
                'cat'        => (string)$catKey,
                'service_id' => (int)($ov['service_id'] ?? ($cat['service_id'] ?? 401)),
                'mode'       => (string)($ov['mode'] ?? 'sample'),
                'img'        => (string)($ov['img'] ?? ''),
                'img_url'    => bsx_img_url((string)($ov['img'] ?? '')),
                'name'       => is_array($ov['name'] ?? null) ? $ov['name'] : ['az' => $id, 'en' => $id, 'tr' => $id, 'ru' => $id],
                'desc'       => is_array($ov['desc'] ?? null) ? $ov['desc'] : [],
                'colors'     => is_array($ov['colors'] ?? null) ? array_values($ov['colors']) : [],
                'opts'       => [],
                'active'     => (bool)($ov['active'] ?? true),
                'custom'     => true,
            ];
            $one['colors'] = bsx_effective_colors((array)($one['colors'] ?? []), (string)($one['mode'] ?? ''), $expandColors);
            if ($onlyActive && !$one['active']) continue;
            $catOut['styles'][] = $one;
        }

        $out[(string)$catKey] = $catOut;
    }

    return $out;
}

/** Bütün stillər (panel siyahısı üçün) — kateqoriya açarı ilə birlikdə. */
function bsx_all_styles(array $cfg): array {
    $out = [];
    foreach (bsx_catalog($cfg, false) as $catKey => $cat) {
        foreach ($cat['styles'] as $st) $out[] = $st;
    }
    return $out;
}

function bsx_style(array $cfg, string $id): ?array {
    foreach (bsx_all_styles($cfg) as $st) {
        if ((string)$st['id'] === $id) return $st;
    }
    return null;
}

/* ───────────────────────────── panel əməliyyatları ─────────────── */

/**
 * Panel formundan stili əlavə edir / redaktə edir.
 *
 * @param array $post  id, cat, name[lang], desc[lang], colors[], service_id, active, delete_photo
 * @param array $file  $_FILES['img']
 */
function bsx_save_style(array $post, array $file, array $cfg): array {
    $cats = array_keys($cfg['categories'] ?? []);
    $cat  = (string)($post['cat'] ?? '');
    if (!in_array($cat, $cats, true)) {
        return ['ok' => false, 'error' => 'Kateqoriya seçilmədi.'];
    }

    $id = bsx_clean_id((string)($post['id'] ?? ''));
    if ($id === '') $id = 'cs_' . bin2hex(random_bytes(4));

    $store = bsx_store();
    $cur   = is_array($store['items'][$id] ?? null) ? $store['items'][$id] : [];
    $existing = bsx_style($cfg, $id);
    $isDefault = $existing && empty($existing['custom']);

    if (!$isDefault && !$existing) {
        // yeni stil
        $cur['custom'] = true;
        $cur['cat'] = $cat;
        $cur['mode'] = (string)($post['mode'] ?? 'sample');
        if (!in_array($cur['mode'], ['hair', 'gloss', 'makeup', 'brow', 'nails', 'sample'], true)) {
            $cur['mode'] = 'sample';
        }
    } elseif ($existing) {
        $cur['cat'] = (string)$existing['cat'];
        $cur['mode'] = (string)$existing['mode'];
    }

    $name = [];
    $desc = [];
    foreach (BSX_LANGS as $l) {
        $n = trim((string)($post['name'][$l] ?? ''));
        if ($n !== '') $name[$l] = mb_substr($n, 0, 60);
        $d = trim((string)($post['desc'][$l] ?? ''));
        if ($d !== '') $desc[$l] = mb_substr($d, 0, 220);
    }
    if ($name === []) {
        return ['ok' => false, 'error' => 'Stilin adını yazın (ən azı bir dildə).'];
    }

    $colors = [];
    foreach ((array)($post['colors'] ?? []) as $c) {
        $c = (string)$c;
        if (isset(bsx_palette()[$c])) $colors[] = $c;
    }

    $serviceId = (int)($post['service_id'] ?? 0);
    $svcIds = array_map(fn($s) => (int)$s['id'], $cfg['services'] ?? []);
    if ($svcIds && !in_array($serviceId, $svcIds, true)) {
        $serviceId = (int)($cfg['categories'][$cat]['service_id'] ?? 401);
    }
    if ($serviceId <= 0) {
        $serviceId = (int)($cfg['categories'][$cat]['service_id'] ?? 401);
    }

    $img = (string)($cur['img'] ?? '');

    if (!empty($post['delete_photo'])) {
        bsx_delete_photo_file($img);
        $img = '';
    }

    if (is_array($file) && (int)($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
        $tmp = (string)($file['tmp_name'] ?? '');
        if ((int)($file['size'] ?? 0) > 3 * 1024 * 1024) {
            return ['ok' => false, 'error' => 'Şəkil 3 MB-dan böyükdür.'];
        }
        $info = @getimagesize($tmp);
        $mime = is_array($info) ? (string)($info['mime'] ?? '') : '';
        $ext = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'][$mime] ?? '';
        if ($ext === '') {
            return ['ok' => false, 'error' => 'Şəkil yalnız JPG, PNG və ya WEBP ola bilər.'];
        }
        $dir = bsx_upload_dir();
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            return ['ok' => false, 'error' => 'uploads/beauty qovluğu yaradılmadı.'];
        }
        $newName = 'style-' . bin2hex(random_bytes(5)) . '.' . $ext;
        if (!move_uploaded_file($tmp, $dir . '/' . $newName)) {
            return ['ok' => false, 'error' => 'Şəkil yüklənmədi.'];
        }
        bsx_delete_photo_file($img);
        $img = 'uploads/beauty/' . $newName;
    }

    $cur['name'] = $name;
    $cur['desc'] = $desc;
    $cur['colors'] = array_values(array_unique($colors));
    $cur['img'] = $img;
    $cur['service_id'] = $serviceId;
    $cur['active'] = !empty($post['active']);
    unset($cur['deleted']);

    $store['items'][$id] = $cur;
    return bsx_save_store($store)
        ? ['ok' => true, 'id' => $id]
        : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

/** Stili silir (default stil → `deleted` nişanı). */
function bsx_delete_style(string $id, array $cfg): array {
    $id = bsx_clean_id($id);
    if ($id === '') return ['ok' => false, 'error' => 'Stil tapılmadı.'];

    $st = bsx_style($cfg, $id);
    if (!$st) return ['ok' => false, 'error' => 'Stil tapılmadı.'];

    $store = bsx_store();
    if (!empty($st['custom'])) {
        bsx_delete_photo_file((string)($store['items'][$id]['img'] ?? ''));
        unset($store['items'][$id]);
    } else {
        $store['items'][$id] = ['deleted' => true];
    }
    return bsx_save_store($store)
        ? ['ok' => true]
        : ['ok' => false, 'error' => 'Yazma alınmadı.'];
}

/** Yalnız panelin yüklədiyi `uploads/beauty/style-*` faylını silir. */
function bsx_delete_photo_file(string $img): void {
    if (!str_starts_with($img, 'uploads/beauty/style-')) return;
    $p = dirname(__DIR__) . '/' . $img;
    if (is_file($p)) @unlink($p);
}
