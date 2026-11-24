<?php
/**
 * SkyBot Chat AJAX Endpoint
 * Multilingual AI Service-Support Assistant for SkyWeb
 * Accepts POST JSON: { message: string, lang: string }
 * Returns JSON:      { reply: string, links: array, topic: string, lang: string }
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

// Same-origin only check
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$host   = $_SERVER['HTTP_HOST'] ?? '';
if ($origin && parse_url($origin, PHP_URL_HOST) !== $host) {
    http_response_code(403);
    echo json_encode(['reply' => 'Forbidden', 'links' => [], 'topic' => 'error', 'lang' => 'az']);
    exit;
}

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/lang.php';
require_once dirname(__DIR__) . '/skybot/knowledge.php';

/**
 * The assistant answers only the asked question. Trailing "contact us / ask me"
 * calls to action and suggestion lists are stripped so a reply never turns into
 * an offer. The core answer (including any service details) stays untouched.
 */
function skybot_strip_suggestions(string $text): string {
    $patterns = [
        '/\n\n[^\n]*(?:sualınızı yaz|sualınızı ver|sorunuzu|bizimlə əlaqə|bizə müraciət|bizə göndərin|əlaqə saxlayın|başlamaq üçün|hazırlaya bilərsiniz|dərhal əlaqə|məmnuniyyətlə təqdim|təklif edim|recommend|contact us|get in touch|ask me|feel free|let us know|let\'s build|start creating|order now|задайте|свяжитесь|напишите|оставьте заявку|bize ulaş|görüşün|hemen)[^\n]*$/iu',
    ];
    foreach ($patterns as $re) {
        $out = preg_replace($re, '', $text);
        if ($out !== null) $text = $out;
    }
    return trim($text);
}

/** Digits-only phone number for tel:/wa.me links, from the single site config. */
function skybot_phone_digits(): string {
    return preg_replace('/\D+/', '', SITE_PHONE) ?? '';
}

// ── Parse input ──────────────────────────────────────────────────────────────
$raw   = file_get_contents('php://input');
$input = json_decode($raw, true);

if (!is_array($input)) {
    echo json_encode([
        'reply' => sky_literal_translate('Xahiş edirəm sualınızı daxil edin.', CURRENT_LANG),
        'links' => [],
        'topic' => 'empty',
        'lang'  => CURRENT_LANG
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$message     = trim($input['message'] ?? '');
$defaultLang = in_array($input['lang'] ?? '', ['az', 'en', 'ru', 'tr'], true)
               ? $input['lang']
               : 'az';

// ── Language Detection Function ───────────────────────────────────────────────
function detectCustomerLanguage(string $text, string $fallbackLang = 'az'): string {
    $textLower = mb_strtolower($text, 'UTF-8');

    // 1. Cyrillic alphabet detection -> Russian (ru)
    if (preg_match('/[\p{Cyrillic}]/u', $textLower)) {
        return 'ru';
    }

    // 2. Distinctive Azerbaijani character 'ə' -> Azerbaijani (az)
    if (mb_strpos($textLower, 'ə') !== false) {
        return 'az';
    }

    // 3. Azerbaijani distinctive keywords
    $azKeywords = [
        'haqqında', 'qiymət', 'qiyməti', 'qiymətlər', 'xidmət', 'xidmətlər', 'nədir',
        'harada', 'tətbiq', 'çatdırılma', 'sifariş', 'hazırlamaq', 'istəyirəm', 'əlaqə',
        'sayt', 'saytlar', 'restoran', 'butik', 'təhsil', 'tərcümeyi-hal', 'təşəkkür',
        'necə', 'hansı', 'vəzifə', 'iş', 'aptek', 'növbə', 'əczaçı', 'reklam', 'salam'
    ];
    foreach ($azKeywords as $kw) {
        if (preg_match('/\b' . preg_quote($kw, '/') . '\b/u', $textLower)) {
            return 'az';
        }
    }

    // 4. Turkish distinctive keywords
    $trKeywords = [
        'merhaba', 'nasılsınız', 'fiyat', 'fiyatlar', 'fiyatı', 'ücret', 'ücreti',
        'nelerdir', 'nasıl', 'sipariş', 'iletişim', 'geliştirme', 'teşekkür', 'lütfen',
        'hizmetler', 'hizmet', 'uygulama', 'özgeçmiş', 'reklamlar', 'kurulum', 'ödeme',
        'tasarım', 'eczane', 'randevu', 'dijital', 'proje', 'projeler'
    ];
    foreach ($trKeywords as $kw) {
        if (preg_match('/\b' . preg_quote($kw, '/') . '\b/u', $textLower)) {
            return 'tr';
        }
    }

    // 5. English distinctive keywords
    $enKeywords = [
        'hello', 'hi', 'hey', 'what', 'how', 'price', 'pricing', 'cost', 'service',
        'services', 'website', 'app', 'mobile', 'development', 'order', 'build',
        'contact', 'phone', 'support', 'pharmacy', 'restaurant', 'store', 'ecommerce',
        'portfolio', 'demo', 'demos', 'thank', 'thanks', 'hosting', 'marketing',
        'advertising', 'google', 'instagram', 'tiktok', 'resume', 'cv'
    ];
    foreach ($enKeywords as $kw) {
        if (preg_match('/\b' . preg_quote($kw, '/') . '\b/u', $textLower)) {
            return 'en';
        }
    }

    // Default to the website's currently selected language
    return $fallbackLang;
}

$effectiveLang = detectCustomerLanguage($message, $defaultLang);

if ($message === '' || mb_strlen($message, 'UTF-8') > 500) {
    $tooLong = [
        'az' => 'Xahiş edirik sualınızı daxil edin (maksimum 500 simvol).',
        'en' => 'Please enter a question (maximum 500 characters).',
        'ru' => 'Пожалуйста, введите ваш вопрос (не более 500 символов).',
        'tr' => 'Lütfen sorunuzu yazın (en fazla 500 karakter).',
    ];
    echo json_encode([
        'reply' => $tooLong[$effectiveLang] ?? $tooLong['az'],
        'links' => [],
        'topic' => 'too_long',
        'lang'  => $effectiveLang
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ── Enhanced Knowledge Search & Scoring ────────────────────────────────────────
$msgLower   = mb_strtolower($message, 'UTF-8');

$bestScore  = 0;
$bestEntry  = null;

foreach ($skybot_knowledge as $entry) {
    $score = 0;
    $keywords = $entry['keywords'] ?? [];

    foreach ($keywords as $kw) {
        $kwLower = mb_strtolower(trim($kw), 'UTF-8');
        if ($kwLower === '') continue;

        // Whole-word / whole-phrase match only. Plain strpos() used to let
        // "what" hit "whatsapp ...", sending generic service questions to a
        // demo-specific answer. Unicode letter lookarounds prevent that.
        $pattern = '/(?<!\p{L})' . preg_quote($kwLower, '/') . '(?!\p{L})/u';
        if (preg_match($pattern, $msgLower)) {
            $len = mb_strlen($kwLower, 'UTF-8');
            $score += ($len > 8) ? 6 : (($len > 4) ? 4 : 2);
        }
    }

    if ($score > $bestScore) {
        $bestScore = $score;
        $bestEntry = $entry;
    }
}

// ── Build Response ────────────────────────────────────────────────────────────
if ($bestEntry && $bestScore >= 2) {
    $reply = $bestEntry['langs'][$effectiveLang]
          ?? $bestEntry['langs'][$defaultLang]
          ?? $bestEntry['langs']['az']
          ?? '';
    // Answer only the asked question — no extra offers or next-step prompts.
    $reply = skybot_strip_suggestions($reply);

    // No contextual link buttons: they read as suggestions in the chat.
    $links = [];

    echo json_encode([
        'reply' => $reply,
        'links' => $links,
        'topic' => $bestEntry['topic'] ?? $bestEntry['id'] ?? '',
        'lang'  => $effectiveLang,
    ], JSON_UNESCAPED_UNICODE);

} else {
    // Outside questions (business/work): redirect to the internal contact
    // number only. No service list, no offers, no extra suggestions.
    $phone       = SITE_PHONE;
    $phoneDigits = skybot_phone_digits();
    $noInfo = [
        'az' => "Bu sual saytımızın xidmətlərinə aid deyil. Biznes və iş məsələləriniz üçün sizinlə əlaqə saxlanılacaq. Daxili nömrəmiz: {$phone} — bu nömrə ilə də əlaqə saxlaya bilərsiniz.",
        'en' => "This question is outside our website services. For business or work matters, you will be contacted by our team. Internal number: {$phone} — you can also reach us on this number.",
        'ru' => "Этот вопрос не относится к услугам нашего сайта. По бизнес- и рабочим вопросам с вами свяжутся. Наш внутренний номер: {$phone} — также можете позвонить по этому номеру.",
        'tr' => "Bu soru sitemizin hizmetleri dışında. İş veya ticari konular için sizinle iletişime geçilecek. Dahili numaramız: {$phone} — bu numaradan da ulaşabilirsiniz.",
    ];

    echo json_encode([
        'reply' => $noInfo[$effectiveLang] ?? $noInfo['az'],
        'links' => [['label' => '📞 ' . $phone, 'url' => 'tel:' . $phoneDigits]],
        'topic' => 'external_contact',
        'lang'  => $effectiveLang,
    ], JSON_UNESCAPED_UNICODE);
}
