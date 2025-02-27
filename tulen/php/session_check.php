<?php

// Prüfen, ob Benutzer angemeldet ist
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

// Zusätzlicher Schutz gegen Session-Hijacking
if (!isset($_SESSION['ip']) || $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
    session_destroy();
    header("Location: ../index.html");
    exit();
}

// Prüfen, ob User-Agent übereinstimmt (erschwert Hijacking)
if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    header("Location: ../index.html");
    exit();
}

// Zeitüberschreitung (optional)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) { // 30 Minuten Inaktivität
    session_destroy();
    header("Location: ../index.html");
    exit();
}
$_SESSION['last_activity'] = time();
?>
