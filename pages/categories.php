<?php
require_once 'header.php';
require_once '../db.php';

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    header('Location: categories.php');
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>


<div class="main-content">
  <div class="content-wrapper">
    <h2>Manage Categories</h2>
    <form method="post">
        <input type="text" name="name" placeholder="New Category Name" required>
        <button type="submit" name="add">Add</button>
    </form>
    <ul>
        <?php foreach ($categories as $cat): ?>
            <li><?= htmlspecialchars($cat['name']) ?></li>
        <?php endforeach; ?>
    </ul>
    
</div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>

