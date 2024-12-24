<?php

session_start();
$conn = new mysqli('localhost', 'root', '', 'todo_db');

if ($conn->connect_error) {
    echo json_encode(['valid' => false, 'message' => 'Database connection error.']);
    exit;
}

// Check if field and value exist in request
if (isset($_GET['field']) && isset($_GET['value'])) {
    $field = $_GET['field'];
    $value = $conn->real_escape_string($_GET['value']);

    // Validate field values
    if ($field === 'username') {
        $query = $conn->query("SELECT id FROM users WHERE username = '$value'");
        if ($query->num_rows > 0) {
            echo json_encode(['valid' => false, 'message' => 'Username already taken.']);
        } else {
            echo json_encode(['valid' => true]);
        }
    } elseif ($field === 'email') {
        $query = $conn->query("SELECT id FROM users WHERE email = '$value'");
        if ($query->num_rows > 0) {
            echo json_encode(['valid' => false, 'message' => 'Email already registered.']);
        } else {
            echo json_encode(['valid' => true]);
        }
    } else {
        echo json_encode(['valid' => false, 'message' => 'Invalid field.']);
    }
} else {
    echo json_encode(['valid' => false, 'message' => 'Invalid request.']);
}
