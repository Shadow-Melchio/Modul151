<?php
require_once './config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = []; // Array für Fehlermeldungen

    // Benutzereingaben bereinigen
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Benutzername validieren
    if (empty($username) || strlen($username) < 3 || strlen($username) > 20 || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors[] = "Der Benutzername muss 3-20 Zeichen lang sein und darf nur Buchstaben & Zahlen enthalten.";
    }

    // E-Mail validieren
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ungültige E-Mail-Adresse.";
    }

    // Passwort validieren
    if (strlen($password) < 8) {
        $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Prüfen, ob Benutzername oder E-Mail schon existieren
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $errors[] = "Benutzername oder E-Mail ist bereits vergeben.";
    }

    // Wenn keine Fehler, Benutzer speichern
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $passwordHash])) {
            $_SESSION['success'] = "Registrierung erfolgreich! Du kannst dich nun einloggen.";
            header("Location: ../login.html");
            exit();
        } else {
            $errors[] = "Fehler bei der Registrierung.";
        }
    }
}

// Fehlermeldungen ausgeben
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
