<?php
require_once 'header.php';
require_once '../db.php';

function embedYouTube($url) {
    if (strpos($url, "youtube.com/watch?v=") !== false) {
        $videoId = explode("v=", $url)[1];
        $videoId = explode("&", $videoId)[0];
        return "https://www.youtube.com/embed/" . $videoId;
    }
    return $url;
}

if (!isset($_GET['id'])) {
    echo "Post not found.";
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT posts.*, categories.name as category_name
                       FROM posts
                       LEFT JOIN categories ON posts.category_id = categories.category_id
                       WHERE post_id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    echo "Post not found.";
    exit;
}
?>
<link rel="stylesheet" href="../assets/css/style.css">
<div class="main-content">
    <div class="content-wrapper">
        <h2><?= htmlspecialchars($post['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($post['description'])) ?></p>

        <?php if ($post['image']): ?>
            <img src="../assets/uploads/<?= htmlspecialchars($post['image']) ?>" width="400" style="margin-top:20px;">
        <?php endif; ?>

        <?php if ($post['video_url']): ?>
            <div class="video-wrapper" style="margin-top:20px;">
                <iframe width="600" height="350"
                        src="<?= embedYouTube($post['video_url']) ?>"
                        frameborder="0" allowfullscreen></iframe>
            </div>
        <?php endif; ?>

        <p style="margin-top:20px;">
            <strong>Category:</strong> <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?>
        </p>
    </div>
</div>

<script src="../assets/js/script.js"></script>
