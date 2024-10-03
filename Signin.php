<?php
require 'config.php'; // MySQL connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: Login in.php");
        exit();
    } else {
        $error = "Error: Could not sign up.";
    }
}
?>

<!-- HTML for Sign-Up Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .form_group {
            margin-bottom: 15px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }

        .submit_button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .submit_button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .redirect {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .redirect a {
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s;
        }

        .redirect a:hover {
            color: #0056b3;
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
        <h2>Sign Up</h2>
        <form action="Signin.php" method="POST">
            <div class="form_group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form_group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form_group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="submit_button">Sign Up</button>
        </form>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <p class="redirect">Already have an account? <a href="Login in.php">Login here</a></p>
    </div>
</body>
</html>
