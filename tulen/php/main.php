<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit();
}

echo "<h2>Willkommen, " . htmlspecialchars($_SESSION['username']) . "!</h2>";
echo "<p>Hier sind alle Produkte:</p>";

// Produkte aus Datenbank abrufen
$stmt = $pdo->query("SELECT * FROM products");
while ($product = $stmt->fetch()) {
    echo "<div><h3>" . htmlspecialchars($product['title']) . "</h3><p>" . htmlspecialchars($product['description']) . "</p><p>Preis: " . htmlspecialchars($product['price']) . "€</p></div>";
}

// Logout-Link
echo '<p><a href="./logout.php">Abmelden</a></p>';
?>
