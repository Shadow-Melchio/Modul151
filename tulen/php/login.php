<?php
require_once 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../index.html"); // Weiterleitung zum Dashboard
            exit();
        } else {
            $error = "Falscher Benutzername oder Passwort.";
        }
    } else {
        $error = "Bitte Benutzername und Passwort eingeben.";
    }
}

// Fehlermeldung ausgeben
if (!empty($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>
