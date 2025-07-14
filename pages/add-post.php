<?php
require_once 'header.php';
require_once '../db.php';

// fetch categories
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $cat_id = $_POST['category_id'];
    $video_url = $_POST['video_url'];

    $imageName = '';
    if (!empty($_FILES['image']['name'])) {
        $imageName = uniqid() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $imageName);
    }

    $stmt = $pdo->prepare("INSERT INTO posts (title, description, image, video_url, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $desc, $imageName, $video_url, $cat_id]);

    header('Location: dashboard.php');
}
?>


<div class="main-content">
  <div class="content-wrapper">
    <h2>Add New Post</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description" required></textarea><br>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <input type="file" name="image"><br>
        <input type="text" name="video_url" placeholder="YouTube embed URL"><br>
        <button type="submit" name="submit">Save</button><br>
       
    </form>
</div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>

