<?php
session_start();

// Establish the database connection
function getConnection()
{
    $conn = new mysqli('localhost', 'root', '', 'todo_db');
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'error' => 'Database connection failed']));
    }
    return $conn;
}

$conn = getConnection();

// Check connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$errors = []; // To store validation errors


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs and fetch POST data
    $username = isset($_POST['username']) ? $conn->real_escape_string($_POST['username']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Reset the errors array at the start of each submission
    $errors = [];

    // Check if the username already exists
    if (!empty($username)) {
        $checkUsername = $conn->query("SELECT id FROM users WHERE username = '$username'");
        if ($checkUsername->num_rows > 0) {
            $errors[] = "The username <strong>'$username'</strong> is already taken. Please choose another one.";
        }
    } else {
        $errors[] = "Username is required.";
    }

    // Check if the email already exists
    if (!empty($email)) {
        $checkEmail = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($checkEmail->num_rows > 0) {
            $errors[] = "The email <strong>'$email'</strong> is already registered. Please use another one.";
        }
    } else {
        $errors[] = "Email is required.";
    }

    // Validate password and password confirmation
    if (!empty($password)) {
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match('/\d/', $password)) {
            $errors[] = "Password must contain at least one number.";
        }
        if (!preg_match('/[@$!%*?&#]/', $password)) {
            $errors[] = "Password must contain at least one special character (@, $, !, %, *, ?, &, or #).";
        }
    } else {
        $errors[] = "Password is required.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // If no errors, proceed to add the user into the database
if (empty($errors)) {
    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and execute the database statement
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "
            <div class='alert alert-success alert-pretty'>
                <h2>🎉 Welcome, $username!</h2>
                <p>Your account has been successfully created. You can now <a href='user_login.php'>login here</a>.</p>
            </div>
        ";
    } else {
        // Handle database-level errors gracefully
        $errors[] = "An error occurred while trying to register your account. Please try again later.";
    }
    $stmt->close();
}}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px; /* Add spacing between inputs */
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            padding: 10px;
            background-color: #f9f7fc; /* Match with index.php inputs */
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        label {
            font-size: 0.95rem;
            color: #4a6976; /* Soft blue-gray */
            font-weight: bold;
        }

        button {
            padding: 12px;
            background: #92d9d4; /* Match index.php button */
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

        form p {
            font-size: 0.9rem;
        }

        form a {
            color: #4a6976; /* Soft blue-gray for links */
            text-decoration: none;
            font-weight: bold;
        }

        form a:hover {
            color: #92d9d4; /* Teal hover color */
            text-decoration: underline;
        }
        /* Alert Styling for Success */
        .alert-pretty {
            padding: 20px;
            background-color: #d8f6eb; /* Light pastel green */
            border: 2px solid #92d9d4; /* Teal border for success */
            border-radius: 12px;
            color: #234f40; /* Deep green text color */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow effect */
            text-align: center; /* Center-align the message */
            animation: fadeInScale 0.5s ease-in-out; /* Subtle fade & scale effect */
        }

        .alert-pretty h2 {
            margin: 0 0 10px; /* Adjust headline spacing */
            font-size: 1.8rem; /* Larger font for the heading */
            color: #136f63; /* Teal shade for headings */
            font-weight: bold;
        }

        .alert-pretty p {
            font-size: 1rem; /* Regular font size for the content */
            color: #34515e; /* Muted text color for content */
        }

        .alert-pretty a {
            text-decoration: none;
            font-weight: bold;
            color: #136f63; /* Teal color for the link */
            transition: color 0.2s ease-in-out;
        }

        .alert-pretty a:hover {
            color: #0b403a; /* Darker teal for hover */
        }

        /* Fade and Scale Animation */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>

</head>

<body>
<!-- Main Wrapper -->
<div id="main-container">
    <!-- Registration Form -->
    <div id="container">
        <h1>Register</h1>


        <form id="registrationForm" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
                <span id="usernameError" style="color: red; font-size: 0.8em;"></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <span id="emailError" style="color: red; font-size: 0.8em;"></span>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span id="passwordError" style="color: red; font-size: 0.8em;"></span>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm your password" required>
                <span id="confirmPasswordError" style="color: red; font-size: 0.8em;"></span>
            </div>

            <button type="submit">Register</button>
            <p style="margin-top: 10px; text-align: center;">Already have an account? <a href="user_login.php">Login</a></p>
        </form>
    </div>
</div>

<!-- Waves (Dynamic Background) -->
<div class="waves">
    <svg viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,218.7C384,213,480,171,576,154.7C672,139,768,149,864,176C960,203,1056,245,1152,245.3C1248,245,1344,203,1392,181.3L1440,160L1440,320L0,320Z"></path>
    </svg>
</div>

<script>
    // DOM Elements
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    const usernameError = document.getElementById('usernameError');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    // Username Validation (AJAX for Availability)
    usernameInput.addEventListener('blur', async () => {
        const username = usernameInput.value.trim();
        if (username === '') {
            usernameError.textContent = 'Username is required.';
            return;
        }

        // Check availability via AJAX
        try {
            const response = await fetch(`validation.php?field=username&value=${username}`);
            const result = await response.json();
            if (!result.valid) {
                usernameError.textContent = result.message;
            } else {
                usernameError.textContent = ''; // Clear the error if valid
            }
        } catch (error) {
            usernameError.textContent = 'Error checking username availability.';
        }
    });

    // Email Validation
    emailInput.addEventListener('blur', () => {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple email regex

        if (email === '') {
            emailError.textContent = 'Email is required.';
        } else if (!emailRegex.test(email)) {
            emailError.textContent = 'Invalid email format.';
        } else {
            emailError.textContent = ''; // Clear the error if valid
        }
    });

    // Password Validation
    passwordInput.addEventListener('input', () => {
        const password = passwordInput.value.trim();
        const errors = [];

        if (password.length < 8) {
            errors.push('At least 8 characters.');
        }
        if (!/[A-Z]/.test(password)) {
            errors.push('One uppercase letter.');
        }
        if (!/[a-z]/.test(password)) {
            errors.push('One lowercase letter.');
        }
        if (!/\d/.test(password)) {
            errors.push('One number.');
        }
        if (!/[@$!%*?&#]/.test(password)) {
            errors.push('One special character (@, $, !, %, *, ?, &, or #).');
        }

        if (errors.length > 0) {
            passwordError.textContent = errors.join(' ');
        } else {
            passwordError.textContent = ''; // Clear error when valid
        }
    });

    // Confirm Password Validation
    confirmPasswordInput.addEventListener('input', () => {
        const confirmPassword = confirmPasswordInput.value.trim();
        const password = passwordInput.value.trim();

        if (confirmPassword === '') {
            confirmPasswordError.textContent = 'Please confirm your password.';
        } else if (confirmPassword !== password) {
            confirmPasswordError.textContent = 'Passwords do not match.';
        } else {
            confirmPasswordError.textContent = ''; // Clear error when passwords match
        }
    });

    // Final Form Validation on Submission
    document.getElementById('registrationForm').addEventListener('submit', (e) => {
        if (
            usernameError.textContent ||
            emailError.textContent ||
            passwordError.textContent ||
            confirmPasswordError.textContent
        ) {
            e.preventDefault(); // Prevent submission if errors exist
            alert('Please fix the errors before submitting the form.');
        }
    });
</script>

</body>

</html>