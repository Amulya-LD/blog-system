<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Blog System</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <header>
    <h1>Blog System</h1>
    <button class="menu-toggle">&#9776;</button>
  </header>

  <nav class="sidebar">
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="add-post.php">Add Post</a></li>
      <li><a href="categories.php">Categories</a></li>
      <li><a href="view-post.php">View Blog</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
