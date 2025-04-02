<?php
// Verbindung + Session starten
require_once 'config.php';

// Zugriffsschutz: Nur eingeloggte User dürfen auf die Seite
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Umleitung zur Login-Seite
    exit(); // Stoppt weitere Ausführung
}

// Benutzer-ID aus Session holen
$user_id = $_SESSION['user_id'];

// Alle Produkte vom aktuellen Benutzer laden
$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = :uid ORDER BY created_at DESC");
// SQL vorbereiten: nur eigene Produkte, sortiert nach Datum (neueste zuerst)

$stmt->execute(['uid' => $user_id]);
// Ausführen mit Benutzer-ID (verhindert SQL-Injection)

$products = $stmt->fetchAll();
// Ergebnisse als Array speichern → wird im HTML angezeigt
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Tulen</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css" />
</head>

<body class="landing is-preload">
    <id="page-wrapper">

        <!-- Header -->
        <header id="header" class="alt">
            <h1><a href="./main.php">Tulen.ch</a> - Marco Frey / Florian Brügger - Modul 151</h1>
            <nav id="nav">
                <ul>
                    <li><a href="./main.php">Home</a></li>
                    <li>
                        <a href="./products.php">Edit Products</a>
                    </li>
                    <li><a href="logout.php" class="button">Logout</a></li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner" style="background-image: url('../images/banner.jpg');">
            
            <h2>Tulen.ch</h2>
            <p>Herzlich Wilkommen! Du bist nun eingelogt :D</p>
            <ul class="actions special">
            </ul>
        </section>

        <!-- Main -->
        <section id="main" class="container">

            <section class="box special">
                <header class="major">
                    <h2>Passwort ändern</h2>
                    <p>Hier kannst du dein aktuelles Passwort ändern</p>
                </header>

                <div class="form-container">
                    <form method="post" action="change_password.php">
                        <label for="current_password">Aktuelles Passwort:</label>
                        <input type="password" id="current_password" name="current_password" required>

                        <label for="new_password">Neues Passwort:</label>
                        <input type="password" id="new_password" name="new_password" required minlength="8">

                        <label for="confirm_password">Neues Passwort bestätigen:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">

                        <button type="submit">Passwort ändern</button>
                    </form>
                </div>
            </section>


            <section class="box special features">
                <h2 style="text-align: center;">Meine Produkte</h2>
                <?php if (count($products) === 0): ?>
                    <p style="text-align: center;">Du hast noch keine Produkte erstellt.</p>
                <?php else: ?>
                    <div class="features-row">
                        <?php foreach ($products as $p): ?>
                            <section>
                                <span class="icon solid major fa-cube accent2"></span>
                                <h3><?= htmlspecialchars($p['name']) ?></h3>
                                <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>
                                <small>Erstellt am: <?= $p['created_at'] ?></small>
                            </section>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>


            <div class="row">
                <div class="col-6 col-12-narrower">

                    <section class="box special">
                        <span class="image featured"><img src="images/pic02.jpg" alt="" /></span>
                        <h3>Logout</h3>
                        <p>Hier kannst du dich ausloggen. Presse den Button :D</p>
                        <ul class="actions special">
                            <li><a href="#" class="button alt">Abmelden</a></li>
                        </ul>
                    </section>

                </div>
                <div class="col-6 col-12-narrower">

                    <section class="box special">
                        <span class="image featured"><img src="images/pic03.jpg" alt="" /></span>
                        <h3>Edit Products</h3>
                        <p>Hier kannst du deine Produkte bearbeiten / erstellen :D</p>
                        <ul class="actions special">
                            <li><a href="products.php" class="button alt">Editieren</a></li>
                        </ul>
                    </section>

                </div>
            </div>

        </section>
        </div>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery.dropotron.min.js"></script>
        <script src="assets/js/jquery.scrollex.min.js"></script>
        <script src="assets/js/browser.min.js"></script>
        <script src="assets/js/breakpoints.min.js"></script>
        <script src="assets/js/util.js"></script>
        <script src="assets/js/main.js"></script>

</body>

</html>