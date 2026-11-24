<?php
/**
 * SKYWEB.AZ — Giriş Prosesi
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

$email_or_phone = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email_or_phone) || empty($password)) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('E-poçt / telefon və şifrə sahələrini doldurun.')]);
    exit;
}

try {
    $pdo = db();
    
    // Daxil edilən məlumatın e-poçt və ya telefon nömrəsi olduğunu təyin etmək
    // Telefon nömrəsi sadəcə rəqəmlərdən və + işarəsindən ibarət ola bilər
    $is_email = filter_var($email_or_phone, FILTER_VALIDATE_EMAIL);
    
    if ($is_email) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([strtolower($email_or_phone)]);
    } else {
        // Telefon nömrəsindən simvolları təmizləmək
        $phone_cleaned = preg_replace('/[^0-9+]/', '', $email_or_phone);
        $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->execute([$phone_cleaned]);
    }
    
    $user = $stmt->fetch();
    
    if (!$user || !password_verify($password, $user['password_hash'])) {
        echo json_encode(['success' => false, 'message' => sky_literal_translate('E-poçt/telefon və ya şifrə yanlışdır.')]);
        exit;
    }
    
    // Sessiyanı qurmaq
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user'] = [
        'id' => $user['id'],
        'fullname' => $user['fullname'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'role' => $user['role'],
        'avatar_url' => $user['avatar_url']
    ];
    
    echo json_encode([
        'success' => true,
        'message' => sky_literal_translate('Giriş uğurla tamamlandı! Yönləndirilirsiniz...'),
        'redirect' => SITE_URL . '/index.php'
    ]);
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Giriş zamanı xəta baş verdi: ') . $e->getMessage()]);
}
