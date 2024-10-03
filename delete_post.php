<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login in.php");
    exit();
}

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Delete the post from the database
    $sql = "DELETE FROM blog_posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        header("Location: manage_posts.php");
        exit();
    } else {
        $error = "Failed to delete post. Please try again.";
    }
} else {
    header("Location: manage_posts.php");
    exit();
}
?>
