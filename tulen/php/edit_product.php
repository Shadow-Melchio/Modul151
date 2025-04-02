<?php
require_once 'config.php'; // DB-Verbindung & Session starten (in config.php)

// Nur eingeloggte Benutzer dürfen Produkte bearbeiten
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Weiterleitung zur Login-Seite
    exit;
}

$user_id = $_SESSION['user_id'];           // Benutzer-ID aus Session
$id = $_GET['id'] ?? null;                 // Produkt-ID aus URL lesen

if (!$id) {
    // Wenn keine Produkt-ID übergeben wurde → Fehler anzeigen
    die("Ungültige Anfrage.");
}

// Produkt aus DB laden, das dem aktuellen Benutzer gehört
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id AND user_id = :uid");
$stmt->execute([
    'id' => $id,
    'uid' => $user_id
]);
$product = $stmt->fetch(); // Produktdaten holen

if (!$product) {
    // Produkt gehört nicht dem Benutzer → kein Zugriff
    die("Kein Zugriff auf dieses Produkt.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Wenn Formular abgeschickt wurde → Produkt aktualisieren

    $stmt = $pdo->prepare("
        UPDATE products 
        SET name = :name, description = :description 
        WHERE id = :id AND user_id = :uid
    ");

    $stmt->execute([
        'name' => htmlspecialchars($_POST['name']),               // Schutz vor XSS (C7)
        'description' => htmlspecialchars($_POST['description']), // Schutz vor XSS
        'id' => $id,
        'uid' => $user_id
    ]);

    header("Location: products.php"); // Zurück zur Produktübersicht
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
