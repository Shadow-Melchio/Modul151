<?php
// Startet die Session mit Sicherheitsoptionen
session_start([
    'cookie_lifetime' => 0,         // Session endet beim Schließen des Browsers
    'cookie_secure' => true,        // Nur über HTTPS senden (aktiv nur mit SSL)
    'cookie_httponly' => true,      // Kein Zugriff über JavaScript (Schutz vor XSS)
    'cookie_samesite' => 'Strict'   // Schutz vor CSRF (keine Fremdseiten-Zugriffe)
]);

// Datenbank-Verbindungsdaten
$dsn = 'mysql:host=localhost;dbname=3d_druck_shop;charset=utf8mb4'; // Datenbankname + Zeichensatz
$user = 'druckshop';         // Eingeschränkter DB-Benutzer (C12)
$password = 'modul151';      // Passwort des DB-Benutzers

try {
    // Erstellt eine neue PDO-Datenbankverbindung
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,         // Fehler als Ausnahme werfen (für sauberes Fehlerhandling)
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC     // Datenbankergebnisse als assoziatives Array zurückgeben
    ]);
} catch (PDOException $e) {
    // Wenn Verbindung fehlschlägt → Fehler ausgeben & Script abbrechen
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>
