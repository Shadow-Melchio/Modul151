<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    // Prüfen, ob der angemeldete Nutzer Ersteller des Produkts ist:
    $stmt = $pdo->prepare("SELECT user_id FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product && $product['user_id'] == $_SESSION['user_id']) {
        $delStmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $delStmt->execute([$product_id]);
    }
}
header("Location: dashboard.php");
exit();
?>
