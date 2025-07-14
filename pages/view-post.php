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

// Fetch categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

// Fetch posts
$sql = "SELECT posts.*, categories.name as category_name
        FROM posts
        LEFT JOIN categories ON posts.category_id = categories.category_id
        ORDER BY post_id DESC";

$posts = $pdo->query($sql)->fetchAll();
?>
<link rel="stylesheet" href="../assets/css/style.css">
<div class="main-content">
  <div class="blog-container">

    <!-- LEFT COLUMN -->
    <div class="blog-posts">
      
      <!-- Category Search Dropdown -->
      <select id="categorySearch" class="search-select">
        <option value="all">All Categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= htmlspecialchars($cat['name']) ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
      </select>

      <?php foreach ($posts as $post): ?>
        <div class="blog-card" data-category="<?= htmlspecialchars($post['category_name']) ?>">
          
          <?php if ($post['image']): ?>
            <div class="blog-image">
              <img src="../assets/uploads/<?= htmlspecialchars($post['image']) ?>" alt="">
            </div>
          <?php endif; ?>

          <div class="blog-content">
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><?= htmlspecialchars(substr($post['description'], 0, 150)) ?>...</p>

            <a href="post-detail.php?id=<?= $post['post_id'] ?>" class="btn">
              Continue Reading
            </a>

            <div class="meta">
              <span>👤 admin</span>
              <span>📅 <?= date("d-M-Y", strtotime($post['created_at'] ?? 'now')) ?></span>
              <span>🏷 <?= htmlspecialchars($post['category_name'] ?? 'Uncategorized') ?></span>
            </div>
          </div>
          
        </div>
      <?php endforeach; ?>
    </div>

    <!-- RIGHT SIDEBAR -->
    <div class="sidebar-right">
      <div class="widget">
        <h4>Categories</h4>
        <ul>
          <?php foreach ($categories as $cat): ?>
            <li><?= htmlspecialchars($cat['name']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      
      <div class="widget">
        <h4>Recent Posts</h4>
        <ul>
          <?php foreach (array_slice($posts, 0, 5) as $post): ?>
            <li><?= htmlspecialchars($post['title']) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="../assets/js/script.js"></script>
