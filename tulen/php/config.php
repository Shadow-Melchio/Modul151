<?php
$dsn = 'mysql:host=localhost;dbname=3d_druck_shop;charset=utf8mb4';
$user = 'root'; // Falls du XAMPP nutzt, ist der Standardbenutzer "root"
$password = ''; // Falls du XAMPP nutzt, ist das Standardpasswort leer

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>
