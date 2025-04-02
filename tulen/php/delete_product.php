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

// Delete user's product only
$stmt = $pdo->prepare("DELETE FROM products WHERE id = :id AND user_id = :uid");
$stmt->execute(['id' => $id, 'uid' => $user_id]);

header("Location: products.php");
exit;
?>
