<?php
require_once './config.php'; // Verbindung zur Datenbank

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Fehler-Array für Validierung
    $errors = [];

    // Überprüfe, ob alle Felder ausgefüllt sind
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "Alle Felder müssen ausgefüllt werden.";
    }

    // Prüfe, ob die E-Mail-Adresse gültig ist
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ungültige E-Mail-Adresse.";
    }

    // Prüfe, ob die Passwörter übereinstimmen
    if ($password !== $confirmPassword) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Prüfe, ob das Passwort sicher genug ist (mindestens 8 Zeichen)
    if (strlen($password) < 8) {
        $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }

    // Prüfe, ob der Benutzername oder die E-Mail bereits existiert
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $errors[] = "Benutzername oder E-Mail bereits vergeben.";
    }

    // Wenn keine Fehler aufgetreten sind, registriere den Benutzer
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Passwort sicher hashen

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $passwordHash])) {
            header("Location: ../login.html"); // Erfolgreich registriert
            exit();
        } else {
            $errors[] = "Fehler bei der Registrierung.";
        }
    }
}

// Falls Fehler vorhanden sind, diese anzeigen
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
