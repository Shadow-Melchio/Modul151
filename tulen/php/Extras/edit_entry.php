<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Eintrag holen
$stmt = $pdo->prepare("SELECT * FROM eintraege WHERE id = :id AND user_id = :uid");
$stmt->execute(['id' => $id, 'uid' => $user_id]);
$eintrag = $stmt->fetch();

if (!$eintrag) {
    die("Zugriff verweigert.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE eintraege SET titel = :titel, inhalt = :inhalt WHERE id = :id AND user_id = :uid");
    $stmt->execute([
        'titel' => htmlspecialchars($_POST['titel']),
        'inhalt' => htmlspecialchars($_POST['inhalt']),
        'id' => $id,
        'uid' => $user_id
    ]);
    header("Location: entries.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Eintrag bearbeiten</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
<div class="form-container">
    <h2>Eintrag bearbeiten</h2>
    <form method="post">
        <label>Titel</label>
        <input type="text" name="titel" value="<?= htmlspecialchars($eintrag['titel']) ?>" required>
        <label>Inhalt</label>
        <textarea name="inhalt" required><?= htmlspecialchars($eintrag['inhalt']) ?></textarea>
        <button type="submit">Speichern</button>
    </form>
</div>
</body>
</html>
