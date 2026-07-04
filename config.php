<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kupata path sahihi ya faili lako la salon.db kule AWS
$db_path = __DIR__ . '/salon.db';

try {
    // Database connectivity kwa kutumia PDO (SQLite) kama maelekezo yanavyotaka
    $pdo = new PDO("sqlite:" . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Kutengeneza table ya wateja na users kama hazipo
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

    // Kuweka user wa majaribio (Bypass tunaihamishia kwenye DB)
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO users (username, password) VALUES ('Robby', '12345')");
    $stmt->execute();

} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// MAELEKEZO YA ASSIGNMENT: Encryption & Decryption (AES-256-CBC)
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
