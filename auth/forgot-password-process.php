<?php
/**
 * SKYWEB.AZ — Şifrə Bərpa Prosesi
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Yanlış sorğu metodu.')]);
    exit;
}

// CSRF check
$csrf = $_POST['csrf'] ?? '';
if (!csrf_verify($csrf)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Təhlükəsizlik xətası (CSRF). Səhifəni yeniləyin.')]);
    exit;
}

$action = trim($_POST['action'] ?? '');

try {
    $pdo = db();
    
    if ($action === 'send_code') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        
        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Zəhmət olmasa e-poçt ünvanınızı daxil edin.')]);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Düzgün e-poçt ünvanı daxil edin.')]);
            exit;
        }
        
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Bu e-poçt ünvanı ilə qeydiyyatdan keçmiş istifadəçi tapılmadı.')]);
            exit;
        }
        
        // Generate 6-digit code
        $code = sprintf("%06d", mt_rand(0, 999999));
        
        // Delete previous codes
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);
        
        // Save code to database
        $expires_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        $stmt = $pdo->prepare("INSERT INTO password_resets (email, code, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $code, $expires_at]);
        
        // Mock send email by logging it to sent_emails.txt in the root of the project
        $log_file = __DIR__ . '/../sent_emails.txt';
        $timestamp = date('Y-m-d H:i:s');
        $email_body = sky_literal_translate('Salam,') . "\n\n" . sky_literal_translate('Skyweb.az hesabınız üçün şifrə bərpa kodu: ') . $code . "\n\n" . sky_literal_translate('Bu kod 15 dəqiqə ərzində etibarlıdır.') . "\n";
        
        $log_content = "====================================================\n";
        $log_content .= sky_literal_translate('Tarix:') . " $timestamp\n";
        $log_content .= sky_literal_translate('Kimə: ') . "$email\n";
        $log_content .= sky_literal_translate('Mövzu: Skyweb.az — Şifrə bərpa kodu') . "\n";
        $log_content .= sky_literal_translate('Mətn:') . "\n$email_body";
        $log_content .= "====================================================\n\n";
        
        file_put_contents($log_file, $log_content, FILE_APPEND);
        
        // Also try standard mail() in case environment supports it
        $headers = "From: " . SITE_EMAIL . "\r\n" .
                   "Reply-To: " . SITE_EMAIL . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n" .
                   "X-Mailer: PHP/" . phpversion();
        @mail($email, sky_literal_translate('Skyweb.az — Sifre berpa kodu'), $email_body, $headers);
        
        echo json_encode([
            'success' => true,
            'message' => sky_literal_translate('Bərpa təsdiq kodu e-poçt ünvanınıza göndərildi. Zəhmət olmasa yoxlayın.')
        ]);
        exit;
        
    } elseif ($action === 'verify_code') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $code = trim($_POST['code'] ?? '');
        
        if (empty($email) || empty($code)) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('E-poçt və təsdiq kodu daxil edilməlidir.')]);
            exit;
        }
        
        // Verify code in DB
        $stmt = $pdo->prepare("SELECT id FROM password_resets WHERE email = ? AND code = ? AND expires_at > NOW()");
        $stmt->execute([$email, $code]);
        $reset = $stmt->fetch();
        
        if (!$reset) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('Daxil etdiyiniz təsdiq kodu yanlışdır və ya müddəti bitib.')]);
            exit;
        }
        
        // Store verification flags in session
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_verified'] = true;
        
        echo json_encode([
            'success' => true,
            'message' => sky_literal_translate('Təsdiq kodu doğrulandı! İndi yeni şifrənizi təyin edə bilərsiniz.')
        ]);
        exit;
        
    } elseif ($action === 'reset_password') {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        
        // Verify session flags
        if (empty($_SESSION['reset_verified']) || $_SESSION['reset_verified'] !== true || empty($_SESSION['reset_email']) || $_SESSION['reset_email'] !== $email) {
            echo json_encode(['success' => false, 'message' => sky_literal_translate('İcazəsiz əməliyyat. Yenidən cəhd edin.')]);
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
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Update user password in DB
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
        $stmt->execute([$password_hash, $email]);
        
        // Clear password resets
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);
        
        // Unset session flags
        unset($_SESSION['reset_verified']);
        unset($_SESSION['reset_email']);
        
        echo json_encode([
            'success' => true,
            'message' => sky_literal_translate('Şifrəniz uğurla yeniləndi! Giriş səhifəsinə yönləndirilirsiniz...'),
            'redirect' => 'login.php'
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => sky_literal_translate('Naməlum fəaliyyət.')]);
        exit;
    }
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => sky_literal_translate('Xəta baş verdi: ') . $e->getMessage()]);
}
