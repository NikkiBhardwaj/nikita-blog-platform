<?php
session_start();
require 'config.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: Login in.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    $user_id = $_SESSION['user_id'];

    if ($_POST['action'] === 'save_draft') {
        // Insert the draft into the database
        $sql = "INSERT INTO blog_posts (title, content, user_id, status) VALUES (?, ?, ?, 'draft')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $user_id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save draft.']);
            exit();
        }
    } elseif ($_POST['action'] === 'publish_post') {
        // Validate title and content before publishing
        if (empty($title) || empty($content)) {
            $error = "Both title and content are required.";
        } else {
            // Insert the post into the database
            $sql = "INSERT INTO blog_posts (title, content, user_id, status) VALUES (?, ?, ?, 'published')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $title, $content, $user_id);
        
            if ($stmt->execute()) {
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Failed to add post. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
</head>
<body>
    <div class="dashboard_container">
        <div class="sidebar">
            <h2>EGATOR</h2>
            <a href="add_post.php">Add Post</a>
            <a href="manage_posts.php">Manage Posts</a>
        </div>
        <div class="main_content">
            <h2>Add New Post</h2>
            <div class="form_container">
                <form id="postForm" action="" method="POST">
                    <input type="text" id="title" name="title" placeholder="Post Title" required>
                    <textarea id="content" name="content" placeholder="Post Content" rows="5" required></textarea>
                    <button type="button" onclick="saveDraft()">Save as Draft</button>
                    <button type="submit" name="action" value="publish_post">Publish Post</button>
                </form>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
            </div>
            <a href="Logout.php" class="logout">Logout</a>
        </div>
    </div>

    <script>
        function saveDraft() {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;

            const formData = new FormData();
            formData.append('action', 'save_draft');
            formData.append('title', title);
            formData.append('content', content);

            fetch('add_post.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Draft saved successfully!');
                } else {
                    alert('Error saving draft: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Auto-save feature
        let autoSaveInterval = setInterval(() => {
            if (document.getElementById('title').value || document.getElementById('content').value) {
                saveDraft();
            }
        }, 30000); // Auto-save every 30 seconds

        // Clear auto-save interval when user is inactive
        document.addEventListener('mousemove', resetAutoSave);
        document.addEventListener('keypress', resetAutoSave);

        function resetAutoSave() {
            clearInterval(autoSaveInterval);
            autoSaveInterval = setInterval(() => {
                if (document.getElementById('title').value || document.getElementById('content').value) {
                    saveDraft();
                }
            }, 30000);
        }
    </script>
</body>
</html>
