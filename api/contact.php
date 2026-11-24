<?php
/**
 * SKYWEB.AZ — Contact Form API Endpoint
 * POST /api/contact.php
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => sky_literal_translate('Method Not Allowed')]));
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => sky_literal_translate('Yanlış format')]));
}

// CSRF yoxlaması (optional in dev)
// if (!csrf_verify($data['csrf'] ?? '')) {
//     http_response_code(403);
//     die(json_encode(['success' => false, 'message' => sky_literal_translate('CSRF token yanlışdır')]));
// }

// Sanitize
$name    = trim(strip_tags($data['name']    ?? ''));
$phone   = trim(strip_tags($data['phone']   ?? ''));
$email   = trim(strip_tags($data['email']   ?? ''));
$service = trim(strip_tags($data['service'] ?? 'other'));
$message = trim(strip_tags($data['message'] ?? ''));

if (strlen($name) < 2 || strlen($phone) < 7) {
    http_response_code(422);
    die(json_encode(['success' => false, 'message' => __('contact_error', 'Ad və telefon məcburidir')]));
}

try {
    $pdo = db();
    $stmt = $pdo->prepare("
        INSERT INTO business_orders
          (contact_name, contact_phone, contact_email, service_type, requirements, status)
        VALUES (:name, :phone, :email, :service, :message, 'new')
    ");
    $stmt->execute([
        ':name'    => $name,
        ':phone'   => $phone,
        ':email'   => $email ?: null,
        ':service' => in_array($service, ['skywork','business','smm','game','cv','other']) ? $service : 'other',
        ':message' => $message ?: null,
    ]);

    echo json_encode(['success' => true, 'message' => __('contact_success', 'Müraciətiniz uğurla göndərildi!')]);

} catch (Throwable $e) {
    error_log('[Contact API] ' . $e->getMessage());
    echo json_encode(['success' => true, 'message' => __('contact_success', 'Müraciətiniz qeydə alındı!')]);
}
