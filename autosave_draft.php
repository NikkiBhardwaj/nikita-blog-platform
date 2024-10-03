<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    echo "Session expired. Please log in again.";
    exit();
}

// Check if request is coming via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    // If the post ID is provided, update the draft, otherwise create a new draft
    if (!empty($post_id)) {
        // Update existing draft
        $sql = "UPDATE blog_posts SET title = ?, content = ?, is_draft = 1 WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);
    } else {
        // Insert a new draft
        $sql = "INSERT INTO blog_posts (title, content, user_id, is_draft) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $user_id);
    }

    if ($stmt->execute()) {
        echo "Draft saved successfully.";
    } else {
        echo "Failed to save draft.";
    }
} else {
    echo "Invalid request.";
}
?>
