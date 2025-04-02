<?php
require_once 'config.php'; // DB-Verbindung + Session starten

if (!isset($_SESSION['user_id'])) {
    // Zugriffsschutz: Nur eingeloggte Benutzer erlaubt
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Benutzer-ID aus Session

// Neues Produkt speichern (nur bei POST-Anfrage mit Name & Beschreibung)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['description'])) {
    $stmt = $pdo->prepare("
        INSERT INTO products (user_id, name, description)
        VALUES (:uid, :name, :description)
    ");

    $stmt->execute([
        'uid' => $user_id,                                 // Zuordnung zum eingeloggten Benutzer
        'name' => htmlspecialchars($_POST['name']),        // Schutz vor Script-Injection (C7)
        'description' => htmlspecialchars($_POST['description']) // ebenfalls escapen (C7)
    ]);

    header("Location: products.php"); // Nach Speichern zurück zur Seite
    exit;
}

// Produkte des eingeloggten Benutzers laden
$stmt = $pdo->prepare("
    SELECT * FROM products WHERE user_id = :uid ORDER BY created_at DESC
");
$stmt->execute(['uid' => $user_id]); // Nur Produkte des eigenen Accounts
$products = $stmt->fetchAll();       // Ergebnisse als Array laden

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
                    <a href="delete_product.php?id=<?= $p['id'] ?>"
                        onclick="return confirm('Wirklich löschen?')">Löschen</a>
                </li>
                <hr>
            <?php endforeach; ?>
        </ul>
    </div>
</body>

</html>