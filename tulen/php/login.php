<?php
require_once './config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "Benutzername und Passwort müssen ausgefüllt sein.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // **Session-Fixation verhindern**
            session_regenerate_id(true);

            // **Sichere Session-Daten setzen**
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['ip'] = $_SERVER['REMOTE_ADDR']; // IP-Adresse speichern
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT']; // User-Agent speichern
            $_SESSION['last_activity'] = time(); // Letzte Aktivität speichern

            header("Location: ../main.html");
            exit();
        } else {
            $errors[] = "Falscher Benutzername oder Passwort.";
        }
    }
}

// Fehler anzeigen
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>
