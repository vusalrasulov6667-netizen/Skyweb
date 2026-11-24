<?php
/**
 * SKYWEB.AZ — Standalone CV Document Viewer / Print / PDF Exporter
 * GET /modules/cv-builder/view.php?id=...&f=...
 */
require_once __DIR__ . '/../../config/config.php';

$id = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['id'] ?? '');
$folder = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['f'] ?? '');

if (!$id) {
    die(sky_literal_translate('CV tapılmadı.', CURRENT_LANG));
}

// Search in all folders or specific folder
$files = glob(__DIR__ . '/../../uploads/cvs/*/' . $id . '.html');
if (!empty($files) && file_exists($files[0])) {
    echo sky_translate_html_literals(file_get_contents($files[0]), CURRENT_LANG);
    exit;
}

if ($folder) {
    $specific = __DIR__ . '/../../uploads/cvs/' . $folder . '/' . $id . '.html';
    if (file_exists($specific)) {
        echo sky_translate_html_literals(file_get_contents($specific), CURRENT_LANG);
        exit;
    }
}

die(sky_literal_translate('CV sənədi mövcud deyil və ya silinib.', CURRENT_LANG));

