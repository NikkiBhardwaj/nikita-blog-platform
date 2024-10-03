<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login in.php");
    exit();
}

// Fetch posts by the user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM blog_posts WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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

        .logo {
            max-width: 150px; /* Adjust as needed */
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 30px;
            color: #555;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        h4 {
            margin: 0;
            color: #333;
        }

        p {
            color: #666;
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

        /* Responsive Styles */
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
        .nav_logo {
    color: #fff;
    font-size: 24px;
    text-decoration: none;
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
        <a href="#" class="nav_logo">Logo</a>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <h3>Your Blog Posts</h3>
            <ul>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                        <p><?php echo htmlspecialchars(substr($row['content'], 0, 100)); ?>...</p>
                        <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_post.php?id=<?php echo $row['id']; ?>">Delete</a>
                    </li>
                <?php endwhile; ?>
            </ul>
            <a href="Logout.php" class="logout">Logout</a>
        </div>
    </div>
</body>
</html>
