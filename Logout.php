<?php
// logout.php
session_start();
if (isset($_SESSION['user_id'])) {
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    $message = "You have been logged out successfully.";
} else {
    $message = "You are not logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .form_container {
            width: 90%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 20px;
            color: #555;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 480px) {
            .form_container {
                width: 100%;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form_container">
        <h2>Logout</h2>
        <p><?php echo $message; ?></p>
        <a href="Login in.php"><button>Login Again</button></a>
        <a href="index.php"><button>Go to Homepage</button></a>
    </div>
</body>
</html>
