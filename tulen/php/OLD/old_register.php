<?php
require 'config.php'; // Enthält Datenbankverbindungsdaten
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: login.php");
        exit;
    } else {
        $message = "Fehler: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrieren</title>
</head>
<body>
    <h1>Registrieren</h1>
    <form method="post">
        Benutzername: <input type="text" name="username" required><br>
        Passwort: <input type="password" name="password" required><br>
        <input type="submit" value="Registrieren">
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
