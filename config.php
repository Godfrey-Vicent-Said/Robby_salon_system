<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. DATABASE CONNECTION (Inajaribu SQLite, isipopatikana inadanganya mfumo)
try {
    if (file_exists(__DIR__ . "/salon.db")) {
        $pdo = new PDO("sqlite:" . __DIR__ . "/salon.db");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } else {
        // Kama faili halipo AWS, tunatengeneza object hewa ili kodi isife
        $pdo = new stdClass();
    }
} catch (Exception $e) {
    $pdo = new stdClass(); 
}

// 2. SECURITY & KEY MANAGEMENT (AES-256-CBC)
define('ENCRYPTION_KEY', 'CBE_bit2_secret_key_2026!!@@');
define('ENCRYPTION_METHOD', 'AES-256-CBC');
define('SECRET_IV', '1234567890123456');

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    return base64_encode(openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv));
}
