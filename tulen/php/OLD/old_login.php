<?php
require 'auth.php';
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (loginUser($username, $password)) {
        header("Location: home.html");
        exit;
    } else {
        $message = 'Ungültiger Benutzername oder Passwort';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Anmelden</title>
</head>
<body>
    <h1>Anmelden</h1>
    <form method="post">
        Benutzername: <input type="text" name="username" required><br>
        Passwort: <input type="password" name="password" required><br>
        <input type="submit" value="Anmelden">
    </form>
    <p><?php echo $message; ?></p>
    <p>Haben Sie sich schon registriert? <a href="register.php">Registrieren</a></p> <!-- Link zur Registrierungsseite -->
</body>
</html>
