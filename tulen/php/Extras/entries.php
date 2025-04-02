<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Neuen Eintrag speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titel'], $_POST['inhalt'])) {
    $stmt = $pdo->prepare("INSERT INTO eintraege (user_id, titel, inhalt) VALUES (:uid, :titel, :inhalt)");
    $stmt->execute([
        'uid' => $user_id,
        'titel' => htmlspecialchars($_POST['titel']),
        'inhalt' => htmlspecialchars($_POST['inhalt']),
    ]);
    header("Location: entries.php");
    exit;
}

// Einträge des Benutzers laden
$stmt = $pdo->prepare("SELECT * FROM eintraege WHERE user_id = :uid ORDER BY erstellt_am DESC");
$stmt->execute(['uid' => $user_id]);
$eintraege = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Meine Einträge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-container">
    <h2>Neuen Eintrag hinzufügen</h2>
    <a href="./main.php">Back</a>
    <form method="post">
        <label>Titel</label>
        <input type="text" name="titel" required>
        <label>Inhalt</label>
        <textarea name="inhalt" required></textarea>
        <button type="submit">Speichern</button>
    </form>

    <h2>Meine Einträge</h2>
    <ul>
        <?php foreach ($eintraege as $e): ?>
            <li>
                <strong><?= htmlspecialchars($e['titel']) ?></strong><br>
                <?= nl2br(htmlspecialchars($e['inhalt'])) ?><br>
                <small><?= $e['erstellt_am'] ?></small><br>
                <a href="edit_entry.php?id=<?= $e['id'] ?>">Bearbeiten</a> |
                <a href="delete_entry.php?id=<?= $e['id'] ?>" onclick="return confirm('Wirklich löschen?')">Löschen</a>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
