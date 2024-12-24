<?php
session_start();
function getConnection()
{
    $conn = new mysqli('localhost', 'root', '', 'todo_db');
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'error' => 'Database connection failed']));
    }
    return $conn;
}
$conn=getConnection();

//Check connection

if($conn->connect_error)
{
    die('Database connection failed: '. $conn->connect_error);
}

if ($_SERVER ['REQUEST_METHOD'] == 'POST')
{
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        echo "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<!-- Main Wrapper -->
<div id="main-container">
    <!-- Login Form -->
    <div id="container">
        <h1>Login</h1>

        <?php
        // Display error for invalid login if any
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($username)) {
            echo "<p style='color: red; text-align: center;'>Invalid username or password.</p>";
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input id="username" type="text" name="username" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit">Login</button>
            <p style="margin-top: 10px; text-align: center;">
                Don't have an account? <a href="user_register.php">Register here</a>
            </p>
        </form>
    </div>
</div>

<!-- Waves (Dynamic Background) -->
<div class="waves">
    <svg viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,218.7C384,213,480,171,576,154.7C672,139,768,149,864,176C960,203,1056,245,1152,245.3C1248,245,1344,203,1392,181.3L1440,160L1440,320L0,320Z"></path>
    </svg>
</div>
</body>
<style>
    /* Form Styling */
    form {
        display: flex; /* Enable flexbox layout */
        flex-direction: column; /* Stack items vertically */
        align-items: stretch; /* Ensure inputs and buttons take full width */
        gap: 15px; /* Adds uniform spacing between elements */
        margin-bottom: 20px; /* Optional - space between form and footer area */
    }

    /* Input Fields (Username & Password) */
    input[type="text"],
    input[type="password"] {
        width: 100%; /* Ensures input fields are full width */
        padding: 12px;
        margin: 0; /* Clears any unintended margin */
        background-color: #f9f7fc; /* Subtle off-white pastel */
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
    }

    /* Labels */
    label {
        margin-bottom: 5px; /* Space between label and input field */
        font-size: 0.95rem;
        color: #4a6976; /* Muted blue-gray font color */
        font-weight: bold;
    }

    /* Buttons */
    button {
        padding: 12px;
        margin: 0; /* Removes any default spacing around the button */
        background: #92d9d4; /* Pastel teal for buttons */
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #7ccfbd; /* Slightly darker pastel teal for hover */
    }

    /* Register Link */
    p a {
        display: block; /* Force the "Register here" link to appear on a new line */
        margin: 0 auto; /* Center the link within the form container */
        text-align: center;
        font-weight: bold;
        color: #4a6976; /* Muted blue-gray font color */
        text-decoration: none;
    }

    p a:hover {
        color: #92d9d4; /* Change to teal on hover */
        text-decoration: underline;
    }
</style>
</html>

