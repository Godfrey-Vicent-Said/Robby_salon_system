<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tumeondoa database connection kabisa ili isilete error kule AWS!
$pdo = null; 

// Ma-setting ya ulinzi na encryption (AES-256-CBC)
define('ENCRYPTION_KEY', 'CBE_bit2_secret_key_2026!!@@');
define('ENCRYPTION_METHOD', 'AES-256-CBC');
define('SECRET_IV', '1234567890123456');

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    return base64_encode(openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv));
}
