<?php
require_once 'config.php';

$errors = [];
$success = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Benutzername validieren
    if (empty($username) || strlen($username) < 3 || strlen($username) > 20 || !preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $errors[] = "Der Benutzer muss 3-20 Zeichen lang sein und darf nur Buchstaben & Zahlen enthalten.";
    }

    // E-Mail validieren
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ungültige E-Mail-Adresse.";
    }

    // Passwort validieren
    if (strlen($password) < 8) {
        $errors[] = "Das Passwort muss mindestens 8 Zeichen lang sein.";
    }
    if ($password !== $confirm) {
        $errors[] = "Die Passwörter stimmen nicht überein.";
    }

    // Existenz prüfen
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        $errors[] = "Benutzername oder E-Mail ist bereits vergeben.";
    }

    // Registrierung durchführen
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        if ($insert->execute([$username, $email, $hashed])) {
            $success = "Registrierung erfolgreich! Du kannst dich jetzt <a href='login.php'> einloggen</a>.";
        } else {
            $errors[] = "Fehler bei der Registrierung.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-container">
    <h2>Registrieren</h2>

    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $e): ?>
                <p><?= htmlspecialchars($e) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success-message"><?= $success ?></div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <label for="username">Benutzername:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Passwort:</label>
        <input type="password" id="password" name="password" required minlength="8">

        <label for="confirm_password">Passwort bestätigen:</label>
        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">

        <button type="submit">Registrieren</button>
    </form>
</div>
</body>
</html>
