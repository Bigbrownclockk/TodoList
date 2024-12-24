<?php
// add_task.php
session_start();
function getConnection()
{
    $conn = new mysqli('localhost', 'root', '', 'todo_db');
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'error' => 'Database connection failed']));
    }
    return $conn;
}
// Database connection

$conn = getConnection();

// Check connection

// Get the JSON data from the request

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$task = $conn->real_escape_string($data['task']);

$sql = "INSERT INTO tasks (task, user_id, completed) VALUES ('$task', $user_id, 0)";if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'id' => $conn->insert_id]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
$conn->close();