<?php
session_start(); // ✅ Needed to remember the author
include("db.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add new post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"])) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_POST["author"];

    $_SESSION['current_author'] = $author; // ✅ Store author name in session

    $conn->query("INSERT INTO posts (title, content, author) VALUES ('$title', '$content', '$author')");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>My Blog</h1>

    <form method="post" action="">
        <input type="text" name="title" placeholder="Post title" required>
        <textarea name="content" placeholder="Post content" rows="6" required></textarea>
        <input type="text" name="author" placeholder="Author name" required>
        <input type="submit" value="Post">
    </form>

    <?php
    //show blog
    $result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
    while ($row = $result->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
        echo "<div class='meta'>By " . htmlspecialchars($row['author']) . " on " . $row['created_at'] . "</div>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";

        // ✅ Show Edit/Delete only if the session author matches post author
        if (isset($_SESSION['current_author']) && $_SESSION['current_author'] === $row['author']) {
            echo "<div class='actions'>
                    <a href='edit.php?id=" . $row['id'] . "'>Edit Post</a>
                    <a href='delete.php?id=" . $row['id'] . "'>Delete</a>
                  </div>";
        }

        // Show comments
        $postId = $row['id'];
        $comments = $conn->query("SELECT * FROM comments WHERE post_id = $postId ORDER BY created_at DESC");
        echo "<div class='comments'>";
        echo "<h4>💬 Comments</h4>";
        
        if ($comments->num_rows > 0) {
            while ($comment = $comments->fetch_assoc()) {
                echo "<div class='comment'>";
                echo "<strong>" . htmlspecialchars($comment['commenter']) . "</strong>: ";
                echo "<span>" . nl2br(htmlspecialchars($comment['comment'])) . "</span>";
                echo "<div class='meta' style='font-size: small; color: gray;'>" . $comment['created_at'] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p style='color: gray;'>No comments yet. Be the first to comment!</p>";
        }

        // Comment form
       echo "<form method='post' action='comment.php' class='comment-form'>
                <input type='hidden' name='post_id' value='$postId'>
                <input type='text' name='commenter' placeholder='Your name' required>
                <textarea name='comment' placeholder='Write a comment...' required></textarea>
                <input type='submit' value='Comment'>
              </form>";
        echo "</div></div>";
    }
    ?>
</div>
</body>
<footer style="text-align:center; margin-top: 40px; font-size: 0.9em;">
    &copy; <?= date("Y") ?> Group 11 CYB. All rights reserved.
</footer>
</html>
