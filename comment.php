<?php
include "db.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = (int) $_POST['post_id'];
    $commenter = $conn->real_escape_string($_POST['commenter']);
    $comment = $conn->real_escape_string($_POST['comment']);

    $sql = "INSERT INTO comments (post_id, commenter, comment) VALUES ($post_id, '$commenter', '$comment')";
    if ($conn->query($sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo " Error: " . $conn->error;
    }
}
?>

