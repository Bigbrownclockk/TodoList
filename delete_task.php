<?php

// delete_task.php


// Database connection
function getConnection()
{
    $conn = new mysqli('localhost', 'root', '', 'todo_db');
    if ($conn->connect_error) {
        die(json_encode(['success' => false, 'error' => 'Database connection failed']));
    }
    return $conn;
}
$conn = getConnection();

// Get the JSON data from the request

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);
$id = (int)$data['id'];

$sql = "DELETE FROM tasks WHERE id = $id AND user_id = $user_id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
$conn->close();
