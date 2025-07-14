<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT image FROM posts WHERE post_id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if ($post && $post['image']) {
    $imagePath = "../assets/uploads/" . $post['image'];
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

$stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = ?");
$stmt->execute([$id]);

header('Location: dashboard.php');
?>
