<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once '../db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE post_id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

if (!$post) {
    die("Post not found!");
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $cat_id = $_POST['category_id'];
    $video_url = $_POST['video_url'];

    $imageName = $post['image'];
    if (!empty($_FILES['image']['name'])) {
        $imageName = uniqid() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../assets/uploads/" . $imageName);
    }

    $stmt = $pdo->prepare("UPDATE posts SET title=?, description=?, image=?, video_url=?, category_id=? WHERE post_id=?");
    $stmt->execute([$title, $desc, $imageName, $video_url, $cat_id, $id]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="main-content">
  <div class="content-wrapper">
    <h2>Edit Post</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br>
        <textarea name="description" required><?= htmlspecialchars($post['description']) ?></textarea><br>
        <select name="category_id" required>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $post['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Change Image (optional):</label><br>
        <input type="file" name="image"><br>
        <?php if ($post['image']): ?>
            <img src="../assets/uploads/<?= $post['image'] ?>" width="120"><br>
        <?php endif; ?>
        <input type="text" name="video_url" value="<?= htmlspecialchars($post['video_url']) ?>" placeholder="YouTube embed URL"><br>
        <button type="submit" name="update">Update</button>
       
    </form>
</div>
</div>
</body>
</html>
