<?php
session_start(); 
// Session starten, um Zugriff auf Session-Daten zu bekommen

$_SESSION = []; 
// Alle Session-Variablen löschen (z. B. user_id, username, ...)

if (ini_get("session.use_cookies")) {
    // Prüfen, ob Cookies für die Session verwendet werden
    $params = session_get_cookie_params(); // Cookie-Parameter holen

    // Session-Cookie löschen (leerer Inhalt + abgelaufene Zeit)
    setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); 
// Session auf dem Server endgültig beenden (inkl. Datei löschen)

header("Location: ../index.html"); 
// Zurück zur Startseite leiten

exit();
// Sicherstellen, dass kein weiterer Code ausgeführt wird

?>
