<?php
require_once 'config.php'; // session_start() ist schon enthalten

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.html');
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];

    if ($new !== $confirm) {
        die("Die neuen Passwörter stimmen nicht überein.");
    }

    // Aktuelles Passwort aus DB holen
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current, $user['password'])) {
        die("Das aktuelle Passwort ist falsch.");
    }

    // Neues Passwort hashen
    $new_hashed = password_hash($new, PASSWORD_DEFAULT);

    // Neues Passwort in DB speichern
    $update = $pdo->prepare("UPDATE users SET password = :pw WHERE id = :id");
    $update->execute(['pw' => $new_hashed, 'id' => $user_id]);

    echo "Passwort wurde erfolgreich geändert.";
}
?>

