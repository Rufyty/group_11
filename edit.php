<?php
include("db.php");

$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_POST["author"];
    $conn->query("UPDATE posts SET title='$title', content='$content', author='$author' WHERE id=$id");
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM posts WHERE id=$id");
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Post</h1>
    <form method="post">
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
        <textarea name="content" rows="4" required><?= htmlspecialchars($post['content']) ?></textarea>
        <input type="text" name="author" value="<?= htmlspecialchars($post['author']) ?>" required>
        <input type="submit" value="Update Post">
    </form>
</div>
</body>
</html>
