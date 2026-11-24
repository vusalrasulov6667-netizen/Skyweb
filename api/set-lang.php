<?php
/**
 * SKYWEB.AZ — Language Switch Sync Endpoint
 * Called silently via fetch() by SkyI18n.js
 * Accepts POST { lang: "ru" } and writes to session + cookie
 */
require_once __DIR__ . "/../config/config.php";

header("Content-Type: application/json; charset=utf-8");
header("X-Content-Type-Options: nosniff");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "Method not allowed"]);
    exit;
}

$lang = null;
$raw = file_get_contents("php://input");
if (!empty($raw)) {
    $body = json_decode($raw, true);
    $lang = $body["lang"] ?? null;
}
if (!$lang && isset($_POST["lang"])) {
    $lang = $_POST["lang"];
}

$supported = ["az", "ru", "en", "tr"];

if (!$lang || !in_array($lang, $supported, true)) {
    http_response_code(400);
    echo json_encode(["ok" => false, "error" => "Invalid language code"]);
    exit;
}

$_SESSION["sky_lang"] = $lang;
setcookie("sky_lang", $lang, time() + (86400 * 30), "/", "", false, false);

echo json_encode(["ok" => true, "lang" => $lang]);
