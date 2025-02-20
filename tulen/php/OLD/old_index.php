<?php
require 'auth.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Startseite</title>
</head>
<body>
    <h1>Willkommen</h1>
    <p>Sie sind eingeloggt.</p>
    <a href="logout.php">Abmelden</a>
</body>
</html>
