<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags']; // New tags field

    // Validate that both title and content are provided
    if (empty($title) || empty($content) || empty($tags)) {
        $error = "Title, content, and tags cannot be empty.";
    } else {
        // Update the post in the database
        $sql = "UPDATE blog_posts SET title = ?, content = ?, tags = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $tags, $post_id);

        if ($stmt->execute()) {
            header("Location: manage_posts.php");
            exit();
        } else {
            $error = "Failed to update post. Please try again.";
        }
    }
}

// Fetch the existing post data
$post_id = $_GET['id'];
$sql = "SELECT * FROM blog_posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    header("Location: manage_posts.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Add your existing styles here */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .dashboard_container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #3a3f47;
            padding: 20px;
            color: white;
            min-height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            display: block;
            color: #cfd8dc;
            text-decoration: none;
            padding: 10px;
            margin: 5px 0;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: #575c63;
        }

        .main_content {
            flex-grow: 1;
            padding: 20px;
            background-color: white;
            min-height: 100vh;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .form_container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .logout {
            margin-top: 30px;
            display: inline-block;
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .logout:hover {
            background-color: #c82333;
        }
    </style>
    <script>
        // Auto-Save Draft Function
        let autoSaveInterval;

        function autoSaveDraft() {
            const title = document.querySelector('input[name="title"]').value;
            const content = document.querySelector('textarea[name="content"]').value;
            const post_id = document.querySelector('input[name="post_id"]').value;
            const tags = document.querySelector('input[name="tags"]').value;

            if (title !== "" || content !== "" || tags !== "") {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'autosave_draft.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Draft auto-saved.");
                    }
                };
                xhr.send("post_id=" + post_id + "&title=" + encodeURIComponent(title) + "&content=" + encodeURIComponent(content) + "&tags=" + encodeURIComponent(tags));
            }
        }

        // Set up auto-save interval
        document.addEventListener('DOMContentLoaded', function() {
            autoSaveInterval = setInterval(autoSaveDraft, 5000); // Auto-save every 5 seconds
        });

        // Auto-save when user becomes inactive
        let isTyping = false;
        document.addEventListener('keypress', () => {
            isTyping = true;
            clearTimeout(autoSaveInterval);
        });

        document.addEventListener('mousemove', () => {
            if (!isTyping) {
                autoSaveInterval = setTimeout(autoSaveDraft, 5000); // Auto-save after inactivity
            }
            isTyping = false;
        });
    </script>
</head>
<body>
    <div class="dashboard_container">
        <div class="sidebar">
            <h2>EGATOR</h2>
            <a href="add_post.php">Add Post</a>
            <a href="manage_posts.php">Manage Posts</a>
        </div>
        <div class="main_content">
            <h2>Edit Post</h2>
            <div class="form_container">
                <form action="" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    <textarea name="content" rows="10" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    <input type="text" name="tags" value="<?php echo htmlspecialchars($post['tags']); ?>" placeholder="Enter tags (comma-separated)" required>
                    <button type="submit">Update Post</button>
                </form>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            </div>
            <a href="Logout.php" class="logout">Logout</a>
        </div>
    </div>
</body>
</html>
