<?php
require_once 'config.php'; // Stellt DB-Verbindung her + startet Session
// Sicherheitsoptionen sind in config.php enthalten (C10)

$error = null; // Variable zur Anzeige von Fehlermeldungen

// Prüfung: Wurde das Formular per POST abgeschickt?
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username']); // Benutzereingabe bereinigen (Leerzeichen entfernen)
    $password = $_POST['password'];       // Passwort aus POST lesen

    if (empty($username) || empty($password)) {
        // Eingabefelder dürfen nicht leer sein
        $error = "Benutzername und Passwort müssen ausgefüllt sein.";
    } else {
        // Benutzer anhand des Benutzernamens aus DB holen
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Passwort ist korrekt → Login erfolgreich

            session_regenerate_id(true); // Session-ID regenerieren (Schutz vor Session-Fixation) (C10)

            // Wichtige Session-Variablen setzen
            $_SESSION['user_id'] = $user['id'];                     // Benutzer-ID
            $_SESSION['username'] = $user['username'];              // Benutzername
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];              // IP-Adresse speichern
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];  // Browserkennung speichern
            $_SESSION['last_activity'] = time();                    // Zeitpunkt letzter Aktivität

            header("Location: main.php"); // Weiterleitung zur Hauptseite
            exit;
        } else {
            // Benutzer nicht gefunden oder Passwort falsch
            $error = "Benutzer oder Passwort ist falsch.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Anmelden</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="form-container">
        <h2>Anmelden</h2>

        <?php if ($error): ?> <!-- hmtlspecialchars verhindert böse injections!!! -->
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="login.php">
            <div class="input-group">
                <label for="username">Benutzername</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Passwort</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Anmelden</button>
            <a href="register.html" class="button">Registrieren</a>
        </form>
    </div>
</body>

</html>