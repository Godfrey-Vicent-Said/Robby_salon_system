<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kupata path sahihi ya faili la SQLite kule AWS
$db_path = __DIR__ . '/salon.db';

try {
    $pdo = new PDO("sqlite:" . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Kutengeneza tables moja kwa moja zisilete crash
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE,
        password TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS customers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        phone TEXT,
        service TEXT
    )");

    // Kuweka user 'Robby' moja kwa moja
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (username, password) VALUES ('Robby', '12345')");
    $stmt->execute();

} catch (Exception $e) {
    $pdo = null;
}

// Ulinzi wa Data (AES-256-CBC) kama maelekezo ya kozi yanavyotaka[cite: 1]
define('ENCRYPTION_KEY', 'CBE_bit2_secret_key_2026!!@@');
define('ENCRYPTION_METHOD', 'AES-256-CBC');
define('SECRET_IV', '1234567890123456');

function encryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    return base64_encode(openssl_encrypt($data, ENCRYPTION_METHOD, $key, 0, $iv));
}

function decryptData($data) {
    $key = hash('sha256', ENCRYPTION_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    return openssl_decrypt(base64_decode($data), ENCRYPTION_METHOD, $key, 0, $iv);
}
