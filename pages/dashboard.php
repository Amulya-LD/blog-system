<<?php
require_once 'header.php';
require_once '../db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$posts = $pdo->query("SELECT posts.*, categories.name as category_name 
                      FROM posts 
                      LEFT JOIN categories ON posts.category_id = categories.category_id")->fetchAll();
?>



<div class="main-content">
    <h2>Welcome, blog system</h2><br>



    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Image</th>
                <th>Video</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post): ?>
                <tr class="post" data-category="<?= $post['category_id'] ?>">
                    <td><?= htmlspecialchars($post['title']) ?></td>
                    <td><?= htmlspecialchars($post['category_name']) ?></td>
                    <td>
                        <?php if ($post['image']): ?>
                            <img src="../assets/uploads/<?= htmlspecialchars($post['image']) ?>" width="100">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($post['video_url']): ?>
                            <iframe width="200" height="150" src="<?= htmlspecialchars($post['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="edit-post.php?id=<?= $post['post_id'] ?>" class="btn">Edit</a>
                        <a href="delete-post.php?id=<?= $post['post_id'] ?>" class="btn btn-delete">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
