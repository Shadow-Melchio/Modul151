<?php
require_once 'config.php'; // DB-Verbindung & Session starten (in config.php)

// Zugriffsschutz: Nur eingeloggte Benutzer dürfen löschen
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Weiterleitung zur Login-Seite
    exit;
}

$user_id = $_SESSION['user_id']; // Benutzer-ID aus der Session
$id = $_GET['id'] ?? null;        // Produkt-ID aus URL (GET) lesen

if (!$id) {
    // Falls keine ID übergeben wurde → Fehler ausgeben
    die("Ungültige Anfrage.");
}

// Nur das Produkt löschen, das dem eingeloggten Benutzer gehört
$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id AND user_id = :uid");
// SQL-Injection-Schutz durch prepare()

$stmt->execute([
    'id' => $id,         // Produkt-ID aus URL
    'uid' => $user_id    // Benutzer-ID aus Session (Zugriffskontrolle)
]);

// Nach dem Löschen zurück zur Produktseite
header("Location: products.php");
exit;
?>
