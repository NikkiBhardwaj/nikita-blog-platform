<?php
require 'config.php';

$search_query = "";

// If the search form is submitted
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// SQL query to fetch all published posts or filter by the search query
$sql = "SELECT * FROM blog_posts WHERE status = 'published'";

// Search functionality
if (!empty($search_query)) {
    $sql .= " AND (title LIKE ? OR content LIKE ? OR tags LIKE ?)";
}

$stmt = $conn->prepare($sql);

if (!empty($search_query)) {
    $like_search_query = '%' . $search_query . '%';
    $stmt->bind_param("sss", $like_search_query, $like_search_query, $like_search_query);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Blog</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .post {
            margin-bottom: 40px;
        }

        .post h2 {
            color: #007BFF;
        }

        .post p {
            color: #555;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
        }

        .search-bar input {
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 10px 20px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        .tags {
            color: #007BFF;
        }

        .no-results {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blog Posts</h1>

        <!-- Search Form -->
        <form class="search-bar" method="GET" action="public_blog.php">
            <input type="text" name="search" placeholder="Search by title, content, or tags" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Blog Posts -->
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo htmlspecialchars(substr($row['content'], 0, 200)); ?>...</p>
                    <p class="tags"><strong>Tags:</strong> <?php echo htmlspecialchars($row['tags']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results">No posts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
