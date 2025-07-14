<?php
require_once 'db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$posts = $pdo->query("SELECT posts.*, categories.name as category_name 
                      FROM posts 
                      LEFT JOIN categories ON posts.category_id = categories.category_id")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>
<body>
<div class="container">
    <h1>My Blog</h1>

    <ul id="categoryList">
        <li data-category="all" class="category-item active">All</li>
        <?php foreach ($categories as $cat): ?>
            <li data-category="<?= $cat['category_id'] ?>" class="category-item"><?= htmlspecialchars($cat['name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <div id="postContainer">
        <?php foreach ($posts as $post): ?>
            <div class="post" data-category="<?= $post['category_id'] ?>">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p><?= htmlspecialchars($post['description']) ?></p>
                <?php if ($post['image']): ?>
                    <img src="assets/uploads/<?= htmlspecialchars($post['image']) ?>" width="300" />
                <?php endif; ?>
                <?php if ($post['video_url']): ?>
                    <iframe width="400" height="300" src="<?= htmlspecialchars($post['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                <?php endif; ?>
                <p><strong>Category:</strong> <?= htmlspecialchars($post['category_name']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
