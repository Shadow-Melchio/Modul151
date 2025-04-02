<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Ungültige Anfrage.");
}

// Load user's product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id AND user_id = :uid");
$stmt->execute(['id' => $id, 'uid' => $user_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Kein Zugriff auf dieses Produkt.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description WHERE id = :id AND user_id = :uid");
    $stmt->execute([
        'name' => htmlspecialchars($_POST['name']),
        'description' => htmlspecialchars($_POST['description']),
        'id' => $id,
        'uid' => $user_id
    ]);
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Produkt bearbeiten</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-container">
    <h2>Produkt bearbeiten</h2>
    <form method="post">
        <label>Produktname</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        <label>Beschreibung</label>
        <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        <button type="submit">Speichern</button>
    </form>
</div>
</body>
</html>
