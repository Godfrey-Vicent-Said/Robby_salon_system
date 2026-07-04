<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. DATABASE CONNECTION (SQLITE - Inasoma faili la salon.db)
try {
    // __DIR__ inahakikisha faili linatafutwa kwenye folda lile lile la config.php
    $pdo = new PDO("sqlite:" . __DIR__ . "/salon.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
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
