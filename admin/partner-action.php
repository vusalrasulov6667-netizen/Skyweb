<?php
/**
 * SKYWEB.AZ — Footer-daxili partner idarəetməsi (yalnız admin)
 * ---------------------------------------------------------------
 * Bu endpoint yalnız `sky_admin_is_logged_in()` TRUE olduqda işləyir.
 * Publik ziyarətçilər nə düymələri görür, nə də bu fayla POST edə bilər.
 *
 * Dəstəklənən əməliyyatlar:
 *   action=add          → yeni brend (ad + loqo + istəyə bağlı URL)
 *   action=toggle       → bölmənin publik görünürlüğünü aç/bağla
 *   action=toggle_item  → tək brendin görünürlüğünü aç/bağla
 *   action=delete       → tək brendi sil (loqo faylı da silinir)
 *
 * CSRF yoxlanılır; nəticə sessiya flash-ı ilə `index.php#partners`-ə qayıdır.
 */
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/admin.php';
require_once __DIR__ . '/../config/partners.php';

header('X-Robots-Tag: noindex, nofollow', true);
header('Referrer-Policy: same-origin', true);

function sky_partner_action_back(): void {
    header('Location: ../index.php#partners');
    exit;
}

/* ── Yalnız POST ────────────────────────────────────────────── */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    echo 'Method Not Allowed';
    exit;
}

/* ── Yalnız admin ───────────────────────────────────────────── */
if (!sky_admin_is_logged_in()) {
    http_response_code(403);
    echo 'Forbidden — yalnız administrator.';
    exit;
}

sky_admin_touch();

/* ── CSRF ───────────────────────────────────────────────────── */
if (!csrf_verify((string) ($_POST['csrf'] ?? ''))) {
    sky_partners_flash('error', 'Təhlükəsizlik xətası (CSRF). Səhifəni yeniləyib yenidən cəhd edin.');
    sky_partner_action_back();
}

$action = (string) ($_POST['action'] ?? '');

switch ($action) {
    /* ── Yeni brend əlavə et ──────────────────────────────── */
    case 'add':
        $name        = trim((string) ($_POST['name'] ?? ''));
        $urlInput    = (string) ($_POST['url'] ?? '');
        $itemVisible = array_key_exists('item_visible', $_POST) ? !empty($_POST['item_visible']) : true;

        if (mb_strlen($name, 'UTF-8') > 120) {
            $name = mb_substr($name, 0, 120, 'UTF-8');
        }

        $data = sky_partners_load();
        if (count($data['items']) >= 60) {
            sky_partners_flash('error', 'Maksimum 60 brendə çatdınız. Yeni əlavə etmək üçün birini silin.');
            sky_partner_action_back();
        }

        $uploadError = null;
        $logo = sky_partners_upload_logo($_FILES['logo'] ?? null, $uploadError);
        if ($uploadError !== null) {
            sky_partners_flash('error', $uploadError);
            sky_partner_action_back();
        }
        $logo = $logo ?? '';

        if ($name === '' && $logo === '') {
            sky_partners_flash('error', 'Brend adı və ya loqo tələb olunur.');
            sky_partner_action_back();
        }

        $url = sky_partners_clean_url($urlInput);
        if ($url === null) {
            if ($logo !== '') {
                sky_partners_delete_logo_file($logo);
            }
            sky_partners_flash('error', 'Vebsayt ünvanı düzgün deyil. Nümunə: https://brend.az');
            sky_partner_action_back();
        }

        $data['items'][] = [
            'id'      => sky_partner_new_id(),
            'name'    => $name,
            'logo'    => $logo,
            'url'     => $url,
            'visible' => $itemVisible,
        ];

        $autoOpened = sky_partners_auto_publish($data);

        if (sky_partners_save($data)) {
            sky_partners_flash('success', '«' . ($name !== '' ? $name : 'Loqo') . '» əlavə olundu.'
                . ($autoOpened
                    ? ' Bölmə də avtomatik saytda görünür edildi.'
                    : (empty($data['visible']) ? ' Bölmə hələ gizlidir — «Saytda göstər» düyməsini basın.' : '')));
        } else {
            if ($logo !== '') {
                sky_partners_delete_logo_file($logo);
            }
            sky_partners_flash('error', 'Yadda saxlamaq alınmadı (`data/partners.json`).');
        }
        sky_partner_action_back();
        break;

    /* ── Bölmənin görünürlüyü ─────────────────────────────── */
    case 'toggle':
        $data = sky_partners_load();

        if (isset($_POST['visible'])) {
            $data['visible'] = ((string) $_POST['visible']) === '1';
        } else {
            $data['visible'] = empty($data['visible']);
        }

        if (sky_partners_save($data)) {
            $active = 0;
            foreach ($data['items'] as $item) {
                if (!empty($item['visible'])) {
                    $active++;
                }
            }
            if ($data['visible'] && $active === 0) {
                sky_partners_flash('warning', 'Bölmə aktiv edildi, lakin hələ aktiv brend yoxdur — saytda heç nə görünməyəcək.');
            } else {
                sky_partners_flash('success', $data['visible']
                    ? 'Bölmə saytda GÖRÜNÜR edildi.'
                    : 'Bölmə saytda GİZLİDİR.');
            }
        } else {
            sky_partners_flash('error', 'Yadda saxlamaq alınmadı (`data/partners.json`).');
        }
        sky_partner_action_back();
        break;

    /* ── Tək brendin görünürlüyü ──────────────────────────── */
    case 'toggle_item':
        $id   = (string) ($_POST['id'] ?? '');
        $data = sky_partners_load();
        $hit  = false;

        foreach ($data['items'] as $i => $item) {
            if ((string) ($item['id'] ?? '') === $id) {
                $data['items'][$i]['visible'] = empty($item['visible']);
                $hit = true;
                $label = (string) ($item['name'] ?? '');
                $nowVisible = !empty($data['items'][$i]['visible']);
                break;
            }
        }

        if (!$hit) {
            sky_partners_flash('error', 'Brend tapılmadı.');
            sky_partner_action_back();
        }

        $autoOpened = sky_partners_auto_publish($data);

        if (sky_partners_save($data)) {
            sky_partners_flash('success', '«' . ($label !== '' ? $label : 'Brend') . '» '
                . ($nowVisible ? 'saytda göstərilir.' : 'saytda gizlədildi.')
                . ($autoOpened ? ' Bölmə də avtomatik saytda görünür edildi.' : ''));
        } else {
            sky_partners_flash('error', 'Yadda saxlamaq alınmadı (`data/partners.json`).');
        }
        sky_partner_action_back();
        break;

    /* ── Brendi sil ───────────────────────────────────────── */
    case 'delete':
        $id     = (string) ($_POST['id'] ?? '');
        $data   = sky_partners_load();
        $hit    = false;
        $label  = '';
        $removedLogo = '';

        foreach ($data['items'] as $i => $item) {
            if ((string) ($item['id'] ?? '') === $id) {
                $label = (string) ($item['name'] ?? '');
                $removedLogo = (string) ($item['logo'] ?? '');
                array_splice($data['items'], $i, 1);
                $hit = true;
                break;
            }
        }

        if (!$hit) {
            sky_partners_flash('error', 'Brend tapılmadı.');
            sky_partner_action_back();
        }

        if (sky_partners_save($data)) {
            if ($removedLogo !== '') {
                sky_partners_delete_logo_file($removedLogo);
            }
            sky_partners_flash('success', '«' . ($label !== '' ? $label : 'Brend') . '» silindi.');
        } else {
            sky_partners_flash('error', 'Yadda saxlamaq alınmadı (`data/partners.json`).');
        }
        sky_partner_action_back();
        break;

    default:
        sky_partners_flash('error', 'Naməlum əməliyyat.');
        sky_partner_action_back();
}
