<?php
//require 'session_check.php';
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Produkte laden
$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->execute(['uid' => $user_id]);
$products = $stmt->fetchAll();
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
            <h1><a href="./main.php">Tulen</a> by Marco Frey - Modul 151</h1>
            <nav id="nav">
                <ul>
                    <li><a href="./main.php">Home</a></li>
                    <li>
                        <a href="./products.php">Edit Products</a>
                        <a href="./settings.php">Settings</a>
                    </li>
                    <li><a href="logout.php" class="button">Logout</a></li>
                </ul>
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <h2>Tulen</h2>
            <p>Herzlich Wilkommen! Du bist nun eingelogt lul</p>
            <ul class="actions special">

            </ul>
        </section>

        <!-- Main -->
        <section id="main" class="container">

            <section class="box special">
                <header class="major">
                    <h2>Introducing the ultimate mobile app
                        <br />
                        for doing stuff with your phone
                    </h2>
                    <p>Blandit varius ut praesent nascetur eu penatibus nisi risus faucibus nunc ornare<br />
                        adipiscing nunc adipiscing. Condimentum turpis massa.</p>
                </header>
                <span class="image featured"><img src="images/pic01.jpg" alt="" /></span>
            </section>

            <section class="box special features">
                <div class="features-row">
                    <section>
                        <span class="icon solid major fa-bolt accent2"></span>
                        <h3>Magna etiam</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                    </section>
                    <section>
                        <span class="icon solid major fa-chart-area accent3"></span>
                        <h3>Ipsum dolor</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                    </section>
                </div>
                <div class="features-row">
                    <section>
                        <span class="icon solid major fa-cloud accent4"></span>
                        <h3>Sed feugiat</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                    </section>
                    <section>
                        <span class="icon solid major fa-lock accent5"></span>
                        <h3>Enim phasellus</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                    </section>
                </div>
            </section>

            <div class="row">
                <div class="col-6 col-12-narrower">

                    <section class="box special">
                        <span class="image featured"><img src="images/pic02.jpg" alt="" /></span>
                        <h3>Sed lorem adipiscing</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                        <ul class="actions special">
                            <li><a href="#" class="button alt">Learn More</a></li>
                        </ul>
                    </section>

                </div>
                <div class="col-6 col-12-narrower">

                    <section class="box special">
                        <span class="image featured"><img src="images/pic03.jpg" alt="" /></span>
                        <h3>Accumsan integer</h3>
                        <p>Integer volutpat ante et accumsan commophasellus sed aliquam feugiat lorem aliquet ut enim
                            rutrum phasellus iaculis accumsan dolore magna aliquam veroeros.</p>
                        <ul class="actions special">
                            <li><a href="#" class="button alt">Learn More</a></li>
                        </ul>
                    </section>

                </div>
            </div>

        </section>

        <!-- UserDetails -->
        <section id="UserDetails">
            <h2>Passwort ändern</h2>
            <div class="form-container">
                <div class="row gtr-50 gtr-uniform">
                    <div class="col-8 col-12-mobilep">
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
                </div>

        </section>
        <br>
        <br>
        <section class="form-container">
            <h2>Meine Produkte</h2>
            <?php if (count($products) === 0): ?>
                <p>Du hast noch keine Produkte erstellt.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($products as $p): ?>
                        <li>
                            <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                            <?= nl2br(htmlspecialchars($p['description'])) ?><br>
                            <small>Erstellt am: <?= $p['created_at'] ?></small>
                        </li>
                        <hr>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
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