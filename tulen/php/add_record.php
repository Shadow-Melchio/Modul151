<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    if (!$title || !$description || !$price) {
        $error = "Bitte alle Felder ausfüllen.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (user_id, title, description, price) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$_SESSION['user_id'], $title, $description, $price])) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Fehler beim Speichern des Produkts.";
        }
    }
}
?>
<form action="add_product.php" method="post">
  <label for="title">Produktname:</label>
  <input type="text" id="title" name="title" required>
  
  <label for="description">Beschreibung:</label>
  <textarea id="description" name="description" required></textarea>
  
  <label for="price">Preis (€):</label>
  <input type="number" id="price" name="price" required step="0.01">
  
  <button type="submit">Produkt hinzufügen</button>
</form>
