<?php
// Database configuration
$host = 'localhost'; // Database host
$user = 'root';      // Database username (default for XAMPP)
$password = '';      // Database password (leave empty if no password is set)
$database = 'blog_platform'; // Name of your database

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
