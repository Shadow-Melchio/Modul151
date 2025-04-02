<?php
require_once 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("DELETE FROM eintraege WHERE id = :id AND user_id = :uid");
$stmt->execute(['id' => $id, 'uid' => $user_id]);

header("Location: entries.php");
exit;
?>
