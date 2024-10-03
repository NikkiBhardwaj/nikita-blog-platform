<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login in.php");
    exit();
}

// Fetch all posts by all users
$sql = "SELECT bp.id, bp.title, bp.content, bp.status, u.username 
        FROM blog_posts bp 
        JOIN users u ON bp.user_id = u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f9f9f9;
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

        @media (max-width: 768px) {
            .dashboard_container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .main_content {
                padding: 10px;
            }
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
            <h2>Manage Posts</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['content'], 0, 100)); ?>...</td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars(ucfirst($row['status'])); ?></td>
                        <td>
                            <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <a href="Logout.php" class="logout">Logout</a>
        </div>
    </div>
</body>
</html>
