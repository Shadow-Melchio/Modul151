<?php
require_once 'config.php'; // Stellt DB-Verbindung her + startet Session
// Session-Schutz ist bereits in config.php aktiv (C10)

if (!isset($_SESSION['user_id'])) {
// Zugriffsschutz: Nur eingeloggte Benutzer dürfen hierher
header('Location: login.php'); // Wenn nicht eingeloggt → zurück zur Loginseite
exit;
}

$user_id = $_SESSION['user_id']; // Aktuelle Benutzer-ID aus der Session lesen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Prüfen, ob das Formular abgeschickt wurde (per POST)

$current = $_POST['current_password'];     // Aktuelles Passwort
$new = $_POST['new_password'];             // Neues Passwort
$confirm = $_POST['confirm_password'];     // Passwortbestätigung

if ($new !== $confirm) {
// Abbruch, wenn neues Passwort nicht bestätigt wurde
die("Die neuen Passwörter stimmen nicht überein.");
}

// Aktuelles Passwort aus der DB holen
$stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

if (!$user || !password_verify($current, $user['password'])) {
// Überprüfen, ob aktuelles Passwort korrekt ist
die("Das aktuelle Passwort ist falsch.");
}

// Neues Passwort sicher hashen (C11)
$new_hashed = password_hash($new, PASSWORD_DEFAULT);

// Neues Passwort in die Datenbank schreiben
$update = $pdo->prepare("UPDATE users SET password = :pw WHERE id = :id");
$update->execute([
'pw' => $new_hashed,
'id' => $user_id
]);

echo "Passwort wurde erfolgreich geändert."; // Erfolgsmeldung
}
?>

