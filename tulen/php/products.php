<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Save new product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description'])) {
    $stmt = $pdo->prepare("INSERT INTO products (user_id, name, description) VALUES (:uid, :name, :description)");
    $stmt->execute([
        'uid' => $user_id,
        'name' => htmlspecialchars($_POST['name']),
        'description' => htmlspecialchars($_POST['description']),
    ]);
    header("Location: products.php");
    exit;
}

// Load user's products
$stmt = $pdo->prepare("SELECT * FROM products WHERE user_id = :uid ORDER BY created_at DESC");
$stmt->execute(['uid' => $user_id]);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Meine Produkte</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-container">
    <h2>Produkt hinzufügen</h2>
    <form method="post">
        <label>Produktname</label>
        <input type="text" name="name" required>
        <label>Beschreibung</label>
        <textarea name="description" required></textarea>
        <button type="submit">Speichern</button>
        
    </form>
    <a href="./main.php" class="button">Zurück</a>
    
    <ul>
        <?php foreach ($products as $p): ?>
            <li>
                <strong><?= htmlspecialchars($p['name']) ?></strong><br>
                <?= nl2br(htmlspecialchars($p['description'])) ?><br>
                <small>Erstellt am: <?= $p['created_at'] ?></small><br>
                <a href="edit_product.php?id=<?= $p['id'] ?>">Bearbeiten</a> |
                <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Wirklich löschen?')">Löschen</a>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
