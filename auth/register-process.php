<?php
/**
 * SKYWEB.AZ — Qeydiyyat Prosesi
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Yanlış sorğu metodu.')]);
    exit;
}

// CSRF yoxlanışı
$csrf = $_POST['csrf'] ?? '';
if (!csrf_verify($csrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Təhlükəsizlik xətası (CSRF). Səhifəni yeniləyin.')]);
    exit;
}

$fullname = trim($_POST['fullname'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$phone = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$role = 'user';

// Sadə validasiyalar
if (empty($fullname) || empty($email) || empty($phone) || empty($password) || empty($password_confirm)) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Zəhmət olmasa bütün məcburi sahələri doldurun.')]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Düzgün e-poçt ünvanı daxil edin.')]);
    exit;
}

// Telefon formatı üçün sadə tənzimləmə (+994 və rəqəmlər)
$phone_cleaned = preg_replace('/[^0-9+]/', '', $phone);
if (strlen($phone_cleaned) < 9) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Düzgün telefon nömrəsi daxil edin (Məs. +994 50 123 45 67).')]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Şifrə minimum 6 simvoldan ibarət olmalıdır.')]);
    exit;
}

if ($password !== $password_confirm) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Şifrələr eyni deyil.')]);
    exit;
}

try {
    $pdo = db();
    
    // E-poçt və ya Telefon dublikat yoxlanışı
    $stmt = $pdo->prepare("SELECT id, email, phone FROM users WHERE email = ? OR phone = ?");
    $stmt->execute([$email, $phone_cleaned]);
    $existingUser = $stmt->fetch();
    
    if ($existingUser) {
        if ($existingUser['email'] === $email) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Bu e-poçt ünvanı ilə artıq qeydiyyatdan keçilib.')]);
        } else {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Bu telefon nömrəsi ilə artıq qeydiyyatdan keçilib.')]);
        }
        exit;
    }
    
    // Şifrənin heşlənməsi
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // Default preset avatar
    $avatar_preset = 'preset:avatar1';
    
    // Verilənlər bazasına yazmaq
    $stmt = $pdo->prepare("INSERT INTO users (fullname, email, phone, password_hash, role, avatar_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$fullname, $email, $phone_cleaned, $password_hash, $role, $avatar_preset]);
    
    $userId = $pdo->lastInsertId();
    
    // Avtomatik login
    $user_data = [
        'id' => $userId,
        'fullname' => $fullname,
        'email' => $email,
        'phone' => $phone_cleaned,
        'role' => $role,
        'avatar_url' => $avatar_preset
    ];
    
    $_SESSION['user_id'] = $userId;
    $_SESSION['user'] = $user_data;
    
    echo json_encode([
        'success' => true,
        'message' => sky_literal_translate('Qeydiyyat uğurla tamamlandı! Yönləndirilirsiniz...'),
        'redirect' => SITE_URL . '/index.php'
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Sistem xətası baş verdi: ') . $e->getMessage()]);
}
