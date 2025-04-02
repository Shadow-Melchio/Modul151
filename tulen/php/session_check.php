<?php
// Prüfen, ob Benutzer angemeldet ist (Session vorhanden)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html"); // Weiterleitung zur Startseite
    exit();
}

// Schutz: IP-Adresse muss gleich bleiben → erschwert Session-Hijacking (C10)
if (!isset($_SESSION['ip']) || $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
    session_destroy(); // Session beenden
    header("Location: ../index.html"); // Zurück zur Startseite
    exit();
}

// Schutz: Browserkennung (User-Agent) muss gleich bleiben → weitere Hijacking-Sicherung
if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    header("Location: ../index.html");
    exit();
}

// Inaktivitäts-Timeout prüfen (optional, hier: 30 Minuten)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) {
    session_destroy(); // Session abgelaufen → löschen
    header("Location: ../index.html");
    exit();
}

// Letzte Aktivität aktualisieren
$_SESSION['last_activity'] = time();
?>
