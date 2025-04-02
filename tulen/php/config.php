<?php
session_start([
    'cookie_lifetime' => 0, // Session wird gelöscht, wenn der Browser geschlossen wird
    'cookie_secure' => true, // Nur über HTTPS senden
    'cookie_httponly' => true, // Kein Zugriff über JavaScript
    'cookie_samesite' => 'Strict' // Verhindert CSRF-Angriffe
]);

$dsn = 'mysql:host=localhost;dbname=3d_druck_shop;charset=utf8mb4';
$user = 'druckshop';
$password = 'modul151';

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>
