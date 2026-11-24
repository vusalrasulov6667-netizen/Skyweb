<?php
/**
 * Sky Beauty — media (qalereya + loqo + watermark) köməkçiləri.
 * Şəkil watermark-ı GD ilə CLI PHP-də aparılır (Apache PHP-də GD yoxdur).
 * Video watermark-ı ffmpeg ilə aparılır.
 */

function beauty_media_dir(): string {
    return dirname(__DIR__) . '/uploads/beauty';
}

function beauty_media_url(): string {
    return 'uploads/beauty/';
}

function beauty_gallery_json(): string {
    return dirname(__DIR__) . '/data/beauty-gallery.json';
}

function beauty_gallery_read(): array {
    $path = beauty_gallery_json();
    $data = is_file($path) ? json_decode((string)file_get_contents($path), true) : null;
    if (!is_array($data)) $data = [];
    $data += ['logo' => '', 'items' => []];
    if (!is_array($data['items'])) $data['items'] = [];
    return $data;
}

function beauty_gallery_write(array $data): bool {
    $path = beauty_gallery_json();
    $dir  = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0775, true)) return false;
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) return false;
    $tmp = $path . '.tmp' . bin2hex(random_bytes(4));
    if (file_put_contents($tmp, $json, LOCK_EX) === false) return false;
    if (!rename($tmp, $path)) { @unlink($tmp); return false; }
    return true;
}

/** Loqo faylının tam yolu (panel yükləməyibsə default). */
function beauty_logo_path(): string {
    $g = beauty_gallery_read();
    if (!empty($g['logo'])) {
        $p = beauty_media_dir() . '/' . basename((string)$g['logo']);
        if (is_file($p)) return $p;
    }
    return beauty_media_dir() . '/logo.png';
}

/** Şəkilə watermark vurur (CLI alt-proses). */
function beauty_watermark_image(string $src, string $dst): bool {
    $php = beauty_find_php();
    $cli = __DIR__ . '/../modules/web-demos/beauty-watermark-cli.php';
    if ($php === '' || !is_file($cli)) return false;
    $cmd = escapeshellarg($php) . ' ' . escapeshellarg($cli) . ' '
        . escapeshellarg($src) . ' ' . escapeshellarg($dst) . ' '
        . escapeshellarg(beauty_logo_path()) . ' 1600';
    $out = @shell_exec($cmd . ' 2>&1');
    return is_file($dst) && filesize($dst) > 0;
}

/** Video watermark (ffmpeg). */
function beauty_watermark_video(string $src, string $dst): bool {
    $ff = beauty_find_ffmpeg();
    if ($ff === '') return false;
    $logo = beauty_logo_path();
    $filter = '[1:v]scale=150:-1[wm];[0:v][wm]overlay=W-w-24:H-h-24:format=auto';
    $cmd = escapeshellarg($ff) . ' -y -i ' . escapeshellarg($src)
        . ' -i ' . escapeshellarg($logo)
        . ' -filter_complex ' . escapeshellarg($filter)
        . ' -c:v libx264 -preset veryfast -crf 23 -pix_fmt yuv420p'
        . ' -c:a aac -b:a 128k -movflags +faststart '
        . escapeshellarg($dst) . ' 2>&1';
    @shell_exec($cmd);
    return is_file($dst) && filesize($dst) > 0;
}

function beauty_find_php(): string {
    if (is_file(__DIR__ . '/secrets.php')) {
        require_once __DIR__ . '/secrets.php';
    }
    $candidates = array_merge(
        defined('SKY_SECRET_PHP_CANDIDATES') ? SKY_SECRET_PHP_CANDIDATES : [],
        [PHP_BINDIR . '/php.exe', PHP_BINDIR . '/php']
    );
    foreach ($candidates as $c) {
        if ($c !== '' && is_file($c)) return $c;
    }
    return '';
}

function beauty_find_ffmpeg(): string {
    if (is_file(__DIR__ . '/secrets.php')) {
        require_once __DIR__ . '/secrets.php';
    }
    $candidates = defined('SKY_SECRET_FFMPEG_CANDIDATES') ? SKY_SECRET_FFMPEG_CANDIDATES : [];
    foreach ($candidates as $c) {
        if (is_file($c)) return $c;
    }
    $which = @shell_exec('where ffmpeg 2>NUL');
    if (is_string($which) && preg_match('/^(.+?ffmpeg\.exe)/mi', trim($which), $m)) {
        return trim($m[1]);
    }
    return '';
}
