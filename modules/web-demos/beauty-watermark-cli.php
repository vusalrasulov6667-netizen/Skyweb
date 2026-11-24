<?php
/**
 * CLI: şəklə loqo watermark-ı «yandırır».
 * Usage: php beauty-watermark-cli.php <input> <output> <logo.png> [maxWidth]
 * Yalnız CLI — Apache-də GD olmadığı üçün panel bu skripti alt-prosess kimi çağırır.
 */
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('CLI only'); }
if (!extension_loaded('gd')) { fwrite(STDERR, "GD yoxdur\n"); exit(2); }

$in     = $argv[1] ?? '';
$out    = $argv[2] ?? '';
$logo   = $argv[3] ?? '';
$maxW   = (int)($argv[4] ?? 1600);
if ($in === '' || $out === '' || !is_file($in)) { fwrite(STDERR, "giriş faylı yoxdur\n"); exit(3); }
if (!is_file($logo)) { copy($in, $out); exit(0); } // loqo yoxdursa ən azı faylı saxla

$data = file_get_contents($in);
$src  = @imagecreatefromstring($data);
if (!$src) { fwrite(STDERR, "şəkil oxunmadı\n"); exit(4); }

$w = imagesx($src); $h = imagesy($src);
if ($maxW > 0 && $w > $maxW) {
    $nh = (int)round($h * ($maxW / $w));
    $resized = imagecreatetruecolor($maxW, $nh);
    imagecopyresampled($resized, $src, 0, 0, 0, 0, $maxW, $nh, $w, $h);
    imagedestroy($src);
    $src = $resized; $w = $maxW; $h = $nh;
}

// Loqo ölçüsü: şəklin 22%-i, 80–320px arası
$lw = (int)min(320, max(80, round($w * 0.22)));
$lsrc = @imagecreatefrompng($logo);
if (!$lsrc) $lsrc = @imagecreatefromstring((string)file_get_contents($logo));
if (!$lsrc) { imagejpeg($src, $out, 88); imagedestroy($src); exit(0); }
$lw0 = imagesx($lsrc); $lh0 = imagesy($lsrc);
$lh = (int)max(1, round($lh0 * ($lw / $lw0)));
$lscaled = imagecreatetruecolor($lw, $lh);
imagealphablending($lscaled, false);
imagefill($lscaled, 0, 0, imagecolorallocatealpha($lscaled, 0, 0, 0, 127));
imagesavealpha($lscaled, true);
imagecopyresampled($lscaled, $lsrc, 0, 0, 0, 0, $lw, $lh, $lw0, $lh0);
imagedestroy($lsrc);

// Opaklıq ~78%
$op = imagecreatetruecolor($lw, $lh);
imagealphablending($op, false);
imagefill($op, 0, 0, imagecolorallocatealpha($op, 0, 0, 0, 127));
imagesavealpha($op, true);
for ($y = 0; $y < $lh; $y++) {
    for ($x = 0; $x < $lw; $x++) {
        $c = imagecolorat($lscaled, $x, $y);
        $a = ($c >> 24) & 0x7F;
        $na = 127 - (int)round((127 - $a) * 0.78);
        if ($na > 127) $na = 127;
        $rgb = $c & 0xFFFFFF;
        imagesetpixel($op, $x, $y, ($na << 24) | $rgb);
    }
}
imagedestroy($lscaled);

$margin = (int)max(12, round($w * 0.018));
$dx = $w - $lw - $margin;
$dy = $h - $lh - $margin;
imagealphablending($src, true);
imagesavealpha($src, true);
imagecopy($src, $op, $dx, $dy, 0, 0, $lw, $lh);
imagedestroy($op);

$ext = strtolower(pathinfo($out, PATHINFO_EXTENSION));
if ($ext === 'png') {
    imagepng($src, $out, 8);
} else {
    $flat = imagecreatetruecolor($w, $h);
    // şəffaf PNG → ağ fon
    $white = imagecolorallocate($flat, 255, 255, 255);
    imagefilledrectangle($flat, 0, 0, $w, $h, $white);
    imagecopy($flat, $src, 0, 0, 0, 0, $w, $h);
    imagejpeg($flat, $out, 88);
    imagedestroy($flat);
}
imagedestroy($src);
echo "ok $w x $h\n";
