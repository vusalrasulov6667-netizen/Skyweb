<?php
/**
 * SKYWEB.AZ — Multi-Language (i18n) Engine
 * Supported Languages in exact order:
 * 1. Azerbaijani (az) — Default
 * 2. Turkish (tr)
 * 3. English (en)
 * 4. Russian (ru)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$SUPPORTED_LANGUAGES = [
    'az' => [
        'code'      => 'az',
        'name'      => 'Azərbaycan',
        'short'     => 'AZ',
        'flag_img'  => 'https://flagcdn.com/w40/az.png',
        'flag_img2x'=> 'https://flagcdn.com/w80/az.png',
        'flag_alt'  => 'Azerbaijan',
    ],
    'ru' => [
        'code'      => 'ru',
        'name'      => 'Русский',
        'short'     => 'RU',
        'flag_img'  => 'https://flagcdn.com/w40/ru.png',
        'flag_img2x'=> 'https://flagcdn.com/w80/ru.png',
        'flag_alt'  => 'Russia',
    ],
    'en' => [
        'code'      => 'en',
        'name'      => 'English',
        'short'     => 'ENG',
        'flag_img'  => 'https://flagcdn.com/w40/gb.png',
        'flag_img2x'=> 'https://flagcdn.com/w80/gb.png',
        'flag_alt'  => 'United Kingdom',
    ],
    'tr' => [
        'code'      => 'tr',
        'name'      => 'Türkçe',
        'short'     => 'TR',
        'flag_img'  => 'https://flagcdn.com/w40/tr.png',
        'flag_img2x'=> 'https://flagcdn.com/w80/tr.png',
        'flag_alt'  => 'Turkey',
    ],
];

// Handle language selection from GET parameter
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $SUPPORTED_LANGUAGES)) {
    $selected_lang = $_GET['lang'];
    $_SESSION['sky_lang'] = $selected_lang;
    setcookie('sky_lang', $selected_lang, time() + (86400 * 30), '/');
}

// Determine active language
$active_lang = 'az';
if (!empty($_SESSION['sky_lang']) && array_key_exists($_SESSION['sky_lang'], $SUPPORTED_LANGUAGES)) {
    $active_lang = $_SESSION['sky_lang'];
} elseif (!empty($_COOKIE['sky_lang']) && array_key_exists($_COOKIE['sky_lang'], $SUPPORTED_LANGUAGES)) {
    $active_lang = $_COOKIE['sky_lang'];
}

if (!defined('CURRENT_LANG')) {
    define('CURRENT_LANG', $active_lang);
}

// Load Translations
$lang_dir = dirname(__DIR__) . '/lang';

// Always load AZ as baseline fallback
$translations_fallback = [];
if (file_exists($lang_dir . '/az.php')) {
    $translations_fallback = require $lang_dir . '/az.php';
}

$translations_current = [];
if ($active_lang !== 'az' && file_exists($lang_dir . '/' . $active_lang . '.php')) {
    $translations_current = require $lang_dir . '/' . $active_lang . '.php';
}

$GLOBAL_TRANSLATIONS = array_merge($translations_fallback, $translations_current);

/**
 * Literal translation layer — covers hardcoded strings that never received keys.
 * Loaded once; also exposed to JavaScript by render_i18n_script().
 */
$SKY_EXTRA_I18N = [];
$_extra_file = dirname(__DIR__) . '/config/i18n-literals.php';
if (file_exists($_extra_file)) {
    $SKY_EXTRA_I18N = require $_extra_file;
}
unset($_extra_file);

/**
 * Translate a raw Azerbaijani literal using the extra literal dictionary.
 * Exact match first, then a match against AZ dictionary values (reverse lookup).
 */
function sky_literal_translate(string $text, ?string $lang = null): string {
    global $SKY_EXTRA_I18N, $translations_fallback, $GLOBAL_TRANSLATIONS;
    $lang = $lang ?: CURRENT_LANG;
    if ($lang === 'az') return $text;

    $key = trim($text);
    $literals = $SKY_EXTRA_I18N['literals'] ?? [];
    if (isset($literals[$key]) && is_array($literals[$key])) {
        return $literals[$key][$lang] ?? $literals[$key]['az'] ?? $text;
    }
    // Reverse lookup: if this literal is an AZ dictionary value, reuse its key.
    static $reverse = null;
    if ($reverse === null) {
        $reverse = [];
        foreach (($translations_fallback ?? []) as $k => $v) {
            if (is_string($v) && $v !== '' && !isset($reverse[$v])) $reverse[$v] = $k;
        }
    }
    if (isset($reverse[$key]) && isset($GLOBAL_TRANSLATIONS[$reverse[$key]])) {
        return $GLOBAL_TRANSLATIONS[$reverse[$key]];
    }
    return $text;
}

/** Build the AZ → active-language literal map used by both SSR and client-facing helpers. */
function sky_literal_map(?string $lang = null): array {
    global $SKY_EXTRA_I18N, $translations_fallback, $GLOBAL_TRANSLATIONS;
    $lang = $lang ?: CURRENT_LANG;
    if ($lang === 'az') return [];

    // Helpers may be called with an explicit language that differs from the
    // request language (saved-CV translation, CLI tests). Load that dictionary
    // instead of reusing $GLOBAL_TRANSLATIONS from the current request.
    static $dictCache = [];
    if ($lang !== CURRENT_LANG) {
        if (!array_key_exists($lang, $dictCache)) {
            $file = dirname(__DIR__) . '/lang/' . $lang . '.php';
            $dictCache[$lang] = file_exists($file) ? (require $file) : [];
        }
        $targetDict = array_merge($translations_fallback ?? [], $dictCache[$lang]);
    } else {
        $targetDict = $GLOBAL_TRANSLATIONS;
    }

    $map = [];
    foreach (($SKY_EXTRA_I18N['literals'] ?? []) as $az => $row) {
        if (is_array($row) && isset($row[$lang]) && $row[$lang] !== $az) $map[$az] = $row[$lang];
    }
    foreach (($translations_fallback ?? []) as $key => $az) {
        // $translations_fallback is key => AZ value. Explicit literals above win
        // so ambiguous words like "Premium" are not stolen by another key.
        if (!is_string($az) || $az === '' || isset($map[$az]) || !isset($targetDict[$key])) continue;
        $to = $targetDict[$key];
        if (is_string($to) && $to !== '' && $to !== $az) $map[$az] = $to;
    }
    return $map;
}

/**
 * Build a bounded, word-aware replacement regex for a literal map.
 *
 * A plain strtr()/substring match corrupts proper names and derived words:
 * "Ay" => "Month" turned "Aysel" into "Monthsel", "Qeydiyyat" => "Registration"
 * produced "Registrationdan", and "Əli" => "Ali" broke "Əliyev". Literal keys are
 * therefore matched as whole word fragments (letter boundaries only, so values
 * such as " ədəd" still match after a digit). Only keys actually present in the
 * subject are compiled, which keeps the pattern small on large pages.
 */
function sky_literal_replace(string $subject, array $map): string {
    if (!$map) return $subject;
    $used = [];
    foreach ($map as $az => $to) {
        if (is_string($az) && $az !== '' && strpos($subject, $az) !== false) $used[$az] = $to;
    }
    if (!$used) return $subject;

    uksort($used, static function ($a, $b): int {
        return mb_strlen((string)$b, 'UTF-8') <=> mb_strlen((string)$a, 'UTF-8');
    });
    $parts = [];
    foreach ($used as $az => $to) {
        $parts[] = preg_quote((string)$az, '/');
    }
    $pattern = '/(?<!\p{L})(?:' . implode('|', $parts) . ')(?!\p{L})/u';
    $result = preg_replace_callback($pattern, static function (array $m) use ($used): string {
        return (string)($used[$m[0]] ?? $m[0]);
    }, $subject);

    // Never fall back to substring replacement: that is exactly the corruption
    // this helper prevents. If PCRE cannot compile, leave the text untouched.
    return $result === null ? $subject : $result;
}

/**
 * Translate all known hardcoded literals inside a rendered HTML fragment.
 * Used for stored CV documents so an old saved CV follows the active language
 * when it is opened later.
 */
function sky_translate_html_literals(string $html, ?string $lang = null): string {
    $lang = $lang ?: CURRENT_LANG;
    if ($lang === 'az') return $html;
    $map = sky_literal_map($lang);
    return $map ? sky_literal_replace($html, $map) : $html;
}

/**
 * Output-buffer translation for legacy pages that still print hardcoded AZ text.
 * Script/style blocks and comments are protected so inline logic, CSS and
 * data attributes are never altered — only visible markup is translated.
 */
function sky_translate_document_html(string $html, ?string $lang = null): string {
    $lang = $lang ?: CURRENT_LANG;
    if ($lang === 'az') return $html;
    $map = sky_literal_map($lang);
    if (!$map) return $html;

    $protected = [];
    $html = preg_replace_callback(
        '/<script\b[^>]*>[\s\S]*?<\/script>|<style\b[^>]*>[\s\S]*?<\/style>|<title\b[^>]*>[\s\S]*?<\/title>|<meta\b[^>]*>|<!--[\s\S]*?-->|<([a-zA-Z][\w:-]*)\b[^>]*\bdata-sky-no-translate\b[^>]*>[\s\S]*?<\/\1>/i',
        static function (array $m) use (&$protected): string {
            $token = '@@SKY_PROTECTED_' . count($protected) . '@@';
            $protected[$token] = $m[0];
            return $token;
        },
        $html
    );

    $sourceHtml = $html;
    $html = sky_literal_replace($sourceHtml, $map);

    // Record the exact AZ source that produced each translated string on THIS
    // page. Clients use this page-specific reverse map to restore the right
    // wording when several AZ phrases share one translation (e.g. "Order").
    // Only keys actually present on the page are considered, longest first, and
    // matching uses the same letter-boundary rule as sky_literal_replace().
    $keys = array_keys($map);
    usort($keys, static function ($a, $b): int {
        return mb_strlen((string)$b, 'UTF-8') <=> mb_strlen((string)$a, 'UTF-8');
    });
    $counts = [];
    $work = $sourceHtml;
    foreach ($keys as $az) {
        if (!is_string($az) || $az === '' || strpos($work, $az) === false) continue;
        $pattern = '/(?<!\p{L})' . preg_quote($az, '/') . '(?!\p{L})/u';
        $n = preg_match_all($pattern, $work);
        if (!$n) continue;
        $target = $map[$az];
        if (!isset($counts[$target])) $counts[$target] = [];
        $counts[$target][$az] = $n;
        // Mask this match so shorter keys inside it are not counted again.
        $work = preg_replace_callback($pattern, static function (array $m): string {
            return str_repeat("\x01", strlen($m[0]));
        }, $work) ?? $work;
    }

    if ($protected) $html = strtr($html, $protected);

    // Expose the page-specific target → source map to sky-i18n.js. It is added
    // after translation, so it never becomes part of the translated text.
    if ($counts) {
        $reverse = [];
        foreach ($counts as $target => $sources) {
            arsort($sources);
            $reverse[$target] = array_key_first($sources);
        }
        $payload = json_encode(
            ['lang' => $lang, 'map' => $reverse],
            JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP
        );
        $script = '<script>window.__SKY_SSR_REVERSE__ = ' . $payload . ';</script>';
        // Must be the LAST </body>: index.php contains a JS string literal with
        // '</body></html>' inside document.write(). Replacing the first match
        // would corrupt that string and throw a client-side SyntaxError.
        $pos = strrpos(strtolower($html), '</body>');
        if ($pos !== false) {
            $html = substr($html, 0, $pos) . $script . substr($html, $pos);
        }
    }

    return $html;
}

/**
 * Get translated text by key
 */
function __(string $key, ?string $default = null): string {
    global $GLOBAL_TRANSLATIONS;
    if (isset($GLOBAL_TRANSLATIONS[$key])) {
        return $GLOBAL_TRANSLATIONS[$key];
    }
    return $default !== null ? $default : $key;
}

/**
 * Shorthand alias for __()
 */
function t(string $key, ?string $default = null): string {
    return __($key, $default);
}

/**
 * Get active language code
 */
function current_lang(): string {
    return CURRENT_LANG;
}

/**
 * Get current language details
 */
function current_lang_info(): array {
    global $SUPPORTED_LANGUAGES;
    return $SUPPORTED_LANGUAGES[CURRENT_LANG] ?? $SUPPORTED_LANGUAGES['az'];
}

/**
 * Get all supported languages list
 */
function all_languages(): array {
    global $SUPPORTED_LANGUAGES;
    return $SUPPORTED_LANGUAGES;
}

/**
 * Generate URL with changed language parameter
 */
function lang_url(string $lang_code): string {
    $query = $_GET;
    $query['lang'] = $lang_code;
    $base_url = strtok($_SERVER["REQUEST_URI"] ?? '', '?');
    return $base_url . '?' . http_build_query($query);
}

/**
 * Render JSON Script Tag containing all language dictionaries for JS
 */
function render_i18n_script(): string {
    global $SKY_EXTRA_I18N;
    $lang_dir = dirname(__DIR__) . '/lang';
    $all = [];
    foreach (['az', 'en', 'ru', 'tr'] as $code) {
        $file = $lang_dir . '/' . $code . '.php';
        if (file_exists($file)) {
            $all[$code] = require $file;
        }
    }
    // Reverse map: AZ dictionary value → key. Lets the client translate legacy
    // hardcoded literals that exactly match an existing translated string.
    $reverse = [];
    foreach (($all['az'] ?? []) as $k => $v) {
        if (is_string($v) && $v !== '' && !isset($reverse[$v])) $reverse[$v] = $k;
    }
    $extra = $SKY_EXTRA_I18N ?? [];
    $payload = [
        'dicts'    => $all,
        'reverse'  => $reverse,
        'literals' => $extra['literals'] ?? [],
        'ab'       => $extra['autobio'] ?? [],
    ];
    $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    return '<script>window.__SKY_I18N_DATA__ = ' . $json . ';'
         . 'window.__SKY_I18N__ = window.__SKY_I18N_DATA__.dicts;'
         . 'window.__SKY_REVERSE__ = window.__SKY_I18N_DATA__.reverse;'
         . 'window.__SKY_LITERALS__ = window.__SKY_I18N_DATA__.literals;'
         . 'window.__SKY_AB__ = window.__SKY_I18N_DATA__.ab;</script>';
}

/**
 * Render Language Switcher HTML (Desktop Header)
 */
function render_language_switcher(string $custom_class = ''): string {
    $current  = current_lang();
    $languages = all_languages();
    $curLang  = $languages[$current];

    /* ── Trigger button ─────────────────────────────────────────────── */
    $html  = '<div class="sky-lang-dropdown ' . e($custom_class) . '" id="sky-lang-selector">';
    $html .= '<button type="button" class="sky-lang-btn" id="sky-lang-btn"'
           . ' aria-haspopup="true" aria-expanded="false"'
           . ' aria-label="' . e($curLang['name']) . ' — ' . e(__('lang_switch_aria', 'Dil seçin')) . '">';

    /* Flag image — no invisible emoji text, no duplicate code rendering */
    $html .= '<span class="sky-lang-flag">'
           . '<img src="'    . e($curLang['flag_img'])   . '"'
           . ' srcset="'     . e($curLang['flag_img2x']) . ' 2x"'
           . ' alt="'        . e($curLang['flag_alt'])   . '"'
           . ' class="sky-flag-img" width="22" height="15" loading="eager">'
           . '</span>';

    /* Language code — shown exactly once */
    $html .= '<span class="sky-lang-code">' . e($curLang['short']) . '</span>';
    $html .= '<svg class="sky-lang-arrow" viewBox="0 0 24 24" width="12" height="12"'
           . ' fill="none" stroke="currentColor" stroke-width="2.5"'
           . ' stroke-linecap="round" stroke-linejoin="round">'
           . '<polyline points="6 9 12 15 18 9"></polyline></svg>';
    $html .= '</button>';

    /* ── Dropdown menu ─────────────────────────────────────────────── */
    $html .= '<div class="sky-lang-menu" id="sky-lang-menu" role="menu" aria-labelledby="sky-lang-btn">';
    foreach ($languages as $code => $lang) {
        $isActive = ($code === $current) ? 'active' : '';
        $html .= '<a href="' . e(lang_url($code)) . '"'
               . ' class="sky-lang-option ' . $isActive . '"'
               . ' role="menuitem" aria-label="' . e($lang['name']) . '"'
               . ($isActive ? ' aria-current="true"' : '') . '>';
        $html .= '<span class="sky-lang-opt-flag">'
               . '<img src="'  . e($lang['flag_img'])   . '"'
               . ' srcset="'   . e($lang['flag_img2x']) . ' 2x"'
               . ' alt="'      . e($lang['flag_alt'])   . '"'
               . ' class="sky-flag-img" width="22" height="15" loading="lazy">'
               . '</span>';
        $html .= '<span class="sky-lang-opt-name">' . e($lang['name']) . '</span>';
        $html .= '<span class="sky-lang-opt-badge">' . e($lang['short']) . '</span>';
        if ($isActive) {
            $html .= '<svg class="sky-lang-check" viewBox="0 0 24 24" width="14" height="14"'
                   . ' fill="none" stroke="var(--neon-cyan)" stroke-width="2.5"'
                   . ' stroke-linecap="round" stroke-linejoin="round">'
                   . '<polyline points="20 6 9 17 4 12"></polyline></svg>';
        }
        $html .= '</a>';
    }
    $html .= '</div>';
    $html .= '</div>';

    return $html;
}

/**
 * Render Mobile Language Selector HTML
 */
function render_mobile_language_selector(): string {
    $current   = current_lang();
    $languages = all_languages();

    $html = '<div class="sky-lang-mobile-bar" role="navigation" aria-label="' . e(__('lang_menu_aria', 'Dil seçimi')) . '">';
    foreach ($languages as $code => $lang) {
        $isActive  = ($code === $current) ? 'active' : '';
        $ariaLabel = e($lang['name']) . ($isActive ? ' — ' . e(__('lang_current_aria', 'seçilib')) : '');
        $html .= '<a href="' . e(lang_url($code)) . '"'
               . ' class="sky-lang-mobile-item ' . $isActive . '"'
               . ' aria-label="' . $ariaLabel . '"'
               . ($isActive ? ' aria-current="true"' : '') . '>';
        $html .= '<span class="sky-lang-mobile-flag">'
               . '<img src="'  . e($lang['flag_img'])   . '"'
               . ' srcset="'   . e($lang['flag_img2x']) . ' 2x"'
               . ' alt="'      . e($lang['flag_alt'])   . '"'
               . ' class="sky-flag-img" width="20" height="14" loading="lazy">'
               . '</span>';
        $html .= '<span class="sky-lang-mobile-code">' . e($lang['short']) . '</span>';
        $html .= '</a>';
    }
    $html .= '</div>';

    return $html;
}